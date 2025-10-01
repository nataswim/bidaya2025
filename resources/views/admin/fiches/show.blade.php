@extends('layouts.admin')

@section('title', 'Détail de la fiche')
@section('page-title', $fiche->title)
@section('page-description', 'Détails de la fiche')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt me-2"></i>{{ $fiche->title }}
                        </h5>
                        <div class="d-flex gap-2">
                            @if($fiche->is_published)
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-check me-1"></i>Publié
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-edit me-1"></i>Brouillon
                                </span>
                            @endif
                            @if($fiche->is_featured)
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>En vedette
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Informations de base -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="border-start border-primary border-3 ps-3">
                                <small class="text-muted d-block">Slug</small>
                                <strong>{{ $fiche->slug }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-info border-3 ps-3">
                                <small class="text-muted d-block">Visibilité</small>
                                <strong>{{ $fiche->visibility === 'public' ? 'Public' : 'Membres uniquement' }}</strong>
                            </div>
                        </div>
                    </div>

                    @if($fiche->image)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Image principale</h6>
                            <img src="{{ $fiche->image }}" 
                                 alt="{{ $fiche->title }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 300px;">
                        </div>
                    @endif

                    @if($fiche->short_description)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Description courte</h6>
                            <div class="bg-light p-3 rounded content-display">
                                {!! $fiche->short_description !!}
                            </div>
                        </div>
                    @endif

                    @if($fiche->long_description)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Description complète</h6>
                            <div class="content-display">
                                {!! $fiche->long_description !!}
                            </div>
                        </div>
                    @endif

                    <!-- Informations SEO -->
                    @if($fiche->meta_title || $fiche->meta_description || $fiche->meta_keywords)
                        <div class="border-top pt-4">
                            <h6 class="fw-semibold mb-3 text-primary">
                                <i class="fas fa-search me-2"></i>Informations SEO
                            </h6>
                            <div class="row g-3">
                                @if($fiche->meta_title)
                                    <div class="col-12">
                                        <small class="text-muted d-block">Titre SEO</small>
                                        <strong>{{ $fiche->meta_title }}</strong>
                                    </div>
                                @endif
                                
                                @if($fiche->meta_description)
                                    <div class="col-12">
                                        <small class="text-muted d-block">Description SEO</small>
                                        <div class="bg-light p-2 rounded">{{ $fiche->meta_description }}</div>
                                    </div>
                                @endif
                                
                                @if($fiche->meta_keywords)
                                    <div class="col-12">
                                        <small class="text-muted d-block">Mots-clés</small>
                                        <div>
                                            @foreach(explode(',', $fiche->meta_keywords) as $keyword)
                                                <span class="badge bg-secondary me-1">{{ trim($keyword) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar informations -->
        <div class="col-lg-4">
            <!-- Statut et publication -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations de publication
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <small class="text-muted d-block">Statut</small>
                            <span class="badge bg-{{ $fiche->is_published ? 'success' : 'warning' }}-subtle text-{{ $fiche->is_published ? 'success' : 'warning' }} fs-6">
                                {{ $fiche->is_published ? 'Publié' : 'Brouillon' }}
                            </span>
                        </div>
                        
                        @if($fiche->published_at)
                            <div class="col-12">
                                <small class="text-muted d-block">Date de publication</small>
                                <strong>{{ $fiche->published_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        @endif
                        
                        <div class="col-6">
                            <small class="text-muted d-block">Vues</small>
                            <strong class="text-primary">{{ number_format($fiche->views_count) }}</strong>
                        </div>
                        
                        <div class="col-6">
                            <small class="text-muted d-block">Ordre</small>
                            <strong>{{ $fiche->sort_order }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catégorie -->
            @if($fiche->category)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient-info text-white p-3">
                        <h6 class="mb-0">
                            <i class="fas fa-folder me-2"></i>Catégorie
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-folder text-info"></i>
                            </div>
                            <div>
                                <strong>{{ $fiche->category->name }}</strong>
                                @if($fiche->category->description)
                                    <div class="text-muted small">{!! Str::limit($fiche->category->description, 50) !!}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Auteur et dates -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-secondary text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Historique
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3 small">
                        @if($fiche->creator)
                            <div class="col-12">
                                <small class="text-muted d-block">Créé par</small>
                                <strong>{{ $fiche->creator->name }}</strong>
                            </div>
                        @endif
                        
                        <div class="col-12">
                            <small class="text-muted d-block">Date de création</small>
                            <strong>{{ $fiche->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                        
                        @if($fiche->updated_at && $fiche->updated_at != $fiche->created_at)
                            <div class="col-12">
                                <small class="text-muted d-block">Dernière modification</small>
                                <strong>{{ $fiche->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.fiches.edit', $fiche) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        @if($fiche->is_published && $fiche->category)
                            <a href="{{ route('public.fiches.show', [$fiche->category, $fiche]) }}" target="_blank" class="btn btn-outline-info">
                                <i class="fas fa-external-link-alt me-2"></i>Voir sur le site
                            </a>
                        @endif
                        <a href="{{ route('admin.fiches.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                    
                    <hr class="my-3">
                    
                    <form method="POST" action="{{ route('admin.fiches.destroy', $fiche) }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Styles pour le contenu HTML de Quill */
.content-display h1,
.content-display h2,
.content-display h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.content-display p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

.content-display ul,
.content-display ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.content-display blockquote {
    border-left: 4px solid var(--bs-primary);
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6c757d;
}

.content-display img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.content-display pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    border-left: 4px solid #0ea5e9;
    overflow-x: auto;
    margin: 1rem 0;
}

.content-display {
    line-height: 1.6;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    background: #f9fafb;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}
</style>
@endpush