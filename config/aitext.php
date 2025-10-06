<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Text Optimizer Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'optimisation de texte par IA
    | Support : Gemini, Groq, OpenAI, Cohere, Hugging Face
    |
    */

    'api_provider' => env('AI_TEXT_API_PROVIDER', 'gemini'),
    'api_key' => env('AI_TEXT_API_KEY', ''),
    'model' => env('AI_TEXT_MODEL', 'gemini-1.5-flash'),
    'temperature' => env('AI_TEXT_TEMPERATURE', 0.7),
    'max_tokens' => env('AI_TEXT_MAX_TOKENS', 1024),

    /*
    |--------------------------------------------------------------------------
    | Modèles disponibles par provider - MISE À JOUR OCTOBRE 2025
    |--------------------------------------------------------------------------
    */
    'models' => [
        'gemini' => [
            'gemini-1.5-flash' => 'Gemini 1.5 Flash (Recommandé)',
            'gemini-1.5-pro' => 'Gemini 1.5 Pro (Plus intelligent)',
            'gemini-1.0-pro' => 'Gemini 1.0 Pro',
        ],
        'groq' => [
            // PRODUCTION - Modèles stables et recommandés
            'llama-3.3-70b-versatile' => '⭐ Llama 3.3 70B Versatile (Recommandé)',
            'llama-3.1-8b-instant' => '⚡ Llama 3.1 8B Instant (Ultra rapide)',
            'gemma2-9b-it' => 'Gemma 2 9B (Équilibré)',
            
            // PREVIEW - Modèles expérimentaux (ne pas utiliser en production)
            'deepseek-r1-distill-llama-70b' => '🧪 DeepSeek R1 70B (Preview)',
            'qwen/qwen3-32b' => '🧪 Qwen 3 32B (Preview)',
            'moonshotai/kimi-k2-instruct' => '🧪 Kimi K2 (Preview)',
        ],
        'openai' => [
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo (Recommandé)',
            'gpt-4' => 'GPT-4',
            'gpt-4-turbo' => 'GPT-4 Turbo',
        ],
        'cohere' => [
            'command' => 'Command (Recommandé)',
            'command-light' => 'Command Light (Plus rapide)',
        ],
        'huggingface' => [
            'microsoft/DialoGPT-medium' => 'DialoGPT Medium',
            'microsoft/DialoGPT-large' => 'DialoGPT Large',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | URLs API
    |--------------------------------------------------------------------------
    */
    'api_urls' => [
        'gemini' => 'https://generativelanguage.googleapis.com/v1/models',
        'groq' => 'https://api.groq.com/openai/v1/chat/completions',
        'openai' => 'https://api.openai.com/v1/chat/completions',
        'cohere' => 'https://api.cohere.ai/v1/generate',
        'huggingface' => 'https://api-inference.huggingface.co/models',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    'admin_only' => true, // Seuls les admins peuvent utiliser l'IA
];