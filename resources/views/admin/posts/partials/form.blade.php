@csrf

<div class="row g-4">
    <!-- Contenu principal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Contenu de l'article
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Titre -->
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Titre de l'article *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $post->name ?? '') }}"
                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                           placeholder="Saisissez le titre de votre article"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="form-label fw-semibold">URL personnalisée (Slug)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">{{ url('/articles') }}/</span>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug', $post->slug ?? '') }}"
                               class="form-control @error('slug') is-invalid @enderror"
                               placeholder="url-de-larticle">
                    </div>
                    <div class="form-text">Laisser vide pour génération automatique</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type -->
                <div class="mb-4">
                    <label for="type" class="form-label fw-semibold">Type d'article</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">Type standard</option>
                        <option value="news" {{ old('type', $post->type ?? '') === 'news' ? 'selected' : '' }}>Actualité</option>
                        <option value="tutorial" {{ old('type', $post->type ?? '') === 'tutorial' ? 'selected' : '' }}>Tutoriel</option>
                        <option value="review" {{ old('type', $post->type ?? '') === 'review' ? 'selected' : '' }}>Avis</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Introduction -->
                <div class="mb-4">
                    <label for="intro" class="form-label fw-semibold">Introduction</label>
                    <textarea name="intro" 
                              id="intro" 
                              rows="3"
                              class="form-control @error('intro') is-invalid @enderror"
                              placeholder="Résumé court de l'article (affiché dans les listes)">{{ old('intro', $post->intro ?? '') }}</textarea>
                    @error('intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="mb-4">
                    <label for="content" class="form-label fw-semibold">Contenu complet</label>
                    <textarea name="content" 
                              id="content" 
                              rows="15"
                              class="form-control @error('content') is-invalid @enderror"
                              placeholder="Rédigez le contenu complet de votre article ici...">{{ old('content', $post->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Section SEO -->
                <div class="border-top pt-4">
                    <h6 class="fw-semibold mb-3 text-primary">
                        <i class="fas fa-search me-2"></i>Optimisation SEO
                    </h6>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="meta_title" class="form-label">Titre SEO</label>
                            <input type="text" 
                                   name="meta_title" 
                                   id="meta_title" 
                                   value="{{ old('meta_title', $post->meta_title ?? '') }}"
                                   class="form-control @error('meta_title') is-invalid @enderror"
                                   placeholder="Titre optimisé pour les moteurs de recherche">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="meta_description" class="form-label">Description SEO</label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="3"
                                      class="form-control @error('meta_description') is-invalid @enderror"
                                      placeholder="Description courte pour les résultats de recherche">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="meta_keywords" class="form-label">Mots-clés</label>
                            <input type="text" 
                                   name="meta_keywords" 
                                   id="meta_keywords" 
                                   value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
                                   class="form-control @error('meta_keywords') is-invalid @enderror"
                                   placeholder="mot1, mot2, mot3">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="meta_og_image" class="form-label">Image Open Graph</label>
                            <input type="url" 
                                   name="meta_og_image" 
                                   id="meta_og_image" 
                                   value="{{ old('meta_og_image', $post->meta_og_image ?? '') }}"
                                   class="form-control @error('meta_og_image') is-invalid @enderror"
                                   placeholder="https://example.com/og-image.jpg">
                            @error('meta_og_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="meta_og_url" class="form-label">URL Open Graph</label>
                            <input type="url" 
                                   name="meta_og_url" 
                                   id="meta_og_url" 
                                   value="{{ old('meta_og_url', $post->meta_og_url ?? '') }}"
                                   class="form-control @error('meta_og_url') is-invalid @enderror"
                                   placeholder="https://example.com/article">
                            @error('meta_og_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                    <label for="status" class="form-label fw-semibold">Statut</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>
                            Brouillon
                        </option>
                        <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>
                            Publié
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="published_at" class="form-label fw-semibold">Date de publication</label>
                    <input type="datetime-local" 
                           name="published_at" 
                           id="published_at" 
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i') ?? '') }}"
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
                           value="{{ old('order', $post->order ?? 0) }}"
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
                           {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_featured" class="form-check-label">
                        <i class="fas fa-star text-warning me-1"></i>
                        Article mis en avant
                    </label>
                </div>
            </div>
        </div>

        <!-- Catégorie -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-info text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-folder me-2"></i>Catégorie
                </h6>
            </div>
            <div class="card-body p-4">
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" 
                                {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <div class="mt-3">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-plus me-1"></i>Nouvelle catégorie
                    </a>
                </div>
            </div>
        </div>

        <!-- Tags -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-warning text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-tags me-2"></i>Tags
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="max-height-200 overflow-auto">
                    @forelse($tags ?? [] as $tag)
                        <div class="form-check mb-2">
                            <input type="checkbox" 
                                   name="tags[]" 
                                   value="{{ $tag->id }}" 
                                   id="tag_{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                   class="form-check-input">
                            <label for="tag_{{ $tag->id }}" class="form-check-label">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Aucun tag disponible</p>
                    @endforelse
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-plus me-1"></i>Nouveau tag
                    </a>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-image me-2"></i>Image à la une
                </h6>
            </div>
            <div class="card-body p-4">
                <input type="url" 
                       name="image" 
                       value="{{ old('image', $post->image ?? '') }}"
                       class="form-control @error('image') is-invalid @enderror"
                       placeholder="https://example.com/image.jpg">
                <div class="form-text">URL de l'image d'illustration</div>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if(isset($post) && $post->image)
                    <div class="mt-3">
                        <img src="{{ $post->image }}" alt="Aperçu" class="img-fluid rounded" style="max-height: 150px;">
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ $submitLabel ?? 'Enregistrer' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>