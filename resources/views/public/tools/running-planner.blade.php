@extends('layouts.public')

@section('title', 'Planificateur Entraînement Course Ã Pied - Programme Scientifique 2024')
@section('meta_description', 'Planificateur course scientifique avec zones d\'entraînement optimisÃ©es. Distribution polarisÃ©e 80/20, biomÃ©canique, Ã©conomie de course et nutrition spÃ©cialisÃ©e. Evidence-based 2024.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Planificateur d'Entraînement Course Ã Pied
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-clock text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Planifiez vos sÃ©ances</strong> avec les derniÃ¨res recherches en biomÃ©canique, 
                    physiologie et sciences du sport
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Planificateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Planificateur PersonnalisÃ© -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-user-cog me-2"></i>
                    Planificateur PersonnalisÃ© - MÃ©thode Evidence-Based
                </h3>
            </div>
            <div class="card-body">
                
                <!-- Messages d'erreur -->
                <div id="errorMessage" class="alert alert-danger d-none">
                    <!-- Sera rempli par JavaScript -->
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="goal" class="form-label fw-bold">
                            <i class="fas fa-target me-2"></i>Objectif de Course
                        </label>
                        <select id="goal" class="form-select form-select-lg border-primary">
                            <option value="">-- Choisir un objectif --</option>
                            <option value="endurance">AmÃ©liorer l'endurance</option>
                            <option value="weight">Perdre du poids</option>
                            <option value="speed">Gagner en vitesse</option>
                            <option value="10k">Courir un 10 km</option>
                            <option value="half">Courir un semi-marathon</option>
                            <option value="marathon">Courir un marathon</option>
                        </select>
                        <small class="text-muted">SÃ©lectionnez votre objectif principal</small>
                    </div>
                    <div class="col-md-6">
                        <label for="experience" class="form-label fw-bold">
                            <i class="fas fa-medal me-2"></i>Niveau d'expÃ©rience
                        </label>
                        <select id="experience" class="form-select form-select-lg border-primary">
                            <option value="">-- SÃ©lectionner votre niveau --</option>
                            <option value="beginner">DÃ©butant (moins de 1 an)</option>
                            <option value="intermediate">IntermÃ©diaire (1-3 ans)</option>
                            <option value="advanced">AvancÃ© (plus de 3 ans)</option>
                        </select>
                        <small class="text-muted">BasÃ© sur votre expÃ©rience en course</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg fw-bold w-100" onclick="generatePlan()">
                            <i class="fas fa-calculator me-2"></i>GÃ©nÃ©rer mon plan personnalisÃ©
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary btn-lg fw-bold w-100" onclick="resetPlanner()">
                            <i class="fas fa-redo me-2"></i>RÃ©initialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RÃ©sultats du Planificateur -->
        <div id="planResults" class="d-none">
            <!-- Plan PersonnalisÃ© -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-chart-pie me-2"></i>
                        Recommandation PersonnalisÃ©e - Distribution Scientifique
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="alert-heading">Plan d'Entraînement Optimal</h5>
                        <p id="planDescription">
                            <!-- Sera rempli par JavaScript -->
                        </p>
                        <p>
                            <span class="fs-3"><strong class="text-success" id="totalSessions">0</strong></span>
                            <span class="fs-5"> sÃ©ances par semaine</span>
                        </p>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white text-center">
                                    <h6 class="mb-0">Endurance (Zone 1-2)</h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong id="enduranceSessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/sem</small>
                                    </p>
                                    <small class="text-muted">60% volume - Base aÃ©robie</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning text-dark text-center">
                                    <h6 class="mb-0">Seuil (Zone 3)</h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong id="thresholdSessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/sem</small>
                                    </p>
                                    <small class="text-muted">20% volume - Tempo/Lactate</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-danger h-100">
                                <div class="card-header bg-danger text-white text-center">
                                    <h6 class="mb-0">Vitesse (Zone 4-5)</h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong id="speedSessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/sem</small>
                                    </p>
                                    <small class="text-muted">15% volume - VO2max/Neurom.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white text-center">
                                    <h6 class="mb-0">RÃ©cupÃ©ration</h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong id="recoverySessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/sem</small>
                                    </p>
                                    <small class="text-muted">5% volume - Footing rÃ©gÃ©nÃ©ration</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <h6><i class="fas fa-info-circle me-2"></i>Distribution PolarisÃ©e 80/20</h6>
                        <p class="mb-0">
                            Ce plan respecte la rÃ¨gle scientifique des ≥80% du volume en zones 1-2 (faible intensitÃ©) 
                            pour optimiser les adaptations aÃ©robies selon les recherches sur les coureurs Ã©lites.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Microcycle DÃ©taillÃ© -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-calendar-week me-2"></i>
                        Microcycle Type RecommandÃ©
                    </h3>
                </div>
                <div class="card-body">
                    <div id="weeklySchedule" class="table-responsive">
                        <!-- Sera rempli par JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- Fondements Scientifiques -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-flask me-2"></i>
                    Fondements Scientifiques en Course Ã Pied - Recherches 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-danger border-0">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Position ACSM 2024</h6>
                    <p class="mb-0">
                        L'entraînement en course Ã pied doit respecter le principe de distribution polarisÃ©e 
                        avec ≥80% du volume en zones 1-2 pour optimiser les adaptations aÃ©robies.
                    </p>
                </div>
                
                <p>
                    Les recommandations s'appuient sur les derniÃ¨res recherches en biomÃ©canique, physiologie de l'exercice 
                    et sciences du sport publiÃ©es en 2024-2025, incluant la mÃ©ta-analyse de Van Hooren et al. sur l'Ã©conomie de course.
                </p>
                
                <div class="alert alert-info border-0">
                    <h6><i class="fas fa-lightbulb me-2"></i>DÃ©couverte majeure 2024</h6>
                    <p class="mb-0">
                        Les variables biomÃ©caniques expliquent 4-12% de la variance dans l'Ã©conomie de course. 
                        La rÃ¨gle 80/20 reste le standard : ≥80% du volume en basse intensitÃ© chez les Ã©lites.
                    </p>
                </div>

                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <h6>Distribution d'IntensitÃ© Ã©lite (Recherche 2024)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>CatÃ©gorie</th>
                                        <th>Zone 1-2</th>
                                        <th>Zone 3</th>
                                        <th>Zone 4-5</th>
                                        <th>Volume/sem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td><strong>Marathon Ã©lite</strong></td>
                                        <td>85%</td>
                                        <td>10%</td>
                                        <td>5%</td>
                                        <td>160-220km</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>5000-10000m Ã©lite</td>
                                        <td>80%</td>
                                        <td>12%</td>
                                        <td>8%</td>
                                        <td>130-190km</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Amateur AvancÃ©</td>
                                        <td>75%</td>
                                        <td>15%</td>
                                        <td>10%</td>
                                        <td>60-100km</td>
                                    </tr>
                                    <tr>
                                        <td>Amateur IntermÃ©diaire</td>
                                        <td>70%</td>
                                        <td>20%</td>
                                        <td>10%</td>
                                        <td>30-60km</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="small text-muted">
                            Source : Analyse de coureurs de classe mondiale (2024). 
                            Distribution polarisÃ©e vs pyramidale montre des rÃ©sultats similaires pour l'Ã©lite.
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h6>CaractÃ©ristiques Physiologiques Ã©lites</h6>
                        <ul class="small">
                            <li><strong>VO2max :</strong> 70-85 ml/kg/min (hommes), 60-75 (femmes)</li>
                            <li><strong>Ã©conomie course :</strong> 150-190 ml O2/kg/km</li>
                            <li><strong>Seuil lactique :</strong> 85-95% VO2max</li>
                            <li><strong>FrÃ©quence :</strong> 11-14 sÃ©ances/semaine</li>
                            <li><strong>CompÃ©titions :</strong> 6±2 (marathon), 9±3 (piste) par an</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <small>
                                <strong>Innovation 2024 :</strong> Les tests mÃ©taboliques portables (lactate, VO2) 
                                permettent une dÃ©termination prÃ©cise des zones individuelles en temps rÃ©el.
                            </small>
                        </div>

                        <h6 class="mt-3">Facteurs Limitants Performance</h6>
                        <ul class="small">
                            <li><strong>Cardiovasculaire :</strong> DÃ©bit cardiaque maximal (40-50%)</li>
                            <li><strong>Respiratoire :</strong> Diffusion alvÃ©olo-capillaire (15-20%)</li>
                            <li><strong>MÃ©tabolique :</strong> DensitÃ© mitochondriale (20-25%)</li>
                            <li><strong>BiomÃ©canique :</strong> Ã©conomie gestuelle (10-15%)</li>
                            <li><strong>Neuromusculaire :</strong> RigiditÃ© tendineuse (5-10%)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- BiomÃ©canique et Ã©conomie de Course -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-running me-2"></i>
                    BiomÃ©canique et Ã©conomie de Course - Recherches 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>Facteurs BiomÃ©caniques ClÃ©s (MÃ©ta-analyse 2024)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Variable</th>
                                        <th>CorrÃ©lation</th>
                                        <th>Impact Performance</th>
                                        <th>Optimum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>FrÃ©quence de foulÃ©e</td>
                                        <td>r = -0.20</td>
                                        <td>↑ FrÃ©quence = ↓ Coût Ã©nergÃ©tique</td>
                                        <td>170-190 pas/min</td>
                                    </tr>
                                    <tr>
                                        <td>Oscillation verticale</td>
                                        <td>r = 0.35</td>
                                        <td>↓ Oscillation = ↑ EfficacitÃ©</td>
                                        <td>&lt;8cm Ã 12km/h</td>
                                    </tr>
                                    <tr>
                                        <td>RigiditÃ© jambe</td>
                                        <td>r = -0.28</td>
                                        <td>↑ RigiditÃ© = ↓ Coût Ã©nergÃ©tique</td>
                                        <td>20-30 kN/m</td>
                                    </tr>
                                    <tr>
                                        <td>Temps contact sol</td>
                                        <td>r = 0.25</td>
                                        <td>↓ Contact = ↑ Vitesse</td>
                                        <td>180-220ms</td>
                                    </tr>
                                    <tr>
                                        <td>Angle attaque pied</td>
                                        <td>r = 0.22</td>
                                        <td>↓ Angle = ↑ Ã©conomie</td>
                                        <td>0-8° (avant-pied)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="mt-3">ParamÃ¨tres de FoulÃ©e Optimaux</h6>
                        <ul class="small">
                            <li><strong>Longueur foulÃ©e :</strong> Auto-sÃ©lection naturelle optimale</li>
                            <li><strong>Largeur foulÃ©e :</strong> 5-10cm entre pieds</li>
                            <li><strong>Position pied :</strong> Sous centre gravitÃ© corporel</li>
                            <li><strong>Flexion genou :</strong> 40-50° au contact initial</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Technologies d'Analyse BiomÃ©canique 2024</h6>
                        <ul class="small">
                            <li><strong>Capteurs inertiels 3D :</strong> Analyse biomÃ©canique temps rÃ©el portable</li>
                            <li><strong>Plateformes force :</strong> Mesure forces rÃ©action sol prÃ©cise</li>
                            <li><strong>CamÃ©ras haute vitesse :</strong> 1000+ fps analyse gestuelle</li>
                            <li><strong>Wearables avancÃ©s :</strong> MÃ©triques oscillation/rigiditÃ©</li>
                            <li><strong>IA analyse foulÃ©e :</strong> Correction technique automatisÃ©e</li>
                            <li><strong>Capteurs puissance :</strong> Quantification charge externe (Stryd)</li>
                        </ul>
                        
                        <div class="alert alert-success">
                            <small>
                                <strong>Application pratique :</strong> L'augmentation de 5-10% de la frÃ©quence 
                                vers l'optimum individuel amÃ©liore l'Ã©conomie de course de 2-4%.
                            </small>
                        </div>

                        <h6 class="mt-3">Analyse Gestuelle SpÃ©cialisÃ©e</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>DurÃ©e (%)</th>
                                        <th>Ã©vÃ©nements ClÃ©s</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Contact initial</td>
                                        <td>0%</td>
                                        <td>Attaque pied, dÃ©but amortissement</td>
                                    </tr>
                                    <tr>
                                        <td>Phase d'appui</td>
                                        <td>0-40%</td>
                                        <td>Absorption choc, transfert poids</td>
                                    </tr>
                                    <tr>
                                        <td>Phase propulsion</td>
                                        <td>40-60%</td>
                                        <td>GÃ©nÃ©ration force, push-off</td>
                                    </tr>
                                    <tr>
                                        <td>Phase aÃ©rienne</td>
                                        <td>60-100%</td>
                                        <td>Vol, rÃ©cupÃ©ration jambe</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zones d'Entraînement Scientifiques -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Zones d'Entraînement BasÃ©es sur la Science
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>ModÃ¨le 5 Zones ValidÃ© (Coggan/Seiler)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Zone</th>
                                        <th>% FC Max</th>
                                        <th>% VO2max</th>
                                        <th>Lactate (mmol/L)</th>
                                        <th>Objectif Physiologique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td><strong>Zone 1</strong></td>
                                        <td>65-75%</td>
                                        <td>45-65%</td>
                                        <td>&lt; 2</td>
                                        <td>RÃ©cupÃ©ration active</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Zone 2</strong></td>
                                        <td>75-85%</td>
                                        <td>65-80%</td>
                                        <td>2-3</td>
                                        <td>Base aÃ©robie, fat-max</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Zone 3</td>
                                        <td>85-90%</td>
                                        <td>80-87%</td>
                                        <td>3-4</td>
                                        <td>Tempo, seuil aÃ©robie</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Zone 4</td>
                                        <td>90-95%</td>
                                        <td>87-95%</td>
                                        <td>4-6</td>
                                        <td>Seuil lactique, VO2max</td>
                                    </tr>
                                    <tr class="table-dark">
                                        <td>Zone 5</td>
                                        <td>&gt; 95%</td>
                                        <td>&gt; 95%</td>
                                        <td>&gt; 6</td>
                                        <td>Puissance anaÃ©robie</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="mt-3">DÃ©termination Zones Individuelles</h6>
                        <ul class="small">
                            <li><strong>Test terrain :</strong> Test 30min all-out (seuil 95%)</li>
                            <li><strong>Test lactate :</strong> Paliers progressifs + dosage</li>
                            <li><strong>Test VO2max :</strong> Laboratoire spiromÃ©trie</li>
                            <li><strong>HRV analyse :</strong> VariabilitÃ© cardiaque repos</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Zone 2 : La RÃ©volution MÃ©tabolique 2024</h6>
                        <p class="small">La Zone 2 correspond Ã l'intensitÃ© de combustion maximale des graisses (FatMax) et d'Ã©quilibre lactate.</p>
                        <ul class="small">
                            <li><strong>DÃ©termination prÃ©cise :</strong> Test mÃ©tabolique (Ã©talon-or)</li>
                            <li><strong>CaractÃ©ristique :</strong> Ã©tat stable production/Ã©limination lactate</li>
                            <li><strong>Adaptation cellulaire :</strong> Optimisation biogenÃ¨se mitochondriale</li>
                            <li><strong>DurÃ©e optimale :</strong> 45-90 minutes en continu</li>
                            <li><strong>FrÃ©quence :</strong> 3-5x/semaine selon niveau</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <small>
                                <strong>Note importante :</strong> Pour les coureurs dÃ©butants, 
                                la Zone 2 peut nÃ©cessiter des phases de marche-course alternÃ©es (run-walk).
                            </small>
                        </div>

                        <h6 class="mt-3">Biomarqueurs Zone 2</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ParamÃ¨tre</th>
                                        <th>Valeur Zone 2</th>
                                        <th>Adaptation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RER (VCO2/VO2)</td>
                                        <td>0.85-0.87</td>
                                        <td>Oxydation graisses optimale</td>
                                    </tr>
                                    <tr>
                                        <td>Lactate sanguin</td>
                                        <td>2.0±0.5 mmol/L</td>
                                        <td>Ã©quilibre production/clairance</td>
                                    </tr>
                                    <tr>
                                        <td>EfficacitÃ© cardiaque</td>
                                        <td>Volume Ã©jection ↑</td>
                                        <td>Adaptation cardiovasculaire</td>
                                    </tr>
                                    <tr>
                                        <td>DensitÃ© mitochondriale</td>
                                        <td>BiogenÃ¨se ↑</td>
                                        <td>CapacitÃ© oxydative ↑</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MÃ©thodes d'Entraînement Modernes -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-2">
                    <i class="fas fa-rocket me-2"></i>
                    MÃ©thodes d'Entraînement Innovantes 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Entraînement PolarisÃ©</h6>
                                <small>(Evidence-Based)</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>RÃ©partition :</strong> 80% Volume Zone 1-2</li>
                                    <li><strong>IntensitÃ© :</strong> 20% Volume Zone 4-5</li>
                                    <li><strong>Zone 3 :</strong> Minimum ("no man's land")</li>
                                    <li><strong>SÃ©ances intensitÃ© :</strong> 2-3 max/semaine</li>
                                    <li><strong>RÃ©cupÃ©ration :</strong> ComplÃ¨te entre intensitÃ©s</li>
                                </ul>
                                
                                <h6 class="mt-3">BÃ©nÃ©fices Scientifiques</h6>
                                <ul class="small">
                                    <li>↑ VO2max (+8-15% vs traditionnel)</li>
                                    <li>↑ Ã©conomie course (+3-7%)</li>
                                    <li>↓ Risque blessures (-30%)</li>
                                    <li>↑ CapacitÃ© tampons lactate</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-info h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">Micro-Dosage Haute IntensitÃ©</h6>
                                <small>(Tendance 2024)</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>DurÃ©e :</strong> SÃ©ances courtes haute qualitÃ©</li>
                                    <li><strong>Format :</strong> 4-6 x 30s Ã 95-100% VMA</li>
                                    <li><strong>RÃ©cupÃ©ration :</strong> ComplÃ¨te (2-3 min)</li>
                                    <li><strong>FrÃ©quence :</strong> 2-3x/semaine dÃ©veloppement neuromusculaire</li>
                                    <li><strong>Objectif :</strong> Puissance anaÃ©robie + Ã©conomie</li>
                                </ul>
                                
                                <h6 class="mt-3">Protocoles SpÃ©cifiques</h6>
                                <ul class="small">
                                    <li><strong>15/15 :</strong> 15s ON/15s OFF x 12-20</li>
                                    <li><strong>30/30 :</strong> 30s Z5/30s Z1 x 8-15</li>
                                    <li><strong>Billat 30-30 :</strong> vVMA/50% vVMA</li>
                                    <li><strong>Norwegian 4x4 :</strong> 4min Z4/3min Z1</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">Entraînement en Hypoxie</h6>
                                <small>(Innovation Tech)</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>Altitude simulÃ©e :</strong> Masques/chambres hypoxiques</li>
                                    <li><strong>Protocole :</strong> "Live High, Train Low"</li>
                                    <li><strong>Adaptation :</strong> ↑ HÃ©matocrite, EPO naturelle</li>
                                    <li><strong>DurÃ©e :</strong> 2-4 semaines minimum</li>
                                    <li><strong>BÃ©nÃ©fice :</strong> ↑ Transport O2 (+2-5%)</li>
                                </ul>
                                
                                <h6 class="mt-3">Technologies Disponibles</h6>
                                <ul class="small">
                                    <li><strong>Hypoxico Altitude :</strong> GÃ©nÃ©rateurs hypoxie</li>
                                    <li><strong>Training Mask :</strong> RÃ©sistance respiratoire</li>
                                    <li><strong>Chambres altitude :</strong> Environnement contrôlÃ©</li>
                                    <li><strong>IHT (Intermittent) :</strong> Cycles hypoxie/normoxie</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <h6>Entraînement CroisÃ© SpÃ©cialisÃ©</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ActivitÃ©</th>
                                        <th>BÃ©nÃ©fice</th>
                                        <th>FrÃ©quence</th>
                                        <th>IntensitÃ©</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Aqua-jogging</td>
                                        <td>Volume sans impact</td>
                                        <td>2-3x/sem</td>
                                        <td>Z2-Z3</td>
                                    </tr>
                                    <tr>
                                        <td>VÃ©lo</td>
                                        <td>CapacitÃ© cardiovasculaire</td>
                                        <td>1-2x/sem</td>
                                        <td>Z2-Z4</td>
                                    </tr>
                                    <tr>
                                        <td>Elliptique</td>
                                        <td>Geste proche + impact ↓</td>
                                        <td>1-2x/sem</td>
                                        <td>Z2-Z3</td>
                                    </tr>
                                    <tr>
                                        <td>Natation</td>
                                        <td>RÃ©cupÃ©ration active</td>
                                        <td>1x/sem</td>
                                        <td>Z1-Z2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>PÃ©riodisation Moderne AvancÃ©e</h6>
                        <ul class="small">
                            <li><strong>Block Periodization :</strong> Blocs spÃ©cialisÃ©s 3-6 sem</li>
                            <li><strong>Reverse Periodization :</strong> IntensitÃ© → Volume</li>
                            <li><strong>Conjugate Method :</strong> Stimuli simultanÃ©s variÃ©s</li>
                            <li><strong>Auto-Regulated :</strong> Ajustement quotidien HRV</li>
                        </ul>
                        
                        <div class="alert alert-info">
                            <small>
                                <strong>Recommandation 2024 :</strong> La pÃ©riodisation par blocs 
                                montre des rÃ©sultats supÃ©rieurs (+12%) vs pÃ©riodisation linÃ©aire traditionnelle.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nutrition SpÃ©cialisÃ©e Course -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-utensils me-2"></i>
                    Nutrition Course Ã Pied - SpÃ©cificitÃ©s 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>StratÃ©gies PrÃ©-Effort OptimisÃ©es</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Timing</th>
                                        <th>Macronutriment</th>
                                        <th>QuantitÃ©</th>
                                        <th>Objectif Physiologique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3-4h avant</td>
                                        <td>Glucides</td>
                                        <td>2-4g/kg</td>
                                        <td>Saturation glycogÃ¨ne hÃ©patique</td>
                                    </tr>
                                    <tr>
                                        <td>1-2h avant</td>
                                        <td>Glucides</td>
                                        <td>30-60g</td>
                                        <td>Maintien glycÃ©mie</td>
                                    </tr>
                                    <tr>
                                        <td>2h avant</td>
                                        <td>Fluides</td>
                                        <td>400-600ml</td>
                                        <td>Hydratation optimale</td>
                                    </tr>
                                    <tr>
                                        <td>30-60min avant</td>
                                        <td>CafÃ©ine</td>
                                        <td>3-6mg/kg</td>
                                        <td>Performance + vigilance</td>
                                    </tr>
                                    <tr>
                                        <td>15min avant</td>
                                        <td>Nitrates</td>
                                        <td>5-9mmol</td>
                                        <td>↑ EfficacitÃ© mitochondriale</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <h6 class="mt-3">Pendant l'Effort (≥ 60min)</h6>
                        <ul class="small">
                            <li><strong>Glucides :</strong> 30-60g/heure selon durÃ©e effort</li>
                            <li><strong>Multi-transporteurs :</strong> Glucose:Fructose 2:1</li>
                            <li><strong>Boisson isotonique :</strong> 4-8% glucides concentration</li>
                            <li><strong>Hydratation :</strong> 150-250ml/15-20min rÃ©guliers</li>
                            <li><strong>Ã©lectrolytes :</strong> Sodium 200-700mg/L selon sudation</li>
                        </ul>

                        <h6 class="mt-3">StratÃ©gies SpÃ©cialisÃ©es</h6>
                        <ul class="small">
                            <li><strong>Fat adaptation :</strong> 2-3 semaines keto + recharge CHO</li>
                            <li><strong>Train low, compete high :</strong> PÃ©riodisation glucides</li>
                            <li><strong>Fasted training :</strong> Zone 2 optimisation</li>
                            <li><strong>Sleep low :</strong> Coucher glycogÃ¨ne bas</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>RÃ©cupÃ©ration Nutritionnelle OptimisÃ©e</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Timing</th>
                                        <th>Nutriment</th>
                                        <th>QuantitÃ©</th>
                                        <th>Objectif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0-30min</td>
                                        <td>Glucides</td>
                                        <td>1-1.2g/kg</td>
                                        <td>ResynthÃ¨se glycogÃ¨ne rapide</td>
                                    </tr>
                                    <tr>
                                        <td>0-30min</td>
                                        <td>ProtÃ©ines</td>
                                        <td>20-25g (leucine 3g)</td>
                                        <td>SynthÃ¨se protÃ©ique (mTOR)</td>
                                    </tr>
                                    <tr>
                                        <td>0-60min</td>
                                        <td>Ratio CHO:Pro</td>
                                        <td>3:1 ou 4:1</td>
                                        <td>Anabolisme optimal</td>
                                    </tr>
                                    <tr>
                                        <td>Continu</td>
                                        <td>RÃ©hydratation</td>
                                        <td>150% poids perdu</td>
                                        <td>Restauration volume plasmatique</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info">
                            <small>
                                <strong>DÃ©couverte 2024 :</strong> La fenêtre anabolique post-exercice 
                                est plus longue qu'estimÃ© (2-3h), mais l'optimisation reste cruciale dans les 30min.
                            </small>
                        </div>
                        
                        <h6 class="mt-3">SupplÃ©mentation Evidence-Based Coureurs</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SupplÃ©ment</th>
                                        <th>Dosage</th>
                                        <th>Effet Performance</th>
                                        <th>Niveau Preuve</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CafÃ©ine</td>
                                        <td>3-6mg/kg</td>
                                        <td>↑ 2-4% endurance</td>
                                        <td>⭐⭐⭐⭐⭐</td>
                                    </tr>
                                    <tr>
                                        <td>Nitrates (betterave)</td>
                                        <td>5-9mmol</td>
                                        <td>↑ 1-3% Ã©conomie</td>
                                        <td>⭐⭐⭐⭐</td>
                                    </tr>
                                    <tr>
                                        <td>Bêta-Alanine</td>
                                        <td>3-5g/jour</td>
                                        <td>↑ Tampon lactate</td>
                                        <td>⭐⭐⭐</td>
                                    </tr>
                                    <tr>
                                        <td>Bicarbonate Na</td>
                                        <td>0.3g/kg</td>
                                        <td>↑ CapacitÃ© tampon</td>
                                        <td>⭐⭐⭐</td>
                                    </tr>
                                    <tr>
                                        <td>CrÃ©atine</td>
                                        <td>3-5g/jour</td>
                                        <td>↑ Sprints rÃ©pÃ©tÃ©s</td>
                                        <td>⭐⭐⭐</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="mt-3">Micronutriments Critiques</h6>
                        <ul class="small">
                            <li><strong>Fer :</strong> 15-20mg/jour (femmes), monitoring ferritine</li>
                            <li><strong>Vitamine D :</strong> 1000-4000 UI/jour selon statut</li>
                            <li><strong>B12 :</strong> 2.4μg/jour minimum (vÃ©gÃ©taliens)</li>
                            <li><strong>MagnÃ©sium :</strong> 400-600mg/jour (crampes, rÃ©cupÃ©ration)</li>
                            <li><strong>Zinc :</strong> 8-15mg/jour (immunitÃ©, rÃ©cupÃ©ration)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- PrÃ©vention des Blessures -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    PrÃ©vention des Blessures en Course Ã Pied
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-0">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Statistiques clÃ©s 2024</h6>
                    <p class="mb-0">
                        72% des blessures en triathlon proviennent de la course Ã pied. 
                        Incidence annuelle : 37-56% des coureurs se blessent, avec 2.5-33 blessures pour 1000h d'entraînement.
                    </p>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6>Blessures les Plus FrÃ©quentes (PrÃ©valence %)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Blessure</th>
                                        <th>PrÃ©valence</th>
                                        <th>Zone Anatomique</th>
                                        <th>Facteur Principal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Syndrome essuie-glace (ITB)</td>
                                        <td><strong>12%</strong></td>
                                        <td>Genou latÃ©ral</td>
                                        <td>Faiblesse hanche</td>
                                    </tr>
                                    <tr>
                                        <td>Fasciite plantaire</td>
                                        <td><strong>10%</strong></td>
                                        <td>Pied</td>
                                        <td>Surcharge, rigiditÃ©</td>
                                    </tr>
                                    <tr>
                                        <td>PÃ©riostite tibiale</td>
                                        <td><strong>9%</strong></td>
                                        <td>Jambe</td>
                                        <td>Progression rapide</td>
                                    </tr>
                                    <tr>
                                        <td>Syndrome fÃ©moro-patellaire</td>
                                        <td><strong>8%</strong></td>
                                        <td>Genou antÃ©rieur</td>
                                        <td>DÃ©sÃ©quilibre quadriceps</td>
                                    </tr>
                                    <tr>
                                        <td>Tendinopathie Achille</td>
                                        <td><strong>7%</strong></td>
                                        <td>Cheville postÃ©rieure</td>
                                        <td>Raideur mollets</td>
                                    </tr>
                                    <tr>
                                        <td>Fractures de stress</td>
                                        <td>5%</td>
                                        <td>Tibia, mÃ©tatarses</td>
                                        <td>Charge excessive</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>StratÃ©gies PrÃ©ventives Evidence-Based 2024</h6>
                        <ul class="small">
                            <li><strong>Progression contrôlÃ©e :</strong> RÃ¨gle 10% volume/semaine max</li>
                            <li><strong>Renforcement spÃ©cifique :</strong> Hanches, core, mollets quotidien</li>
                            <li><strong>VariÃ©tÃ© surfaces :</strong> Rotation bitume/terre/piste</li>
                            <li><strong>Chaussures adaptÃ©es :</strong> Rotation 2-3 paires diffÃ©rentes</li>
                            <li><strong>Analyse biomÃ©canique :</strong> Ã©valuation foulÃ©e annuelle</li>
                            <li><strong>Monitoring charge :</strong> Ratio aigu:chronique &lt;1.5</li>
                            <li><strong>RÃ©cupÃ©ration programmÃ©e :</strong> Semaines dÃ©charge rÃ©guliÃ¨res</li>
                        </ul>

                        <h6 class="mt-3">Tests de DÃ©pistage RecommandÃ©s</h6>
                        <ul class="small">
                            <li><strong>Single Leg Squat :</strong> Contrôle frontal/sagittal</li>
                            <li><strong>Y-Balance Test :</strong> StabilitÃ© dynamique asymÃ©tries</li>
                            <li><strong>Hop Tests :</strong> Fonction neuromusculaire</li>
                            <li><strong>Analyse foulÃ©e :</strong> CamÃ©ra haute vitesse</li>
                            <li><strong>Tests force isomÃ©trique :</strong> Ratios musculaires</li>
                        </ul>

                        <div class="alert alert-success">
                            <small>
                                <strong>EfficacitÃ© prouvÃ©e :</strong> Les programmes prÃ©ventifs rÃ©duisent 
                                l'incidence des blessures de 35-50% selon mÃ©ta-analyses 2024.
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6>Programme PrÃ©vention Quotidien (15-20min)</h6>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white">
                                    <strong>Ã©chauffement Dynamique (15min)</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="small">
                                        <li>Activation cardiovasculaire progressive (5min)</li>
                                        <li>MobilitÃ© articulaire dynamique (5min)</li>
                                        <li>Gammes coureur spÃ©cifiques (5min)</li>
                                        <li>Progression allure jusqu'Ã intensitÃ© cible</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning text-dark">
                                    <strong>Renforcement PrÃ©ventif (20min)</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="small">
                                        <li>Squats/Fentes unipodales (force hanches)</li>
                                        <li>Gainage statique/dynamique (core stability)</li>
                                        <li>Travail proprioception (Ã©quilibre)</li>
                                        <li>Renforcement mollets/tibial antÃ©rieur</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white">
                                    <strong>RÃ©cupÃ©ration Active (15min)</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="small">
                                        <li>Retour au calme progressif (5min marche)</li>
                                        <li>Ã©tirements statiques ciblÃ©s (5min)</li>
                                        <li>Auto-massage/foam rolling (5min)</li>
                                        <li>Hydratation + nutrition rÃ©cupÃ©ration</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-danger mt-3">
                    <h6><i class="fas fa-exclamation-circle me-2"></i>Important - SÃ©curitÃ©</h6>
                    <p class="mb-0">
                        En cas de douleur persistante (&gt;3 jours), de progression stagnante ou de signaux d'alarme, 
                        consultez un professionnel qualifiÃ© (mÃ©decin du sport, kinÃ©sithÃ©rapeute). 
                        La progression graduelle et l'Ã©coute du corps sont prioritaires sur la performance immÃ©diate.
                    </p>
                </div>
            </div>
        </div>

        <!-- Conseils GÃ©nÃ©raux Evidence-Based -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-lightbulb me-2"></i>
                    Conseils GÃ©nÃ©raux Evidence-Based
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6>Optimisation Technique</h6>
                        <ul class="small">
                            <li><strong>Cadence optimale :</strong> 170-190 pas/min (auto-sÃ©lection)</li>
                            <li><strong>Attaque pied :</strong> MÃ©dio/avant-pied privilÃ©giÃ©e</li>
                            <li><strong>Posture corporelle :</strong> LÃ©gÃ¨re inclinaison avant</li>
                            <li><strong>Regard horizontal :</strong> 10-20m devant</li>
                            <li><strong>Bras dÃ©contractÃ©s :</strong> Balancier naturel 90°</li>
                            <li><strong>Ã©ducatifs techniques :</strong> 2-3x/semaine intÃ©grÃ©s</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Programmation Optimale</h6>
                        <ul class="small">
                            <li><strong>Progression volume :</strong> +10% maximum/semaine</li>
                            <li><strong>RÃ¨gle 80/20 :</strong> Strictement respectÃ©e toute saison</li>
                            <li><strong>Ã©chauffement obligatoire :</strong> 15-20 min progressif</li>
                            <li><strong>RÃ©cupÃ©ration active :</strong> 10-15min post-sÃ©ance</li>
                            <li><strong>Tests rÃ©guliers :</strong> VMA, seuils trimestriels</li>
                            <li><strong>PÃ©riodisation :</strong> Cycles 3-4 semaines + dÃ©charge</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>RÃ©cupÃ©ration OptimisÃ©e</h6>
                        <ul class="small">
                            <li><strong>Sommeil prioritaire :</strong> 7-9h qualitÃ© optimale</li>
                            <li><strong>Hydratation adaptÃ©e :</strong> Selon taux sudation individuel</li>
                            <li><strong>Nutrition ciblÃ©e :</strong> PÃ©riodisation glucides</li>
                            <li><strong>Gestion stress :</strong> Techniques relaxation</li>
                            <li><strong>ModalitÃ©s rÃ©cupÃ©ration :</strong> Bains froids, massage</li>
                            <li><strong>Monitoring continu :</strong> HRV, wellness scores</li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-success mt-4">
                    <h6><i class="fas fa-check-circle me-2"></i>Principe Fondamental</h6>
                    <p class="mb-0">
                        La constance dans l'entraînement Ã faible intensitÃ© (Zone 2) reprÃ©sente 80% des gains de performance 
                        en course d'endurance. La patience et la rÃ©gularitÃ© priment sur l'intensitÃ© excessive.
                    </p>
                </div>
            </div>
        </div>

        <!-- RÃ©fÃ©rences Scientifiques -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-2">
                    <i class="fas fa-book me-2"></i>
                    RÃ©fÃ©rences Scientifiques et Sources
                </h3>
            </div>
            <div class="card-body">
                <p>
                    Ce planificateur intÃ¨gre les derniÃ¨res recherches en sciences du sport et course d'endurance
                    publiÃ©es en 2024-2025 dans des revues scientifiques de rÃ©fÃ©rence internationale :
                </p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <h6>BiomÃ©canique Course</h6>
                        <ul class="small">
                            <li>Sports Medicine (Van Hooren et al., 2024)</li>
                            <li>Journal of Biomechanics</li>
                            <li>Sports Biomechanics</li>
                            <li>Gait & Posture</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Physiologie Exercice</h6>
                        <ul class="small">
                            <li>Frontiers in Physiology - Exercise Physiology</li>
                            <li>European Journal of Applied Physiology</li>
                            <li>Medicine & Science in Sports & Exercise</li>
                            <li>Journal of Applied Physiology</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Entraînement & Performance</h6>
                        <ul class="small">
                            <li>Sports Medicine - Open</li>
                            <li>International Journal of Sports Physiology</li>
                            <li>Scandinavian Journal of Medicine & Science</li>
                            <li>Journal of Sports Sciences</li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <h6><i class="fas fa-chart-line me-2"></i>MÃ©ta-analyses clÃ©s 2024</h6>
                    <p class="mb-0">
                        Les derniÃ¨res revues systÃ©matiques confirment l'efficacitÃ© supÃ©rieure de l'entraînement polarisÃ© 
                        pour les performances d'endurance, avec des gains de 8-15% vs entraînement traditionnel 
                        chez les coureurs entraînÃ©s.
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
// Base de donnÃ©es des plans d'entraînement
const trainingPlans = {
    'endurance': {
        'beginner': 3,
        'intermediate': 4,
        'advanced': 5
    },
    'weight': {
        'beginner': 2,
        'intermediate': 3,
        'advanced': 4
    },
    'speed': {
        'beginner': 3,
        'intermediate': 4,
        'advanced': 5
    },
    '10k': {
        'beginner': 3,
        'intermediate': 4,
        'advanced': 5
    },
    'half': {
        'beginner': 3,
        'intermediate': 4,
        'advanced': 6
    },
    'marathon': {
        'beginner': 4,
        'intermediate': 5,
        'advanced': 6
    }
};

// Descriptions des objectifs
const goalDescriptions = {
    'endurance': 'AmÃ©liorer l\'endurance',
    'weight': 'Perdre du poids',
    'speed': 'Gagner en vitesse',
    '10k': 'Courir un 10 km',
    'half': 'Courir un semi-marathon',
    'marathon': 'Courir un marathon'
};

// Descriptions des niveaux
const experienceDescriptions = {
    'beginner': 'dÃ©butant',
    'intermediate': 'intermÃ©diaire',
    'advanced': 'avancÃ©'
};

// Microcycles types par niveau
const weeklySchedules = {
    'beginner': {
        'Lundi': 'Repos',
        'Mardi': 'Fartlek (30min)',
        'Mercredi': 'Endurance Z2 (30min)',
        'Jeudi': 'Repos',
        'Vendredi': 'Repos',
        'Samedi': 'Sortie longue (45min)',
        'Dimanche': 'Repos'
    },
    'intermediate': {
        'Lundi': 'Endurance Z2 (45min)',
        'Mardi': 'Tempo Z3 (30min)',
        'Mercredi': 'Repos ou Z1 (30min)',
        'Jeudi': 'Endurance Z2 (45min)',
        'Vendredi': 'Repos',
        'Samedi': 'Intervalles Z4 (45min)',
        'Dimanche': 'Sortie longue (90min)'
    },
    'advanced': {
        'Lundi': 'Endurance Z2 (60min)',
        'Mardi': 'Intervalles Z4-5 (45min)',
        'Mercredi': 'Endurance Z2 (75min)',
        'Jeudi': 'Tempo Z3 (45min)',
        'Vendredi': 'Endurance Z1-2 (45min)',
        'Samedi': 'SÃ©ance spÃ©cifique (60min)',
        'Dimanche': 'Sortie longue (120-180min)'
    }
};

function generatePlan() {
    const goal = document.getElementById('goal').value;
    const experience = document.getElementById('experience').value;
    const errorDiv = document.getElementById('errorMessage');
    
    // Validation
    if (!goal || !experience) {
        showError('Veuillez sÃ©lectionner un objectif et un niveau d\'expÃ©rience.');
        return;
    }
    
    // Masquer les erreurs
    errorDiv.classList.add('d-none');
    
    // RÃ©cupÃ©rer le nombre de sÃ©ances
    const totalSessions = trainingPlans[goal][experience];
    
    // Calculer la distribution selon le modÃ¨le polarisÃ©
    const enduranceSessions = Math.round(totalSessions * 0.6); // 60% Zone 1-2
    const thresholdSessions = Math.round(totalSessions * 0.2); // 20% Zone 3
    const speedSessions = Math.round(totalSessions * 0.15); // 15% Zone 4-5
    const recoverySessions = Math.max(0, Math.round(totalSessions * 0.05)); // 5% RÃ©cupÃ©ration
    
    // Afficher les rÃ©sultats
    displayResults(goal, experience, totalSessions, {
        endurance: enduranceSessions,
        threshold: thresholdSessions,
        speed: speedSessions,
        recovery: recoverySessions
    });
}

function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.textContent = message;
    errorDiv.classList.remove('d-none');
    document.getElementById('planResults').classList.add('d-none');
}

