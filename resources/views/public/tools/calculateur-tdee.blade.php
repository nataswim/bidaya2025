@extends('layouts.public')

@section('title', 'Calculateur TDEE AvancÃ© & MÃ©tabolisme - DÃ©pense Ã©nergÃ©tique PersonnalisÃ©e')
@section('meta_description', 'Calculateur TDEE scientifique avec personnalisation avancÃ©e. Multiples formules BMR, ajustements gÃ©nÃ©tiques, hormonaux, environnementaux. Objectifs nutritionnels optimisÃ©s. Evidence-based 2024.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Calculateur TDEE dÃ©pense Ã©nergÃ©tique totale
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-desktop text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Calculez votre dÃ©pense Ã©nergÃ©tique totale</strong> avec les derniÃ¨res recherches 
                    en mÃ©tabolisme et personnalisation scientifique avancÃ©e
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Calculateur TDEE Multi-ParamÃ¨tres -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-calculator me-2"></i>
                    Calculateur TDEE Multi-ParamÃ¨tres
                </h3>
            </div>
            <div class="card-body">
                
                <!-- Messages d'erreur -->
                <div id="errorMessage" class="alert alert-danger d-none">
                    <!-- Sera rempli par JavaScript -->
                </div>

                <!-- DonnÃ©es de base -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="age" class="form-label fw-bold">Âge (annÃ©es)</label>
                        <input type="number" id="age" class="form-control form-control-lg border-primary" 
                               placeholder="30" min="10" max="100">
                    </div>
                    <div class="col-md-3">
                        <label for="weight" class="form-label fw-bold">Poids (kg)</label>
                        <input type="number" id="weight" class="form-control form-control-lg border-primary" 
                               placeholder="70" min="30" max="200" step="0.1">
                    </div>
                    <div class="col-md-3">
                        <label for="height" class="form-label fw-bold">Taille (cm)</label>
                        <input type="number" id="height" class="form-control form-control-lg border-primary" 
                               placeholder="175" min="120" max="220">
                    </div>
                    <div class="col-md-3">
                        <label for="gender" class="form-label fw-bold">Sexe</label>
                        <select id="gender" class="form-select form-select-lg border-primary">
                            <option value="male">Homme</option>
                            <option value="female">Femme</option>
                        </select>
                    </div>
                </div>

                <!-- Composition Corporelle (Optionnel) -->
                <h5 class="fw-bold mb-3">Composition Corporelle (Optionnel)</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="bodyFat" class="form-label">% Masse grasse</label>
                        <input type="number" id="bodyFat" class="form-control border-warning" 
                               placeholder="15" min="3" max="50" step="0.1">
                        <small class="text-muted">Pour formule Katch-McArdle</small>
                    </div>
                    <div class="col-md-6">
                        <label for="muscleMass" class="form-label">Masse musculaire (kg)</label>
                        <input type="number" id="muscleMass" class="form-control border-warning" 
                               placeholder="55" min="20" max="100" step="0.1">
                        <small class="text-muted">Pour formule Cunningham</small>
                    </div>
                </div>

                <!-- ActivitÃ© et Lifestyle -->
                <h5 class="fw-bold mb-3">ActivitÃ© et Lifestyle</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="activityLevel" class="form-label">Niveau d'activitÃ© physique</label>
                        <select id="activityLevel" class="form-select border-success">
                            <option value="sedentary">SÃ©dentaire (bureau, pas d'exercice)</option>
                            <option value="light">LÃ©ger (exercice 1-3j/sem)</option>
                            <option value="moderate" selected>ModÃ©rÃ© (exercice 3-5j/sem)</option>
                            <option value="active">Actif (exercice 6-7j/sem)</option>
                            <option value="very_active">TrÃ¨s actif (2x/jour ou travail physique)</option>
                            <option value="extreme">Extrême (athlÃ¨te professionnel)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="occupation" class="form-label">Type d'occupation</label>
                        <select id="occupation" class="form-select border-info">
                            <option value="sedentary" selected>Bureau/SÃ©dentaire</option>
                            <option value="standing">Debout (vente, enseignement)</option>
                            <option value="walking">Marche (infirmier, serveur)</option>
                            <option value="physical">Physique (construction, sport)</option>
                        </select>
                    </div>
                </div>

                <!-- ParamÃ¨tres MÃ©taboliques AvancÃ©s -->
                <h5 class="fw-bold mb-3">ParamÃ¨tres MÃ©taboliques AvancÃ©s</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="bmrFormula" class="form-label">Formule BMR</label>
                        <select id="bmrFormula" class="form-select border-danger">
                            <option value="mifflin" selected>Mifflin-St Jeor (RecommandÃ©e)</option>
                            <option value="harris">Harris-Benedict RÃ©visÃ©e</option>
                            <option value="katch">Katch-McArdle (% graisse requis)</option>
                            <option value="cunningham">Cunningham (masse musculaire)</option>
                            <option value="owen">Owen (validation rÃ©cente)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="healthCondition" class="form-label">Ã©tat de santÃ©</label>
                        <select id="healthCondition" class="form-select border-secondary">
                            <option value="healthy" selected>Bonne santÃ©</option>
                            <option value="hyperthyroid">Hyperthyroïdie</option>
                            <option value="hypothyroid">Hypothyroïdie</option>
                            <option value="diabetes">DiabÃ¨te</option>
                            <option value="pcos">SOPK</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="geneticFactor" class="form-label">Facteur gÃ©nÃ©tique</label>
                        <select id="geneticFactor" class="form-select border-warning">
                            <option value="slow">MÃ©tabolisme lent</option>
                            <option value="average" selected>Moyen</option>
                            <option value="fast">MÃ©tabolisme rapide</option>
                        </select>
                    </div>
                </div>

                <!-- Facteurs Environnementaux -->
                <h5 class="fw-bold mb-3">Facteurs Environnementaux</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="sleepHours" class="form-label">Heures de sommeil/nuit</label>
                        <input type="number" id="sleepHours" class="form-control border-info" 
                               placeholder="8" min="4" max="12" step="0.5">
                    </div>
                    <div class="col-md-4">
                        <label for="stressLevel" class="form-label">Niveau de stress</label>
                        <select id="stressLevel" class="form-select border-warning">
                            <option value="low">Faible</option>
                            <option value="moderate" selected>ModÃ©rÃ©</option>
                            <option value="high">Ã©levÃ©</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="climateTemp" class="form-label">TempÃ©rature moyenne (°C)</label>
                        <input type="number" id="climateTemp" class="form-control border-secondary" 
                               placeholder="20" min="-20" max="50">
                    </div>
                </div>

                <!-- Impact MÃ©dicamenteux -->
                <h5 class="fw-bold mb-3">Impact MÃ©dicamenteux</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="medicationImpact" class="form-label">MÃ©dicaments affectant le mÃ©tabolisme</label>
                        <select id="medicationImpact" class="form-select border-danger">
                            <option value="none" selected>Aucun impact significatif</option>
                            <option value="stimulants">Stimulants (cafÃ©ine, ADHD)</option>
                            <option value="beta_blockers">Bêta-bloquants</option>
                            <option value="antidepressants">AntidÃ©presseurs</option>
                            <option value="corticosteroids">CorticostÃ©roïdes</option>
                            <option value="thyroid_meds">MÃ©dicaments thyroïdiens</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg fw-bold w-100" onclick="calculateTDEE()">
                            <i class="fas fa-calculator me-2"></i>Calculer TDEE PersonnalisÃ©
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary btn-lg fw-bold w-100" onclick="resetCalculator()">
                            <i class="fas fa-redo me-2"></i>RÃ©initialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RÃ©sultats -->
        <div id="resultsSection" class="d-none">
            <!-- Profil MÃ©tabolique -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-user-chart me-2"></i>
                        Votre Profil MÃ©tabolique PersonnalisÃ©
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card border-danger h-100">
                                <div class="card-header bg-danger text-white text-center">
                                    <h6 class="mb-0">BMR</h6>
                                    <small>MÃ©tabolisme de Base</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-danger" id="bmrResult">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                    <small class="text-muted" id="formulaUsed">Formule</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white text-center">
                                    <h6 class="mb-0">TDEE Standard</h6>
                                    <small>Avant ajustements</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-primary" id="standardTDEE">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white text-center">
                                    <h6 class="mb-0">TDEE AjustÃ©</h6>
                                    <small>PersonnalisÃ©</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-success" id="adjustedTDEE">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                    <small class="text-success" id="adjustmentFactor">Facteur: 100%</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white text-center">
                                    <h6 class="mb-0">Âge MÃ©tabolique</h6>
                                    <small>Estimation</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-3"><strong class="text-info" id="metabolicAge">0</strong></span>
                                        <small class="d-block">ans</small>
                                    </p>
                                    <small class="text-muted" id="tdeePerKg">0 kcal/kg</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ajustements appliquÃ©s -->
                    <div id="adjustmentDetails" class="alert alert-info d-none">
                        <h6>Ajustements AppliquÃ©s</h6>
                        <ul id="adjustmentsList" class="mb-0">
                            <!-- Sera rempli par JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- RÃ©partition de la DÃ©pense Ã©nergÃ©tique -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-2">
                        <i class="fas fa-chart-pie me-2"></i>
                        RÃ©partition de la DÃ©pense Ã©nergÃ©tique
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white text-center">
                                    <h6 class="mb-0">BMR/RMR</h6>
                                    <small>60-75% TDEE</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong class="text-danger" id="bmrBreakdown">0</strong></span>
                                        <small class="d-block">kcal</small>
                                    </p>
                                    <small class="text-muted">Fonctions vitales</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark text-center">
                                    <h6 class="mb-0">TEF</h6>
                                    <small>8-12% TDEE</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong class="text-warning" id="tefBreakdown">0</strong></span>
                                        <small class="d-block">kcal</small>
                                    </p>
                                    <small class="text-muted">Digestion</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white text-center">
                                    <h6 class="mb-0">NEAT</h6>
                                    <small>15-30% TDEE</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong class="text-info" id="neatBreakdown">0</strong></span>
                                        <small class="d-block">kcal</small>
                                    </p>
                                    <small class="text-muted">ActivitÃ© spontanÃ©e</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white text-center">
                                    <h6 class="mb-0">EAT</h6>
                                    <small>5-35% TDEE</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="card-text">
                                        <span class="fs-4"><strong class="text-success" id="eatBreakdown">0</strong></span>
                                        <small class="d-block">kcal</small>
                                    </p>
                                    <small class="text-muted">Exercice planifiÃ©</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Barre de progression -->
                    <div class="progress" style="height: 30px;">
                        <div id="bmrProgress" class="progress-bar bg-danger" style="width: 0%">BMR</div>
                        <div id="tefProgress" class="progress-bar bg-warning" style="width: 0%">TEF</div>
                        <div id="neatProgress" class="progress-bar bg-info" style="width: 0%">NEAT</div>
                        <div id="eatProgress" class="progress-bar bg-success" style="width: 0%">EAT</div>
                    </div>
                </div>
            </div>

            <!-- Objectifs Caloriques et Macronutriments -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-bullseye me-2"></i>
                        Objectifs Caloriques et Macronutriments
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3" id="calorieGoals">
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
        
        <!-- Formules BMR et Validation -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-formula me-2"></i>
                    Formules BMR et Validation Scientifique 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-8">
                        <h6>Comparaison des Formules BMR</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Formule</th>
                                        <th>AnnÃ©e</th>
                                        <th>Population d'Ã©tude</th>
                                        <th>PrÃ©cision (±%)</th>
                                        <th>Recommandation 2024</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td><strong>Mifflin-St Jeor</strong></td>
                                        <td>1990</td>
                                        <td>Adultes normaux (n=498)</td>
                                        <td>±5-10%</td>
                                        <td>Gold Standard actuel</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Harris-Benedict RÃ©visÃ©e</td>
                                        <td>1984</td>
                                        <td>Large cohorte mixte</td>
                                        <td>±10-15%</td>
                                        <td>Alternative acceptable</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Katch-McArdle</td>
                                        <td>1996</td>
                                        <td>BasÃ©e sur masse maigre</td>
                                        <td>±3-8%</td>
                                        <td>Optimale si % graisse connu</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Cunningham</td>
                                        <td>1991</td>
                                        <td>AthlÃ¨tes et bodybuilders</td>
                                        <td>±5-12%</td>
                                        <td>AthlÃ¨tes musclÃ©s</td>
                                    </tr>
                                    <tr>
                                        <td>Owen</td>
                                        <td>1986</td>
                                        <td>Validation rÃ©cente large</td>
                                        <td>±8-15%</td>
                                        <td>Populations obÃ¨ses</td>
                                    </tr>
                                    <tr class="table-secondary">
                                        <td>Harris-Benedict Originale</td>
                                        <td>1919</td>
                                        <td>Caucasiens 1919</td>
                                        <td>±15-25%</td>
                                        <td>ObsolÃ¨te</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Facteurs d'Erreur des Formules</h6>
                        <ul class="small">
                            <li><strong>Composition corporelle :</strong> Muscle vs graisse (±20%)</li>
                            <li><strong>EthnicitÃ© :</strong> DiffÃ©rences mÃ©taboliques significatives</li>
                            <li><strong>Âge :</strong> DÃ©clin BMR -1-2%/dÃ©cennie</li>
                            <li><strong>Pathologies :</strong> Thyroïde, diabÃ¨te, SOPK</li>
                            <li><strong>MÃ©dicaments :</strong> Impact hormonal/neural</li>
                            <li><strong>Adaptation mÃ©tabolique :</strong> Restriction calorique</li>
                        </ul>
                        
                        <div class="card mt-3 border-primary">
                            <div class="card-header bg-primary text-white">
                                <small>Technologies PrÃ©cises 2024</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>CalorimÃ©trie indirecte :</strong> Gold standard (±2%)</li>
                                    <li><strong>Doubly Labeled Water :</strong> TDEE rÃ©el (±3%)</li>
                                    <li><strong>Room Calorimeter :</strong> Contrôle total (±1%)</li>
                                    <li><strong>Metabolic Cart :</strong> Accessible (±5%)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Composantes TDEE DÃ©taillÃ©es -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-puzzle-piece me-2"></i>
                    Composantes TDEE - Recherches RÃ©centes
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>BMR/RMR - MÃ©tabolisme de Base (60-75% TDEE)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Organe/Tissu</th>
                                        <th>% BMR</th>
                                        <th>kcal/kg/jour</th>
                                        <th>VariabilitÃ©</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Foie</strong></td>
                                        <td>21%</td>
                                        <td>200</td>
                                        <td>±15%</td>
                                    </tr>
                                    <tr>
                                        <td>Cerveau</td>
                                        <td>20%</td>
                                        <td>240</td>
                                        <td>±8%</td>
                                    </tr>
                                    <tr>
                                        <td>Muscle squelettique</td>
                                        <td>22%</td>
                                        <td>13</td>
                                        <td>±25%</td>
                                    </tr>
                                    <tr>
                                        <td>Reins</td>
                                        <td>8%</td>
                                        <td>440</td>
                                        <td>±20%</td>
                                    </tr>
                                    <tr>
                                        <td>Cœur</td>
                                        <td>9%</td>
                                        <td>440</td>
                                        <td>±12%</td>
                                    </tr>
                                    <tr>
                                        <td>Tissu adipeux</td>
                                        <td>4%</td>
                                        <td>4.5</td>
                                        <td>±30%</td>
                                    </tr>
                                    <tr>
                                        <td>Autres</td>
                                        <td>16%</td>
                                        <td>Variable</td>
                                        <td>±20%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>NEAT - ThermogenÃ¨se ActivitÃ© Non-Exercice (15-30%)</h6>
                        <ul class="small">
                            <li><strong>DÃ©finition :</strong> Toute activitÃ© non-exercice conscient</li>
                            <li><strong>Composantes :</strong> Fidgeting, posture, gestes quotidiens</li>
                            <li><strong>VariabilitÃ© :</strong> 100-800 kcal/jour entre individus</li>
                            <li><strong>GÃ©nÃ©tique :</strong> 40-60% hÃ©ritabilitÃ©</li>
                            <li><strong>Facteurs :</strong> Environnement, stress, saison</li>
                            <li><strong>Adaptation :</strong> ↓20-40% en restriction calorique</li>
                        </ul>
                        
                        <h6 class="mt-3">TEF - Effet Thermique Alimentaire (8-12%)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Macronutriment</th>
                                        <th>TEF (%)</th>
                                        <th>DurÃ©e</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>ProtÃ©ines</strong></td>
                                        <td>20-30%</td>
                                        <td>3-6h</td>
                                    </tr>
                                    <tr>
                                        <td>Glucides</td>
                                        <td>5-10%</td>
                                        <td>1-3h</td>
                                    </tr>
                                    <tr>
                                        <td>Lipides</td>
                                        <td>0-3%</td>
                                        <td>1-6h</td>
                                    </tr>
                                    <tr>
                                        <td>Alcool</td>
                                        <td>15-20%</td>
                                        <td>1-4h</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facteurs d'Influence MÃ©tabolique -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-dna me-2"></i>
                    Facteurs d'Influence sur le MÃ©tabolisme
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6>Facteurs GÃ©nÃ©tiques et Ã©pigÃ©nÃ©tiques</h6>
                        <ul class="small">
                            <li><strong>GÃ¨nes UCP :</strong> ThermogenÃ¨se mitochondriale</li>
                            <li><strong>FTO :</strong> RÃ©gulation appÃ©tit (+9% BMR variants)</li>
                            <li><strong>MC4R :</strong> Contrôle satiÃ©tÃ© centrale</li>
                            <li><strong>ADRB3 :</strong> Lipolyse et thermogenÃ¨se</li>
                            <li><strong>HÃ©ritabilitÃ© BMR :</strong> 40-80% selon Ã©tudes</li>
                            <li><strong>Ã©pigÃ©nÃ©tique :</strong> Modulation lifestyle</li>
                        </ul>
                        
                        <div class="card mt-3 border-primary">
                            <div class="card-header bg-primary text-white">
                                <small>Variants MÃ©taboliques</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>MÃ©tabolisme rapide :</strong> +10-15% population</li>
                                    <li><strong>MÃ©tabolisme lent :</strong> -10-20% population</li>
                                    <li><strong>RÃ©sistants obÃ©sitÃ© :</strong> 5% population</li>
                                    <li><strong>Susceptibles obÃ©sitÃ© :</strong> 15% population</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Facteurs Hormonaux</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Hormone</th>
                                        <th>Impact BMR</th>
                                        <th>Condition Pathologique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>T3/T4 (Thyroïde)</strong></td>
                                        <td>±30-50%</td>
                                        <td>Hyper/Hypothyroïdie</td>
                                    </tr>
                                    <tr>
                                        <td>Insuline</td>
                                        <td>±10-20%</td>
                                        <td>DiabÃ¨te, RÃ©sistance</td>
                                    </tr>
                                    <tr>
                                        <td>Cortisol</td>
                                        <td>±5-15%</td>
                                        <td>Cushing, Addison</td>
                                    </tr>
                                    <tr>
                                        <td>Leptine</td>
                                        <td>±5-25%</td>
                                        <td>RÃ©sistance leptine</td>
                                    </tr>
                                    <tr>
                                        <td>GH</td>
                                        <td>±10-20%</td>
                                        <td>DÃ©ficit/ExcÃ¨s GH</td>
                                    </tr>
                                    <tr>
                                        <td>TestostÃ©rone</td>
                                        <td>±8-15%</td>
                                        <td>Hypogonadisme</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Facteurs Environnementaux</h6>
                        <ul class="small">
                            <li><strong>TempÃ©rature :</strong> Froid ↑5-15%, Chaleur ↑3-8%</li>
                            <li><strong>Altitude :</strong> >2500m ↑10-25% BMR</li>
                            <li><strong>Sommeil :</strong> <6h ↓2-8% BMR</li>
                            <li><strong>Stress chronique :</strong> ↑5-15% cortisol</li>
                            <li><strong>Pollution :</strong> Perturbateurs endocriniens</li>
                            <li><strong>Microbiome :</strong> ±5-20% extraction Ã©nergÃ©tique</li>
                        </ul>
                        
                        <div class="card mt-3 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <small>Adaptations MÃ©taboliques</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>Restriction calorique :</strong> ↓15-40% TDEE</li>
                                    <li><strong>Suralimentation :</strong> ↑8-20% TDEE</li>
                                    <li><strong>Effet yo-yo :</strong> Spirale mÃ©tabolique</li>
                                    <li><strong>Set-point :</strong> DÃ©fense pondÃ©rale</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- StratÃ©gies d'Optimisation MÃ©tabolique -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-2">
                    <i class="fas fa-rocket me-2"></i>
                    StratÃ©gies d'Optimisation MÃ©tabolique
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6>Optimisation Nutritionnelle</h6>
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white">
                                <small>Boost TEF et BMR</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>ProtÃ©ines Ã©levÃ©es :</strong> 1.6-2.2g/kg (↑TEF 20-30%)</li>
                                    <li><strong>Repas frÃ©quents :</strong> 4-6 repas/jour</li>
                                    <li><strong>CafÃ©ine :</strong> 100-400mg (↑BMR 3-11%)</li>
                                    <li><strong>ThÃ© vert :</strong> EGCG + cafÃ©ine</li>
                                    <li><strong>Ã©pices :</strong> Capsaïcine, gingembre</li>
                                    <li><strong>Eau froide :</strong> 2L (↑BMR 50 kcal)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <small>Ã©viter Adaptations NÃ©gatives</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>Ã©viter dÃ©ficits extrêmes (>30%)</li>
                                    <li>Refeeds pÃ©riodiques (leptine)</li>
                                    <li>Diet breaks (2-4 semaines)</li>
                                    <li>Cyclage calorique</li>
                                    <li>Monitoring tempÃ©rature corporelle</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Optimisation par l'Exercice</h6>
                        <div class="card border-success mb-3">
                            <div class="card-header bg-success text-white">
                                <small>Maximiser EPOC et NEAT</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>HIIT :</strong> ↑EPOC 12-48h (+50-200 kcal)</li>
                                    <li><strong>Musculation :</strong> ↑BMR par masse musculaire</li>
                                    <li><strong>Cardio LISS :</strong> Optimisation lipolyse</li>
                                    <li><strong>NEAT conscient :</strong> Marche, fidgeting</li>
                                    <li><strong>Exposition froid :</strong> Activation BAT</li>
                                    <li><strong>RÃ©cupÃ©ration active :</strong> Maintien NEAT</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <small>Gains Masse Musculaire</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>+1kg muscle = +13 kcal/jour BMR</li>
                                    <li>Progression charge progressive</li>
                                    <li>Volume optimal: 10-20 sets/muscle/semaine</li>
                                    <li>FrÃ©quence: 2-3x/semaine/muscle</li>
                                    <li>RÃ©cupÃ©ration: 48-72h</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Optimisation Lifestyle</h6>
                        <div class="card border-secondary mb-3">
                            <div class="card-header bg-secondary text-white">
                                <small>Facteurs Circadiens</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>Sommeil :</strong> 7-9h qualitÃ© (↑leptine)</li>
                                    <li><strong>LumiÃ¨re :</strong> Exposition matinale</li>
                                    <li><strong>Horaires repas :</strong> RÃ©gularitÃ©</li>
                                    <li><strong>Jeûne intermittent :</strong> FlexibilitÃ© mÃ©tabolique</li>
                                    <li><strong>Stress management :</strong> MÃ©ditation, yoga</li>
                                    <li><strong>Sauna/Froid :</strong> Hormesis thermique</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <small>Surveillance et Ajustements</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>Monitoring poids quotidien</li>
                                    <li>Photos progression mensuelle</li>
                                    <li>Mesures circonfÃ©rences</li>
                                    <li>Biomarqueurs sanguins (TSH, T3)</li>
                                    <li>Performance exercice</li>
                                    <li>Humeur et Ã©nergie subjective</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Avertissement MÃ©dical Important</h6>
                    <p class="mb-0">
                        Les calculs TDEE sont des estimations basÃ©es sur des Ã©quations statistiques. 
                        En cas de pathologie mÃ©tabolique, troubles alimentaires ou doutes sur votre condition, 
                        consultez un professionnel de santÃ©. Ã©vitez les dÃ©ficits caloriques extrêmes (&gt;30%) 
                        sans supervision mÃ©dicale.
                    </p>
                </div>
                
                <div class="alert alert-success mt-3">
                    <h6><i class="fas fa-chart-line me-2"></i>Vision 2024-2030</h6>
                    <p class="mb-0">
                        L'avenir du mÃ©tabolisme tend vers une personnalisation extrême intÃ©grant gÃ©nomique, 
                        Ã©pigÃ©nÃ©tique, microbiome, biomarqueurs temps rÃ©el et IA pour optimiser individuellement 
                        la dÃ©pense Ã©nergÃ©tique et la composition corporelle.
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

.progress-bar {
    font-size: 0.8rem;
    font-weight: bold;
}
</style>
@endpush

@push('scripts')
<script>
// Configuration des facteurs d'activitÃ©
const activityFactors = {
    sedentary: { factor: 1.2, neat: 200, eat: 0, description: 'SÃ©dentaire (bureau, pas d\'exercice)' },
    light: { factor: 1.375, neat: 300, eat: 150, description: 'LÃ©ger (exercice 1-3j/sem)' },
    moderate: { factor: 1.55, neat: 400, eat: 300, description: 'ModÃ©rÃ© (exercice 3-5j/sem)' },
    active: { factor: 1.725, neat: 500, eat: 450, description: 'Actif (exercice 6-7j/sem)' },
    very_active: { factor: 1.9, neat: 600, eat: 600, description: 'TrÃ¨s actif (2x/jour ou travail physique)' },
    extreme: { factor: 2.2, neat: 700, eat: 800, description: 'Extrême (athlÃ¨te professionnel)' }
};

// Formules BMR
const bmrFormulas = {
    mifflin: {
        male: (weight, height, age) => 10 * weight + 6.25 * height - 5 * age + 5,
        female: (weight, height, age) => 10 * weight + 6.25 * height - 5 * age - 161
    },
    harris: {
        male: (weight, height, age) => 88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age),
        female: (weight, height, age) => 447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age)
    },
    katch: (weight, bodyFat) => {
        if (!bodyFat || bodyFat <= 0) return null;
        const leanMass = weight * (1 - bodyFat / 100);
        return 370 + (21.6 * leanMass);
    },
    cunningham: (muscleMass) => {
        if (!muscleMass || muscleMass <= 0) return null;
        return 500 + (22 * muscleMass);
    },
    owen: {
        male: (weight) => 879 + (10.2 * weight),
        female: (weight) => 795 + (7.18 * weight)
    }
};

