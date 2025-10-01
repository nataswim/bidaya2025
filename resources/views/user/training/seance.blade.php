@extends('layouts.user')

@section('title', 'Séance : ' . $seance->titre)

@section('content')
<div class="container-lg py-5">
    <!-- Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.training.index') }}" class="text-decoration-none">Plans d'entraînement</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.training.show', $plan) }}" class="text-decoration-none">{{ $plan->titre }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.training.cycle', [$plan, $cycle]) }}" class="text-decoration-none">{{ $cycle->titre }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $seance->titre }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- En-tête de la séance -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h1 class="fw-bold mb-2">{{ $seance->titre }}</h1>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark">{{ $seance->type_seance_label }}</span>
                                <span class="badge bg-warning text-dark">{{ $seance->niveau_label }}</span>
                                @if($seance->duree_estimee_minutes)
                                    <span class="badge bg-info">
                                        <i class="fas fa-clock me-1"></i>{{ $seance->duree_estimee_minutes }} min
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0 opacity-75">
                                Plan : {{ $plan->titre }} • Cycle : {{ $cycle->titre }}
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            @if($seance->image)
                                <img src="{{ $seance->image }}" 
                                     alt="{{ $seance->titre }}" 
                                     class="img-fluid rounded shadow"
                                     style="max-height: 120px; width: auto;">
                            @else
                                <div class="bg-white bg-opacity-20 rounded p-3 d-inline-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-dumbbell fa-3x text-white opacity-75"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($seance->description)
    <div class="card-body p-4">
        <h5 class="fw-semibold mb-3">
            <i class="fas fa-water me-2 text-primary"></i>Description
        </h5>
        <div class="content-display-compact">
            {!! $seance->description !!}
        </div>
    </div>
@endif
            </div>
        </div>
    </div>

    <!-- Informations pratiques -->
    <div class="row mb-4">
       @if($seance->materiel_requis)
    <div class="col-md-6 mb-3">
        <div class="alert alert-warning">
            <h6 class="alert-heading">
                <i class="fas fa-tools me-2"></i>Matériel requis
            </h6>
            <div class="content-display-compact">
                {!! $seance->materiel_requis !!}
            </div>
        </div>
    </div>
@endif
        
        @if($seance->echauffement)
    <div class="col-md-6 mb-3">
        <div class="alert alert-info">
            <h6 class="alert-heading">
                <i class="fas fa-fire me-2"></i>Échauffement
            </h6>
            <div class="content-display-compact">
                {!! $seance->echauffement !!}
            </div>
        </div>
    </div>
