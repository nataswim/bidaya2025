@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Informations du Module</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Nom du module *</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', isset($module) ? $module->name : '') }}"
                           class="form-control form-control-lg @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="slug" class="form-label fw-semibold">Slug URL</label>
                    <input type="text" name="slug" id="slug" 
                           value="{{ old('slug', isset($module) ? $module->slug : '') }}"
                           class="form-control @error('slug') is-invalid @enderror">
                    <div class="form-text">Laisser vide pour génération automatique</div>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="short_description" class="form-label fw-semibold">Description courte</label>
                    <textarea name="short_description" id="short_description" rows="3"
                              class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', isset($module) ? $module->short_description : '') }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="long_description" class="form-label fw-semibold">Description complète</label>
                    <textarea name="long_description" id="long_description" rows="6"
                              class="form-control @error('long_description') is-invalid @enderror">{{ old('long_description', isset($module) ? $module->long_description : '') }}</textarea>
                    @error('long_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <label for="catalogue_section_id" class="form-label fw-semibold">Section parente *</label>
                    <select name="catalogue_section_id" id="catalogue_section_id" 
                            class="form-select @error('catalogue_section_id') is-invalid @enderror" required>
                        <option value="">Sélectionner une section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" 
                                    {{ old('catalogue_section_id', isset($module) ? $module->catalogue_section_id : '') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('catalogue_section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label fw-semibold">Ordre</label>
                    <input type="number" name="order" id="order" 
                           value="{{ old('order', isset($module) ? $module->order : 0) }}"
                           class="form-control @error('order') is-invalid @enderror" min="0">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', isset($module) ? $module->is_active : true) ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_active" class="form-check-label">
                        <i class="fas fa-check-circle text-success me-1"></i>Module actif
                    </label>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-info text-white p-4">
                <h6 class="mb-0"><i class="fas fa-image me-2"></i>Image</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">URL de l'image</label>
                    <div class="input-group">
                        <input type="text" name="image" id="image" 
                               value="{{ old('image', isset($module) ? $module->image : '') }}"
                               class="form-control @error('image') is-invalid @enderror">
                        <button type="button" class="btn btn-outline-primary"
                                onclick="openMediaSelector('image', 'imagePreview')">
                            <i class="fas fa-images"></i>
                        </button>
                    </div>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if(isset($module) && $module->image)
                    <div class="mt-3" id="currentImagePreview">
                        <img src="{{ $module->image }}" id="imagePreview" class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                @else
                    <div class="mt-3 d-none" id="currentImagePreview">
                        <img id="imagePreview" class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.catalogue-modules.index') }}" class="btn btn-outline-secondary">
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
<script src="{{ asset('js/media-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
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
});
</script>
@endpush