<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateCategorySlugs extends Command
{
    protected $signature = 'categories:generate-slugs';
    protected $description = 'Générer les slugs manquants pour les catégories';

    public function handle()
    {
        $this->info('Génération des slugs pour les catégories...');
        
        $categories = Category::whereNull('slug')->orWhere('slug', '')->get();
        
        if ($categories->isEmpty()) {
            $this->info('Aucune catégorie sans slug trouvée.');
            return 0;
        }
        
        $count = 0;
        foreach ($categories as $category) {
            $slug = Str::slug($category->name);
            $originalSlug = $slug;
            $counter = 1;
            
            // Vérifier l'unicité
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $category->slug = $slug;
            $category->save();
            
            $this->line("✓ Slug généré pour '{$category->name}': {$slug}");
            $count++;
        }
        
        $this->info("\n✅ {$count} slug(s) généré(s) avec succès !");
        
        return 0;
    }
}