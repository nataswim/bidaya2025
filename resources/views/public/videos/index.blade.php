@extends('layouts.public')

@section('title', 'Vidéos')
@section('meta_description', 'Découvrez notre bibliothèque de vidéos d\'entraînement, de techniques et de conseils sportifs')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center" style="background: linear-gradient(58deg, #04adb9 0%, #4b0055 100%);border-top: 20px solid #71287c;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
                    Vidéothèque Numérique
                </h1>
                <p class="lead mb-0 text-center">
                    <strong>Vidéo</strong>infos, tutoriels, techniques et plus
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Navigation par Catégories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Nos Catégories</h2>
            <p class="lead text-muted">
                Découvrez l'ensemble des ressources vidéo classées par catégorie
            </p>
        </div>

        @if($categories->count() > 0)
        <div class="row g-4 mb-5">
            @foreach($categories as $category)
            <!-- Une catégorie par ligne -->
            <div class="col-12">
                <a href="{{ route('public.videos.category', $category) }}"
                    class="text-decoration-none">
                    <div class="card shadow-lg border-0 bg-white hover-lift category-card-full">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <!-- Image centrée en haut sur mobile, à gauche sur desktop -->
                                <div class="col-12 col-md-3 text-center mb-3 mb-md-0">
                                    @if($category->image)
                                    <img src="{{ $category->image }}"
                                        class="rounded shadow"
                                        style="max-height: 150px;object-fit: cover;"
                                        alt="{{ $category->name }}">
                                    @else
                                    <div class="bg-light rounded shadow d-inline-flex align-items-center justify-content-center"
                                        style="width: 150px; height: 150px;">
                                        <i class="fas fa-folder text-primary" style="font-size: 4rem;"></i>
                                    </div>
                                    @endif
                                </div>

                                <!-- Contenu de la catégorie -->
                                <div class="col-12 col-md-7">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge {{ $loop->index % 4 == 0 ? 'bg-primary' : ($loop->index % 4 == 1 ? 'bg-success' : ($loop->index % 4 == 2 ? 'bg-info' : 'bg-warning text-dark')) }} me-2">
                                            {{ $category->published_videos_count }} vidéo(s)
                                        </span>
                                    </div>
                                    <h3 class="mb-3 text-dark">
                                        {{ $category->name }}
                                    </h3>
                                    @if($category->description)
                                    <p class="text-muted mb-0">
                                        {{ Str::limit($category->description, 200) }}
                                    </p>
                                    @endif
                                </div>

                                <!-- Bouton -->
                                <div class="col-12 col-md-2 text-center text-md-end">
                                    <span class="btn btn-primary">
                                        Voir les vidéos
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- Les 6 dernières vidéos ajoutées -->
<section class="py-5 bg-white">
    <div class="container">

        @if($videos->count() > 0)
        <div class="row g-4">
            @foreach($videos->take(6) as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    @if($video->thumbnail)
                    <div class="position-relative">
                        <img src="{{ $video->thumbnail }}"
                            class="card-img-top"
                            style="height: 220px; object-fit: cover;"
                            alt="{{ $video->title }}">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-play text-white fs-4"></i>
                            </div>
                        </div>
                        @if($video->duration)
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                            {{ $video->getFormattedDuration() }}
                        </span>
                        @endif

                        {{-- Badge Premium --}}
                        @if($video->visibility === 'authenticated')
                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                            <i class="fas fa-crown me-1"></i>Premium
                        </span>
                        @endif

                        {{-- Badge Nouveau --}}
                        @if($video->created_at->diffInDays(now()) < 7)
                        <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                            <i class="fas fa-sparkles me-1"></i>Nouveau
                        </span>
                        @endif
                    </div>
                    @else
                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center"
                        style="height: 220px;">
                        <i class="fas fa-video fa-4x text-white opacity-50"></i>
                    </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($video->categories->take(2) as $category)
                            <span class="badge bg-primary">
                                {{ $category->name }}
                            </span>
                            @endforeach

                            @if($video->visibility === 'authenticated')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-crown me-1"></i>Premium
                            </span>
                            @endif

                            @if($video->is_featured)
                            <span class="badge bg-success">
                                <i class="fas fa-star me-1"></i>Vedette
                            </span>
                            @endif
                        </div>

                        <h5 class="card-title mb-3">{{ $video->title }}</h5>

                        @if($video->description)
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($video->description), 120) }}
                        </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>11{{ number_format($video->views_count) }} vues
                            </small>
                            <a href="{{ route('public.videos.show', $video) }}"
                                class="btn btn-sm btn-primary">
                                Regarder <i class="fas fa-play ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="fas fa-video fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted mb-3">Aucune vidéo disponible pour le moment</h5>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Les vidéos les plus vues -->
@php
    // Récupérer les 6 vidéos les plus vues
    $mostViewedVideos = \App\Models\Video::where('is_published', true)
        ->where('visibility', 'public')
        ->orWhere(function($query) {
            $query->where('visibility', 'authenticated')
                  ->where('is_published', true);
        })
        ->orderBy('views_count', 'desc')
        ->take(6)
        ->get();
@endphp