// Calcul du BMR selon la formule choisie
function calculateBMR(weight, height, age, gender, formula, bodyFat, muscleMass) {
    const w = parseFloat(weight);
    const h = parseFloat(height);
    const a = parseInt(age);
    const bf = parseFloat(bodyFat);
    const mm = parseFloat(muscleMass);

    switch (formula) {
        case 'mifflin':
            return bmrFormulas.mifflin[gender](w, h, a);
        case 'harris':
            return bmrFormulas.harris[gender](w, h, a);
        case 'katch':
            return bmrFormulas.katch(w, bf);
        case 'cunningham':
            return bmrFormulas.cunningham(mm);
        case 'owen':
            return bmrFormulas.owen[gender](w);
        default:
            return bmrFormulas.mifflin[gender](w, h, a);
    }
}

// Calcul du TDEE
function calculateTDEE() {
    // RÃ©cupÃ©ration des valeurs
    const age = parseInt(document.getElementById('age').value);
    const weight = parseFloat(document.getElementById('weight').value);
    const height = parseFloat(document.getElementById('height').value);
    const gender = document.getElementById('gender').value;
    const activityLevel = document.getElementById('activityLevel').value;
    const bodyFat = parseFloat(document.getElementById('bodyFat').value);
    const muscleMass = parseFloat(document.getElementById('muscleMass').value);
    const bmrFormula = document.getElementById('bmrFormula').value;
    const healthCondition = document.getElementById('healthCondition').value;
    const geneticFactor = document.getElementById('geneticFactor').value;
    const sleepHours = parseFloat(document.getElementById('sleepHours').value);
    const stressLevel = document.getElementById('stressLevel').value;
    const climateTemp = parseFloat(document.getElementById('climateTemp').value);
    const medicationImpact = document.getElementById('medicationImpact').value;
    
    // Validation
    if (!age || !weight || !height) {
        showError('Veuillez entrer votre âge, poids et taille.');
        return;
    }
    
    if (age < 10 || age > 100) {
        showError('L\'âge doit être compris entre 10 et 100 ans.');
        return;
    }
    
    if (weight < 30 || weight > 200) {
        showError('Le poids doit être compris entre 30 et 200 kg.');
        return;
    }
    
    if (height < 120 || height > 220) {
        showError('La taille doit être comprise entre 120 et 220 cm.');
        return;
    }
    
    // Masquer les erreurs
    document.getElementById('errorMessage').classList.add('d-none');
    
    // Calcul BMR
    let bmr = calculateBMR(weight, height, age, gender, bmrFormula, bodyFat, muscleMass);
    
    if (!bmr || bmr <= 0) {
        // Fallback vers Mifflin si formule spÃ©cialisÃ©e impossible
        bmr = calculateBMR(weight, height, age, gender, 'mifflin');
    }
    
    // Facteurs d'activitÃ© dÃ©taillÃ©s
    const activityData = activityFactors[activityLevel];
    
    // Calcul TDEE standard
    const standardTDEE = bmr * activityData.factor;
    
    // Breakdown dÃ©taillÃ© des composantes TDEE
    const tef = standardTDEE * 0.10; // Thermic Effect of Food (8-12%)
    const neat = activityData.neat; // Non-Exercise Activity Thermogenesis
    const eat = activityData.eat; // Exercise Activity Thermogenesis
    
    // Ajustements selon conditions personnelles
    let adjustmentFactor = 1.0;
    let adjustmentDetails = [];
    
    // Ajustement condition de santÃ©
    switch (healthCondition) {
        case 'hyperthyroid':
            adjustmentFactor *= 1.15;
            adjustmentDetails.push('Hyperthyroïdie: +15%');
            break;
        case 'hypothyroid':
            adjustmentFactor *= 0.85;
            adjustmentDetails.push('Hypothyroïdie: -15%');
            break;
        case 'diabetes':
            adjustmentFactor *= 0.95;
            adjustmentDetails.push('DiabÃ¨te: -5%');
            break;
        case 'pcos':
            adjustmentFactor *= 0.90;
            adjustmentDetails.push('SOPK: -10%');
            break;
    }
    
    // Ajustement gÃ©nÃ©tique
    switch (geneticFactor) {
        case 'fast':
            adjustmentFactor *= 1.10;
            adjustmentDetails.push('MÃ©tabolisme rapide: +10%');
            break;
        case 'slow':
            adjustmentFactor *= 0.90;
            adjustmentDetails.push('MÃ©tabolisme lent: -10%');
            break;
    }
    
    // Ajustement mÃ©dicaments
    switch (medicationImpact) {
        case 'stimulants':
            adjustmentFactor *= 1.05;
            adjustmentDetails.push('Stimulants: +5%');
            break;
        case 'beta_blockers':
            adjustmentFactor *= 0.95;
            adjustmentDetails.push('Bêta-bloquants: -5%');
            break;
        case 'antidepressants':
            adjustmentFactor *= 0.93;
            adjustmentDetails.push('AntidÃ©presseurs: -7%');
            break;
        case 'corticosteroids':
            adjustmentFactor *= 1.08;
            adjustmentDetails.push('CorticostÃ©roïdes: +8%');
            break;
        case 'thyroid_meds':
            adjustmentFactor *= 1.12;
            adjustmentDetails.push('MÃ©dicaments thyroïdiens: +12%');
            break;
    }
    
    // Ajustement stress
    if (stressLevel === 'high') {
        adjustmentFactor *= 1.03;
        adjustmentDetails.push('Stress Ã©levÃ©: +3%');
    } else if (stressLevel === 'low') {
        adjustmentFactor *= 0.98;
        adjustmentDetails.push('Stress faible: -2%');
    }
    
    // Ajustement sommeil
    if (!isNaN(sleepHours)) {
        if (sleepHours < 6) {
            adjustmentFactor *= 0.97;
            adjustmentDetails.push('Sommeil insuffisant: -3%');
        } else if (sleepHours > 9) {
            adjustmentFactor *= 1.02;
            adjustmentDetails.push('Sommeil prolongÃ©: +2%');
        }
    }
    
    // Ajustement tempÃ©rature
    if (!isNaN(climateTemp)) {
        if (climateTemp < 10) {
            adjustmentFactor *= 1.05;
            adjustmentDetails.push('Froid: +5%');
        } else if (climateTemp > 30) {
            adjustmentFactor *= 1.03;
            adjustmentDetails.push('Chaleur: +3%');
        }
    }
    
    // TDEE final ajustÃ©
    const adjustedTDEE = standardTDEE * adjustmentFactor;
    
    // Estimations pour objectifs
    const maintenanceCalories = Math.round(adjustedTDEE);
    const cuttingCalories = Math.round(adjustedTDEE * 0.8); // -20%
    const bulkingCalories = Math.round(adjustedTDEE * 1.15); // +15%
    const extremeCutCalories = Math.round(adjustedTDEE * 0.7); // -30%
    
    // Calcul composition macronutriments selon objectif
    const macros = {
        maintenance: {
            protein: Math.round((maintenanceCalories * 0.25) / 4),
            fat: Math.round((maintenanceCalories * 0.25) / 9),
            carb: Math.round((maintenanceCalories * 0.5) / 4)
        },
        cutting: {
            protein: Math.round((cuttingCalories * 0.35) / 4),
            fat: Math.round((cuttingCalories * 0.25) / 9),
            carb: Math.round((cuttingCalories * 0.4) / 4)
        },
        bulking: {
            protein: Math.round((bulkingCalories * 0.25) / 4),
            fat: Math.round((bulkingCalories * 0.30) / 9),
            carb: Math.round((bulkingCalories * 0.45) / 4)
        }
    };
    
    // MÃ©triques mÃ©taboliques additionnelles
    const metabolicAge = age + (adjustmentFactor < 0.95 ? 5 : adjustmentFactor > 1.05 ? -3 : 0);
    const bmrPerKg = Math.round(bmr / weight * 10) / 10;
    const tdeePerKg = Math.round(adjustedTDEE / weight * 10) / 10;
    
    const results = {
        bmr: Math.round(bmr),
        standardTDEE: Math.round(standardTDEE),
        adjustedTDEE: Math.round(adjustedTDEE),
        adjustmentFactor: Math.round(adjustmentFactor * 1000) / 10,
        adjustmentDetails,
        breakdown: {
            bmr: Math.round(bmr),
            tef: Math.round(tef),
            neat: Math.round(neat),
            eat: Math.round(eat)
        },
        goals: {
            maintenance: maintenanceCalories,
            cutting: cuttingCalories,
            bulking: bulkingCalories,
            extremeCut: extremeCutCalories
        },
        macros,
        metrics: {
            metabolicAge: Math.round(metabolicAge),
            bmrPerKg,
            tdeePerKg
        },
        formula: bmrFormula
    };
    
    displayResults(results);
}

