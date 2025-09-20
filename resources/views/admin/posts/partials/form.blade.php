@csrf

<div class="row g-4">
    <!-- Contenu principal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Contenu de l'article
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Titre -->
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Titre de l'article *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', isset($post) ? $post->name : '') }}"
                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                           placeholder="Saisissez un titre accrocheur..."
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="form-label fw-semibold">Slug URL</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">{{ url('/articles') }}/</span>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug', isset($post) ? $post->slug : '') }}"
                               class="form-control @error('slug') is-invalid @enderror"
                               placeholder="slug-automatique">
                    </div>
                    <div class="form-text">Laisser vide pour génération automatique à partir du titre</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Introduction -->
                <div class="mb-4">
                    <label for="intro" class="form-label fw-semibold">
                        Introduction / Résumé
                        <span class="badge bg-info-subtle text-info ms-2">Toujours visible</span>
                    </label>
                    <textarea name="intro" 
                              id="intro" 
                              rows="4"
                              class="form-control @error('intro') is-invalid @enderror"
                              placeholder="Rédigez une introduction engageante qui sera visible par tous les visiteurs...">{{ old('intro', isset($post) ? $post->intro : '') }}</textarea>
                    <div class="form-text">Cette introduction sera visible par tous les visiteurs, même pour les articles restreints</div>
                    @error('intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contenu principal -->
                <div class="mb-4">
                    <label for="content" class="form-label fw-semibold">
                        Contenu principal *
                        <span class="badge bg-warning-subtle text-warning ms-2">Selon visibilité</span>
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="15"
                              class="form-control @error('content') is-invalid @enderror"
                              placeholder="Rédigez le contenu principal de votre article..."
                              required>{{ old('content', isset($post) ? $post->content : '') }}</textarea>
                    <div class="form-text">Ce contenu sera visible selon les paramètres de visibilité choisis</div>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type d'article -->
                <div class="mb-4">
                    <label for="type" class="form-label fw-semibold">Type d'article</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="article" {{ old('type', isset($post) ? $post->type : 'article') === 'article' ? 'selected' : '' }}>
                            Article standard
                        </option>
                        <option value="tutorial" {{ old('type', isset($post) ? $post->type : '') === 'tutorial' ? 'selected' : '' }}>
                            Tutoriel
                        </option>
                        <option value="news" {{ old('type', isset($post) ? $post->type : '') === 'news' ? 'selected' : '' }}>
                            Actualité
                        </option>
                        <option value="review" {{ old('type', isset($post) ? $post->type : '') === 'review' ? 'selected' : '' }}>
                            Test/Avis
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SEO et métadonnées -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-gradient-info text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-search me-2"></i>SEO et Métadonnées
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="meta_title" class="form-label fw-semibold">Titre SEO</label>
                        <input type="text" 
                               name="meta_title" 
                               id="meta_title" 
                               value="{{ old('meta_title', isset($post) ? $post->meta_title : '') }}"
                               class="form-control @error('meta_title') is-invalid @enderror"
                               maxlength="60"
                               placeholder="Titre optimisé pour les moteurs de recherche">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="meta_keywords" class="form-label fw-semibold">Mots-clés</label>
                        <input type="text" 
                               name="meta_keywords" 
                               id="meta_keywords" 
                               value="{{ old('meta_keywords', isset($post) ? $post->meta_keywords : '') }}"
                               class="form-control @error('meta_keywords') is-invalid @enderror"
                               placeholder="mot1, mot2, mot3">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="meta_description" class="form-label fw-semibold">Description SEO</label>
                        <textarea name="meta_description" 
                                  id="meta_description" 
                                  rows="3"
                                  class="form-control @error('meta_description') is-invalid @enderror"
                                  maxlength="160"
                                  placeholder="Description qui apparaîtra dans les résultats de recherche...">{{ old('meta_description', isset($post) ? $post->meta_description : '') }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                    <label for="status" class="form-label fw-semibold">Statut</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status', isset($post) ? $post->status : 'draft') === 'draft' ? 'selected' : '' }}>
                            <i class="fas fa-edit"></i> Brouillon
                        </option>
                        <option value="published" {{ old('status', isset($post) ? $post->status : '') === 'published' ? 'selected' : '' }}>
                            <i class="fas fa-check"></i> Publié
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- VISIBILITÉ -->
                <div class="mb-3">
                    <label for="visibility" class="form-label fw-semibold">
                        <i class="fas fa-eye me-1 text-info"></i>Visibilité du contenu
                    </label>
                    <select name="visibility" id="visibility" class="form-select @error('visibility') is-invalid @enderror">
                        <option value="public" {{ old('visibility', isset($post) ? $post->visibility : 'public') === 'public' ? 'selected' : '' }}>
                            <i class="fas fa-globe"></i> Public - Accessible à tous les visiteurs
                        </option>
                        <option value="authenticated" {{ old('visibility', isset($post) ? $post->visibility : '') === 'authenticated' ? 'selected' : '' }}>
                            <i class="fas fa-lock"></i> Membres uniquement - Connexion requise
                        </option>
                    </select>
                    
                    <!-- Aide contextuelle -->
                    <div class="form-text">
                        <div id="visibility-help" class="mt-2 p-3 rounded" style="background-color: #f8f9fa;">
                            <div id="public-help" style="display: none;">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-globe text-success me-2 mt-1"></i>
                                    <div>
                                        <strong class="text-success">Accès public</strong>
                                        <div class="small text-muted mt-1">
                                            • Visible par tous les visiteurs<br>
                                            • Indexé par les moteurs de recherche<br>
                                            • Partageable sur les réseaux sociaux
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="authenticated-help" style="display: none;">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-lock text-warning me-2 mt-1"></i>
                                    <div>
                                        <strong class="text-warning">Accès restreint</strong>
                                        <div class="small text-muted mt-1">
                                            • Titre et introduction visibles par tous<br>
                                            • Contenu complet réservé aux membres<br>
                                            • Incite à l'inscription sur votre site
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('visibility')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Aperçu de l'impact -->
                <div class="mb-3">
                    <div class="border rounded p-3 bg-light">
                        <h6 class="small fw-semibold mb-2">
                            <i class="fas fa-info-circle text-primary me-1"></i>Impact de la visibilité
                        </h6>
                        <div id="visibility-impact">
                            <div id="public-impact" style="display: none;">
                                <div class="row g-2 text-center">
                                    <div class="col-4">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                            <i class="fas fa-users text-success"></i>
                                            <div class="small fw-bold text-success">Tous</div>
                                            <div class="tiny text-muted">Visiteurs</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                            <i class="fas fa-search text-success"></i>
                                            <div class="small fw-bold text-success">SEO</div>
                                            <div class="tiny text-muted">Indexé</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-success bg-opacity-10 rounded p-2">
                                            <i class="fas fa-share text-success"></i>
                                            <div class="small fw-bold text-success">Social</div>
                                            <div class="tiny text-muted">Partageable</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="authenticated-impact" style="display: none;">
                                <div class="row g-2 text-center">
                                    <div class="col-4">
                                        <div class="bg-warning bg-opacity-10 rounded p-2">
                                            <i class="fas fa-user-check text-warning"></i>
                                            <div class="small fw-bold text-warning">Membres</div>
                                            <div class="tiny text-muted">Connectés</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-info bg-opacity-10 rounded p-2">
                                            <i class="fas fa-eye text-info"></i>
                                            <div class="small fw-bold text-info">Teaser</div>
                                            <div class="tiny text-muted">Intro visible</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-primary bg-opacity-10 rounded p-2">
                                            <i class="fas fa-user-plus text-primary"></i>
                                            <div class="small fw-bold text-primary">Conversion</div>
                                            <div class="tiny text-muted">Inscription</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="published_at" class="form-label fw-semibold">Date de publication</label>
                    <input type="datetime-local" 
                           name="published_at" 
                           id="published_at" 
                           value="{{ old('published_at', isset($post) ? $post->published_at?->format('Y-m-d\TH:i') : '') }}"
                           class="form-control @error('published_at') is-invalid @enderror">
                    <div class="form-text">Laisser vide pour publication immédiate</div>
                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label fw-semibold">Ordre d'affichage</label>
                    <input type="number" 
                           name="order" 
                           id="order" 
                           value="{{ old('order', isset($post) ? $post->order : 0) }}"
                           class="form-control @error('order') is-invalid @enderror"
                           placeholder="0">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" 
                           name="is_featured" 
                           id="is_featured" 
                           value="1"
                           {{ old('is_featured', isset($post) ? $post->is_featured : false) ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_featured" class="form-check-label">
                        <i class="fas fa-star text-warning me-1"></i>
                        Article mis en avant
                    </label>
                </div>
            </div>
        </div>

        <!-- Catégorie et Tags -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-warning text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-folder me-2"></i>Catégorisation
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold">Catégorie *</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach(\App\Models\Category::where('status', 'active')->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('category_id', isset($post) ? $post->category_id : '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label fw-semibold">Tags</label>
                    <select name="tags[]" id="tags" class="form-select" multiple>
                        @foreach(\App\Models\Tag::where('status', 'active')->orderBy('name')->get() as $tag)
                            <option value="{{ $tag->id }}" 
                                    {{ isset($post) && $post->tags->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Maintenez Ctrl pour sélectionner plusieurs tags</div>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-info text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-image me-2"></i>Image à la une
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">URL de l'image</label>
                    <input type="url" 
                           name="image" 
                           id="image" 
                           value="{{ old('image', isset($post) ? $post->image : '') }}"
                           class="form-control @error('image') is-invalid @enderror"
                           placeholder="https://exemple.com/image.jpg">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if(isset($post) && $post->image)
                    <div class="mt-3">
                        <small class="text-muted d-block mb-2">Aperçu actuel :</small>
                        <img src="{{ $post->image }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 150px; object-fit: cover;"
                             alt="Image actuelle">
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
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
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

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}

.tiny {
    font-size: 0.7rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-génération du slug
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });
    
    slugInput.addEventListener('input', function() {
        this.dataset.autoGenerated = '';
    });

    // Gestion de l'aide à la visibilité
    const visibilitySelect = document.getElementById('visibility');
    const publicHelp = document.getElementById('public-help');
    const authenticatedHelp = document.getElementById('authenticated-help');
    const publicImpact = document.getElementById('public-impact');
    const authenticatedImpact = document.getElementById('authenticated-impact');

    function updateVisibilityHelp() {
        const value = visibilitySelect.value;
        
        // Masquer tous les éléments d'aide
        publicHelp.style.display = 'none';
        authenticatedHelp.style.display = 'none';
        publicImpact.style.display = 'none';
        authenticatedImpact.style.display = 'none';
        
        // Afficher l'aide correspondante
        if (value === 'public') {
            publicHelp.style.display = 'block';
            publicImpact.style.display = 'block';
        } else if (value === 'authenticated') {
            authenticatedHelp.style.display = 'block';
            authenticatedImpact.style.display = 'block';
        }
    }

    // Initialiser l'affichage
    updateVisibilityHelp();
    
    // Écouter les changements
    visibilitySelect.addEventListener('change', updateVisibilityHelp);
});
</script>
@endpush