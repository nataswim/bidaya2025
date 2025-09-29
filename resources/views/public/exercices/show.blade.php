@extends('layouts.public')

@section('title', $exercice->titre . ' - Exercice d\'Entraînement')
@section('meta_description', 'Découvrez l\'exercice ' . $exercice->titre . ' - ' . $exercice->type_exercice_label . ' niveau ' . $exercice->niveau_label . '. Instructions détaillées et conseils de sécurité.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white">
    <div class="container py-3">
        <!-- Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item">
                    <a href="{{ route('exercices.index') }}" class="text-white text-decoration-none opacity-75">
                        <i class="fas fa-dumbbell me-1"></i>Exercices
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">{{ $exercice->titre }}</li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">{{ $exercice->titre }}</h1>
                <div class="d-flex flex-wrap gap-3 mb-3">
                    <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }} fs-6 px-3 py-2">
                        <i class="fas fa-signal me-2"></i>{{ $exercice->niveau_label }}
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-tag me-2"></i>{{ $exercice->type_exercice_label }}
                    </span>
                </div>
                @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                    <div class="alert alert-info border-0 shadow-sm" 
                         style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-crosshairs text-info me-3 mt-1"></i>
                            <div class="text-dark">
                                <strong>Muscles ciblés :</strong> {{ $exercice->muscles_cibles_formatted }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 text-center">
                @if($exercice->image)
                    <img src="{{ $exercice->image }}" 
                         alt="{{ $exercice->titre }}" 
                         class="img-fluid rounded shadow"
                         style="max-height: 200px; width: auto;">
                @else
                    <div class="bg-white bg-opacity-10 rounded p-4 d-inline-flex align-items-center justify-content-center" 
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-running fa-4x text-white opacity-50"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Image principale -->
                @if($exercice->image)
                    <div class="card border-0 shadow-sm mb-4">
                        <img src="{{ $exercice->image }}" 
                             class="card-img-top rounded" 
                             style="height: 400px; object-fit: cover;" 
                             alt="{{ $exercice->titre }}">
                    </div>
                @endif

                <!-- Description -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white p-4">
        <h3 class="mb-0">
            <i class="fas fa-file-text me-2"></i>Description de l'exercice
        </h3>
    </div>
    <div class="card-body p-4">
        @if($exercice->description)
            <div class="content-display">
                {!! $exercice->description !!}
            </div>
        @else
            <p class="text-muted">Description non disponible pour cet exercice.</p>
        @endif
    </div>
</div>

                <!-- Consignes de sécurité -->
@if($exercice->consignes_securite)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-warning text-dark p-4">
            <h3 class="mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>Consignes de sécurité
            </h3>
        </div>
        <div class="card-body p-4">
            <div class="content-display alert-warning">
                {!! $exercice->consignes_securite !!}
            </div>
        </div>
    </div>
@endif

                <!-- Vidéo -->
                @if($exercice->video_url)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-success text-white p-4">
                            <h3 class="mb-0">
                                <i class="fas fa-play me-2"></i>Vidéo explicative
                            </h3>
                        </div>
                        <div class="card-body p-4 text-center">
                            <a href="{{ $exercice->video_url }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="btn btn-success btn-lg px-5 py-3">
                                <i class="fas fa-external-link-alt me-2"></i>Voir la vidéo explicative
                            </a>
                            <p class="text-muted small mt-3 mb-0">
                                <i class="fas fa-water me-1"></i>
                                La vidéo s'ouvrira dans un nouvel onglet
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Informations techniques -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white p-3">
                        <h5 class="mb-0">
                            <i class="fas fa-water me-2"></i>Informations techniques
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted fw-semibold">Niveau :</span>
                                    <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }} fs-6">
                                        {{ $exercice->niveau_label }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted fw-semibold">Type :</span>
                                    <strong class="text-dark">{{ $exercice->type_exercice_label }}</strong>
                                </div>
                            </div>
                            @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                                <div class="col-12">
                                    <div class="py-2">
                                        <span class="text-muted fw-semibold d-block mb-2">Muscles ciblés :</span>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($exercice->muscles_cibles as $muscle)
                                                <span class="badge bg-light text-dark border small">{{ ucfirst($muscle) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Call to action pour les plans -->
                @auth
                    @if(auth()->user()->hasRole('user') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('admin'))
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-success text-white p-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>Plans d'entraînement
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <p class="small mb-3">Découvrez nos plans d'entraînement personnalisés incluant cet exercice.</p>
                                <a href="{{ route('user.training.index') }}" class="btn btn-success btn-sm w-100 fw-bold">
                                    <i class="fas fa-arrow-right me-2"></i>Voir les plans
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-info text-white p-3">
                            <h6 class="mb-0">
                                <i class="fas fa-user-plus me-2"></i>Rejoignez-nous
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <p class="small mb-3">Connectez-vous pour accéder à nos plans d'entraînement personnalisés.</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm fw-bold">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user-plus me-2"></i>S'inscrire
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- Exercices similaires -->
                @if($exercicesSimilaires->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark p-3">
                            <h6 class="mb-0">
                                <i class="fas fa-dumbbell me-2"></i>Exercices similaires
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            @foreach($exercicesSimilaires as $similaire)
                                <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }} hover-item">
                                    @if($similaire->image)
                                        <img src="{{ $similaire->image }}" 
                                             class="rounded me-3" 
                                             style="width: 50px; height: 40px; object-fit: cover;" 
                                             alt="">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 40px;">
                                            <i class="fas fa-dumbbell text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-fill">
                                        <a href="{{ route('exercices.show', $similaire) }}" 
                                           class="text-decoration-none text-dark">
                                            <div class="fw-semibold mb-1">{{ $similaire->titre }}</div>
                                            <small class="text-muted">{{ $similaire->niveau_label }} • {{ $similaire->type_exercice_label }}</small>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Section Navigation -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <h5 class="fw-bold mb-3">Découvrez aussi</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('tools.index') }}" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-calculator me-2"></i>Outils de calcul
                        </a>
                    </div>
                    
                            <div class="col-md-4">
                                <a href="{{ route('plans.index') }}" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-calendar-alt me-2"></i>Plans de Musculation
                                </a>
                            </div>
 
                    <div class="col-md-4">
                        <a href="{{ route('public.index') }}" class="btn btn-outline-info btn-lg w-100">
                            <i class="fas fa-water me-2"></i>Articles & conseils
                        </a>
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
.hover-item {
    transition: all 0.2s ease;
    padding: 8px;
    border-radius: 8px;
}
.hover-item:hover {
    background-color: rgba(0,0,0,0.05);
}
/* Styles pour le contenu HTML de Quill */
.content-display {
    line-height: 1.8;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1.5rem;
    background: #ffffff;
    font-size: 1.1rem;
}

