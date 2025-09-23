@extends('layouts.public')

@section('title', 'Calculateur Efficacité Technique Natation - DPS & SWOLF Scientifique')
@section('meta_description', 'Analysez votre efficacité technique en natation avec DPS (Distance Par Stroke) et SWOLF. Comparaisons normatives, recommandations d\'amélioration et progression technique evidence-based.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="fas fa-swimmer text-info"></i>
            Calculateur Efficacité Technique Natation
            <i class="fas fa-chart-line text-warning"></i>
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-ruler text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Optimisez votre technique</strong> avec l'analyse DPS (Distance Par Stroke) et SWOLF 
                    basée sur les standards internationaux et recherches en biomécanique aquatique
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Calculateur DPS/SWOLF -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-calculator me-2"></i>
                    Calculateur DPS & SWOLF
                </h3>
            </div>
            <div class="card-body">
                
                <!-- Messages d'erreur -->
                <div id="errorMessage" class="alert alert-danger d-none">
                    <!-- Sera rempli par JavaScript -->
                </div>

                <!-- Paramètres du test -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="strokeType" class="form-label fw-bold">Type de nage</label>
                        <select id="strokeType" class="form-select form-select-lg border-primary">
                            <option value="freestyle">Crawl / Nage libre</option>
                            <option value="backstroke">Dos crawlé</option>
                            <option value="breaststroke">Brasse</option>
                            <option value="butterfly">Papillon</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="distance" class="form-label fw-bold">Distance du test</label>
                        <select id="distance" class="form-select form-select-lg border-success">
                            <option value="25">25 mètres</option>
                            <option value="50" selected>50 mètres</option>
                            <option value="100">100 mètres</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="poolLength" class="form-label fw-bold">Longueur bassin</label>
                        <select id="poolLength" class="form-select form-select-lg border-info">
                            <option value="25" selected>25 mètres</option>
                            <option value="50">50 mètres</option>
                        </select>
                    </div>
                </div>

                <!-- Données de performance -->
                <h5 class="fw-bold mb-3">Données de Performance</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="timeMinutes" class="form-label fw-bold">Temps (minutes)</label>
                        <input type="number" id="timeMinutes" class="form-control form-control-lg border-danger" 
                               placeholder="0" min="0" max="10">
                    </div>
                    <div class="col-md-4">
                        <label for="timeSeconds" class="form-label fw-bold">Secondes</label>
                        <input type="number" id="timeSeconds" class="form-control form-control-lg border-danger" 
                               placeholder="30" min="0" max="59" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label for="strokeCount" class="form-label fw-bold">Nombre de coups de bras</label>
                        <input type="number" id="strokeCount" class="form-control form-control-lg border-warning" 
                               placeholder="20" min="1" max="200">
                        <small class="text-muted">Compter tous les mouvements de bras</small>
                    </div>
                </div>

                <!-- Profil nageur -->
                <h5 class="fw-bold mb-3">Profil Nageur</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="level" class="form-label">Niveau</label>
                        <select id="level" class="form-select border-secondary">
                            <option value="recreational">Loisir / Débutant</option>
                            <option value="club" selected>Club / Intermédiaire</option>
                            <option value="competitive">Compétition</option>
                            <option value="elite">Élite / National</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="age" class="form-label">Âge</label>
                        <input type="number" id="age" class="form-control border-info" 
                               placeholder="25" min="8" max="80">
                    </div>
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Sexe</label>
                        <select id="gender" class="form-select border-info">
                            <option value="male">Homme</option>
                            <option value="female">Femme</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg fw-bold w-100" onclick="calculateEfficiency()">
                            <i class="fas fa-chart-line me-2"></i>Analyser Efficacité Technique
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary btn-lg fw-bold w-100" onclick="resetCalculator()">
                            <i class="fas fa-redo me-2"></i>Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Résultats de l'analyse -->
        <div id="resultsSection" class="d-none">
            <!-- Métriques principales -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-trophy me-2"></i>
                        Analyse de votre Efficacité Technique
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white text-center">
                                    <h6 class="mb-0">DPS</h6>
                                    <small>Distance Par Stroke</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-primary" id="dpsResult">0.00</strong></span>
                                        <small class="d-block">mètres/coup</small>
                                    </p>
                                    <span id="dpsRating" class="badge bg-secondary">-</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning text-dark text-center">
                                    <h6 class="mb-0">SWOLF</h6>
                                    <small>Swimming Golf</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-warning" id="swolfResult">0</strong></span>
                                        <small class="d-block">score</small>
                                    </p>
                                    <span id="swolfRating" class="badge bg-secondary">-</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white text-center">
                                    <h6 class="mb-0">Vitesse</h6>
                                    <small>Vitesse moyenne</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-info" id="speedResult">0.00</strong></span>
                                        <small class="d-block">m/s</small>
                                    </p>
                                    <small class="text-muted" id="paceResult">0:00/100m</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white text-center">
                                    <h6 class="mb-0">Fréquence</h6>
                                    <small>Gestuelle</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-success" id="frequencyResult">0</strong></span>
                                        <small class="d-block">coups/min</small>
                                    </p>
                                    <span id="frequencyRating" class="badge bg-secondary">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Évaluation globale -->
                    <div class="alert" id="globalAssessment">
                        <h6 id="assessmentTitle">Évaluation Globale</h6>
                        <p id="assessmentText" class="mb-0">
                            <!-- Sera rempli par JavaScript -->
                        </p>
                    </div>
                </div>
            </div>

            <!-- Comparaisons normatives -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-chart-bar me-2"></i>
                        Comparaisons Normatives
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6>Position par rapport aux normes :</h6>
                            <div id="normativeComparison">
                                <!-- Sera rempli par JavaScript -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Objectifs d'amélioration :</h6>
                            <div id="improvementTargets">
                                <!-- Sera rempli par JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommandations techniques -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-2">
                        <i class="fas fa-lightbulb me-2"></i>
                        Recommandations Techniques
                    </h3>
                </div>
                <div class="card-body">
                    <div id="technicalRecommendations">
                        <!-- Sera rempli par JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Éducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- Comprendre DPS et SWOLF -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Comprendre DPS et SWOLF
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>DPS - Distance Par Stroke</h6>
                        <p class="small">
                            Le DPS mesure l'efficacité propulsive en calculant la distance parcourue par coup de bras. 
                            Plus le DPS est élevé, plus le nageur avance loin avec chaque mouvement, indiquant une 
                            meilleure technique de glisse et d'appui.
                        </p>
                        
                        <h6 className="mt-3">Facteurs influençant le DPS :</h6>
                        <ul class="small">
                            <li><strong>Technique d'appui :</strong> Efficacité de la prise d'eau</li>
                            <li><strong>Position du corps :</strong> Hydrodynamisme et glisse</li>
                            <li><strong>Amplitude gestuelle :</strong> Longueur des mouvements</li>
                            <li><strong>Timing :</strong> Coordination bras/corps/jambes</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>SWOLF - Swimming Golf</h6>
                        <p class="small">
                            Le SWOLF combine temps et nombre de coups (Temps + Coups = Score). Plus le score est bas, 
                            meilleure est l'efficacité globale. C'est un indicateur d'équilibre entre vitesse et technique.
                        </p>
                        
                        <h6 className="mt-3">Interprétation SWOLF :</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Score 50m Crawl</th>
                                        <th>Niveau Récréatif</th>
                                        <th>Niveau Club</th>
                                        <th>Niveau Compétition</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td>Excellent</td>
                                        <td>&lt; 65</td>
                                        <td>&lt; 55</td>
                                        <td>&lt; 45</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Bon</td>
                                        <td>65-75</td>
                                        <td>55-65</td>
                                        <td>45-55</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Moyen</td>
                                        <td>75-85</td>
                                        <td>65-75</td>
                                        <td>55-65</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>À améliorer</td>
                                        <td>&gt; 85</td>
                                        <td>&gt; 75</td>
                                        <td>&gt; 65</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Normes par nage -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-swimming-pool me-2"></i>
                    Normes de Référence par Nage
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>DPS Moyens par Nage (niveau Club)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nage</th>
                                        <th>Homme</th>
                                        <th>Femme</th>
                                        <th>Amplitude Optimale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Crawl</strong></td>
                                        <td>2.2 - 2.5m</td>
                                        <td>2.0 - 2.3m</td>
                                        <td>Longue, régulière</td>
                                    </tr>
                                    <tr>
                                        <td>Dos crawlé</td>
                                        <td>2.0 - 2.3m</td>
                                        <td>1.8 - 2.1m</td>
                                        <td>Rotation marquée</td>
                                    </tr>
                                    <tr>
                                        <td>Brasse</td>
                                        <td>1.8 - 2.2m</td>
                                        <td>1.6 - 2.0m</td>
                                        <td>Glisse prolongée</td>
                                    </tr>
                                    <tr>
                                        <td>Papillon</td>
                                        <td>2.5 - 3.0m</td>
                                        <td>2.2 - 2.7m</td>
                                        <td>Ondulation efficace</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Fréquences Gestuelles Optimales</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nage</th>
                                        <th>Distance</th>
                                        <th>Fréquence (coups/min)</th>
                                        <th>Stratégie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="2"><strong>Crawl</strong></td>
                                        <td>50-100m</td>
                                        <td>45-55</td>
                                        <td>Vitesse</td>
                                    </tr>
                                    <tr>
                                        <td>400m+</td>
                                        <td>35-45</td>
                                        <td>Endurance</td>
                                    </tr>
                                    <tr>
                                        <td>Dos</td>
                                        <td>50-200m</td>
                                        <td>40-50</td>
                                        <td>Régularité</td>
                                    </tr>
                                    <tr>
                                        <td>Brasse</td>
                                        <td>50-200m</td>
                                        <td>25-35</td>
                                        <td>Glisse max</td>
                                    </tr>
                                    <tr>
                                        <td>Papillon</td>
                                        <td>50-100m</td>
                                        <td>30-40</td>
                                        <td>Rythme</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Amélioration technique -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-arrow-up me-2"></i>
                    Stratégies d'Amélioration Technique
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 className="text-primary">Améliorer le DPS</h6>
                        <ul class="small">
                            <li><strong>Position corporelle :</strong> Corps aligné, tête neutre</li>
                            <li><strong>Entrée de main :</strong> Extension maximale, pénétration propre</li>
                            <li><strong>Phase d'appui :</strong> Prise d'eau profonde, avant-bras vertical</li>
                            <li><strong>Roulis :</strong> Rotation corps 30-45°</li>
                            <li><strong>Glisse :</strong> Maintenir vitesse entre les coups</li>
                        </ul>
                        
                        <div className="alert alert-info alert-sm">
                            <small><strong>Exercice clé :</strong> Nage à 3 temps (3 coups + respiration) pour maximiser la glisse</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 className="text-success">Optimiser SWOLF</h6>
                        <ul class="small">
                            <li><strong>Équilibre amplitude/fréquence :</strong> Trouver le ratio optimal</li>
                            <li><strong>Régularité :</strong> Maintenir technique sous fatigue</li>
                            <li><strong>Efficacité énergétique :</strong> Éviter efforts parasites</li>
                            <li><strong>Coordination :</strong> Synchronisation bras/jambes/respiration</li>
                            <li><strong>Streamline :</strong> Position de glisse optimale</li>
                        </ul>
                        
                        <div className="alert alert-success alert-sm">
                            <small><strong>Test progression :</strong> SWOLF weekly sur 50m même allure</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 className="text-warning">Protocole d'Évaluation</h6>
                        <ul class="small">
                            <li><strong>Échauffement :</strong> 400-600m progressif</li>
                            <li><strong>Standardisation :</strong> Même bassin, même conditions</li>
                            <li><strong>Intensité :</strong> 80-85% effort (soutenu mais contrôlé)</li>
                            <li><strong>Récupération :</strong> 2-3min entre répétitions</li>
                            <li><strong>Fréquence :</strong> Test hebdomadaire ou bi-hebdomadaire</li>
                        </ul>
                        
                        <div className="alert alert-warning alert-sm">
                            <small><strong>Important :</strong> Progrès technique = progression graduelle et constante</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Limitations et bonnes pratiques -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Limitations et Bonnes Pratiques
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 className="text-danger">Facteurs Limitants</h6>
                        <ul class="small">
                            <li><strong>Conditions de test :</strong> Température eau, fatigue préalable</li>
                            <li><strong>Précision mesure :</strong> Comptage coups, chronométrage</li>
                            <li><strong>Variabilité individuelle :</strong> Morphologie, flexibilité</li>
                            <li><strong>Phase d'apprentissage :</strong> Technique en évolution</li>
                            <li><strong>Spécificité distance :</strong> 50m ≠ 1500m</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 className="text-success">Recommandations d'Usage</h6>
                        <ul class="small">
                            <li><strong>Régularité :</strong> Tests dans conditions similaires</li>
                            <li><strong>Progression graduelle :</strong> Éviter changements techniques brutaux</li>
                            <li><strong>Accompagnement :</strong> Analyse vidéo et regard externe</li>
                            <li><strong>Patience :</strong> Améliorations techniques prennent du temps</li>
                            <li><strong>Approche holistique :</strong> Technique + condition physique</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-heart me-2"></i>Approche Équilibrée</h6>
                    <p class="mb-0">
                        Ces métriques sont des outils d'aide à l'amélioration technique, non des objectifs en soi. 
                        L'efficacité en natation résulte d'un équilibre entre technique, condition physique et plaisir de nager. 
                        Une obsession des chiffres peut nuire au développement technique naturel. Privilégiez la progression 
                        graduelle avec l'accompagnement d'un coach qualifié.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Crédit et Contact -->
     <div class="card mb-4">
            <a href="{{ route('tools.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Essayer d'autres outils
            </a>
        </div>
<section class="py-5 bg-primary text-white">

    <div class="container">


        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">À Propos de nos Outils</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">Développement & Expertise</h6>
                        <p class="mb-3">
                            Contenus et outils développés par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Expert en sciences du sport, physiologie de l'exercice et développement 
                            d'outils d'aide à la performance sportive evidence-based.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Collaboration & Amélioration</h6>
                        <p class="mb-3 small">
                            Si vous constatez une erreur dans nos calculateurs ou souhaitez suggérer 
                            de nouveaux outils, n'hésitez pas à nous contacter.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-envelope me-2"></i>Nous Contacter
                            </a>
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fab fa-linkedin me-2"></i>LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="bg-white bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/med_Hassan_EL_HAOUAT.png') }}" 
                         alt="MED Hassan El Haouat - Expert en sciences du sport" 
                         class="w-100 h-100 rounded-circle"
                         style="object-fit: cover;">
                </div>
                <div class="mt-3">
                    <h6 class="text-warning mb-1">Evidence-Based</h6>
                    <small class="text-light opacity-75">Recherches 2024 intégrées</small>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Dernières Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-newspaper text-primary me-2"></i>Dernières Publications
            </h2>
            <a href="{{ route('public.index') }}" class="btn btn-outline-primary">
                Tous les articles <i class="fas fa-angle-right ms-1"></i>
            </a>
        </div>
        
        @php
            $latestPosts = App\Models\Post::with('category')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        @endphp
        
        @if($latestPosts->count() > 0)
            <div class="row g-4">
                @foreach($latestPosts as $post)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm hover-lift border-0">
                            <div style="height: 180px; overflow: hidden;">
                                @if($post->image)
                                    <img src="{{ $post->image }}" 
                                         alt="{{ $post->name }}"
                                         class="card-img-top"
                                         style="height: 100%; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                        <i class="fas fa-swimmer text-muted" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($post->category)
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    </div>
                                @endif
                                <h3 class="card-title h5 mb-3">{{ $post->name }}</h3>
                                @if($post->intro)
                                    <p class="card-text text-muted small">
                                        {{ Str::limit(strip_tags($post->intro), 100) }}
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $post->published_at->format('d/m/Y') }}
                                </small>
                                <a href="{{ route('public.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                    Lire la suite
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>Aucun article n'est disponible actuellement.
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
}

