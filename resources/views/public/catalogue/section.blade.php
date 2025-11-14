@extends('layouts.public')

@section('title', $section->meta_title ?? $section->name . ' - Catalogue')
@section('meta_description', $section->meta_description ?? $section->short_description ?? 'Découvrez les modules de formation de la section ' . $section->name)
@section('meta_keywords', $section->meta_keywords ?? 'formation, ' . $section->name . ', modules pédagogiques')

@section('content')

<!-- Section Titre avec Breadcrumb -->
<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">


        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
                    {{ $section->name }}
                </h1>
                @if($section->short_description)
    <p class="lead mb-0">
        {!! strip_tags($section->short_description, '<strong><em><b><i>') !!}
    </p>
@endif
            </div>
        </div>
    </div>
</section>

<!-- Description longue (si disponible) -->
@if($section->long_description)
<section class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-muted">
                            {!! $section->long_description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Grille des Modules -->
<section class="py-5 bg-light">
    <div class="container-lg">
        
        <!-- Stats de la section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 fs-6">
                        <i class="fas fa-layer-group me-2"></i>
                        {{ $modules->count() }} module{{ $modules->count() > 1 ? 's' : '' }} disponible{{ $modules->count() > 1 ? 's' : '' }}
                    </span>
                    <span class="badge bg-info-subtle text-info px-3 py-2 fs-6">
                        <i class="fas fa-puzzle-piece me-2"></i>
                        {{ $modules->sum('units_count') }} unité{{ $modules->sum('units_count') > 1 ? 's' : '' }} de formation
                    </span>
                </div>
            </div>
        </div>

        @if($modules->count() > 0)
            <!-- Grille responsive de cartes -->
            <div class="row g-4">
                @foreach($modules as $module)
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card h-100 border-0 shadow-sm hover-module-card">
                            <!-- Image du module -->
                            <div class="module-image-wrapper position-relative">
                                @if($module->image)
                                    <img src="{{ $module->image }}" 
                                         class="card-img-top module-card-image" 
                                         alt="{{ $module->name }}">
                                @else
                                    <div class="module-image-placeholder d-flex align-items-center justify-content-center text-white"
                                         style="background: linear-gradient(135deg, {{ $loop->index % 4 == 0 ? '#198754' : ($loop->index % 4 == 1 ? '#0dcaf0' : ($loop->index % 4 == 2 ? '#ffc107' : '#dc3545')) }} 0%, {{ $loop->index % 4 == 0 ? '#0f5132' : ($loop->index % 4 == 1 ? '#087990' : ($loop->index % 4 == 2 ? '#cc9a06' : '#842029')) }} 100%);">
                                        <i class="fas fa-graduation-cap" style="font-size: 4rem;"></i>
                                    </div>
                                @endif

                                <!-- Badge nombre d'unités -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success shadow-sm fs-6">
                                        <i class="fas fa-list-check me-1"></i>
                                        {{ $module->units_count }} unité{{ $module->units_count > 1 ? 's' : '' }}
                                    </span>
                                </div>

                                <!-- Badge ordre -->
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-dark shadow-sm">
                                        Module {{ $module->order }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenu de la carte -->
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title h5 fw-bold mb-3">
                                    <a href="{{ route('public.catalogue.module', [$section->slug, $module->slug]) }}" 
                                       class="text-decoration-none text-dark module-link stretched-link">
                                        {{ $module->name }}
                                    </a>
                                </h3>

                                <!-- Description courte -->
                                @if($module->short_description)
    <p class="card-text text-muted mb-3">
        {!! Str::limit(strip_tags($module->short_description, '<strong><em><b><i>'), 120) !!}
    </p>
@endif

                                <!-- Spacer pour pousser le footer en bas -->
                                <div class="mt-auto pt-3 border-top">
                                    <div class="card-header text-dark nataswim-titre5">
                                        <small class="text-muted">
                                            <i class="fas fa-book me-1"></i>
                                            Voir ce Module 
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Message si aucun module -->
            <div class="text-center py-5">
                <i class="fas fa-layer-group fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucun module disponible dans cette section</h5>
                <p class="text-muted">Les modules seront bientôt ajoutés</p>
            </div>
        @endif

        <!-- Bouton retour -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('public.catalogue.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour au catalogue
                </a>
            </div>
        </div>

    </div>
</section>

@endsection

@push('styles')
<style>
/* Cartes modules avec effet hover */
.hover-module-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.hover-module-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 2rem rgba(25, 135, 84, 0.25) !important;
}

/* Image du module */
.module-image-wrapper {
    height: 200px;
    overflow: hidden;
}

.module-card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hover-module-card:hover .module-card-image {
    transform: scale(1.05);
}

.module-image-placeholder {
    width: 100%;
    height: 200px;
    transition: transform 0.3s ease;
}

.hover-module-card:hover .module-image-placeholder {
    transform: scale(1.05);
}

/* Lien avec effet hover */
.module-link {
    transition: color 0.3s ease;
}

.hover-module-card:hover .module-link {
    color: #198754 !important;
}

/* Breadcrumb personnalisé */
.breadcrumb {
    background: transparent;
    margin-bottom: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.7);
}

/* Responsive */
@media (max-width: 767px) {
    .module-image-wrapper {
        height: 180px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée pour les cards
        const cards = document.querySelectorAll('.hover-module-card');

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