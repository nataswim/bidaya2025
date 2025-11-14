@extends('layouts.public')

@section('title', 'Équipements Sportifs en France')
@section('meta_description', 'Trouvez facilement des équipements sportifs près de chez vous : piscines, terrains de sport, gymnases, stades. Carte interactive et recherche par localisation.')

@section('content')

<!-- Section titre -->
<section class="text-white py-5 nataswim-titre">
    <div class="container-lg py-4">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-map-marked-alt me-3 fs-1"></i>
                    <h1 class="display-5 fw-bold mb-0">Équipements Sportifs</h1>
                </div>
                <p class="lead mb-0">
                    Localisez plus de 333 000 équipements sportifs en France : piscines, terrains, gymnases, parcours de santé et bien plus.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-3 p-3">
                    <i class="fas fa-running fs-1 text-warning mb-2"></i>
                    <p class="mb-0 small">Données officielles<br>Ministère des Sports</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section recherche et carte -->
<section class="py-5 bg-light">
    <div class="container-lg">

        <!-- Formulaire de recherche -->
        <div class="card shadow-lg border-0 mb-4 nataswim-ombre">
            <div class="card-header nataswim-titre6 text-white">
                <h2 class="h4 mb-0">
                    <i class="fas fa-search me-2"></i>Rechercher des équipements
                </h2>
            </div>
            <div class="card-body p-4">
                <form id="searchForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="ville" class="form-label fw-semibold">
                                <i class="fas fa-city me-1"></i>Ville
                            </label>
                            <input type="text"
                                class="form-control form-control-lg"
                                id="ville"
                                name="ville"
                                placeholder="Paris, Lyon, Marseille...">
                        </div>

                        <div class="col-md-4">
                            <label for="code_postal" class="form-label fw-semibold">
                                <i class="fas fa-map-pin me-1"></i>Code Postal
                            </label>
                            <input type="text"
                                class="form-control form-control-lg"
                                id="code_postal"
                                name="code_postal"
                                maxlength="5"
                                placeholder="75001, 69001...">
                        </div>

                        <div class="col-md-4">
                            <label for="departement" class="form-label fw-semibold">
                                <i class="fas fa-map me-1"></i>Département
                            </label>
                            <input type="text"
                                class="form-control form-control-lg"
                                id="departement"
                                name="departement"
                                maxlength="3"
                                placeholder="75, 69, 13...">
                        </div>

                        <div class="col-md-8">
                            <label for="type_equipement" class="form-label fw-semibold">
                                <i class="fas fa-dumbbell me-1"></i>Type d'équipement
                            </label>
                            <input type="text"
                                class="form-control form-control-lg"
                                id="type_equipement"
                                name="type_equipement"
                                value="bassin"
                                placeholder="Piscine, Terrain de football, Gymnase...">
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Loader -->
                <div id="loader" class="text-center mt-4 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2 text-muted">Recherche en cours...</p>
                </div>

                <!-- Résultats -->
                <div id="results" class="mt-3"></div>
            </div>
        </div>

        <!-- Carte interactive -->
        <div class="card shadow-lg border-0 mb-4 nataswim-ombre">
            <div class="card-header nataswim-titre1 text-white d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">
                    <i class="fas fa-globe me-2"></i>Carte interactive
                </h2>
                <div class="btn-group btn-group-sm" role="group" id="mapViewSelector">
                    <input type="radio" class="btn-check" name="mapView" id="viewStandard" value="standard" checked>
                    <label class="btn btn-outline-light" for="viewStandard">
                        <i class="fas fa-map"></i> Standard
                    </label>

                    <input type="radio" class="btn-check" name="mapView" id="viewSatellite" value="satellite">
                    <label class="btn btn-outline-light" for="viewSatellite">
                        <i class="fas fa-satellite"></i> Satellite
                    </label>

                    <input type="radio" class="btn-check" name="mapView" id="viewTerrain" value="terrain">
                    <label class="btn btn-outline-light" for="viewTerrain">
                        <i class="fas fa-mountain"></i> Terrain
                    </label>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 600px; width: 100%;"></div>
            </div>
        </div>

        <!-- Liste des équipements -->
        <div id="equipementsList" class="d-none">
            <div class="card shadow-lg border-0 nataswim-ombre">
                <div class="card-header nataswim-titre2 text-white">
                    <h2 class="h4 mb-0">
                        <i class="fas fa-list me-2"></i>Liste des équipements
                        <span id="equipementsCount" class="badge bg-white text-primary ms-2">0</span>
                    </h2>
                </div>
                <div class="card-body p-4">
                    <div id="equipementsContent" class="row g-4">
                        <!-- Les cartes seront générées ici -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Section info -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Comment utiliser la recherche ?
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary-subtle p-2 rounded me-3">
                                <i class="fas fa-search text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Recherchez</h6>
                                <p class="small text-muted mb-0">
                                    Utilisez les filtres pour trouver un équipement par ville, code postal ou type.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-success-subtle p-2 rounded me-3">
                                <i class="fas fa-map-marked-alt text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Localisez</h6>
                                <p class="small text-muted mb-0">
                                    Visualisez les équipements sur la carte interactive avec différentes vues.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-info-subtle p-2 rounded me-3">
                                <i class="fas fa-info text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Consultez</h6>
                                <p class="small text-muted mb-0">
                                    Accédez aux détails : adresse, type, accessibilité, nature du sol, etc.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="bg-primary-subtle p-4 rounded">
                    <i class="fas fa-database text-primary fs-1 mb-3"></i>
                    <h5 class="fw-bold">333 247 équipements</h5>
                    <p class="small text-muted mb-0">Données officielles du Ministère des Sports</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .equipement-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }

    .equipement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2) !important;
    }

    .badge-custom {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    #map {
        border-radius: 0 0 12px 12px;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px;
    }

    .leaflet-popup-content {
        margin: 15px;
        min-width: 250px;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .equipement-card {
        animation: fadeInUp 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #map {
            height: 400px !important;
        }

        .btn-group-sm {
            flex-direction: column;
        }

        .btn-group-sm .btn {
            border-radius: 0.25rem !important;
            margin-bottom: 0.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Déclarer map en global pour qu'elle soit accessible partout
    let map;
    let markersLayer;
    let currentLayer;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation de la carte (centré sur la France)
        map = L.map('map').setView([46.603354, 1.888334], 6);

        // Couches de carte
        const layers = {
            standard: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }),
            satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: '&copy; <a href="https://www.esri.com/">Esri</a>'
            }),
            terrain: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://opentopomap.org">OpenTopoMap</a>'
            })
        };

        // Ajouter la couche par défaut
        currentLayer = layers.standard.addTo(map);

        // Gestion du changement de vue
        document.querySelectorAll('input[name="mapView"]').forEach(radio => {
            radio.addEventListener('change', function() {
                map.removeLayer(currentLayer);
                currentLayer = layers[this.value].addTo(map);
            });
        });

        // Groupe de marqueurs
        markersLayer = L.layerGroup().addTo(map);

        // Token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Éléments DOM
        const searchForm = document.getElementById('searchForm');
        const loader = document.getElementById('loader');
        const results = document.getElementById('results');
        const equipementsList = document.getElementById('equipementsList');
        const equipementsContent = document.getElementById('equipementsContent');
        const equipementsCount = document.getElementById('equipementsCount');

        // Fonction de recherche
        async function searchEquipements(event) {
            event.preventDefault();

            // Afficher le loader
            loader.classList.remove('d-none');
            results.innerHTML = '';
            equipementsList.classList.add('d-none');

            // Effacer les anciens marqueurs
            markersLayer.clearLayers();
            equipementsContent.innerHTML = '';

            // Récupérer les valeurs du formulaire
            const formData = new FormData(searchForm);
            const params = new URLSearchParams();

            for (const [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }

            try {
                // Appel API
                const response = await fetch(`/api/equipements/search?${params.toString()}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const equipements = data.equipements;

                    // Afficher le nombre de résultats
                    results.innerHTML = `
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>${equipements.length}</strong>&nbsp;équipement(s) trouvé(s) sur ${data.total} total
                    </div>
                `;

                    if (equipements.length > 0) {
                        // Afficher la liste des équipements
                        equipementsList.classList.remove('d-none');
                        equipementsCount.textContent = equipements.length;

                        // Créer les marqueurs et les cartes
                        const bounds = [];
                        const markers = {}; // Stocker les marqueurs par ID

                        equipements.forEach((equip, index) => {
                            // Marqueur sur la carte
                            const marker = L.marker([equip.latitude, equip.longitude]).addTo(markersLayer);
                            markers[index] = marker; // Stocker le marqueur

                            // Icône d'accès
                            const accesIcon = equip.acces_libre ?
                                '<i class="fas fa-unlock text-success"></i> Accès libre' :
                                '<i class="fas fa-lock text-warning"></i> Accès restreint';

                            // Popup
                            marker.bindPopup(`
                            <div class="p-2">
                                <h6 class="fw-bold text-primary mb-2">${equip.nom}</h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Type:</strong> ${equip.type}</p>
                                    ${equip.nature ? `<p class="mb-1"><strong>Nature:</strong> ${equip.nature}</p>` : ''}
                                    ${equip.sol ? `<p class="mb-1"><strong>Sol:</strong> ${equip.sol}</p>` : ''}
                                    <p class="mb-1"><strong>Adresse:</strong> ${equip.adresse}</p>
                                    <p class="mb-1"><strong>Ville:</strong> ${equip.code_postal} ${equip.ville}</p>
                                    <p class="mb-1"><strong>Département:</strong> ${equip.departement}</p>
                                    <hr class="my-2">
                                    <p class="mb-0">${accesIcon}</p>
                                </div>
                            </div>
                        `);

                            bounds.push([equip.latitude, equip.longitude]);

                            // Carte dans la liste
                            const card = document.createElement('div');
                            card.className = 'col-md-6 col-lg-4';
                            card.innerHTML = `
                            <div class="card h-100 shadow-sm equipement-card hover-lift border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold mb-0 text-primary">${equip.nom}</h5>
                                        ${equip.acces_libre 
                                            ? '<span class="badge bg-success-subtle text-success badge-custom">Accès libre</span>' 
                                            : '<span class="badge bg-warning-subtle text-warning badge-custom">Restreint</span>'
                                        }
                                    </div>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-tag me-1"></i>
                                        <strong>${equip.type}</strong>
                                    </p>
                                    ${equip.nature ? `
                                        <p class="small text-muted mb-1">
                                            <i class="fas fa-leaf me-1"></i>
                                            ${equip.nature}
                                        </p>
                                    ` : ''}
                                    ${equip.sol ? `
                                        <p class="small text-muted mb-2">
                                            <i class="fas fa-shoe-prints me-1"></i>
                                            ${equip.sol}
                                        </p>
                                    ` : ''}
                                    <hr class="my-2">
                                    <p class="small mb-1">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <strong>${equip.adresse}</strong>
                                    </p>
                                    <p class="small mb-1">
                                        <i class="fas fa-city text-primary me-1"></i>
                                        ${equip.code_postal} ${equip.ville}
                                    </p>
                                    <p class="small mb-0">
                                        <i class="fas fa-map text-info me-1"></i>
                                        ${equip.departement} • ${equip.region}
                                    </p>
                                </div>
                                <div class="card-footer bg-light border-0">
    <button class="btn btn-sm btn-outline-primary w-100 mb-2 view-on-map-btn" 
            data-lat="${equip.latitude}" 
            data-lng="${equip.longitude}"
            data-marker-index="${index}">
        <i class="fas fa-map-pin me-1"></i>Voir sur la carte
    </button>
    <a href="https://www.google.com/search?q=${encodeURIComponent(equip.nom + ' ' + equip.adresse + ' ' + equip.ville + ' ' + equip.code_postal)}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="btn btn-sm btn-outline-success w-100">
        <i class="fas fa-info-circle me-1"></i>Plus d'informations sur ce site
    </a>

    
</div>
                            </div>
                        `;
                            equipementsContent.appendChild(card);

                            // Ajouter l'event listener au bouton
                            const viewBtn = card.querySelector('.view-on-map-btn');
                            viewBtn.addEventListener('click', function() {
                                const lat = parseFloat(this.dataset.lat);
                                const lng = parseFloat(this.dataset.lng);
                                const markerIndex = this.dataset.markerIndex;

                                // Centrer la carte et zoomer
                                map.setView([lat, lng], 16);

                                // Ouvrir le popup du marqueur
                                if (markers[markerIndex]) {
                                    markers[markerIndex].openPopup();
                                }

                                // Scroll vers la carte
                                document.querySelector('#map').scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            });
                        });

                        // Ajuster la vue de la carte
                        if (bounds.length > 0) {
                            map.fitBounds(bounds, {
                                padding: [50, 50]
                            });
                        }

                        // Scroll vers les résultats
                        setTimeout(() => {
                            equipementsList.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }, 300);
                    } else {
                        results.innerHTML = `
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Aucun équipement trouvé avec ces critères
                        </div>
                    `;
                    }
                } else {
                    results.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fas fa-times-circle me-2"></i>
                        Erreur: ${data.error}
                    </div>
                `;
                }
            } catch (error) {
                console.error('Erreur:', error);
                results.innerHTML = `
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="fas fa-times-circle me-2"></i>
                    Erreur lors de la recherche
                </div>
            `;
            } finally {
                // Masquer le loader
                loader.classList.add('d-none');
            }
        }

        // Événement de soumission du formulaire
        searchForm.addEventListener('submit', searchEquipements);
    });
</script>
@endpush