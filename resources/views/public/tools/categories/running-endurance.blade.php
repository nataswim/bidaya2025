@extends('layouts.public')

@section('title', 'Outils Course Ã Pied & Endurance - Planification SÃ©curisÃ©e Evidence-Based')
@section('meta_description', 'Outils scientifiques pour course Ã pied et endurance : planification progressive, prÃ©vention blessures, approche sÃ©curisÃ©e. BiomÃ©canique et physiologie de l\'endurance evidence-based.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-warning text-dark">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('tools.index') }}" class="text-dark text-decoration-none">
                        <i class="fas fa-home me-1"></i>Outils
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark" aria-current="page">
                    Course Ã Pied & Endurance
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-running me-3"></i>
                    Course Ã Pied & Endurance
                </h1>
                <p class="lead mb-4">
                    Planification intelligente et sÃ©curisÃ©e pour la course Ã pied. 
                    Approche progressive basÃ©e sur la biomÃ©canique, la physiologie de l'endurance et la prÃ©vention des blessures.
                </p>
                <div class="alert alert-info border-0 bg-white bg-opacity-75">
                    <small>
                        <i class="fas fa-route me-2"></i>
                        <strong>1 outil disponible</strong> - Planification progressive et sÃ©curisÃ©e
                    </small>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-25 rounded-circle p-4 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-running text-dark" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avertissement progression graduelle -->
<section class="py-4 bg-danger text-white">
    <div class="container">
        <div class="alert alert-light border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2 text-danger">Progression Graduelle Obligatoire</h6>
                    <p class="mb-0 small text-dark">
                        <strong>La course Ã pied prÃ©sente un risque Ã©levÃ© de blessures sans progression appropriÃ©e.</strong> 
                        Augmentation maximum 10% du volume/semaine, respect des signaux corporels, Ã©quipement adaptÃ© et 
                        consultation mÃ©dicale recommandÃ©e avant tout programme d'entraînement, particuliÃ¨rement aprÃ¨s 40 ans 
                        ou en cas d'antÃ©cÃ©dents cardiovasculaires, articulaires ou de sÃ©dentaritÃ© prolongÃ©e.
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
            
            <!-- 1. Planificateur Course Ã Pied -->
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('tools.running-planner') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-route text-primary" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h4 class="card-title mb-0 text-dark fw-bold">Planificateur Course Ã Pied</h4>
                                        <span class="badge bg-primary ms-2">AvancÃ©</span>
                                    </div>
                                    <p class="card-text text-muted mb-4">
                                        Plans d'entraînement personnalisÃ©s avec progression graduelle sÃ©curisÃ©e. 
                                        Planification intelligente respectant les principes physiologiques, 
                                        la prÃ©vention des blessures et l'adaptation individuelle pour un dÃ©veloppement durable.
                                    </p>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-shield-alt text-success me-2"></i>
                                                <small class="text-success fw-semibold">Progression sÃ©curisÃ©e</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-md text-info me-2"></i>
                                                <small class="text-info fw-semibold">Approche mÃ©dicale</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                <small class="text-danger fw-semibold">Bien-être prioritaire</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-primary fw-bold fs-5">AccÃ©der Ã l'outil →</span>
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

        </div>

        <!-- Message outils complÃ©mentaires -->
        <div class="text-center mt-5">
            <div class="card border-warning">
                <div class="card-body py-3">
                    <h6 class="text-warning mb-2">
                        <i class="fas fa-tools me-2"></i>Outils ComplÃ©mentaires RecommandÃ©s
                    </h6>
                    <p class="small text-muted mb-3">
                        Pour une approche complÃ¨te de la course Ã pied, combinez avec nos autres outils :
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('tools.category.cardiac') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-heart me-1"></i>Zones Cardiaques
                        </a>
                        <a href="{{ route('tools.category.nutrition') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-apple-alt me-1"></i>Hydratation
                        </a>
                        <a href="{{ route('tools.category.health') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-heartbeat me-1"></i>Composition Corporelle
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="row g-3 mt-5">
            <div class="col-md-6">
                <a href="{{ route('tools.category.swimming') }}" class="btn btn-outline-warning btn-lg w-100">
                    <i class="fas fa-arrow-left me-2"></i>Sports Aquatiques
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tools.category.strength') }}" class="btn btn-warning btn-lg w-100">
                    Force & Musculation <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- BiomÃ©canique de la course -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-cogs me-2"></i>
                    BiomÃ©canique et Technique de Course
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-warning">Cycle de Course et EfficacitÃ©</h6>
                        <p class="small">
                            La course implique des impacts rÃ©pÃ©tÃ©s (2-3x le poids du corps) et une coordination complexe. 
                            L'efficacitÃ© rÃ©sulte de l'Ã©quilibre entre Ã©conomie gestuelle, absorption des chocs 
                            et propulsion. La technique naturelle est gÃ©nÃ©ralement la plus efficace pour chaque individu.
                        </p>
                        
                        <h6 class="text-primary mt-3">ParamÃ¨tres Techniques ClÃ©s</h6>
                        <ul class="small">
                            <li><strong>Cadence :</strong> 170-190 pas/minute optimal pour la plupart</li>
                            <li><strong>Longueur foulÃ©e :</strong> Adaptation naturelle selon vitesse</li>
                            <li><strong>Attaque pied :</strong> Talon, mÃ©dio-pied ou avant-pied selon morphologie</li>
                            <li><strong>Posture :</strong> LÃ©gÃ¨re inclinaison avant, core engagÃ©</li>
                            <li><strong>Balancement bras :</strong> Mouvement naturel, dÃ©contractÃ©</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Progression Technique Saine</h6>
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">Principe Fondamental</h6>
                            <p class="small mb-0">
                                <strong>Ne pas forcer de changements techniques majeurs.</strong> 
                                La technique de course est largement dÃ©terminÃ©e par la morphologie individuelle. 
                                Les modifications doivent être progressives et accompagnÃ©es.
                            </p>
                        </div>
                        
                        <h6 class="text-info mt-3">Facteurs Individuels</h6>
                        <ul class="small">
                            <li>Morphologie (taille, proportions membres)</li>
                            <li>FlexibilitÃ© articulaire (cheville, hanche, thorax)</li>
                            <li>Historique blessures et adaptations</li>
                            <li>Condition physique et expÃ©rience</li>
                            <li>Type de terrain habituel</li>
                        </ul>
                        
                        <div class="alert alert-warning alert-sm">
                            <h6 class="small">Changements Techniques</h6>
                            <p class="small mb-0">
                                Toute modification technique peut initialement augmenter le risque de blessure. 
                                Progression trÃ¨s graduelle et surveillance nÃ©cessaires.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PrÃ©vention des blessures -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    PrÃ©vention des Blessures en Course Ã Pied
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">Blessures Courantes et Causes</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Blessure</th>
                                        <th>FrÃ©quence</th>
                                        <th>Cause Principale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tendinopathie d'Achille</td>
                                        <td>15-20%</td>
                                        <td>Progression trop rapide</td>
                                    </tr>
                                    <tr>
                                        <td>Syndrome rotulien</td>
                                        <td>10-15%</td>
                                        <td>DÃ©sÃ©quilibres musculaires</td>
                                    </tr>
                                    <tr>
                                        <td>PÃ©riostite tibiale</td>
                                        <td>8-12%</td>
                                        <td>Augmentation brutale volume</td>
                                    </tr>
                                    <tr>
                                        <td>Syndrome IT Band</td>
                                        <td>5-8%</td>
                                        <td>Faiblesse muscles stabilisateurs</td>
                                    </tr>
                                    <tr>
                                        <td>Fascite plantaire</td>
                                        <td>5-10%</td>
                                        <td>Raideur mollet/pied</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">StratÃ©gies PrÃ©ventives Evidence-Based</h6>
                        <ul class="small">
                            <li><strong>RÃ¨gle des 10% :</strong> Augmentation hebdomadaire maximum</li>
                            <li><strong>Renforcement ciblÃ© :</strong> Muscles stabilisateurs (hanches, core)</li>
                            <li><strong>MobilitÃ© rÃ©guliÃ¨re :</strong> Ã©tirements dynamiques prÃ©-course</li>
                            <li><strong>RÃ©cupÃ©ration programmÃ©e :</strong> Jours de repos obligatoires</li>
                            <li><strong>Ã©coute corporelle :</strong> Arrêt si douleur persistante</li>
                            <li><strong>Surfaces variÃ©es :</strong> Ã©viter monotonie (asphalte uniquement)</li>
                        </ul>
                        
                        <h6 class="text-warning mt-3">Ã©quipement PrÃ©ventif</h6>
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Chaussures de Course</h6>
                            <p class="small mb-0">
                                Ã©lÃ©ment prÃ©ventif crucial : changement tous les 500-800km, 
                                choix selon type de foulÃ©e et morphologie. 
                                <strong>Conseil spÃ©cialisÃ© en magasin recommandÃ©.</strong>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-danger mt-4">
                    <h6><i class="fas fa-stop me-2"></i>Signaux d'Arrêt ImmÃ©diat</h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <ul class="small mb-0">
                                <li>Douleur aiguë pendant la course</li>
                                <li>Douleur persistante plus de 48h</li>
                                <li>Gonflement ou inflammation visible</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="small mb-0">
                                <li>Boiterie ou compensation gestuelle</li>
                                <li>Douleur nocturne ou au repos</li>
                                <li>Symptômes systÃ©miques (fiÃ¨vre, malaise)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physiologie de l'endurance -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-heartbeat me-2"></i>
                    Physiologie de l'Endurance et Adaptations
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">SystÃ¨mes Ã©nergÃ©tiques</h6>
                        <p class="small">
                            L'endurance sollicite principalement le systÃ¨me aÃ©robie, avec contribution 
                            anaÃ©robie selon l'intensitÃ©. Les adaptations cardiovasculaires, 
                            respiratoires et musculaires s'installent progressivement (6-12 semaines minimum).
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Distance</th>
                                        <th>SystÃ¨me Principal</th>
                                        <th>DurÃ©e Effort</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5km</td>
                                        <td>AÃ©robie + AnaÃ©robie</td>
                                        <td>15-30 min</td>
                                    </tr>
                                    <tr>
                                        <td>10km</td>
                                        <td>AÃ©robie dominant</td>
                                        <td>30-60 min</td>
                                    </tr>
                                    <tr>
                                        <td>Semi-marathon</td>
                                        <td>AÃ©robie (95%)</td>
                                        <td>1h-2h30</td>
                                    </tr>
                                    <tr>
                                        <td>Marathon</td>
                                        <td>AÃ©robie (98%)</td>
                                        <td>2h30-6h</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Adaptations Chronologiques</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>PÃ©riode</th>
                                        <th>Adaptations</th>
                                        <th>Manifestations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2-4 semaines</td>
                                        <td>Neuromusculaires</td>
                                        <td>Coordination, efficacitÃ©</td>
                                    </tr>
                                    <tr>
                                        <td>4-8 semaines</td>
                                        <td>Cardiovasculaires</td>
                                        <td>FC repos, dÃ©bit cardiaque</td>
                                    </tr>
                                    <tr>
                                        <td>8-16 semaines</td>
                                        <td>MÃ©taboliques</td>
                                        <td>Enzymes, mitochondries</td>
                                    </tr>
                                    <tr>
                                        <td>3-6 mois</td>
                                        <td>Structurelles</td>
                                        <td>DensitÃ© capillaire, VO2 max</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">Patience NÃ©cessaire</h6>
                            <p class="small mb-0">
                                Les adaptations physiologiques demandent du temps. 
                                Forcer la progression peut causer blessures sans bÃ©nÃ©fice supplÃ©mentaire.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approche Ã©quilibrÃ©e -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-balance-scale me-2"></i>
                    Approche Ã©quilibrÃ©e de la Course Ã Pied
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">BÃ©nÃ©fices SantÃ© DÃ©montrÃ©s</h6>
                        <ul class="small">
                            <li><strong>Cardiovasculaire :</strong> RÃ©duction risque maladies cardiaques (-30-40%)</li>
                            <li><strong>MÃ©tabolique :</strong> AmÃ©lioration sensibilitÃ© insuline, contrôle poids</li>
                            <li><strong>Osseux :</strong> PrÃ©vention ostÃ©oporose, renforcement squelette</li>
                            <li><strong>Mental :</strong> RÃ©duction stress, anxiÃ©tÃ©, amÃ©lioration humeur</li>
                            <li><strong>Cognitif :</strong> NeuroplasticitÃ©, mÃ©moire, concentration</li>
                            <li><strong>LongÃ©vitÃ© :</strong> Augmentation espÃ©rance de vie en bonne santÃ©</li>
                        </ul>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Dose Optimale</h6>
                            <p class="small mb-0">
                                150min/semaine d'activitÃ© modÃ©rÃ©e ou 75min d'activitÃ© intense 
                                pour bÃ©nÃ©fices santÃ© maximaux selon l'OMS.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">PrÃ©vention Comportements Dysfonctionnels</h6>
                        <p class="small">
                            La course peut devenir compulsive ou excessive. Signaux d'alerte : 
                            impossibilitÃ© de repos, course malgrÃ© blessures, nÃ©gligence obligations sociales/professionnelles.
                        </p>
                        
                        <h6 class="text-info mt-3">Ã©quilibre Sain</h6>
                        <ul class="small">
                            <li>Plaisir de courir prÃ©servÃ©</li>
                            <li>FlexibilitÃ© dans la planification</li>
                            <li>Repos acceptÃ© sans culpabilitÃ©</li>
                            <li>Objectifs rÃ©alistes et adaptables</li>
                            <li>Vie sociale et familiale respectÃ©e</li>
                            <li>Ã©coute des signaux corporels</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-heart me-2"></i>PrioritÃ© Bien-être</h6>
                            <p class="mb-0 small">
                                La course doit enrichir votre vie, non la contrôler. 
                                <strong>Si courir devient une obsession ou source d'anxiÃ©tÃ©, 
                                cherchez l'aide d'un professionnel.</strong> SantÃ© mentale et physique 
                                sont indissociables pour un dÃ©veloppement harmonieux.
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
    color: rgba(0,0,0,0.7);
}

.breadcrumb-item.active {
    color: rgba(0,0,0,0.9);
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