@extends('layouts.public')

@section('title', 'Accueil - Votre plateforme d\'entraînement aquatique')
@section('meta_description', 'DÃ©couvrez notre plateforme dÃ©diÃ©e Ã la natation et au triathlon avec articles, plans d\'entraînement, fiches techniques et vidÃ©os. Rejoignez notre communautÃ© de nageurs, triathlÃ¨tes et coachs.')

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
                    Planifiez, suivez et optimisez vos entraînements de natation et triathlon. Une plateforme complÃ¨te pour nageurs, triathlÃ¨tes, entraîneurs et coachs, du dÃ©butant au professionnel.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('public.index') }}" class="btn btn-light d-flex align-items-center px-4">
                        DÃ©couvrir les plans d'entraînement
                        <i class="fas fa-chevron-right ms-2"></i>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light px-4">
                        Rejoindre la communautÃ©
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        <div class="bg-white bg-opacity-10 rounded-circle p-4" style="width: 250px; height: 250px;">
                            <div class="bg-white bg-opacity-20 rounded-circle p-4 h-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-water text-white" style="font-size: 3.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pour qui Section avec VidÃ©o Background TempoSwim -->
<section class="py-5 position-relative">
    <!-- VidÃ©o d'arriÃ¨re-plan TempoSwim -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 1; overflow: hidden;">
        <iframe 
            src="https://www.youtube.com/embed/AhBaSV8psGA?autoplay=1&mute=1&loop=1&playlist=AhBaSV8psGA&controls=0&modestbranding=1&rel=0&showinfo=0&iv_load_policy=3" 
            frameborder="0" 
            allow="autoplay; encrypted-media" 
            allowfullscreen
            style="width: 100vw; height: 100vh; min-width: 100%; min-height: 100%; object-fit: cover; pointer-events: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
            title="Video Background TempoSwim">
        </iframe>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.2;"></div>
    </div>

    <!-- Contenu -->
    <div class="container-lg position-relative" style="z-index: 2;">
        <div class="text-center mb-5 text-white">
            <h2 class="fw-bold">Pour qui est conçue cette plateforme ?</h2>
            <p class="lead">
                Une solution adaptÃ©e Ã tous les profils aquatiques, amateurs ou professionnels
            </p>
        </div>
        <div class="row g-4">
            <!-- Vos cards existantes restent identiques -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body d-flex p-4">
                        <div class="me-3">
                            <div class="bg-primary-subtle p-3 rounded-circle">
                                <i class="fas fa-swimmer text-primary fs-1"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="h5 mb-2">Nageurs et Nageuses</h3>
                            <p class="card-text text-muted small mb-0">De tous niveaux, du dÃ©butant au compÃ©titeur confirmÃ©, pour structurer et amÃ©liorer vos entraînements en piscine.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body d-flex p-4">
                        <div class="me-3">
                            <div class="bg-success-subtle p-3 rounded-circle">
                                <i class="fas fa-users text-success fs-1"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="h5 mb-2">Entraîneurs et Coachs</h3>
                            <p class="card-text text-muted small mb-0">Pour crÃ©er, partager et superviser des plans d'entraînement adaptÃ©s Ã vos athlÃ¨tes et Ã©quipes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body d-flex p-4">
                        <div class="me-3">
                            <div class="bg-warning-subtle p-3 rounded-circle">
                                <i class="fas fa-medal text-warning fs-1"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="h5 mb-2">TriathlÃ¨tes</h3>
                            <p class="card-text text-muted small mb-0">Pour optimiser votre segment natation et intÃ©grer parfaitement vos entraînements multi-disciplines.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 bg-white bg-opacity-95">
                    <div class="card-body d-flex p-4">
                        <div class="me-3">
                            <div class="bg-info-subtle p-3 rounded-circle">
                                <i class="fas fa-heart text-info fs-1"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="h5 mb-2">Amateurs PassionnÃ©s</h3>
                            <p class="card-text text-muted small mb-0">Pour progresser mÃ©thodiquement dans l'eau et atteindre vos objectifs personnels de forme et bien-être.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- FonctionnalitÃ©s clÃ©s -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold">FonctionnalitÃ©s clÃ©s</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Notre plateforme offre tous les outils nÃ©cessaires pour progresser et atteindre vos objectifs aquatiques
            </p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @php
                $features = [
                    [
                        'icon' => 'fas fa-clipboard-list',
                        'title' => 'Plans d\'Entraînement PersonnalisÃ©s',
                        'description' => 'CrÃ©ez des programmes adaptÃ©s Ã votre niveau et vos objectifs : sprint, endurance, technique, rÃ©cupÃ©ration.'
                    ],
                    [
                        'icon' => 'fas fa-dumbbell',
                        'title' => 'Exercices SpÃ©cialisÃ©s',
                        'description' => 'BibliothÃ¨que d\'exercices conçus par des entraîneurs pros pour amÃ©liorer technique, vitesse et endurance.'
                    ],
                    [
                        'icon' => 'fas fa-calendar-alt',
                        'title' => 'Organisation des SÃ©ances',
                        'description' => 'Planifiez vos entraînements, suivez votre progression et organisez vos sÃ©ances de façon optimale.'
                    ],
                    [
                        'icon' => 'fas fa-book-open',
                        'title' => 'Fiches Techniques',
                        'description' => 'Guides dÃ©taillÃ©s sur les techniques de nage, la biomÃ©canique et les stratÃ©gies d\'entraînement.'
                    ],
                    [
                        'icon' => 'fas fa-chart-line',
                        'title' => 'Suivi des Performances',
                        'description' => 'Enregistrez vos temps, analysez votre progression avec des graphiques et statistiques dÃ©taillÃ©s.'
                    ],
                    [
                        'icon' => 'fas fa-play-circle',
                        'title' => 'VidÃ©os d\'Entraînement',
                        'description' => 'DÃ©monstrations techniques, sÃ©ances filmÃ©es et conseils de coachs professionnels.'
                    ]
                ];
            @endphp
            
            @foreach($features as $feature)
                <div class="col">
                    <div class="card h-100 shadow-sm hover-lift border-0">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary-subtle p-3 rounded-circle d-inline-block mb-3">
                                <i class="{{ $feature['icon'] }} text-primary fs-1"></i>
                            </div>
                            <h3 class="card-title h5 mb-3">{{ $feature['title'] }}</h3>
                            <p class="card-text text-muted">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- TÃ©moignages -->
