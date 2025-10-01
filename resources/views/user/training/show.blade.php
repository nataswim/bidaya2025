@extends('layouts.user')

@section('title', $plan->titre . ' - Plan d\'Entraînement')

@section('content')
<div class="container-lg py-5">
    <!-- En-tête du plan -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                @if($plan->image)
                    <div class="position-relative">
                        <img src="{{ $plan->image }}" class="card-img-top" style="height: 300px; object-fit: cover;" alt="">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-end">
                            <div class="p-4 text-white">
                                <h1 class="fw-bold mb-2">{{ $plan->titre }}</h1>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark">{{ $plan->niveau_label }}</span>
                                    <span class="badge bg-primary">{{ $plan->objectif_label }}</span>
                                    @if($plan->duree_semaines)
                                        <span class="badge bg-info">{{ $plan->duree_semaines_formattee }}</span>
                                    @endif
                                    @if($plan->is_featured)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>Premium
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-header bg-primary text-white p-4">
                        <h1 class="fw-bold mb-2">{{ $plan->titre }}</h1>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark">{{ $plan->niveau_label }}</span>
                            <span class="badge bg-warning text-dark">{{ $plan->objectif_label }}</span>
                            @if($plan->duree_semaines)
                                <span class="badge bg-info">{{ $plan->duree_semaines_formattee }}</span>
                            @endif
                        </div>
                    </div>
                @endif
                
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-8">
                            @if($plan->description)
    <div class="content-display-compact mb-4">
        {!! $plan->description !!}
    </div>
@endif
                            
                            @if($plan->prerequis)
    <div class="alert alert-info">
        <h6 class="fw-semibold mb-2">
            <i class="fas fa-water me-2"></i>Prérequis
        </h6>
        <div class="content-display-compact">
            {!! $plan->prerequis !!}
        </div>
    </div>
@endif
                            
                            @if($plan->conseils_generaux)
    <div class="alert alert-success">
        <h6 class="fw-semibold mb-2">
            <i class="fas fa-lightbulb me-2"></i>Conseils Généraux
        </h6>
        <div class="content-display-compact">
            {!! $plan->conseils_generaux !!}
        </div>
    </div>
@endif
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Statut utilisateur -->
                            @if($userPlan)
                                <div class="card bg-light mb-4">
                                    <div class="card-body p-3">
                                        <h6 class="fw-semibold mb-3">Mon Statut</h6>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Statut :</span>
                                            <span class="badge bg-{{ $userPlan->pivot->statut_color }}-subtle text-{{ $userPlan->pivot->statut_color }}">
                                                {{ $userPlan->pivot->statut_label }}
                                            </span>
                                        </div>
                                        
                                        @if($userPlan->pivot->progression_pourcentage > 0)
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Progression</span>
                                                    <span>{{ $userPlan->pivot->progression_pourcentage }}%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-success" 
                                                         style="width: {{ $userPlan->pivot->progression_pourcentage }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($userPlan->pivot->date_debut)
                                            <small class="text-muted d-block">
                                                Commencé le {{ \Carbon\Carbon::parse($userPlan->pivot->date_debut)->format('d/m/Y') }}
                                            </small>
                                        @endif
                                        
                                        <!-- Actions de statut -->
                                        <div class="mt-3">
                                            @if($userPlan->pivot->statut === 'pause')
                                                <form method="POST" action="{{ route('user.training.update-statut', $plan) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="statut" value="en_cours">
                                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                                        <i class="fas fa-play me-1"></i>Reprendre
                                                    </button>
                                                </form>
                                            @elseif($userPlan->pivot->statut === 'en_cours')
                                                <form method="POST" action="{{ route('user.training.update-statut', $plan) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="statut" value="pause">
                                                    <button type="submit" class="btn btn-warning btn-sm w-100">
                                                        <i class="fas fa-pause me-1"></i>Mettre en pause
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Commencer le plan -->
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body p-3 text-center">
                                        <h6 class="fw-semibold mb-2">Prêt à commencer ?</h6>
                                        <p class="small mb-3">Lancez-vous dans ce programme d'entraînement adapté à votre niveau.</p>
                                        <form method="POST" action="{{ route('user.training.commencer', $plan) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light btn-sm">
                                                <i class="fas fa-play me-2"></i>Commencer ce plan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Informations du plan -->
                            <div class="card">
                                <div class="card-body p-3">
                                    <h6 class="fw-semibold mb-3">Informations</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Cycles :</span>
                                        <strong>{{ $plan->cycles->count() }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Séances :</span>
                                        <strong>{{ $plan->getTotalSeances() }}</strong>
                                    </div>
                                    @if($plan->duree_semaines)
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Durée :</span>
                                            <strong>{{ $plan->duree_semaines_formattee }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cycles du plan -->
    <div class="row">
        <div class="col-12">
            <h3 class="fw-semibold mb-4">
                <i class="fas fa-sync-alt me-2 text-primary"></i>Cycles d'Entraînement
            </h3>
            
            @if($plan->cycles->count() > 0)
                <div class="row g-4">
                    @foreach($plan->cycles as $cycle)
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="mb-0">
                                            <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                            {{ $cycle->titre }}
                                        </h5>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $cycle->objectif_label }}
                                        </span>
                                    </div>
                                    
                                    @if($cycle->description)
    <p class="text-muted mb-3">{!! Str::limit(strip_tags($cycle->description), 100) !!}</p>
@endif
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            {{ $cycle->seances->count() }} séances
                                            @if($cycle->duree_semaines)
                                                • {{ $cycle->duree_semaines_formattee }}
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <a href="{{ route('user.training.cycle', [$plan, $cycle]) }}" 
                                       class="btn btn-outline-primary w-100">
                                        <i class="fas fa-eye me-2"></i>Voir le cycle
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-sync-alt fa-3x text-muted mb-3 opacity-25"></i>
                    <h5>Aucun cycle configuré</h5>
                    <p class="text-muted">Ce plan est en cours de préparation.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('user.training.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour aux plans
                </a>
                
                @if($userPlan)
                    <a href="{{ route('user.training.mes-plans') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i>Mes plans
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Animations cartes */
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}

/* Contenu Quill compact (pour alertes et sections courtes) */
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