@endif
    </div>

    <!-- Séries d'exercices -->
    @if($seance->series->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4">
                    <i class="fas fa-list-ol me-2 text-primary"></i>
                    Exercices de la séance ({{ $seance->series->count() }} série(s))
                </h2>
                
                <div class="row g-4">
                    @foreach($seance->series->sortBy('pivot.ordre') as $index => $serie)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-primary text-white p-3">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <span class="badge bg-light text-dark me-2">{{ $serie->pivot->ordre }}</span>
            <a href="{{ route('exercices.show', $serie->exercice) }}" 
               class="text-white text-decoration-none">
                {{ $serie->exercice->titre }}
                <i class="fas fa-external-link-alt ms-1 small"></i>
            </a>
        </h5>
        <span class="badge bg-success">
            {{ $serie->pivot->nombre_series }}x cette série
        </span>
    </div>
</div>
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-lg-3">
    <a href="{{ route('exercices.show', $serie->exercice) }}" 
       class="text-decoration-none">
        @if($serie->exercice->image)
            <div class="position-relative overflow-hidden rounded hover-zoom">
                <img src="{{ $serie->exercice->image }}" 
                     class="img-fluid rounded" 
                     style="height: 120px; width: 100%; object-fit: cover;" 
                     alt="{{ $serie->exercice->titre }}">
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-dark bg-opacity-75">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center hover-zoom" 
                 style="height: 120px;">
                <div class="text-center">
                    <i class="fas fa-running fa-2x text-muted opacity-25 mb-2"></i>
                    <div class="small text-muted">Voir détails</div>
                </div>
            </div>
        @endif
    </a>
</div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <div class="d-flex flex-wrap gap-2 mb-2">
                                                    <span class="badge bg-primary">{{ $serie->exercice->type_exercice_label }}</span>
                                                    <span class="badge bg-success">{{ $serie->exercice->niveau_label }}</span>
                                                </div>
                                                @if($serie->exercice->description)
                                                    <p class="text-muted small mb-2">
                                                        {!! Str::limit(strip_tags($serie->exercice->description), 120) !!}
                                                    </p>
                                                @endif
                                                @if($serie->exercice->muscles_cibles && count($serie->exercice->muscles_cibles) > 0)
                                                    <div class="small">
                                                        <strong class="text-primary">Muscles ciblés :</strong>
                                                        {{ $serie->exercice->muscles_cibles_formatted }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="text-center">
                                                <h6 class="fw-bold text-primary mb-3">Configuration</h6>
                                                <div class="row g-2 text-center">
                                                    @if($serie->repetitions)
                                                        <div class="col-6">
                                                            <div class="bg-light rounded p-2">
                                                                <div class="fw-bold text-primary">{{ $serie->repetitions }}</div>
                                                                <small class="text-muted">reps</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($serie->duree_secondes)
                                                        <div class="col-6">
                                                            <div class="bg-light rounded p-2">
                                                                <div class="fw-bold text-info">{{ gmdate('i:s', $serie->duree_secondes) }}</div>
                                                                <small class="text-muted">durée</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($serie->poids_kg)
                                                        <div class="col-6">
                                                            <div class="bg-light rounded p-2">
                                                                <div class="fw-bold text-warning">{{ $serie->poids_kg }}kg</div>
                                                                <small class="text-muted">poids</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($serie->distance_metres)
                                                        <div class="col-6">
                                                            <div class="bg-light rounded p-2">
                                                                <div class="fw-bold text-success">{{ $serie->distance_metres }}m</div>
                                                                <small class="text-muted">distance</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-12 mt-2">
                                                        <div class="bg-secondary bg-opacity-10 rounded p-2">
                                                            <div class="fw-bold text-secondary">{{ $serie->repos_formate }}</div>
                                                            <small class="text-muted">repos</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($serie->consignes)
    <div class="mt-3 pt-3 border-top">
        <h6 class="fw-semibold text-info">
            <i class="fas fa-lightbulb me-2"></i>Consignes spécifiques
        </h6>
        <div class="alert alert-info mb-0">
            <div class="content-display-compact">
                {!! $serie->consignes !!}
            </div>
        </div>
    </div>
@endif
                                    
                                    @if($serie->pivot->notes)
                                        <div class="mt-3 pt-3 border-top">
                                            <h6 class="fw-semibold text-warning">
                                                <i class="fas fa-sticky-note me-2"></i>Notes pour cette séance
                                            </h6>
                                            <div class="alert alert-warning mb-0">
                                                {{ $serie->pivot->notes }}
                                            </div>
                                        </div>
                                    @endif

                                    @if($serie->exercice->consignes_securite)
    <div class="mt-3 pt-3 border-top">
        <h6 class="fw-semibold text-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>Consignes de sécurité
        </h6>
        <div class="alert alert-danger mb-0">
            <div class="content-display-compact">
                {!! $serie->exercice->consignes_securite !!}
            </div>
        </div>
    </div>
@endif
                                </div>
                                <div class="card-footer bg-light p-3">
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">
            <i class="fas fa-repeat me-1"></i>
            Répéter {{ $serie->pivot->nombre_series }} fois cette série
        </small>
        <div class="d-flex gap-2">
            <a href="{{ route('exercices.show', $serie->exercice) }}" 
               class="btn btn-sm btn-outline-success">
                <i class="fas fa-info-circle me-1"></i>Détails exercice
            </a>
            @if($serie->exercice->video_url)
                <a href="{{ $serie->exercice->video_url }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-play me-1"></i>Voir la vidéo
                </a>
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
        <div class="row mb-5">
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                    <h4>Aucun exercice configuré</h4>
                    <p class="mb-0">Cette séance ne contient pas encore d'exercices.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Retour au calme -->
    @if($seance->retour_calme)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success">
                <h5 class="alert-heading">
                    <i class="fas fa-leaf me-2"></i>Retour au calme
                </h5>
                <div class="content-display-compact">
                    {!! $seance->retour_calme !!}
                </div>
            </div>
        </div>
    </div>
@endif

    <!-- Actions et navigation -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.training.cycle', [$plan, $cycle]) }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour au cycle
                                </a>
                                <a href="{{ route('user.training.show', $plan) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-calendar-alt me-2"></i>Voir le plan complet
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            @if($userPlan)
                                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                    <span class="badge bg-{{ 
                                        $userPlan->pivot->statut === 'en_cours' ? 'success' : 
                                        ($userPlan->pivot->statut === 'termine' ? 'info' : 'secondary')
                                    }} fs-6 px-3 py-2">
                                        Statut : {{ $userPlan->pivot->statut_label ?? 'Non commencé' }}
                                    </span>
                                    @if($userPlan->pivot->progression_pourcentage > 0)
                                        <span class="badge bg-info fs-6 px-3 py-2">
                                            <i class="fas fa-chart-line me-1"></i>
                                            {{ $userPlan->pivot->progression_pourcentage }}% complété
                                        </span>
                                    @endif
                                </div>
                            @else
                                <button class="btn btn-success" disabled>
                                    <i class="fas fa-play me-2"></i>Séance en cours
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.alert-sm {
    padding: 0.375rem 0.75rem;
    margin-bottom: 0.5rem;
}
/* Animations et effets hover */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.hover-zoom {
    transition: transform 0.3s ease;
}

.hover-zoom:hover {
    transform: scale(1.05);
}

/* Alertes compactes */
.alert-sm {
    padding: 0.375rem 0.75rem;
    margin-bottom: 0.5rem;
}

/* Contenu Quill compact */
.content-display-compact {
    line-height: 1.6;
    font-size: 0.95rem;
}

.content-display-compact p {
    margin-bottom: 0.5rem;
}

.content-display-compact p:last-child {
    margin-bottom: 0;
}

.content-display-compact ul,
.content-display-compact ol {
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
}

.content-display-compact li {
    margin-bottom: 0.25rem;
}

.content-display-compact strong {
    font-weight: 600;
}

.content-display-compact h1,
.content-display-compact h2,
.content-display-compact h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0.5rem 0;
}

.content-display-compact blockquote {
    border-left: 3px solid rgba(0,0,0,0.1);
    padding-left: 1rem;
    margin: 0.5rem 0;
    font-style: italic;
    color: #6c757d;
}

.content-display-compact img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin: 0.5rem 0;
}
</style>
@endpush