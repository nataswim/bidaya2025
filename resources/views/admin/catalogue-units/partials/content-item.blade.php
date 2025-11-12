<div class="content-item border rounded p-3 mb-3" data-index="{{ $index }}">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <h6 class="mb-0">
            <span class="badge bg-secondary me-2 content-order">{{ $index + 1 }}</span>
            @if($isNew)
                Nouveau contenu
            @else
                {{ $content->display_title ?? 'Contenu' }}
            @endif
        </h6>
        <button type="button" class="btn btn-sm btn-outline-danger remove-content-btn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    @if(!$isNew && isset($content->id))
        <input type="hidden" name="contents[{{ $index }}][id]" value="{{ $content->id }}">
    @endif
    
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Type de contenu *</label>
            <select name="contents[{{ $index }}][contentable_type]" 
                    class="form-select content-type-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="App\Models\Post" {{ ($content->contentable_type ?? '') == 'App\Models\Post' ? 'selected' : '' }}>
                    Article (Post)
                </option>
                <option value="App\Models\Video" {{ ($content->contentable_type ?? '') == 'App\Models\Video' ? 'selected' : '' }}>
                    Vidéo
                </option>
                <option value="App\Models\Downloadable" {{ ($content->contentable_type ?? '') == 'App\Models\Downloadable' ? 'selected' : '' }}>
                    Fichier téléchargeable
                </option>
                <option value="App\Models\Fiche" {{ ($content->contentable_type ?? '') == 'App\Models\Fiche' ? 'selected' : '' }}>
                    Fiche
                </option>
                <option value="App\Models\Exercice" {{ ($content->contentable_type ?? '') == 'App\Models\Exercice' ? 'selected' : '' }}>
                    Exercice
                </option>
                <option value="App\Models\Workout" {{ ($content->contentable_type ?? '') == 'App\Models\Workout' ? 'selected' : '' }}>
                    Entraînement
                </option>
                <option value="App\Models\EbookFile" {{ ($content->contentable_type ?? '') == 'App\Models\EbookFile' ? 'selected' : '' }}>
                    E-book
                </option>
            </select>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Contenu *</label>
            <select name="contents[{{ $index }}][contentable_id]" 
                    class="form-select content-id-select" 
                    required 
                    {{ empty($content->contentable_type) ? 'disabled' : '' }}>
                @if(!empty($content->contentable_id))
                    <option value="{{ $content->contentable_id }}" selected>
                        {{ $content->contentable->title ?? $content->contentable->name ?? 'ID: ' . $content->contentable_id }}
                    </option>
                @else
                    <option value="">-- Choisir un type d'abord --</option>
                @endif
            </select>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Titre personnalisé</label>
            <input type="text" 
                   name="contents[{{ $index }}][custom_title]" 
                   value="{{ $content->custom_title ?? '' }}"
                   class="form-control" 
                   placeholder="Optionnel">
        </div>
        
        <div class="col-md-3">
            <label class="form-label">Durée (min)</label>
            <input type="number" 
                   name="contents[{{ $index }}][duration_minutes]" 
                   value="{{ $content->duration_minutes ?? '' }}"
                   class="form-control" 
                   min="0">
        </div>
        
        <div class="col-md-3">
            <label class="form-label">Ordre</label>
            <input type="number" 
                   name="contents[{{ $index }}][order]" 
                   value="{{ $content->order ?? ($index + 1) }}"
                   class="form-control content-order-input" 
                   min="1" 
                   required>
        </div>
        
        <div class="col-12">
            <label class="form-label">Description personnalisée</label>
            <textarea name="contents[{{ $index }}][custom_description]" 
                      rows="2" 
                      class="form-control"
                      placeholder="Optionnel">{{ $content->custom_description ?? '' }}</textarea>
        </div>
        
        <div class="col-12">
            <div class="form-check">
                <input type="checkbox" 
                       name="contents[{{ $index }}][is_required]" 
                       value="1" 
                       {{ ($content->is_required ?? true) ? 'checked' : '' }}
                       class="form-check-input">
                <label class="form-check-label">Contenu obligatoire</label>
            </div>
        </div>
    </div>
</div>