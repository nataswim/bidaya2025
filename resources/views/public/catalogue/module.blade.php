@extends('layouts.public')

@section('title', $module->meta_title ?? $module->name . ' - Catalogue')
@section('meta_description', $module->meta_description ?? $module->short_description ?? 'Découvrez les unités de formation du module ' . $module->name)
@section('meta_keywords', $module->meta_keywords ?? 'formation, ' . $module->name . ', unités pédagogiques')

@section('content')

<!-- Section Titre avec Breadcrumb -->
<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">
        <!-- Fil d'Ariane -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white text-decoration-none">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.catalogue.index') }}" class="text-white text-decoration-none">
                        Catalogue
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.catalogue.section', $section->slug) }}" class="text-white text-decoration-none">
                        {{ $section->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $module->name }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <!-- Badge ordre du module -->
                <div class="mb-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        Module {{ $module->order }}
                    </span>
                </div>

                <h1 class="display-4 fw-bold mb-3">
                    {{ $module->name }}
                </h1>
                @if($module->short_description)
                    <p class="lead mb-0">
                        {{ $module->short_description }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Description longue (si disponible) -->
@if($module->long_description)
<section class="py-4 bg-white">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            À propos de ce module
                        </h2>
                        <div class="text-muted">
                            {!! nl2br(e($module->long_description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Liste des Unités -->
<section class="py-5 bg-light">
    <div class="container-lg">
        
        <!-- Stats du module -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center">
                    <span class="badge bg-success-subtle text-success px-3 py-2 fs-6">
                        <i class="fas fa-list-check me-2"></i>
                        {{ $units->count() }} unité{{ $units->count() > 1 ? 's' : '' }} de formation
                    </span>
                    <span class="badge bg-info-subtle text-info px-3 py-2 fs-6">
                        <i class="fas fa-book-open me-2"></i>
                        Progression guidée
                    </span>
                </div>
            </div>
        </div>

        @if($units->count() > 0)
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Liste ordonnée des unités -->
                    <div class="list-group shadow-sm">
                        @foreach($units as $unit)
                            <div class="list-group-item list-group-item-action unit-item border-0 mb-2">
                                <div class="row align-items-center">
                                    <!-- Numéro d'ordre -->
                                    <div class="col-auto">
                                        <div class="unit-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                             style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            {{ $unit->order }}
                                        </div>
                                    </div>

                                    <!-- Contenu de l'unité -->
                                    <div class="col">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-2 fw-bold">{{ $unit->title }}</h5>
                                                @if($unit->description)
                                                    <p class="mb-2 text-muted">
                                                        {{ Str::limit($unit->description, 150) }}
                                                    </p>
                                                @endif
                                                <!-- Type de contenu -->
                                                @if($unit->unitable)
                                                    <div class="mt-2">
                                                        <span class="badge bg-secondary-subtle text-secondary">
                                                            <i class="fas {{ 
                                                                $unit->unitable_type == 'App\Models\Video' ? 'fa-video' : 
                                                                ($unit->unitable_type == 'App\Models\Fiche' ? 'fa-file-alt' : 
                                                                ($unit->unitable_type == 'App\Models\Exercice' ? 'fa-dumbbell' : 
                                                                ($unit->unitable_type == 'App\Models\Workout' ? 'fa-running' : 
                                                                ($unit->unitable_type == 'App\Models\Downloadable' ? 'fa-download' : 'fa-book'))))
                                                            }} me-1"></i>
                                                            {{ $unit->content_type_label }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Bouton d'accès -->
                                            <div class="ms-3">
                                                @if($unit->unitable && $unit->content_url)
                                                    <a href="{{ $unit->url }}" 
                                                       class="btn btn-outline-primary btn-sm unit-link">
                                                        <i class="fas fa-play-circle me-1"></i>
                                                        Accéder
                                                    </a>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Bientôt
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Message si aucune unité -->
            <div class="text-center py-5">
                <i class="fas fa-list-check fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucune unité disponible dans ce module</h5>
                <p class="text-muted">Les unités seront bientôt ajoutées</p>
            </div>
        @endif

        <!-- Navigation -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <!-- Bouton retour section -->
                    <a href="{{ route('public.catalogue.section', $section->slug) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour à {{ $section->name }}
                    </a>

                    <!-- Bouton retour catalogue -->
                    <a href="{{ route('public.catalogue.index') }}" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-th-large me-2"></i>
                        Retour au catalogue
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('styles')
<style>
/* Items de la liste des unités */
.unit-item {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    border: 2px solid transparent !important;
}

.unit-item:hover {
    transform: translateX(5px);
    box-shadow: 0 0.5rem 1.5rem rgba(13, 110, 253, 0.15) !important;
    border-color: #0d6efd !important;
    background-color: #f8f9fa;
}

/* Numéro d'ordre */
.unit-number {
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.unit-item:hover .unit-number {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

/* Bouton d'accès */
.unit-link {
    transition: all 0.3s ease;
}

.unit-item:hover .unit-link {
    background-color: #0d6efd;
    color: white !important;
    border-color: #0d6efd;
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
    .unit-item {
        padding: 1rem;
    }
    
    .unit-number {
        width: 40px !important;
        height: 40px !important;
        font-size: 1rem !important;
    }
    
    .unit-item h5 {
        font-size: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée pour les unités
        const units = document.querySelectorAll('.unit-item');

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }
            });
        }, observerOptions);

        units.forEach((unit, index) => {
            unit.style.opacity = '0';
            unit.style.transform = 'translateX(-20px)';
            unit.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(unit);
        });
    });
</script>
@endpush