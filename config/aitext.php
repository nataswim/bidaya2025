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
    | Modèles disponibles par provider
    |--------------------------------------------------------------------------
    */
    'models' => [
        'gemini' => [
            'gemini-1.5-flash' => 'Gemini 1.5 Flash (Recommandé)',
            'gemini-1.5-pro' => 'Gemini 1.5 Pro (Plus intelligent)',
            'gemini-1.0-pro' => 'Gemini 1.0 Pro',
        ],
        'groq' => [
            'llama3-8b-8192' => 'Llama 3 8B (Rapide)',
            'llama3-70b-8192' => 'Llama 3 70B (Plus intelligent)',
            'mixtral-8x7b-32768' => 'Mixtral 8x7B',
            'gemma-7b-it' => 'Gemma 7B',
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