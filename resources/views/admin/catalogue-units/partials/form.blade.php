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

        <!-- Section des contenus multiples -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-gradient-info text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-list me-2"></i>Contenus de l'unité</h6>
                    <button type="button" class="btn btn-light btn-sm" id="add-content-btn">
                        <i class="fas fa-plus me-1"></i>Ajouter un contenu
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                <div id="contents-container">
                    @php
                        $existingContents = isset($unit) ? $unit->contents()->ordered()->get() : collect();
                        $oldContents = old('contents', []);
                    @endphp
                    
                    @if(count($oldContents) > 0)
                        {{-- Afficher les anciens contenus en cas d'erreur de validation --}}
                        @foreach($oldContents as $index => $oldContent)
                            @include('admin.catalogue-units.partials.content-item', [
                                'index' => $index,
                                'content' => (object)$oldContent,
                                'isNew' => true
                            ])
                        @endforeach
                    @elseif($existingContents->count() > 0)
                        {{-- Afficher les contenus existants en mode édition --}}
                        @foreach($existingContents as $index => $content)
                            @include('admin.catalogue-units.partials.content-item', [
                                'index' => $index,
                                'content' => $content,
                                'isNew' => false
                            ])
                        @endforeach
                    @else
                        {{-- Message si aucun contenu --}}
                        <div id="no-content-message" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun contenu ajouté. Cliquez sur "Ajouter un contenu" pour commencer.
                        </div>
                    @endif
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
                            class="form-select @error('catalogue_module_id') is-invalid @enderror" required>
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

{{-- Template pour un nouvel élément de contenu --}}
<template id="content-item-template">
    <div class="content-item border rounded p-3 mb-3" data-index="">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h6 class="mb-0">
                <span class="badge bg-secondary me-2 content-order">1</span>
                Nouveau contenu
            </h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-content-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Type de contenu *</label>
                <select name="contents[][contentable_type]" class="form-select content-type-select" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="App\Models\Post">Article (Post)</option>
                    <option value="App\Models\Video">Vidéo</option>
                    <option value="App\Models\Downloadable">Fichier téléchargeable</option>
                    <option value="App\Models\Fiche">Fiche</option>
                    <option value="App\Models\Exercice">Exercice</option>
                    <option value="App\Models\Workout">Entraînement</option>
                    <option value="App\Models\EbookFile">E-book</option>
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Contenu *</label>
                <select name="contents[][contentable_id]" class="form-select content-id-select" required disabled>
                    <option value="">-- Choisir un type d'abord --</option>
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Titre personnalisé</label>
                <input type="text" name="contents[][custom_title]" class="form-control" 
                       placeholder="Optionnel">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Durée (min)</label>
                <input type="number" name="contents[][duration_minutes]" class="form-control" min="0">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Ordre</label>
                <input type="number" name="contents[][order]" class="form-control content-order-input" 
                       value="1" min="1" required>
            </div>
            
            <div class="col-12">
                <label class="form-label">Description personnalisée</label>
                <textarea name="contents[][custom_description]" rows="2" class="form-control"
                          placeholder="Optionnel"></textarea>
            </div>
            
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="contents[][is_required]" value="1" checked
                           class="form-check-input">
                    <label class="form-check-label">Contenu obligatoire</label>
                </div>
            </div>
        </div>
    </div>
</template>

@push('styles')
<style>
.content-item {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}
.content-item:hover {
    background-color: #e9ecef;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0891b2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let contentIndex = {{ $existingContents->count() ?? 0 }};
    const container = document.getElementById('contents-container');
    const template = document.getElementById('content-item-template');
    const addBtn = document.getElementById('add-content-btn');
    const noContentMsg = document.getElementById('no-content-message');
    
    // Fonction pour ajouter un nouveau contenu
    function addContentItem() {
        if (noContentMsg) {
            noContentMsg.remove();
        }
        
        const clone = template.content.cloneNode(true);
        const item = clone.querySelector('.content-item');
        item.dataset.index = contentIndex;
        
        // Mettre à jour les noms des champs
        item.querySelectorAll('select, input, textarea').forEach(field => {
            if (field.name) {
                field.name = field.name.replace('[]', `[${contentIndex}]`);
            }
        });
        
        // Mettre à jour l'ordre
        const orderInput = item.querySelector('.content-order-input');
        const orderBadge = item.querySelector('.content-order');
        const currentOrder = container.querySelectorAll('.content-item').length + 1;
        orderInput.value = currentOrder;
        orderBadge.textContent = currentOrder;
        
        container.appendChild(item);
        contentIndex++;
        
        // Initialiser les événements pour ce nouvel item
        initializeContentItem(item);
    }
    
    // Fonction pour initialiser les événements d'un item
    function initializeContentItem(item) {
        // Bouton supprimer
        item.querySelector('.remove-content-btn')?.addEventListener('click', function() {
            if (confirm('Supprimer ce contenu ?')) {
                item.remove();
                updateOrders();
                
                if (container.querySelectorAll('.content-item').length === 0) {
                    container.innerHTML = `
                        <div id="no-content-message" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun contenu ajouté. Cliquez sur "Ajouter un contenu" pour commencer.
                        </div>
                    `;
                }
            }
        });
        
        // Select de type de contenu
        const typeSelect = item.querySelector('.content-type-select');
        const idSelect = item.querySelector('.content-id-select');
        
        if (typeSelect && idSelect) {
            typeSelect.addEventListener('change', function() {
                const contentType = this.value;
                
                if (!contentType) {
                    idSelect.disabled = true;
                    idSelect.innerHTML = '<option value="">-- Choisir un type d\'abord --</option>';
                    return;
                }
                
                idSelect.disabled = false;
                idSelect.innerHTML = '<option value="">Chargement...</option>';
                
                fetch(`{{ route('admin.catalogue-units.api.content-by-type') }}?content_type=${encodeURIComponent(contentType)}`)
                    .then(response => response.json())
                    .then(data => {
                        idSelect.innerHTML = '<option value="">-- Sélectionner --</option>';
                        data.forEach(content => {
                            const option = document.createElement('option');
                            option.value = content.id;
                            option.textContent = content.title || content.name;
                            idSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        idSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    });
            });
        }
    }
    
    // Fonction pour mettre à jour les ordres
    function updateOrders() {
        container.querySelectorAll('.content-item').forEach((item, index) => {
            const orderBadge = item.querySelector('.content-order');
            const orderInput = item.querySelector('.content-order-input');
            if (orderBadge) orderBadge.textContent = index + 1;
            if (orderInput) orderInput.value = index + 1;
        });
    }
    
    // Événement pour ajouter un contenu
    addBtn?.addEventListener('click', addContentItem);
    
    // Initialiser les items existants
    container.querySelectorAll('.content-item').forEach(initializeContentItem);
    
    // Auto-génération du slug (code existant)
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
    
    // Chargement dynamique des modules par section (code existant)
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
            const currentModuleId = '{{ isset($unit) ? $unit->catalogue_module_id : "" }}';
            if (currentModuleId) {
                // Si on est en édition, attendre que les modules soient chargés puis sélectionner le bon
                sectionSelect.addEventListener('change', function setCurrentModule() {
                    setTimeout(() => {
                        moduleSelect.value = currentModuleId;
                    }, 500);
                    sectionSelect.removeEventListener('change', setCurrentModule);
                });
            }
            sectionSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endpush