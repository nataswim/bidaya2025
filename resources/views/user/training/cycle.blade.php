@extends('layouts.user')


@section('title', 'Cycle : ' . $cycle->titre)

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
                    <li class="breadcrumb-item active">{{ $cycle->titre }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- En-tête du cycle -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h1 class="fw-bold mb-2">{{ $cycle->titre }}</h1>
                            <p class="mb-0 opacity-75">Cycle du plan : {{ $plan->titre }}</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-dark fs-6">{{ $cycle->objectif_label }}</span>
                            @if($cycle->duree_semaines)
                                <div class="mt-2">
                                    <small class="opacity-75">{{ $cycle->duree_semaines }} semaine(s)</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($cycle->description)
    <div class="card-body p-4">
        <div class="content-display-compact">
            {!! $cycle->description !!}
        </div>
    </div>
@endif
            </div>
        </div>
    </div>

    <!-- Conseils du cycle -->
    @if($cycle->conseils)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <h5 class="alert-heading">
                    <i class="fas fa-lightbulb me-2"></i>Conseils pour ce cycle
                </h5>
                <div class="content-display-compact">
                    {!! $cycle->conseils !!}
                </div>
            </div>
        </div>
    </div>
@endif

    <!-- Séances du cycle -->
    @if($cycle->seances->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4">
                    <i class="fas fa-calendar-week me-2 text-primary"></i>
                    Séances du cycle ({{ $cycle->seances->count() }})
                </h2>
                
                @php
                    $seancesByWeek = $cycle->seances->groupBy('pivot.semaine_cycle');
                @endphp
                
                @foreach($seancesByWeek as $semaine => $seances)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">
                                <i class="fas fa-calendar me-2"></i>
                                Semaine {{ $semaine }}
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach($seances->sortBy('pivot.ordre') as $seance)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card border h-100 hover-lift">
                                            @if($seance->image)
                                                <img src="{{ $seance->image }}" 
                                                     class="card-img-top" 
                                                     style="height: 150px; object-fit: cover;" 
                                                     alt="{{ $seance->titre }}">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                     style="height: 150px;">
                                                    <i class="fas fa-dumbbell fa-2x text-muted opacity-25"></i>
                                                </div>
                                            @endif
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <span class="badge bg-primary">Jour {{ $seance->pivot->ordre }}</span>
                                                    @if($seance->pivot->jour_semaine)
                                                        <span class="badge bg-info">
                                                            {{ ['', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'][$seance->pivot->jour_semaine] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <h5 class="card-title fw-bold">{{ $seance->titre }}</h5>
                                                
                                                <div class="d-flex flex-wrap gap-1 mb-3">
                                                    <span class="badge bg-secondary">{{ $seance->type_seance_label }}</span>
                                                    <span class="badge bg-warning text-dark">{{ $seance->niveau_label }}</span>
                                                    @if($seance->duree_estimee_minutes)
                                                        <span class="badge bg-info">{{ $seance->duree_estimee_minutes }}min</span>
                                                    @endif
                                                </div>
                                                
                                                @if($seance->description)
                                                    <p class="card-text text-muted small">
                                                        {{ Str::limit(strip_tags($seance->description), 80) }}
                                                    </p>
                                                @endif
                                                
                                                @if($seance->pivot->notes)
                                                    <div class="alert alert-info alert-sm py-2">
                                                        <small>
                                                            <i class="fas fa-sticky-note me-1"></i>
                                                            {{ $seance->pivot->notes }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-footer bg-white border-top-0">
                                                <a href="{{ route('user.training.seance', [$plan, $cycle, $seance]) }}" 
                                                   class="btn btn-outline-primary w-100">
                                                    <i class="fas fa-play me-2"></i>Commencer la séance
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="row mb-5">
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                    <h4>Aucune séance disponible</h4>
                    <p class="mb-0">Ce cycle ne contient pas encore de séances d'entraînement.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('user.training.show', $plan) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour au plan
                </a>
                @if($userPlan)
                    <div class="d-flex gap-2">
                        <span class="badge bg-{{ $userPlan->pivot->statut === 'en_cours' ? 'success' : 'secondary' }} fs-6 px-3 py-2">
                            Statut : {{ $userPlan->pivot->statut_label ?? 'Non commencé' }}
                        </span>
                        @if($userPlan->pivot->progression_pourcentage > 0)
                            <span class="badge bg-info fs-6 px-3 py-2">
                                {{ $userPlan->pivot->progression_pourcentage }}% complété
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Animations cartes */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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