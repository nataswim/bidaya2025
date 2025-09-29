@extends('layouts.admin')

@section('title', 'Détail série')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list-ol me-2"></i>{{ $series->nom ?: 'Série #' . $series->id }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Exercice associé -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Exercice</h6>
                        @if($series->exercice)
                            <div class="d-flex align-items-center">
                                @if($series->exercice->image)
                                    <img src="{{ $series->exercice->image }}" 
                                         class="rounded me-3" 
                                         style="width: 60px; height: 45px; object-fit: cover;" 
                                         alt="">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 45px;">
                                        <i class="fas fa-running text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('admin.training.exercices.show', $series->exercice) }}" 
                                           class="text-decoration-none">
                                            {{ $series->exercice->titre }}
                                        </a>
                                    </h6>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-primary">{{ $series->exercice->type_exercice_label }}</span>
                                        <span class="badge bg-success">{{ $series->exercice->niveau_label }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Exercice non trouvé ou supprimé
                            </div>
                        @endif
                    </div>

                    <!-- Configuration de la série -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Configuration</h6>
                        <div class="row g-3">
                            @if($series->repetitions)
                                <div class="col-md-3">
                                    <div class="bg-light p-3 rounded text-center">
                                        <h4 class="fw-bold text-primary mb-1">{{ $series->repetitions }}</h4>
                                        <small class="text-muted">Répétitions</small>
                                    </div>
                                </div>
                            @endif
                            @if($series->duree_secondes)
                                <div class="col-md-3">
                                    <div class="bg-light p-3 rounded text-center">
                                        <h4 class="fw-bold text-info mb-1">{{ gmdate('i:s', $series->duree_secondes) }}</h4>
                                        <small class="text-muted">Durée</small>
                                    </div>
                                </div>
                            @endif
                            @if($series->distance_metres)
                                <div class="col-md-3">
                                    <div class="bg-light p-3 rounded text-center">
                                        <h4 class="fw-bold text-warning mb-1">{{ $series->distance_metres }}m</h4>
                                        <small class="text-muted">Distance</small>
                                    </div>
                                </div>
                            @endif
                            @if($series->poids_kg)
                                <div class="col-md-3">
                                    <div class="bg-light p-3 rounded text-center">
                                        <h4 class="fw-bold text-success mb-1">{{ $series->poids_kg }}kg</h4>
                                        <small class="text-muted">Poids</small>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-3">
                                <div class="bg-light p-3 rounded text-center">
                                    <h4 class="fw-bold text-secondary mb-1">{{ $series->repos_formate }}</h4>
                                    <small class="text-muted">Repos</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consignes -->
                    @if($series->consignes)
    <div class="mb-4">
        <h6 class="fw-semibold mb-3">Consignes spécifiques</h6>
        <div class="content-display">
            {!! $series->consignes !!}
        </div>
    </div>
@endif

                    <!-- Séances utilisant cette série -->
                    @if($series->seances->count() > 0)
                        <div class="border-top pt-4">
                            <h6 class="fw-semibold mb-3">Utilisée dans {{ $series->seances->count() }} séance(s)</h6>
                            <div class="row g-2">
                                @foreach($series->seances as $seance)
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body p-3">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('admin.training.seances.show', $seance) }}" 
                                                       class="text-decoration-none">
                                                        {{ $seance->titre }}
                                                    </a>
                                                </h6>
                                                <div class="small text-muted">
                                                    Ordre: {{ $seance->pivot->ordre }} • 
                                                    {{ $seance->pivot->nombre_series }}x cette série
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white p-3">
                    <h6 class="mb-0">Informations</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <small class="text-muted">Statut</small>
                            <div>
                                <span class="badge bg-{{ $series->is_active ? 'success' : 'secondary' }}">
                                    {{ $series->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Ordre</small>
                            <div><strong>{{ $series->ordre }}</strong></div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Créée le</small>
                            <div><small>{{ $series->created_at->format('d/m/Y') }}</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.training.series.edit', $series) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('admin.training.series.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('styles')
<style>
/* Styles pour le contenu HTML de Quill */
.content-display {
    line-height: 1.6;
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    background: #f9fafb;
}

.content-display h1,
.content-display h2,
.content-display h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.content-display p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

.content-display ul,
.content-display ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.content-display blockquote {
    border-left: 4px solid var(--bs-primary);
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6c757d;
}

.content-display img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.content-display pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    border-left: 4px solid #0ea5e9;
    overflow-x: auto;
    margin: 1rem 0;
}
</style>
@endpush

@endsection