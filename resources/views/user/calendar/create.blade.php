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
            <form action="{{ route('user.calendar.store') }}" method="POST">
                @csrf
                
                <!-- Pré-remplissage si lié à un contenu -->
                @if(request('linkable_type') && request('linkable_id'))
                    <input type="hidden" name="linkable_type" value="{{ request('linkable_type') }}">
                    <input type="hidden" name="linkable_id" value="{{ request('linkable_id') }}">
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-link me-2"></i>
                        Cette activité sera liée à : <strong>{{ request('linkable_title') }}</strong>
                    </div>
                @endif
                
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
                                       value="{{ old('discipline', request('discipline')) }}" 
                                       placeholder="Ex: Course à pied, Natation, Musculation...">
                                <small class="text-muted">Sport ou activité pratiquée</small>
                                @error('discipline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Titre de l'activité <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', request('title')) }}" 
                                       required maxlength="200" 
                                       placeholder="Ex: Séance jambes, Course matinale...">
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
                                    <option value="entrainement" {{ old('type', request('type')) == 'entrainement' ? 'selected' : '' }}>
                                        🏋️ Entraînement
                                    </option>
                                    <option value="rendez-vous" {{ old('type') == 'rendez-vous' ? 'selected' : '' }}>
                                        📅 Rendez-vous
                                    </option>
                                    <option value="stage" {{ old('type') == 'stage' ? 'selected' : '' }}>
                                        🍽️ Stage
                                    </option>
                                    <option value="competition" {{ old('type') == 'competition' ? 'selected' : '' }}>
                                        💊 Compétition
                                    </option>
                                    <option value="autres" {{ old('type') == 'autres' ? 'selected' : '' }}>
                                        📝 Autres
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Objectif</label>
                                <input type="text" name="objective" class="form-control @error('objective') is-invalid @enderror" 
                                       value="{{ old('objective') }}" 
                                       placeholder="Ex: Améliorer endurance, Gagner en force...">
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
                                       placeholder="Ex: Salle de sport, Parc...">
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
                                   placeholder="Ex: Chaussures trail, ceinture, élastiques...">
                            <small class="text-muted">Équipement à prévoir pour cette activité</small>
                            @error('material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Durée prévue</label>
                                <input type="text" name="planned_duration" class="form-control @error('planned_duration') is-invalid @enderror" 
                                       value="{{ old('planned_duration') }}" 
                                       placeholder="Ex: 1h30, 45min...">
                                @error('planned_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Distance prévue</label>
                                <input type="text" name="planned_distance" class="form-control @error('planned_distance') is-invalid @enderror" 
                                       value="{{ old('planned_distance') }}" 
                                       placeholder="Ex: 10 km, 5000m...">
                                @error('planned_distance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lier à un contenu (si pas déjà pré-rempli) -->
                @if(!request('linkable_type'))
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Lier à un contenu (optionnel)</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-3">Associez cette activité à un entraînement ou un plan existant</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Type de contenu</label>
                                <select name="linkable_type" class="form-select" id="linkable_type">
                                    <option value="">Aucun</option>
                                    <option value="workout">Séance d'entraînement</option>
                                    <option value="plan">Plan d'entraînement</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contenu</label>
                                <select name="linkable_id" class="form-select" id="linkable_id" disabled>
                                    <option value="">Sélectionner d'abord un type</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
<script>
// Gestion du chargement dynamique des contenus liés
document.getElementById('linkable_type')?.addEventListener('change', function() {
    const type = this.value;
    const select = document.getElementById('linkable_id');
    
    if (!type) {
        select.disabled = true;
        select.innerHTML = '<option value="">Sélectionner d\'abord un type</option>';
        return;
    }
    
    select.disabled = false;
    select.innerHTML = '<option value="">Chargement...</option>';
    
    // Charger les contenus selon le type
    fetch(`/user/calendar/get-linkable/${type}`)
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Sélectionner</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.title;
                select.appendChild(option);
            });
        })
        .catch(() => {
            select.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});
</script>
@endpush