@extends('layouts.admin')

@section('title', 'Modifier une série')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white p-4">
            <h5 class="mb-0">
                <i class="fas fa-list-ol me-2"></i>Modifier la Série
            </h5>
        </div>
        <form method="POST" action="{{ route('admin.training.series.update', $series) }}">
            @csrf
            @method('PUT')
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <!-- Exercice -->
                        <div class="mb-4">
                            <label for="exercice_id" class="form-label fw-semibold">Exercice *</label>
                            <select name="exercice_id" id="exercice_id" class="form-select @error('exercice_id') is-invalid @enderror" required>
                                <option value="">Choisir un exercice</option>
                                @foreach($exercices as $exercice)
                                    <option value="{{ $exercice->id }}" {{ old('exercice_id', $series->exercice_id) == $exercice->id ? 'selected' : '' }}>
                                        {{ $exercice->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exercice_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nom de la série -->
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold">Nom de la série</label>
                            <input type="text" 
                                   name="nom" 
                                   id="nom" 
                                   value="{{ old('nom', $series->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Configuration -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="repetitions" class="form-label fw-semibold">Répétitions</label>
                                <input type="number" 
                                       name="repetitions" 
                                       id="repetitions" 
                                       value="{{ old('repetitions', $series->repetitions) }}"
                                       class="form-control @error('repetitions') is-invalid @enderror"
                                       min="1" max="1000">
                            </div>
                            <div class="col-md-3">
                                <label for="duree_secondes" class="form-label fw-semibold">Durée (sec)</label>
                                <input type="number" 
                                       name="duree_secondes" 
                                       id="duree_secondes" 
                                       value="{{ old('duree_secondes', $series->duree_secondes) }}"
                                       class="form-control @error('duree_secondes') is-invalid @enderror"
                                       min="1">
                            </div>
                            <div class="col-md-3">
                                <label for="distance_metres" class="form-label fw-semibold">Distance (m)</label>
                                <input type="number" 
                                       name="distance_metres" 
                                       id="distance_metres" 
                                       value="{{ old('distance_metres', $series->distance_metres) }}"
                                       class="form-control @error('distance_metres') is-invalid @enderror"
                                       step="0.01" min="0">
                            </div>
                            <div class="col-md-3">
                                <label for="poids_kg" class="form-label fw-semibold">Poids (kg)</label>
                                <input type="number" 
                                       name="poids_kg" 
                                       id="poids_kg" 
                                       value="{{ old('poids_kg', $series->poids_kg) }}"
                                       class="form-control @error('poids_kg') is-invalid @enderror"
                                       step="0.01" min="0">
                            </div>
                        </div>

                        <!-- Repos -->
                        <div class="mb-4">
                            <label for="repos_secondes" class="form-label fw-semibold">Temps de repos (secondes) *</label>
                            <input type="number" 
                                   name="repos_secondes" 
                                   id="repos_secondes" 
                                   value="{{ old('repos_secondes', $series->repos_secondes) }}"
                                   class="form-control @error('repos_secondes') is-invalid @enderror"
                                   min="0" max="3600" required>
                        </div>

                        <!-- Consignes -->
                        <div class="mb-4">
                            <label for="consignes" class="form-label fw-semibold">Consignes spécifiques</label>
                            <textarea name="consignes" 
                                      id="consignes" 
                                      rows="4"
                                      class="form-control @error('consignes') is-invalid @enderror">{{ old('consignes', $series->consignes) }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Paramètres</h6>
                                
                                <div class="mb-3">
                                    <label for="ordre" class="form-label">Ordre</label>
                                    <input type="number" 
                                           name="ordre" 
                                           id="ordre" 
                                           value="{{ old('ordre', $series->ordre) }}"
                                           class="form-control"
                                           min="0">
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active" 
                                           value="1"
                                           {{ old('is_active', $series->is_active) ? 'checked' : '' }}
                                           class="form-check-input">
                                    <label for="is_active" class="form-check-label">
                                        Série active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.training.series.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection