@extends('layouts.public')

@section('title', $fiche->title)
@section('meta_description', strip_tags($fiche->short_description))

@section('content')
<!-- Section titre avec breadcrumb -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.fiches.index') }}">
                        <i class="fas fa-home me-1"></i>Fiches
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.fiches.category', $category) }}">
                        {{ $category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Str::limit($fiche->title, 50) }}
                </li>
            </ol>
        </nav>
    </div>
</section>

<div class="container py-5">
    <!-- Contenu principal en pleine largeur -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl">
            <!-- Carte principale -->
            <article class="card border-0 shadow-lg mb-5">
                @if($fiche->image)
                    <img src="{{ $fiche->image }}" 
                         class="card-img-top" 
                         style="max-height: 450px; object-fit: cover;"
                         alt="{{ $fiche->title }}">
                @endif
                
                <div class="card-body p-4 p-md-5">
                    <!-- Tags et métadonnées -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-folder me-1"></i>{{ $category->name }}
                        </span>
                        @if($fiche->is_featured)
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-star me-1"></i>En vedette
                            </span>
                        @endif
                        @if($fiche->visibility === 'authenticated')
                            <span class="badge bg-info fs-6">
                                <i class="fas fa-lock me-1"></i>Membres
                            </span>
                        @endif
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-eye me-1"></i>{{ number_format($fiche->views_count) }} vues
                        </span>
                    </div>

                    <!-- Titre -->
                    <h1 class="display-5 fw-bold mb-4">{{ $fiche->title }}</h1>

                    <!-- Métadonnées article -->
                    <div class="d-flex flex-wrap align-items-center gap-4 mb-4 pb-4 border-bottom">
                        @if($fiche->creator)
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" 
                                     style="width: 40px; height: 40px;">
                                    <span class="fw-bold text-primary">
                                        {{ substr($fiche->creator->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Publié par</small>
                                    <strong>{{ $fiche->creator->name }}</strong>
                                </div>
                            </div>
                        @endif
                        <div>
                            <small class="text-muted d-block">Date de publication</small>
                            <strong>
                                <i class="fas fa-calendar me-1"></i>
                                {{ $fiche->published_at?->format('d/m/Y') ?? $fiche->created_at->format('d/m/Y') }}
                            </strong>
                        </div>
                    </div>

                    <!-- Description courte (toujours visible) -->
                    @if($fiche->short_description)
                        <div class="alert alert-info border-0 shadow-sm mb-4" 
                             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                            <div class="content-display">
                                {!! $fiche->short_description !!}
                            </div>
                        </div>
                    @endif

                    <!-- Description longue (selon visibilité) -->
                    @if($fiche->long_description)
                        @if($fiche->canViewContent(auth()->user()))
                            <div class="content-display-full">
                                {!! $fiche->long_description !!}
                            </div>
                        @else
                            <!-- Message d'accès restreint -->
                            <div class="card border-0 bg-warning bg-opacity-10 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-lock fa-3x text-warning me-4"></i>
                                        <div class="flex-grow-1">
                                            <h5 class="card-title text-warning mb-3">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                Contenu Réservé aux Membres
                                            </h5>
                                            <p class="card-text mb-3">
                                                {{ $fiche->getAccessMessage(auth()->user()) }}
                                            </p>
                                            @if(!auth()->check())
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('login') }}" class="btn btn-warning">
                                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                                    </a>
                                                    <a href="{{ route('register') }}" class="btn btn-outline-warning">
                                                        <i class="fas fa-user-plus me-2"></i>S'inscrire gratuitement
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </article>

            <!-- Fiches associées -->
            @if($relatedFiches->count() > 0)
                <div class="card border-0 shadow-sm mb-5">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h5 mb-0">
                            <i class="fas fa-layer-group me-2"></i>Fiches dans la même catégorie
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @foreach($relatedFiches as $related)
                                <div class="col-md-4">
                                    <div class="card h-100 border hover-lift" style="transition: all 0.3s ease;">
                                        @if($related->image)
                                            <img src="{{ $related->image }}" 
                                                 class="card-img-top" 
                                                 style="height: 180px; object-fit: cover;"
                                                 alt="{{ $related->title }}">
                                        @else
                                            <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" 
                                                 style="height: 180px;">
                                                <i class="fas fa-file-alt fa-2x text-white opacity-50"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body p-3">
                                            <h6 class="card-title">{{ Str::limit($related->title, 60) }}</h6>
                                            <a href="{{ route('public.fiches.show', [$category, $related]) }}" 
                                               class="stretched-link"></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Section Catégorie et Actions (anciennement sidebar) -->
            <div class="row g-4 mb-5">
                <!-- Catégorie -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-folder me-2"></i>Catégorie
                            </h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('public.fiches.category', $category) }}" 
                               class="d-flex align-items-center text-decoration-none hover-card">
                                @if($category->image)
                                    <img src="{{ $category->image }}" 
                                         class="rounded me-3" 
                                         style="width: 70px; height: 70px; object-fit: cover;"
                                         alt="{{ $category->name }}">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 70px; height: 70px;">
                                        <i class="fas fa-folder text-primary fs-3"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 text-dark">{{ $category->name }}</h6>
                                    <small class="text-muted">Voir toutes les fiches</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-compass me-2"></i>Navigation
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('public.fiches.category', $category) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour à {{ Str::limit($category->name, 30) }}
                                </a>
                                <a href="{{ route('public.fiches.index') }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-th me-2"></i>Toutes les catégories
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partage social -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-share-alt me-2"></i>Partager cette fiche
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="btn btn-primary w-100">
                                <i class="fab fa-facebook me-2"></i>Facebook
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($fiche->title) }}" 
                               target="_blank" 
                               class="btn btn-info text-white w-100">
                                <i class="fab fa-twitter me-2"></i>Twitter
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="btn btn-secondary w-100">
                                <i class="fab fa-linkedin me-2"></i>LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Section Credit et Contact -->
     <div class="card mb-4">
            <a href="{{ route('tools.index') }}" class="btn btn-danger text-light btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Essayer Nos Outils & Calculateurs
            </a>
        </div>
