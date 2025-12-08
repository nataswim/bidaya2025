@extends('layouts.public')

@section('title', 'Plateforme Sportive pour tous - nataswim')
@section('meta_description', 'Decouvrez notre plateforme dediee A la natation et au triathlon avec articles, plans d\'entrainement, fiches techniques et videos. Rejoignez notre communaute de nageurs, triathletes et coachs.')

@section('content')
<!--  Section avec Video Background -->

<section class="position-relative text-white py-5 bg-primary overflow-hidden" style="min-height: 600px;">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index: 1;">
        <source src="{{ asset('assets/images/team/nataswim.mp4') }}" type="video/mp4">
    </video>
    
    <!-- Overlay sombre pour meilleure lisibilité -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="z-index: 2;"></div>
    
    <!-- Contenu -->
    <div class="container-lg py-4 position-relative" style="z-index: 3;">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-swimmer me-3 fs-1"></i>
                    <h1 class="display-4 fw-bold mb-0">nataswim</h1>
                </div>
                
                <p class="lead mb-4">
                    Optimisez vos entraînements, développez vos connaissances et formez-vous en continu grâce à cette plateforme  dédiée aux sportifs, techniciens, préparateurs physiques, entraîneurs et coachs — du débutant au professionnel.
                </p>
            </div>
            <div class="col-lg-5">
                
    <div class="text-center">
        <div class="position-relative d-inline-block bg-white rounded-circle">
           <a href="{{ route('public.categories.index') }}"> <img src="{{ asset('assets/images/team/nataswim_app_logo_2.png') }}" 
                 alt="nataswim application pour tous" 
                 class="img-fluid" 
                 style="max-width: 200px;height: auto;box-shadow: 0 0 40px rgba(255,255,255,.8),0 0 10px #fff;border-radius: 100%;"></a>
        </div>
    </div>
</div>
        </div>
    </div>
</section>






