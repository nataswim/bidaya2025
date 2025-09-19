@extends('layouts.public')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section Aquatique -->
<section class="hero-section position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 50%, #1e40af 100%);"></div>
    
    <!-- Vagues animées en arrière-plan -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; overflow: hidden;">
        <svg class="position-relative" style="width: 120%; height: 100px; animation: wave 10s infinite linear;" 
             viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" 
                  fill="rgba(255,255,255,0.1)"></path>
        </svg>
    </div>
    
    <div class="container-lg position-relative" style="z-index: 2;">
        <div class="row align-items-center min-vh-75 py-5">
            <div class="col-lg-6">
                <div class="text-white">
                    <h1 class="display-3 fw-bold mb-4">
                        Plongez dans l'univers du
                        <span class="text-warning">développement web</span>
                    </h1>
                    <p class="lead mb-5 opacity-90">
                        Découvrez nos articles, tutoriels et guides sur les dernières technologies. 
                        Une plateforme moderne pour développeurs passionnés.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('public.index') }}" class="btn btn-light btn-lg rounded-pill px-5">
                            <i class="fas fa-book-open me-2"></i>Explorer les articles
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg rounded-pill px-5">
                            <i class="fas fa-info-circle me-2"></i>En savoir plus
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        <div class="bg-white bg-opacity-10 rounded-circle p-5" style="width: 300px; height: 300px;">
                            <div class="bg-white bg-opacity-20 rounded-circle p-4 h-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-code text-white" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <div class="position-absolute top-0 end-0 bg-warning rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-rocket text-white fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section statistiques -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row g-4">
            @php
                $stats = [
                    ['icon' => 'fas fa-newspaper', 'number' => App\Models\Post::count(), 'label' => 'Articles publiés', 'color' => 'primary'],
                    ['icon' => 'fas fa-users', 'number' => App\Models\User::count(), 'label' => 'Membres actifs', 'color' => 'info'],
                    ['icon' => 'fas fa-tags', 'number' => App\Models\Category::count(), 'label' => 'Catégories', 'color' => 'success'],
                    ['icon' => 'fas fa-eye', 'number' => App\Models\Post::sum('hits'), 'label' => 'Vues totales', 'color' => 'warning']
                ];
            @endphp
            
            @foreach($stats as $stat)
                <div class="col-lg-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 text-center">
                        <div class="card-body py-4">
                            <div class="bg-{{ $stat['color'] }} bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="{{ $stat['icon'] }} text-{{ $stat['color'] }} fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-2">{{ number_format($stat['number']) }}</h3>
                            <p class="text-muted mb-0">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Articles récents avec design fluide -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Articles récents</h2>
                <p class="lead text-muted">Découvrez nos dernières publications sur les technologies modernes</p>
            </div>
        </div>

        <div class="row g-4">
            @php
                $recentPosts = App\Models\Post::with('category')
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->orderBy('published_at', 'desc')
                    ->limit(6)
                    ->get();
            @endphp

            @foreach($recentPosts as $index => $post)
                <div class="col-lg-4 col-md-6">
                    <article class="card border-0 shadow-sm h-100 overflow-hidden hover-lift">
                        @if($post->image)
                            <div class="position-relative">
                                <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->name }}" 
                                     style="height: 220px; object-fit: cover;">
                                <div class="position-absolute top-3 start-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-2">
                                        {{ $post->category->name ?? 'Tech' }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="fas fa-code text-white opacity-50" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i>
                                    {{ $post->published_at?->format('d M Y') ?? 'Non daté' }}
                                    @if($post->hits > 0)
                                        <span class="ms-auto d-flex align-items-center">
                                            <i class="fas fa-eye me-1"></i>{{ $post->hits }}
                                        </span>
                                    @endif
                                </small>
                            </div>
                            
                            <h5 class="card-title fw-semibold mb-3">
                                <a href="{{ route('public.show', $post) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ $post->name }}
                                </a>
                            </h5>
                            
                            @if($post->intro)
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($post->intro, 120) }}</p>
                            @endif
                            
                            <div class="mt-auto pt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-primary fw-medium">
                                        Lire la suite
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </small>
                                    @if($post->is_featured)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('public.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                <i class="fas fa-th-large me-2"></i>Voir tous les articles
            </a>
        </div>
    </div>
</section>

<!-- Section CTA moderne -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="card-body p-5 text-center position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100" 
                             style="background: linear-gradient(45deg, #0ea5e9, #3b82f6); opacity: 0.05;"></div>
                        
                        <div class="position-relative">
                            <div class="mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-users text-primary" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            
                            <h2 class="display-6 fw-bold mb-4">Rejoignez notre communauté</h2>
                            <p class="lead text-muted mb-4">
                                Plus de {{ App\Models\User::count() }} développeurs nous font déjà confiance. 
                                Inscrivez-vous et accédez à du contenu exclusif.
                            </p>
                            
                            @guest
                                <div class="d-flex flex-wrap gap-3 justify-content-center">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                                        <i class="fas fa-user-plus me-2"></i>Créer un compte
                                    </a>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-success d-inline-flex align-items-center rounded-pill px-4 py-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span class="fw-medium">Bienvenue dans la communauté, {{ auth()->user()->first_name ?: auth()->user()->name }} !</span>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
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

@keyframes wave {
    0% { transform: translateX(0); }
    100% { transform: translateX(-200px); }
}

.min-vh-75 { min-height: 75vh; }

.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9, #3b82f6);
}
</style>
@endpush