// Affichage des erreurs
function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i><strong>Erreur :</strong> ${message}`;
    errorDiv.classList.remove('d-none');
    document.getElementById('resultsSection').classList.add('d-none');
}

// Affichage des rÃ©sultats
function displayResults(results) {
    // Profil mÃ©tabolique
    document.getElementById('bmrResult').textContent = results.bmr;
    document.getElementById('standardTDEE').textContent = results.standardTDEE;
    document.getElementById('adjustedTDEE').textContent = results.adjustedTDEE;
    document.getElementById('adjustmentFactor').textContent = `Facteur: ${results.adjustmentFactor}%`;
    document.getElementById('metabolicAge').textContent = results.metrics.metabolicAge;
    document.getElementById('tdeePerKg').textContent = `${results.metrics.tdeePerKg} kcal/kg`;
    document.getElementById('formulaUsed').textContent = `Formule ${results.formula}`;
    
    // Ajustements appliquÃ©s
    if (results.adjustmentDetails.length > 0) {
        const adjustmentDiv = document.getElementById('adjustmentDetails');
        const adjustmentsList = document.getElementById('adjustmentsList');
        adjustmentsList.innerHTML = '';
        
        results.adjustmentDetails.forEach(detail => {
            const li = document.createElement('li');
            li.textContent = detail;
            adjustmentsList.appendChild(li);
        });
        
        adjustmentDiv.classList.remove('d-none');
    }
    
    // Breakdown Ã©nergÃ©tique
    document.getElementById('bmrBreakdown').textContent = results.breakdown.bmr;
    document.getElementById('tefBreakdown').textContent = results.breakdown.tef;
    document.getElementById('neatBreakdown').textContent = results.breakdown.neat;
    document.getElementById('eatBreakdown').textContent = results.breakdown.eat;
    
    // Barre de progression
    const total = results.adjustedTDEE;
    document.getElementById('bmrProgress').style.width = `${(results.breakdown.bmr / total * 100)}%`;
    document.getElementById('tefProgress').style.width = `${(results.breakdown.tef / total * 100)}%`;
    document.getElementById('neatProgress').style.width = `${(results.breakdown.neat / total * 100)}%`;
    document.getElementById('eatProgress').style.width = `${(results.breakdown.eat / total * 100)}%`;
    
    // Objectifs caloriques
    const goalsContainer = document.getElementById('calorieGoals');
    goalsContainer.innerHTML = '';
    
    const goals = [
        { key: 'maintenance', name: 'Maintien', subtitle: 'Poids stable', color: 'secondary', macros: results.macros.maintenance },
        { key: 'cutting', name: 'SÃ¨che ModÃ©rÃ©e', subtitle: '-20% (-0.5kg/sem)', color: 'warning', macros: results.macros.cutting },
        { key: 'extremeCut', name: 'SÃ¨che Agressive', subtitle: '-30% (-1kg/sem)', color: 'danger', macros: null },
        { key: 'bulking', name: 'Prise de Masse', subtitle: '+15% (+0.3kg/sem)', color: 'success', macros: results.macros.bulking }
    ];
    
    goals.forEach(goal => {
        const goalCard = document.createElement('div');
        goalCard.className = 'col-md-3';
        
        let macrosHtml = '';
        if (goal.macros) {
            macrosHtml = `
                <hr class="my-2">
                <div class="text-start small">
                    <div>P: ${goal.macros.protein}g</div>
                    <div>L: ${goal.macros.fat}g</div>
                    <div>G: ${goal.macros.carb}g</div>
                </div>
            `;
        } else if (goal.key === 'extremeCut') {
            macrosHtml = `<small class="text-danger">Supervision recommandÃ©e</small>`;
        }
        
        goalCard.innerHTML = `
            <div class="card border-${goal.color}">
                <div class="card-header bg-${goal.color} ${goal.color === 'warning' ? 'text-dark' : 'text-white'} text-center">
                    <h6 class="mb-0">${goal.name}</h6>
                    <small>${goal.subtitle}</small>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">
                        <span class="fs-4"><strong class="text-${goal.color}">${results.goals[goal.key]}</strong></span>
                        <small class="d-block">kcal/jour</small>
                    </p>
                    ${macrosHtml}
                </div>
            </div>
        `;
        
        goalsContainer.appendChild(goalCard);
    });
    
    // Afficher la section rÃ©sultats
    document.getElementById('resultsSection').classList.remove('d-none');
    document.getElementById('resultsSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// RÃ©initialisation du calculateur
function resetCalculator() {
    const inputs = ['age', 'weight', 'height', 'bodyFat', 'muscleMass', 'sleepHours', 'climateTemp'];
    inputs.forEach(id => {
        document.getElementById(id).value = '';
    });
    
    const selects = [
        { id: 'gender', value: 'male' },
        { id: 'activityLevel', value: 'moderate' },
        { id: 'occupation', value: 'sedentary' },
        { id: 'bmrFormula', value: 'mifflin' },
        { id: 'healthCondition', value: 'healthy' },
        { id: 'geneticFactor', value: 'average' },
        { id: 'stressLevel', value: 'moderate' },
        { id: 'medicationImpact', value: 'none' }
    ];
    
    selects.forEach(select => {
        document.getElementById(select.id).value = select.value;
    });
    
    document.getElementById('errorMessage').classList.add('d-none');
    document.getElementById('resultsSection').classList.add('d-none');
}
</script>
@endpush