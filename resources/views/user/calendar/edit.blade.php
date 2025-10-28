@extends('layouts.user')

@section('title', 'Modifier l\'activité')

@section('content')
<div class="container-lg py-5">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.calendar.index') }}">Calendrier</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.calendar.show', $event) }}">{{ $event->title }}</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-2">✏️ Modifier l'activité</h1>
            <p class="text-muted">{{ $event->title }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <form action="{{ route('user.calendar.update', $event) }}" method="POST" id="eventForm">
                @csrf
                @method('PUT')
                
                <!-- Informations générales -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations générales</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Discipline</label>
                                <input type="text" name="discipline" class="form-control @error('discipline') is-invalid @enderror" 
                                       value="{{ old('discipline', $event->discipline) }}">
                                @error('discipline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Titre de l'activité <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $event->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Type d'activité <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="entrainement" {{ old('type', $event->type) == 'entrainement' ? 'selected' : '' }}>🏋️ Entraînement</option>
                                    <option value="rendez-vous" {{ old('type', $event->type) == 'rendez-vous' ? 'selected' : '' }}>📅 Rendez-vous</option>
                                    <option value="stage" {{ old('type', $event->type) == 'stage' ? 'selected' : '' }}>🍽️ Stage</option>
                                    <option value="competition" {{ old('type', $event->type) == 'competition' ? 'selected' : '' }}>💊 Compétition</option>
                                    <option value="autres" {{ old('type', $event->type) == 'autres' ? 'selected' : '' }}>📝 Autres</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Objectif</label>
                                <input type="text" name="objective" class="form-control @error('objective') is-invalid @enderror" 
                                       value="{{ old('objective', $event->objective) }}">
                                @error('objective')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date & Lieu -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Date & Lieu</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror" 
                                       value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Heure <span class="text-danger">*</span></label>
                                <input type="time" name="event_time" class="form-control @error('event_time') is-invalid @enderror" 
                                       value="{{ old('event_time', $event->event_time->format('H:i')) }}" required>
                                @error('event_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lieu</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                       value="{{ old('location', $event->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Détails</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Remarques</label>
                            <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                                      rows="2">{{ old('remarks', $event->remarks) }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Matériel nécessaire</label>
                            <input type="text" name="material" class="form-control @error('material') is-invalid @enderror" 
                                   value="{{ old('material', $event->material) }}">
                            @error('material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Durée prévue</label>
                                <input type="text" name="planned_duration" class="form-control @error('planned_duration') is-invalid @enderror" 
                                       value="{{ old('planned_duration', $event->planned_duration) }}">
                                @error('planned_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Distance prévue</label>
                                <input type="text" name="planned_distance" class="form-control @error('planned_distance') is-invalid @enderror" 
                                       value="{{ old('planned_distance', $event->planned_distance) }}">
                                @error('planned_distance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NOUVEAU : Lier à un contenu (MODIFIABLE) -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-link me-2"></i>Modifier les contenus liés
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($event->hasLinkedContent())
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Attention :</strong> Vous avez déjà des contenus liés à cette activité. 
                            Vous pouvez modifier votre sélection ci-dessous.
                        </div>
                        @endif
                        
                        <!-- Onglets -->
                        <ul class="nav nav-tabs mb-4" id="contentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $event->linked_workout ? 'active' : ($event->linked_exercices->count() > 0 ? '' : 'active') }}" 
                                        id="workout-tab" data-bs-toggle="tab" data-bs-target="#workout-panel" 
                                        type="button" role="tab">
                                    <i class="fas fa-dumbbell me-1"></i>Séance d'entraînement
                                    @if($event->linked_workout)
                                        <span class="badge bg-primary ms-1">1</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $event->linked_exercices->count() > 0 ? 'active' : '' }}" 
                                        id="exercice-tab" data-bs-toggle="tab" data-bs-target="#exercice-panel" 
                                        type="button" role="tab">
                                    <i class="fas fa-running me-1"></i>Exercices
                                    @if($event->linked_exercices->count() > 0)
                                        <span class="badge bg-success ms-1">{{ $event->linked_exercices->count() }}</span>
                                    @endif
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="contentTabsContent">
                            <!-- PANEL 1 : WORKOUT -->
                            <div class="tab-pane fade {{ $event->linked_workout ? 'show active' : ($event->linked_exercices->count() > 0 ? '' : 'show active') }}" 
                                 id="workout-panel" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Section</label>
                                        <select id="workout_section" class="form-select">
                                            <option value="">Choisir une section</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Catégorie</label>
                                        <select id="workout_category" class="form-select" disabled>
                                            <option value="">Choisir une catégorie</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Conteneur des séances (checkboxes) -->
                                <div id="workouts-container" class="mt-3">
                                    <p class="text-muted">Sélectionnez une section et une catégorie</p>
                                </div>
                                
                                <!-- Hidden input pour pré-sélectionner le workout -->
                                @if($event->linked_workout)
                                <input type="hidden" id="preselected_workout_id" value="{{ $event->linked_workout->id }}">
                                @endif
                            </div>

                            <!-- PANEL 2 : EXERCICES -->
                            <div class="tab-pane fade {{ $event->linked_exercices->count() > 0 ? 'show active' : '' }}" 
                                 id="exercice-panel" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Catégorie d'exercices</label>
                                        <select id="exercice_category" class="form-select">
                                            <option value="">Tous les exercices</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Conteneur des exercices (checkboxes) -->
                                <div id="exercices-container" class="mt-3">
                                    <p class="text-muted">Chargement...</p>
                                </div>
                                
                                <!-- Hidden input pour pré-sélectionner les exercices -->
                                @if($event->linked_exercices->count() > 0)
                                <input type="hidden" id="preselected_exercice_ids" value="{{ $event->linked_exercices->pluck('id')->implode(',') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ route('user.calendar.show', $event) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.workout-card, .exercice-card {
    transition: all 0.2s ease;
}

.workout-card:hover, .exercice-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.workout-card.border-primary {
    border-width: 2px !important;
}

.exercice-card.border-success {
    border-width: 2px !important;
}
</style>
@endsection

@push('scripts')
<script src="{{ asset('js/calendar-create.js') }}?v={{ time() }}"></script>
<script>
// Script spécifique pour la page edit : pré-sélectionner les contenus
document.addEventListener('DOMContentLoaded', function() {
    
    // Pré-sélectionner le workout si présent
    const preselectedWorkoutId = document.getElementById('preselected_workout_id');
    if (preselectedWorkoutId) {
        // Attendre que les workouts soient chargés puis cocher
        setTimeout(() => {
            const workoutRadio = document.querySelector(`input[name="workout_id"][value="${preselectedWorkoutId.value}"]`);
            if (workoutRadio) {
                workoutRadio.checked = true;
                // Déclencher l'événement pour mettre à jour l'apparence
                workoutRadio.dispatchEvent(new Event('change'));
            }
        }, 500);
    }
    
    // Pré-sélectionner les exercices si présents
    const preselectedExerciceIds = document.getElementById('preselected_exercice_ids');
    if (preselectedExerciceIds) {
        const ids = preselectedExerciceIds.value.split(',');
        
        // Fonction pour cocher les exercices
        function checkExercices() {
            let checkedCount = 0;
            ids.forEach(id => {
                const checkbox = document.querySelector(`input[name="exercice_ids[]"][value="${id}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                    checkedCount++;
                }
            });
            
            // Si tous les exercices ne sont pas encore chargés, réessayer
            if (checkedCount < ids.length && checkedCount > 0) {
                setTimeout(checkExercices, 500);
            } else if (checkedCount > 0) {
                // Mettre à jour l'apparence
                document.querySelectorAll('.exercice-checkbox').forEach(cb => {
                    if (cb.checked) {
                        cb.dispatchEvent(new Event('change'));
                    }
                });
            }
        }
        
        // Attendre que les exercices soient chargés
        setTimeout(checkExercices, 800);
    }
});
</script>
@endpush