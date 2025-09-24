@extends('layouts.public')

@section('title', 'Outils Force & Musculation - Approche SÃ©curisÃ©e et Progressive Evidence-Based')
@section('meta_description', 'Outils scientifiques pour musculation sÃ©curisÃ©e : calcul charges, progression graduelle, prÃ©vention blessures. Approche Ã©quilibrÃ©e privilÃ©giant santÃ© et dÃ©veloppement harmonieux.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-dark text-white">
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
                    Force & Musculation
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-dumbbell me-3"></i>
                    Force & Musculation
                </h1>
                <p class="lead mb-4">
                    DÃ©veloppement de la force avec une approche sÃ©curisÃ©e et progressive. 
                    Outils basÃ©s sur la physiologie musculaire, la biomÃ©canique sÃ©curitaire et la prÃ©vention des blessures.
                </p>
                <div class="alert alert-warning border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong>1 outil disponible</strong> - SÃ©curitÃ© et progression graduelle prioritaires
                    </small>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle p-4 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-dumbbell text-white" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avertissement sÃ©curitÃ© -->
<section class="py-4 bg-danger text-white">
    <div class="container">
        <div class="alert alert-light border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2 text-danger">SÃ©curitÃ© en Musculation - PrioritÃ© Absolue</h6>
                    <p class="mb-0 small text-dark">
                        <strong>La musculation prÃ©sente des risques de blessures graves sans supervision et progression appropriÃ©es.</strong> 
                        Apprentissage technique obligatoire avec professionnel qualifiÃ©, progression trÃ¨s graduelle, 
                        Ã©chauffement systÃ©matique et arrêt immÃ©diat en cas de douleur. 
                        Consultation mÃ©dicale recommandÃ©e avant dÃ©but, particuliÃ¨rement aprÃ¨s 40 ans ou antÃ©cÃ©dents articulaires/cardiaques.
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
            
            <!-- 1. Calculateur 1RM & Charges -->
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('tools.onermcalculator') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-weight-hanging text-danger" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h4 class="card-title mb-0 text-dark fw-bold">Calculateur 1RM & Charges d'Entraînement</h4>
                                        <span class="badge bg-primary ms-2">AvancÃ©</span>
                                    </div>
                                    <p class="card-text text-muted mb-4">
                                        Estimation de la rÃ©pÃ©tition maximale (1RM) et calcul des pourcentages d'entraînement sÃ©curisÃ©s. 
                                        Planification progressive des charges respectant les principes physiologiques 
                                        et la prÃ©vention des blessures pour un dÃ©veloppement harmonieux et durable.
                                    </p>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-graduate text-warning me-2"></i>
                                                <small class="text-warning fw-semibold">Supervision requise</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-chart-line text-success me-2"></i>
                                                <small class="text-success fw-semibold">Progression graduelle</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                <small class="text-danger fw-semibold">SantÃ© prioritaire</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-primary fw-bold fs-5">AccÃ©der Ã l'outil →</span>
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

        </div>

        <!-- Message supervision obligatoire -->
        <div class="text-center mt-5">
            <div class="card border-danger">
                <div class="card-body py-3">
                    <h6 class="text-danger mb-2">
                        <i class="fas fa-user-tie me-2"></i>Supervision Professionnelle RecommandÃ©e
                    </h6>
                    <p class="small text-muted mb-3">
                        La musculation nÃ©cessite un apprentissage technique rigoureux. 
                        L'accompagnement d'un professionnel qualifiÃ© accÃ©lÃ¨re les progrÃ¨s et prÃ©vient les blessures.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <span class="badge bg-outline-primary">Coach sportif diplômÃ©</span>
                        <span class="badge bg-outline-success">KinÃ©sithÃ©rapeute</span>
                        <span class="badge bg-outline-warning">PrÃ©parateur physique</span>
                        <span class="badge bg-outline-info">Ã©ducateur APA</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="row g-3 mt-5">
            <div class="col-md-6">
                <a href="{{ route('tools.category.running') }}" class="btn btn-outline-dark btn-lg w-100">
                    <i class="fas fa-arrow-left me-2"></i>Course & Endurance
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tools.category.practical') }}" class="btn btn-dark btn-lg w-100">
                    Outils Pratiques <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- SÃ©curitÃ© en musculation -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    SÃ©curitÃ© en Musculation - PrioritÃ© Absolue
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">Risques et Accidents Courants</h6>
                        <ul class="small">
                            <li><strong>Blessures musculaires :</strong> Ã©longations, dÃ©chirures par charge excessive</li>
                            <li><strong>Traumatismes articulaires :</strong> Entorses, luxations par mauvaise technique</li>
                            <li><strong>Blessures rachidiennes :</strong> Hernies, tassements vertÃ©braux</li>
                            <li><strong>Accidents matÃ©riel :</strong> Chute de charges, coincement</li>
                            <li><strong>Malaises cardiovasculaires :</strong> Manœuvre de Valsalva excessive</li>
                        </ul>
                        
                        <div class="alert alert-danger alert-sm">
                            <h6 class="small">Statistiques Alarmantes</h6>
                            <p class="small mb-0">
                                La musculation reprÃ©sente 15-25% des blessures sportives, 
                                souvent graves et invalidantes. <strong>La prÃ©vention est cruciale.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">RÃ¨gles de SÃ©curitÃ© Fondamentales</h6>
                        <ul class="small">
                            <li><strong>Apprentissage technique :</strong> Mouvement parfait avant charge</li>
                            <li><strong>Ã©chauffement obligatoire :</strong> 15-20 minutes minimum</li>
                            <li><strong>Progression graduelle :</strong> 5-10% augmentation maximum/semaine</li>
                            <li><strong>Supervision :</strong> PrÃ©sence partenaire ou coach pour exercices lourds</li>
                            <li><strong>MatÃ©riel vÃ©rifiÃ© :</strong> Ã©tat barres, disques, attaches</li>
                            <li><strong>Environnement sÃ©curisÃ© :</strong> Espace dÃ©gagÃ©, sol stable</li>
                        </ul>
                        
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">Principe Cardinal</h6>
                            <p class="small mb-0">
                                <strong>"Mieux vaut sous-estimer ses capacitÃ©s que risquer la blessure."</strong> 
                                La prudence permet la progression long terme.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-stop me-2"></i>Arrêt ImmÃ©diat Obligatoire</h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <ul class="small mb-0">
                                <li>Douleur articulaire aiguë</li>
                                <li>Sensation de "claquage" musculaire</li>
                                <li>Vertiges, malaise, nausÃ©es</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="small mb-0">
                                <li>Perte de contrôle technique</li>
                                <li>Fatigue excessive compromettant sÃ©curitÃ©</li>
                                <li>Douleur rachidienne (dos, nuque)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physiologie et progression -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-chart-line me-2"></i>
                    Physiologie de la Force et Progression Saine
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Adaptations Physiologiques</h6>
                        <p class="small">
                            Le dÃ©veloppement de la force implique des adaptations nerveuses (coordination, recrutement) 
                            puis structurelles (hypertrophie musculaire). Ces adaptations nÃ©cessitent du temps 
                            et une stimulation progressive pour s'installer durablement.
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>PÃ©riode</th>
                                        <th>Adaptation Principale</th>
                                        <th>Gains Attendus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0-4 semaines</td>
                                        <td>Neuromusculaire</td>
                                        <td>+15-25% force</td>
                                    </tr>
                                    <tr>
                                        <td>4-8 semaines</td>
                                        <td>Mixte</td>
                                        <td>+10-20% force</td>
                                    </tr>
                                    <tr>
                                        <td>8-16 semaines</td>
                                        <td>Hypertrophie</td>
                                        <td>+5-15% force/volume</td>
                                    </tr>
                                    <tr>
                                        <td>4+ mois</td>
                                        <td>Structurelle</td>
                                        <td>Progression plus lente</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Principes de Progression SÃ©curisÃ©e</h6>
                        <ul class="small">
                            <li><strong>Progression linÃ©aire :</strong> Augmentation graduelle et rÃ©guliÃ¨re</li>
                            <li><strong>PÃ©riodisation :</strong> Alternance phases volume/intensitÃ©</li>
                            <li><strong>RÃ©cupÃ©ration intÃ©grÃ©e :</strong> 48-72h entre sÃ©ances muscle</li>
                            <li><strong>Individualisation :</strong> Adaptation selon rÃ©ponse personnelle</li>
                            <li><strong>Monitoring :</strong> Suivi fatigue, motivation, performances</li>
                        </ul>
                        
                        <h6 class="text-warning mt-3">Signaux de Surcharge</h6>
                        <ul class="small">
                            <li>Stagnation ou rÃ©gression performances</li>
                            <li>Fatigue persistante malgrÃ© repos</li>
                            <li>Douleurs articulaires chroniques</li>
                            <li>Troubles du sommeil, irritabilitÃ©</li>
                            <li>Perte d'envie, dÃ©motivation</li>
                        </ul>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Patience NÃ©cessaire</h6>
                            <p class="small mb-0">
                                Les adaptations durables prennent des mois Ã s'installer. 
                                Forcer la progression augmente le risque de blessure sans gain.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PrÃ©vention troubles comportementaux -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-balance-scale me-2"></i>
                    Approche Ã©quilibrÃ©e et PrÃ©vention des DÃ©rives
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-warning">Risques Comportementaux</h6>
                        <p class="small">
                            La musculation peut dÃ©velopper des comportements compulsifs ou une dysmorphie corporelle. 
                            L'obsession du physique, la comparaison constante ou l'entraînement excessif 
                            peuvent nuire au bien-être mental et social.
                        </p>
                        
                        <h6 class="text-danger mt-3">Signaux d'Alarme</h6>
                        <ul class="small">
                            <li>ImpossibilitÃ© de manquer une sÃ©ance</li>
                            <li>Entraînement malgrÃ© blessures</li>
                            <li>Insatisfaction permanente physique</li>
                            <li>Comparaison obsessionnelle avec autres</li>
                            <li>NÃ©gligence obligations sociales/professionnelles</li>
                            <li>Utilisation substances pour "amÃ©liorer" rÃ©sultats</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Approche Saine RecommandÃ©e</h6>
                        <ul class="small">
                            <li><strong>Objectifs rÃ©alistes :</strong> Progression graduelle sur plusieurs annÃ©es</li>
                            <li><strong>Ã©quilibre vie :</strong> Musculation complÃ©ment, non centre existence</li>
                            <li><strong>Plaisir prÃ©servÃ© :</strong> Entraînement source satisfaction</li>
                            <li><strong>FlexibilitÃ© :</strong> Adaptation selon contraintes vie</li>
                            <li><strong>Image corporelle saine :</strong> Acceptation morphologie individuelle</li>
                            <li><strong>Perspective long terme :</strong> SantÃ© et mobilitÃ© Ã vie</li>
                        </ul>
                        
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">BÃ©nÃ©fices SantÃ© RÃ©els</h6>
                            <p class="small mb-0">
                                Musculation bien pratiquÃ©e amÃ©liore force fonctionnelle, 
                                densitÃ© osseuse, mÃ©tabolisme et confiance en soi durablement.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-hands-helping me-2"></i>Recherche d'Aide Professionnelle</h6>
                    <p class="mb-0 small">
                        Si la musculation devient source d'anxiÃ©tÃ©, d'obsession ou nuit Ã votre bien-être global, 
                        <strong>consultez un psychologue spÃ©cialisÃ© en sport ou troubles alimentaires.</strong> 
                        Il n'y a aucune honte Ã chercher de l'aide pour maintenir un rapport sain Ã l'exercice. 
                        Votre Ã©quilibre mental et social est plus important que n'importe quel objectif physique.
                    </p>
                </div>
            </div>
        </div>

        <!-- MatÃ©riel et environnement -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-tools me-2"></i>
                    MatÃ©riel et Environnement SÃ©curisÃ©s
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-secondary">Ã©quipements de SÃ©curitÃ©</h6>
                        <ul class="small">
                            <li><strong>Barres et disques :</strong> VÃ©rification Ã©tat, serrage colliers</li>
                            <li><strong>Bancs et supports :</strong> StabilitÃ©, rÃ©glages sÃ©curisÃ©s</li>
                            <li><strong>Câbles et poulies :</strong> Usure, lubrification</li>
                            <li><strong>HaltÃ¨res :</strong> Serrage, Ã©quilibre</li>
                            <li><strong>Protections :</strong> Gants, ceinture si appropriÃ©</li>
                        </ul>
                        
                        <div class="alert alert-warning alert-sm">
                            <h6 class="small">Attention MatÃ©riel DÃ©faillant</h6>
                            <p class="small mb-0">
                                Ne jamais utiliser matÃ©riel douteux. 
                                Signaler immÃ©diatement tout problÃ¨me au personnel.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info">Environnement Optimal</h6>
                        <ul class="small">
                            <li><strong>Espace suffisant :</strong> Mouvements libres, pas d'obstacle</li>
                            <li><strong>Sol stable :</strong> AntidÃ©rapant, niveau</li>
                            <li><strong>Ã©clairage adaptÃ© :</strong> VisibilitÃ© parfaite</li>
                            <li><strong>TempÃ©rature :</strong> Ni trop chaud, ni trop froid</li>
                            <li><strong>Ventilation :</strong> Air renouvelÃ©</li>
                            <li><strong>ProximitÃ© secours :</strong> Personnel formÃ© disponible</li>
                        </ul>
                        
                        <h6 class="text-success mt-3">PrÃ©paration SÃ©ance</h6>
                        <ul class="small">
                            <li>Planification exercices et charges</li>
                            <li>VÃ©rification matÃ©riel nÃ©cessaire</li>
                            <li>Ã©chauffement spÃ©cifique complet</li>
                            <li>Hydratation avant/pendant sÃ©ance</li>
                            <li>Partenaire ou supervision si exercices lourds</li>
                        </ul>
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

.badge.bg-outline-primary {
    color: #0d6efd;
    border: 1px solid #0d6efd;
    background: transparent;
}

.badge.bg-outline-success {
    color: #198754;
    border: 1px solid #198754;
    background: transparent;
}

.badge.bg-outline-warning {
    color: #ffc107;
    border: 1px solid #ffc107;
    background: transparent;
}

.badge.bg-outline-info {
    color: #0dcaf0;
    border: 1px solid #0dcaf0;
    background: transparent;
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