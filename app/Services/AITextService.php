<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AITextService
{
    private $provider;
    private $apiKey;
    private $model;
    private $temperature;
    private $maxTokens;

    public function __construct()
    {
        // Récupérer le provider actuel
        $this->provider = Setting::get('ai_text_provider', config('aitext.api_provider', 'gemini'));
        
        // Récupérer la clé API spécifique au provider
        $this->apiKey = Setting::get('ai_text_api_key_' . $this->provider, '');
        
        $this->model = Setting::get('ai_text_model', config('aitext.model', 'gemini-1.5-flash'));
        $this->temperature = (float) Setting::get('ai_text_temperature', config('aitext.temperature', 0.7));
        $this->maxTokens = (int) Setting::get('ai_text_max_tokens', config('aitext.max_tokens', 1024));
    }

    /**
     * Traiter le texte avec l'IA
     */
    public function processText(string $content, string $actionType, ?string $title = null): array
    {
        try {
            // Validation de la clé API
            if (empty($this->apiKey)) {
                throw new \Exception('Clé API non configurée pour ' . $this->provider . '. Veuillez configurer votre clé API dans les paramètres.');
            }

            $prompt = $this->buildPrompt($content, $actionType, $title);
            
            switch ($this->provider) {
                case 'gemini':
                    return $this->callGemini($prompt);
                case 'groq':
                    return $this->callGroq($prompt);
                case 'openai':
                    return $this->callOpenAI($prompt);
                case 'cohere':
                    return $this->callCohere($prompt);
                case 'huggingface':
                    return $this->callHuggingFace($prompt);
                default:
                    throw new \Exception('Provider non supporté : ' . $this->provider);
            }
        } catch (\Exception $e) {
            Log::error('AI Text Error', [
                'provider' => $this->provider,
                'model' => $this->model,
                'action' => $actionType,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Construire le prompt selon l'action
     */
    private function buildPrompt(string $content, string $actionType, ?string $title): string
    {
        $prompts = [
            'optimize' => "Titre : {$title}\n\nTexte : {$content}\n\nCorrige les fautes, améliore le style et optimise le SEO. IMPORTANT : Formate le texte avec des balises HTML appropriées (<p>, <strong>, <em>, etc.). Renvoie uniquement le texte optimisé en HTML.",
            
            'correct' => "Titre : {$title}\n\nTexte : {$content}\n\nCorrige uniquement les fautes d'orthographe, de grammaire et de syntaxe. IMPORTANT : Conserve la structure originale mais formate avec des balises HTML (<p>, <br>, etc.). Renvoie uniquement le texte corrigé en HTML.",
            
            'enrich' => "Titre : {$title}\n\nTexte : {$content}\n\nEnrichis ce texte en ajoutant des détails pertinents, des exemples et des informations complémentaires. IMPORTANT : Structure le contenu avec des balises HTML (<h3>, <p>, <strong>, <ul>, <li>, etc.) pour une meilleure lisibilité. Renvoie uniquement le texte enrichi en HTML.",
            
            'create_content' => "Titre : {$title}\n\nIdée/Mots-clés : {$content}\n\nCrée un article complet et optimisé SEO basé sur ces informations. IMPORTANT : Structure le contenu avec des balises HTML complètes :\n- Utilisez <h2> et <h3> pour les sous-titres\n- <p> pour les paragraphes\n- <strong> pour les mots importants\n- <ul> et <li> pour les listes\n- <em> pour l'emphase\nRenvoie uniquement l'article structuré en HTML.",
            
            'optimize_title' => "Titre actuel : \"{$content}\"\n\nOptimise ce titre pour le SEO et le rendre plus attractif. Le titre doit être :\n- Accrocheur et vendeur\n- Optimisé pour le référencement\n- Contenir les mots-clés principaux\n- Faire moins de 60 caractères\n- Être en français\n- Attractif pour inciter au clic\n\nRenvoie uniquement le titre optimisé, sans guillemets ni formatage.",
            
            'optimize_slug' => "Titre : \"{$title}\"\n\nCrée un slug URL optimisé pour le SEO basé sur ce titre. Le slug doit être :\n- En minuscules\n- Sans accents ni caractères spéciaux\n- Séparé par des tirets\n- Court mais descriptif (3-5 mots maximum)\n- Contenir les mots-clés principaux\n- Être en français mais formaté pour une URL\n\nExemples : 'guide-nutrition-sportive' ou 'exercices-musculation-debutant'\n\nRenvoie uniquement le slug optimisé, sans guillemets.",
        ];

        return $prompts[$actionType] ?? $prompts['optimize'];
    }

    /**
     * Appel API Google Gemini
     */
    private function callGemini(string $prompt): array
    {
        $url = config('aitext.api_urls.gemini') . "/{$this->model}:generateContent?key={$this->apiKey}";
        
        $response = Http::timeout(60)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => $this->temperature,
                'maxOutputTokens' => $this->maxTokens
            ]
        ]);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $errorBody
            ]);
            throw new \Exception('Erreur Gemini: ' . $response->status() . ' - ' . $errorBody);
        }

        $data = $response->json();
        
        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Réponse Gemini invalide');
        }

        return [
            'success' => true,
            'content' => $data['candidates'][0]['content']['parts'][0]['text']
        ];
    }

    /**
     * Appel API Groq
     */
    private function callGroq(string $prompt): array
    {
        Log::info('Groq API Call', [
            'model' => $this->model,
            'temperature' => $this->temperature,
            'max_tokens' => $this->maxTokens
        ]);

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
            ->post(config('aitext.api_urls.groq'), [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un rédacteur SEO professionnel et expert en création de contenu web français.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => $this->temperature,
                'max_tokens' => $this->maxTokens
            ]);

        if (!$response->successful()) {
            $errorBody = $response->body();
            $errorData = $response->json();
            
            Log::error('Groq API Error', [
                'status' => $response->status(),
                'body' => $errorBody,
                'model' => $this->model,
                'error_data' => $errorData
            ]);

            $errorMessage = 'Erreur Groq ' . $response->status();
            
            if (isset($errorData['error']['message'])) {
                $errorMessage .= ': ' . $errorData['error']['message'];
            } else {
                $errorMessage .= ': ' . $errorBody;
            }

            throw new \Exception($errorMessage);
        }

        $data = $response->json();
        
        if (!isset($data['choices'][0]['message']['content'])) {
            Log::error('Groq Invalid Response', ['response' => $data]);
            throw new \Exception('Réponse Groq invalide');
        }

        return [
            'success' => true,
            'content' => $data['choices'][0]['message']['content']
        ];
    }

    /**
     * Appel API OpenAI
     */
    private function callOpenAI(string $prompt): array
    {
        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
            ->post(config('aitext.api_urls.openai'), [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un rédacteur SEO professionnel et expert en création de contenu web français.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => $this->temperature,
                'max_tokens' => $this->maxTokens
            ]);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('OpenAI API Error', [
                'status' => $response->status(),
                'body' => $errorBody
            ]);
            throw new \Exception('Erreur OpenAI: ' . $response->status() . ' - ' . $errorBody);
        }

        $data = $response->json();
        
        if (!isset($data['choices'][0]['message']['content'])) {
            throw new \Exception('Réponse OpenAI invalide');
        }

        return [
            'success' => true,
            'content' => $data['choices'][0]['message']['content']
        ];
    }

    /**
     * Appel API Cohere
     */
    private function callCohere(string $prompt): array
    {
        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
            ->post(config('aitext.api_urls.cohere'), [
                'model' => $this->model,
                'prompt' => $prompt,
                'temperature' => $this->temperature,
                'max_tokens' => $this->maxTokens
            ]);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('Cohere API Error', [
                'status' => $response->status(),
                'body' => $errorBody
            ]);
            throw new \Exception('Erreur Cohere: ' . $response->status() . ' - ' . $errorBody);
        }

        $data = $response->json();
        
        if (!isset($data['generations'][0]['text'])) {
            throw new \Exception('Réponse Cohere invalide');
        }

        return [
            'success' => true,
            'content' => $data['generations'][0]['text']
        ];
    }

    /**
     * Appel API Hugging Face
     */
    private function callHuggingFace(string $prompt): array
    {
        $url = config('aitext.api_urls.huggingface') . '/' . $this->model;
        
        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])
            ->post($url, [
                'inputs' => $prompt,
                'parameters' => [
                    'temperature' => $this->temperature,
                    'max_new_tokens' => $this->maxTokens,
                    'return_full_text' => false
                ]
            ]);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('Hugging Face API Error', [
                'status' => $response->status(),
                'body' => $errorBody
            ]);
            throw new \Exception('Erreur Hugging Face: ' . $response->status() . ' - ' . $errorBody);
        }

        $data = $response->json();
        
        if (!isset($data[0]['generated_text'])) {
            throw new \Exception('Réponse Hugging Face invalide');
        }

        return [
            'success' => true,
            'content' => $data[0]['generated_text']
        ];
    }

    /**
     * Tester la connexion API
     */
    public function testConnection(): array
    {
        try {
            $result = $this->processText(
                'Bonjour',
                'correct',
                'Test'
            );

            return [
                'success' => true,
                'provider' => $this->provider,
                'model' => $this->model,
                'message' => 'Connexion API réussie !',
                'response' => $result['content'] ?? ''
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}