<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\WorkoutCategory;
use Illuminate\Support\Facades\DB;

/**
 * 🇬🇧 Seeder for intermediate workouts I-001 to I-235
 * 🇫🇷 Seeder pour les workouts intermédiaires I-001 à I-235
 */
class WorkoutIntermediaireSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = 2; // Catégorie 2
        $total = 4000; // Volume total en mètres
        $shortDescription = 'seance en cours';
        $longDescription = 'seance en cours';

        // Vérifier que la catégorie existe
        $category = WorkoutCategory::find($categoryId);
        if (!$category) {
            $this->command->error("La catégorie ID {$categoryId} n'existe pas.");
            return;
        }

        $this->command->info("Création des workouts I-001 à I-235...");

        // Début de la transaction
        DB::beginTransaction();
        
        try {
            for ($i = 1; $i <= 235; $i++) {
                // Formatage avec zéros (001, 002, etc.)
                $number = str_pad($i, 3, '0', STR_PAD_LEFT);
                
                $title = "Séance : -I-{$number}-";
                $slug = "seance-i{$number}";

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

                // Associer à la catégorie 2 avec order_number
                $workout->categories()->attach($categoryId, [
                    'order_number' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Afficher la progression tous les 25 workouts
                if ($i % 25 === 0) {
                    $this->command->info("✓ {$i} workouts créés...");
                }
            }

            DB::commit();
            
            $this->command->info("✅ 235 workouts intermédiaires créés avec succès !");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Erreur : " . $e->getMessage());
        }
    }
}