<!-- Dernieres Publications -->
<section class="py-5">
    <div class="container-lg card shadow-lg border-0 bg-white">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        Articles
                    </h5>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @php
            $recentArticles = App\Models\Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();
            @endphp

            @forelse($recentArticles as $article)
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 h-100 hover-lift">
                    <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="height: 180px; overflow: hidden;">
                        @if($article->image)
                        <img src="{{ $article->image }}"
                            class="w-100"
                            style="object-fit: cover;"
                            alt="{{ $article->name }}">
                        @else
                        <i class="fas fa-newspaper fa-3x text-primary opacity-25"></i>
                        @endif
                    </div>

                    <div class="card-body p-3">
                        <span class="badge bg-primary-subtle text-primary mb-2">
                            {{ $article->category->name ?? 'Non catégorisé' }}
                        </span>
                        <h6 class="card-title mb-2">
                            <a href="{{ route('public.show', $article) }}"
                                class="text-decoration-none text-dark">
                                {!! Str::limit($article->name, 50) !!}
                            </a>
                        </h6>
                        @if($article->intro)
                        <p class="card-text text-muted small mb-3">
                            {!! Str::limit(strip_tags($article->intro), 80) !!}
                        </p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ $article->hits }}
                            </small>
                            <small class="text-muted">
                                {{ $article->published_at->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-newspaper fa-3x mb-3 opacity-25"></i>
                    <p>Aucun article publié récemment</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="align-items-center justify-content-between">
                    <a href="{{ route('public.index') }}" class="btn btn-lg btn-secondary d-flex align-items-center px-4 text-white" style="border-radius: 0px;">
                        <i class="fas fa-eye me-1"></i> Consulter les dossiers
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</section>




<section class="py-5" >

    <div class="container-lg card shadow-lg border-0 bg-white">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        Fiches Pratiques
                    </h5>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @php
            $recentFiches = App\Models\Fiche::where('is_published', true)
            ->where('visibility', 'public')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
                @endphp

                @forelse($recentFiches as $fiche)
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 h-100 hover-lift">
                        @if($fiche->image)
                        <img src="{{ $fiche->image }}"
                            class="w-100"
                            style="object-fit: cover;"
                            alt="{{ $fiche->title }}">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                            style="height: 180px;">
                            <i class="fas fa-file-alt fa-3x text-muted opacity-25"></i>
                        </div>
                        @endif

                        <div class="card-body p-3">
                            @if($fiche->category)
                            <span class="badge bg-primary-subtle text-primary mb-2">
                                {{ $fiche->category->name }}
                            </span>
                            @endif
                            <h6 class="card-title mb-2">
                                <a href="{{ route('public.fiches.show', [$fiche->category, $fiche]) }}"
                                    class="text-decoration-none text-dark">
                                    {!! Str::limit($fiche->title, 50) !!}
                                </a>
                            </h6>
                            @if($fiche->short_description)
                            <p class="card-text text-muted small mb-3">
                                {!! Str::limit(strip_tags($fiche->short_description), 80) !!}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>{{ $fiche->views_count ?? 0 }}
                                </small>
                                <a href="{{ route('public.fiches.show', [$fiche->category, $fiche]) }}"
                                    class="btn btn-light d-flex align-items-center px-4">
                                    Lire
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-file-alt fa-3x mb-3 opacity-25"></i>
                        <p>Aucune fiche disponible</p>
                    </div>
                </div>
                @endforelse
        </div>
<div class="row mb-4">
            <div class="col-12">
                <div class="align-items-center justify-content-between">
                    <a href="{{ route('public.fiches.index') }}" class="btn btn-lg btn-secondary d-flex align-items-center px-4 text-white" style="border-radius: 0px;">
                    <i class="fas fa-eye me-1"></i> Voir les fiches
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>











<section class="py-5 bg-primary text-white">
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
            
            <!-- 5. Dossiers -->
            <div class="col">
                <a href="{{ route('public.categories.index') }}" class="text-decoration-none">

                <div class="card h-100 shadow-lg border-0 bg-white category-card">
                    <div class="card-header bg-secondary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line me-3" style="font-size: 2rem;"></i>
                            <div class="flex-grow-1">
                                <h4 class="mb-1">Dossiers</h4>
                                <p class="mb-0 opacity-75">Articles et thématiques</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="card-text text-muted mb-3">
                            Dossiers structurées et accessibles pour vous accompagner dans votre progression avec des contenus organisés par domaine.
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary fw-bold">S'informer →</span>
                            <div class="d-flex gap-1">
                                <span class="badge bg-info">Actualites</span>
                                <span class="badge bg-success">Préparartion</span>
                                <span class="badge bg-primary">Analyses</span>
                            </div>
                        </div>
                    </div>
                </div>
                 </a>
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





<!-- Témoignages -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Ce qu'en disent nos membres</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Découvrez comment notre application aide les utilisateurs à atteindre leurs objectifs
            </p>
        </div>

        <div class="row g-4">
            <!-- Témoignage 1 -->
            <div class="col-md-4">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-4 fst-italic">
                            "Cette application a révolutionné mon approche de l'entraînement. J'ai amélioré mon 200m 
                            papillon de 3 secondes en seulement deux mois grâce aux séries personnalisées et au suivi précis."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold">S</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">Sophie E.</h5>
                                <small class="text-muted">Nageuse de compétition</small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Témoignage 2 -->
            <div class="col-md-4">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-4 fst-italic">
                            "En tant qu'entraîneur, je peux désormais gérer facilement les programmes de toute mon équipe. 
                            La possibilité de personnaliser les plans selon le niveau de chaque nageur est inestimable."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold">N</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">Nicolas G.</h5>
                                <small class="text-muted">Coach de club</small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Témoignage 3 -->
            <div class="col-md-4">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-4 fst-italic">
                            "La planification intuitive et le suivi détaillé m'ont permis d'améliorer considérablement mes 
                            performances. L'application s'est parfaitement intégrée à ma préparation pour mon premier triathlon."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold">T</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">Thomas D.</h5>
                                <small class="text-muted">Triathlète amateur</small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>


<section class="py-5 bg-primary text-white">    

       <div class="container-lg">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('public.workouts.index') }}" class="btn btn-lg btn-secondary d-flex align-items-center px-4 text-white" style="border-radius: 0px;width: 100%;">
                        <i class="fas fa-life-ring me-2"></i> Séances
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @php
                $recentWorkouts = App\Models\Workout::with(['categories.section'])
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
                @endphp

                @forelse($recentWorkouts as $workout)
                @php
                $firstCategory = $workout->categories->first();
                $section = $firstCategory?->section;
                @endphp
                @if($firstCategory && $section)
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 nataswim-ombre h-100 hover-lift">


                        <div class="card-body p-3">
                            <span class="badge bg-info-subtle text-info mb-2">
                                {{ $firstCategory->name }}
                            </span>
                            <h6 class="card-title mb-2">
                                <a href="{{ route('public.workouts.show', [$section, $firstCategory, $workout]) }}"
                                    class="text-decoration-none text-dark">
                                    {!! Str::limit($workout->title, 50) !!}
                                </a>
                            </h6>
                            @if($workout->short_description)
                            <p class="card-text text-muted small mb-3">
                                {!! Str::limit(strip_tags($workout->short_description), 80) !!}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-ruler me-1"></i>{{ $workout->formatted_total ?? 'N/A' }}
                                </small>
                                <a href="{{ route('public.workouts.show', [$section, $firstCategory, $workout]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-heartbeat fa-3x mb-3 opacity-25"></i>
                        <p>Aucune séance disponible</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
