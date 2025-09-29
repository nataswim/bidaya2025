@csrf

<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white p-4">
        <h5 class="mb-0">
            <i class="fas fa-sync-alt me-2"></i>{{ isset($cycle) ? 'Modifier le Cycle' : 'Nouveau Cycle' }}
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-4">
                    <label for="titre" class="form-label fw-semibold">Titre du cycle *</label>
                    <input type="text" 
                           name="titre" 
                           id="titre" 
                           value="{{ old('titre', isset($cycle) ? $cycle->titre : '') }}"
                           class="form-control @error('titre') is-invalid @enderror"
                           required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    
                    <div id="description-editor" style="height: 150px; border: 1px solid #ced4da; border-radius: 0.375rem; background: white;"></div>
                    
                    <textarea name="description" 
                              id="description" 
                              class="d-none @error('description') is-invalid @enderror">{{ old('description', isset($cycle) ? $cycle->description : '') }}</textarea>
                              
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="conseils" class="form-label fw-semibold">Conseils généraux</label>
                    
                    <div id="conseils-editor" style="height: 120px; border: 1px solid #ced4da; border-radius: 0.375rem; background: white;"></div>
                    
                    <textarea name="conseils" 
                              id="conseils" 
                              class="d-none @error('conseils') is-invalid @enderror">{{ old('conseils', isset($cycle) ? $cycle->conseils : '') }}</textarea>
                              
                    <div class="form-text">Conseils pour bien suivre ce cycle...</div>
                    @error('conseils')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">Séances du cycle</h6>
                    <div id="seances-container">
                        @if(isset($cycle))
                            @foreach($cycle->seances as $index => $seanceItem)
                                <div class="card border mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Séance {{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSeance(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="row g-3">
                                            {{-- Champs cachés pour le pivot --}}
                                            <input type="hidden" name="seances[{{ $index }}][id]" value="{{ $seanceItem->id }}">
                                            
                                            <div class="col-md-6">
                                                <label class="form-label">Séance</label>
                                                <select name="seances[{{ $index }}][seance_id]" class="form-select" required>
                                                    {{-- Options pour le champ existant --}}
                                                    @if(isset($seances))
                                                        @foreach($seances as $seance)
                                                            <option value="{{ $seance->id }}" {{ $seance->id == $seanceItem->id ? 'selected' : '' }}>
                                                                {{ $seance->titre }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Ordre</label>
                                                <input type="number" name="seances[{{ $index }}][ordre]" class="form-control" 
                                                       value="{{ old('seances.'.$index.'.ordre', $seanceItem->pivot->ordre) }}" min="1" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Semaine</label>
                                                <input type="number" name="seances[{{ $index }}][semaine_cycle]" class="form-control" 
                                                       value="{{ old('seances.'.$index.'.semaine_cycle', $seanceItem->pivot->semaine_cycle) }}" min="1" max="52" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Jour</label>
                                                <select name="seances[{{ $index }}][jour_semaine]" class="form-select">
                                                    <option value="">Optionnel</option>
                                                    <option value="1" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 1 ? 'selected' : '' }}>Lundi</option>
                                                    <option value="2" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 2 ? 'selected' : '' }}>Mardi</option>
                                                    <option value="3" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 3 ? 'selected' : '' }}>Mercredi</option>
                                                    <option value="4" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 4 ? 'selected' : '' }}>Jeudi</option>
                                                    <option value="5" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 5 ? 'selected' : '' }}>Vendredi</option>
                                                    <option value="6" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 6 ? 'selected' : '' }}>Samedi</option>
                                                    <option value="7" {{ old('seances.'.$index.'.jour_semaine', $seanceItem->pivot->jour_semaine) == 7 ? 'selected' : '' }}>Dimanche</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Notes</label>
                                                <input type="text" name="seances[{{ $index }}][notes]" class="form-control" 
                                                       value="{{ old('seances.'.$index.'.notes', $seanceItem->pivot->notes) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addSeance()">
                        <i class="fas fa-plus me-2"></i>Ajouter une séance
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Paramètres</h6>
                        
                        <div class="mb-3">
                            <label for="objectif" class="form-label fw-semibold">Objectif *</label>
                            <select name="objectif" id="objectif" class="form-select @error('objectif') is-invalid @enderror" required>
                                <option value="">Choisir un objectif</option>
                                <option value="force" {{ old('objectif', isset($cycle) ? $cycle->objectif : '') === 'force' ? 'selected' : '' }}>Force</option>
                                <option value="endurance" {{ old('objectif', isset($cycle) ? $cycle->objectif : '') === 'endurance' ? 'selected' : '' }}>Endurance</option>
                                <option value="perte_poids" {{ old('objectif', isset($cycle) ? $cycle->objectif : '') === 'perte_poids' ? 'selected' : '' }}>Perte de poids</option>
                                <option value="prise_masse" {{ old('objectif', isset($cycle) ? $cycle->objectif : '') === 'prise_masse' ? 'selected' : '' }}>Prise de masse</option>
                                <option value="recuperation" {{ old('objectif', isset($cycle) ? $cycle->objectif : '') === 'recuperation' ? 'selected' : '' }}>Récupération</option>
                                <option value="mixte" {{ old('objectif', isset($cycle) ? $cycle->objectif : '') === 'mixte' ? 'selected' : '' }}>Mixte</option>
                            </select>
                            @error('objectif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duree_semaines" class="form-label fw-semibold">Durée (semaines)</label>
                            <input type="number" 
                                   name="duree_semaines" 
                                   id="duree_semaines" 
                                   value="{{ old('duree_semaines', isset($cycle) ? $cycle->duree_semaines : '') }}"
                                   class="form-control @error('duree_semaines') is-invalid @enderror"
                                   min="1" max="52">
                            @error('duree_semaines')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ordre" class="form-label">Ordre</label>
                            <input type="number" 
                                   name="ordre" 
                                   id="ordre" 
                                   value="{{ old('ordre', isset($cycle) ? $cycle->ordre : 0) }}"
                                   class="form-control"
                                   min="0">
                        </div>

                        <div class="form-check">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   {{ old('is_active', isset($cycle) ? $cycle->is_active : true) ? 'checked' : '' }}
                                   class="form-check-input">
                            <label for="is_active" class="form-check-label">
                                Cycle actif
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Image</h6>
                        <div class="mb-3">
                            <label for="image" class="form-label">URL de l'image</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="image" 
                                       id="image" 
                                       value="{{ old('image', isset($cycle) ? $cycle->image : '') }}"
                                       class="form-control @error('image') is-invalid @enderror"
                                       placeholder="https://exemple.com/image.jpg ou /storage/media/image.jpg">
                                <button type="button" 
                                        class="btn btn-outline-primary"
                                        onclick="openMediaSelector('image', 'imagePreview')">
                                    <i class="fas fa-images"></i>
                                </button>
                            </div>
                            <div class="form-text">Sélectionnez depuis la médiathèque ou saisissez une URL</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Prévisualisation de l'image --}}
                        <div class="mt-3 {{ isset($cycle) && $cycle->image ? '' : 'd-none' }}" id="currentImagePreview">
                            <small class="text-muted d-block mb-2">Aperçu :</small>
                            <img id="imagePreview"
                                 src="{{ isset($cycle) ? $cycle->image : '' }}"
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 100px; object-fit: cover;"
                                 alt="Aperçu">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer d-flex justify-content-between">
        <a href="{{ route('admin.training.cycles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>{{ $submitLabel ?? 'Enregistrer' }}
        </button>
    </div>
</div>

@push('scripts')
{{-- Correction de l'erreur "Identifier has already been declared" avec @once --}}
@once
<script src="{{ asset('js/media-selector.js') }}"></script>
<script src="{{ asset('js/quill-advanced.js') }}"></script>
@endonce

@php
    // PRÉ-RENDU des options de séances pour le JS, car Blade ne s'exécute pas dans le template string JS.
    $seanceOptionsHtml = '<option value="">Choisir une séance</option>';
    if (isset($seances)) {
        foreach ($seances as $seance) {
            $seanceOptionsHtml .= '<option value="' . $seance->id . '">' . htmlspecialchars($seance->titre) . '</option>';
        }
    }
@endphp

<script>
    // Injecte les options de séances dans une variable JS pour être utilisée dans addSeance()
    const seanceOptionsHtml = `{!! $seanceOptionsHtml !!}`;

    let seanceIndex = {{ isset($cycle) ? $cycle->seances->count() : 0 }};

    function addSeance() {
        const container = document.getElementById('seances-container');
        const div = document.createElement('div');
        div.className = 'card border mb-3';
        div.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Séance ${seanceIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSeance(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Séance</label>
                        <select name="seances[${seanceIndex}][seance_id]" class="form-select" required>
                            ${seanceOptionsHtml} {{-- Utilisation de la variable JS --}}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ordre</label>
                        <input type="number" name="seances[${seanceIndex}][ordre]" class="form-control" value="${seanceIndex + 1}" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Semaine</label>
                        <input type="number" name="seances[${seanceIndex}][semaine_cycle]" class="form-control" value="1" min="1" max="52" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jour</label>
                        <select name="seances[${seanceIndex}][jour_semaine]" class="form-select">
                            <option value="">Optionnel</option>
                            <option value="1">Lundi</option>
                            <option value="2">Mardi</option>
                            <option value="3">Mercredi</option>
                            <option value="4">Jeudi</option>
                            <option value="5">Vendredi</option>
                            <option value="6">Samedi</option>
                            <option value="7">Dimanche</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Notes</label>
                        <input type="text" name="seances[${seanceIndex}][notes]" class="form-control" placeholder="Notes spécifiques...">
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
        seanceIndex++;
    }

    function removeSeance(button) {
        button.closest('.card').remove();
    }

    document.addEventListener('DOMContentLoaded', function() {
        let quillDescription = null;
        let quillConseils = null;
        
        // 1. Initialisation des éditeurs Quill
        if (document.getElementById('description-editor')) {
            quillDescription = initQuillEditor('#description-editor', 'description');
        }
        if (document.getElementById('conseils-editor')) {
            // Note : initQuillEditor doit être défini dans quill-advanced.js
            quillConseils = initQuillEditor('#conseils-editor', 'conseils'); 
        }

        // 2. Synchronisation des textareas cachées A la soumission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const descriptionTextarea = document.getElementById('description');
                if (descriptionTextarea && quillDescription) {
                    descriptionTextarea.value = quillDescription.root.innerHTML;
                }
                const conseilsTextarea = document.getElementById('conseils');
                if (conseilsTextarea && quillConseils) {
                    conseilsTextarea.value = quillConseils.root.innerHTML;
                }
            });
        }
        
        // 3. Aperçu de l'image (si l'URL change)
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('input', function() {
                const imageUrl = this.value.trim();
                const preview = document.getElementById('imagePreview');
                const container = document.getElementById('currentImagePreview');
                
                if (imageUrl && preview && container) {
                    preview.src = imageUrl;
                    container.classList.remove('d-none');
                } else if (container) {
                    container.classList.add('d-none');
                }
            });
        }
    });
    
    // Ajout d'une première séance pour un nouveau cycle (si le conteneur est vide)
    @if(!isset($cycle) || $cycle->seances->count() == 0)
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('seances-container').children.length === 0) {
                addSeance();
            }
        });
    @endif
</script>
@endpush