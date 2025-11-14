<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExploreDataEsCommand extends Command
{
    protected $signature = 'explore:dataes';
    protected $description = 'Explorer la structure de l\'API Data ES';

    public function handle(): int
    {
        $this->info('🔍 Exploration de l\'API Data ES...');
        
        // Appel sans filtres pour voir la structure
        $url = 'https://equipements.sports.gouv.fr/api/explore/v2.1/catalog/datasets/data-es/records';
        
        $this->info("URL: {$url}");
        
        try {
            $response = Http::timeout(30)->get($url, ['limit' => 1]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                $this->info('✅ Succès !');
                $this->line('');
                $this->line('Structure complète :');
                $this->line(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                
                if (isset($data['results'][0]['fields'])) {
                    $this->line('');
                    $this->info('📋 Liste des champs disponibles :');
                    foreach (array_keys($data['results'][0]['fields']) as $field) {
                        $this->line("  - {$field}");
                    }
                }
            } else {
                $this->error('❌ Erreur: ' . $response->status());
                $this->line($response->body());
            }
        } catch (\Exception $e) {
            $this->error('❌ Exception: ' . $e->getMessage());
        }
        
        return 0;
    }
}