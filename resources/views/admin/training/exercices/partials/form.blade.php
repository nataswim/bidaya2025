@csrf

<div class="row g-4">
    <!-- Contenu principal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h5 class="mb-0">
                    <i class="fas fa-running me-2"></i>Informations de l'exercice
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Titre -->
                <div class="mb-4">
                    <label for="titre" class="form-label fw-semibold">Titre de l'exercice *</label>
                    <input type="text" 
                           name="titre" 
                           id="titre" 
                           value="{{ old('titre', isset($exercice) ? $exercice->titre : '') }}"
                           class="form-control form-control-lg @error('titre') is-invalid @enderror"
                           placeholder="Ex: Pompes, Squat, Course à pied..."
                           required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Description avec Quill -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description *</label>
                    
                    <!-- Conteneur pour l'éditeur Quill -->
                    <div id="description-editor" style="height: 150px; border: 1px solid #ced4da; border-radius: 0.375rem; background: white;"></div>
                    
                    <!-- Textarea cachée pour Laravel -->
                               <textarea name="description" 
                              id="description" 
                              class="d-none @error('description') is-invalid @enderror">{{ old('description', isset($exercice) ? $exercice->description : '') }}</textarea>
                              <div class="form-text">Décrivez l'exercice en détail : position de départ, mouvement, technique...</div>
                    
                      @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    
                        @enderror
                </div>

                <!-- Consignes de sécurité avec Quill -->
                <div class="mb-4">
                    <label for="consignes_securite" class="form-label fw-semibold">Consignes de sécurité</label>
                    
                    <!-- Conteneur pour l'éditeur Quill -->
                    <div id="consignes-editor" style="height: 150px; border: 1px solid #ced4da; border-radius: 0.375rem; background: white;"></div>
                    
                    <!-- Textarea cachée pour Laravel -->
                    <textarea name="consignes_securite" 
                              id="consignes_securite" 
                              class="d-none @error('consignes_securite') is-invalid @enderror">{{ old('consignes_securite', isset($exercice) ? $exercice->consignes_securite : '') }}</textarea>
                              
                    <div class="form-text">Points d'attention, contre-indications, conseils de sécurité...</div>
                    @error('consignes_securite')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Muscles ciblés -->
                <div class="mb-4">
                    <label for="muscles_cibles" class="form-label fw-semibold">Muscles ciblés</label>
                    <div class="row g-2" id="muscles-container">
                        @php
                            $musclesCibles = old('muscles_cibles', isset($exercice) ? $exercice->muscles_cibles : []);
                            $musclesCibles = is_array($musclesCibles) ? $musclesCibles : [];
                        @endphp
                        @forelse($musclesCibles as $index => $muscle)
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" 
                                           name="muscles_cibles[]" 
                                           value="{{ $muscle }}"
                                           class="form-control" 
                                           placeholder="Ex: Pectoraux">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeMusle(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" 
                                           name="muscles_cibles[]" 
                                           class="form-control" 
                                           placeholder="Ex: Pectoraux">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeMusle(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addMuscle()">
                        <i class="fas fa-plus me-1"></i>Ajouter un muscle
                    </button>
                </div>

                <!-- URL Vidéo -->
                <div class="mb-4">
                    <label for="video_url" class="form-label fw-semibold">URL de la vidéo explicative</label>
                    <input type="url" 
                           name="video_url" 
                           id="video_url" 
                           value="{{ old('video_url', isset($exercice) ? $exercice->video_url : '') }}"
                           class="form-control @error('video_url') is-invalid @enderror"
                           placeholder="https://youtube.com/watch?v=...">
                    @error('video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Paramètres -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-success text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="niveau" class="form-label fw-semibold">Niveau *</label>
                    <select name="niveau" id="niveau" class="form-select @error('niveau') is-invalid @enderror" required>
                        <option value="">Choisir un niveau</option>
                        <option value="debutant" {{ old('niveau', isset($exercice) ? $exercice->niveau : '') === 'debutant' ? 'selected' : '' }}>
                            Débutant
                        </option>
                        <option value="intermediaire" {{ old('niveau', isset($exercice) ? $exercice->niveau : '') === 'intermediaire' ? 'selected' : '' }}>
                            Intermédiaire
                        </option>
                        <option value="avance" {{ old('niveau', isset($exercice) ? $exercice->niveau : '') === 'avance' ? 'selected' : '' }}>
                            Avancé
                        </option>
                        <option value="special" {{ old('niveau', isset($exercice) ? $exercice->niveau : '') === 'special' ? 'selected' : '' }}>
                            Spécial
                        </option>
                    </select>
                    @error('niveau')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type_exercice" class="form-label fw-semibold">Type d'exercice *</label>
                    <select name="type_exercice" id="type_exercice" class="form-select @error('type_exercice') is-invalid @enderror" required>
                        <option value="">Choisir un type</option>
                        <option value="cardio" {{ old('type_exercice', isset($exercice) ? $exercice->type_exercice : '') === 'cardio' ? 'selected' : '' }}>
                            Cardio
                        </option>
                        <option value="force" {{ old('type_exercice', isset($exercice) ? $exercice->type_exercice : '') === 'force' ? 'selected' : '' }}>
                            Force
                        </option>
                        <option value="flexibilite" {{ old('type_exercice', isset($exercice) ? $exercice->type_exercice : '') === 'flexibilite' ? 'selected' : '' }}>
                            Flexibilité
                        </option>
                        <option value="equilibre" {{ old('type_exercice', isset($exercice) ? $exercice->type_exercice : '') === 'equilibre' ? 'selected' : '' }}>
                            Équilibre
                        </option>
                    </select>
                    @error('type_exercice')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ordre" class="form-label fw-semibold">Ordre d'affichage</label>
                    <input type="number" 
                           name="ordre" 
                           id="ordre" 
                           value="{{ old('ordre', isset($exercice) ? $exercice->ordre : 0) }}"
                           class="form-control @error('ordre') is-invalid @enderror"
                           min="0"
                           placeholder="0">
                    @error('ordre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', isset($exercice) ? $exercice->is_active : true) ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_active" class="form-check-label">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Exercice actif
                    </label>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-info text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-image me-2"></i>Image de l'exercice
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">URL de l'image</label>
                    <div class="input-group">
                        <input type="text" 
                               name="image" 
                               id="image" 
                               value="{{ old('image', isset($exercice) ? $exercice->image : '') }}"
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

                @if(isset($exercice) && $exercice->image)
                    <div class="mt-3" id="currentImagePreview">
                        <small class="text-muted d-block mb-2">Aperçu actuel :</small>
                        <img src="{{ $exercice->image }}" 
                             id="imagePreview"
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 150px; object-fit: cover;"
                             alt="Image actuelle">
                    </div>
                @else
                    <div class="mt-3 d-none" id="currentImagePreview">
                        <small class="text-muted d-block mb-2">Aperçu :</small>
                        <img id="imagePreview"
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 150px; object-fit: cover;"
                             alt="Aperçu">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.training.exercices.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ $submitLabel ?? 'Enregistrer' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@once
<script src="{{ asset('js/media-selector.js') }}"></script>
<script src="{{ asset('js/quill-advanced.js') }}"></script>
@endonce

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // 1. INITIALISATION DES ÉDITEURS QUILL
    // ========================================
    let quillDescription = null;
    let quillConsignes = null;
    
    if (document.getElementById('description-editor')) {
        quillDescription = initQuillEditor('#description-editor', 'description');
    }
    
    if (document.getElementById('consignes-editor')) {
        quillConsignes = initQuillEditor('#consignes-editor', 'consignes_securite');
    }

    // ========================================
    // 2. SYNCHRONISATION À LA SOUMISSION
    // ========================================
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            // Synchroniser description
            const descriptionTextarea = document.getElementById('description');
            if (descriptionTextarea && quillDescription) {
                descriptionTextarea.value = quillDescription.root.innerHTML;
            }
            
            // Synchroniser consignes de sécurité
            const consignesTextarea = document.getElementById('consignes_securite');
            if (consignesTextarea && quillConsignes) {
                consignesTextarea.value = quillConsignes.root.innerHTML;
            }
        });
    }

    // ========================================
    // 3. APERÇU DE L'IMAGE
    // ========================================
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('currentImagePreview');
    
    if (imageInput && imagePreview && imagePreviewContainer) {
        imageInput.addEventListener('input', function() {
            const imageUrl = this.value.trim();
            if (imageUrl) {
                imagePreview.src = imageUrl;
                imagePreviewContainer.classList.remove('d-none');
            } else {
                imagePreviewContainer.classList.add('d-none');
            }
        });
    }
});

// ========================================
// 4. GESTION DES MUSCLES CIBLÉS
// ========================================
function addMuscle() {
    const container = document.getElementById('muscles-container');
    const div = document.createElement('div');
    div.className = 'col-md-4';
    div.innerHTML = `
        <div class="input-group">
            <input type="text" 
                   name="muscles_cibles[]" 
                   class="form-control" 
                   placeholder="Ex: Pectoraux">
            <button type="button" class="btn btn-outline-danger" onclick="removeMusle(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeMusle(button) {
    const container = document.getElementById('muscles-container');
    if (container.children.length > 1) {
        button.closest('.col-md-4').remove();
    }
}
</script>
@endpush