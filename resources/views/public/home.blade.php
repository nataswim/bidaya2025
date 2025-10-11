@extends('layouts.public')

@section('title', 'Accueil - Votre plateforme d\'entrainement aquatique')
@section('meta_description', 'Decouvrez notre plateforme dediee A la natation et au triathlon avec articles, plans d\'entrainement, fiches techniques et videos. Rejoignez notre communaute de nageurs, triathletes et coachs.')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg py-4">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-swimmer me-3 fs-1"></i>
                    <h1 class="display-4 fw-bold mb-0">Sport Net Systèmes</h1>
                </div>
                <p class="lead mb-4">
                    Optimisez vos entraînements, développez vos connaissances et formez-vous en continu grâce à une plateforme complète dédiée aux sportifs, techniciens, préparateurs physiques, entraîneurs et coachs — du débutant au professionnel.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('guide') }}" class="btn btn-light d-flex align-items-center px-4">
                        Decouvrir
                        <i class="fas fa-chevron-right ms-2"></i>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-light d-flex align-items-center px-4">
                        Rejoindre
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
    <div class="text-center">
        <div class="position-relative d-inline-block bg-white rounded-circle">
            <img src="{{ asset('assets/images/team/nataswim_app_logo_2.png') }}" 
                 alt="nataswim application pour tous" 
                 class="img-fluid" 
                 style="max-width: 250px; height: auto;">
        </div>
    </div>
</div>
        </div>
    </div>
</section>



<!-- Section Pour qui avec vidéo background -->
<section class="py-5 position-relative">
    <!-- Vidéo d'arrière-plan -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 1; overflow: hidden;">
        <iframe 
            src="https://www.youtube.com/embed/AhBaSV8psGA?autoplay=1&mute=1&loop=1&playlist=AhBaSV8psGA&controls=0&modestbranding=1&rel=0&showinfo=0&iv_load_policy=3" 
            frameborder="0" 
            allow="autoplay; encrypted-media" 
            allowfullscreen
            style="width: 100vw; height: 100vh; min-width: 100%; min-height: 100%; object-fit: cover; pointer-events: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
            title="Entrainement natation professionnel"
            loading="lazy">
        </iframe>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.3;"></div>
    </div>

    <!-- Contenu -->
    <div class="container-lg position-relative" style="z-index: 2;">
        <div class="text-center mb-5 text-white">
            <h2 class="fw-bold display-6">Plateforme adaptée à tous les profils </h2>
            <p class="lead">
                De l'amateur passionné au professionnel, en passant par les entraineurs et techniciens du sport
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <article class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-swimmer text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h3 class="h5 mb-3">Sportives & Sportifs</h3>
                        <p class="card-text text-muted small mb-0">
                            Plans d'entrainement pour tous personnalisés pour tous niveaux. Techniques, seances, préparation physique et suivi de progression.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <article class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body text-center p-4">
                        <div class="bg-success-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-medal text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h3 class="h5 mb-3">Triathlètes</h3>
                        <p class="card-text text-muted small mb-0">
                            Programmes triathlon complets. Optimisez votre segment natation, vélo et CAP avec nos plans d'entrainement spécialisés.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <article class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-users text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <h3 class="h5 mb-3">Entraineurs & Coachs</h3>
                        <p class="card-text text-muted small mb-0">
                            Outils professionnels pour créer et gérer vos programmes d'entrainement, plans et préparation physique.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <article class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body text-center p-4">
                        <div class="bg-info-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-graduation-cap text-info" style="font-size: 2rem;"></i>
                        </div>
                        <h3 class="h5 mb-3">Sportifs & Étudiants </h3>
                        <p class="card-text text-muted small mb-0">
                            Ressources pédagogiques, fiches techniques et outils pour votre formation en sciences du sport.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>