.content-display.alert-warning {
    background: #fff3cd;
    border-color: #ffc107;
}

.content-display h1,
.content-display h2,
.content-display h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.content-display h1 { font-size: 1.8rem; }
.content-display h2 { font-size: 1.5rem; }
.content-display h3 { font-size: 1.3rem; }

.content-display p {
    margin-bottom: 1rem;
    line-height: 1.8;
    color: #475569;
}

.content-display ul,
.content-display ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.content-display li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.content-display blockquote {
    border-left: 4px solid #0ea5e9;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #64748b;
    background: #f8fafc;
    padding: 1rem 1.5rem;
    border-radius: 0 0.5rem 0.5rem 0;
}

.content-display img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.content-display pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    border-left: 4px solid #0ea5e9;
    overflow-x: auto;
    margin: 1rem 0;
    font-size: 0.95rem;
}

.content-display strong {
    font-weight: 600;
    color: #1e293b;
}

.content-display em {
    font-style: italic;
    color: #475569;
}

/* Scrollbar personnalisé pour un meilleur look */
.content-display::-webkit-scrollbar {
    width: 8px;
}

.content-display::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.content-display::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.content-display::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animation au hover des éléments */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.hover-item {
    transition: all 0.2s ease;
    padding: 8px;
    border-radius: 8px;
}

.hover-item:hover {
    background-color: rgba(0,0,0,0.05);
}
</style>
</style>
@endpush
