@extends('layouts.public')

@section('title', $exercice->titre . ' - Exercice d\'Entraînement')
@section('meta_description', 'Découvrez l\'exercice ' . $exercice->titre . ' - ' . $exercice->type_exercice_label . ' niveau ' . $exercice->niveau_label . '. Instructions détaillées et conseils de sécurité.')

@section('content')

<!-- En-tête de section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-{{ $exercice->image ? '7' : '12' }}">
                <h1 class="display-5 fw-bold mb-0">{{ $exercice->titre }}</h1>
            </div>
            @if($exercice->image)
                <div class="col-lg-5">
                    <img src="{{ $exercice->image }}" 
                         alt="{{ $exercice->titre }}" 
                         class="img-fluid w-100 rounded shadow"
                         style="max-height: 300px; object-fit: cover; background-color: #ffffff;">
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="py-3 bg-light border-bottom">
    <div class="container-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('exercices.index') }}">
                        <i class="fas fa-dumbbell me-1"></i>Exercices
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Str::limit($exercice->titre, 50) }}
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
                            <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }} px-3 py-2">
                                <i class="fas fa-signal me-1"></i>{{ $exercice->niveau_label }}
                            </span>
                            
                            <span class="badge bg-primary px-3 py-2">
                                <i class="fas fa-tag me-1"></i>{{ $exercice->type_exercice_label }}
                            </span>
                            
                            @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-crosshairs me-1"></i>
                                    @foreach($exercice->muscles_cibles as $muscle)
                                        <span class="badge bg-secondary-subtle text-secondary me-1 small">
                                            {{ ucfirst($muscle) }}
                                        </span>
                                    @endforeach
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card 2: Muscles ciblés (si présents) -->
                @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 mb-0" 
                                 style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-crosshairs fs-3 text-info me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-2">Muscles ciblés</h6>
                                        <p class="mb-0 lead">{{ $exercice->muscles_cibles_formatted }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 3: Description -->
                @if($exercice->description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-file-text me-2"></i>Description de l'exercice
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="content-display fs-6 lh-lg">
                                {!! $exercice->description !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 4: Consignes de sécurité -->
                @if($exercice->consignes_securite)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>Consignes de sécurité
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="content-display-warning fs-6 lh-lg">
                                {!! $exercice->consignes_securite !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 5: Vidéo explicative -->
                @if($exercice->video_url)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-play me-2"></i>Vidéo explicative
                            </h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            <a href="{{ $exercice->video_url }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="btn btn-success btn-lg">
                                <i class="fas fa-external-link-alt me-2"></i>Voir la vidéo explicative
                            </a>
                            <p class="text-muted small mt-3 mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                La vidéo s'ouvrira dans un nouvel onglet
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Card 6: Exercices similaires -->
                @if($exercicesSimilaires->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-dumbbell me-2 text-primary"></i>
                                Exercices similaires
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @foreach($exercicesSimilaires as $similaire)
                                <div class="p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="row align-items-center">
                                        @if($similaire->image)
                                            <div class="col-auto">
                                                <img src="{{ $similaire->image }}" 
                                                     class="rounded" 
                                                     style="width: 80px; height: 60px; object-fit: cover;" 
                                                     alt="">
                                            </div>
                                        @else
                                            <div class="col-auto">
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 60px;">
                                                    <i class="fas fa-dumbbell text-muted fa-2x"></i>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col">
                                            <a href="{{ route('exercices.show', $similaire) }}" 
                                               class="text-decoration-none">
                                                <h6 class="mb-1">{{ Str::limit($similaire->titre, 60) }}</h6>
                                            </a>
                                            <div class="small text-muted">
                                                <span class="badge bg-{{ $similaire->niveau === 'debutant' ? 'success' : ($similaire->niveau === 'avance' ? 'danger' : 'warning') }}-subtle text-{{ $similaire->niveau === 'debutant' ? 'success' : ($similaire->niveau === 'avance' ? 'danger' : 'warning') }} me-2">
                                                    {{ $similaire->niveau_label }}
                                                </span>
                                                {{ $similaire->type_exercice_label }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Card 7: Informations techniques -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Informations techniques
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-signal me-1"></i>Niveau:
                                    </span>
                                    <strong>
                                        <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}">
                                            {{ $exercice->niveau_label }}
                                        </span>
                                    </strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-tag me-1"></i>Type:
                                    </span>
                                    <strong>{{ $exercice->type_exercice_label }}</strong>
                                </div>
                            </div>
                            @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <span class="text-muted">
                                            <i class="fas fa-crosshairs me-1"></i>Muscles ciblés:
                                        </span>
                                        <div class="text-end">
                                            <strong>{{ $exercice->muscles_cibles_formatted }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Ajouté le:
                                    </span>
                                    <strong>{{ $exercice->created_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise à jour:
                                    </span>
                                    <strong>{{ $exercice->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Navigation / Call to Action -->
                <div class="row g-4 mb-4">
                    <!-- Plans d'entraînement -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            @auth
                                @if(auth()->user()->hasRole('user') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('admin'))
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-calendar-alt me-2"></i>Plans d'entraînement
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-3">Découvrez nos plans d'entraînement personnalisés incluant cet exercice.</p>
                                        <a href="{{ route('user.training.index') }}" class="btn btn-success w-100">
                                            <i class="fas fa-arrow-right me-2"></i>Voir les plans
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-user-plus me-2"></i>Rejoignez-nous
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-3">Connectez-vous pour accéder à nos plans d'entraînement personnalisés.</p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('login') }}" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-user-plus me-2"></i>S'inscrire
                                        </a>
                                    </div>
                                </div>
                            @endauth
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
                                    <a href="{{ route('exercices.index') }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Tous les exercices
                                    </a>
                                    <a href="{{ route('tools.index') }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-calculator me-2"></i>Outils de calcul
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

<!-- Section Découvrez aussi -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <h3 class="fw-bold text-center mb-4">Découvrez aussi</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('plans.index') }}" class="btn btn-outline-primary btn-lg w-100">
                    <i class="fas fa-calendar-alt me-2"></i>Plans de musculation
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('tools.index') }}" class="btn btn-outline-success btn-lg w-100">
                    <i class="fas fa-calculator me-2"></i>Outils de calcul
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('public.index') }}" class="btn btn-outline-info btn-lg w-100">
                    <i class="fas fa-book me-2"></i>Articles & conseils
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Styles pour le contenu HTML */
.content-display h1,
.content-display h2,
.content-display h3,
.content-display-warning h1,
.content-display-warning h2,
.content-display-warning h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    line-height: 1.3;
}

.content-display h1, .content-display-warning h1 { font-size: 1.8rem; color: #2d3748; }
.content-display h2, .content-display-warning h2 { font-size: 1.5rem; color: #2d3748; }
.content-display h3, .content-display-warning h3 { font-size: 1.3rem; color: #2d3748; }

.content-display p,
.content-display-warning p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
    text-align: justify;
    color: #4a5568;
}

.content-display ul,
.content-display ol,
.content-display-warning ul,
.content-display-warning ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
    line-height: 1.7;
}

.content-display li,
.content-display-warning li {
    margin-bottom: 0.5rem;
}

.content-display blockquote,
.content-display-warning blockquote {
    border-left: 4px solid #3182ce;
    padding: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    background: #f7fafc;
    border-radius: 0.375rem;
    color: #2d3748;
}

.content-display-warning blockquote {
    border-left-color: #f59e0b;
    background: #fffbeb;
}

.content-display img,
.content-display-warning img {
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
.content-display-warning pre {
    background: #1a202c;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 2rem 0;
    font-size: 0.875rem;
    line-height: 1.6;
}

.content-display code,
.content-display-warning code {
    background-color: #edf2f7;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
    color: #d63384;
    font-family: 'Courier New', monospace;
}

.content-display strong,
.content-display-warning strong {
    font-weight: 600;
    color: #1e293b;
}

.card {
    transition: box-shadow 0.2s ease;
}

@media (max-width: 991px) {
    .col-lg-7, .col-lg-5 {
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .content-display,
    .content-display-warning {
        font-size: 0.95rem;
    }
    
    .display-5 {
        font-size: 1.75rem !important;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem !important;
    }
}
</style>
@endpush