<!-- Fonctionnalités clés -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <header class="text-center mb-5">
            <h2 class="fw-bold display-6">Outils & contenus complets</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Tout ce dont vous avez besoin pour progresser, comprendre et améliorer vos performances
            </p>
        </header>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- 1. Séances & Plans -->
            <div class="col">
                <a href="{{ route('public.workouts.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clipboard-list me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Séances & Plans</h4>
                                    @php
                                        $workoutSectionsCount = \App\Models\WorkoutSection::where('is_active', true)->count();
                                        $workoutsCount = \App\Models\Workout::count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $workoutSectionsCount }} sections • {{ $workoutsCount }} workouts</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Programmes structurés pour tous niveaux : technique, endurance, sprint. Plans hebdomadaires et cycles d'entraînement pour les sportifs.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">Choisir vos plans →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Débutant</span>
                                    <span class="badge bg-warning">Avancé</span>
                                    <span class="badge bg-danger">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- 2. Exercices spécialisés -->
            <div class="col">
                <a href="{{ route('exercices.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-dumbbell me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Exercices spécialisés</h4>
                                    @php
                                        $exercicesCount = \App\Models\Exercice::where('is_active', true)->count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $exercicesCount }} {{ $exercicesCount > 1 ? 'exercices disponibles' : 'exercice disponible' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Bibliothèque d'exercices musculation, natation et préparation physique. Techniques détaillées avec vidéos et conseils professionnels.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-success fw-bold">Voir les exercices →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-info">Vidéos</span>
                                    <span class="badge bg-primary">Détaillés</span>
                                    <span class="badge bg-warning">Techniques</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- 3. Fiches techniques -->
            <div class="col">
                <a href="{{ route('public.fiches.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-info text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book-open me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Fiches techniques</h4>
                                    @php
                                        $fichesCount = \App\Models\Fiche::where('is_published', true)->where('visibility', 'public')->count();
                                        $fichesCategoriesCount = \App\Models\FichesCategory::where('is_active', true)->count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $fichesCategoriesCount }} catégories • {{ $fichesCount }} fiches</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Des guides complets sur les techniques, préparation physique, entraînement, sciences, stratégies et plus.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-info fw-bold">Accéder aux fiches →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Sciences</span>
                                    <span class="badge bg-primary">Techniques</span>
                                    <span class="badge bg-warning">Stratégies</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- 4. Calculateurs & Outils -->
            <div class="col">
                <a href="{{ route('tools.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-warning text-dark">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calculator me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Calculateurs & Outils</h4>
                                    <p class="mb-0 opacity-75">18 outils spécialisés disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Outils de calcul spécialisés : VNC, prédicteur de temps natation, zones cardiaques, planification triathlon.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning fw-bold">Utiliser nos outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Gratuit</span>
                                    <span class="badge bg-primary">Précis</span>
                                    <span class="badge bg-info">Pratique</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- 5. Suivi de progression -->
            <div class="col">
                <div class="card h-100 shadow-lg border-0 bg-white category-card opacity-75">
                    <div class="card-header bg-secondary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line me-3" style="font-size: 2rem;"></i>
                            <div class="flex-grow-1">
                                <h4 class="mb-1">Suivi de progression</h4>
                                <p class="mb-0 opacity-75">Bientôt disponible</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="card-text text-muted mb-3">
                            Enregistrez vos performances, analysez votre évolution avec graphiques et statistiques détaillés.
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary fw-bold">Prochainement →</span>
                            <div class="d-flex gap-1">
                                <span class="badge bg-info">Statistiques</span>
                                <span class="badge bg-success">Graphiques</span>
                                <span class="badge bg-primary">Analyses</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 6. Ressources téléchargeables -->
            <div class="col">
                <a href="{{ route('ebook.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-download me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Ressources téléchargeables</h4>
                                    @php
                                        $totalDownloads = \App\Models\Downloadable::where('status', 'active')->count();
                                        $downloadCategoriesCount = \App\Models\DownloadCategory::where('status', 'active')->count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $downloadCategoriesCount }} catégories • {{ $totalDownloads }} ressources</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Documents PDF, vidéos d'entraînement, guides techniques et supports pédagogiques pour techniciens, sportifs et entraîneurs.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-danger fw-bold">Télécharger les documents →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">PDF</span>
                                    <span class="badge bg-primary">Vidéos</span>
                                    <span class="badge bg-warning">Guides</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>