<section class="py-5 bg-primary text-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Ce qu'en disent nos utilisateurs</h2>
        </div>
        <div class="row g-4">
            @php
                $testimonials = [
                    [
                        'name' => 'Sarah, Nageuse compÃ©tition',
                        'quote' => 'Cette plateforme a transformÃ© ma façon de m\'entraîner. J\'ai amÃ©liorÃ© mon 200m papillon de 3 secondes en seulement deux mois.',
                        'role' => 'Nageuse compÃ©tition'
                    ],
                    [
                        'name' => 'Marc, Coach natation',
                        'quote' => 'Un outil indispensable pour tout entraîneur. Je gÃ¨re les programmes de toute mon Ã©quipe et peux suivre leur progression en temps rÃ©el.',
                        'role' => 'Entraîneur'
                    ],
                    [
                        'name' => 'Sophie, TriathlÃ¨te amateur',
                        'quote' => 'Enfin un outil qui me permet d\'intÃ©grer parfaitement mes sÃ©ances de natation dans mon planning global d\'entraînement.',
                        'role' => 'TriathlÃ¨te'
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
            <p class="lead text-muted">Trois Ã©tapes simples pour optimiser vos entraînements aquatiques</p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center">
                <div class="bg-success-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-user-plus text-success fs-1"></i>
                </div>
                <h3 class="h5">1. CrÃ©ez votre profil</h3>
                <p class="text-muted">Inscrivez-vous et dÃ©finissez votre niveau, objectifs et spÃ©cialitÃ©s aquatiques</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="bg-warning-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-swimmer text-warning fs-1"></i>
                </div>
                <h3 class="h5">2. Choisissez vos plans</h3>
                <p class="text-muted">SÃ©lectionnez des programmes existants ou crÃ©ez vos propres sÃ©ances d'entraînement</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="bg-info-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-chart-line text-info fs-1"></i>
                </div>
                <h3 class="h5">3. Suivez vos progrÃ¨s</h3>
                <p class="text-muted">Enregistrez vos performances et visualisez votre Ã©volution dans l'eau</p>
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

<!-- Call to Action -->
<section class="py-5 bg-white">
    <div class="container-lg text-center py-4">
        <h2 class="mb-4 fw-bold">Prêt Ã amÃ©liorer vos performances aquatiques ?</h2>
        <p class="lead text-muted mb-4 mx-auto" style="max-width: 700px;">
            Rejoignez des milliers de nageurs, entraîneurs et triathlÃ¨tes qui utilisent notre plateforme pour atteindre leurs objectifs aquatiques et optimiser leurs entraînements.
        </p>
        
        @guest
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-user-plus me-2"></i>CrÃ©er un compte
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
                <span class="fw-medium">Bienvenue dans la communautÃ© aquatique, {{ auth()->user()->first_name ?: auth()->user()->name }} !</span>
            </div>
            <div class="mt-3">
                <a href="{{ route('public.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-swimmer me-2"></i>DÃ©couvrir nos entraînements
                </a>
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