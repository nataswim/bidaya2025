<div class="row g-3">
    <!-- Catégories -->
    <div class="col-md-6">
        <label class="form-label fw-semibold mb-3">
            <i class="fas fa-folder me-2 text-primary"></i>Catégories
        </label>
        
        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
            @php
            $categories = \App\Models\ExerciceCategory::active()->ordered()->get();
            @endphp
            
            @forelse($categories as $category)
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="categories[]" 
                           value="{{ $category->id }}" 
                           id="cat-{{ $category->id }}">
                    <label class="form-check-label w-100" for="cat-{{ $category->id }}">
                        <div class="d-flex align-items-center justify-content-between">
                            <span>{{ $category->name }}</span>
                            @if($category->description)
                                <small class="text-muted" title="{{ $category->description }}">
                                    <i class="fas fa-info-circle"></i>
                                </small>
                            @endif
                        </div>
                    </label>
                </div>
            @empty
                <p class="text-muted mb-0">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Aucune catégorie disponible
                </p>
            @endforelse
        </div>
        
        <div class="mt-2">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllCategories()">
                <i class="fas fa-check-square me-1"></i>Tout sélectionner
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllCategories()">
                <i class="fas fa-square me-1"></i>Tout désélectionner
            </button>
        </div>
    </div>

    <!-- Sous-catégories -->
    <div class="col-md-6">
        <label class="form-label fw-semibold mb-3">
            <i class="fas fa-layer-group me-2 text-info"></i>Sous-catégories
        </label>
        
        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
            @php
            $sousCategories = \App\Models\ExerciceSousCategory::active()->ordered()->get();
            @endphp
            
            @forelse($sousCategories as $sousCategory)
                <div class="form-check mb-2" data-parent-category="{{ $sousCategory->exercice_category_id }}">
                    <input class="form-check-input sous-category-checkbox" 
                           type="checkbox" 
                           name="sous_categories[]" 
                           value="{{ $sousCategory->id }}" 
                           id="sous-cat-{{ $sousCategory->id }}">
                    <label class="form-check-label w-100" for="sous-cat-{{ $sousCategory->id }}">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="flex-grow-1">
                                <span>{{ $sousCategory->name }}</span>
                                @if($sousCategory->category)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-arrow-right me-1"></i>{{ $sousCategory->category->name }}
                                    </small>
                                @endif
                            </div>
                            @if($sousCategory->description)
                                <small class="text-muted ms-2" title="{{ $sousCategory->description }}">
                                    <i class="fas fa-info-circle"></i>
                                </small>
                            @endif
                        </div>
                    </label>
                </div>
            @empty
                <p class="text-muted mb-0">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Aucune sous-catégorie disponible
                </p>
            @endforelse
        </div>
        
        <div class="mt-2">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllSousCategories()">
                <i class="fas fa-check-square me-1"></i>Tout sélectionner
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllSousCategories()">
                <i class="fas fa-square me-1"></i>Tout désélectionner
            </button>
        </div>
    </div>
</div>

<script>
// Fonction pour sélectionner toutes les catégories
function selectAllCategories() {
    document.querySelectorAll('input[name="categories[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

// Fonction pour désélectionner toutes les catégories
function deselectAllCategories() {
    document.querySelectorAll('input[name="categories[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Fonction pour sélectionner toutes les sous-catégories
function selectAllSousCategories() {
    document.querySelectorAll('input[name="sous_categories[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

// Fonction pour désélectionner toutes les sous-catégories
function deselectAllSousCategories() {
    document.querySelectorAll('input[name="sous_categories[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>