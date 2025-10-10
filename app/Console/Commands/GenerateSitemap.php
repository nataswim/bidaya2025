<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SitemapService;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Génère le sitemap XML du site';

    protected $sitemapService;

    public function __construct(SitemapService $sitemapService)
    {
        parent::__construct();
        $this->sitemapService = $sitemapService;
    }

    public function handle()
    {
        $this->info('🚀 Génération du sitemap en cours...');

        try {
            // Générer le XML
            $result = $this->sitemapService->generateXml();

            $this->info('✅ Sitemap généré avec succès !');
            $this->table(
                ['Metric', 'Value'],
                [
                    ['URLs incluses', $result['urls_count']],
                    ['Taille du fichier', number_format($result['file_size'] / 1024, 2) . ' KB'],
                    ['Généré le', $result['generated_at']->format('d/m/Y H:i:s')],
                    ['Chemin', $result['file_path']]
                ]
            );

            $this->info('📍 Le sitemap est accessible sur : ' . config('app.url') . '/sitemap.xml');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de la génération : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}