<section class="py-5 bg-primary text-white">

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">A Propos de nos Fiches</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">Developpement</h6>
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
                            Expert en sciences du sport, physiologie de l'exercice et developpement 
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
                </div>
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
                <i class="fas fa-water me-2"></i>Aucun article n'est disponible actuellement.
            </div>
        @endif
    </div>
</section>











@endsection

@push('styles')
<style>
/* Styles pour le contenu HTML de Quill */
.content-display h1,
.content-display h2,
.content-display h3,
.content-display-full h1,
.content-display-full h2,
.content-display-full h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.content-display p,
.content-display-full p {
    margin-bottom: 1rem;
    line-height: 1.8;
    color: #4b5563;
}

.content-display ul,
.content-display ol,
.content-display-full ul,
.content-display-full ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
    line-height: 1.8;
}

.content-display-full ul li,
.content-display-full ol li {
    margin-bottom: 0.5rem;
}

.content-display blockquote,
.content-display-full blockquote {
    border-left: 4px solid #0ea5e9;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
    background: #f3f4f6;
    padding: 1rem 1.5rem;
    border-radius: 0.375rem;
}

.content-display img,
.content-display-full img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.content-display pre,
.content-display-full pre {
    background: #1f2937;
    color: #f9fafb;
    padding: 1.5rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
    border-left: 4px solid #0ea5e9;
}

.content-display strong,
.content-display-full strong {
    font-weight: 600;
    color: #1f2937;
}

.content-display a,
.content-display-full a {
    color: #0ea5e9;
    text-decoration: underline;
}

.content-display a:hover,
.content-display-full a:hover {
    color: #0284c7;
    text-decoration: none;
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
}

.hover-card {
    transition: transform 0.3s ease;
}

.hover-card:hover {
    transform: translateX(5px);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}
</style>
@endpush