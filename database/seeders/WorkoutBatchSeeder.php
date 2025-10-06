<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\WorkoutCategory;
use Illuminate\Support\Facades\DB;

/**
 * 🇬🇧 Seeder for workouts 25 to 191
 * 🇫🇷 Seeder pour les workouts 25 à 191
 */
class WorkoutBatchSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = 1; // Catégorie 1
        $total = 3200; // Volume total en mètres
        $shortDescription = 'seance en cours';
        $longDescription = 'seance en cours';

        // Vérifier que la catégorie existe
        $category = WorkoutCategory::find($categoryId);
        if (!$category) {
            $this->command->error("La catégorie ID {$categoryId} n'existe pas.");
            return;
        }

        $this->command->info("Création des workouts 25 à 191...");

        // Début de la transaction
        DB::beginTransaction();
        
        try {
            for ($i = 25; $i <= 191; $i++) {
                // Formatage avec zéros (001, 002, etc.)
                $number = str_pad($i, 3, '0', STR_PAD_LEFT);
                
                $title = "Séance : -{$number}-";
                $slug = "seance-{$number}";

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

                // Associer à la catégorie 1 avec order_number = $i
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
            
            $total = 191 - 25 + 1;
            $this->command->info("✅ {$total} workouts créés avec succès !");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Erreur : " . $e->getMessage());
        }
    }
}