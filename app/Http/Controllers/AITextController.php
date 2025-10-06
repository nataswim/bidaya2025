<?php

namespace App\Http\Controllers;

use App\Services\AITextService;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AITextController extends Controller
{
    private $aiService;

    public function __construct(AITextService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Vérifier l'accès admin
     */
    private function checkAdminAccess()
    {
        if (!auth()->check()) {
            abort(403, 'Accès non autorisé - Connexion requise');
        }

        $user = auth()->user();
        
        if (!$user->role) {
            abort(403, 'Accès non autorisé - Aucun rôle assigné');
        }

        if (!$user->hasRole('admin')) {
            abort(403, 'Accès non autorisé - Réservé aux administrateurs');
        }
    }

    /**
     * Afficher la page de configuration
     */
    public function settings()
    {
        $this->checkAdminAccess();

        $currentConfig = [
            'provider' => Setting::get('ai_text_provider', 'gemini'),
            'model' => Setting::get('ai_text_model', 'gemini-1.5-flash'),
            'temperature' => Setting::get('ai_text_temperature', '0.7'),
            'max_tokens' => Setting::get('ai_text_max_tokens', '1024'),
            'api_key' => Setting::get('ai_text_api_key', ''),
            'has_api_key' => !empty(Setting::get('ai_text_api_key'))
        ];

        $models = config('aitext.models');

        return view('admin.aitext.settings', compact('currentConfig', 'models'));
    }

    /**
     * Sauvegarder la configuration
     */
    public function saveSettings(Request $request)
    {
        $this->checkAdminAccess();

        $validator = Validator::make($request->all(), [
            'provider' => 'required|in:gemini,groq,openai,cohere,huggingface',
            'model' => 'required|string',
            'api_key' => 'required|string|min:10',
            'temperature' => 'required|numeric|min:0|max:1',
            'max_tokens' => 'required|integer|min:100|max:4096',
        ], [
            'provider.required' => 'Le fournisseur est requis',
            'provider.in' => 'Fournisseur invalide',
            'model.required' => 'Le modèle est requis',
            'api_key.required' => 'La clé API est requise',
            'api_key.min' => 'La clé API doit contenir au moins 10 caractères',
            'temperature.required' => 'La température est requise',
            'temperature.numeric' => 'La température doit être un nombre',
            'temperature.min' => 'La température doit être supérieure ou égale à 0',
            'temperature.max' => 'La température doit être inférieure ou égale à 1',
            'max_tokens.required' => 'Le nombre de tokens est requis',
            'max_tokens.integer' => 'Le nombre de tokens doit être un entier',
            'max_tokens.min' => 'Le nombre de tokens doit être au moins 100',
            'max_tokens.max' => 'Le nombre de tokens ne peut pas dépasser 4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Sauvegarder dans la base de données
        Setting::set('ai_text_provider', $request->input('provider'), 'string', 'aitext');
        Setting::set('ai_text_model', $request->input('model'), 'string', 'aitext');
        Setting::set('ai_text_api_key', $request->input('api_key'), 'string', 'aitext');
        Setting::set('ai_text_temperature', $request->input('temperature'), 'string', 'aitext');
        Setting::set('ai_text_max_tokens', $request->input('max_tokens'), 'string', 'aitext');

        return response()->json([
            'success' => true,
            'message' => 'Configuration sauvegardée avec succès !'
        ]);
    }

    /**
     * Tester la connexion API
     */
    public function testConnection(Request $request)
    {
        $this->checkAdminAccess();

        $result = $this->aiService->testConnection();

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => '✅ Connexion API réussie !',
                'provider' => $result['provider'],
                'model' => $result['model'],
                'response' => $result['response']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '❌ Erreur de connexion',
            'error' => $result['error']
        ], 500);
    }

    /**
     * Traiter le texte avec l'IA
     */
    public function process(Request $request)
    {
        $this->checkAdminAccess();

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'action_type' => 'required|in:optimize,correct,enrich,create_content',
            'title' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->aiService->processText(
            $request->input('content'),
            $request->input('action_type'),
            $request->input('title')
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'content' => $result['content']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 500);
    }

    /**
     * Optimiser un titre
     */
    public function optimizeTitle(Request $request)
    {
        $this->checkAdminAccess();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->aiService->processText(
            $request->input('title'),
            'optimize_title',
            $request->input('title')
        );

        if ($result['success']) {
            $optimizedTitle = trim($result['content']);
            $optimizedTitle = preg_replace('/^["\']|["\']$/', '', $optimizedTitle);
            $optimizedTitle = substr($optimizedTitle, 0, 60);

            return response()->json([
                'success' => true,
                'title' => $optimizedTitle
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 500);
    }

    /**
     * Optimiser un slug
     */
    public function optimizeSlug(Request $request)
    {
        $this->checkAdminAccess();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->aiService->processText(
            $request->input('title'),
            'optimize_slug',
            $request->input('title')
        );

        if ($result['success']) {
            $optimizedSlug = trim($result['content']);
            $optimizedSlug = preg_replace('/^["\']|["\']$/', '', $optimizedSlug);
            $optimizedSlug = strtolower($optimizedSlug);
            
            $optimizedSlug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $optimizedSlug);
            $optimizedSlug = preg_replace('/[^a-z0-9-]/', '', $optimizedSlug);
            $optimizedSlug = preg_replace('/-+/', '-', $optimizedSlug);
            $optimizedSlug = trim($optimizedSlug, '-');

            return response()->json([
                'success' => true,
                'slug' => $optimizedSlug
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 500);
    }
}