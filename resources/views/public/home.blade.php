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
                    <h1 class="display-4 fw-bold mb-0">Votre plateforme digitale pour booster vos performances aquatiques</h1>
                </div>
                <p class="lead mb-4">
                    Planifiez, suivez et optimisez vos entrainements de natation et triathlon. Une plateforme complete pour nageurs, triathletes, entraineurs et coachs, du debutant au professionnel.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('public.index') }}" class="btn btn-light d-flex align-items-center px-4">
                        Decouvrir les plans d'entrainement
                        <i class="fas fa-chevron-right ms-2"></i>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light px-4">
                        Rejoindre la communaute
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
            <h2 class="fw-bold display-6">Une plateforme adaptée à tous les profils </h2>
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
                        <h3 class="h5 mb-3">Nageurs & Nageuses</h3>
                        <p class="card-text text-muted small mb-0">
                            Plans d'entrainement natation personnalisés pour tous niveaux. Techniques de nage, préparation physique et suivi de progression.
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
                            Programmes triathlon complets. Optimisez votre segment natation avec nos plans d'entrainement spécialisés.
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
                            Outils professionnels pour créer et gérer vos programmes d'entrainement natation et préparation physique.
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
                        <h3 class="h5 mb-3">BP & Étudiants </h3>
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
            <h2 class="fw-bold display-6">Des outils complets pour votre entrainement aquatique</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Tout ce dont vous avez besoin pour progresser en natation, triathlon et préparation physique
            </p>
        </header>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <article class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="bg-primary-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-clipboard-list text-primary fs-2"></i>
                        </div>
                        <h3 class="h5 mb-3">Plans d'entrainement natation</h3>
                        <p class="card-text text-muted">
                            Programmes structurés pour tous niveaux : technique, endurance, sprint. Plans hebdomadaires et cycles d'entrainement natation.
                        </p>
                        <a href="{{ route('plans.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                            Découvrir les plans
                        </a>
                    </div>
                </article>
            </div>
            
            <div class="col">
                <article class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="bg-success-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-dumbbell text-success fs-2"></i>
                        </div>
                        <h3 class="h5 mb-3">Exercices spécialisés</h3>
                        <p class="card-text text-muted">
                            Bibliothèque d'exercices natation et préparation physique. Techniques détaillées avec vidéos et conseils professionnels.
                        </p>
                        <a href="{{ route('exercices.index') }}" class="btn btn-sm btn-outline-success mt-2">
                            Voir les exercices
                        </a>
                    </div>
                </article>
            </div>
            
            <div class="col">
                <article class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="bg-warning-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-book-open text-warning fs-2"></i>
                        </div>
                        <h3 class="h5 mb-3">Fiches techniques natation</h3>
                        <p class="card-text text-muted">
                            Guides complets sur les techniques de nage, biomécanique aquatique et stratégies d'entrainement natation.
                        </p>
                        <a href="{{ route('public.fiches.index') }}" class="btn btn-sm btn-outline-warning mt-2">
                            Accéder aux fiches
                        </a>
                    </div>
                </article>
            </div>
            
            <div class="col">
                <article class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="bg-info-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-calculator text-info fs-2"></i>
                        </div>
                        <h3 class="h5 mb-3">Calculateurs performance</h3>
                        <p class="card-text text-muted">
                            Outils de calcul spécialisés : VNC, prédicteur de temps natation, zones cardiaques, planification triathlon.
                        </p>
                        <a href="{{ route('tools.index') }}" class="btn btn-sm btn-outline-info mt-2">
                            Utiliser les outils
                        </a>
                    </div>
                </article>
            </div>
            
            <div class="col">
                <article class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="bg-danger-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-chart-line text-danger fs-2"></i>
                        </div>
                        <h3 class="h5 mb-3">Suivi de progression</h3>
                        <p class="card-text text-muted">
                            Enregistrez vos performances natation, analysez votre évolution avec graphiques et statistiques détaillés.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col">
                <article class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="bg-secondary-subtle p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-download text-secondary fs-2"></i>
                        </div>
                        <h3 class="h5 mb-3">Ressources téléchargeables</h3>
                        <p class="card-text text-muted">
                            Documents PDF, vidéos d'entrainement natation, guides techniques et supports pédagogiques pour entraineurs.
                        </p>
                        <a href="{{ route('ebook.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                            Télécharger
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Temoignages -->
<section class="py-5 bg-primary text-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold">L'avis de notre communauté</h2>
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
            <p class="lead text-muted">Trois etapes simples pour optimiser vos entrainements aquatiques</p>
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
                <p class="text-muted">Enregistrez vos performances et visualisez votre evolution dans l'eau</p>
            </div>
        </div>
    </div>
</section>

<!-- Dernieres Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-water text-primary me-2"></i>Dernieres Publications
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
       
   <div class="text-center">
    <img src="{{ asset('assets/images/team/nataswim-application-banner-1.jpg') }}" 
         alt="site nataswim application" 
         class="img-fluid rounded shadow">
</div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-white">
    <div class="container-lg text-center py-4">
        <h2 class="mb-4 fw-bold">Prêt a ameliorer vos performances  ?</h2>
        <p class="lead text-muted mb-4 mx-auto" style="max-width: 700px;">
            Rejoignez des milliers de nageurs, entraineurs et triathletes qui utilisent notre plateforme pour atteindre leurs objectifs aquatiques et optimiser leurs entrainements.
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

@media (max-width: 768px) {
    .display-4 {
        font-size: 1.75rem !important;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        align-items: stretch !important;
    }
}
</style>
@endpush