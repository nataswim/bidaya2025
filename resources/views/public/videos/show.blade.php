@extends('layouts.public')

{{-- SEO Meta --}}
@section('title', $video->title)
@section('meta_description', $video->description ?? 'Regardez cette vidéo sur ' . config('app.name'))

{{-- Open Graph / Facebook --}}
@section('og_type', 'video.other')
@section('og_title', $video->title)
@section('og_description', $video->description ?? 'Regardez cette vidéo')
@section('og_url', route('public.videos.show', $video))
@if($video->thumbnail)
    @section('og_image', $video->thumbnail)
    @section('og_image_alt', $video->title)
@endif

{{-- Twitter Card --}}
@section('twitter_title', $video->title)
@section('twitter_description', $video->description ?? 'Regardez cette vidéo')
@if($video->thumbnail)
    @section('twitter_image', $video->thumbnail)
@endif

@section('content')

<!-- En-tête de section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-0">{{ $video->title }}</h1>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="py-3 bg-light border-bottom">
    <div class="container-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.videos.index') }}">
                        <i class="fas fa-home me-1"></i>Vidéos
                    </a>
                </li>
                @if($video->categories->count() > 0)
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.videos.category', $video->categories->first()) }}">
                            {{ $video->categories->first()->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">
                    {!! Str::limit($video->title, 50) !!}
                </li>
            </ol>
        </nav>
    </div>
</section>

<article class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-12">
                
                <!-- Card 1: Métadonnées -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted">
                            @foreach($video->categories as $category)
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="fas fa-folder me-1"></i>{{ $category->name }}
                                </span>
                            @endforeach
                            
                            @if($video->is_featured)
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star me-1"></i>En vedette
                                </span>
                            @endif
                            
                            @if($video->visibility === 'authenticated')
                                <span class="badge bg-info px-3 py-2">
                                    <i class="fas fa-lock me-1"></i>Membres
                                </span>
                            @endif
                            
                            <span class="d-flex align-items-center">
                                <i class="fas fa-eye me-1"></i>
                                {{ number_format($video->views_count) }} vue{{ $video->views_count > 1 ? 's' : '' }}
                            </span>
                            
                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $video->published_at?->format('d M Y') ?? $video->created_at->format('d M Y') }}
                            </span>
                            
                            @if($video->duration)
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $video->getFormattedDuration() }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="mt-3">
                            <x-add-to-notebook-button 
                                content-type="videos" 
                                :content-id="$video->id" 
                            />
                        </div>
                    </div>
                </div>

                <!-- Card 2: Lecteur vidéo -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        @if($contentVisible)
                            @if($video->type === 'upload' && $video->file_path)
                                <!-- Vidéo uploadée -->
                                <video controls class="w-100" style="max-height: 600px; background: #000;">
                                    <source src="{{ asset('storage/' . $video->file_path) }}" type="{{ $video->mime_type }}">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                            @elseif($video->getEmbedUrl())
                                <!-- Vidéo externe (YouTube, Vimeo, Dailymotion) -->
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $video->getEmbedUrl() }}" 
                                            allowfullscreen 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            class="border-0">
                                    </iframe>
                                </div>
                            @elseif($video->external_url)
                                <!-- Lien URL direct -->
                                <div class="p-4 text-center">
                                    <i class="fas fa-link fa-3x text-muted mb-3"></i>
                                    <p class="mb-3">Cette vidéo est hébergée sur un service externe.</p>
                                    <a href="{{ $video->external_url }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="btn btn-primary">
                                        <i class="fas fa-external-link-alt me-2"></i>Ouvrir la vidéo
                                    </a>
                                </div>
                            @else
                                <!-- Aucune source disponible -->
                                <div class="p-4 text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <p class="text-muted">Aucune source vidéo disponible.</p>
                                </div>
                            @endif
                        @else
                            <!-- Message d'accès restreint -->
                            <div class="p-4">
                                <div class="alert alert-warning border-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-lock text-warning fs-2"></i>
                                        </div>
                                        <div class="col">
                                            <h5 class="alert-heading mb-2">Contenu réservé aux membres</h5>
                                            <p class="mb-3">
                                                Cette vidéo est réservée aux membres connectés. 
                                                Inscrivez-vous gratuitement pour y accéder.
                                            </p>
                                            @if(!auth()->check())
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-user-plus me-2"></i>Inscription gratuite
                                                    </a>
                                                    <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card 3: Description -->
                @if($video->description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Description
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="content-display fs-6 lh-lg">
                                {!! nl2br(e($video->description)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 4: Informations techniques -->
                @if($video->duration || $video->width || $video->height)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-cog me-2 text-secondary"></i>
                                Informations techniques
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @if($video->duration)
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-clock me-1"></i>Durée:
                                            </span>
                                            <strong>{{ $video->getFormattedDuration() }}</strong>
                                        </div>
                                    </div>
                                @endif
                                @if($video->width && $video->height)
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-expand me-1"></i>Résolution:
                                            </span>
                                            <strong>{{ $video->width }}x{{ $video->height }}</strong>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-server me-1"></i>Type:
                                        </span>
                                        <strong class="text-capitalize">{{ $video->type }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 5: Vidéos similaires -->
                @if($relatedVideos->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-layer-group me-2 text-primary"></i>
                                Vidéos similaires
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach($relatedVideos as $related)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 border">
                                            @if($related->thumbnail)
                                                <div class="position-relative">
                                                    <img src="{{ $related->thumbnail }}" 
                                                         class="card-img-top" 
                                                         style="height: 150px; object-fit: cover;"
                                                         alt="{{ $related->title }}">
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-play text-white"></i>
                                                        </div>
                                                    </div>
                                                    @if($related->duration)
                                                        <span class="position-absolute bottom-0 end-0 m-1 badge bg-dark">
                                                            {{ $related->getFormattedDuration() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                     style="height: 150px;">
                                                    <i class="fas fa-video fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="card-body p-3">
                                                <h6 class="card-title small">{!! Str::limit($related->title, 50) !!}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-eye me-1"></i>{{ number_format($related->views_count) }}
                                                </small>
                                                <a href="{{ route('public.videos.show', $related) }}" 
                                                   class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 6: Informations de la vidéo -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Informations de la vidéo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @if($video->categories->count() > 0)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-folder me-1"></i>Catégories:
                                        </span>
                                        <div>
                                            @foreach($video->categories as $category)
                                                <span class="badge bg-primary">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Publié le:
                                    </span>
                                    <strong>{{ $video->published_at?->format('d F Y') ?? $video->created_at->format('d F Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-eye me-1"></i>Nombre de vues:
                                    </span>
                                    <strong>{{ number_format($video->views_count) }}</strong>
                                </div>
                            </div>
                            @if($video->creator)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-user me-1"></i>Auteur:
                                        </span>
                                        <strong>{{ $video->creator->name }}</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise à jour:
                                    </span>
                                    <strong>{{ $video->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            @if($video->visibility === 'authenticated')
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-shield-alt me-1"></i>Visibilité:
                                        </span>
                                        <strong class="text-info">Membres uniquement</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section Navigation -->
                <div class="row g-4 mb-4">
                    <!-- Catégorie -->
                    @if($video->categories->count() > 0)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-folder me-2"></i>Catégorie
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @php $firstCategory = $video->categories->first(); @endphp
                                    <a href="{{ route('public.videos.category', $firstCategory) }}" 
                                       class="d-flex align-items-center text-decoration-none">
                                        @if($firstCategory->image)
                                            <img src="{{ $firstCategory->image }}" 
                                                 class="rounded me-3" 
                                                 style="width: 70px; height: 70px; object-fit: cover;"
                                                 alt="{{ $firstCategory->name }}">
                                        @else
                                            <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 70px; height: 70px;">
                                                <i class="fas fa-folder text-primary fs-3"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 text-dark">{{ $firstCategory->name }}</h6>
                                            <small class="text-muted">Voir toutes les vidéos</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Boutons de navigation -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-compass me-2"></i>Navigation
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    @if($video->categories->count() > 0)
                                        <a href="{{ route('public.videos.category', $video->categories->first()) }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-arrow-left me-2"></i>Retour à {!! Str::limit($video->categories->first()->name, 30) !!}
                                        </a>
                                    @endif
                                    <a href="{{ route('public.videos.index') }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-th me-2"></i>Toutes les vidéos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</article>

<!-- Bouton Outils & Calculateurs -->
<div class="container-lg mb-4">
    <a href="{{ route('tools.index') }}" class="btn btn-primary text-light btn-lg w-100">
        <i class="fas fa-calculator me-2"></i>Essayer nos outils & calculateurs
    </a>
</div>

<!-- Section Crédit et Contact -->
<section class="py-5 bg-primary text-white">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">À propos de nos vidéos</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">Développement</h6>
                        <p class="mb-3">
                            Contenus développés par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Expert en sciences du sport et performance sportive.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Contact</h6>
                        <p class="mb-3 small">
                            Questions ou suggestions ? N'hésitez pas à nous contacter.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-envelope me-2"></i>Nous contacter
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
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Styles pour le contenu */
.content-display p {
    margin-bottom: 1rem;
    line-height: 1.8;
    color: #4a5568;
}

.card {
    transition: box-shadow 0.2s ease;
}

/* Responsive pour le player vidéo */
@media (max-width: 991px) {
    video {
        max-height: 400px !important;
    }
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 1.75rem !important;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem !important;
    }
    
    video {
        max-height: 300px !important;
    }
}

/* Animation pour les vidéos similaires */
.hover-card {
    transition: transform 0.2s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
}
</style>
@endpush