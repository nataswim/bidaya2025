@extends('layouts.user')

@section('title', 'Mes Carnets')

@section('content')
<div class="container-lg py-5">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-2">Mes Carnets</h1>
                    <p class="text-muted mb-0">Organisez et sauvegardez vos contenus préférés</p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNotebookModal">
                    <i class="fas fa-plus me-2"></i>Créer un carnet
                </button>
            </div>
        </div>
    </div>

    @if($notebooks->count() > 0)
        <div class="row g-4">
            @foreach($notebooks as $notebook)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 50px; height: 50px; background-color: {{ $notebook->color }}20;">
                                            <i class="{{ $notebook->content_type_icon }} fa-lg" style="color: {{ $notebook->color }};"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-0">
                                                <a href="{{ route('user.notebooks.show', $notebook) }}" 
                                                   class="text-decoration-none text-dark stretched-link">
                                                    {{ $notebook->title }}
                                                </a>
                                            </h5>
                                            <small class="text-muted">{{ $notebook->content_type_label }}</small>
                                        </div>
                                    </div>
                                </div>
                                @if($notebook->is_favorite)
                                    <i class="fas fa-star text-warning"></i>
                                @endif
                            </div>
                            
                            @if($notebook->description)
                                <p class="text-muted small mb-3">{{ Str::limit($notebook->description, 80) }}</p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary-subtle text-secondary">
                                    {{ $notebook->items_count }} élément(s)
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $notebook->updated_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-book fa-3x text-muted mb-4 opacity-25"></i>
            <h4>Aucun carnet créé</h4>
            <p class="text-muted mb-4">Créez votre premier carnet pour organiser vos contenus préférés</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNotebookModal">
                <i class="fas fa-plus me-2"></i>Créer mon premier carnet
            </button>
        </div>
    @endif
</div>

<!-- Modal Création Carnet -->
<div class="modal fade" id="createNotebookModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.notebooks.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Créer un carnet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre du carnet *</label>
                        <input type="text" name="title" class="form-control" required maxlength="200">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Type de contenu *</label>
                        <select name="content_type" class="form-select" required>
                            <option value="">Sélectionner un type</option>
                            <option value="posts">Articles</option>
                            <option value="fiches">Fiches Pratiques</option>
                            <option value="exercices">Exercices</option>
                            <option value="workouts">Séances d'Entraînement</option>
                            <option value="plans">Plans d'Entraînement</option>
                            <option value="downloadables">Documents</option>
                        </select>
                        <small class="text-muted">Un carnet ne peut contenir qu'un seul type de contenu</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Couleur</label>
                        <input type="color" name="color" class="form-control form-control-color" value="#007bff">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer le carnet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
}
</style>
@endpush