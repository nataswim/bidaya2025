<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Récupérer l'ancienne clé API et le provider actuel avant modification
        $currentProvider = DB::table('settings')->where('key', 'ai_text_provider')->value('value') ?? 'gemini';
        $currentApiKey = DB::table('settings')->where('key', 'ai_text_api_key')->value('value') ?? '';
        
        // Supprimer l'ancienne clé générique
        DB::table('settings')->where('key', 'ai_text_api_key')->delete();
        
        // Créer les clés API spécifiques par provider
        $providers = ['gemini', 'groq', 'openai', 'cohere', 'huggingface'];
        $now = now();
        
        foreach ($providers as $provider) {
            // Si c'est le provider actuel, on garde la clé existante
            $apiKey = ($provider === $currentProvider) ? $currentApiKey : '';
            
            DB::table('settings')->insert([
                'key' => "ai_text_api_key_{$provider}",
                'value' => $apiKey,
                'type' => 'string',
                'group' => 'aitext',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Récupérer le provider actuel et sa clé
        $currentProvider = DB::table('settings')->where('key', 'ai_text_provider')->value('value') ?? 'gemini';
        $currentApiKey = DB::table('settings')->where('key', "ai_text_api_key_{$currentProvider}")->value('value') ?? '';
        
        // Supprimer toutes les clés spécifiques
        DB::table('settings')->where('key', 'LIKE', 'ai_text_api_key_%')->delete();
        
        // Recréer la clé générique avec la valeur du provider actuel
        DB::table('settings')->insert([
            'key' => 'ai_text_api_key',
            'value' => $currentApiKey,
            'type' => 'string',
            'group' => 'aitext',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};