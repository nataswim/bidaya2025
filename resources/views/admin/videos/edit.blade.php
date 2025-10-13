@extends('layouts.admin')

@section('title', 'Modifier une Vidéo')
@section('page-title', 'Modifier la Vidéo')
@section('page-description', 'Modification de : ' . $video->title)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.videos.update', $video) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div class="row g-4">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white p-4">
                        <h5 class="mb-0">
                            <i class="fas fa-video me-2"></i>Informations de la vidéo
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Titre -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Titre de la vidéo *</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $video->title) }}"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold">Slug URL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">{{ url('/videos') }}/</span>
                                <input type="text" 
                                       name="slug" 
                                       id="slug" 
                                       value="{{ old('slug', $video->slug) }}"
                                       class="form-control @error('slug') is-invalid @enderror">
                            </div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description avec Quill Editor -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <div id="quill-description" style="height: 300px;">
                                {!! old('description', $video->description) !!}
                            </div>
                            <input type="hidden" name="description" id="description" value="{{ old('description', $video->description) }}">
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type de source -->
                        <div class="mb-4">
                            <label for="type" class="form-label fw-semibold">Type de source *</label>
                            <select name="type" 
                                    id="type" 
                                    class="form-select @error('type') is-invalid @enderror"
                                    required>
                                <option value="upload" {{ old('type', $video->type) === 'upload' ? 'selected' : '' }}>Upload fichier</option>
                                <option value="youtube" {{ old('type', $video->type) === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="vimeo" {{ old('type', $video->type) === 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                                <option value="dailymotion" {{ old('type', $video->type) === 'dailymotion' ? 'selected' : '' }}>Dailymotion</option>
                                <option value="url" {{ old('type', $video->type) === 'url' ? 'selected' : '' }}>URL directe</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload fichier -->
                        <div class="mb-4" id="uploadSection" style="display: none;">
                            @if($video->type === 'upload' && $video->file_path)
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Fichier actuel: <strong>{{ basename($video->file_path) }}</strong> ({{ $video->file_size }})
                                </div>
                            @endif
                            <label for="file" class="form-label fw-semibold">Remplacer le fichier vidéo</label>
                            <input type="file" 
                                   name="file" 
                                   id="file" 
                                   class="form-control @error('file') is-invalid @enderror"
                                   accept="video/mp4,video/webm,video/quicktime,video/x-msvideo">
                            <div class="form-text">Laisser vide pour conserver le fichier actuel</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- URL externe -->
                        <div class="mb-4" id="urlSection" style="display: none;">
                            <label for="external_url" class="form-label fw-semibold">URL de la vidéo</label>
                            <div class="input-group">
                                <input type="url" 
                                       name="external_url" 
                                       id="external_url" 
                                       value="{{ old('external_url', $video->external_url) }}"
                                       class="form-control @error('external_url') is-invalid @enderror">
                                <button type="button" 
                                        class="btn btn-outline-primary" 
                                        id="fetchMetadataBtn">
                                    <i class="fas fa-download me-2"></i>Récupérer infos
                                </button>
                            </div>
                            @error('external_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Métadonnées -->
                        <div class="border-top pt-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-info-circle me-2 text-info"></i>Métadonnées
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="duration" class="form-label">Durée (secondes)</label>
                                    <input type="number" 
                                           name="duration" 
                                           id="duration" 
                                           value="{{ old('duration', $video->duration) }}"
                                           class="form-control"
                                           min="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="width" class="form-label">Largeur (px)</label>
                                    <input type="number" 
                                           name="width" 
                                           id="width" 
                                           value="{{ old('width', $video->width) }}"
                                           class="form-control"
                                           min="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="height" class="form-label">Hauteur (px)</label>
                                    <input type="number" 
                                           name="height" 
                                           id="height" 
                                           value="{{ old('height', $video->height) }}"
                                           class="form-control"
                                           min="0">
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="border-top pt-4 mt-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-search me-2 text-primary"></i>SEO et Métadonnées
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="meta_title" class="form-label">Titre SEO</label>
                                    <input type="text" 
                                           name="meta_title" 
                                           id="meta_title" 
                                           value="{{ old('meta_title', $video->meta_title) }}"
                                           class="form-control"
                                           maxlength="60">
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_keywords" class="form-label">Mots-clés</label>
                                    <input type="text" 
                                           name="meta_keywords" 
                                           id="meta_keywords" 
                                           value="{{ old('meta_keywords', $video->meta_keywords) }}"
                                           class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="meta_description" class="form-label">Description SEO</label>
                                    <textarea name="meta_description" 
                                              id="meta_description" 
                                              rows="3"
                                              class="form-control"
                                              maxlength="160">{{ old('meta_description', $video->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publication -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient-success text-white p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar me-2"></i>Publication
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="is_published" class="form-label fw-semibold">Statut</label>
                            <select name="is_published" id="is_published" class="form-select">
                                <option value="0" {{ old('is_published', $video->is_published) == 0 ? 'selected' : '' }}>
                                    Brouillon
                                </option>
                                <option value="1" {{ old('is_published', $video->is_published) == 1 ? 'selected' : '' }}>
                                    Publié
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="visibility" class="form-label fw-semibold">
                                <i class="fas fa-eye me-1 text-info"></i>Visibilité
                            </label>
                            <select name="visibility" id="visibility" class="form-select">
                                <option value="public" {{ old('visibility', $video->visibility) === 'public' ? 'selected' : '' }}>
                                    Public - Accessible à tous
                                </option>
                                <option value="authenticated" {{ old('visibility', $video->visibility) === 'authenticated' ? 'selected' : '' }}>
                                    Membres uniquement
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label fw-semibold">Date de publication</label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   id="published_at" 
                                   value="{{ old('published_at', $video->published_at?->format('Y-m-d\TH:i')) }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label fw-semibold">Ordre d'affichage</label>
                            <input type="number" 
                                   name="sort_order" 
                                   id="sort_order" 
                                   value="{{ old('sort_order', $video->sort_order) }}"
                                   class="form-control">
                        </div>

                        <div class="form-check">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}
                                   class="form-check-input">
                            <label for="is_featured" class="form-check-label">
                                <i class="fas fa-star text-warning me-1"></i>
                                Vidéo mise en vedette
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Catégories -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient-warning text-white p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-folder me-2"></i>Catégories
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if($categories->count() > 0)
                            @foreach($categories as $category)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $category->id }}" 
                                           id="category_{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', $video->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Aucune catégorie disponible</p>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient-info text-white p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-image me-2"></i>Miniature
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="input-group">
                            <input type="text" 
                                   name="thumbnail" 
                                   id="thumbnail" 
                                   value="{{ old('thumbnail', $video->thumbnail) }}"
                                   class="form-control">
                            <button type="button" 
                                    class="btn btn-outline-primary"
                                    onclick="openMediaSelector('thumbnail', 'thumbnailPreview')">
                                <i class="fas fa-images"></i>
                            </button>
                        </div>
                        
                        @if($video->thumbnail)
                            <div class="mt-3" id="thumbnailPreviewContainer">
                                <img src="{{ $video->thumbnail }}" 
                                     id="thumbnailPreview"
                                     alt="Aperçu" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px;">
                            </div>
                        @else
                            <div class="mt-3 d-none" id="thumbnailPreviewContainer">
                                <img id="thumbnailPreview"
                                     alt="Aperçu" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px;">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-secondary text-white p-3">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Statistiques
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Vues:</span>
                            <strong>{{ number_format($video->views_count) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Créé le:</span>
                            <strong>{{ $video->created_at->format('d/m/Y') }}</strong>
                        </div>
                        @if($video->updated_at != $video->created_at)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Modifié le:</span>
                                <strong>{{ $video->updated_at->format('d/m/Y') }}</strong>
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
                            <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                            </a>
                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="save" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
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
    </form>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary { background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%); }
.bg-gradient-secondary { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); }
</style>

<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/media-selector.js') }}"></script>

<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== QUILL EDITOR POUR DESCRIPTION ==========
    const quillDescription = new Quill('#quill-description', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        },
        placeholder: 'Description détaillée de la vidéo...'
    });

    // Synchroniser Quill avec le champ caché
    const descriptionInput = document.getElementById('description');
    quillDescription.on('text-change', function() {
        descriptionInput.value = quillDescription.root.innerHTML;
    });

    // Initialiser la valeur existante
    if (descriptionInput.value) {
        quillDescription.root.innerHTML = descriptionInput.value;
    }

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });
    
    slugInput.addEventListener('input', function() { this.dataset.autoGenerated = ''; });

    const typeSelect = document.getElementById('type');
    const uploadSection = document.getElementById('uploadSection');
    const urlSection = document.getElementById('urlSection');
    
    typeSelect.addEventListener('change', function() {
        uploadSection.style.display = this.value === 'upload' ? 'block' : 'none';
        urlSection.style.display = ['youtube', 'vimeo', 'dailymotion', 'url'].includes(this.value) ? 'block' : 'none';
    });
    
    typeSelect.dispatchEvent(new Event('change'));

    const fetchMetadataBtn = document.getElementById('fetchMetadataBtn');
    const externalUrlInput = document.getElementById('external_url');
    
    fetchMetadataBtn.addEventListener('click', async function() {
        const url = externalUrlInput.value;
        const type = typeSelect.value;
        
        if (!url || !['youtube', 'vimeo', 'dailymotion'].includes(type)) {
            alert('Veuillez sélectionner un type et saisir une URL valide');
            return;
        }
        
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Récupération...';
        
        try {
            const response = await fetch('{{ route("admin.videos.fetch-metadata") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ url, type })
            });
            
            const data = await response.json();
            
            if (data.success && data.data) {
                if (data.data.thumbnail) {
                    document.getElementById('thumbnail').value = data.data.thumbnail;
                    document.getElementById('thumbnailPreview').src = data.data.thumbnail;
                    document.getElementById('thumbnailPreviewContainer').classList.remove('d-none');
                }
                if (data.data.duration) document.getElementById('duration').value = data.data.duration;
                if (data.data.width) document.getElementById('width').value = data.data.width;
                if (data.data.height) document.getElementById('height').value = data.data.height;
                
                alert('Métadonnées récupérées avec succès !');
            } else {
                alert('Impossible de récupérer les métadonnées');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        } finally {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-download me-2"></i>Récupérer infos';
        }
    });

    const thumbnailInput = document.getElementById('thumbnail');
    const thumbnailPreview = document.getElementById('thumbnailPreview');
    const thumbnailPreviewContainer = document.getElementById('thumbnailPreviewContainer');
    
    if (thumbnailInput && thumbnailPreview) {
        thumbnailInput.addEventListener('input', function() {
            if (this.value.trim()) {
                thumbnailPreview.src = this.value;
                thumbnailPreviewContainer.classList.remove('d-none');
            } else {
                thumbnailPreviewContainer.classList.add('d-none');
            }
        });
    }
});
</script>
@endpush