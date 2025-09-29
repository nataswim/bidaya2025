@extends('layouts.user')

@section('title', $exercice->titre . ' - Exercice')

@section('content')
<div class="container-lg py-5">
    <!-- Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.training.index') }}" class="text-decoration-none">Plans d'Entraînement</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $exercice->titre }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Image et titre -->
            <div class="card border-0 shadow-sm mb-4">
                @if($exercice->image)
                    <img src="{{ $exercice->image }}" 
                         class="card-img-top" 
                         style="height: 300px; object-fit: cover;" 
                         alt="{{ $exercice->titre }}">
                @endif
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="fw-bold mb-0">{{ $exercice->titre }}</h1>
                        <div class="d-flex gap-2">
                            <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}-subtle text-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }} fs-6">
                                {{ $exercice->niveau_label }}
                            </span>
                            <span class="badge bg-primary-subtle text-primary fs-6">
                                {{ $exercice->type_exercice_label }}
                            </span>
                        </div>
                    </div>
                    
                    @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                        <div class="mb-3">
                            <h6 class="fw-semibold mb-2 text-primary">
                                <i class="fas fa-crosshairs me-2"></i>Muscles ciblés
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($exercice->muscles_cibles as $muscle)
                                    <span class="badge bg-light text-dark border">{{ ucfirst($muscle) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-file-text me-2 text-primary"></i>Description de l'exercice
                    </h5>
                    <div class="text-muted">
                        {!! nl2br(e($exercice->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Consignes de sécurité -->
            @if($exercice->consignes_securite)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-semibold mb-3 text-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>Consignes de sécurité
                        </h5>
                        <div class="alert alert-warning border-0">
                            {!! nl2br(e($exercice->consignes_securite)) !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Vidéo -->
            @if($exercice->video_url)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="fas fa-play me-2 text-primary"></i>Vidéo explicative
                        </h5>
                        <div class="text-center">
                            <a href="{{ $exercice->video_url }}" 
                               target="_blank" 
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-external-link-alt me-2"></i>Voir la vidéo
                            </a>
                            <p class="text-muted small mt-2 mb-0">
                                La vidéo s'ouvrira dans un nouvel onglet
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informations techniques -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-water me-2"></i>Informations
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Niveau :</span>
                                <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}-subtle text-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}">
                                    {{ $exercice->niveau_label }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Type :</span>
                                <strong>{{ $exercice->type_exercice_label }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Muscles :</span>
                                <strong>{{ $exercice->muscles_cibles_formatted }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conseils -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Conseils
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small>Commencez toujours par un échauffement adapté</small>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small>Respectez le tempo et la technique</small>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small>Adaptez l'intensité à votre niveau</small>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small>Hydratez-vous régulièrement</small>
                    </div>
                </div>
            </div>

            <!-- Exercices similaires -->
            @php
                $exercicesSimilaires = \App\Models\Exercice::where('type_exercice', $exercice->type_exercice)
                    ->where('id', '!=', $exercice->id)
                    ->where('is_active', true)
                    ->limit(3)
                    ->get();
            @endphp

            @if($exercicesSimilaires->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white p-3">
                        <h6 class="mb-0">
                            <i class="fas fa-dumbbell me-2"></i>Exercices similaires
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        @foreach($exercicesSimilaires as $similaire)
                            <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                                @if($similaire->image)
                                    <img src="{{ $similaire->image }}" 
                                         class="rounded me-3" 
                                         style="width: 40px; height: 30px; object-fit: cover;" 
                                         alt="">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 30px;">
                                        <i class="fas fa-dumbbell text-muted small"></i>
                                    </div>
                                @endif
                                <div class="flex-fill">
                                    <a href="{{ route('user.training.exercice', $similaire) }}" 
                                       class="text-decoration-none text-dark">
                                        <small class="fw-semibold d-block">{{ $similaire->titre }}</small>
                                        <small class="text-muted">{{ $similaire->niveau_label }}</small>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="text-center">
                <a href="{{ route('user.training.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Retour aux plans d'entraînement
                </a>
            </div>
        </div>
    </div>
</div>
@endsection