@if($mostViewedVideos->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <p class="lead text-muted">
                Les vidéos préférées de notre communauté
            </p>
        </div>

        <div class="row g-4">
            @foreach($mostViewedVideos as $index => $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-lg hover-lift position-relative">
                    {{-- Badge classement --}}
                    <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                        <div class="badge {{ $index === 0 ? 'bg-warning' : ($index === 1 ? 'bg-secondary' : ($index === 2 ? 'bg-bronze' : 'bg-dark')) }} text-dark fs-5 px-3 py-2">
                            <i class="fas fa-trophy me-1"></i>#{{ $index + 1 }}
                        </div>
                    </div>

                    @if($video->thumbnail)
                    <div class="position-relative">
                        <img src="{{ $video->thumbnail }}"
                            class="card-img-top"
                            style="height: 220px; object-fit: cover;"
                            alt="{{ $video->title }}">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-play text-white fs-4"></i>
                            </div>
                        </div>
                        @if($video->duration)
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                            {{ $video->getFormattedDuration() }}
                        </span>
                        @endif

                        {{-- Badge Premium --}}
                        @if($video->visibility === 'authenticated')
                        <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">
                            <i class="fas fa-crown me-1"></i>Premium
                        </span>
                        @endif
                    </div>
                    @else
                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center"
                        style="height: 220px;">
                        <i class="fas fa-video fa-4x text-white opacity-50"></i>
                    </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($video->categories->take(2) as $category)
                            <span class="badge bg-primary">
                                {{ $category->name }}
                            </span>
                            @endforeach

                            @if($video->visibility === 'authenticated')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-crown me-1"></i>Premium
                            </span>
                            @endif

                            @if($video->is_featured)
                            <span class="badge bg-success">
                                <i class="fas fa-star me-1"></i>Vedette
                            </span>
                            @endif
                        </div>

                        <h5 class="card-title mb-3">{{ $video->title }}</h5>

                        @if($video->description)
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($video->description), 120) }}
                        </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                            <small class="text-danger fw-bold">
                                <i class="fas fa-fire me-1"></i>11{{ number_format($video->views_count) }} vues
                            </small>
                            <a href="{{ route('public.videos.show', $video) }}"
                                class="btn btn-sm btn-danger">
                                Regarder <i class="fas fa-play ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Vidéos en vedette (optionnel) -->
@if($featuredVideos->count() > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">
                <i class="fas fa-star me-2 text-warning"></i>Vidéos en vedette
            </h2>
            <p class="lead text-muted">
                Nos meilleures sélections
            </p>
        </div>

        <div class="row g-4">
            @foreach($featuredVideos->take(3) as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    @if($video->thumbnail)
                    <div class="position-relative">
                        <img src="{{ $video->thumbnail }}"
                            class="card-img-top"
                            style="height: 220px; object-fit: cover;"
                            alt="{{ $video->title }}">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-play text-white fs-4"></i>
                            </div>
                        </div>
                        @if($video->duration)
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                            {{ $video->getFormattedDuration() }}
                        </span>
                        @endif
                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                            <i class="fas fa-star me-1"></i>En vedette
                        </span>
                    </div>
                    @else
                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center"
                        style="height: 220px;">
                        <i class="fas fa-video fa-4x text-white opacity-50"></i>
                    </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($video->categories->take(2) as $category)
                            <span class="badge bg-primary">
                                {{ $category->name }}
                            </span>
                            @endforeach

                            @if($video->visibility === 'authenticated')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-crown me-1"></i>Premium
                            </span>
                            @endif
                        </div>

                        <h5 class="card-title mb-3">{{ $video->title }}</h5>

                        @if($video->description)
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($video->description), 120) }}
                        </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>11{{ number_format($video->views_count) }} vues
                            </small>
                            <a href="{{ route('public.videos.show', $video) }}"
                                class="btn btn-sm btn-primary">
                                Regarder <i class="fas fa-play ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Toutes les vidéos avec pagination (si plus de 6) -->
@if($videos->count() > 6)
<section class="py-5 bg-light" id="all-videos-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">
                <i class="fas fa-th me-2 text-primary"></i>Toutes les vidéos
            </h2>
        </div>

        <div class="row g-4">
            @foreach($videos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow hover-lift">
                    @if($video->thumbnail)
                    <div class="position-relative">
                        <img src="{{ $video->thumbnail }}"
                            class="card-img-top"
                            style="height: 200px; object-fit: cover;"
                            alt="{{ $video->title }}">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-play text-white fs-5"></i>
                            </div>
                        </div>
                        @if($video->duration)
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                            {{ $video->getFormattedDuration() }}
                        </span>
                        @endif

                        {{-- Badge Premium --}}
                        @if($video->visibility === 'authenticated')
                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                            <i class="fas fa-crown me-1"></i>Premium
                        </span>
                        @endif
                    </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($video->title, 60) }}</h5>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ number_format($video->views_count) }}
                            </small>
                            <a href="{{ route('public.videos.show', $video) }}"
                                class="btn btn-sm btn-primary">
                                Regarder
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($videos->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $videos->links() }}
        </div>
        @endif
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .category-card-full {
        transition: all 0.3s ease;
        border-left: 6px solid transparent;
    }

    .category-card-full:hover {
        border-left-color: var(--bs-primary);
        transform: translateX(5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
    }

    /* Couleur bronze pour la 3ème place */
    .bg-bronze {
        background-color: #cd7f32 !important;
        color: white !important;
    }

    /* Animation smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Badge classement avec effet brillant */
    .badge.fs-5 {
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .category-card-full .card-body {
            padding: 1.5rem !important;
        }
        
        .category-card-full h3 {
            font-size: 1.3rem;
        }
    }
</style>
@endpush
