@extends('layouts.admin')

@section('title', 'Créer un Article')
@section('page-title', 'Nouvel Article')
@section('page-description', 'Création d\'un nouvel article')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.posts.store') }}">
        @csrf
        
        <div class="row g-4">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0">Contenu de l'article</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Titre de l'article *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="Saisissez le titre de votre article"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold">URL personnalisée (Slug)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">{{ url('/articles') }}/</span>
                                <input type="text" 
                                       name="slug" 
                                       id="slug" 
                                       value="{{ old('slug') }}"
                                       class="form-control"
                                       placeholder="url-de-larticle">
                            </div>
                            <div class="form-text">Laisser vide pour génération automatique</div>
                        </div>

                        <div class="mb-4">
                            <label for="intro" class="form-label fw-semibold">Introduction</label>
                            <textarea name="intro" 
                                      id="intro" 
                                      rows="3"
                                      class="form-control"
                                      placeholder="Résumé court de l'article (affiché dans les listes)">{{ old('intro') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Contenu complet</label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="15"
                                      class="form-control"
                                      placeholder="Rédigez le contenu complet de votre article ici...">{{ old('content') }}</textarea>
                        </div>

                        <!-- Section SEO -->
                        <div class="border-top pt-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-search me-2 text-primary"></i>Optimisation SEO
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="meta_title" class="form-label">Titre SEO</label>
                                    <input type="text" 
                                           name="meta_title" 
                                           id="meta_title" 
                                           value="{{ old('meta_title') }}"
                                           class="form-control"
                                           placeholder="Titre optimisé pour les moteurs de recherche">
                                </div>
                                
                                <div class="col-12">
                                    <label for="meta_description" class="form-label">Description SEO</label>
                                    <textarea name="meta_description" 
                                              id="meta_description" 
                                              rows="3"
                                              class="form-control"
                                              placeholder="Description courte pour les résultats de recherche">{{ old('meta_description') }}</textarea>
                                </div>
                                
                                <div class="col-12">
                                    <label for="meta_keywords" class="form-label">Mots-clés</label>
                                    <input type="text" 
                                           name="meta_keywords" 
                                           id="meta_keywords" 
                                           value="{{ old('meta_keywords') }}"
                                           class="form-control"
                                           placeholder="mot1, mot2, mot3">
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
                    <div class="card-header bg-white border-bottom p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar me-2 text-success"></i>Publication
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Statut</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                    📝 Brouillon
                                </option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                    ✅ Publié
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
                                   value="{{ old('published_at') }}"
                                   class="form-control">
                            <div class="form-text">Laisser vide pour publication immédiate</div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured" 
                                   value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}
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
                    <div class="card-header bg-white border-bottom p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-folder me-2 text-info"></i>Catégorie
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Choisir une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <div class="card-header bg-white border-bottom p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-tags me-2 text-warning"></i>Tags
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="max-height-200 overflow-auto">
                            @foreach($tags as $tag)
                                <div class="form-check mb-2">
                                    <input type="checkbox" 
                                           name="tags[]" 
                                           value="{{ $tag->id }}" 
                                           id="tag_{{ $tag->id }}"
                                           {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                           class="form-check-input">
                                    <label for="tag_{{ $tag->id }}" class="form-check-label">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($tags->isEmpty())
                            <p class="text-muted mb-0">Aucun tag disponible</p>
                        @endif
                        
                        <div class="mt-3">
                            <a href="{{ route('admin.tags.create') }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-plus me-1"></i>Nouveau tag
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom p-4">
                        <h6 class="mb-0">
                            <i class="fas fa-image me-2 text-primary"></i>Image à la une
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <input type="url" 
                               name="image" 
                               value="{{ old('image') }}"
                               class="form-control"
                               placeholder="https://example.com/image.jpg">
                        <div class="form-text">URL de l'image d'illustration</div>
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
                                <button type="submit" name="action" value="draft" class="btn btn-outline-primary">
                                    <i class="fas fa-save me-2"></i>Sauvegarder en brouillon
                                </button>
                                <button type="submit" name="action" value="publish" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Publier l'article
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
.max-height-200 {
    max-height: 200px;
}
</style>
@endpush