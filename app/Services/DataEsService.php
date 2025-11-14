<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DataEsService
{
    /**
     * URL de base de l'API Data ES
     */
    private const API_BASE_URL = 'https://equipements.sports.gouv.fr/api/explore/v2.1';
    
    /**
     * Dataset des équipements sportifs
     */
    private const DATASET = 'data-es';
    
    /**
     * Durée du cache en minutes (5 minutes)
     */
    private const CACHE_DURATION = 5;

    /**
     * Rechercher des équipements sportifs
     *
     * @param array $filters Filtres de recherche
     * @return array
     */
    public function searchEquipements(array $filters = []): array
    {
        try {
            // Construction de la clé de cache unique
            $cacheKey = 'equipements_' . md5(json_encode($filters));

            return Cache::remember($cacheKey, self::CACHE_DURATION * 60, function () use ($filters) {
                $url = self::API_BASE_URL . '/catalog/datasets/' . self::DATASET . '/records';

                // Paramètres de la requête
                $params = [
                    'limit' => $filters['limit'] ?? 100,
                    'offset' => $filters['offset'] ?? 0,
                ];

                // Construction du filtre WHERE (sans UPPER)
                $whereConditions = [];
                
                // Ville (new_name) - recherche insensible à la casse avec LIKE
                if (!empty($filters['ville'])) {
                    $ville = trim($filters['ville']);
                    // Échapper les apostrophes
                    $ville = str_replace("'", "''", $ville);
                    $whereConditions[] = "new_name LIKE '%" . $ville . "%'";
                }
                
                // Code postal (inst_cp) - égalité exacte
                if (!empty($filters['code_postal'])) {
                    $codePostal = trim($filters['code_postal']);
                    $codePostal = str_replace("'", "''", $codePostal);
                    $whereConditions[] = "inst_cp = '" . $codePostal . "'";
                }
                
                // Département (dep_code) - égalité exacte
                if (!empty($filters['departement'])) {
                    $departement = trim($filters['departement']);
                    $departement = str_replace("'", "''", $departement);
                    $whereConditions[] = "dep_code = '" . $departement . "'";
                }
                
                // Région (reg_nom) - recherche avec LIKE
                if (!empty($filters['region'])) {
                    $region = trim($filters['region']);
                    $region = str_replace("'", "''", $region);
                    $whereConditions[] = "reg_nom LIKE '%" . $region . "%'";
                }

                // Type d'équipement (equip_type_name) - recherche avec LIKE
                if (!empty($filters['type_equipement'])) {
                    $type = trim($filters['type_equipement']);
                    $type = str_replace("'", "''", $type);
                    $whereConditions[] = "equip_type_name LIKE '%" . $type . "%'";
                }

                // Ajouter les conditions WHERE
                if (!empty($whereConditions)) {
                    $params['where'] = implode(' AND ', $whereConditions);
                }

                // Log de la requête pour debug
                Log::info('DataES API Request', [
                    'url' => $url,
                    'params' => $params,
                ]);

                // Appel API avec gestion d'erreur détaillée
                $response = Http::timeout(30)
                    ->retry(3, 100)
                    ->get($url, $params);

                // Log de la réponse
                Log::info('DataES API Response', [
                    'status' => $response->status(),
                    'successful' => $response->successful(),
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    return [
                        'success' => true,
                        'data' => $data,
                    ];
                }

                // Log détaillé de l'erreur
                Log::error('Erreur API Data ES', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'params' => $params,
                ]);

                return [
                    'success' => false,
                    'error' => 'Erreur API: ' . $response->status() . ' - ' . $response->body(),
                    'data' => ['results' => [], 'total_count' => 0],
                ];
            });
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Erreur de connexion DataEsService', [
                'message' => $e->getMessage(),
                'filters' => $filters,
            ]);

            return [
                'success' => false,
                'error' => 'Impossible de se connecter à l\'API Data ES.',
                'data' => ['results' => [], 'total_count' => 0],
            ];
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Erreur de requête DataEsService', [
                'message' => $e->getMessage(),
                'response' => $e->response ? $e->response->body() : null,
                'filters' => $filters,
            ]);

            return [
                'success' => false,
                'error' => 'Erreur lors de la requête: ' . $e->getMessage(),
                'data' => ['results' => [], 'total_count' => 0],
            ];
        } catch (\Exception $e) {
            Log::error('Exception DataEsService', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'filters' => $filters,
            ]);

            return [
                'success' => false,
                'error' => 'Erreur serveur: ' . $e->getMessage(),
                'data' => ['results' => [], 'total_count' => 0],
            ];
        }
    }

    /**
     * Obtenir un équipement par son ID
     *
     * @param string $recordId
     * @return array
     */
    public function getEquipementById(string $recordId): array
    {
        try {
            $url = self::API_BASE_URL . '/catalog/datasets/' . self::DATASET . '/records/' . $recordId;

            Log::info('DataES API getEquipementById', ['url' => $url]);

            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Équipement non trouvé', [
                'id' => $recordId,
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'error' => 'Équipement non trouvé',
                'data' => null,
            ];
        } catch (\Exception $e) {
            Log::error('Exception getEquipementById', [
                'message' => $e->getMessage(),
                'id' => $recordId,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Obtenir les statistiques d'équipements par département
     *
     * @return array
     */
    public function getStatsByDepartement(): array
    {
        try {
            $cacheKey = 'equipements_stats_departement';

            return Cache::remember($cacheKey, 60 * 60, function () {
                $url = self::API_BASE_URL . '/catalog/datasets/' . self::DATASET . '/aggregates';

                $params = [
                    'group_by' => 'dep_code',
                    'select' => 'count(*) as count',
                    'order_by' => 'count DESC',
                    'limit' => 100,
                ];

                $response = Http::timeout(30)->get($url, $params);

                if ($response->successful()) {
                    return [
                        'success' => true,
                        'data' => $response->json(),
                    ];
                }

                return [
                    'success' => false,
                    'error' => 'Erreur lors de la récupération des statistiques',
                    'data' => [],
                ];
            });
        } catch (\Exception $e) {
            Log::error('Exception getStatsByDepartement', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => [],
            ];
        }
    }
}