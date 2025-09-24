@extends('layouts.public')

@section('title', 'Outils Sports Aquatiques & Natation - Analyse Technique et Performance Evidence-Based')
@section('meta_description', 'Suite complÃ¨te d\'outils scientifiques pour natation et sports aquatiques : prÃ©diction performance, planification, technique, VNC, triathlon. Approche sÃ©curisÃ©e et biomÃ©canique.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-info text-white">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('tools.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-home me-1"></i>Outils
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    Sports Aquatiques & Natation
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-swimmer me-3"></i>
                    Sports Aquatiques & Natation
                </h1>
                <p class="lead mb-4">
                    Suite complÃ¨te d'outils scientifiques pour optimiser votre pratique aquatique. 
                    Analyse technique, planification, prÃ©diction performance basÃ©es sur la biomÃ©canique et la physiologie aquatique.
                </p>
                <div class="alert alert-warning border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-water me-2"></i>
                        <strong>6 outils disponibles</strong> - De l'initiation Ã l'expertise technique
                    </small>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle p-4 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-swimmer text-white" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avertissement sÃ©curitÃ© aquatique -->
<section class="py-4 bg-warning">
    <div class="container">
        <div class="alert alert-dark border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-life-ring fa-2x text-dark"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2">SÃ©curitÃ© Aquatique Prioritaire</h6>
                    <p class="mb-0 small">
                        <strong>La natation nÃ©cessite des compÃ©tences aquatiques solides et une surveillance appropriÃ©e.</strong> 
                        Ne nagez jamais seul, respectez votre niveau technique, et assurez-vous de la prÃ©sence de secours qualifiÃ©s. 
                        Ces outils d'analyse ne remplacent pas l'apprentissage technique avec un maître-nageur qualifiÃ© 
                        ni les rÃ¨gles de sÃ©curitÃ© aquatique fondamentales.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Outils de la catÃ©gorie -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            <!-- 1. PrÃ©diction Performance Natation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.swimming-predictor') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-chart-line text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">PrÃ©diction Performance Natation</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Analyse et prÃ©diction scientifique des performances natation sur diffÃ©rentes distances. 
                                        ModÃ¨les mathÃ©matiques validÃ©s pour planification objetifs et Ã©valuation progression.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>5-8 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Planificateur Natation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.swimming-planner') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-calendar-alt text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Planificateur Natation</h5>
                                        <span class="badge bg-primary ms-2">AvancÃ©</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        SÃ©ances et pÃ©riodisation d'entraînement natation personnalisÃ©es. 
                                        Structure progressive respectant les principes physiologiques et techniques.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>8-12 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Planificateur Triathlon -->
            <div class="col-lg-6">
                <a href="{{ route('tools.triathlon-planner') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-medal text-warning" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Planificateur Triathlon</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Entraînement multidisciplinaire scientifique intÃ©grant natation, cyclisme et course. 
                                        PÃ©riodisation Ã©quilibrÃ©e et gestion des transitions spÃ©cifiques.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>10-15 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 4. VNC - Vitesse Critique Natation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.vnc') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-tachometer-alt text-warning" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">VNC - Vitesse Critique Natation</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Vitesse de Nage Critique et seuils mÃ©taboliques personnalisÃ©s. 
                                        DÃ©termination zones d'entraînement spÃ©cifiques Ã la natation.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>6-10 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 5. EfficacitÃ© Technique Natation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.swimming-efficiency') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-ruler text-success" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">EfficacitÃ© Technique Natation</h5>
                                        <span class="badge bg-success ms-2">Essentiel</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Calculateur DPS (Distance Par Stroke) et SWOLF pour analyse efficacitÃ© technique. 
                                        Comparaisons normatives et recommandations d'amÃ©lioration.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>3-5 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 6. ChronomÃ¨tre Natation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.chronometre') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-stopwatch text-warning" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">ChronomÃ¨tre Natation</h5>
                                        <span class="badge bg-success ms-2">Essentiel</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        ChronomÃ©trage spÃ©cialisÃ© natation et sports aquatiques. 
                                        Interface optimisÃ©e pour suivi sÃ©ances et calculs automatiques.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>En temps rÃ©el</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Navigation -->
        <div class="row g-3 mt-5">
            <div class="col-md-6">
                <a href="{{ route('tools.category.cardiac') }}" class="btn btn-outline-info btn-lg w-100">
                    <i class="fas fa-arrow-left me-2"></i>Performance Cardiaque
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tools.category.running') }}" class="btn btn-info btn-lg w-100">
                    Course & Endurance <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- BiomÃ©canique et technique natation -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-cogs me-2"></i>
                    BiomÃ©canique et Technique en Natation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info">Principes BiomÃ©caniques Fondamentaux</h6>
                        <p class="small">
                            La natation est unique par sa dimension tridimensionnelle et l'absence d'appui fixe. 
                            L'efficacitÃ© rÃ©sulte de l'Ã©quilibre entre forces propulsives et rÃ©sistances hydrodynamiques. 
                            La technique prime sur la force pure, rendant l'apprentissage progressif essentiel.
                        </p>
                        
                        <h6 class="text-primary mt-3">Facteurs de Performance</h6>
                        <ul class="small">
                            <li><strong>Hydrodynamisme :</strong> Position corps, alignement, rÃ©duction traînÃ©e</li>
                            <li><strong>Propulsion :</strong> EfficacitÃ© prise d'appui, coordination gestuelle</li>
                            <li><strong>Respiration :</strong> Technique adaptÃ©e, perturbation minimale</li>
                            <li><strong>Coordination :</strong> Synchronisation bras-jambes-respiration</li>
                            <li><strong>Rythme :</strong> Amplitude vs frÃ©quence selon distance</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Progression Technique SÃ©curisÃ©e</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Ã©tape</th>
                                        <th>Objectif</th>
                                        <th>DurÃ©e</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Familiarisation</td>
                                        <td>Aisance aquatique, flottaison</td>
                                        <td>4-8 semaines</td>
                                    </tr>
                                    <tr>
                                        <td>Technique base</td>
                                        <td>Mouvement fondamentaux</td>
                                        <td>8-16 semaines</td>
                                    </tr>
                                    <tr>
                                        <td>Coordination</td>
                                        <td>Synchronisation globale</td>
                                        <td>12-24 semaines</td>
                                    </tr>
                                    <tr>
                                        <td>Perfectionnement</td>
                                        <td>EfficacitÃ©, automatisation</td>
                                        <td>Processus continu</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-warning alert-sm mt-3">
                            <h6 class="small">Patience et Progression</h6>
                            <p class="small mb-0">
                                La technique natation demande temps et rÃ©pÃ©tition. Forcer la progression 
                                peut crÃ©er des dÃ©fauts techniques durables. La supervision qualifiÃ©e 
                                accÃ©lÃ¨re l'apprentissage correct.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SÃ©curitÃ© aquatique et prÃ©vention -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-2">
                    <i class="fas fa-life-ring me-2"></i>
                    SÃ©curitÃ© Aquatique et PrÃ©vention
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">RÃ¨gles de SÃ©curitÃ© Fondamentales</h6>
                        <ul class="small">
                            <li><strong>Jamais seul :</strong> Toujours nager accompagnÃ© ou surveillÃ©</li>
                            <li><strong>Connaître ses limites :</strong> Respecter niveau technique et condition physique</li>
                            <li><strong>Surveillance qualifiÃ©e :</strong> PrÃ©sence maître-nageur ou sauveteur</li>
                            <li><strong>Ã©quipement sÃ©curitÃ© :</strong> MatÃ©riel flottaison si nÃ©cessaire</li>
                            <li><strong>Conditions environnementales :</strong> Ã©valuer sÃ©curitÃ© lieu de nage</li>
                            <li><strong>Ã©tat physique :</strong> Ne pas nager malade, fatiguÃ© ou sous influence</li>
                        </ul>
                        
                        <div class="alert alert-danger alert-sm">
                            <h6 class="small">Signaux d'Alarme</h6>
                            <p class="small mb-0">
                                Essoufflement excessif, crampes, vertiges, panique : 
                                <strong>sortir immÃ©diatement de l'eau et signaler.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">PrÃ©vention Noyade et Accidents</h6>
                        <p class="small">
                            La noyade est silencieuse et rapide. Elle peut survenir même chez des nageurs expÃ©rimentÃ©s 
                            en cas de malaise, fatigue excessive ou conditions difficiles.
                        </p>
                        
                        <h6 class="text-success mt-3">Comportements PrÃ©ventifs</h6>
                        <ul class="small">
                            <li>Ã©chauffement progressif, surtout en eau froide</li>
                            <li>EntrÃ©e graduelle dans l'eau</li>
                            <li>Hydratation avant et aprÃ¨s la nage</li>
                            <li>Protection solaire et thermique adaptÃ©e</li>
                            <li>Signalement de sa prÃ©sence au personnel</li>
                            <li>Connaissance basiques premiers secours</li>
                        </ul>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Eau Libre - PrÃ©cautions RenforcÃ©es</h6>
                            <p class="small mb-0">
                                Mer, lac, riviÃ¨re nÃ©cessitent expÃ©rience et prÃ©cautions supplÃ©mentaires : 
                                courants, tempÃ©rature, visibilitÃ©, faune aquatique.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physiologie aquatique -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-lungs me-2"></i>
                    Physiologie et Adaptations Aquatiques
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Adaptations Cardiovasculaires</h6>
                        <p class="small">
                            L'immersion modifie la distribution sanguine (effet de compression hydrostatique) 
                            et la thermorÃ©gulation. La FC en natation est gÃ©nÃ©ralement 10-15 bpm infÃ©rieure 
                            Ã la course Ã allure Ã©quivalente.
                        </p>
                        
                        <h6 class="text-success mt-3">Respiration en Natation</h6>
                        <ul class="small">
                            <li><strong>Contrôle respiratoire :</strong> Expiration complÃ¨te sous l'eau</li>
                            <li><strong>Timing :</strong> Inspiration rapide, expiration prolongÃ©e</li>
                            <li><strong>BilatÃ©rale :</strong> DÃ©veloppement Ã©quilibre musculaire</li>
                            <li><strong>Hypoxie modÃ©rÃ©e :</strong> Adaptation progressive, sÃ©curisÃ©e</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info">Adaptations Musculaires</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>SystÃ¨me</th>
                                        <th>Adaptation</th>
                                        <th>BÃ©nÃ©fice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cardiovasculaire</td>
                                        <td>EfficacitÃ© pompe cardiaque</td>
                                        <td>Endurance gÃ©nÃ©rale</td>
                                    </tr>
                                    <tr>
                                        <td>Respiratoire</td>
                                        <td>CapacitÃ© et contrôle</td>
                                        <td>Gestion apnÃ©e</td>
                                    </tr>
                                    <tr>
                                        <td>Musculaire</td>
                                        <td>Coordination fine</td>
                                        <td>EfficacitÃ© gestuelle</td>
                                    </tr>
                                    <tr>
                                        <td>Articulaire</td>
                                        <td>MobilitÃ©, souplesse</td>
                                        <td>Amplitude mouvement</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">BÃ©nÃ©fices SantÃ© Globale</h6>
                            <p class="small mb-0">
                                Natation : sport complet, faible impact articulaire, 
                                dÃ©veloppement harmonieux, accessible tous âges.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approche Ã©quilibrÃ©e entraînement -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-balance-scale me-2"></i>
                    Approche Ã©quilibrÃ©e de l'Entraînement Aquatique
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">Principes d'Entraînement Sain</h6>
                        <ul class="small">
                            <li><strong>Progression graduelle :</strong> Augmentation volume/intensitÃ© 10% max/semaine</li>
                            <li><strong>RÃ©cupÃ©ration intÃ©grÃ©e :</strong> Repos actif et passif nÃ©cessaires</li>
                            <li><strong>VariÃ©tÃ© technique :</strong> Travail 4 nages pour dÃ©veloppement complet</li>
                            <li><strong>Plaisir prÃ©servÃ© :</strong> Motivation et adhÃ©sion long terme</li>
                            <li><strong>Ã©coute corporelle :</strong> Adaptation selon signaux fatigue</li>
                            <li><strong>Objectifs rÃ©alistes :</strong> Progression respectant capacitÃ©s individuelles</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">PrÃ©vention Surentraînement</h6>
                        <p class="small">
                            Le surentraînement en natation peut se manifester par stagnation performance, 
                            fatigue chronique, infections rÃ©pÃ©tÃ©es, perte motivation ou troubles sommeil.
                        </p>
                        
                        <h6 class="text-info mt-3">Signaux d'Alerte</h6>
                        <ul class="small">
                            <li>FC repos Ã©levÃ©e de façon persistante</li>
                            <li>Sensation de lourdeur dans l'eau</li>
                            <li>Temps dÃ©gradÃ©s malgrÃ© l'effort</li>
                            <li>IrritabilitÃ©, troubles de l'humeur</li>
                            <li>AppÃ©tit diminuÃ©, perte de poids</li>
                            <li>Blessures Ã rÃ©pÃ©tition</li>
                        </ul>
                        
                        <div class="alert alert-warning mt-3">
                            <h6><i class="fas fa-heart me-2"></i>Bien-être Prioritaire</h6>
                            <p class="mb-0 small">
                                L'entraînement natation doit enrichir votre vie, non la dominer. 
                                <strong>SantÃ© et Ã©quilibre personnel priment sur performance.</strong> 
                                Si la natation devient source de stress ou obsession, 
                                consultez un professionnel pour retrouver une approche saine.
                            </p>
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
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.7);
}

.breadcrumb-item.active {
    color: rgba(255,255,255,0.9);
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.table th {
    border-top: none;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrÃ©e pour les cards
    const cards = document.querySelectorAll('.hover-lift');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush