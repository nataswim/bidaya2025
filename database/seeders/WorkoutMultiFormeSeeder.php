<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\WorkoutCategory;
use Illuminate\Support\Facades\DB;

/**
 * 🇬🇧 Seeder for multi-form workouts MF-001 to MF-025
 * 🇫🇷 Seeder pour les workouts multiforme MF-001 à MF-025
 */
class WorkoutMultiFormeSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = 11; // Catégorie MultiForme
        $total = 2000; // Volume total en mètres
        $shortDescription = 'seance en cours';
        $longDescription = 'seance en cours';

        // Vérifier que la catégorie existe
        $category = WorkoutCategory::find($categoryId);
        if (!$category) {
            $this->command->error("La catégorie ID {$categoryId} n'existe pas.");
            return;
        }

        $this->command->info("Création des workouts MultiForme MF-001 à MF-025...");

        // Début de la transaction
        DB::beginTransaction();
        
        try {
            for ($i = 1; $i <= 25; $i++) {
                // Formatage avec zéros (001, 002, etc.)
                $number = str_pad($i, 3, '0', STR_PAD_LEFT);
                
                $title = "Séance MultiForme : -MF-{$number}-";
                $slug = "seance-mf{$number}";

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

                // Associer à la catégorie avec order_number
                $workout->categories()->attach($categoryId, [
                    'order_number' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($i % 10 === 0) {
                    $this->command->info("✓ {$i} workouts créés...");
                }
            }

            DB::commit();
            
            $this->command->info("✅ 25 workouts MultiForme créés avec succès !");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Erreur : " . $e->getMessage());
        }
    }
}