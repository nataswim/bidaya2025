<?php

namespace App\Http\Controllers;

use App\Services\DataEsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class EquipementController extends Controller
{
    /**
     * Service Data ES
     */
    protected DataEsService $dataEsService;

    public function __construct(DataEsService $dataEsService)
    {
        $this->dataEsService = $dataEsService;
    }

    /**
     * Afficher la page principale avec la carte
     *
     * @return View
     */
    public function index(): View
    {
        return view('equipements.index');
    }

    /**
     * Rechercher des équipements (API JSON)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            // Validation des paramètres
            $validated = $request->validate([
                'ville' => 'nullable|string|max:255',
                'code_postal' => 'nullable|string|max:5',
                'departement' => 'nullable|string|max:3',
                'region' => 'nullable|string|max:255',
                'type_equipement' => 'nullable|string|max:255',
                'limit' => 'nullable|integer|min:1|max:100',
                'offset' => 'nullable|integer|min:0',
            ]);

            // Log de la requête
            Log::info('Recherche équipements', ['filters' => $validated]);

            // Appel au service
            $result = $this->dataEsService->searchEquipements($validated);

            // Log du résultat
            Log::info('Résultat recherche', [
                'success' => $result['success'],
                'total' => $result['data']['total_count'] ?? 0,
            ]);

            // Formatage des résultats pour la carte avec les VRAIS noms de champs
            if ($result['success'] && isset($result['data']['results'])) {
                $equipements = collect($result['data']['results'])->map(function ($item) {
                    // L'API renvoie les champs directement (pas dans 'fields')
                    $coordonnees = $item['equip_coordonnees'] ?? null;
                    
                    return [
                        'id' => $item['equip_numero'] ?? null,
                        'nom' => $item['equip_nom'] ?? 'Non renseigné',
                        'type' => $item['equip_type_name'] ?? 'Non renseigné',
                        'adresse' => $item['inst_adresse'] ?? '',
                        'ville' => $item['new_name'] ?? '',
                        'code_postal' => $item['inst_cp'] ?? '',
                        'departement' => $item['dep_nom'] ?? '',
                        'region' => $item['reg_nom'] ?? '',
                        'latitude' => is_array($coordonnees) ? ($coordonnees['lat'] ?? null) : null,
                        'longitude' => is_array($coordonnees) ? ($coordonnees['lon'] ?? null) : null,
                        'nature' => $item['equip_nature'] ?? null,
                        'sol' => $item['equip_sol'] ?? null,
                        'acces_libre' => $item['equip_acc_libre'] === 'true',
                    ];
                })->filter(function ($item) {
                    // Garder uniquement les équipements avec coordonnées GPS
                    return !is_null($item['latitude']) && !is_null($item['longitude']);
                })->values();

                return response()->json([
                    'success' => true,
                    'total' => $result['data']['total_count'] ?? 0,
                    'equipements' => $equipements,
                ]);
            }

            // En cas d'échec de l'API
            return response()->json([
                'success' => false,
                'error' => $result['error'] ?? 'Erreur lors de la récupération des données',
                'equipements' => [],
                'total' => 0,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Erreur de validation', ['errors' => $e->errors()]);
            
            return response()->json([
                'success' => false,
                'error' => 'Paramètres de recherche invalides',
                'details' => $e->errors(),
                'equipements' => [],
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Exception dans EquipementController::search', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Erreur serveur: ' . $e->getMessage(),
                'equipements' => [],
            ], 500);
        }
    }

    /**
     * Obtenir un équipement par son ID (API JSON)
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $result = $this->dataEsService->getEquipementById($id);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'equipement' => $result['data'],
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => $result['error'] ?? 'Équipement non trouvé',
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Exception dans EquipementController::show', [
                'message' => $e->getMessage(),
                'id' => $id,
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération de l\'équipement',
            ], 500);
        }
    }

    /**
     * Obtenir les statistiques par département (API JSON)
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        try {
            $result = $this->dataEsService->getStatsByDepartement();

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'stats' => $result['data'],
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => $result['error'] ?? 'Erreur lors de la récupération des statistiques',
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Exception dans EquipementController::stats', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des statistiques',
            ], 500);
        }
    }
}