<!-- Temoignages -->
<section class="py-5 text-white" style="background-color: #2195ae;">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Avis Communauté</h2>
        </div>
        <div class="row g-4">
            @php
                $testimonials = [
                    [
                        'name' => 'Marie L. Nageuse competition',
                        'quote' => 'Les plans d entrainement natation m ont permis d améliorer mon 200m crawl de 4 secondes en 2 mois. Programmes structurés et progressifs parfaits.',
                        'role' => 'Nageuse competition'
                    ],
                    [
                        'name' => 'Thomas D. Coach natation',
                        'quote' => 'Outil indispensable pour gérer mes groupes d entrainement natation. Je crée facilement des programmes adaptés à chaque nageur.',
                        'role' => 'Entraineur'
                    ],
                    [
                        'name' => 'Sophie. Triathlete amateur',
                        'quote' => 'Parfait pour intégrer mes séances natation dans mon plan triathlon global. Calculateurs et outils très pratiques pour la préparation physique.',
                        'role' => 'Triathlete'
                    ]
                ];
            @endphp
            
            @foreach($testimonials as $testimonial)
                <div class="col-md-4">
                    <div class="card h-100 bg-white border border-info">
                        <div class="card-body p-4">
                            <p class="card-text mb-4 text-dark">"{{ $testimonial['quote'] }}"</p>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                    <i class="fas fa-swimmer text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-dark">{{ $testimonial['name'] }}</p>
                                    <small class="text-muted">{{ $testimonial['role'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Comment ça marche -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Comment ça marche ?</h2>
            <p class="lead text-muted">Trois etapes simples pour optimiser vos entrainements</p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center">
                <div class="bg-success-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-user-plus text-success fs-1"></i>
                </div>
                <h3 class="h5">1. Creez votre profil</h3>
                <p class="text-muted">Inscrivez-vous et definissez votre niveau, objectifs et specialites aquatiques</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="bg-warning-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-swimmer text-warning fs-1"></i>
                </div>
                <h3 class="h5">2. Choisissez vos plans</h3>
                <p class="text-muted">Selectionnez des programmes existants ou creez vos propres seances d'entrainement</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="bg-info-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-chart-line text-info fs-1"></i>
                </div>
                <h3 class="h5">3. Suivez vos progres</h3>
                <p class="text-muted">Enregistrez vos performances et visualisez votre evolution sportive</p>
            </div>
        </div>
    </div>
</section>

<!-- Dernieres Publications -->
<section class="py-5 text-white" style="background-color: #04b7e6; border-left: 10px solid #bb0a31;">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-water text-primary me-2"></i> Publications
            </h2>
            <a href="{{ route('public.index') }}" class="btn btn-light d-flex align-items-center px-4">
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
        {!! Str::limit(strip_tags($post->intro), 100) !!}
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
                <i class="fas fa-water me-2"></i>Aucun article n'est disponible actuellement.
            </div>
        @endif
    </div>
</section>


<!-- Dernieres Publications -->
<section class="py-5 text-white">
   <div class="text-center">
    <img src="{{ asset('assets/images/team/nataswim-application-banner-1.jpg') }}" 
         alt="site nataswim application" 
         class="img-fluid rounded shadow">
</div>
</section>



<!-- Section Credit et Contact -->
<section class="py-5 bg-primary text-white">

    <div class="container">


        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Sport Net Systèmes</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">Developpement & Expertise</h6>
                        <p class="mb-3">
                            Contenus et outils developpes par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Sciences du sport, physiologie de l'exercice et developpement 
                            d'outils d'aide A la performance sportive evidence-based.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Collaboration & Amelioration</h6>
                        <p class="mb-3 small">
                            Si vous constatez une erreur dans nos calculateurs ou souhaitez suggerer 
                            de nouveaux outils, n'hesitez pas A nous contacter.
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
                    <small class="text-light opacity-75">Recherches integrees</small>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Call to Action -->
<section class="py-5 bg-white">
    <div class="container-lg text-center py-4">
        <h2 class="mb-4 fw-bold">Prêt a ameliorer vos performances  ?</h2>
        <p class="lead text-muted mb-4 mx-auto" style="max-width: 700px;">
            Rejoignez des milliers de sportifs, entraineurs et techniciens qui utilisent notre plateforme pour atteindre leurs objectifs et optimiser leurs entrainements.
        </p>
        
        @guest
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-user-plus me-2"></i>Creer un compte
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </a>
            </div>
            <div class="mt-3">
                <a href="{{ route('public.index') }}" class="text-decoration-none">
                    Ou explorez nos contenus sans vous inscrire
                </a>
            </div>
        @else
            <div class="alert alert-success d-inline-flex align-items-center px-4 py-3">
                <i class="fas fa-check-circle me-2"></i>
                <span class="fw-medium">Bienvenue dans la communaute, {{ auth()->user()->first_name ?: auth()->user()->name }} !</span>
            </div>
        @endguest
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

/* Cards catégories - Design amélioré */
.category-card {
    transition: all 0.3s ease;
    overflow: hidden;
    border-radius: 12px;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
}

.category-card .card-header {
    border-bottom: 3px solid rgba(255,255,255,0.2);
    padding: 1.25rem;
}

.category-card .card-header h4 {
    font-size: 1.25rem;
    margin-bottom: 0.25rem;
}

/* Effets hover spécifiques par couleur */
.category-card:hover .bg-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
}

.category-card:hover .bg-success {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
}

.category-card:hover .bg-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%) !important;
}

.category-card:hover .bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #cc9a06 100%) !important;
}

.category-card:hover .bg-danger {
    background: linear-gradient(135deg, #dc3545 0%, #bb0a31 100%) !important;
}

.category-card:hover .bg-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #565e64 100%) !important;
}

/* Amélioration des badges */
.category-card .badge {
    font-size: 0.7rem;
    padding: 0.35rem 0.65rem;
    font-weight: 600;
}

.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1);
}
.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1);
}
.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1);
}
.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .display-4 {
        font-size: 1.75rem !important;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        align-items: stretch !important;
    }
    
    .category-card .card-header h4 {
        font-size: 1.1rem;
    }
    
    .category-card .card-header i {
        font-size: 1.5rem !important;
    }
    
    .category-card .badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Animation au chargement */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.category-card {
    animation: fadeInUp 0.6s ease-out;
}

.category-card:nth-child(1) { animation-delay: 0.1s; }
.category-card:nth-child(2) { animation-delay: 0.2s; }
.category-card:nth-child(3) { animation-delay: 0.3s; }
.category-card:nth-child(4) { animation-delay: 0.4s; }
.category-card:nth-child(5) { animation-delay: 0.5s; }
.category-card:nth-child(6) { animation-delay: 0.6s; }
</style>
@endpush