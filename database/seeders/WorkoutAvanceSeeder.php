<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\WorkoutCategory;
use Illuminate\Support\Facades\DB;

/**
 * 🇬🇧 Seeder for advanced workouts A-001 to A-160
 * 🇫🇷 Seeder pour les workouts avancés A-001 à A-160
 */
class WorkoutAvanceSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = 3; // Catégorie 3
        $total = 5000; // Volume total en mètres
        $shortDescription = 'seance en cours';
        $longDescription = 'seance en cours';

        // Vérifier que la catégorie existe
        $category = WorkoutCategory::find($categoryId);
        if (!$category) {
            $this->command->error("La catégorie ID {$categoryId} n'existe pas.");
            return;
        }

        $this->command->info("Création des workouts A-001 à A-160...");

        // Début de la transaction
        DB::beginTransaction();
        
        try {
            for ($i = 1; $i <= 160; $i++) {
                // Formatage avec zéros (001, 002, etc.)
                $number = str_pad($i, 3, '0', STR_PAD_LEFT);
                
                $title = "Séance : -A-{$number}-";
                $slug = "seance-a{$number}";

                // Créer le workout
                $workout = Workout::create([
                    'title' => $title,
                    'slug' => $slug,
                    'short_description' => $shortDescription,
                    'long_description' => $longDescription,
                    'total' => $total,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Associer à la catégorie 3 avec order_number
                $workout->categories()->attach($categoryId, [
                    'order_number' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Afficher la progression tous les 20 workouts
                if ($i % 20 === 0) {
                    $this->command->info("✓ {$i} workouts créés...");
                }
            }

            DB::commit();
            
            $this->command->info("✅ 160 workouts avancés créés avec succès !");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Erreur : " . $e->getMessage());
        }
    }
}