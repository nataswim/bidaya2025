@extends('layouts.user')

@section('title', 'Planifier une activité')

@section('content')
<div class="container-lg py-5">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.calendar.index') }}">Calendrier</a></li>
                    <li class="breadcrumb-item active">Planifier une activité</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-2">📅 Planifier une activité</h1>
            <p class="text-muted">Organisez votre entraînement ou événement</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <form action="{{ route('user.calendar.store') }}" method="POST" id="eventForm">
                @csrf
                
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
                                       value="{{ old('discipline') }}" 
                                       placeholder="Ex: Course à pied, Natation...">
                                <small class="text-muted">Sport ou activité pratiquée</small>
                                @error('discipline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Titre de l'activité <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title') }}" 
                                       required maxlength="200" 
                                       placeholder="Ex: Séance jambes">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Type d'activité <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="entrainement" {{ old('type') == 'entrainement' ? 'selected' : '' }}>🏋️ Entraînement</option>
                                    <option value="rendez-vous" {{ old('type') == 'rendez-vous' ? 'selected' : '' }}>📅 Rendez-vous</option>
                                    <option value="stage" {{ old('type') == 'stage' ? 'selected' : '' }}>🍽️ Stage</option>
                                    <option value="competition" {{ old('type') == 'competition' ? 'selected' : '' }}>💊 Compétition</option>
                                    <option value="autres" {{ old('type') == 'autres' ? 'selected' : '' }}>📝 Autres</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Objectif</label>
                                <input type="text" name="objective" class="form-control @error('objective') is-invalid @enderror" 
                                       value="{{ old('objective') }}" 
                                       placeholder="Ex: Améliorer endurance">
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
                                       value="{{ old('event_date', now()->format('Y-m-d')) }}" required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Heure <span class="text-danger">*</span></label>
                                <input type="time" name="event_time" class="form-control @error('event_time') is-invalid @enderror" 
                                       value="{{ old('event_time', '14:00') }}" required>
                                @error('event_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lieu</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                       value="{{ old('location') }}" 
                                       placeholder="Ex: Salle de sport">
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
                                      rows="3" placeholder="Décrivez votre activité...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Remarques</label>
                            <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                                      rows="2" placeholder="Notes personnelles...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Matériel nécessaire</label>
                            <input type="text" name="material" class="form-control @error('material') is-invalid @enderror" 
                                   value="{{ old('material') }}" 
                                   placeholder="Ex: Chaussures trail, ceinture...">
                            @error('material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Durée prévue</label>
                                <input type="text" name="planned_duration" class="form-control @error('planned_duration') is-invalid @enderror" 
                                       value="{{ old('planned_duration') }}" 
                                       placeholder="Ex: 1h30">
                                @error('planned_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Distance prévue</label>
                                <input type="text" name="planned_distance" class="form-control @error('planned_distance') is-invalid @enderror" 
                                       value="{{ old('planned_distance') }}" 
                                       placeholder="Ex: 10 km">
                                @error('planned_distance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NOUVEAU : Lier à un contenu -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Lier à un contenu (optionnel)</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Onglets -->
                        <ul class="nav nav-tabs mb-4" id="contentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="workout-tab" data-bs-toggle="tab" data-bs-target="#workout-panel" 
                                        type="button" role="tab">
                                    <i class="fas fa-dumbbell me-1"></i>Séance d'entraînement
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="exercice-tab" data-bs-toggle="tab" data-bs-target="#exercice-panel" 
                                        type="button" role="tab">
                                    <i class="fas fa-running me-1"></i>Exercices
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="contentTabsContent">
                            <!-- PANEL 1 : WORKOUT -->
                            <div class="tab-pane fade show active" id="workout-panel" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Section</label>
                                        <select id="workout_section" class="form-select">
                                            <option value="">Choisir une section</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Catégorie</label>
                                        <select id="workout_category" class="form-select" disabled>
                                            <option value="">Choisir une catégorie</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Séance</label>
                                        <select name="workout_id" id="workout_id" class="form-select" disabled>
                                            <option value="">Choisir une séance</option>
                                        </select>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Sélectionnez une séance pour l'associer à cette activité
                                </small>
                            </div>

                            <!-- PANEL 2 : EXERCICES -->
                            <div class="tab-pane fade" id="exercice-panel" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Catégorie d'exercices</label>
                                        <select id="exercice_category" class="form-select">
                                            <option value="">Tous les exercices</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Exercices (sélection multiple)</label>
                                        <select name="exercice_ids[]" id="exercice_ids" class="form-select" multiple size="8">
                                            <option value="" disabled>Chargement...</option>
                                        </select>
                                        <small class="text-muted">
                                            Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs exercices
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Liste des exercices sélectionnés -->
                                <div id="selected-exercices-list" class="mt-3" style="display: none;">
                                    <label class="form-label fw-bold">Exercices sélectionnés :</label>
                                    <div id="selected-exercices-items" class="list-group">
                                        <!-- Les exercices sélectionnés s'afficheront ici -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ route('user.calendar.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i>Planifier l'activité
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/calendar-create.js') }}"></script>
@endpush