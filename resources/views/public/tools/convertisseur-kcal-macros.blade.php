@extends('layouts.public')

@section('title', 'Convertisseur Kcal ↔ Macronutriments AvancÃ© - Calculs MÃ©taboliques 2024')
@section('meta_description', 'Convertisseur calories-macronutriments scientifique 2024. Calculs BMR, TDEE, TEF avec algorithmes personnalisÃ©s. RÃ©partitions Ã©quilibrÃ©e, low-carb, high-protein. Recherches mÃ©taboliques actualisÃ©es.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="fas fa-calculator text-warning"></i>
            Convertisseur Kcal ↔ Macronutriments AvancÃ©
            <i class="fas fa-fire text-danger"></i>
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-chart-line text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Calculez vos apports et dÃ©penses Ã©nergÃ©tiques</strong> avec les derniÃ¨res recherches 
                    scientifiques en mÃ©tabolisme et nutrition personnalisÃ©e
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Mode de Conversion -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-exchange-alt me-2"></i>Mode de Conversion
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conversionMode" 
                                   id="kcalToMacros" value="kcalToMacros" checked>
                            <label class="form-check-label fw-bold" for="kcalToMacros">
                                <i class="fas fa-arrow-right me-2"></i>Calories → Macronutriments
                            </label>
                            <small class="d-block text-muted">RÃ©partition selon diffÃ©rents rÃ©gimes alimentaires</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="conversionMode" 
                                   id="macrosToKcal" value="macrosToKcal">
                            <label class="form-check-label fw-bold" for="macrosToKcal">
                                <i class="fas fa-arrow-left me-2"></i>Macronutriments → Calories
                            </label>
                            <small class="d-block text-muted">Calcul prÃ©cis avec pourcentages</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculateur Ã©nergÃ©tique -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-calculator me-2"></i>Calculateur Ã©nergÃ©tique
                </h3>
            </div>
            <div class="card-body">
                
                <!-- Conversion principale -->
                <div id="kcalToMacrosInputs">
                    <h5 class="fw-bold text-success mb-3">Conversion Calories → Macronutriments</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ã©nergie totale (kcal)</label>
                            <input type="number" id="totalKcal" class="form-control form-control-lg border-success" 
                                   placeholder="Ex: 2000" min="500" max="5000">
                            <small class="text-muted">Entre 500 et 5000 kcal</small>
                        </div>
                    </div>
                </div>

                <div id="macrosToKcalInputs" class="d-none">
                    <h5 class="fw-bold text-primary mb-3">Conversion Macronutriments → Calories</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">ProtÃ©ines (g)</label>
                            <input type="number" id="proteinGrams" class="form-control form-control-lg border-primary" 
                                   placeholder="Ex: 120" min="0" max="500">
                            <small class="text-muted">4 kcal/g</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Lipides (g)</label>
                            <input type="number" id="fatGrams" class="form-control form-control-lg border-warning" 
                                   placeholder="Ex: 80" min="0" max="300">
                            <small class="text-muted">9 kcal/g</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Glucides (g)</label>
                            <input type="number" id="carbGrams" class="form-control form-control-lg border-info" 
                                   placeholder="Ex: 250" min="0" max="800">
                            <small class="text-muted">4 kcal/g</small>
                        </div>
                    </div>
                </div>

                <!-- DonnÃ©es personnelles pour calcul mÃ©tabolique -->
                <h5 class="fw-bold text-secondary mb-3">
                    <i class="fas fa-user me-2"></i>DonnÃ©es personnelles (calcul mÃ©tabolique avancÃ©)
                </h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-2">
                        <label class="form-label">Poids (kg)</label>
                        <input type="number" id="weight" class="form-control" placeholder="70" min="30" max="200">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Taille (cm)</label>
                        <input type="number" id="height" class="form-control" placeholder="175" min="120" max="220">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Âge</label>
                        <input type="number" id="age" class="form-control" placeholder="30" min="15" max="90">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sexe</label>
                        <select id="gender" class="form-select">
                            <option value="male" selected>Homme</option>
                            <option value="female">Femme</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Niveau d'activitÃ©</label>
                        <select id="activityLevel" class="form-select">
                            <option value="sedentary" selected>SÃ©dentaire</option>
                            <option value="light">LÃ©gÃ¨re</option>
                            <option value="moderate">ModÃ©rÃ©e</option>
                            <option value="active">Active</option>
                            <option value="veryActive">TrÃ¨s active</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg fw-bold w-100" onclick="calculateConversion()">
                            <i class="fas fa-calculator me-2"></i>Calculer & Analyser
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary btn-lg fw-bold w-100" onclick="resetForm()">
                            <i class="fas fa-redo me-2"></i>RÃ©initialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RÃ©sultats de Conversion -->
        <div id="conversionResults" class="d-none">
            <!-- RÃ©sultats Calories → Macros -->
            <div id="kcalToMacrosResults" class="card mb-4 shadow-lg">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-chart-pie me-2"></i>RÃ©partitions RecommandÃ©es
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white text-center">
                                    <h6 class="mb-0">RÃ©gime Ã©quilibrÃ©</h6>
                                    <small>25% P / 25% L / 50% G</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="mb-2"><strong class="text-primary" id="balancedProtein">0g</strong> protÃ©ines</p>
                                    <p class="mb-2"><strong class="text-warning" id="balancedFat">0g</strong> lipides</p>
                                    <p class="mb-0"><strong class="text-info" id="balancedCarb">0g</strong> glucides</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning text-dark text-center">
                                    <h6 class="mb-0">Low Carb</h6>
                                    <small>30% P / 50% L / 20% G</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="mb-2"><strong class="text-primary" id="lowCarbProtein">0g</strong> protÃ©ines</p>
                                    <p class="mb-2"><strong class="text-warning" id="lowCarbFat">0g</strong> lipides</p>
                                    <p class="mb-0"><strong class="text-info" id="lowCarbCarb">0g</strong> glucides</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-danger h-100">
                                <div class="card-header bg-danger text-white text-center">
                                    <h6 class="mb-0">High Protein</h6>
                                    <small>35% P / 25% L / 40% G</small>
                                </div>
                                <div class="card-body text-center">
                                    <p class="mb-2"><strong class="text-primary" id="highProteinProtein">0g</strong> protÃ©ines</p>
                                    <p class="mb-2"><strong class="text-warning" id="highProteinFat">0g</strong> lipides</p>
                                    <p class="mb-0"><strong class="text-info" id="highProteinCarb">0g</strong> glucides</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RÃ©sultats Macros → Calories -->
            <div id="macrosToKcalResults" class="card mb-4 shadow-lg d-none">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-2">
                        <i class="fas fa-fire me-2"></i>Analyse Ã©nergÃ©tique
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Ã©nergÃ©tique</h5>
                                    <p class="card-text">
                                        <span class="fs-2"><strong class="text-success" id="totalCalories">0</strong></span>
                                        <span class="d-block">kcal</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-info h-100">
                                <div class="card-body">
                                    <h6 class="card-title">RÃ©partition Ã©nergÃ©tique</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>ProtÃ©ines:</span>
                                        <strong class="text-primary" id="proteinPercent">0%</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Lipides:</span>
                                        <strong class="text-warning" id="fatPercent">0%</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Glucides:</span>
                                        <strong class="text-info" id="carbPercent">0%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse MÃ©tabolique -->
            <div id="metabolicResults" class="card mb-4 shadow-lg d-none">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-2">
                        <i class="fas fa-heartbeat me-2"></i>Analyse MÃ©tabolique PersonnalisÃ©e
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card border-primary text-center">
                                <div class="card-body">
                                    <h6 class="card-title">BMR Mifflin-St Jeor</h6>
                                    <p class="card-text">
                                        <span class="fs-4"><strong class="text-primary" id="bmrMifflin">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                    <small class="text-muted">MÃ©tabolisme de base</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-success text-center">
                                <div class="card-body">
                                    <h6 class="card-title">TDEE Total</h6>
                                    <p class="card-text">
                                        <span class="fs-4"><strong class="text-success" id="tdeeTotal">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                    <small class="text-muted">DÃ©pense totale</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning text-center">
                                <div class="card-body">
                                    <h6 class="card-title">NEAT</h6>
                                    <p class="card-text">
                                        <span class="fs-5"><strong class="text-warning" id="neatValue">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                    <small class="text-muted">ActivitÃ© spontanÃ©e</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-danger text-center">
                                <div class="card-body">
                                    <h6 class="card-title">TEF</h6>
                                    <p class="card-text">
                                        <span class="fs-5"><strong class="text-danger" id="tefValue">0</strong></span>
                                        <small class="d-block">kcal/jour</small>
                                    </p>
                                    <small class="text-muted">Effet thermique</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <h6><i class="fas fa-info-circle me-2"></i>InterprÃ©tation</h6>
                        <p class="small mb-0" id="metabolicInterpretation">
                            <!-- Sera rempli par JavaScript -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- Coefficients Ã©nergÃ©tiques ActualisÃ©s -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-flask me-2"></i>
                    Coefficients Ã©nergÃ©tiques - Recherches 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>Valeurs Ã©nergÃ©tiques ActualisÃ©es</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Macronutriment</th>
                                        <th>Standard (kcal/g)</th>
                                        <th>MÃ©tabolisable (kcal/g)</th>
                                        <th>TEF (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>ProtÃ©ines</strong></td>
                                        <td>4.0</td>
                                        <td>3.2-3.8</td>
                                        <td>20-30%</td>
                                    </tr>
                                    <tr>
                                        <td>Glucides</td>
                                        <td>4.0</td>
                                        <td>3.7-3.9</td>
                                        <td>5-10%</td>
                                    </tr>
                                    <tr>
                                        <td>Lipides</td>
                                        <td>9.0</td>
                                        <td>8.7-8.9</td>
                                        <td>0-3%</td>
                                    </tr>
                                    <tr>
                                        <td>Alcool</td>
                                        <td>7.0</td>
                                        <td>5.6-6.2</td>
                                        <td>15-20%</td>
                                    </tr>
                                    <tr>
                                        <td>Fibres</td>
                                        <td>2.0</td>
                                        <td>0.5-2.0</td>
                                        <td>Variable</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Facteurs de Correction Modernes</h6>
                        <ul class="small">
                            <li><strong>QualitÃ© protÃ©ique :</strong> DIAAS vs PDCAAS (2024)</li>
                            <li><strong>Index glycÃ©mique :</strong> Impact sur TEF des glucides</li>
                            <li><strong>Forme des lipides :</strong> MCT vs LCT vs PUFA</li>
                            <li><strong>Transformation alimentaire :</strong> Ultra-transformÃ© vs naturel</li>
                            <li><strong>Timing nutritionnel :</strong> Chronobiologie mÃ©tabolique</li>
                            <li><strong>Micronutriments :</strong> Cofacteurs mÃ©taboliques</li>
                        </ul>
                        
                        <div class="alert alert-info">
                            <small>
                                <strong>Innovation 2024 :</strong> Les nouveaux algorithmes intÃ¨grent 
                                la variabilitÃ© inter-individuelle du mÃ©tabolisme (±15-20%).
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Composantes de la DÃ©pense Ã©nergÃ©tique -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-chart-line me-2"></i>
                    Composantes de la DÃ©pense Ã©nergÃ©tique Totale
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-8">
                        <h6>Breakdown Ã©nergÃ©tique DÃ©taillÃ© (% TDEE)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Composante</th>
                                        <th>SÃ©dentaire</th>
                                        <th>Actif</th>
                                        <th>AthlÃ¨te</th>
                                        <th>VariabilitÃ©</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-primary">
                                        <td><strong>BMR/RMR</strong></td>
                                        <td>60-70%</td>
                                        <td>50-60%</td>
                                        <td>45-55%</td>
                                        <td>±8-15%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TEF</strong></td>
                                        <td>8-12%</td>
                                        <td>8-12%</td>
                                        <td>8-12%</td>
                                        <td>±3-5%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>EAT (Exercice)</strong></td>
                                        <td>5-10%</td>
                                        <td>15-25%</td>
                                        <td>25-35%</td>
                                        <td>Variable</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NEAT</strong></td>
                                        <td>15-30%</td>
                                        <td>15-25%</td>
                                        <td>15-20%</td>
                                        <td>±20-50%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>SPA (ActivitÃ© spontanÃ©e)</strong></td>
                                        <td>2-8%</td>
                                        <td>2-8%</td>
                                        <td>2-8%</td>
                                        <td>±50-100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Recherche 2024</h6>
                            <p class="small mb-0">
                                La composante NEAT varie jusqu'Ã 800 kcal/jour entre individus de même profil, 
                                expliquant les diffÃ©rences mÃ©taboliques majeures.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Facteurs d'Influence MÃ©tabolique</h6>
                        <ul class="small">
                            <li><strong>GÃ©nÃ©tique :</strong> 40-60% de la variation BMR</li>
                            <li><strong>Composition corporelle :</strong> Masse musculaire vs graisseuse</li>
                            <li><strong>Âge :</strong> -1-2% BMR par dÃ©cennie aprÃ¨s 30 ans</li>
                            <li><strong>Sexe :</strong> Hommes +10-15% BMR vs femmes</li>
                            <li><strong>ThermorÃ©gulation :</strong> Adaptation au froid/chaud</li>
                            <li><strong>Ã©tat nutritionnel :</strong> Restriction/suralimentation</li>
                            <li><strong>Hormones :</strong> Thyroïde, leptine, cortisol</li>
                            <li><strong>MÃ©dicaments :</strong> Impact sur mÃ©tabolisme</li>
                            <li><strong>Pathologies :</strong> DiabÃ¨te, SOPK, hypothyroïdie</li>
                        </ul>
                        
                        <div class="card mt-3 border-secondary">
                            <div class="card-header bg-secondary text-white text-center">
                                <small>Technologies de Mesure 2024</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>CalorimÃ©trie indirecte :</strong> RMR prÃ©cis</li>
                                    <li><strong>Doubly Labeled Water :</strong> TDEE gold standard</li>
                                    <li><strong>Wearables avancÃ©s :</strong> Estimation NEAT/EAT</li>
                                    <li><strong>Monitors mÃ©taboliques :</strong> TEF en temps rÃ©el</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculs Ã©nergÃ©tiques par Aliment -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-apple-alt me-2"></i>
                    Calculs Ã©nergÃ©tiques par Aliment, Repas et Jour
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>MÃ©thodes de Calcul PrÃ©cises</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>MÃ©thode</th>
                                        <th>PrÃ©cision</th>
                                        <th>Application</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CalorimÃ©trie bombe</td>
                                        <td>±0.1%</td>
                                        <td>Recherche alimentaire</td>
                                    </tr>
                                    <tr>
                                        <td>Facteurs Atwater</td>
                                        <td>±5-10%</td>
                                        <td>Ã©tiquetage commercial</td>
                                    </tr>
                                    <tr>
                                        <td>Atwater spÃ©cifiques</td>
                                        <td>±3-5%</td>
                                        <td>Bases nutritionnelles</td>
                                    </tr>
                                    <tr>
                                        <td>Analyse proximale</td>
                                        <td>±2-5%</td>
                                        <td>Laboratoires agrÃ©Ã©s</td>
                                    </tr>
                                    <tr>
                                        <td>Spectroscopie NIR</td>
                                        <td>±1-3%</td>
                                        <td>Contrôle qualitÃ© industriel</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>VariabilitÃ© Ã©nergÃ©tique des Aliments</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>CatÃ©gorie d'Aliment</th>
                                        <th>Variation kcal/100g</th>
                                        <th>Facteurs d'Influence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Fruits</td>
                                        <td>±15-25%</td>
                                        <td>MaturitÃ©, variÃ©tÃ©, saison</td>
                                    </tr>
                                    <tr>
                                        <td>LÃ©gumes</td>
                                        <td>±10-20%</td>
                                        <td>Mode culture, prÃ©paration</td>
                                    </tr>
                                    <tr>
                                        <td>Viandes</td>
                                        <td>±20-40%</td>
                                        <td>Partie, Ã©levage, cuisson</td>
                                    </tr>
                                    <tr>
                                        <td>CÃ©rÃ©ales</td>
                                        <td>±5-15%</td>
                                        <td>Raffinage, transformation</td>
                                    </tr>
                                    <tr>
                                        <td>Produits transformÃ©s</td>
                                        <td>±30-50%</td>
                                        <td>Recette, additifs, process</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4 mt-3">
                    <div class="col-md-4">
                        <div class="card border-primary h-100">
                            <div class="card-header bg-primary text-white text-center">
                                <h6 class="mb-0">Niveau Aliment</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>Base :</strong> Macronutriments × coefficients</li>
                                    <li><strong>Correction :</strong> Fibres, alcool, acides organiques</li>
                                    <li><strong>Ajustement :</strong> Transformation, cuisson</li>
                                    <li><strong>PrÃ©cision :</strong> ±5-15% selon aliment</li>
                                </ul>
                                <div class="text-center mt-2 bg-light p-2 rounded">
                                    <strong class="text-primary">Exemple : 1 pomme (150g)</strong><br/>
                                    <small>78 kcal ± 12 kcal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-header bg-warning text-dark text-center">
                                <h6 class="mb-0">Niveau Repas</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>Sommation :</strong> Σ calories individuelles</li>
                                    <li><strong>Interactions :</strong> Effet matrice alimentaire</li>
                                    <li><strong>TEF combinÃ© :</strong> Synergie macronutriments</li>
                                    <li><strong>PrÃ©cision :</strong> ±10-20% selon complexitÃ©</li>
                                </ul>
                                <div class="text-center mt-2 bg-light p-2 rounded">
                                    <strong class="text-warning">Exemple : Petit-dÃ©jeuner</strong><br />
                                    <small>520 kcal ± 85 kcal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white text-center">
                                <h6 class="mb-0">Niveau JournÃ©e</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>Total :</strong> Σ repas + collations</li>
                                    <li><strong>Rythme :</strong> Chronobiologie nutritionnelle</li>
                                    <li><strong>Adaptation :</strong> TEF journalier global</li>
                                    <li><strong>PrÃ©cision :</strong> ±15-25% population gÃ©nÃ©rale</li>
                                </ul>
                                <div class="text-center mt-2 bg-light p-2 rounded">
                                    <strong class="text-success">Exemple : Apport quotidien</strong><br/>
                                    <small>2150 kcal ± 320 kcal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technologies et Innovations 2024 -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-2">
                    <i class="fas fa-microchip me-2"></i>
                    Technologies et Innovations MÃ©taboliques 2024
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>Outils de Mesure AvancÃ©s</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Technologie</th>
                                        <th>ParamÃ¨tre MesurÃ©</th>
                                        <th>PrÃ©cision</th>
                                        <th>Coût</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>MetaboFlex Pro</td>
                                        <td>RMR en temps rÃ©el</td>
                                        <td>±3%</td>
                                        <td>€€€</td>
                                    </tr>
                                    <tr>
                                        <td>Lumen device</td>
                                        <td>Ratio RQ mÃ©tabolique</td>
                                        <td>±5%</td>
                                        <td>€€</td>
                                    </tr>
                                    <tr>
                                        <td>KORR CardioCoach</td>
                                        <td>VO2/VCO2 portable</td>
                                        <td>±2%</td>
                                        <td>€€€€</td>
                                    </tr>
                                    <tr>
                                        <td>InBody 970</td>
                                        <td>Composition corporelle</td>
                                        <td>±1-3%</td>
                                        <td>€€€€</td>
                                    </tr>
                                    <tr>
                                        <td>CGM (Continuous Glucose)</td>
                                        <td>RÃ©ponse glycÃ©mique</td>
                                        <td>±8%</td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td>Whoop/Oura Ring</td>
                                        <td>DÃ©pense estimÃ©e 24h</td>
                                        <td>±15-25%</td>
                                        <td>€</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Innovations Algorithmiques</h6>
                        <ul class="small">
                            <li><strong>IA prÃ©dictive :</strong> ModÃ¨les personnalisÃ©s basÃ©s sur historique</li>
                            <li><strong>Machine Learning :</strong> Ajustement continu selon rÃ©ponse individuelle</li>
                            <li><strong>Digital Twins :</strong> Jumeaux numÃ©riques mÃ©taboliques</li>
                            <li><strong>Computer Vision :</strong> Estimation portions par photo</li>
                            <li><strong>Blockchain nutrition :</strong> TraçabilitÃ© Ã©nergÃ©tique aliments</li>
                            <li><strong>Capteurs IoT :</strong> Monitoring environnemental continu</li>
                        </ul>
                        
                        <div class="card mt-3 border-info">
                            <div class="card-header bg-info text-white">
                                <small>Applications Ã©mergentes 2024</small>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li><strong>MyFitnessPal AI :</strong> Reconnaissance alimentaire automatique</li>
                                    <li><strong>Nutrino/Suggestic :</strong> Recommandations personnalisÃ©es IA</li>
                                    <li><strong>DayTwo :</strong> Nutrition basÃ©e sur microbiome</li>
                                    <li><strong>Habit :</strong> Tests gÃ©nÃ©tiques + coaching mÃ©tabolique</li>
                                    <li><strong>Virta Health :</strong> ThÃ©rapie mÃ©tabolique digitale</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommandations Pratiques -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-lightbulb me-2"></i>
                    Recommandations Pratiques et Personnalisation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6>StratÃ©gies d'Optimisation MÃ©tabolique</h6>
                        <ul class="small">
                            <li><strong>Timing nutritionnel :</strong> Synchronisation circadienne</li>
                            <li><strong>FrÃ©quence repas :</strong> 3-6 repas selon profil</li>
                            <li><strong>Hydratation :</strong> Impact sur TEF (+3-5%)</li>
                            <li><strong>TempÃ©rature aliments :</strong> ThermogenÃ¨se adaptative</li>
                            <li><strong>Mastication :</strong> Augmentation TEF mÃ©canique</li>
                            <li><strong>ActivitÃ© post-prandiale :</strong> Marche digestive</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Personnalisation selon Profil</h6>
                        <ul class="small">
                            <li><strong>AthlÃ¨tes :</strong> PÃ©riodisation Ã©nergÃ©tique</li>
                            <li><strong>SÃ©dentaires :</strong> Focus sur NEAT et TEF</li>
                            <li><strong>Seniors :</strong> PrÃ©vention sarcopÃ©nie</li>
                            <li><strong>MÃ©taboliquement malades :</strong> Restriction contrôlÃ©e</li>
                            <li><strong>Femmes enceintes :</strong> Besoins Ã©volutifs</li>
                            <li><strong>Pathologies :</strong> Adaptations spÃ©cifiques</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Surveillance et Ajustements</h6>
                        <ul class="small">
                            <li><strong>Biomarqueurs :</strong> Suivi mÃ©tabolique rÃ©gulier</li>
                            <li><strong>Composition corporelle :</strong> DEXA bi-annuel</li>
                            <li><strong>Performance :</strong> Tests fonctionnels</li>
                            <li><strong>Bien-être :</strong> Ã©nergie, sommeil, humeur</li>
                            <li><strong>Adaptation mÃ©tabolique :</strong> PrÃ©vention plateaux</li>
                            <li><strong>FlexibilitÃ© mÃ©tabolique :</strong> Tests substrats</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-success mt-4">
                    <h6><i class="fas fa-rocket me-2"></i>Vision 2024</h6>
                    <p class="mb-0">
                        L'avenir de la nutrition Ã©nergÃ©tique tend vers une approche hyper-personnalisÃ©e intÃ©grant 
                        gÃ©nÃ©tique, microbiome, lifestyle et rÃ©ponses mÃ©taboliques individuelles pour une prÃ©cision 
                        optimale des apports et dÃ©penses Ã©nergÃ©tiques.
                    </p>
                </div>
            </div>
        </div>

        <!-- Rappels Nutritionnels Fondamentaux -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-bookmark me-2"></i>
                    Rappels Nutritionnels Fondamentaux
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6>Coefficients Ã©nergÃ©tiques Standards</h6>
                        <ul class="small">
                            <li><strong>1g de protÃ©ine = 4 kcal</strong> (digestibilitÃ© 95%)</li>
                            <li><strong>1g de glucide = 4 kcal</strong> (digestibilitÃ© 98%)</li>
                            <li><strong>1g de lipide = 9 kcal</strong> (digestibilitÃ© 95%)</li>
                            <li><strong>1g d'alcool = 7 kcal</strong> (mÃ©tabolisme prioritaire)</li>
                            <li><strong>1g de fibres = 2 kcal</strong> (fermentation colique)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>RÃ©partitions Classiques ActualisÃ©es</h6>
                        <ul class="small">
                            <li><strong>Ã©quilibrÃ©e :</strong> 25% protÃ©ines, 25% lipides, 50% glucides</li>
                            <li><strong>MÃ©diterranÃ©enne :</strong> 15% protÃ©ines, 35% lipides, 50% glucides</li>
                            <li><strong>DASH :</strong> 20% protÃ©ines, 25% lipides, 55% glucides</li>
                            <li><strong>CÃ©togÃ¨ne :</strong> 25% protÃ©ines, 70% lipides, 5% glucides</li>
                            <li><strong>Sportif endurance :</strong> 15% protÃ©ines, 25% lipides, 60% glucides</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <h6><i class="fas fa-exclamation-circle me-2"></i>Important</h6>
                    <p class="small mb-0">
                        Ces calculs sont des estimations. Pour un suivi prÃ©cis, particuliÃ¨rement en cas de pathologie 
                        ou d'objectifs spÃ©cifiques, consultez un professionnel de la nutrition.
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
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.card {
    transition: all 0.3s ease;
}

.table th {
    border-top: none;
}
</style>
@endpush

@push('scripts')
<script>
class KcalMacroConverter {
    constructor() {
        this.mode = 'kcalToMacros';
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        // Gestion changement de mode
        document.querySelectorAll('input[name="conversionMode"]').forEach(radio => {
            radio.addEventListener('change', (e) => this.switchMode(e.target.value));
        });
    }
    
    switchMode(mode) {
        this.mode = mode;
        const kcalInputs = document.getElementById('kcalToMacrosInputs');
        const macrosInputs = document.getElementById('macrosToKcalInputs');
        
        if (mode === 'kcalToMacros') {
            kcalInputs.classList.remove('d-none');
            macrosInputs.classList.add('d-none');
        } else {
            kcalInputs.classList.add('d-none');
            macrosInputs.classList.remove('d-none');
        }
        
        // Masquer les rÃ©sultats lors du changement de mode
        document.getElementById('conversionResults').classList.add('d-none');
    }
    
    calculateBMR(weight, height, age, gender) {
        // Formule Mifflin-St Jeor (plus prÃ©cise)
        if (gender === 'male') {
            return 10 * weight + 6.25 * height - 5 * age + 5;
        } else {
            return 10 * weight + 6.25 * height - 5 * age - 161;
        }
    }
    
    calculateTDEE(bmr, activityLevel) {
        const activityFactors = {
            sedentary: 1.2,
            light: 1.375,
            moderate: 1.55,
            active: 1.725,
            veryActive: 1.9
        };
        
        return bmr * activityFactors[activityLevel];
    }
    
    calculateAdvancedMetrics(weight, height, age, gender, activityLevel) {
        if (!weight || !height || !age) return null;
        
        const bmr = this.calculateBMR(weight, height, age, gender);
        const tdee = this.calculateTDEE(bmr, activityLevel);
        
        // Composantes Ã©nergÃ©tiques avancÃ©es
        const neat = tdee * 0.15; // NEAT (Non-Exercise Activity Thermogenesis)
        const tef = tdee * 0.10;  // TEF (Thermic Effect of Food)
        
        return {
            bmr: Math.round(bmr),
            tdee: Math.round(tdee),
            neat: Math.round(neat),
            tef: Math.round(tef)
        };
    }
    
    calculateKcalToMacros(kcal) {
        const balanced = {
            protein: Math.round((kcal * 0.25) / 4),
            fat: Math.round((kcal * 0.25) / 9),
            carb: Math.round((kcal * 0.5) / 4)
        };
        
        const lowCarb = {
            protein: Math.round((kcal * 0.30) / 4),
            fat: Math.round((kcal * 0.50) / 9),
            carb: Math.round((kcal * 0.20) / 4)
        };
        
        const highProtein = {
            protein: Math.round((kcal * 0.35) / 4),
            fat: Math.round((kcal * 0.25) / 9),
            carb: Math.round((kcal * 0.40) / 4)
        };
        
        return { balanced, lowCarb, highProtein };
    }
    
    calculateMacrosToKcal(protein, fat, carb) {
        const total = protein * 4 + fat * 9 + carb * 4;
        
        return {
            kcal: Math.round(total * 10) / 10,
            proteinPercent: Math.round((protein * 4 / total) * 100),
            fatPercent: Math.round((fat * 9 / total) * 100),
            carbPercent: Math.round((carb * 4 / total) * 100)
        };
    }
    
    displayKcalToMacrosResults(results) {
        // RÃ©gime Ã©quilibrÃ©
        document.getElementById('balancedProtein').textContent = `${results.balanced.protein}g`;
        document.getElementById('balancedFat').textContent = `${results.balanced.fat}g`;
        document.getElementById('balancedCarb').textContent = `${results.balanced.carb}g`;
        
        // Low carb
        document.getElementById('lowCarbProtein').textContent = `${results.lowCarb.protein}g`;
        document.getElementById('lowCarbFat').textContent = `${results.lowCarb.fat}g`;
        document.getElementById('lowCarbCarb').textContent = `${results.lowCarb.carb}g`;
        
        // High protein
        document.getElementById('highProteinProtein').textContent = `${results.highProtein.protein}g`;
        document.getElementById('highProteinFat').textContent = `${results.highProtein.fat}g`;
        document.getElementById('highProteinCarb').textContent = `${results.highProtein.carb}g`;
        
        document.getElementById('kcalToMacrosResults').classList.remove('d-none');
        document.getElementById('macrosToKcalResults').classList.add('d-none');
    }
    
    displayMacrosToKcalResults(results) {
        document.getElementById('totalCalories').textContent = results.kcal;
        document.getElementById('proteinPercent').textContent = `${results.proteinPercent}%`;
        document.getElementById('fatPercent').textContent = `${results.fatPercent}%`;
        document.getElementById('carbPercent').textContent = `${results.carbPercent}%`;
        
        document.getElementById('macrosToKcalResults').classList.remove('d-none');
        document.getElementById('kcalToMacrosResults').classList.add('d-none');
    }
    
    displayMetabolicResults(metrics) {
        document.getElementById('bmrMifflin').textContent = metrics.bmr;
        document.getElementById('tdeeTotal').textContent = metrics.tdee;
        document.getElementById('neatValue').textContent = metrics.neat;
        document.getElementById('tefValue').textContent = metrics.tef;
        
        // InterprÃ©tation
        let interpretation = `Votre mÃ©tabolisme de base est de ${metrics.bmr} kcal/jour. `;
        interpretation += `Avec votre niveau d'activitÃ©, vos besoins totaux sont estimÃ©s Ã ${metrics.tdee} kcal/jour. `;
        interpretation += `L'activitÃ© non-sportive reprÃ©sente environ ${metrics.neat} kcal et l'effet thermique des aliments ${metrics.tef} kcal.`;
        
        document.getElementById('metabolicInterpretation').textContent = interpretation;
        document.getElementById('metabolicResults').classList.remove('d-none');
    }
}

let converter;

function calculateConversion() {
    if (!converter) converter = new KcalMacroConverter();
    
    // RÃ©cupÃ©ration des donnÃ©es personnelles
    const weight = parseFloat(document.getElementById('weight').value) || 0;
    const height = parseFloat(document.getElementById('height').value) || 0;
    const age = parseInt(document.getElementById('age').value) || 0;
    const gender = document.getElementById('gender').value;
    const activityLevel = document.getElementById('activityLevel').value;
    
    if (converter.mode === 'kcalToMacros') {
        const kcal = parseFloat(document.getElementById('totalKcal').value);
        
        if (!kcal || kcal < 500 || kcal > 5000) {
            alert('Veuillez saisir une valeur entre 500 et 5000 kcal.');
            return;
        }
        
        const results = converter.calculateKcalToMacros(kcal);
        converter.displayKcalToMacrosResults(results);
        
    } else {
        const protein = parseFloat(document.getElementById('proteinGrams').value) || 0;
        const fat = parseFloat(document.getElementById('fatGrams').value) || 0;
        const carb = parseFloat(document.getElementById('carbGrams').value) || 0;
        
        if (protein === 0 && fat === 0 && carb === 0) {
            alert('Veuillez saisir au moins une valeur de macronutriment.');
            return;
        }
        
        const results = converter.calculateMacrosToKcal(protein, fat, carb);
        converter.displayMacrosToKcalResults(results);
    }
    
    // Calculs mÃ©taboliques si donnÃ©es disponibles
    if (weight > 0 && height > 0 && age > 0) {
        const metrics = converter.calculateAdvancedMetrics(weight, height, age, gender, activityLevel);
        if (metrics) {
            converter.displayMetabolicResults(metrics);
        }
    }
    
    // Afficher les rÃ©sultats
    document.getElementById('conversionResults').classList.remove('d-none');
    document.getElementById('conversionResults').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetForm() {
    // RÃ©initialiser tous les champs
    document.getElementById('totalKcal').value = '';
    document.getElementById('proteinGrams').value = '';
    document.getElementById('fatGrams').value = '';
    document.getElementById('carbGrams').value = '';
    document.getElementById('weight').value = '';
    document.getElementById('height').value = '';
    document.getElementById('age').value = '';
    document.getElementById('gender').value = 'male';
    document.getElementById('activityLevel').value = 'sedentary';
    
    // RÃ©initialiser le mode
    document.getElementById('kcalToMacros').checked = true;
    document.getElementById('kcalToMacrosInputs').classList.remove('d-none');
    document.getElementById('macrosToKcalInputs').classList.add('d-none');
    
    // Masquer les rÃ©sultats
    document.getElementById('conversionResults').classList.add('d-none');
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    converter = new KcalMacroConverter();
});
</script>
@endpush