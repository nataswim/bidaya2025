@extends('layouts.user')

@section('title', $event->title)

@section('content')
<div class="container-lg py-5">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid {{ $event->type_color }} !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-start">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 60px; height: 60px; background-color: {{ $event->type_color }}20;">
                                <i class="{{ $event->type_icon }} fa-2x" style="color: {{ $event->type_color }};"></i>
                            </div>
                            <div>
                                <h1 class="mb-2">{{ $event->title }}</h1>
                                <span class="badge bg-secondary-subtle text-secondary">
                                    {{ $event->type_label }}
                                </span>
                                @if($event->discipline)
                                    <span class="badge bg-info-subtle text-info ms-2">
                                        {{ $event->discipline }}
                                    </span>
                                @endif
                                {!! $event->status_badge !!}
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            @if($event->status === 'planned' && !$event->is_past)
                                <a href="{{ route('user.calendar.edit', $event) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </a>
                            @endif
                            
                            @if($event->needs_completion)
                                <button type="button" class="btn btn-sm btn-warning" onclick="completeEvent({{ $event->id }})">
                                    <i class="fas fa-check-circle me-1"></i>Compléter
                                </button>
                            @endif
                            
                            <form action="{{ route('user.calendar.destroy', $event) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Supprimer cette activité ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Informations principales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">📋 Informations</h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-primary fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Date</small>
                                    <strong>{{ $event->formatted_date }}</strong>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Heure</small>
                                    <strong>{{ $event->formatted_time }}</strong>
                                </div>
                            </div>
                        </div>
                        
                        @if($event->location)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-danger fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Lieu</small>
                                    <strong>{{ $event->location }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($event->objective)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-bullseye text-success fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Objectif</small>
                                    <strong>{{ $event->objective }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($event->description)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">📝 Description</h5>
                    <p class="mb-0">{{ $event->description }}</p>
                </div>
            </div>
            @endif

            <!-- Remarques -->
            @if($event->remarks)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">💭 Remarques</h5>
                    <p class="mb-0">{{ $event->remarks }}</p>
                </div>
            </div>
            @endif

            <!-- NOUVEAU : Contenus liés -->
            @if($event->hasLinkedContent())
            <div class="card border-0 shadow-sm mb-4 border-start border-info border-4">
                <div class="card-body p-4">
                    <h5 class="mb-3 text-info">🔗 Contenus liés</h5>
                    
                    <!-- Workout lié -->
                    @if($event->linked_workout)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Séance d'entraînement</h6>
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-dumbbell text-primary fa-lg me-3"></i>
                                            <div>
                                                <strong>{{ $event->linked_workout->title }}</strong>
                                                @if($event->linked_workout->short_description)
                                                    <br><small class="text-muted">{{ Str::limit($event->linked_workout->short_description, 100) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $firstCategory = $event->linked_workout->categories->first();
                                        @endphp
                                        @if($firstCategory && $firstCategory->section)
                                            <a href="{{ route('public.workouts.show', [$firstCategory->section->slug, $firstCategory->slug, $event->linked_workout->slug]) }}" 
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-external-link-alt me-1"></i>Voir la séance
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Exercices liés -->
                    @if($event->linked_exercices->count() > 0)
                        <div>
                            <h6 class="text-muted mb-2">Exercices ({{ $event->linked_exercices->count() }})</h6>
                            <div class="list-group">
                                @foreach($event->linked_exercices as $index => $exercice)
                                    <div class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary me-3">{{ $index + 1 }}</span>
                                                <i class="fas fa-running text-success me-2"></i>
                                                <div>
                                                    <strong>{{ $exercice->titre }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <span class="badge bg-info-subtle text-info">{{ $exercice->niveau_label }}</span>
                                                        @if($exercice->type_exercice)
                                                            <span class="badge bg-secondary-subtle text-secondary ms-1">{{ $exercice->type_exercice_label }}</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <a href="{{ route('exercices.show', $exercice->id) }}" 
                                               class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Données de performance (si complété) -->
            @if($event->status === 'completed')
            <div class="card border-0 shadow-sm mb-4 border-start border-success border-4">
                <div class="card-body p-4">
                    <h5 class="mb-3 text-success">📊 Performance & Retour</h5>
                    
                    <div class="row g-3">
                        @if($event->effort_feeling)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-heartbeat text-danger fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Ressenti de l'effort</small>
                                    <strong>{{ $event->effort_feeling }}/10</strong>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-danger" style="width: {{ $event->effort_feeling * 10 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($event->objective_achieved)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-target text-success fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Objectif</small>
                                    <strong>{{ $event->objective_achieved_label }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($event->actual_duration)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-stopwatch text-primary fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Durée réelle</small>
                                    <strong>{{ $event->actual_duration }}</strong>
                                    @if($event->planned_duration)
                                        <small class="text-muted">(prévu: {{ $event->planned_duration }})</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($event->actual_distance)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-route text-info fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Distance réelle</small>
                                    <strong>{{ $event->actual_distance }}</strong>
                                    @if($event->planned_distance)
                                        <small class="text-muted">(prévu: {{ $event->planned_distance }})</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($event->weather_conditions)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cloud-sun text-warning fa-lg me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Météo</small>
                                    <strong>{{ $event->weather_label }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    @if($event->pain_discomfort)
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted d-block mb-1">Douleurs/Gênes</small>
                        <p class="mb-0 text-danger">{{ $event->pain_discomfort }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Planification -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="mb-3">📦 Planification</h6>
                    
                    @if($event->material)
                    <div class="mb-3">
                        <small class="text-muted d-block">Matériel</small>
                        <p class="mb-0">{{ $event->material }}</p>
                    </div>
                    @endif
                    
                    @if($event->planned_duration)
                    <div class="mb-3">
                        <small class="text-muted d-block">Durée prévue</small>
                        <strong>{{ $event->planned_duration }}</strong>
                    </div>
                    @endif
                    
                    @if($event->planned_distance)
                    <div class="mb-3">
                        <small class="text-muted d-block">Distance prévue</small>
                        <strong>{{ $event->planned_distance }}</strong>
                    </div>
                    @endif
                    
                    @if(!$event->material && !$event->planned_duration && !$event->planned_distance)
                    <p class="text-muted mb-0 small">Aucune information de planification</p>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="mb-3">⚡ Actions rapides</h6>
                    
                    @if($event->needs_completion)
                        <button type="button" class="btn btn-warning w-100 mb-2" onclick="completeEvent({{ $event->id }})">
                            <i class="fas fa-check-circle me-1"></i>Compléter mon retour
                        </button>
                    @endif
                    
                    @if($event->status === 'planned' && !$event->is_past)
                        <a href="{{ route('user.calendar.edit', $event) }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-edit me-1"></i>Modifier
                        </a>
                        
                        <button type="button" class="btn btn-outline-warning w-100 mb-2" onclick="cancelEvent({{ $event->id }})">
                            <i class="fas fa-ban me-1"></i>Annuler l'activité
                        </button>
                    @endif
                    
                    <a href="{{ route('user.calendar.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-1"></i>Retour au calendrier
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Finalisation -->
@include('user.calendar.partials.complete-modal')

@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endpush
@push('scripts')
<script>
let currentEventId = {{ $event->id }};

function completeEvent(eventId) {
    currentEventId = eventId;
    
    const form = document.getElementById('completeEventForm');
    if (form) form.reset();
    
    openModal('completeEventModal');
}

function submitComplete() {
    const form = document.getElementById('completeEventForm');
    const formData = new FormData(form);
    
    const effortFeeling = formData.get('effort_feeling');
    const objectiveAchieved = formData.get('objective_achieved');
    
    if (!effortFeeling) {
        alert('Veuillez sélectionner un ressenti de l\'effort');
        return;
    }
    
    if (!objectiveAchieved) {
        alert('Veuillez indiquer si l\'objectif a été atteint');
        return;
    }
    
    fetch(`/user/calendar/${currentEventId}/complete`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('completeEventModal');
            alert('✅ Activité finalisée avec succès !');
            location.reload();
        } else {
            alert('Erreur lors de la finalisation');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la finalisation');
    });
}

function cancelEvent(eventId) {
    if (!confirm('Annuler cette activité ?')) return;
    
    fetch(`/user/calendar/${eventId}/cancel`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function openModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
        const modal = new window.bootstrap.Modal(modalEl);
        modal.show();
    }
}

function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
        const modalInstance = window.bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }
}
</script>
@endpush