</section>


<section class="py-5">    

<div class="container-lg">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('ebook.index') }}" class="btn btn-lg btn-secondary d-flex align-items-center px-4 text-white" style="border-radius: 0px;width: 100%;">
                        <i class="fas fa-life-ring me-2"></i> Documents
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @php
                $recentDownloads = App\Models\Downloadable::with('category')
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
                @endphp

                @forelse($recentDownloads as $download)
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 nataswim-ombre h-100 hover-lift">
  

                        <div class="card-body p-3">
                            @if($download->category)
                            <span class="badge bg-primary-subtle text-primary mb-2">
                                {{ $download->category->name }}
                            </span>
                            @endif
                            <h6 class="card-title mb-2">
                                <a href="{{ route('ebook.show', [$download->category->slug, $download->slug]) }}"
                                    class="text-decoration-none text-dark">
                                    {!! Str::limit($download->title, 50) !!}
                                </a>
                            </h6>
                            @if($download->short_description)
                            <p class="card-text text-muted small mb-3">
                                {!! Str::limit(strip_tags($download->short_description), 80) !!}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-download me-1"></i>{{ $download->download_count ?? 0 }}
                                </small>
                                <a href="{{ route('ebook.show', [$download->category->slug, $download->slug]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-book fa-3x mb-3 opacity-25"></i>
                        <p>Aucun document disponible</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
</section>

<section class="py-5 bg-primary text-white">    
<!-- Derniers Exercices -->
        <div class="container-lg">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('exercices.index') }}" class="btn btn-lg btn-secondary d-flex align-items-center px-4 text-white" style="border-radius: 0px; width: 100%;">
                           <i class="fas fa-life-ring me-2"></i> Exercices
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @php
                $recentExercices = App\Models\Exercice::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
                @endphp

                @forelse($recentExercices as $exercice)
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 nataswim-ombre h-100 hover-lift">

                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">
                                <a href="{{ route('exercices.show', $exercice) }}"
                                    class="text-decoration-none text-dark">
                                    {!! Str::limit($exercice->titre, 50) !!}
                                </a>
                            </h6>
                            @if($exercice->description)
                            <p class="card-text text-muted small mb-3">
                                {!! Str::limit(strip_tags($exercice->description), 80) !!}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                                <small class="text-muted">
                                    <i class="fas fa-crosshairs me-1"></i>{{ count($exercice->muscles_cibles) }} muscle(s)
                                </small>
                                @else
                                <small class="text-muted">&nbsp;</small>
                                @endif
                                <a href="{{ route('exercices.show', $exercice) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-running fa-3x mb-3 opacity-25"></i>
                        <p>Aucun exercice disponible</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
</section>







<section class="py-5 ">
    <div class="container-lg">
        <header class="text-center mb-5">
            <h2 class="fw-bold display-6">Fonctionnalités Spécifiques</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Utilitaires 24/24 pour démocratiser l'accès aux connaissances pour tous les passionnés.
            </p>
        </header>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- formation -->
            <div class="col">

<a href="{{ route('public.catalogue.index') }}" class="text-white fw-bold text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Se Former S'informer</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Explorez nos dossiers structurées en sections thématiques pour progresser à votre rythme.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Outil planification -->
            <div class="col">
                <a href="{{ route('guideplanif') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Outil planification</h4>
                               </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                               Votre outil personnel pour organiser et suivre toutes vos activités.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Carnets Personnalisés -->
            <div class="col">

                 <a href="{{ route('guidecarnet') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Carnets Personnalisés</h4>
                               </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Organisez, sauvegardez et consultez tous vos contenus préférés en un seul endroit.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            
            
        </div>
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