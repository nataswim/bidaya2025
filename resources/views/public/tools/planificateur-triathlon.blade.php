@extends('layouts.public')

@section('title', 'Planificateur d\'Entraînement Triathlon - PÃ©riodisation Scientifique Multi-Sports')
@section('meta_description', 'Planificateur triathlon basÃ© sur la science du sport. Calcul sÃ©ances hebdomadaires optimales selon objectif et niveau. PÃ©riodisation, nutrition, prÃ©vention blessures. Evidence-based 2024.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Planificateur d'Entraînement Triathlon
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-clock text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Planification scientifique personnalisÃ©e</strong> basÃ©e sur les derniÃ¨res recherches 
                    en sciences du sport combinÃ© et pÃ©riodisation multi-disciplines
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Planificateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Calculateur de Plan -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-calendar-alt me-2"></i>
                    GÃ©nÃ©rateur de Plan PersonnalisÃ©
                </h3>
            </div>
            <div class="card-body">
                
                <!-- Messages d'erreur -->
                <div id="errorMessage" class="alert alert-danger d-none">
                    <!-- Sera rempli par JavaScript -->
                </div>

                <!-- SÃ©lection objectif et niveau -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="goal" class="form-label fw-bold">Objectif de Triathlon</label>
                        <select id="goal" class="form-select form-select-lg border-primary">
                            <option value="">-- Choisir un objectif --</option>
                            <option value="discovery">DÃ©couverte / Sprint (750m-20km-5km)</option>
                            <option value="olympic">Distance Olympique (1.5km-40km-10km)</option>
                            <option value="half_ironman">Half Ironman 70.3 (1.9km-90km-21km)</option>
                            <option value="ironman">Ironman (3.8km-180km-42km)</option>
                            <option value="ultra">Ultra-Distance (>Ironman)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="experience" class="form-label fw-bold">Niveau d'expÃ©rience</label>
                        <select id="experience" class="form-select form-select-lg border-success">
                            <option value="">-- SÃ©lectionner votre niveau --</option>
                            <option value="beginner">DÃ©butant (moins de 1 an)</option>
                            <option value="intermediate">IntermÃ©diaire (1-3 ans)</option>
                            <option value="advanced">AvancÃ© (3-5 ans)</option>
                            <option value="expert">Expert (plus de 5 ans)</option>
                        </select>
                    </div>
                </div>

                <!-- ParamÃ¨tres additionnels -->
                <h5 class="fw-bold mb-3">ParamÃ¨tres de Personnalisation</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="timeAvailable" class="form-label">Temps disponible/semaine</label>
                        <select id="timeAvailable" class="form-select border-warning">
                            <option value="low">LimitÃ© (3-5h/semaine)</option>
                            <option value="moderate" selected>ModÃ©rÃ© (6-10h/semaine)</option>
                            <option value="high">Ã©levÃ© (11-15h/semaine)</option>
                            <option value="very_high">TrÃ¨s Ã©levÃ© (>15h/semaine)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="discipline" class="form-label">Point fort</label>
                        <select id="discipline" class="form-select border-info">
                            <option value="balanced" selected>Ã©quilibrÃ©</option>
                            <option value="swimming">Natation</option>
                            <option value="cycling">Cyclisme</option>
                            <option value="running">Course Ã pied</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="season" class="form-label">PÃ©riode de l'annÃ©e</label>
                        <select id="season" class="form-select border-secondary">
                            <option value="preparation">PrÃ©paration gÃ©nÃ©rale</option>
                            <option value="base" selected>Phase de base</option>
                            <option value="build">Phase de dÃ©veloppement</option>
                            <option value="peak">Phase spÃ©cifique/pic</option>
                            <option value="taper">Affûtage prÃ©-compÃ©tition</option>
                            <option value="recovery">RÃ©cupÃ©ration/Transition</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg fw-bold w-100" onclick="generatePlan()">
                            <i class="fas fa-magic me-2"></i>GÃ©nÃ©rer mon Plan PersonnalisÃ©
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

        <!-- RÃ©sultats du Plan -->
        <div id="planResults" class="d-none">
            <!-- Plan RecommandÃ© -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Votre Plan d'Entraînement PersonnalisÃ©
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5 class="alert-heading">Recommandation PersonnalisÃ©e</h5>
                        <p id="planSummary">
                            <!-- Sera rempli par JavaScript -->
                        </p>
                    </div>

                    <!-- RÃ©partition par discipline -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white text-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-swimmer me-2"></i>Natation
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-info" id="swimmingSessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/semaine</small>
                                    </p>
                                    <small class="text-muted" id="swimmingPercentage">% du volume total</small>
                                    <hr>
                                    <small id="swimmingFocus" class="text-muted">Focus technique et endurance</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark text-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-biking me-2"></i>Cyclisme
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-warning" id="cyclingSessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/semaine</small>
                                    </p>
                                    <small class="text-muted" id="cyclingPercentage">% du volume total</small>
                                    <hr>
                                    <small id="cyclingFocus" class="text-muted">Focus endurance et puissance</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white text-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-running me-2"></i>Course Ã pied
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-danger" id="runningSessions">0</strong></span>
                                        <small class="d-block">sÃ©ances/semaine</small>
                                    </p>
                                    <small class="text-muted" id="runningPercentage">% du volume total</small>
                                    <hr>
                                    <small id="runningFocus" class="text-muted">Focus Ã©conomie et rÃ©sistance</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SÃ©ances spÃ©cialisÃ©es -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-link me-2"></i>SÃ©ances Brick
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <strong id="brickSessions">0</strong> sÃ©ance(s) vÃ©lo-course/semaine
                                    </p>
                                    <small class="text-muted">Adaptation aux transitions spÃ©cifiques</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-dumbbell me-2"></i>Renforcement
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <strong id="strengthSessions">0</strong> sÃ©ance(s) force/semaine
                                    </p>
                                    <small class="text-muted">PrÃ©vention blessures et performance</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Planning Hebdomadaire DÃ©taillÃ© -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-calendar-week me-2"></i>
                        Planning Hebdomadaire Type
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
        
        <!-- Principes Scientifiques du Triathlon -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-flask me-2"></i>
                    Principes Scientifiques du Triathlon
                </h3>
            </div>
            <div class="card-body">
                <p>
                    La planification du triathlon nÃ©cessite une approche multi-disciplinaire Ã©quilibrant trois sports distincts. 
                    Nos recommandations intÃ¨grent la science de la pÃ©riodisation, la spÃ©cificitÃ© de l'entraînement, 
                    et la prÃ©vention des blessures selon les recherches les plus rÃ©centes.
                </p>

                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Mise Ã jour Recherche 2024</h6>
                    <p class="mb-0">
                        La "variabilitÃ© de l'entraînement" (alternance d'intensitÃ©/volume) est cruciale pour Ã©viter 
                        le surentraînement et maximiser les gains dans chaque discipline tout en prÃ©servant la santÃ©.
                    </p>
                </div>

                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <h6>PÃ©riodisation SpÃ©cifique au Triathlon</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>DurÃ©e</th>
                                        <th>Objectif</th>
                                        <th>Focus Disciplines</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Base</strong></td>
                                        <td>12-16 sem</td>
                                        <td>Volume, endurance gÃ©nÃ©rale, technique</td>
                                        <td>Ã©quilibre des 3 disciplines</td>
                                    </tr>
                                    <tr>
                                        <td>Build</td>
                                        <td>8-10 sem</td>
                                        <td>IntensitÃ©, force spÃ©cifique, seuil</td>
                                        <td>Focus progressif vÃ©lo/course</td>
                                    </tr>
                                    <tr>
                                        <td>SpÃ©cialisÃ©e</td>
                                        <td>4-6 sem</td>
                                        <td>Rythme course, transitions, affûtage</td>
                                        <td>Simulation course, brick frÃ©quents</td>
                                    </tr>
                                    <tr>
                                        <td>Affûtage</td>
                                        <td>1-3 sem</td>
                                        <td>RÃ©cupÃ©ration, supercompensation</td>
                                        <td>RÃ©duction volume, maintien intensitÃ©</td>
                                    </tr>
                                    <tr>
                                        <td>Transition</td>
                                        <td>2-4 sem</td>
                                        <td>RÃ©cupÃ©ration mentale/physique</td>
                                        <td>ActivitÃ©s alternatives</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="small">
                            L'intÃ©gration de blocs d'entraînement "brick" (vÃ©lo-course) est essentielle dÃ¨s la phase Build 
                            pour l'adaptation spÃ©cifique aux transitions.
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h6>Adaptations Physiologiques CroisÃ©es</h6>
                        <ul class="small">
                            <li><strong>Natation :</strong> EfficacitÃ© propulsive, adaptation Ã l'hypoxie, proprioception aquatique</li>
                            <li><strong>Cyclisme :</strong> Puissance aÃ©robie, endurance musculaire des jambes, position aÃ©rodynamique</li>
                            <li><strong>Course Ã pied :</strong> Ã©conomie de course, rÃ©sistance aux chocs, adaptation post-vÃ©lo</li>
                            <li><strong>Physiologie IntÃ©grÃ©e :</strong> AmÃ©lioration VO2 Max gÃ©nÃ©rale, gestion fatigue neuromusculaire</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <h6>DÃ©couverte Recherche 2024</h6>
                            <p class="mb-0 small">
                                La natation en eau libre dÃ©veloppe une proprioception unique, amÃ©liorant l'Ã©quilibre 
                                et la coordination sur les autres disciplines. Les entraînements en eau libre 
                                sont recommandÃ©s dÃ¨s que possible.
                            </p>
                        </div>

                        <h6 className="mt-3">Charges d'Entraînement Relatives</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Distance Course</th>
                                        <th>Natation</th>
                                        <th>Cyclisme</th>
                                        <th>Course</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sprint/Olympique</td>
                                        <td>25-30%</td>
                                        <td>40-45%</td>
                                        <td>25-35%</td>
                                    </tr>
                                    <tr>
                                        <td>Half Ironman</td>
                                        <td>20-25%</td>
                                        <td>45-50%</td>
                                        <td>25-35%</td>
                                    </tr>
                                    <tr>
                                        <td>Ironman</td>
                                        <td>15-20%</td>
                                        <td>50-55%</td>
                                        <td>25-35%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nutrition et RÃ©cupÃ©ration -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-apple-alt me-2"></i>
                    Nutrition et RÃ©cupÃ©ration AvancÃ©es en Triathlon
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>StratÃ©gies Nutritionnelles par Phase</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>Focus Macronutriments</th>
                                        <th>Hydratation</th>
                                        <th>Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Entraînement</td>
                                        <td>Glucides complexes 5-7g/kg<br>ProtÃ©ines 1.2-1.7g/kg</td>
                                        <td>35-40ml/kg/jour<br>+ Ã©lectrolytes</td>
                                        <td>PrÃ©: 1-4h avant<br>Post: 30min fenêtre</td>
                                    </tr>
                                    <tr>
                                        <td>Avant course</td>
                                        <td>Surcharge glucidique<br>8-12g/kg (3 jours)</td>
                                        <td>Hyperhydratation<br>contrôlÃ©e</td>
                                        <td>Dernier repas:<br>3-4h avant</td>
                                    </tr>
                                    <tr>
                                        <td>Pendant course</td>
                                        <td>Gels, barres<br>30-90g glucides/h</td>
                                        <td>Boissons Ã©nergÃ©tiques<br>500-1000ml/h</td>
                                        <td>DÃ©but dÃ¨s 1Ã¨re heure<br>RÃ©gularitÃ© cruciale</td>
                                    </tr>
                                    <tr>
                                        <td>Post course</td>
                                        <td>Glucides + ProtÃ©ines<br>ratio 3:1 ou 4:1</td>
                                        <td>RÃ©hydratation<br>150% pertes</td>
                                        <td>ImmÃ©diat puis<br>toutes les 2h</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Techniques de RÃ©cupÃ©ration OptimisÃ©es</h6>
                        <ul class="small">
                            <li><strong>Sommeil :</strong> 7-9 heures minimum, siestes stratÃ©giques possible (20-30min)</li>
                            <li><strong>Nutrition post-effort :</strong> "Fenêtre mÃ©tabolique" critique 30-60 minutes</li>
                            <li><strong>RÃ©cupÃ©ration active :</strong> Nage lÃ©gÃ¨re ou vÃ©lo zone 1 (50-60% FCmax)</li>
                            <li><strong>Compression :</strong> Manches, chaussettes de rÃ©cupÃ©ration (2-4h post-effort)</li>
                            <li><strong>ThÃ©rapie par le froid :</strong> Bains 10-15°C, 10-15 minutes maximum</li>
                            <li><strong>Massage :</strong> Techniques de drainage, Ã©viter massage profond prÃ©-compÃ©tition</li>
                        </ul>
                        
                        <div class="alert alert-success">
                            <h6>Innovation RÃ©cupÃ©ration 2024</h6>
                            <p class="mb-0 small">
                                L'intÃ©gration de la mÃ©ditation et de la cohÃ©rence cardiaque (5-10min quotidien) 
                                rÃ©duit significativement le stress perçu et accÃ©lÃ¨re la rÃ©cupÃ©ration 
                                chez les triathlÃ¨tes d'endurance.
                            </p>
                        </div>

                        <h6 className="mt-3">SupplÃ©mentation Evidence-Based</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>SupplÃ©ment</th>
                                        <th>BÃ©nÃ©fice</th>
                                        <th>Dosage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CrÃ©atine</td>
                                        <td>Puissance, rÃ©cupÃ©ration</td>
                                        <td>3-5g/jour</td>
                                    </tr>
                                    <tr>
                                        <td>Bêta-alanine</td>
                                        <td>Tampon lactique</td>
                                        <td>3-6g/jour (divisÃ©)</td>
                                    </tr>
                                    <tr>
                                        <td>CafÃ©ine</td>
                                        <td>Performance, focus</td>
                                        <td>3-6mg/kg prÃ©-effort</td>
                                    </tr>
                                    <tr>
                                        <td>Nitrates</td>
                                        <td>EfficacitÃ© O2</td>
                                        <td>5-9mmol 2-3h avant</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PrÃ©vention des Blessures -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    PrÃ©vention des Blessures et MatÃ©riel 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>Blessures Courantes en Triathlon</h6>
                        <div class="accordion" id="injuryAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#swimming-injuries">
                                        <i class="fas fa-swimmer text-info me-2"></i>Blessures Natation
                                    </button>
                                </h2>
                                <div id="swimming-injuries" class="accordion-collapse collapse" data-bs-parent="#injuryAccordion">
                                    <div class="accordion-body small">
                                        <ul>
                                            <li><strong>Ã©paule du nageur :</strong> Conflit sous-acromial, tendinopathie coiffe</li>
                                            <li><strong>Douleurs cervicales :</strong> Hyperextension rÃ©pÃ©tÃ©e</li>
                                            <li><strong>PrÃ©vention :</strong> Renforcement coiffe des rotateurs, Ã©tirements antÃ©rieurs</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cycling-injuries">
                                        <i class="fas fa-biking text-warning me-2"></i>Blessures Cyclisme
                                    </button>
                                </h2>
                                <div id="cycling-injuries" class="accordion-collapse collapse" data-bs-parent="#injuryAccordion">
                                    <div class="accordion-body small">
                                        <ul>
                                            <li><strong>Douleurs lombaires :</strong> Position prolongÃ©e, core faible</li>
                                            <li><strong>Syndrome fÃ©moro-patellaire :</strong> Mauvais rÃ©glage selle</li>
                                            <li><strong>Neuropathies :</strong> Compression nerf pudendal/cubital</li>
                                            <li><strong>PrÃ©vention :</strong> Ã©tude posturale, renforcement core, selle adaptÃ©e</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#running-injuries">
                                        <i class="fas fa-running text-danger me-2"></i>Blessures Course Ã pied
                                    </button>
                                </h2>
                                <div id="running-injuries" class="accordion-collapse collapse" data-bs-parent="#injuryAccordion">
                                    <div class="accordion-body small">
                                        <ul>
                                            <li><strong>Tendinopathie d'Achille :</strong> Surcharge, transition vÃ©lo-course</li>
                                            <li><strong>Syndrome essuie-glace :</strong> Friction TFL sur condyle fÃ©moral</li>
                                            <li><strong>PÃ©riostite tibiale :</strong> Progression volume trop rapide</li>
                                            <li><strong>PrÃ©vention :</strong> Progression graduelle, chaussures adaptÃ©es, technique</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>MatÃ©riel Essentiel 2024</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>CatÃ©gorie</th>
                                        <th>Ã©quipement</th>
                                        <th>PrioritÃ©</th>
                                        <th>Budget</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="3">Natation</td>
                                        <td>Combinaison nÃ©oprÃ¨ne</td>
                                        <td><span class="badge bg-danger">Essentiel</span></td>
                                        <td>€€€</td>
                                    </tr>
                                    <tr>
                                        <td>Lunettes eau libre</td>
                                        <td><span class="badge bg-warning">Important</span></td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td>Bonnet silicone</td>
                                        <td><span class="badge bg-success">Utile</span></td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3">Cyclisme</td>
                                        <td>VÃ©lo triathlon/TT</td>
                                        <td><span class="badge bg-danger">Essentiel</span></td>
                                        <td>€€€€</td>
                                    </tr>
                                    <tr>
                                        <td>Capteur puissance</td>
                                        <td><span class="badge bg-warning">Important</span></td>
                                        <td>€€€</td>
                                    </tr>
                                    <tr>
                                        <td>Chaussures triathlon</td>
                                        <td><span class="badge bg-warning">Important</span></td>
                                        <td>€€</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Course</td>
                                        <td>Chaussures running tri</td>
                                        <td><span class="badge bg-danger">Essentiel</span></td>
                                        <td>€€</td>
                                    </tr>
                                    <tr>
                                        <td>Lacets Ã©lastiques</td>
                                        <td><span class="badge bg-success">Utile</span></td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Tech</td>
                                        <td>Montre GPS multi-sports</td>
                                        <td><span class="badge bg-danger">Essentiel</span></td>
                                        <td>€€€</td>
                                    </tr>
                                    <tr>
                                        <td>Ceinture cardiaque</td>
                                        <td><span class="badge bg-warning">Important</span></td>
                                        <td>€</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6>Tendance Technologique 2024</h6>
                            <p class="mb-0 small">
                                Les capteurs de puissance en natation et l'analyse biomÃ©canique en course 
                                deviennent accessibles, permettant une prÃ©vention ultra-personnalisÃ©e des blessures 
                                et une optimisation de la technique.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conseils par Discipline -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-2">
                    <i class="fas fa-lightbulb me-2"></i>
                    Conseils SpÃ©cifiques Evidence-Based par Discipline
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6><i class="fas fa-swimmer text-info me-2"></i>Natation</h6>
                        <ul class="small">
                            <li><strong>Technique prioritaire :</strong> EfficacitÃ© propulsive avant volume</li>
                            <li><strong>Respiration bilatÃ©rale :</strong> Ã©quilibre musculaire et navigation</li>
                            <li><strong>Eau libre rÃ©guliÃ¨re :</strong> Adaptation conditions rÃ©elles</li>
                            <li><strong>Sighting practice :</strong> Technique visÃ©e toutes les 6-8 mouvements</li>
                            <li><strong>Drafting :</strong> Ã©conomie d'Ã©nergie 10-20% en peloton</li>
                            <li><strong>Ã©chauffement spÃ©cifique :</strong> 400-800m progression intensitÃ©</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-biking text-warning me-2"></i>Cyclisme</h6>
                        <ul class="small">
                            <li><strong>Position aÃ©rodynamique :</strong> Gain 15-30% rÃ©sistance air</li>
                            <li><strong>Entraînement puissance :</strong> Zones FTP spÃ©cifiques triathlon</li>
                            <li><strong>Cadence optimale :</strong> 85-95 rpm prÃ©servation jambes</li>
                            <li><strong>Nutrition timing :</strong> DÃ©but alimentation dÃ¨s 1Ã¨re heure</li>
                            <li><strong>Pacing strategy :</strong> RÃ©partition effort selon distance</li>
                            <li><strong>Brick training :</strong> Transition vÃ©lo-course 2x/semaine</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-running text-danger me-2"></i>Course Ã pied</h6>
                        <ul class="small">
                            <li><strong>Ã©conomie de course :</strong> Technique plus importante que VO2max</li>
                            <li><strong>Adaptation post-vÃ©lo :</strong> Jambes lourdes 5-10 premiÃ¨res minutes</li>
                            <li><strong>StratÃ©gie allure :</strong> Start conservateur puis progression</li>
                            <li><strong>Renforcement spÃ©cifique :</strong> Travail excentrique prÃ©vention</li>
                            <li><strong>RÃ©cupÃ©ration active :</strong> Footing lÃ©ger jours off</li>
                            <li><strong>Terrain variÃ© :</strong> Adaptation surface course (route/trail)</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Recommandations de SantÃ© et SÃ©curitÃ©</h6>
                    <p class="mb-0">
                        Le triathlon est un sport exigeant nÃ©cessitant une progression graduelle et mÃ©thodique. 
                        Consultez un professionnel de santÃ© avant de dÃ©buter, surtout si vous avez des antÃ©cÃ©dents 
                        cardiovasculaires. Respectez les signaux de fatigue et intÃ©grez des pÃ©riodes de rÃ©cupÃ©ration 
                        complÃ¨te. La performance durable prime sur la performance immÃ©diate.
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

.accordion-button:not(.collapsed) {
    background-color: #e7f3ff;
    border-color: #0d6efd;
}

.badge {
    font-size: 0.7rem;
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
// Configuration des plans d'entraînement
const trainingPlans = {
    discovery: {
        beginner: { total: 3, swimming: 1, cycling: 1, running: 1, brick: 0, strength: 1 },
        intermediate: { total: 4, swimming: 1, cycling: 2, running: 1, brick: 1, strength: 1 },
        advanced: { total: 5, swimming: 2, cycling: 2, running: 1, brick: 1, strength: 1 },
        expert: { total: 6, swimming: 2, cycling: 2, running: 2, brick: 1, strength: 1 }
    },
    olympic: {
        beginner: { total: 4, swimming: 1, cycling: 2, running: 1, brick: 1, strength: 1 },
        intermediate: { total: 5, swimming: 2, cycling: 2, running: 1, brick: 1, strength: 1 },
        advanced: { total: 6, swimming: 2, cycling: 2, running: 2, brick: 1, strength: 1 },
        expert: { total: 7, swimming: 2, cycling: 3, running: 2, brick: 1, strength: 1 }
    },
    half_ironman: {
        beginner: { total: 5, swimming: 2, cycling: 2, running: 1, brick: 1, strength: 1 },
        intermediate: { total: 6, swimming: 2, cycling: 3, running: 1, brick: 1, strength: 1 },
        advanced: { total: 7, swimming: 2, cycling: 3, running: 2, brick: 1, strength: 1 },
        expert: { total: 8, swimming: 3, cycling: 3, running: 2, brick: 2, strength: 1 }
    },
    ironman: {
        beginner: { total: 6, swimming: 2, cycling: 3, running: 1, brick: 1, strength: 1 },
        intermediate: { total: 7, swimming: 2, cycling: 3, running: 2, brick: 1, strength: 1 },
        advanced: { total: 8, swimming: 3, cycling: 3, running: 2, brick: 2, strength: 1 },
        expert: { total: 9, swimming: 3, cycling: 4, running: 2, brick: 2, strength: 1 }
    },
    ultra: {
        beginner: { total: 7, swimming: 2, cycling: 4, running: 1, brick: 1, strength: 1 },
        intermediate: { total: 8, swimming: 3, cycling: 4, running: 1, brick: 2, strength: 1 },
        advanced: { total: 9, swimming: 3, cycling: 4, running: 2, brick: 2, strength: 1 },
        expert: { total: 10, swimming: 3, cycling: 5, running: 2, brick: 2, strength: 1 }
    }
};

// Ajustements selon paramÃ¨tres
const adjustmentFactors = {
    timeAvailable: {
        low: 0.7,
        moderate: 1.0,
        high: 1.2,
        very_high: 1.4
    },
    discipline: {
        balanced: { swimming: 1.0, cycling: 1.0, running: 1.0 },
        swimming: { swimming: 1.3, cycling: 0.9, running: 0.9 },
        cycling: { swimming: 0.9, cycling: 1.3, running: 0.9 },
        running: { swimming: 0.9, cycling: 0.9, running: 1.3 }
    },
    season: {
        preparation: { volume: 0.8, intensity: 0.6 },
        base: { volume: 1.0, intensity: 0.7 },
        build: { volume: 1.1, intensity: 1.0 },
        peak: { volume: 1.2, intensity: 1.1 },
        taper: { volume: 0.6, intensity: 0.8 },
        recovery: { volume: 0.5, intensity: 0.5 }
    }
};

// GÃ©nÃ©ration du plan d'entraînement
function generatePlan() {
    const goal = document.getElementById('goal').value;
    const experience = document.getElementById('experience').value;
    const timeAvailable = document.getElementById('timeAvailable').value;
    const discipline = document.getElementById('discipline').value;
    const season = document.getElementById('season').value;
    
    // Validation
    if (!goal || !experience) {
        showError('Veuillez sÃ©lectionner votre objectif et votre niveau d\'expÃ©rience.');
        return;
    }
    
    // Masquer les erreurs
    document.getElementById('errorMessage').classList.add('d-none');
    
    // Plan de base
    const basePlan = trainingPlans[goal][experience];
    
    // Ajustements
    const timeAdjustment = adjustmentFactors.timeAvailable[timeAvailable];
    const disciplineAdj = adjustmentFactors.discipline[discipline];
    const seasonAdj = adjustmentFactors.season[season];
    
    // Calcul plan ajustÃ©
    const adjustedPlan = {
        total: Math.round(basePlan.total * timeAdjustment * seasonAdj.volume),
        swimming: Math.max(1, Math.round(basePlan.swimming * timeAdjustment * disciplineAdj.swimming * seasonAdj.volume)),
        cycling: Math.max(1, Math.round(basePlan.cycling * timeAdjustment * disciplineAdj.cycling * seasonAdj.volume)),
        running: Math.max(1, Math.round(basePlan.running * timeAdjustment * disciplineAdj.running * seasonAdj.volume)),
        brick: Math.round(basePlan.brick * timeAdjustment * seasonAdj.volume),
        strength: Math.round(basePlan.strength * timeAdjustment)
    };
    
    // S'assurer que le total est cohÃ©rent
    const disciplineSum = adjustedPlan.swimming + adjustedPlan.cycling + adjustedPlan.running;
    if (disciplineSum > adjustedPlan.total) {
        adjustedPlan.total = disciplineSum + adjustedPlan.brick + adjustedPlan.strength;
    }
    
    displayPlan(adjustedPlan, goal, experience, timeAvailable, season);
}

// Affichage du plan
function displayPlan(plan, goal, experience, timeAvailable, season) {
    // Texte de rÃ©sumÃ©
    const goalNames = {
        discovery: 'DÃ©couverte/Sprint',
        olympic: 'Distance Olympique',
        half_ironman: 'Half Ironman 70.3',
        ironman: 'Ironman',
        ultra: 'Ultra-Distance'
    };
    
    const experienceNames = {
        beginner: 'dÃ©butant',
        intermediate: 'intermÃ©diaire',
        advanced: 'avancÃ©',
        expert: 'expert'
    };
    
    const timeNames = {
        low: 'temps limitÃ©',
        moderate: 'temps modÃ©rÃ©',
        high: 'temps Ã©levÃ©',
        very_high: 'temps trÃ¨s Ã©levÃ©'
    };
    
    const seasonNames = {
        preparation: 'prÃ©paration gÃ©nÃ©rale',
        base: 'phase de base',
        build: 'phase de dÃ©veloppement',
        peak: 'phase spÃ©cifique',
        taper: 'affûtage',
        recovery: 'rÃ©cupÃ©ration'
    };
    
    document.getElementById('planSummary').innerHTML = `
        Pour votre objectif <strong>${goalNames[goal]}</strong> et niveau <strong>${experienceNames[experience]}</strong>,
        avec <strong>${timeNames[timeAvailable]}</strong> en <strong>${seasonNames[season]}</strong>,
        il est recommandÃ© de faire <strong>${plan.total} sÃ©ances</strong> d'entraînement par semaine.
    `;
    
    // SÃ©ances par discipline
    document.getElementById('swimmingSessions').textContent = plan.swimming;
    document.getElementById('cyclingSessions').textContent = plan.cycling;
    document.getElementById('runningSessions').textContent = plan.running;
    document.getElementById('brickSessions').textContent = plan.brick;
    document.getElementById('strengthSessions').textContent = plan.strength;
    
    // Pourcentages
    const swimPercent = Math.round((plan.swimming / plan.total) * 100);
    const cyclePercent = Math.round((plan.cycling / plan.total) * 100);
    const runPercent = Math.round((plan.running / plan.total) * 100);
    
    document.getElementById('swimmingPercentage').textContent = `~${swimPercent}% du volume total`;
    document.getElementById('cyclingPercentage').textContent = `~${cyclePercent}% du volume total`;
    document.getElementById('runningPercentage').textContent = `~${runPercent}% du volume total`;
    
    // Focus spÃ©cifiques selon la phase
    updateFocusText(season);
    
    // Planning hebdomadaire
    generateWeeklySchedule(plan, season);
    
    // Afficher les rÃ©sultats
    document.getElementById('planResults').classList.remove('d-none');
    document.getElementById('planResults').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Mise Ã jour du focus selon la saison
function updateFocusText(season) {
    const focusTexts = {
        preparation: {
            swimming: 'Technique, mobilitÃ© articulaire',
            cycling: 'Endurance base, force gÃ©nÃ©rale',
            running: 'Volume progressif, prÃ©vention'
        },
        base: {
            swimming: 'Volume, endurance aÃ©robie',
            cycling: 'Endurance, Ã©conomie gestuelle',
            running: 'Endurance fondamentale'
        },
        build: {
            swimming: 'Seuil, vitesse spÃ©cifique',
            cycling: 'Puissance, seuil lactique',
            running: 'Tempo, seuil anaÃ©robie'
        },
        peak: {
            swimming: 'Allure course, transitions',
            cycling: 'SpÃ©cifique compÃ©tition',
            running: 'Rythme cible, brick'
        },
        taper: {
            swimming: 'Maintien sensation',
            cycling: 'QualitÃ©, rÃ©cupÃ©ration',
            running: 'Activation, confiance'
        },
        recovery: {
            swimming: 'Plaisir, technique',
            cycling: 'Exploration, plaisir',
            running: 'RÃ©cupÃ©ration active'
        }
    };
    
    const focus = focusTexts[season];
    document.getElementById('swimmingFocus').textContent = focus.swimming;
    document.getElementById('cyclingFocus').textContent = focus.cycling;
    document.getElementById('runningFocus').textContent = focus.running;
}

// GÃ©nÃ©ration du planning hebdomadaire
function generateWeeklySchedule(plan, season) {
    const scheduleContainer = document.getElementById('weeklySchedule');
    
    // Structure de la semaine type
    const weekDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    
    // RÃ©partition intelligente des sÃ©ances
    const schedule = distributeWorkouts(plan, season);
    
    let tableHTML = `
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Jour</th>
                    <th>SÃ©ance Principale</th>
                    <th>SÃ©ance Secondaire</th>
                    <th>DurÃ©e Approximative</th>
                    <th>IntensitÃ©</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    weekDays.forEach((day, index) => {
        const daySchedule = schedule[index];
        tableHTML += `
            <tr>
                <td><strong>${day}</strong></td>
                <td>${daySchedule.primary}</td>
                <td>${daySchedule.secondary}</td>
                <td>${daySchedule.duration}</td>
                <td>
                    <span class="badge bg-${daySchedule.intensityColor}">${daySchedule.intensity}</span>
                </td>
            </tr>
        `;
    });
    
    tableHTML += '</tbody></table>';
    scheduleContainer.innerHTML = tableHTML;
}

// Distribution intelligente des sÃ©ances
function distributeWorkouts(plan, season) {
    const baseSchedule = [
        { primary: 'Natation technique', secondary: '', duration: '45-60min', intensity: 'ModÃ©rÃ©e', intensityColor: 'warning' },
        { primary: 'Cyclisme endurance', secondary: '', duration: '60-90min', intensity: 'Faible', intensityColor: 'success' },
        { primary: 'Course Ã pied', secondary: 'Renforcement', duration: '30-45min + 20min', intensity: 'ModÃ©rÃ©e', intensityColor: 'warning' },
        { primary: 'Natation intensitÃ©', secondary: '', duration: '45-60min', intensity: 'Ã©levÃ©e', intensityColor: 'danger' },
        { primary: 'Brick (VÃ©lo + Course)', secondary: '', duration: '90-120min', intensity: 'Ã©levÃ©e', intensityColor: 'danger' },
        { primary: 'Cyclisme long', secondary: '', duration: '2-4h', intensity: 'Faible-ModÃ©rÃ©e', intensityColor: 'info' },
        { primary: 'RÃ©cupÃ©ration ou Repos', secondary: '', duration: 'Optionnel', intensity: 'TrÃ¨s faible', intensityColor: 'secondary' }
    ];
    
    // Ajustements selon la phase
    if (season === 'recovery') {
        return baseSchedule.map(day => ({
            ...day,
            intensity: 'TrÃ¨s faible',
            intensityColor: 'secondary',
            duration: day.primary.includes('Repos') ? 'Repos complet' : '30-45min'
        }));
    }
    
    if (season === 'taper') {
        return baseSchedule.map(day => ({
            ...day,
            duration: day.duration.replace(/(\d+)/g, (match) => Math.round(parseInt(match) * 0.7))
        }));
    }
    
    return baseSchedule;
}

// Affichage des erreurs
function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i><strong>Erreur :</strong> ${message}`;
    errorDiv.classList.remove('d-none');
    document.getElementById('planResults').classList.add('d-none');
}

// RÃ©initialisation du planificateur
function resetPlanner() {
    const selects = [
        { id: 'goal', value: '' },
        { id: 'experience', value: '' },
        { id: 'timeAvailable', value: 'moderate' },
        { id: 'discipline', value: 'balanced' },
        { id: 'season', value: 'base' }
    ];
    
    selects.forEach(select => {
        document.getElementById(select.id).value = select.value;
    });
    
    document.getElementById('errorMessage').classList.add('d-none');
    document.getElementById('planResults').classList.add('d-none');
}
</script>
@endpush