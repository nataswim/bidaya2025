@extends('layouts.public')

@section('title', 'Outils Pratiques & ChronomÃ©trage - Utilitaires Sportifs Professionnels')
@section('meta_description', 'Outils pratiques pour l\'entraînement sportif : chronomÃ©trage professionnel multi-athlÃ¨tes, carte interactive parcours. Interface optimisÃ©e pour coaches et sportifs.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-secondary text-white">
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
                    Outils Pratiques & ChronomÃ©trage
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-tools me-3"></i>
                    Outils Pratiques & ChronomÃ©trage
                </h1>
                <p class="lead mb-4">
                    Utilitaires pratiques pour l'entraînement et le suivi sportif. 
                    Outils optimisÃ©s pour coaches, Ã©ducateurs sportifs et pratiquants autonomes recherchant efficacitÃ© et simplicitÃ© d'usage.
                </p>
                <div class="alert alert-info border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-cogs me-2"></i>
                        <strong>2 outils disponibles</strong> - Interface intuitive et fonctionnalitÃ©s avancÃ©es
                    </small>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle p-4 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-tools text-white" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Note utilisation responsable -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="alert alert-info border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-info-circle fa-2x text-info"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2 text-info">Utilisation Responsable des Outils</h6>
                    <p class="mb-0 small">
                        <strong>Ces outils sont conçus pour faciliter l'entraînement et le suivi sportif.</strong> 
                        Respectez la confidentialitÃ© des donnÃ©es personnelles si vous chronomÃ©trez d'autres personnes. 
                        Pour la carte interactive, vÃ©rifiez toujours les conditions de sÃ©curitÃ© sur le terrain 
                        avant de planifier ou rÃ©aliser un parcours sportif.
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
            
            <!-- 1. ChronomÃ¨tre Pro Groupe -->
            <div class="col-lg-6">
                <a href="{{ route('tools.chronometre-pro') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-stopwatch text-warning" style="font-size: 1.8rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">ChronomÃ¨tre Pro Groupe</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        ChronomÃ©trage multi-athlÃ¨tes avancÃ© pour coaching professionnel. 
                                        Gestion simultanÃ©e de plusieurs coureurs avec fonctionnalitÃ©s avancÃ©es : 
                                        tours automatiques, export donnÃ©es, analyse comparative.
                                    </p>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <small class="text-success d-flex align-items-center">
                                                <i class="fas fa-users me-1"></i>Multi-athlÃ¨tes
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-info d-flex align-items-center">
                                                <i class="fas fa-download me-1"></i>Export donnÃ©es
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-primary d-flex align-items-center">
                                                <i class="fas fa-chart-bar me-1"></i>Analyse temps
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-warning d-flex align-items-center">
                                                <i class="fas fa-redo me-1"></i>Tours auto
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>Temps rÃ©el</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Carte Interactive -->
            <div class="col-lg-6">
                <a href="{{ route('tools.carte-interactive') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-map text-success" style="font-size: 1.8rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Carte Interactive</h5>
                                        <span class="badge bg-secondary ms-2">Pratique</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Planification parcours et gÃ©olocalisation sportive interactive. 
                                        CrÃ©ation d'itinÃ©raires personnalisÃ©s, calcul distances, 
                                        dÃ©nivelÃ©s et partage de parcours pour course, vÃ©lo, randonnÃ©e.
                                    </p>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <small class="text-primary d-flex align-items-center">
                                                <i class="fas fa-route me-1"></i>TracÃ© parcours
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-warning d-flex align-items-center">
                                                <i class="fas fa-mountain me-1"></i>DÃ©nivelÃ©s
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-info d-flex align-items-center">
                                                <i class="fas fa-share-alt me-1"></i>Partage facile
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-success d-flex align-items-center">
                                                <i class="fas fa-mobile-alt me-1"></i>Mobile friendly
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>5-15 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Suggestions d'usage -->
        <div class="text-center mt-5">
            <div class="card border-secondary">
                <div class="card-body py-3">
                    <h6 class="text-secondary mb-2">
                        <i class="fas fa-lightbulb me-2"></i>Suggestions d'Usage Optimal
                    </h6>
                    <p class="small text-muted mb-3">
                        Combinez ces outils avec nos calculateurs spÃ©cialisÃ©s pour une approche complÃ¨te :
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('tools.category.swimming') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-swimmer me-1"></i>ChronomÃ©trage + VNC
                        </a>
                        <a href="{{ route('tools.category.running') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-running me-1"></i>Parcours + Planificateur
                        </a>
                        <a href="{{ route('tools.category.cardiac') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-heart me-1"></i>ChronomÃ©trage + Zones FC
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="row g-3 mt-5">
            <div class="col-md-6">
                <a href="{{ route('tools.category.strength') }}" class="btn btn-outline-secondary btn-lg w-100">
                    <i class="fas fa-arrow-left me-2"></i>Force & Musculation
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tools.category.development') }}" class="btn btn-secondary btn-lg w-100">
                    Outils en DÃ©veloppement <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- Utilisation optimale des outils -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-chart-line me-2"></i>
                    Optimisation de l'Usage des Outils Pratiques
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-secondary">ChronomÃ©trage Efficace</h6>
                        <p class="small">
                            Le chronomÃ©trage prÃ©cis est essentiel pour l'Ã©valuation objective des performances 
                            et la planification d'entraînement. L'usage d'outils numÃ©riques permet une 
                            collecte de donnÃ©es fiable et une analyse comparative dans le temps.
                        </p>
                        
                        <h6 class="text-primary mt-3">Bonnes Pratiques ChronomÃ©trage</h6>
                        <ul class="small">
                            <li><strong>Standardisation :</strong> Même protocole Ã chaque test</li>
                            <li><strong>Conditions similaires :</strong> Environnement, Ã©chauffement, moment</li>
                            <li><strong>PrÃ©cision :</strong> DÃ©clenchement et arrêt nets</li>
                            <li><strong>Documentation :</strong> Contexte et conditions de mesure</li>
                            <li><strong>RÃ©pÃ©tabilitÃ© :</strong> Plusieurs mesures si possible</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Planification Parcours SÃ©curisÃ©e</h6>
                        <p class="small">
                            La planification numÃ©rique de parcours facilite la prÃ©paration mais ne remplace pas 
                            la reconnaissance terrain. La sÃ©curitÃ©, la faisabilitÃ© technique et les autorisations 
                            nÃ©cessaires doivent toujours être vÃ©rifiÃ©es sur site.
                        </p>
                        
                        <h6 class="text-warning mt-3">VÃ©rifications Essentielles</h6>
                        <ul class="small">
                            <li><strong>SÃ©curitÃ© terrain :</strong> Ã©tat, obstacles, dangers potentiels</li>
                            <li><strong>Autorisations :</strong> AccÃ¨s public, propriÃ©tÃ© privÃ©e</li>
                            <li><strong>Conditions mÃ©tÃ©o :</strong> PraticabilitÃ© selon saison</li>
                            <li><strong>Niveau technique :</strong> Adaptation capacitÃ©s du groupe</li>
                            <li><strong>Points de sortie :</strong> Secours et Ã©vacuation possibles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- ConfidentialitÃ© et Ã©thique -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    ConfidentialitÃ© et Utilisation Ã©thique
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info">Protection des DonnÃ©es Personnelles</h6>
                        <p class="small">
                            Lors du chronomÃ©trage d'autres personnes ou du partage de parcours, 
                            respectez la confidentialitÃ© des donnÃ©es personnelles et sportives. 
                            Obtenez le consentement explicite pour l'enregistrement et le partage d'informations.
                        </p>
                        
                        <h6 class="text-warning mt-3">Bonnes Pratiques RGPD</h6>
                        <ul class="small">
                            <li><strong>Consentement explicite :</strong> Accord Ã©crit si nÃ©cessaire</li>
                            <li><strong>Minimisation donnÃ©es :</strong> Collecter uniquement le nÃ©cessaire</li>
                            <li><strong>SÃ©curisation :</strong> Protection contre accÃ¨s non autorisÃ©</li>
                            <li><strong>Droit d'effacement :</strong> PossibilitÃ© de supprimer les donnÃ©es</li>
                            <li><strong>FinalitÃ© claire :</strong> Usage dÃ©fini et limitÃ©</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Usage PÃ©dagogique et Motivationnel</h6>
                        <p class="small">
                            Ces outils doivent servir l'amÃ©lioration de la performance et le plaisir de la pratique. 
                            Ã©vitez les comparaisons blessantes ou la pression excessive. 
                            PrivilÃ©giez l'encouragement et la progression individuelle.
                        </p>
                        
                        <h6 class="text-primary mt-3">Approche Constructive</h6>
                        <ul class="small">
                            <li><strong>Feedback positif :</strong> Souligner les progrÃ¨s rÃ©alisÃ©s</li>
                            <li><strong>Objectifs individualisÃ©s :</strong> Respecter les capacitÃ©s de chacun</li>
                            <li><strong>Apprentissage :</strong> Expliquer l'intÃ©rêt des mesures</li>
                            <li><strong>Motivation intrinsÃ¨que :</strong> Plaisir de l'effort et progression</li>
                            <li><strong>Bienveillance :</strong> AtmosphÃ¨re d'entraide et respect mutuel</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-users me-2"></i>ResponsabilitÃ© Ã©ducative</h6>
                    <p class="mb-0 small">
                        Si vous utilisez ces outils dans un cadre Ã©ducatif ou d'encadrement, 
                        <strong>votre responsabilitÃ© est de crÃ©er un environnement positif et sÃ©curisant.</strong> 
                        Les donnÃ©es de performance ne doivent jamais servir Ã humilier ou exclure, 
                        mais toujours Ã encourager et personnaliser l'accompagnement.
                    </p>
                </div>
            </div>
        </div>

        <!-- IntÃ©gration avec autres outils -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-link me-2"></i>
                    IntÃ©gration avec l'Ã©cosystÃ¨me d'Outils
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Synergies RecommandÃ©es</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Outil Pratique</th>
                                        <th>Combinaison Efficace</th>
                                        <th>BÃ©nÃ©fice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ChronomÃ¨tre Pro</td>
                                        <td>+ Zones Cardiaques</td>
                                        <td>Analyse intensitÃ© effort</td>
                                    </tr>
                                    <tr>
                                        <td>ChronomÃ¨tre Pro</td>
                                        <td>+ VNC Natation</td>
                                        <td>Tests seuils prÃ©cis</td>
                                    </tr>
                                    <tr>
                                        <td>Carte Interactive</td>
                                        <td>+ Planificateur Course</td>
                                        <td>Parcours personnalisÃ©s</td>
                                    </tr>
                                    <tr>
                                        <td>Carte Interactive</td>
                                        <td>+ Calculateur Hydratation</td>
                                        <td>PrÃ©paration conditions</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Workflow RecommandÃ©</h6>
                        <div class="timeline-container">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="small fw-bold">1. Planification</h6>
                                    <p class="small">Carte interactive pour parcours, calculateurs pour objectifs</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="small fw-bold">2. PrÃ©paration</h6>
                                    <p class="small">Zones cardiaques, hydratation, Ã©chauffement</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="small fw-bold">3. ExÃ©cution</h6>
                                    <p class="small">ChronomÃ©trage prÃ©cis, suivi temps rÃ©el</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="small fw-bold">4. Analyse</h6>
                                    <p class="small">Comparaison normes, planification progression</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-success alert-sm mt-3">
                            <h6 class="small">Approche Globale</h6>
                            <p class="small mb-0">
                                L'efficacitÃ© maximale provient de l'usage coordonnÃ© des outils, 
                                chacun apportant sa valeur ajoutÃ©e Ã l'ensemble du processus.
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

/* Timeline styles */
.timeline-container {
    position: relative;
    padding-left: 30px;
}

.timeline-container::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid white;
    z-index: 1;
}

.timeline-content {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 5px;
    border-left: 3px solid #dee2e6;
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