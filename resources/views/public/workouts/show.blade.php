@extends('layouts.public')

@section('title', $workout->title . ' - Séance d\'Entraînement ' . $section->name)
@section('meta_description', strip_tags($workout->short_description))
@section('meta_keywords', 'séance ' . strtolower($section->name) . ', entraînement ' . strtolower($category->name) . ', ' . strtolower($workout->title))

@section('content')
<!-- En-tête de section -->
<section class="bg-warning text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="d-flex align-items-center gap-3 mb-3">
                    @if($orderNumber !== null)
                        <span class="badge bg-light text-dark fs-4">
                            Séance #{{ $orderNumber }}
                        </span>
                    @endif
                    <h1 class="display-5 fw-bold mb-0">{{ $workout->title }}</h1>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-ruler me-1"></i>Volume : {{ $workout->formatted_total }}
                    </span>
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-layer-group me-1"></i>{{ $section->name }}
                    </span>
                </div>
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
                    <a href="{{ route('public.workouts.index') }}">
                        <i class="fas fa-home me-1"></i>Séances
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.section', $section) }}">
                        {{ $section->name }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.category', [$section, $category]) }}">
                        {{ $category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {!! Str::limit($workout->title, 50) !!}
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
                            <span class="badge bg-info px-3 py-2">
                                <i class="fas fa-folder me-1"></i>Programme : {{ $category->name }}
                            </span>
                            
                            <span class="badge bg-primary px-3 py-2">
                                <i class="fas fa-layer-group me-1"></i>Discipline : {{ $section->name }}
                            </span>
                            
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-ruler me-1"></i>Volume : {{ $workout->formatted_total }}
                            </span>
                            
                            @if($orderNumber !== null)
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-hashtag me-1"></i>Séance n°{{ $orderNumber }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card 2: Objectif de la séance (description courte) -->
                @if($workout->short_description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="mb-0 h5">
                                <i class="fas fa-bullseye me-2 text-primary"></i>
                                Objectif de la séance
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 mb-0" 
                                 style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <div class="content-display lead">
                                    {!! $workout->short_description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 3: Déroulement de la séance (description longue) -->
                @if($workout->long_description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="mb-0 h5">
                                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                Déroulement de la séance d'entraînement
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="content-display-full fs-6 lh-lg">
                                {!! $workout->long_description !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 4: Autres séances du programme -->
                @if($relatedWorkouts->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="mb-0 h5">
                                <i class="fas fa-running me-2 text-primary"></i>
                                Autres séances du programme {{ $category->name }}
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach($relatedWorkouts as $related)
                                    <div class="col-md-4">
                                        <div class="card h-100 border">
                                            <div class="card-header bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">Séance #{{ $related->pivot->order_number }}</span>
                                                    <span class="badge bg-info">{{ $related->formatted_total }}</span>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <h3 class="card-title h6">{!! Str::limit($related->title, 60) !!}</h3>
                                                <a href="{{ route('public.workouts.show', [$section, $category, $related]) }}" 
                                                   class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 5: Autres programmes de cette séance -->
                @if($workout->categories->count() > 1)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="mb-0 h5">
                                <i class="fas fa-folder-open me-2 text-info"></i>
                                Cette séance fait aussi partie de
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                @foreach($workout->categories as $cat)
                                    @if($cat->id !== $category->id)
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="badge bg-primary mb-1">Séance #{{ $cat->pivot->order_number }}</span>
                                                            <h3 class="mb-1 h6">Programme {{ $cat->name }}</h3>
                                                            <small class="text-muted">
                                                                <i class="fas fa-layer-group me-1"></i>
                                                                {{ $cat->section->name ?? 'N/A' }}
                                                            </small>
                                                        </div>
                                                        <a href="{{ route('public.workouts.show', [$cat->section, $cat, $workout]) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            Voir
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 6: Caractéristiques de la séance -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h2 class="mb-0 h5">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Caractéristiques de la séance
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-layer-group me-1"></i>Discipline :
                                    </span>
                                    <strong>{{ $section->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-folder me-1"></i>Programme :
                                    </span>
                                    <strong>{{ $category->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-ruler me-1"></i>Volume total :
                                    </span>
                                    <strong>{{ $workout->formatted_total }}</strong>
                                </div>
                            </div>
                            @if($orderNumber !== null)
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-hashtag me-1"></i>Position :
                                        </span>
                                        <strong>Séance n°{{ $orderNumber }}</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Ajoutée le :
                                    </span>
                                    <strong>{{ $workout->created_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise à jour :
                                    </span>
                                    <strong>{{ $workout->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Navigation -->
                <div class="row g-4 mb-4">
                    <!-- Programme -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h2 class="mb-0 h5">
                                    <i class="fas fa-folder me-2"></i>Programme
                                </h2>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('public.workouts.category', [$section, $category]) }}" 
                                   class="d-flex align-items-center text-decoration-none">
                                    <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 70px; height: 70px;">
                                        <i class="fas fa-folder text-info fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 text-dark h6">{{ $category->name }}</h3>
                                        <small class="text-muted">Voir toutes les séances</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-secondary text-white">
                                <h2 class="mb-0 h5">
                                    <i class="fas fa-compass me-2"></i>Navigation
                                </h2>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('public.workouts.category', [$section, $category]) }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour au programme {!! Str::limit($category->name, 25) !!}
                                    </a>
                                    <a href="{{ route('public.workouts.section', $section) }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-layer-group me-2"></i>Discipline {{ $section->name }}
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

<!-- Section SEO -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">À propos de cette séance d'entraînement</h2>
                        <p class="text-muted">
                            Cette <strong>séance d'entraînement {{ $section->name }}</strong> fait partie 
                            du <strong>programme {{ $category->name }}</strong> et représente un volume 
                            total de <strong>{{ $workout->formatted_total }}</strong>.
                        </p>
                        <p class="text-muted mb-0">
                            Suivez les instructions détaillées pour réaliser cette 
                            <strong>séance d'entraînement</strong> dans les meilleures conditions 
                            et progresser efficacement dans votre discipline.
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
    line-height: 1.3;
}

.content-display h1, .content-display-full h1 { font-size: 1.8rem; color: #2d3748; }
.content-display h2, .content-display-full h2 { font-size: 1.5rem; color: #2d3748; }
.content-display h3, .content-display-full h3 { font-size: 1.3rem; color: #2d3748; }

.content-display p,
.content-display-full p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
    text-align: justify;
    color: #4a5568;
}

.content-display ul,
.content-display ol,
.content-display-full ul,
.content-display-full ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
    line-height: 1.7;
}

.content-display li,
.content-display-full li {
    margin-bottom: 0.5rem;
}

.content-display blockquote,
.content-display-full blockquote {
    border-left: 4px solid #3182ce;
    padding: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    background: #f7fafc;
    border-radius: 0.375rem;
    color: #2d3748;
}

.content-display img,
.content-display-full img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 2rem 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.content-display pre,
.content-display-full pre {
    background: #1a202c;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 2rem 0;
    font-size: 0.875rem;
    line-height: 1.6;
}
</style>
@endpush