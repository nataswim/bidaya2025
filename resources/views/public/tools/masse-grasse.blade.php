@extends('layouts.public')

@section('title', 'Calculateur Masse Grasse AvancÃ© & Composition Corporelle - Analyse Scientifique')
@section('meta_description', 'Calculez votre pourcentage de masse grasse avec 4 mÃ©thodes validÃ©es : US Navy, Deurenberg, Jackson-Pollock, Covert Bailey. Normes par âge/sexe et conseils santÃ©.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="fas fa-weight"></i>
            Calculateur de Masse Grasse AvancÃ©
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-microscope text-info me-3 mt-1"></i>
                <div class="text-dark">
                    Analysez votre composition corporelle avec 4 mÃ©thodes validÃ©es scientifiquement et les derniÃ¨res recherches en adipositÃ©
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculateur -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Calculateur Multi-MÃ©thodes</h3>
                
                <!-- DonnÃ©es de base -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="fw-bold mb-2">Sexe</label>
                        <select id="gender" class="form-select form-select-lg border-primary">
                            <option value="male">Homme</option>
                            <option value="female">Femme</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold mb-2">Âge</label>
                        <input type="number" id="age" class="form-control form-control-lg border-primary" 
                               placeholder="30" min="10" max="120">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold mb-2">Taille (cm)</label>
                        <input type="number" id="height" class="form-control form-control-lg border-primary" 
                               placeholder="175" min="100" step="1">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold mb-2">Poids (kg)</label>
                        <input type="number" id="weight" class="form-control form-control-lg border-primary" 
                               placeholder="70" min="30" step="0.1">
                    </div>
                </div>

                <!-- Mesures circonfÃ©rentielles -->
                <h5 class="fw-bold mb-3 text-warning">
                    <i class="fas fa-ruler-combined me-2"></i>
                    Mesures CirconfÃ©rentielles (cm)
                </h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="fw-bold mb-2">Tour de cou</label>
                        <input type="number" id="neck" class="form-control form-control-lg border-warning" 
                               placeholder="38" min="25" step="0.5">
                        <small class="text-muted">Requis pour US Navy</small>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold mb-2">Tour de taille</label>
                        <input type="number" id="waist" class="form-control form-control-lg border-warning" 
                               placeholder="85" min="50" step="0.5">
                        <small class="text-muted">Requis pour US Navy</small>
                    </div>
                    <div class="col-md-4" id="hipField">
                        <label class="fw-bold mb-2">Tour de hanches</label>
                        <input type="number" id="hip" class="form-control form-control-lg border-warning" 
                               placeholder="95" min="50" step="0.5">
                        <small class="text-muted">Requis pour femmes US Navy</small>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold mb-2">Tour de poignet (optionnel)</label>
                        <input type="number" id="wrist" class="form-control form-control-lg border-info" 
                               placeholder="17" min="10" step="0.5">
                        <small class="text-muted">Pour mÃ©thode Covert Bailey</small>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold mb-2">Tour d'avant-bras (optionnel)</label>
                        <input type="number" id="forearm" class="form-control form-control-lg border-info" 
                               placeholder="28" min="15" step="0.5">
                        <small class="text-muted">Pour mÃ©thode Covert Bailey</small>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg px-4 py-3 fw-bold w-100" onclick="calculateBodyFat()">
                            <i class="fas fa-calculator me-2"></i>Analyser ma composition
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary btn-lg px-4 py-3 fw-bold w-100" onclick="resetForm()">
                            <i class="fas fa-redo me-2"></i>RÃ©initialiser
                        </button>
                    </div>
                </div>

                <!-- RÃ©sultats -->
                <div id="results" class="d-none">
                    <div class="alert alert-success">
                        <h5 class="alert-heading">
                            <i class="fas fa-chart-pie me-2"></i>Analyse de Votre Composition Corporelle
                        </h5>
                        
                        <div class="row g-3 mt-3" id="resultsContent">
                            <!-- Les rÃ©sultats seront injectÃ©s ici par JavaScript -->
                        </div>
                        
                        <div id="categoryInfo" class="mt-3">
                            <!-- Informations sur la catÃ©gorie seront injectÃ©es ici -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MÃ©thodes de Calcul -->
<section class="py-5">
    <div class="container">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-flask me-2"></i>
                    MÃ©thodes de Calcul UtilisÃ©es
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-anchor me-2"></i>US Navy (Gold Standard)
                                </h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Principe :</strong> CirconfÃ©rences corporelles</p>
                                <p><strong>PrÃ©cision :</strong> ±3-5% vs DEXA</p>
                                <p><strong>Avantages :</strong> Simple, accessible, reproductible</p>
                                <p><strong>Mesures requises :</strong> Cou, taille, hanches (femmes)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Deurenberg
                                </h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Principe :</strong> IMC + âge + sexe</p>
                                <p><strong>PrÃ©cision :</strong> ±4-6% population gÃ©nÃ©rale</p>
                                <p><strong>Avantages :</strong> TrÃ¨s simple, largement utilisÃ©e</p>
                                <p><strong>Limitation :</strong> BasÃ©e sur population europÃ©enne</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-dumbbell me-2"></i>Jackson-Pollock
                                </h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Principe :</strong> Approximation simplifiÃ©e</p>
                                <p><strong>PrÃ©cision :</strong> ±4-7% avec plis cutanÃ©s complets</p>
                                <p><strong>Version utilisÃ©e :</strong> Estimation basÃ©e IMC</p>
                                <p><strong>Usage :</strong> Comparaison relative</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-ruler me-2"></i>Covert Bailey
                                </h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Principe :</strong> Multi-circonfÃ©rences</p>
                                <p><strong>PrÃ©cision :</strong> ±3-6% si mesures prÃ©cises</p>
                                <p><strong>Avantages :</strong> ConsidÃ¨re ossature</p>
                                <p><strong>Mesures :</strong> Poignet, avant-bras additionnels</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Normes par Âge et Sexe -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-users me-2"></i>
                    Normes de Masse Grasse par Âge et Sexe
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-center mb-3">
                            <i class="fas fa-mars text-primary me-2"></i>Hommes
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>CatÃ©gorie</th>
                                        <th>20-39 ans</th>
                                        <th>40-59 ans</th>
                                        <th>60+ ans</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-danger">
                                        <td><strong>Trop faible</strong></td>
                                        <td>&lt; 8%</td>
                                        <td>&lt; 8%</td>
                                        <td>&lt; 8%</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><strong>AthlÃ©tique</strong></td>
                                        <td>8-19%</td>
                                        <td>8-19%</td>
                                        <td>8-19%</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Excellent</strong></td>
                                        <td>10-14%</td>
                                        <td>11-16%</td>
                                        <td>13-18%</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Bon</strong></td>
                                        <td>15-19%</td>
                                        <td>17-21%</td>
                                        <td>19-23%</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Moyen</strong></td>
                                        <td>20-24%</td>
                                        <td>22-27%</td>
                                        <td>24-29%</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Ã©levÃ©</strong></td>
                                        <td>&gt; 25%</td>
                                        <td>&gt; 28%</td>
                                        <td>&gt; 30%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-center mb-3">
                            <i class="fas fa-venus text-danger me-2"></i>Femmes
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>CatÃ©gorie</th>
                                        <th>20-39 ans</th>
                                        <th>40-59 ans</th>
                                        <th>60+ ans</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-danger">
                                        <td><strong>Trop faible</strong></td>
                                        <td>&lt; 16%</td>
                                        <td>&lt; 16%</td>
                                        <td>&lt; 16%</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><strong>AthlÃ©tique</strong></td>
                                        <td>16-24%</td>
                                        <td>16-24%</td>
                                        <td>16-24%</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Excellent</strong></td>
                                        <td>17-21%</td>
                                        <td>18-23%</td>
                                        <td>20-25%</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Bon</strong></td>
                                        <td>22-25%</td>
                                        <td>24-28%</td>
                                        <td>26-30%</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Moyen</strong></td>
                                        <td>26-31%</td>
                                        <td>29-34%</td>
                                        <td>31-36%</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Ã©levÃ©</strong></td>
                                        <td>&gt; 32%</td>
                                        <td>&gt; 35%</td>
                                        <td>&gt; 37%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important :</strong> Ces normes sont indicatives et peuvent varier selon l'origine ethnique, 
                    le niveau d'activitÃ© physique et les objectifs personnels.
                </div>
            </div>
        </div>

        <!-- Implications SantÃ© -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-heartbeat me-2"></i>
                    Implications pour la SantÃ©
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-danger h-100">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">Masse Grasse Trop Faible</h6>
                            </div>
                            <div class="card-body">
                                <h6>Risques :</h6>
                                <ul class="small">
                                    <li>Dysfonctions hormonales</li>
                                    <li>SystÃ¨me immunitaire affaibli</li>
                                    <li>Troubles de la reproduction</li>
                                    <li>FragilitÃ© osseuse</li>
                                </ul>
                                <div class="alert alert-danger alert-sm">
                                    <small><strong>Action :</strong> Consultation mÃ©dicale recommandÃ©e</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Niveau Optimal</h6>
                            </div>
                            <div class="card-body">
                                <h6>BÃ©nÃ©fices :</h6>
                                <ul class="small">
                                    <li>Ã©quilibre hormonal optimal</li>
                                    <li>Performance physique maximale</li>
                                    <li>Risque mÃ©tabolique minimal</li>
                                    <li>LongÃ©vitÃ© favorisÃ©e</li>
                                </ul>
                                <div class="alert alert-success alert-sm">
                                    <small><strong>Maintien :</strong> Poursuivre habitudes actuelles</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">Masse Grasse Ã©levÃ©e</h6>
                            </div>
                            <div class="card-body">
                                <h6>Risques :</h6>
                                <ul class="small">
                                    <li>Syndrome mÃ©tabolique</li>
                                    <li>DiabÃ¨te type 2</li>
                                    <li>Maladies cardiovasculaires</li>
                                    <li>Inflammation chronique</li>
                                </ul>
                                <div class="alert alert-warning alert-sm">
                                    <small><strong>Action :</strong> Programme de rÃ©duction progressif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technologies Modernes -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-cogs me-2"></i>
                    Technologies Modernes d'Ã©valuation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>MÃ©thode</th>
                                        <th>PrÃ©cision</th>
                                        <th>Coût</th>
                                        <th>AccessibilitÃ©</th>
                                        <th>Temps</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td><strong>DEXA Scan</strong></td>
                                        <td>±1-2%</td>
                                        <td>€€€</td>
                                        <td>Clinique</td>
                                        <td>10-15min</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>BIA Multi-frÃ©quence</strong></td>
                                        <td>±3-5%</td>
                                        <td>€€</td>
                                        <td>Large</td>
                                        <td>2min</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><strong>Plis cutanÃ©s (7 sites)</strong></td>
                                        <td>±3-5%</td>
                                        <td>€</td>
                                        <td>Large</td>
                                        <td>10min</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>US Navy (notre outil)</strong></td>
                                        <td>±3-5%</td>
                                        <td>€</td>
                                        <td>Universelle</td>
                                        <td>5min</td>
                                    </tr>
                                    <tr class="table-secondary">
                                        <td><strong>Bod Pod (ADP)</strong></td>
                                        <td>±2-3%</td>
                                        <td>€€€</td>
                                        <td>Centre spÃ©cialisÃ©</td>
                                        <td>5min</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>Innovations 2024</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Scanners 3D corporels</span>
                                <span class="badge bg-primary">±2%</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>IA + Computer Vision</span>
                                <span class="badge bg-info">±3%</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Wearables bioÃ©lectriques</span>
                                <span class="badge bg-secondary">±4%</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Spectroscopie NIR</span>
                                <span class="badge bg-success">±2%</span>
                            </li>
                        </ul>
                        
                        <div class="alert alert-success mt-3">
                            <small>
                                <strong>Tendance 2024 :</strong> IntÃ©gration multi-modale pour 
                                une prÃ©cision Ã©quivalente au DEXA Ã domicile.
                            </small>
                        </div>
                    </div>
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

#hipField {
    display: block;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
</style>
@endpush

@push('scripts')
<script>
// Gestion affichage champ hanches selon le sexe
document.getElementById('gender').addEventListener('change', function() {
    const hipField = document.getElementById('hipField');
    if (this.value === 'female') {
        hipField.style.display = 'block';
        hipField.querySelector('small').textContent = 'Requis pour femmes US Navy';
    } else {
        hipField.style.display = 'none';
        document.getElementById('hip').value = '';
    }
});

function calculateBodyFat() {
    const gender = document.getElementById('gender').value;
    const age = parseInt(document.getElementById('age').value);
    const height = parseFloat(document.getElementById('height').value);
    const weight = parseFloat(document.getElementById('weight').value);
    const neck = parseFloat(document.getElementById('neck').value);
    const waist = parseFloat(document.getElementById('waist').value);
    const hip = parseFloat(document.getElementById('hip').value);
    const wrist = parseFloat(document.getElementById('wrist').value);
    const forearm = parseFloat(document.getElementById('forearm').value);
    
    if (!height || !weight || !age || height <= 0 || weight <= 0 || age <= 0) {
        alert('Veuillez saisir une taille, un poids et un âge valides');
        return;
    }
    
    let results = {};
    const heightM = height / 100;
    const bmi = weight / (heightM * heightM);
    
    // 1. US Navy Formula
    if (neck && waist && neck > 0 && waist > 0) {
        if (gender === 'male') {
            results.usNavy = 495 / (1.0324 - 0.19077 * Math.log10(waist - neck) + 0.15456 * Math.log10(height)) - 450;
        } else if (hip && hip > 0) {
            results.usNavy = 495 / (1.29579 - 0.35004 * Math.log10(waist + hip - neck) + 0.22100 * Math.log10(height)) - 450;
        }
    }
    
    // 2. Deurenberg Formula
    const genderFactor = gender === 'male' ? 1 : 0;
    results.deurenberg = (1.20 * bmi) + (0.23 * age) - (10.8 * genderFactor) - 5.4;
    
    // 3. Jackson-Pollock simplified
    if (gender === 'male') {
        results.jackson = (1.61 * bmi) + (0.13 * age) - 12.1 + 4.4;
    } else {
        results.jackson = (1.48 * bmi) + (0.16 * age) - 9.7 + 4.2;
    }
    
    // 4. Covert Bailey Formula
    if (waist && wrist && forearm && waist > 0 && wrist > 0 && forearm > 0) {
        if (gender === 'male') {
            results.covert = (waist * 0.74) - (wrist * 1.4) - (weight * 0.155) + 8.2;
        } else if (hip && hip > 0) {
            results.covert = (waist * 0.8) - (wrist * 1.1) - (forearm * 0.9) + (hip * 0.4) - 2.9;
        }
    }
    
    // Arrondir tous les rÃ©sultats
    Object.keys(results).forEach(key => {
        if (results[key] !== null && !isNaN(results[key])) {
            results[key] = Math.round(results[key] * 10) / 10;
            // S'assurer que les valeurs sont positives
            if (results[key] < 0) results[key] = 0;
        }
    });
    
    // DÃ©terminer la catÃ©gorie (basÃ©e sur US Navy ou Deurenberg)
    const primaryBodyFat = results.usNavy || results.deurenberg;
    let category = '';
    let categoryColor = '';
    let healthRisk = '';
    
    if (primaryBodyFat) {
        if (gender === 'male') {
            if (primaryBodyFat < 8) { 
                category = 'Trop faible'; 
                categoryColor = 'danger'; 
                healthRisk = 'Risques hormonaux et immunitaires';
            }
            else if (primaryBodyFat < 14) { 
                category = 'AthlÃ©tique'; 
                categoryColor = 'primary'; 
                healthRisk = 'Optimal pour la performance';
            }
            else if (primaryBodyFat < 18) { 
                category = 'Excellent'; 
                categoryColor = 'success'; 
                healthRisk = 'SantÃ© optimale';
            }
            else if (primaryBodyFat < 25) { 
                category = 'Bon'; 
                categoryColor = 'info'; 
                healthRisk = 'Risque faible';
            }
            else if (primaryBodyFat < 30) { 
                category = 'Moyen'; 
                categoryColor = 'warning'; 
                healthRisk = 'Surveillance recommandÃ©e';
            }
            else { 
                category = 'Ã©levÃ©'; 
                categoryColor = 'danger'; 
                healthRisk = 'Risques mÃ©taboliques';
            }
        } else {
            if (primaryBodyFat < 16) { 
                category = 'Trop faible'; 
                categoryColor = 'danger'; 
                healthRisk = 'Risques hormonaux et reproduction';
            }
            else if (primaryBodyFat < 21) { 
                category = 'AthlÃ©tique'; 
                categoryColor = 'primary'; 
                healthRisk = 'Optimal pour la performance';
            }
            else if (primaryBodyFat < 25) { 
                category = 'Excellent'; 
                categoryColor = 'success'; 
                healthRisk = 'SantÃ© optimale';
            }
            else if (primaryBodyFat < 32) { 
                category = 'Bon'; 
                categoryColor = 'info'; 
                healthRisk = 'Risque faible';
            }
            else if (primaryBodyFat < 38) { 
                category = 'Moyen'; 
                categoryColor = 'warning'; 
                healthRisk = 'Surveillance recommandÃ©e';
            }
            else { 
                category = 'Ã©levÃ©'; 
                categoryColor = 'danger'; 
                healthRisk = 'Risques mÃ©taboliques';
            }
        }
    }
    
    displayResults(results, category, categoryColor, healthRisk, bmi);
}

function displayResults(results, category, categoryColor, healthRisk, bmi) {
    let resultsHTML = '';
    
    // US Navy (prioritaire)
    if (results.usNavy) {
        resultsHTML += `
            <div class="col-md-3">
                <div class="card border-primary h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-anchor me-1"></i>US Navy
                        </h6>
                        <p class="card-text fs-3">
                            <strong class="text-primary">${results.usNavy}%</strong>
                        </p>
                        <span class="badge bg-${categoryColor}">
                            ${category}
                        </span>
                        <div class="mt-2">
                            <small class="text-muted">Gold Standard</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Deurenberg
    if (results.deurenberg) {
        resultsHTML += `
            <div class="col-md-3">
                <div class="card border-warning h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-line me-1"></i>Deurenberg
                        </h6>
                        <p class="card-text fs-4">
                            <strong class="text-warning">${results.deurenberg}%</strong>
                        </p>
                        <small class="text-muted">IMC + âge + sexe</small>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Jackson-Pollock
    if (results.jackson) {
        resultsHTML += `
            <div class="col-md-3">
                <div class="card border-info h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-dumbbell me-1"></i>Jackson-Pollock
                        </h6>
                        <p class="card-text fs-5">
                            <strong class="text-info">${results.jackson}%</strong>
                        </p>
                        <small class="text-muted">Estimation simplifiÃ©e</small>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Covert Bailey
    if (results.covert) {
        resultsHTML += `
            <div class="col-md-3">
                <div class="card border-secondary h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-ruler me-1"></i>Covert Bailey
                        </h6>
                        <p class="card-text fs-5">
                            <strong class="text-secondary">${results.covert}%</strong>
                        </p>
                        <small class="text-muted">Multi-circonfÃ©rences</small>
                    </div>
                </div>
            </div>
        `;
    }
    
    document.getElementById('resultsContent').innerHTML = resultsHTML;
    
    // Informations catÃ©gorie
    if (category) {
        document.getElementById('categoryInfo').innerHTML = `
            <div class="card border-${categoryColor}">
                <div class="card-header bg-${categoryColor} ${categoryColor === 'warning' ? 'text-dark' : 'text-white'}">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Ã©valuation : ${category}
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Implications santÃ© :</strong> ${healthRisk}</p>
                    <p class="mb-0"><strong>IMC de rÃ©fÃ©rence :</strong> ${bmi.toFixed(1)}</p>
                </div>
            </div>
        `;
    }
    
    document.getElementById('results').classList.remove('d-none');
    document.getElementById('results').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function resetForm() {
    document.getElementById('gender').value = 'male';
    document.getElementById('age').value = '';
    document.getElementById('height').value = '';
    document.getElementById('weight').value = '';
    document.getElementById('neck').value = '';
    document.getElementById('waist').value = '';
    document.getElementById('hip').value = '';
    document.getElementById('wrist').value = '';
    document.getElementById('forearm').value = '';
    document.getElementById('results').classList.add('d-none');
    
    // RÃ©afficher le champ hanches si nÃ©cessaire
    const hipField = document.getElementById('hipField');
    hipField.style.display = 'block';
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // DÃ©marrer avec le champ hanches visible (dÃ©faut homme)
    const hipField = document.getElementById('hipField');
    hipField.style.display = 'block';
});
</script>
@endpush