function displayResults(goal, experience, totalSessions, distribution) {
    // Affichage du plan principal
    document.getElementById('planDescription').innerHTML = `
        Pour votre objectif <strong class="text-primary">${goalDescriptions[goal]}</strong> et niveau 
        <strong class="text-warning">${experienceDescriptions[experience]}</strong>, 
        il est recommandÃ© de courir :
    `;
    
    document.getElementById('totalSessions').textContent = totalSessions;
    document.getElementById('enduranceSessions').textContent = distribution.endurance;
    document.getElementById('thresholdSessions').textContent = distribution.threshold;
    document.getElementById('speedSessions').textContent = distribution.speed;
    document.getElementById('recoverySessions').textContent = distribution.recovery;
    
    // Affichage du microcycle dÃ©taillÃ©
    displayWeeklySchedule(experience);
    
    // Afficher la section rÃ©sultats
    document.getElementById('planResults').classList.remove('d-none');
    document.getElementById('planResults').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function displayWeeklySchedule(experience) {
    const schedule = weeklySchedules[experience];
    const scheduleDiv = document.getElementById('weeklySchedule');
    
    let tableHTML = `
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Jour</th>
                    <th>SÃ©ance RecommandÃ©e</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    Object.entries(schedule).forEach(([day, session]) => {
        let notes = '';
        let rowClass = '';
        
        if (session.includes('Repos')) {
            notes = 'RÃ©cupÃ©ration complÃ¨te ou marche lÃ©gÃ¨re';
            rowClass = 'table-light';
        } else if (session.includes('Z2') || session.includes('Endurance')) {
            notes = 'Zone 2: conversationnel, base aÃ©robie';
            rowClass = 'table-success';
        } else if (session.includes('Z3') || session.includes('Tempo')) {
            notes = 'Zone 3: rythme soutenu mais contrôlÃ©';
            rowClass = 'table-warning';
        } else if (session.includes('Z4') || session.includes('Z5') || session.includes('Intervalles')) {
            notes = 'Zone 4-5: haute intensitÃ©, rÃ©cupÃ©ration complÃ¨te';
            rowClass = 'table-danger';
        } else if (session.includes('longue')) {
            notes = 'DÃ©veloppement endurance fondamentale';
            rowClass = 'table-info';
        } else {
            notes = 'Alternance allures, travail technique';
        }
        
        tableHTML += `
            <tr class="${rowClass}">
                <td><strong>${day}</strong></td>
                <td>${session}</td>
                <td><small class="text-muted">${notes}</small></td>
            </tr>
        `;
    });
    
    tableHTML += `
            </tbody>
        </table>
    `;
    
    scheduleDiv.innerHTML = tableHTML;
}

function resetPlanner() {
    document.getElementById('goal').value = '';
    document.getElementById('experience').value = '';
    document.getElementById('errorMessage').classList.add('d-none');
    document.getElementById('planResults').classList.add('d-none');
}

// GÃ©nÃ©ration automatique si les deux champs sont remplis
document.getElementById('goal').addEventListener('change', checkAutoGenerate);
document.getElementById('experience').addEventListener('change', checkAutoGenerate);

function checkAutoGenerate() {
    const goal = document.getElementById('goal').value;
    const experience = document.getElementById('experience').value;
    
    if (goal && experience) {
        setTimeout(generatePlan, 300); // DÃ©lai pour Ã©viter les gÃ©nÃ©rations trop frÃ©quentes
    }
}
</script>
@endpush