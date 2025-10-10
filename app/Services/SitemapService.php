<?php

namespace App\Services;

use App\Models\SitemapUrl;
use App\Models\Post;
use App\Models\Downloadable;
use App\Models\DownloadCategory;
use App\Models\Fiche;
use App\Models\FichesCategory;
use App\Models\Plan;
use App\Models\Exercice;
use App\Models\Workout;
use App\Models\WorkoutSection;
use App\Models\WorkoutCategory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SitemapService
{
    private $baseUrl;
    private $staticRoutes;

    public function __construct()
    {
        $this->baseUrl = config('app.url');
        
        // Routes statiques du site
        $this->staticRoutes = [
            '/' => ['priority' => 1.0, 'changefreq' => 'daily'],
            '/about' => ['priority' => 0.8, 'changefreq' => 'monthly'],
            '/contact' => ['priority' => 0.7, 'changefreq' => 'monthly'],
            '/accessibilite' => ['priority' => 0.3, 'changefreq' => 'yearly'],
            '/cookies' => ['priority' => 0.3, 'changefreq' => 'yearly'],
            '/fonctionnalites' => ['priority' => 0.6, 'changefreq' => 'monthly'],
            '/mentions-legales' => ['priority' => 0.3, 'changefreq' => 'yearly'],
            '/politique-confidentialite' => ['priority' => 0.3, 'changefreq' => 'yearly'],
            '/plans-inscription' => ['priority' => 0.7, 'changefreq' => 'weekly'],
            '/guide-utilisation' => ['priority' => 0.6, 'changefreq' => 'monthly'],
            
            // Index des sections
            '/articles' => ['priority' => 0.9, 'changefreq' => 'daily'],
            '/ebook' => ['priority' => 0.8, 'changefreq' => 'weekly'],
            '/fiches' => ['priority' => 0.8, 'changefreq' => 'weekly'],
            '/exercices' => ['priority' => 0.8, 'changefreq' => 'weekly'],
            '/plans' => ['priority' => 0.8, 'changefreq' => 'weekly'],
            '/workouts' => ['priority' => 0.8, 'changefreq' => 'weekly'],
            '/outils' => ['priority' => 0.8, 'changefreq' => 'monthly'],
        ];
    }

    /**
     * Découvrir toutes les URLs (statiques + dynamiques)
     */
    public function discoverUrls(): array
    {
        $stats = [
            'static' => 0,
            'dynamic' => 0,
            'total' => 0
        ];

        try {
            $stats['static'] = $this->addStaticRoutes();
            $stats['dynamic'] = $this->addDynamicRoutes();
            $stats['total'] = $stats['static'] + $stats['dynamic'];

            Log::info('Sitemap discovery completed', $stats);
        } catch (\Exception $e) {
            Log::error('Sitemap discovery error: ' . $e->getMessage());
            throw $e;
        }

        return $stats;
    }

    /**
     * Ajouter les routes statiques
     */
    private function addStaticRoutes(): int
    {
        $count = 0;

        foreach ($this->staticRoutes as $path => $config) {
            try {
                $url = $this->baseUrl . $path;
                
                SitemapUrl::updateOrCreate(
                    ['url' => $url],
                    [
                        'type' => 'static',
                        'priority' => $config['priority'],
                        'changefreq' => $config['changefreq'],
                        'is_approved' => true, // Auto-approuver les routes statiques
                        'is_active' => true,
                        'last_modified' => now()
                    ]
                );
                
                $count++;
            } catch (\Exception $e) {
                Log::warning("Failed to add static route {$path}: " . $e->getMessage());
            }
        }

        // Ajouter les outils individuels
        $count += $this->addToolsRoutes();

        return $count;
    }

    /**
     * Ajouter les routes des outils
     */
    private function addToolsRoutes(): int
    {
        $count = 0;
        
        $tools = [
            '/outils/calculateur-imc',
            '/outils/calculateur-masse-grasse',
            '/outils/calculateur-calories',
            '/outils/chronometre-natation',
            '/outils/chronometre-pro',
            '/outils/calculateur-vnc',
            '/outils/calculateur-fitness',
            '/outils/coherence-cardiaque',
            '/outils/calculateur-hydratation',
            '/outils/carte-interactive',
            '/outils/convertisseur-kcal-macros',
            '/outils/calculateur-rm-charge-maximale',
            '/outils/planificateur-course-a-pieds',
            '/outils/predicteur-natation',
            '/outils/planificateur-natation',
            '/outils/zones-cardiaques',
            '/outils/calculateur-tdee',
            '/outils/planificateur-triathlon',
            '/outils/efficacite-technique-natation',
        ];

        foreach ($tools as $tool) {
            try {
                SitemapUrl::updateOrCreate(
                    ['url' => $this->baseUrl . $tool],
                    [
                        'type' => 'static',
                        'priority' => 0.6,
                        'changefreq' => 'monthly',
                        'is_approved' => true,
                        'is_active' => true,
                        'last_modified' => now()
                    ]
                );
                $count++;
            } catch (\Exception $e) {
                Log::warning("Failed to add tool route {$tool}: " . $e->getMessage());
            }
        }

        return $count;
    }

    /**
     * Ajouter les routes dynamiques depuis la base de données
     */
    private function addDynamicRoutes(): int
    {
        $count = 0;

        $count += $this->addPostsUrls();
        $count += $this->addDownloadablesUrls();
        $count += $this->addFichesUrls();
        $count += $this->addPlansUrls();
        $count += $this->addExercicesUrls();
        $count += $this->addWorkoutsUrls();

        return $count;
    }

    /**
     * Ajouter les URLs des articles
     */
    private function addPostsUrls(): int
    {
        $count = 0;

        Post::published()
            ->where('visibility', 'public')
            ->chunk(50, function ($posts) use (&$count) {
                foreach ($posts as $post) {
                    try {
                        $url = route('public.show', $post->slug);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'posts',
                                'source_id' => $post->id,
                                'priority' => $post->is_featured ? 0.9 : 0.8,
                                'changefreq' => 'weekly',
                                'is_approved' => false, // Nécessite approbation manuelle
                                'is_active' => true,
                                'last_modified' => $post->updated_at ?? $post->published_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add post {$post->id}: " . $e->getMessage());
                    }
                }
            });

        return $count;
    }

    /**
     * Ajouter les URLs des téléchargements
     */
    private function addDownloadablesUrls(): int
    {
        $count = 0;

        // Catégories de téléchargements
        DownloadCategory::active()
            ->chunk(50, function ($categories) use (&$count) {
                foreach ($categories as $category) {
                    try {
                        $url = route('ebook.category', $category->slug);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'download_categories',
                                'source_id' => $category->id,
                                'priority' => 0.7,
                                'changefreq' => 'weekly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $category->updated_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add download category {$category->id}: " . $e->getMessage());
                    }
                }
            });

        // Téléchargements individuels
        Downloadable::active()
            ->with('category')
            ->chunk(50, function ($downloadables) use (&$count) {
                foreach ($downloadables as $downloadable) {
                    if (!$downloadable->category) continue;
                    
                    try {
                        $url = route('ebook.show', [
                            $downloadable->category->slug,
                            $downloadable->slug
                        ]);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'downloadables',
                                'source_id' => $downloadable->id,
                                'priority' => $downloadable->is_featured ? 0.7 : 0.6,
                                'changefreq' => 'monthly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $downloadable->updated_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add downloadable {$downloadable->id}: " . $e->getMessage());
                    }
                }
            });

        return $count;
    }

    /**
     * Ajouter les URLs des fiches
     */
    private function addFichesUrls(): int
    {
        $count = 0;

        // Catégories de fiches
        FichesCategory::active()
            ->chunk(50, function ($categories) use (&$count) {
                foreach ($categories as $category) {
                    try {
                        $url = route('public.fiches.category', $category->slug);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'fiches_categories',
                                'source_id' => $category->id,
                                'priority' => 0.7,
                                'changefreq' => 'weekly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $category->updated_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add fiches category {$category->id}: " . $e->getMessage());
                    }
                }
            });

        // Fiches individuelles
        Fiche::published()
            ->where('visibility', 'public')
            ->with('category')
            ->chunk(50, function ($fiches) use (&$count) {
                foreach ($fiches as $fiche) {
                    if (!$fiche->category) continue;
                    
                    try {
                        $url = route('public.fiches.show', [
                            $fiche->category->slug,
                            $fiche->slug
                        ]);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'fiches',
                                'source_id' => $fiche->id,
                                'priority' => $fiche->is_featured ? 0.8 : 0.6,
                                'changefreq' => 'monthly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $fiche->updated_at ?? $fiche->published_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add fiche {$fiche->id}: " . $e->getMessage());
                    }
                }
            });

        return $count;
    }

    /**
     * Ajouter les URLs des plans
     */
    private function addPlansUrls(): int
    {
        $count = 0;

        Plan::public()
            ->active()
            ->chunk(50, function ($plans) use (&$count) {
                foreach ($plans as $plan) {
                    try {
                        $url = route('plans.show', $plan->id);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'plans',
                                'source_id' => $plan->id,
                                'priority' => $plan->is_featured ? 0.8 : 0.7,
                                'changefreq' => 'monthly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $plan->updated_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add plan {$plan->id}: " . $e->getMessage());
                    }
                }
            });

        return $count;
    }

    /**
     * Ajouter les URLs des exercices
     */
    private function addExercicesUrls(): int
    {
        $count = 0;

        Exercice::active()
            ->chunk(50, function ($exercices) use (&$count) {
                foreach ($exercices as $exercice) {
                    try {
                        $url = route('exercices.show', $exercice->id);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'exercices',
                                'source_id' => $exercice->id,
                                'priority' => 0.6,
                                'changefreq' => 'monthly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $exercice->updated_at
                            ]
                        );
                        
                        $count++;
                    } catch (\Exception $e) {
                        Log::warning("Failed to add exercice {$exercice->id}: " . $e->getMessage());
                    }
                }
            });

        return $count;
    }

    /**
     * Ajouter les URLs des workouts
     */
    private function addWorkoutsUrls(): int
    {
        $count = 0;

        // Sections de workouts
        WorkoutSection::active()
            ->with('activeCategories.workouts')
            ->chunk(50, function ($sections) use (&$count) {
                foreach ($sections as $section) {
                    try {
                        $url = route('public.workouts.section', $section->slug);
                        
                        SitemapUrl::updateOrCreate(
                            ['url' => $url],
                            [
                                'type' => 'dynamic',
                                'source' => 'workout_sections',
                                'source_id' => $section->id,
                                'priority' => 0.7,
                                'changefreq' => 'weekly',
                                'is_approved' => false,
                                'is_active' => true,
                                'last_modified' => $section->updated_at
                            ]
                        );
                        
                        $count++;

                        // Catégories dans chaque section
                        foreach ($section->activeCategories as $category) {
                            try {
                                $url = route('public.workouts.category', [
                                    $section->slug,
                                    $category->slug
                                ]);
                                
                                SitemapUrl::updateOrCreate(
                                    ['url' => $url],
                                    [
                                        'type' => 'dynamic',
                                        'source' => 'workout_categories',
                                        'source_id' => $category->id,
                                        'priority' => 0.65,
                                        'changefreq' => 'weekly',
                                        'is_approved' => false,
                                        'is_active' => true,
                                        'last_modified' => $category->updated_at
                                    ]
                                );
                                
                                $count++;

                                // Workouts individuels
                                foreach ($category->workouts as $workout) {
                                    try {
                                        $url = route('public.workouts.show', [
                                            $section->slug,
                                            $category->slug,
                                            $workout->slug
                                        ]);
                                        
                                        SitemapUrl::updateOrCreate(
                                            ['url' => $url],
                                            [
                                                'type' => 'dynamic',
                                                'source' => 'workouts',
                                                'source_id' => $workout->id,
                                                'priority' => 0.6,
                                                'changefreq' => 'monthly',
                                                'is_approved' => false,
                                                'is_active' => true,
                                                'last_modified' => $workout->updated_at
                                            ]
                                        );
                                        
                                        $count++;
                                    } catch (\Exception $e) {
                                        Log::warning("Failed to add workout {$workout->id}: " . $e->getMessage());
                                    }
                                }
                            } catch (\Exception $e) {
                                Log::warning("Failed to add workout category {$category->id}: " . $e->getMessage());
                            }
                        }
                    } catch (\Exception $e) {
                        Log::warning("Failed to add workout section {$section->id}: " . $e->getMessage());
                    }
                }
            });

        return $count;
    }

    /**
     * Générer le fichier sitemap.xml
     */
    public function generateXml(): array
    {
        $urls = SitemapUrl::forSitemap()
            ->orderBy('priority', 'desc')
            ->orderBy('url')
            ->get();

        if ($urls->isEmpty()) {
            throw new \Exception('Aucune URL approuvée trouvée. Veuillez d\'abord découvrir et approuver des URLs.');
        }

        $xml = $this->buildXmlContent($urls);
        
        $path = public_path('sitemap.xml');
        file_put_contents($path, $xml);

        return [
            'urls_count' => $urls->count(),
            'file_path' => $path,
            'file_size' => filesize($path),
            'generated_at' => now()
        ];
    }

    /**
     * Construire le contenu XML
     */
    private function buildXmlContent($urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $urlData) {
            $xml .= "    <url>\n";
            $xml .= "        <loc>" . htmlspecialchars($urlData->url, ENT_XML1 | ENT_COMPAT, 'UTF-8') . "</loc>\n";
            $xml .= "        <lastmod>" . $urlData->last_modified_formatted . "</lastmod>\n";
            $xml .= "        <changefreq>" . htmlspecialchars($urlData->changefreq, ENT_XML1 | ENT_COMPAT, 'UTF-8') . "</changefreq>\n";
            $xml .= "        <priority>" . number_format($urlData->priority, 1) . "</priority>\n";
            $xml .= "    </url>\n";
        }

        $xml .= "</urlset>";

        return $xml;
    }

    /**
     * Obtenir les statistiques
     */
    public function getStatistics(): array
    {
        return [
            'total_urls' => SitemapUrl::count(),
            'approved_urls' => SitemapUrl::approved()->count(),
            'pending_approval' => SitemapUrl::where('is_approved', false)->count(),
            'active_urls' => SitemapUrl::active()->count(),
            'static_urls' => SitemapUrl::where('type', 'static')->count(),
            'dynamic_urls' => SitemapUrl::where('type', 'dynamic')->count(),
            'manual_urls' => SitemapUrl::where('type', 'manual')->count(),
            
            // Détail par source
            'posts_urls' => SitemapUrl::where('source', 'posts')->count(),
            'fiches_urls' => SitemapUrl::where('source', 'fiches')->count(),
            'downloadables_urls' => SitemapUrl::where('source', 'downloadables')->count(),
            'exercices_urls' => SitemapUrl::where('source', 'exercices')->count(),
            'plans_urls' => SitemapUrl::where('source', 'plans')->count(),
            'workouts_urls' => SitemapUrl::where('source', 'workouts')->count(),
            
            'sitemap_exists' => file_exists(public_path('sitemap.xml')),
            'last_generated' => file_exists(public_path('sitemap.xml')) 
                ? Carbon::createFromTimestamp(filemtime(public_path('sitemap.xml')))
                : null,
        ];
    }
}