@extends('layouts.admin')

@section('title', 'Contenus de l\'unité : ' . $catalogueUnit->title)
@section('page-title', 'Gestion des contenus')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des contenus -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-list me-2"></i>Contenus de l'unité
                            </h5>
                            <small class="opacity-75">{{ $catalogueUnit->title }}</small>
                        </div>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addContentModal">
                            <i class="fas fa-plus me-2"></i>Ajouter un contenu
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($catalogueUnit->contents->count() > 0)
                        <div class="list-group list-group-flush" id="contents-list">
                            @foreach($catalogueUnit->contents()->ordered()->get() as $content)
                                <div class="list-group-item px-4 py-3" data-content-id="{{ $content->id }}">
                                    <div class="row align-items-center">
                                        <!-- Handle de tri -->
                                        <div class="col-auto">
                                            <i class="fas fa-grip-vertical text-muted handle" style="cursor: move;"></i>
                                            <span class="badge bg-secondary ms-2">{{ $content->order }}</span>
                                        </div>
                                        
                                        <!-- Info contenu -->
                                        <div class="col">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">
                                                        {{ $content->display_title }}
                                                        @if($content->custom_title)
                                                            <small class="text-muted">(Titre personnalisé)</small>
                                                        @endif
                                                    </h6>
                                                    <div class="d-flex gap-2 mb-1">
                                                        <span class="badge bg-info-subtle text-info">
                                                            {{ $content->content_type_label }}
                                                        </span>
                                                        @if($content->is_required)
                                                            <span class="badge bg-success-subtle text-success">Obligatoire</span>
                                                        @else
                                                            <span class="badge bg-warning-subtle text-warning">Optionnel</span>
                                                        @endif
                                                        @if($content->duration_minutes)
                                                            <span class="badge bg-secondary-subtle text-secondary">
                                                                <i class="fas fa-clock me-1"></i>{{ $content->duration_minutes }} min
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($content->custom_description)
                                                        <small class="text-muted">{{ $content->custom_description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="col-auto">
                                            <div class="btn-group">
                                                @if($content->content_url)
                                                    <a href="{{ $content->content_url }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @endif
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        onclick="editContent({{ $content->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" 
                                                      action="{{ route('admin.catalogue-units.remove-content', [$catalogueUnit, $content]) }}"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Retirer ce contenu ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                            <h5>Aucun contenu lié</h5>
                            <p class="text-muted">Ajoutez des contenus à cette unité</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar infos -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h6>
                </div>
                <div class="card-body p-3">
                    <dl class="row mb-0">
                        <dt class="col-12">Module</dt>
                        <dd class="col-12 mb-3">{{ $catalogueUnit->module->name }}</dd>
                        
                        <dt class="col-12">Nombre de contenus</dt>
                        <dd class="col-12 mb-3">{{ $catalogueUnit->contents->count() }}</dd>
                        
                        <dt class="col-12">Types présents</dt>
                        <dd class="col-12">
                            @forelse($catalogueUnit->content_types as $type)
                                <span class="badge bg-secondary me-1">{{ $type }}</span>
                            @empty
                                <span class="text-muted">Aucun</span>
                            @endforelse
                        </dd>
                    </dl>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.catalogue-units.edit', $catalogueUnit) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier l'unité
                        </a>
                        <a href="{{ route('admin.catalogue-units.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ajout contenu -->
<div class="modal fade" id="addContentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.catalogue-units.add-content', $catalogueUnit) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un contenu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contentable_type" class="form-label">Type de contenu *</label>
                        <select name="contentable_type" id="contentable_type" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="App\Models\Post">Article (Post)</option>
                            <option value="App\Models\Video">Vidéo</option>
                            <option value="App\Models\Downloadable">Fichier téléchargeable</option>
                            <option value="App\Models\Fiche">Fiche</option>
                            <option value="App\Models\Exercice">Exercice</option>
                            <option value="App\Models\Workout">Entraînement</option>
                            <option value="App\Models\EbookFile">E-book</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="content-selector" style="display: none;">
                        <label for="contentable_id" class="form-label">Sélectionner le contenu *</label>
                        <select name="contentable_id" id="contentable_id" class="form-select" required>
                            <option value="">-- Choisir un type d'abord --</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="custom_title" class="form-label">Titre personnalisé (optionnel)</label>
                        <input type="text" name="custom_title" id="custom_title" class="form-control">
                        <div class="form-text">Laisser vide pour utiliser le titre original</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="custom_description" class="form-label">Description (optionnel)</label>
                        <textarea name="custom_description" id="custom_description" rows="2" class="form-control"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">Durée (minutes)</label>
                                <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Ordre</label>
                                <input type="number" name="order" id="order" class="form-control" min="0" 
                                       value="{{ ($catalogueUnit->contents()->max('order') ?? 0) + 1 }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="is_required" id="is_required" value="1" checked class="form-check-input">
                        <label for="is_required" class="form-check-label">Contenu obligatoire</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter le contenu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Drag & drop pour réordonner
    const contentsList = document.getElementById('contents-list');
    if (contentsList) {
        Sortable.create(contentsList, {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                const contents = [];
                contentsList.querySelectorAll('[data-content-id]').forEach(item => {
                    contents.push(item.dataset.contentId);
                });
                
                // Envoyer la nouvelle ordre
                fetch(`{{ route('admin.catalogue-units.reorder-contents', $catalogueUnit) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ contents: contents })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour les badges d'ordre
                        contentsList.querySelectorAll('.badge.bg-secondary').forEach((badge, index) => {
                            badge.textContent = index + 1;
                        });
                    }
                });
            }
        });
    }
    
    // Chargement dynamique des contenus
    const typeSelect = document.getElementById('contentable_type');
    const idSelect = document.getElementById('contentable_id');
    const selectorWrapper = document.getElementById('content-selector');
    
    typeSelect.addEventListener('change', function() {
        const contentType = this.value;
        
        if (!contentType) {
            selectorWrapper.style.display = 'none';
            return;
        }
        
        selectorWrapper.style.display = 'block';
        idSelect.innerHTML = '<option value="">Chargement...</option>';
        
        fetch(`{{ route('admin.catalogue-units.api.content-by-type') }}?content_type=${encodeURIComponent(contentType)}`)
            .then(response => response.json())
            .then(data => {
                idSelect.innerHTML = '<option value="">-- Sélectionner --</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.title;
                    idSelect.appendChild(option);
                });
            });
    });
});
</script>
@endpush