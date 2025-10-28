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
            <form action="{{ route('user.calendar.update', $event) }}" method="POST">
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
@endsection