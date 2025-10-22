<div class="row g-3">
    <div class="col-md-6">
        <label for="bulk-categories" class="form-label fw-semibold">
            Catégories
        </label>
        <select name="categories[]" 
                class="form-select" 
                multiple 
                size="8">
            @php
            $categories = \App\Models\ExerciceCategory::active()->ordered()->get();
            @endphp
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="form-text">
            <i class="fas fa-info-circle me-1"></i>
            Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs catégories
        </div>
    </div>

    <div class="col-md-6">
        <label for="bulk-sous-categories" class="form-label fw-semibold">
            Sous-catégories
        </label>
        <select name="sous_categories[]" 
                class="form-select" 
                multiple 
                size="8">
            @php
            $sousCategories = \App\Models\ExerciceSousCategory::active()->ordered()->get();
            @endphp
            @foreach($sousCategories as $sousCategory)
                <option value="{{ $sousCategory->id }}"
                        data-category="{{ $sousCategory->exercice_category_id }}">
                    {{ $sousCategory->category ? $sousCategory->category->name . ' → ' : '' }}{{ $sousCategory->name }}
                </option>
            @endforeach
        </select>
        <div class="form-text">
            <i class="fas fa-info-circle me-1"></i>
            Sélectionnez les sous-catégories à assigner
        </div>
    </div>
</div>