.card {
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.progress-ring {
    width: 80px;
    height: 80px;
}

.progress-ring circle {
    fill: transparent;
    stroke-width: 8;
    stroke-linecap: round;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}
</style>
@endpush

@push('scripts')
<script>
// Normes de référence
const norms = {
    freestyle: {
        recreational: {
            male: { dps: { excellent: 2.0, good: 1.7, average: 1.4 }, swolf: { excellent: 70, good: 80, average: 90 } },
            female: { dps: { excellent: 1.8, good: 1.5, average: 1.2 }, swolf: { excellent: 75, good: 85, average: 95 } }
        },
        club: {
            male: { dps: { excellent: 2.5, good: 2.2, average: 1.9 }, swolf: { excellent: 55, good: 65, average: 75 } },
            female: { dps: { excellent: 2.3, good: 2.0, average: 1.7 }, swolf: { excellent: 60, good: 70, average: 80 } }
        },
        competitive: {
            male: { dps: { excellent: 2.8, good: 2.5, average: 2.2 }, swolf: { excellent: 45, good: 55, average: 65 } },
            female: { dps: { excellent: 2.6, good: 2.3, average: 2.0 }, swolf: { excellent: 50, good: 60, average: 70 } }
        },
        elite: {
            male: { dps: { excellent: 3.0, good: 2.8, average: 2.5 }, swolf: { excellent: 40, good: 45, average: 55 } },
            female: { dps: { excellent: 2.8, good: 2.6, average: 2.3 }, swolf: { excellent: 42, good: 50, average: 60 } }
        }
    },
    backstroke: {
        recreational: {
            male: { dps: { excellent: 1.8, good: 1.5, average: 1.2 }, swolf: { excellent: 75, good: 85, average: 95 } },
            female: { dps: { excellent: 1.6, good: 1.3, average: 1.0 }, swolf: { excellent: 80, good: 90, average: 100 } }
        },
        club: {
            male: { dps: { excellent: 2.3, good: 2.0, average: 1.7 }, swolf: { excellent: 60, good: 70, average: 80 } },
            female: { dps: { excellent: 2.1, good: 1.8, average: 1.5 }, swolf: { excellent: 65, good: 75, average: 85 } }
        },
        competitive: {
            male: { dps: { excellent: 2.6, good: 2.3, average: 2.0 }, swolf: { excellent: 50, good: 60, average: 70 } },
            female: { dps: { excellent: 2.4, good: 2.1, average: 1.8 }, swolf: { excellent: 55, good: 65, average: 75 } }
        },
        elite: {
            male: { dps: { excellent: 2.8, good: 2.6, average: 2.3 }, swolf: { excellent: 45, good: 50, average: 60 } },
            female: { dps: { excellent: 2.6, good: 2.4, average: 2.1 }, swolf: { excellent: 47, good: 55, average: 65 } }
        }
    },
    breaststroke: {
        recreational: {
            male: { dps: { excellent: 1.6, good: 1.3, average: 1.0 }, swolf: { excellent: 80, good: 90, average: 100 } },
            female: { dps: { excellent: 1.4, good: 1.1, average: 0.8 }, swolf: { excellent: 85, good: 95, average: 105 } }
        },
        club: {
            male: { dps: { excellent: 2.2, good: 1.9, average: 1.6 }, swolf: { excellent: 65, good: 75, average: 85 } },
            female: { dps: { excellent: 2.0, good: 1.7, average: 1.4 }, swolf: { excellent: 70, good: 80, average: 90 } }
        },
        competitive: {
            male: { dps: { excellent: 2.5, good: 2.2, average: 1.9 }, swolf: { excellent: 55, good: 65, average: 75 } },
            female: { dps: { excellent: 2.3, good: 2.0, average: 1.7 }, swolf: { excellent: 60, good: 70, average: 80 } }
        },
        elite: {
            male: { dps: { excellent: 2.7, good: 2.5, average: 2.2 }, swolf: { excellent: 50, good: 55, average: 65 } },
            female: { dps: { excellent: 2.5, good: 2.3, average: 2.0 }, swolf: { excellent: 52, good: 60, average: 70 } }
        }
    },
    butterfly: {
        recreational: {
            male: { dps: { excellent: 2.0, good: 1.7, average: 1.4 }, swolf: { excellent: 75, good: 85, average: 95 } },
            female: { dps: { excellent: 1.8, good: 1.5, average: 1.2 }, swolf: { excellent: 80, good: 90, average: 100 } }
        },
        club: {
            male: { dps: { excellent: 2.7, good: 2.4, average: 2.1 }, swolf: { excellent: 60, good: 70, average: 80 } },
            female: { dps: { excellent: 2.5, good: 2.2, average: 1.9 }, swolf: { excellent: 65, good: 75, average: 85 } }
        },
        competitive: {
            male: { dps: { excellent: 3.0, good: 2.7, average: 2.4 }, swolf: { excellent: 50, good: 60, average: 70 } },
            female: { dps: { excellent: 2.8, good: 2.5, average: 2.2 }, swolf: { excellent: 55, good: 65, average: 75 } }
        },
        elite: {
            male: { dps: { excellent: 3.2, good: 3.0, average: 2.7 }, swolf: { excellent: 45, good: 50, average: 60 } },
            female: { dps: { excellent: 3.0, good: 2.8, average: 2.5 }, swolf: { excellent: 47, good: 55, average: 65 } }
        }
    }
};

// Calcul de l'efficacité technique
function calculateEfficiency() {
    // Récupération des valeurs
    const strokeType = document.getElementById('strokeType').value;
    const distance = parseFloat(document.getElementById('distance').value);
    const timeMinutes = parseFloat(document.getElementById('timeMinutes').value) || 0;
    const timeSeconds = parseFloat(document.getElementById('timeSeconds').value);
    const strokeCount = parseInt(document.getElementById('strokeCount').value);
    const level = document.getElementById('level').value;
    const gender = document.getElementById('gender').value;
    
    // Validation
    if (isNaN(timeSeconds) || !strokeCount || strokeCount <= 0) {
        showError('Veuillez entrer un temps valide et le nombre de coups de bras.');
        return;
    }
    
    if (timeSeconds <= 0 || timeSeconds >= 600) {
        showError('Le temps doit être compris entre 0 et 600 secondes.');
        return;
    }
    
    if (strokeCount > distance * 10) {
        showError('Le nombre de coups semble trop élevé pour cette distance.');
        return;
    }
    
    // Masquer les erreurs
    document.getElementById('errorMessage').classList.add('d-none');
    
    // Calculs
    const totalTimeSeconds = (timeMinutes * 60) + timeSeconds;
    const dps = distance / strokeCount;
    const swolf = strokeCount + totalTimeSeconds;
    const speed = distance / totalTimeSeconds;
    const pace = 100 / speed; // secondes par 100m
    const frequency = (strokeCount / totalTimeSeconds) * 60; // coups par minute
    
    // Ajustements selon la distance pour comparaison 50m
    let adjustedSwolf = swolf;
    if (distance === 25) {
        adjustedSwolf = swolf * 2; // Approximation pour 50m
    } else if (distance === 100) {
        adjustedSwolf = swolf * 0.5; // Approximation pour 50m
    }
    
    // Affichage des résultats
    displayResults({
        dps: dps,
        swolf: Math.round(swolf),
        adjustedSwolf: Math.round(adjustedSwolf),
        speed: speed,
        pace: pace,
        frequency: Math.round(frequency),
        strokeType: strokeType,
        level: level,
        gender: gender,
        distance: distance
    });
}

// Affichage des résultats
function displayResults(results) {
    // Métriques principales
    document.getElementById('dpsResult').textContent = results.dps.toFixed(2);
    document.getElementById('swolfResult').textContent = results.swolf;
    document.getElementById('speedResult').textContent = results.speed.toFixed(2);
    document.getElementById('frequencyResult').textContent = results.frequency;
    
    // Calcul du pace
    const paceMinutes = Math.floor(results.pace / 60);
    const paceSeconds = Math.round(results.pace % 60);
    document.getElementById('paceResult').textContent = `${paceMinutes}:${paceSeconds.toString().padStart(2, '0')}/100m`;
    
    // Récupération des normes
    const norm = norms[results.strokeType][results.level][results.gender];
    
    // Évaluation DPS
    const dpsRating = evaluateMetric(results.dps, norm.dps);
    document.getElementById('dpsRating').textContent = dpsRating.label;
    document.getElementById('dpsRating').className = `badge bg-${dpsRating.color}`;
    
    // Évaluation SWOLF (utiliser adjustedSwolf pour comparaison)
    const swolfRating = evaluateMetric(results.adjustedSwolf, norm.swolf, true); // true = lower is better
    document.getElementById('swolfRating').textContent = swolfRating.label;
    document.getElementById('swolfRating').className = `badge bg-${swolfRating.color}`;
    
    // Évaluation fréquence
    const idealFrequency = getIdealFrequency(results.strokeType, results.distance);
    const frequencyRating = evaluateFrequency(results.frequency, idealFrequency);
    document.getElementById('frequencyRating').textContent = frequencyRating.label;
    document.getElementById('frequencyRating').className = `badge bg-${frequencyRating.color}`;
    
    // Évaluation globale
    const globalAssessment = getGlobalAssessment(dpsRating, swolfRating, results);
    document.getElementById('globalAssessment').className = `alert alert-${globalAssessment.color}`;
    document.getElementById('assessmentTitle').textContent = globalAssessment.title;
    document.getElementById('assessmentText').textContent = globalAssessment.text;
    
    // Comparaisons normatives
    displayNormativeComparison(results, norm);
    
    // Recommandations techniques
    displayTechnicalRecommendations(results, dpsRating, swolfRating, frequencyRating);
    
    // Afficher la section résultats
    document.getElementById('resultsSection').classList.remove('d-none');
    document.getElementById('resultsSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Évaluation d'une métrique
function evaluateMetric(value, norm, lowerIsBetter = false) {
    if (lowerIsBetter) {
        if (value <= norm.excellent) return { label: 'Excellent', color: 'success' };
        if (value <= norm.good) return { label: 'Bon', color: 'info' };
        if (value <= norm.average) return { label: 'Moyen', color: 'warning' };
        return { label: 'À améliorer', color: 'danger' };
    } else {
        if (value >= norm.excellent) return { label: 'Excellent', color: 'success' };
        if (value >= norm.good) return { label: 'Bon', color: 'info' };
        if (value >= norm.average) return { label: 'Moyen', color: 'warning' };
        return { label: 'À améliorer', color: 'danger' };
    }
}

// Fréquence idéale selon nage et distance
function getIdealFrequency(strokeType, distance) {
    const frequencies = {
        freestyle: { short: 50, long: 40 },
        backstroke: { short: 45, long: 40 },
        breaststroke: { short: 30, long: 28 },
        butterfly: { short: 35, long: 32 }
    };
    
    const isShort = distance <= 50;
    return frequencies[strokeType][isShort ? 'short' : 'long'];
}

// Évaluation fréquence
function evaluateFrequency(frequency, ideal) {
    const diff = Math.abs(frequency - ideal);
    if (diff <= 3) return { label: 'Optimal', color: 'success' };
    if (diff <= 6) return { label: 'Bon', color: 'info' };
    if (diff <= 10) return { label: 'Acceptable', color: 'warning' };
    return { label: 'À ajuster', color: 'danger' };
}

// Évaluation globale
function getGlobalAssessment(dpsRating, swolfRating, results) {
    const excellentCount = [dpsRating, swolfRating].filter(r => r.color === 'success').length;
    const goodCount = [dpsRating, swolfRating].filter(r => r.color === 'info').length;
    
    if (excellentCount >= 2) {
        return {
            title: 'Excellente Efficacité Technique !',
            text: `Votre technique est très efficace avec un DPS de ${results.dps.toFixed(2)}m et un SWOLF de ${results.swolf}. Continuez sur cette voie en maintenant la régularité.`,
            color: 'success'
        };
    } else if (excellentCount + goodCount >= 2) {
        return {
            title: 'Bonne Efficacité Technique',
            text: `Votre technique montre de bons résultats. Concentrez-vous sur l'amélioration du point le plus faible pour optimiser votre efficacité globale.`,
            color: 'info'
        };
    } else if (goodCount >= 1) {
        return {
            title: 'Efficacité Technique à Développer',
            text: `Votre technique présente des axes d'amélioration intéressants. Un travail technique régulier vous permettra de progresser significativement.`,
            color: 'warning'
        };
    } else {
        return {
            title: 'Focus sur la Technique',
            text: `Concentrez-vous sur les fondamentaux techniques. Un accompagnement par un coach vous aidera à développer une nage plus efficace.`,
            color: 'danger'
        };
    }
}

// Affichage comparaisons normatives
function displayNormativeComparison(results, norm) {
    const container = document.getElementById('normativeComparison');
    
    container.innerHTML = `
        <div class="row g-2">
            <div class="col-12 mb-2">
                <div class="card border-primary">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">DPS - Distance Par Stroke</h6>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-danger" style="width: 25%">
                                <small>À améliorer: &lt;${norm.dps.average.toFixed(1)}m</small>
                            </div>
                            <div class="progress-bar bg-warning" style="width: 25%">
                                <small>Moyen: ${norm.dps.average.toFixed(1)}m</small>
                            </div>
                            <div class="progress-bar bg-info" style="width: 25%">
                                <small>Bon: ${norm.dps.good.toFixed(1)}m</small>
                            </div>
                            <div class="progress-bar bg-success" style="width: 25%">
                                <small>Excellent: ${norm.dps.excellent.toFixed(1)}m+</small>
                            </div>
                        </div>
                        <p class="mb-0 small">Votre DPS: <strong>${results.dps.toFixed(2)}m</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-body py-2">
                        <h6 class="card-title mb-1">SWOLF - Swimming Golf</h6>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: 25%">
                                <small>Excellent: &lt;${norm.swolf.excellent}</small>
                            </div>
                            <div class="progress-bar bg-info" style="width: 25%">
                                <small>Bon: ${norm.swolf.excellent}-${norm.swolf.good}</small>
                            </div>
                            <div class="progress-bar bg-warning" style="width: 25%">
                                <small>Moyen: ${norm.swolf.good}-${norm.swolf.average}</small>
                            </div>
                            <div class="progress-bar bg-danger" style="width: 25%">
                                <small>À améliorer: ${norm.swolf.average}+</small>
                            </div>
                        </div>
                        <p class="mb-0 small">Votre SWOLF: <strong>${results.adjustedSwolf}</strong> (ajusté 50m)</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Objectifs d'amélioration
function displayImprovementTargets(results, norm) {
    const container = document.getElementById('improvementTargets');
    
    const dpsTarget = Math.min(norm.dps.excellent, results.dps + 0.2);
    const swolfTarget = Math.max(norm.swolf.excellent, results.adjustedSwolf - 5);
    
    container.innerHTML = `
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                DPS Objectif
                <span class="badge bg-primary rounded-pill">${dpsTarget.toFixed(2)}m</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                SWOLF Objectif
                <span class="badge bg-warning rounded-pill">${swolfTarget}</span>
            </li>
            <li class="list-group-item">
                <small class="text-muted">Objectifs réalisables à court terme (4-6 semaines)</small>
            </li>
        </ul>
    `;
}

// Recommandations techniques
function displayTechnicalRecommendations(results, dpsRating, swolfRating, frequencyRating) {
    const container = document.getElementById('technicalRecommendations');
    
    let recommendations = [];
    
    // Recommandations DPS
    if (dpsRating.color === 'danger' || dpsRating.color === 'warning') {
        recommendations.push({
            type: 'DPS - Distance Par Stroke',
            color: 'primary',
            items: [
                'Travaillez la position haute du corps (tête alignée, épaules stables)',
                'Améliorez l\'entrée de main (extension maximale, pénétration propre)',
                'Développez la phase d\'appui (prise d\'eau profonde, avant-bras vertical)',
                'Exercice recommandé: Nage à 3 temps pour maximiser la glisse'
            ]
        });
    }
    
    // Recommandations SWOLF
    if (swolfRating.color === 'danger' || swolfRating.color === 'warning') {
        recommendations.push({
            type: 'SWOLF - Efficacité Globale',
            color: 'warning',
            items: [
                'Travaillez l\'équilibre amplitude/fréquence gestuelle',
                'Améliorez la régularité technique sous effort',
                'Réduisez les efforts parasites (tensions inutiles)',
                'Exercice recommandé: Séries tempo avec métronome'
            ]
        });
    }
    
    // Recommandations fréquence
    if (frequencyRating.color === 'danger' || frequencyRating.color === 'warning') {
        const ideal = getIdealFrequency(results.strokeType, results.distance);
        if (results.frequency > ideal) {
            recommendations.push({
                type: 'Fréquence Gestuelle - Trop Rapide',
                color: 'info',
                items: [
                    'Ralentissez la cadence pour améliorer l\'amplitude',
                    'Travaillez la glisse entre les mouvements',
                    'Concentrez-vous sur la phase de traction complète',
                    'Exercice recommandé: Nage avec temps de pause'
                ]
            });
        } else {
            recommendations.push({
                type: 'Fréquence Gestuelle - Trop Lente',
                color: 'info',
                items: [
                    'Augmentez légèrement la cadence gestuelle',
                    'Travaillez la coordination bras/jambes',
                    'Améliorez le retour aérien des bras',
                    'Exercice recommandé: Sprints courts avec fréquence élevée'
                ]
            });
        }
    }
    
    // Recommandations générales positives
    if (dpsRating.color === 'success' && swolfRating.color === 'success') {
        recommendations.push({
            type: 'Maintien du Niveau',
            color: 'success',
            items: [
                'Excellente technique ! Maintenez cette efficacité',
                'Testez sur des distances plus longues',
                'Travaillez la technique sous fatigue',
                'Continuez les tests réguliers pour suivre la progression'
            ]
        });
    }
    
    // Générer le HTML
    let html = '';
    recommendations.forEach(rec => {
        html += `
            <div class="card border-${rec.color} mb-3">
                <div class="card-header bg-${rec.color} text-white">
                    <h6 class="mb-0">${rec.type}</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        ${rec.items.map(item => `<li class="small">${item}</li>`).join('')}
                    </ul>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Afficher aussi les objectifs d'amélioration
    displayImprovementTargets(results, norms[results.strokeType][results.level][results.gender]);
}

// Affichage des erreurs
function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i><strong>Erreur :</strong> ${message}`;
    errorDiv.classList.remove('d-none');
    document.getElementById('resultsSection').classList.add('d-none');
}

// Réinitialisation du calculateur
function resetCalculator() {
    // Reset des champs de saisie
    document.getElementById('strokeType').value = 'freestyle';
    document.getElementById('distance').value = '50';
    document.getElementById('poolLength').value = '25';
    document.getElementById('timeMinutes').value = '';
    document.getElementById('timeSeconds').value = '';
    document.getElementById('strokeCount').value = '';
    document.getElementById('level').value = 'club';
    document.getElementById('age').value = '';
    document.getElementById('gender').value = 'male';
    
    // Masquer erreurs et résultats
    document.getElementById('errorMessage').classList.add('d-none');
    document.getElementById('resultsSection').classList.add('d-none');
}
</script>
@endpush