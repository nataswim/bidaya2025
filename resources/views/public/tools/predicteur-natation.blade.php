@extends('layouts.public')

@section('title', 'PrÃ©dicteur Performance Natation - Calcul Temps IntermÃ©diaires & Allures')
@section('meta_description', 'PrÃ©dicteur performance natation scientifique. Calcul temps intermÃ©diaires, allures, stratÃ©gies course. Crawl, papillon, brasse, dos, 4 nages. Formules validÃ©es par l\'analyse biomÃ©canique.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            PrÃ©dicteur de Performance Natation
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Outil de prÃ©diction avancÃ© :</strong> Estimez vos temps intermÃ©diaires et stratÃ©gies de course 
                    avec des formules scientifiques validÃ©es par l'analyse biomÃ©canique moderne
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Calculateur de Performance -->
        <div class="card border-0 shadow-lg mb-4" style="background: #006170;">
            <div class="card-header text-white text-center py-4 border-0">
                <h2 class="h3 mb-0 d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-calculator text-warning"></i>
                    Calculateur de Performance
                </h2>
                <p class="mb-0 mt-2 opacity-75">
                    Entrez vos donnÃ©es pour prÃ©dire vos temps de course
                </p>
            </div>

            <div class="card-body p-4" style="background-color: rgba(255, 255, 255, 0.95);">
                
                <!-- Messages d'erreur -->
                <div id="errorMessage" class="alert alert-danger d-none">
                    <!-- Sera rempli par JavaScript -->
                </div>

                <div class="row g-4">
                    <!-- Style de nage -->
                    <div class="col-md-6">
                        <label for="swimmingStyle" class="form-label fw-bold text-primary d-flex align-items-center gap-2">
                            <i class="fas fa-swimmer text-info"></i>
                            Style de nage
                        </label>
                        <select id="swimmingStyle" class="form-select form-select-lg border-primary" style="border-width: 2px;">
                            <option value="crawl">Crawl</option>
                            <option value="papillon">Papillon</option>
                            <option value="brasse">Brasse</option>
                            <option value="dos">Dos</option>
                            <option value="quatre-nages">Quatre Nages</option>
                        </select>
                    </div>

                    <!-- Distance -->
                    <div class="col-md-6">
                        <label for="distance" class="form-label fw-bold text-primary d-flex align-items-center gap-2">
                            <i class="fas fa-ruler text-success"></i>
                            Distance
                        </label>
                        <select id="distance" class="form-select form-select-lg border-success" style="border-width: 2px;">
                            <!-- Sera rempli par JavaScript -->
                        </select>
                    </div>

                    <!-- Temps de rÃ©fÃ©rence (pour styles normaux) -->
                    <div id="normalStyleInputs" class="col-12">
                        <label for="referenceTime" class="form-label fw-bold text-primary d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-clock text-warning"></i>
                            Temps de rÃ©fÃ©rence 50m (en secondes)
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-primary text-white border-primary" style="border-width: 2px;">
                                <i class="fas fa-clock"></i>
                            </span>
                            <input type="number" id="referenceTime" class="form-control border-primary" 
                                   placeholder="Ex: 28.50" min="0" step="0.01" style="border-width: 2px; font-size: 1.2rem;">
                            <span class="input-group-text bg-secondary text-white border-secondary" style="border-width: 2px;">
                                secondes
                            </span>
                        </div>
                    </div>

                    <!-- Temps quatre nages (cachÃ© par dÃ©faut) -->
                    <div id="medleyInputs" class="col-12 d-none">
                        <div class="alert alert-warning border-0 mb-3">
                            <strong>Mode Quatre Nages :</strong> Entrez vos temps pour chaque nage
                        </div>
                        <div id="medleyFields" class="row g-3">
                            <!-- Sera rempli par JavaScript -->
                        </div>
                    </div>

                    <!-- Bouton de calcul -->
                    <div class="col-12 text-center mt-4">
                        <button type="button" class="btn btn-lg px-5 py-3 fw-bold shadow-lg" 
                                onclick="calculatePerformance()"
                                style="background: #dc3545; border: none; border-radius: 0.5rem; color: white; font-size: 1.3rem;">
                            <i class="fas fa-calculator me-2"></i>
                            Calculer mes temps de performance
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RÃ©sultats -->
        <div id="resultsSection" class="d-none">
            <!-- Temps Total -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-trophy me-2"></i>Performance EstimÃ©e
                    </h3>
                </div>
                <div class="card-body text-center">
                    <div class="alert alert-success border-0 py-4">
                        <i class="fas fa-trophy text-warning me-2" style="font-size: 2rem;"></i>
                        <div>
                            <h4 class="fw-bold text-success mb-0">Temps Total PrÃ©dit</h4>
                            <span class="display-5 fw-bold text-success" id="totalTime">--:--:--</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des temps intermÃ©diaires -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header text-white py-3" style="background: #198754;">
                    <h3 class="h4 mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-chart-line text-warning"></i>
                        Allures et Temps IntermÃ©diaires
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="predictionsTable">
                            <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <tr>
                                    <th class="text-center fw-bold py-3">
                                        <i class="fas fa-target text-primary me-2"></i>Fraction
                                    </th>
                                    <th class="text-center fw-bold py-3">
                                        <i class="fas fa-clock text-success me-2"></i>Temps Passage
                                    </th>
                                    <th class="text-center fw-bold py-3">
                                        <i class="fas fa-stopwatch text-info me-2"></i>Chrono (sec)
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="predictionsBody">
                                <!-- Sera rempli par JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notes Importantes -->
<section class="py-5">
    <div class="container">
        
        <div class="card border-0 shadow-sm mb-5" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-info-circle text-primary" style="font-size: 1.5rem;"></i>
                    <h2 class="h4 fw-semibold mb-0 text-primary">
                        Notes Importantes sur les PrÃ©dictions
                    </h2>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Formules basÃ©es sur l'analyse biomÃ©canique et donnÃ©es de performance Ã©lites
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Progression physiologique constante et endurance adaptÃ©e Ã chaque distance
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                SpÃ©cificitÃ©s biomÃ©caniques intÃ©grÃ©es pour chaque style de nage
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Transitions et spÃ©cificitÃ©s considÃ©rÃ©es pour le quatre nages
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Variations individuelles possibles : ±5-8% selon entraînement
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                Conditions optimales supposÃ©es (bassin 50m, eau 26-28°C)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analyse Scientifique -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-flask me-2"></i>
                    Analyse Scientifique de la Performance en Natation
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info border-0">
                    <h6><i class="fas fa-lightbulb me-2"></i>Recherche 2024</h6>
                    <p class="mb-0">
                        L'analyse biomÃ©canique moderne rÃ©vÃ¨le que l'efficacitÃ© propulsive varie de 15-25% entre les styles de nage, 
                        impactant directement les stratÃ©gies de course optimales.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>Facteurs BiomÃ©caniques ClÃ©s par Style</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Style</th>
                                        <th>EfficacitÃ© Propulsive</th>
                                        <th>Coût Ã©nergÃ©tique</th>
                                        <th>FrÃ©quence Optimale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Crawl</strong></td>
                                        <td>85-90%</td>
                                        <td>RÃ©fÃ©rence (100%)</td>
                                        <td>45-65 cycles/min</td>
                                    </tr>
                                    <tr>
                                        <td>Dos crawlÃ©</td>
                                        <td>80-85%</td>
                                        <td>+8-12%</td>
                                        <td>40-60 cycles/min</td>
                                    </tr>
                                    <tr>
                                        <td>Brasse</td>
                                        <td>65-75%</td>
                                        <td>+25-35%</td>
                                        <td>25-35 cycles/min</td>
                                    </tr>
                                    <tr>
                                        <td>Papillon</td>
                                        <td>75-80%</td>
                                        <td>+20-30%</td>
                                        <td>30-45 cycles/min</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Variables Physiologiques Impact Performance</h6>
                        <ul class="small">
                            <li><strong>VO2max spÃ©cifique :</strong> CapacitÃ© aÃ©robie en natation (±15% vs terrestre)</li>
                            <li><strong>Seuil lactique :</strong> IntensitÃ© soutenable sans accumulation</li>
                            <li><strong>Puissance anaÃ©robie :</strong> Sprints et fins de course</li>
                            <li><strong>Ã©conomie gestuelle :</strong> Coût Ã©nergÃ©tique par mÃ¨tre nagÃ©</li>
                            <li><strong>FlexibilitÃ© active :</strong> Amplitude articulaire fonctionnelle</li>
                        </ul>

                        <div class="alert alert-success">
                            <small>
                                <strong>Innovation 2024 :</strong> Les capteurs inertiels sous-marins permettent 
                                une analyse biomÃ©canique prÃ©cise en conditions rÃ©elles de course.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analyse Multidimensionnelle -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-chart-pie me-2"></i>
                    La Performance en Natation : Une Analyse Multidimensionnelle
                </h3>
            </div>
            <div class="card-body">
                <p class="lead">
                    La <strong>performance en natation</strong> est le rÃ©sultat d'une interaction complexe entre des facteurs 
                    biomÃ©caniques, physiologiques, psychologiques et environnementaux. L'efficacitÃ© du mouvement est primordiale 
                    dans ce milieu rÃ©sistant qu'est l'eau.
                </p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>L'ImpÃ©ratif de la Technique</h6>
                        <p class="small">
                            Au cœur de toute <strong>performance en natation</strong> rÃ©side la <strong>technique de nage</strong>. 
                            Une dÃ©faillance technique, même minime, engendre une augmentation significative de la traînÃ©e.
                        </p>
                        <ul class="small">
                            <li><strong>Hydrodynamisme :</strong> Position du corps alignÃ©e, profilÃ©e et stable</li>
                            <li><strong>Propulsion :</strong> Coordination prÃ©cise bras-jambes-tronc</li>
                            <li><strong>Respiration :</strong> Synchronisation sans perturbation de l'Ã©quilibre</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Composantes Physiologiques</h6>
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6 class="card-title small">CapacitÃ©s AÃ©robies</h6>
                                        <p class="card-text small">
                                            VO2 max Ã©levÃ©e et capacitÃ© Ã maintenir une intensitÃ© soutenue sans accumulation excessive de lactate.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6 class="card-title small">CapacitÃ©s AnaÃ©robies</h6>
                                        <p class="card-text small">
                                            Puissance anaÃ©robie et tolÃ©rance au lactate pour les sprints et fins de course.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-3">
                    <div class="col-md-4">
                        <div class="card border-primary h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Dimension Psychologique</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>Concentration et focus technique</li>
                                    <li>Gestion du stress de compÃ©tition</li>
                                    <li>StratÃ©gie de course adaptative</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-info h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">Facteurs Environnementaux</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>TempÃ©rature de l'eau (26-28°C optimal)</li>
                                    <li>QualitÃ© du bassin (turbulences, profondeur)</li>
                                    <li>Conditions de compÃ©tition</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Analyse et Suivi</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>DonnÃ©es d'entraînement rigoureuses</li>
                                    <li>Ã©valuation technique rÃ©guliÃ¨re</li>
                                    <li>Ajustement programmatique continu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success mt-4">
                    <h6><i class="fas fa-check-circle me-2"></i>Principe Fondamental</h6>
                    <p class="mb-0">
                        La performance en natation n'est pas le fruit d'une seule qualitÃ©, mais d'une synergie maîtrisÃ©e entre 
                        technique irrÃ©prochable, condition physique adaptÃ©e, prÃ©paration mentale solide et approche analytique rigoureuse.
                    </p>
                </div>
            </div>
        </div>

        <!-- StratÃ©gies de Course -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-tactic me-2"></i>
                    StratÃ©gies de Course et Optimisation Performance
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>StratÃ©gies de RÃ©partition d'Effort</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Distance</th>
                                        <th>StratÃ©gie Optimale</th>
                                        <th>RÃ©partition</th>
                                        <th>Points ClÃ©s</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>50m</strong></td>
                                        <td>All-out</td>
                                        <td>100% dÃ¨s le dÃ©part</td>
                                        <td>Technique parfaite sous lactate max</td>
                                    </tr>
                                    <tr>
                                        <td>100m</td>
                                        <td>Negative split</td>
                                        <td>48-52%</td>
                                        <td>Contrôle 1er 50m, finish puissant</td>
                                    </tr>
                                    <tr>
                                        <td>200m</td>
                                        <td>Even split</td>
                                        <td>25-25-25-25%</td>
                                        <td>RÃ©gularitÃ© avec finish</td>
                                    </tr>
                                    <tr>
                                        <td>400m+</td>
                                        <td>Progressive</td>
                                        <td>Build-up</td>
                                        <td>MontÃ©e progressive, sprint final</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Technologies d'Analyse Performance 2024</h6>
                        <ul class="small">
                            <li><strong>Capteurs inertiels Ã©tanches :</strong> Analyse 3D en temps rÃ©el</li>
                            <li><strong>CamÃ©ras sous-marines HD :</strong> BiomÃ©canique dÃ©taillÃ©e</li>
                            <li><strong>Lactate portable :</strong> Mesure mÃ©tabolique instantanÃ©e</li>
                            <li><strong>Applications IA :</strong> Correction technique automatisÃ©e</li>
                            <li><strong>Wearables aquatiques :</strong> Monitoring cardiaque prÃ©cis</li>
                        </ul>

                        <h6 class="mt-3">MÃ©triques ClÃ©s Ã Surveiller</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>MÃ©trique</th>
                                        <th>UnitÃ©</th>
                                        <th>Objectif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SWOLF Score</td>
                                        <td>Temps + Coups</td>
                                        <td>Minimiser</td>
                                    </tr>
                                    <tr>
                                        <td>Distance par coup</td>
                                        <td>MÃ¨tres</td>
                                        <td>Maximiser</td>
                                    </tr>
                                    <tr>
                                        <td>FrÃ©quence de bras</td>
                                        <td>Cycles/min</td>
                                        <td>Optimiser</td>
                                    </tr>
                                    <tr>
                                        <td>Temps de glisse</td>
                                        <td>Secondes</td>
                                        <td>Contrôler</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entraînement Moderne -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-dumbbell me-2"></i>
                    Entraînement et PrÃ©paration Moderne
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6>PÃ©riodisation Moderne</h6>
                        <ul class="small">
                            <li><strong>Phase AÃ©robie (12-16 sem) :</strong> Volume, technique, endurance</li>
                            <li><strong>Phase Mixte (6-8 sem) :</strong> Seuil, rÃ©sistance lactique</li>
                            <li><strong>Phase AnaÃ©robie (4-6 sem) :</strong> Vitesse, puissance</li>
                            <li><strong>Phase Affûtage (2-3 sem) :</strong> Maintien + rÃ©cupÃ©ration</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Zones d'Entraînement Natation</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Zone</th>
                                        <th>% VO2max</th>
                                        <th>Lactate</th>
                                        <th>Objectif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Z1</td>
                                        <td>50-60%</td>
                                        <td>&lt;2 mmol/L</td>
                                        <td>RÃ©cupÃ©ration</td>
                                    </tr>
                                    <tr>
                                        <td>Z2</td>
                                        <td>60-70%</td>
                                        <td>2-3 mmol/L</td>
                                        <td>AÃ©robie</td>
                                    </tr>
                                    <tr>
                                        <td>Z3</td>
                                        <td>70-80%</td>
                                        <td>3-4 mmol/L</td>
                                        <td>Seuil</td>
                                    </tr>
                                    <tr>
                                        <td>Z4</td>
                                        <td>80-90%</td>
                                        <td>4-8 mmol/L</td>
                                        <td>VO2max</td>
                                    </tr>
                                    <tr>
                                        <td>Z5</td>
                                        <td>&gt;90%</td>
                                        <td>&gt;8 mmol/L</td>
                                        <td>Neuromusculaire</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>RÃ©cupÃ©ration et RÃ©gÃ©nÃ©ration</h6>
                        <ul class="small">
                            <li><strong>Sommeil :</strong> 8-9h pour nageurs Ã©lites</li>
                            <li><strong>Nutrition :</strong> Hydratation optimale prÃ©/post</li>
                            <li><strong>ThÃ©rapies :</strong> Massage, cryothÃ©rapie, compression</li>
                            <li><strong>MobilitÃ© :</strong> Ã©tirements spÃ©cifiques Ã©paules</li>
                            <li><strong>Mental :</strong> Visualisation, relaxation</li>
                        </ul>

                        <div class="alert alert-warning">
                            <small>
                                <strong>Conseil 2024 :</strong> L'analyse HRV (variabilitÃ© cardiaque) 
                                permet un monitoring prÃ©cis de l'Ã©tat de rÃ©cupÃ©ration quotidien.
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <h6><i class="fas fa-info-circle me-2"></i>Important - SÃ©curitÃ©</h6>
                    <p class="mb-0">
                        Ces prÃ©dictions sont des estimations basÃ©es sur des modÃ¨les scientifiques. Les performances rÃ©elles 
                        peuvent varier selon l'entraînement, les conditions et la forme physique. Consultez un entraîneur 
                        qualifiÃ© pour un programme personnalisÃ©.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section CrÃ©dit et Contact -->
     <div class="card mb-4">
            <a href="{{ route('tools.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Essayer d'autres outils
            </a>
        </div>
<section class="py-5 bg-primary text-white">

    <div class="container">


        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Ã Propos de nos Outils</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">DÃ©veloppement & Expertise</h6>
                        <p class="mb-3">
                            Contenus et outils dÃ©veloppÃ©s par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Expert en sciences du sport, physiologie de l'exercice et dÃ©veloppement 
                            d'outils d'aide Ã la performance sportive evidence-based.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Collaboration & AmÃ©lioration</h6>
                        <p class="mb-3 small">
                            Si vous constatez une erreur dans nos calculateurs ou souhaitez suggÃ©rer 
                            de nouveaux outils, n'hÃ©sitez pas Ã nous contacter.
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
                    <small class="text-light opacity-75">Recherches 2024 intÃ©grÃ©es</small>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- DerniÃ¨res Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-newspaper text-primary me-2"></i>DerniÃ¨res Publications
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

.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script>
// Configuration des styles de nage et distances
const swimmingStyles = {
    'crawl': [100, 200, 400, 800, 1500],
    'papillon': [100, 200],
    'brasse': [100, 200],
    'dos': [100, 200],
    'quatre-nages': [200, 400]
};

// Configuration des champs quatre nages
const medleyFields = {
    200: [
        { key: 'butterfly50m', label: 'Papillon 50m', color: 'danger' },
        { key: 'backstroke50m', label: 'Dos 50m', color: 'warning' },
        { key: 'breaststroke50m', label: 'Brasse 50m', color: 'info' },
        { key: 'freestyle50m', label: 'Crawl 50m', color: 'success' }
    ],
    400: [
        { key: 'butterfly100m', label: 'Papillon 100m', color: 'danger' },
        { key: 'backstroke100m', label: 'Dos 100m', color: 'warning' },
        { key: 'breaststroke100m', label: 'Brasse 100m', color: 'info' },
        { key: 'freestyle100m', label: 'Crawl 100m', color: 'success' }
    ]
};

let medleyTimes = {};

// Formatage du temps (secondes vers MM:SS.CS)
function formatTime(timeInSeconds) {
    const minutes = Math.floor(timeInSeconds / 60);
    const seconds = Math.floor(timeInSeconds % 60);
    const centiseconds = Math.round((timeInSeconds % 1) * 100);
    return `${minutes}:${seconds.toString().padStart(2, '0')}.${centiseconds.toString().padStart(2, '0')}`;
}

// Ajout du pourcentage final
function addFinalPercentage(time) {
    return time * 1.049;
}

// Initialisation des sÃ©lecteurs
function initializeSelectors() {
    const styleSelect = document.getElementById('swimmingStyle');
    const distanceSelect = document.getElementById('distance');
    
    styleSelect.addEventListener('change', updateDistances);
    distanceSelect.addEventListener('change', updateInputs);
    
    updateDistances(); // Initialisation
}

// Mise Ã jour des distances selon le style
function updateDistances() {
    const style = document.getElementById('swimmingStyle').value;
    const distanceSelect = document.getElementById('distance');
    const distances = swimmingStyles[style] || [];
    
    distanceSelect.innerHTML = '';
    distances.forEach(distance => {
        const option = document.createElement('option');
        option.value = distance;
        option.textContent = distance + 'm';
        distanceSelect.appendChild(option);
    });
    
    updateInputs();
}

// Mise Ã jour des champs de saisie
function updateInputs() {
    const style = document.getElementById('swimmingStyle').value;
    const distance = parseInt(document.getElementById('distance').value);
    const normalInputs = document.getElementById('normalStyleInputs');
    const medleyInputs = document.getElementById('medleyInputs');
    
    if (style === 'quatre-nages') {
        normalInputs.classList.add('d-none');
        medleyInputs.classList.remove('d-none');
        setupMedleyFields(distance);
    } else {
        normalInputs.classList.remove('d-none');
        medleyInputs.classList.add('d-none');
    }
}

// Configuration des champs quatre nages
function setupMedleyFields(distance) {
    const fieldsContainer = document.getElementById('medleyFields');
    const fields = medleyFields[distance] || [];
    
    fieldsContainer.innerHTML = '';
    medleyTimes = {};
    
    fields.forEach(field => {
        const col = document.createElement('div');
        col.className = 'col-md-3';
        
        col.innerHTML = `
            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                <i class="fas fa-swimmer text-${field.color}"></i>
                ${field.label}
            </label>
            <input type="number" id="${field.key}" class="form-control form-control-lg border-${field.color}" 
                   placeholder="Temps en sec." min="0" step="0.01" style="border-width: 2px;">
        `;
        
        fieldsContainer.appendChild(col);
        
        // Gestionnaire d'Ã©vÃ©nement
        const input = col.querySelector('input');
        input.addEventListener('input', (e) => {
            medleyTimes[field.key] = e.target.value;
        });
        
        medleyTimes[field.key] = '';
    });
}

// Calcul des prÃ©dictions
function calculatePredictedTimes(style, distance, referenceTime50m) {
    const predictions = [];
    
    if (style === 'quatre-nages') {
        return calculateMedleyPredictions(distance);
    }
    
    const time50m = parseFloat(referenceTime50m);
    const time100m = addFinalPercentage(time50m + 1.5 + (time50m + 2.49));
    
    switch (distance) {
        case 100:
            predictions.push(
                {
                    distance: 50,
                    time: time50m + 1.5,
                    timeFormatted: formatTime(time50m + 1.5),
                    label: "1er 50m"
                },
                {
                    distance: 100,
                    time: addFinalPercentage(time50m + 2.49),
                    timeFormatted: formatTime(addFinalPercentage(time50m + 2.49)),
                    label: "2Ã¨me 50m"
                }
            );
            break;
            
        case 200:
            [2.5, 4.13, 4.53, 2.57].forEach((add, i) => {
                const lapTime = time50m + add;
                const isLast = i === 3;
                const time = isLast ? addFinalPercentage(lapTime) : lapTime;
                predictions.push({
                    distance: (i + 1) * 50,
                    time,
                    timeFormatted: formatTime(time),
                    label: `${i + 1}${i === 0 ? 'er' : 'Ã¨me'} 50m`
                });
            });
            break;
            
        case 400:
            [4.5, 6.13, 6, 2.59].forEach((add, i) => {
                const lapTime = time100m + add;
                const time = i === 3 ? addFinalPercentage(lapTime) : lapTime;
                predictions.push({
                    distance: (i + 1) * 100,
                    time,
                    timeFormatted: formatTime(time),
                    label: `${i + 1}${i === 0 ? 'er' : 'Ã¨me'} 100m`
                });
            });
            break;
            
        case 800:
            [6, 8.5, 8.2, 7.8, 7.5, 7.2, 6.8, 2.1].forEach((add, i) => {
                const lapTime = time100m + add;
                const time = i === 7 ? addFinalPercentage(lapTime) : lapTime;
                predictions.push({
                    distance: (i + 1) * 100,
                    time,
                    timeFormatted: formatTime(time),
                    label: `${i + 1}${i === 0 ? 'er' : 'Ã¨me'} 100m`
                });
            });
            break;
            
        case 1500:
            const splits1500 = [7, 9, 8.8, 8.6, 8.4, 8.2, 8.0, 7.8, 7.6, 7.4, 7.2, 7.0, 6.8, 6.5, 1.8];
            splits1500.forEach((add, i) => {
                const lapTime = time100m + add;
                const time = i === 14 ? addFinalPercentage(lapTime) : lapTime;
                predictions.push({
                    distance: (i + 1) * 100,
                    time,
                    timeFormatted: formatTime(time),
                    label: `${i + 1}${i === 0 ? 'er' : 'Ã¨me'} 100m`
                });
            });
            break;
    }
    
    return predictions;
}

// Calcul spÃ©cifique pour le quatre nages
function calculateMedleyPredictions(distance) {
    const predictions = [];
    const keys = distance === 200 
        ? ['butterfly50m', 'backstroke50m', 'breaststroke50m', 'freestyle50m']
        : ['butterfly100m', 'backstroke100m', 'breaststroke100m', 'freestyle100m'];
    
    const adjustments = distance === 200 
        ? [2.2, 3.09, 5.59, 5.09]
        : [3.2, 6.19, 6, 8.97];
        
    const styles = ['Papillon', 'Dos', 'Brasse', 'Crawl'];
    
    keys.forEach((key, index) => {
        const baseTime = parseFloat(medleyTimes[key]) || 0;
        const lapTime = baseTime + adjustments[index];
        const final = index === keys.length - 1;
        const time = final ? addFinalPercentage(lapTime) : lapTime;
        
        predictions.push({
            distance: (index + 1) * (distance === 400 ? 100 : 50),
            time,
            timeFormatted: formatTime(time),
            label: `${styles[index]} ${index + 1}${index === 0 ? 'er' : 'Ã¨me'} ${distance === 400 ? '100m' : '50m'}`
        });
    });
    
    return predictions;
}

// Calcul du temps total
function calculateTotalTime(predictions) {
    return predictions.reduce((total, pred) => total + pred.time, 0);
}

// Fonction principale de calcul
function calculatePerformance() {
    const style = document.getElementById('swimmingStyle').value;
    const distance = parseInt(document.getElementById('distance').value);
    const errorDiv = document.getElementById('errorMessage');
    
    let predictions = [];
    
    try {
        if (style === 'quatre-nages') {
            // Validation pour quatre nages
            const keys = distance === 200 
                ? ['butterfly50m', 'backstroke50m', 'breaststroke50m', 'freestyle50m']
                : ['butterfly100m', 'backstroke100m', 'breaststroke100m', 'freestyle100m'];
            
            const valid = keys.every(key => medleyTimes[key] && !isNaN(parseFloat(medleyTimes[key])));
            if (!valid) {
                showError(`Veuillez entrer tous les temps pour le ${distance}m Quatre Nages`);
                return;
            }
            
            predictions = calculatePredictedTimes(style, distance, 0);
        } else {
            // Validation pour styles normaux
            const referenceTime = parseFloat(document.getElementById('referenceTime').value);
            if (isNaN(referenceTime) || referenceTime <= 0) {
                showError('Veuillez entrer un temps valide pour le 50m.');
                return;
            }
            
            predictions = calculatePredictedTimes(style, distance, referenceTime);
        }
        
        if (predictions.length === 0) {
            showError('Aucune prÃ©diction n\'a pu être calculÃ©e.');
            return;
        }
        
        // Masquer les erreurs
        errorDiv.classList.add('d-none');
        
        // Calculer et afficher les rÃ©sultats
        const totalTime = calculateTotalTime(predictions);
        displayResults(predictions, totalTime);
        
    } catch (error) {
        console.error('Erreur lors du calcul:', error);
        showError('Une erreur s\'est produite lors du calcul. Veuillez vÃ©rifier vos donnÃ©es.');
    }
}

// Affichage des erreurs
function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i><strong>Erreur :</strong> ${message}`;
    errorDiv.classList.remove('d-none');
    document.getElementById('resultsSection').classList.add('d-none');
}

// Affichage des rÃ©sultats
function displayResults(predictions, totalTime) {
    // Afficher le temps total
    document.getElementById('totalTime').textContent = formatTime(totalTime);
    
    // Remplir le tableau des prÃ©dictions
    const tbody = document.getElementById('predictionsBody');
    tbody.innerHTML = '';
    
    predictions.forEach((pred, index) => {
        const row = document.createElement('tr');
        row.className = index % 2 === 0 ? 'bg-light' : '';
        
        row.innerHTML = `
            <td class="text-center fw-semibold py-3">${pred.label}</td>
            <td class="text-center py-3">
                <span class="badge bg-success fs-6 px-3 py-2">${pred.timeFormatted}</span>
            </td>
            <td class="text-center text-muted py-3">${pred.time.toFixed(2)}</td>
        `;
        
        tbody.appendChild(row);
    });
    
    // Afficher la section rÃ©sultats
    document.getElementById('resultsSection').classList.remove('d-none');
    document.getElementById('resultsSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    initializeSelectors();
});
</script>
@endpush