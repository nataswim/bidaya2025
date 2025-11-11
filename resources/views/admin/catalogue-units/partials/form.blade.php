@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Informations de l'Unité</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold">Titre de l'unité *</label>
                    <input type="text" name="title" id="title" 
                           value="{{ old('title', isset($unit) ? $unit->title : '') }}"
                           class="form-control form-control-lg @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="slug" class="form-label fw-semibold">Slug URL</label>
                    <input type="text" name="slug" id="slug" 
                           value="{{ old('slug', isset($unit) ? $unit->slug : '') }}"
                           class="form-control @error('slug') is-invalid @enderror">
                    <div class="form-text">Laisser vide pour génération automatique</div>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', isset($unit) ? $unit->description : '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Sélection du contenu -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-gradient-info text-white p-4">
                <h6 class="mb-0"><i class="fas fa-link me-2"></i>Contenu Lié (optionnel)</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="unitable_type" class="form-label fw-semibold">Type de contenu</label>
                    <select name="unitable_type" id="unitable_type" class="form-select @error('unitable_type') is-invalid @enderror">
                        <option value="">-- Aucun contenu lié --</option>
                        <option value="App\Models\Post" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\Post' ? 'selected' : '' }}>
                            Article (Post)
                        </option>
                        <option value="App\Models\Video" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\Video' ? 'selected' : '' }}>
                            Vidéo
                        </option>
                        <option value="App\Models\Downloadable" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\Downloadable' ? 'selected' : '' }}>
                            Fichier téléchargeable
                        </option>
                        <option value="App\Models\Fiche" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\Fiche' ? 'selected' : '' }}>
                            Fiche
                        </option>
                        <option value="App\Models\Exercice" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\Exercice' ? 'selected' : '' }}>
                            Exercice
                        </option>
                        <option value="App\Models\Workout" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\Workout' ? 'selected' : '' }}>
                            Entraînement (Workout)
                        </option>
                        <option value="App\Models\EbookFile" {{ old('unitable_type', isset($unit) ? $unit->unitable_type : '') == 'App\Models\EbookFile' ? 'selected' : '' }}>
                            E-book
                        </option>
                    </select>
                    @error('unitable_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3" id="content-selector-wrapper" style="display: none;">
                    <label for="unitable_id" class="form-label fw-semibold">Sélectionner le contenu</label>
                    <select name="unitable_id" id="unitable_id" class="form-select @error('unitable_id') is-invalid @enderror">
                        <option value="">-- Chargement... --</option>
                    </select>
                    @error('unitable_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Info :</strong> Sélectionnez un type de contenu pour lier cette unité à un contenu existant (article, vidéo, fiche, etc.)
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-success text-white p-4">
                <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Paramètres</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="catalogue_section_id" class="form-label fw-semibold">Section *</label>
                    <select name="catalogue_section_id" id="catalogue_section_id" 
                            class="form-select @error('catalogue_section_id') is-invalid @enderror">
                        <option value="">Sélectionner une section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" 
                                    data-section-id="{{ $section->id }}"
                                    {{ old('catalogue_section_id', isset($unit) && $unit->module ? $unit->module->catalogue_section_id : '') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('catalogue_section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="catalogue_module_id" class="form-label fw-semibold">Module parent *</label>
                    <select name="catalogue_module_id" id="catalogue_module_id" 
                            class="form-select @error('catalogue_module_id') is-invalid @enderror" required disabled>
                        <option value="">Sélectionner d'abord une section</option>
                        @if(isset($unit) && $unit->module)
                            <option value="{{ $unit->module->id }}" selected>{{ $unit->module->name }}</option>
                        @endif
                    </select>
                    @error('catalogue_module_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label fw-semibold">Ordre d'affichage</label>
                    <input type="number" name="order" id="order" 
                           value="{{ old('order', isset($unit) ? $unit->order : 0) }}"
                           class="form-control @error('order') is-invalid @enderror" min="0">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', isset($unit) ? $unit->is_active : true) ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_active" class="form-check-label">
                        <i class="fas fa-check-circle text-success me-1"></i>Unité active
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.catalogue-units.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <div class="d-flex gap-2">
                        <button type="submit" name="action" value="save" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ $submitLabel ?? 'Enregistrer' }}
                        </button>
                        <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Enregistrer et continuer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-génération du slug
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.autoGenerated) {
                slugInput.value = this.value.toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.dataset.autoGenerated = 'true';
            }
        });
        
        slugInput.addEventListener('input', function() {
            this.dataset.autoGenerated = '';
        });
    }

    // Chargement dynamique des modules par section
    const sectionSelect = document.getElementById('catalogue_section_id');
    const moduleSelect = document.getElementById('catalogue_module_id');
    
    if (sectionSelect && moduleSelect) {
        sectionSelect.addEventListener('change', function() {
            const sectionId = this.value;
            
            moduleSelect.innerHTML = '<option value="">Chargement...</option>';
            moduleSelect.disabled = true;
            
            if (!sectionId) {
                moduleSelect.innerHTML = '<option value="">Sélectionner d\'abord une section</option>';
                return;
            }
            
            fetch(`{{ route('admin.catalogue-units.api.modules-by-section') }}?section_id=${sectionId}`)
                .then(response => response.json())
                .then(data => {
                    moduleSelect.innerHTML = '<option value="">Sélectionner un module</option>';
                    
                    if (data.length > 0) {
                        data.forEach(module => {
                            const option = document.createElement('option');
                            option.value = module.id;
                            option.textContent = module.name;
                            moduleSelect.appendChild(option);
                        });
                        moduleSelect.disabled = false;
                    } else {
                        moduleSelect.innerHTML = '<option value="">Aucun module disponible</option>';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    moduleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
        
        // Déclencher le chargement initial si une section est déjà sélectionnée
        if (sectionSelect.value) {
            sectionSelect.dispatchEvent(new Event('change'));
        }
    }

    // Chargement dynamique du contenu par type
    const contentTypeSelect = document.getElementById('unitable_type');
    const contentIdSelect = document.getElementById('unitable_id');
    const contentSelectorWrapper = document.getElementById('content-selector-wrapper');
    
    if (contentTypeSelect && contentIdSelect && contentSelectorWrapper) {
        contentTypeSelect.addEventListener('change', function() {
            const contentType = this.value;
            
            if (!contentType) {
                contentSelectorWrapper.style.display = 'none';
                contentIdSelect.innerHTML = '<option value="">-- Choisir d\'abord un type --</option>';
                return;
            }
            
            contentSelectorWrapper.style.display = 'block';
            contentIdSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`{{ route('admin.catalogue-units.api.content-by-type') }}?content_type=${encodeURIComponent(contentType)}`)
                .then(response => response.json())
                .then(data => {
                    contentIdSelect.innerHTML = '<option value="">-- Sélectionner un contenu --</option>';
                    
                    if (data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.title;
                            contentIdSelect.appendChild(option);
                        });
                    } else {
                        contentIdSelect.innerHTML = '<option value="">Aucun contenu disponible</option>';
                    }
                    
                    // Restaurer la valeur si on est en édition
                    @if(isset($unit) && $unit->unitable_id)
                        contentIdSelect.value = '{{ $unit->unitable_id }}';
                    @endif
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    contentIdSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
        
        // Déclencher le chargement initial si un type est déjà sélectionné
        if (contentTypeSelect.value) {
            contentTypeSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endpush