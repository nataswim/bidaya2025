@extends('layouts.admin')

@section('title', 'Gestion des Tags')
@section('page-title', 'Tags')
@section('page-description', 'Gestion des étiquettes d\'articles')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des tags -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Liste des tags</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                                <i class="fas fa-trash me-2"></i>Suppression groupée
                            </button>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTagModal">
                                <i class="fas fa-plus me-2"></i>Nouveau tag
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Filtres -->
                <div class="card-body border-bottom p-4">
                    <form method="GET" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ $search }}" 
                                       class="form-control border-start-0"
                                       placeholder="Rechercher un tag...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-outline-primary flex-fill">
                                    <i class="fas fa-filter me-2"></i>Rechercher
                                </button>
                                @if($search)
                                    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tags avec layout en grille -->
                <div class="card-body p-4">
                    @if($tags->count() > 0)
                        <div class="row g-3">
                            @foreach($tags as $tag)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border h-100 hover-lift">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="flex-fill">
                                                    <h6 class="mb-2">
                                                        <span class="badge bg-warning-subtle text-warning me-2">
                                                            <i class="fas fa-tag"></i>
                                                        </span>
                                                        {{ $tag->name }}
                                                    </h6>
                                                    @if($tag->description)
                                                        <p class="text-muted small mb-2">{{ Str::limit($tag->description, 60) }}</p>
                                                    @endif
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="fas fa-newspaper me-1"></i>
                                                        <span>{{ $tag->posts()->count() }} articles</span>
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button class="dropdown-item" 
                                                                    onclick="editTag({{ $tag->id }}, '{{ $tag->name }}', '{{ addslashes($tag->description) }}')">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('public.index', ['tag' => $tag->slug]) }}" target="_blank">
                                                                <i class="fas fa-external-link-alt me-2"></i>Voir sur le site
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="dropdown-item text-danger"
                                                                        data-confirm="delete">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($tags->hasPages())
                            <div class="mt-4">
                                {{ $tags->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5>Aucun tag trouvé</h5>
                            <p class="text-muted">Créez votre premier tag pour organiser vos articles</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTagModal">
                                <i class="fas fa-plus me-2"></i>Créer un tag
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques et actions -->
        <div class="col-lg-4">
            <!-- Statistiques -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>Statistiques
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $totalTags }}</h4>
                                <small class="text-muted">Total tags</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-success mb-1">{{ $usedTags }}</h4>
                                <small class="text-muted">Utilisés</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-warning mb-1">{{ $unusedTags }}</h4>
                                <small class="text-muted">Non utilisés</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-info mb-1">{{ $avgPerPost }}</h4>
                                <small class="text-muted">Moy./article</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags populaires -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-fire me-2 text-danger"></i>Tags populaires
                    </h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $popularTags = \App\Models\Tag::withCount('posts')
                            ->orderBy('posts_count', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @forelse($popularTags as $tag)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <span class="badge bg-warning-subtle text-warning">{{ $tag->name }}</span>
                            </div>
                            <small class="text-muted">{{ $tag->posts_count }} articles</small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Aucun tag utilisé pour le moment</p>
                    @endforelse
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-tools me-2 text-info"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-warning" onclick="cleanUnusedTags()">
                            <i class="fas fa-broom me-2"></i>Nettoyer les tags non utilisés
                        </button>
                        <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#mergeTagsModal">
                            <i class="fas fa-compress-alt me-2"></i>Fusionner des tags
                        </button>
                        <button class="btn btn-outline-success" onclick="exportTags()">
                            <i class="fas fa-download me-2"></i>Exporter la liste
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal création/édition tag -->
<div class="modal fade" id="createTagModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tag me-2"></i>
                    <span id="modal-title">Nouveau tag</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="tagForm" method="POST" action="{{ route('admin.tags.store') }}">
                @csrf
                <input type="hidden" id="method" name="_method" value="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tag_name" class="form-label fw-semibold">Nom du tag *</label>
                        <input type="text" 
                               name="name" 
                               id="tag_name" 
                               class="form-control"
                               placeholder="Ex: Laravel"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="tag_description" class="form-label fw-semibold">Description</label>
                        <textarea name="description" 
                                  id="tag_description" 
                                  rows="3"
                                  class="form-control"
                                  placeholder="Description optionnelle du tag..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tag_color" class="form-label fw-semibold">Couleur</label>
                        <select name="color" id="tag_color" class="form-select">
                            <option value="primary">🔵 Bleu (Primary)</option>
                            <option value="success">🟢 Vert (Success)</option>
                            <option value="danger">🔴 Rouge (Danger)</option>
                            <option value="warning">🟡 Jaune (Warning)</option>
                            <option value="info">🔷 Cyan (Info)</option>
                            <option value="secondary">⚫ Gris (Secondary)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        <span id="submit-text">Créer le tag</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editTag(id, name, description) {
    document.getElementById('modal-title').textContent = 'Modifier le tag';
    document.getElementById('submit-text').textContent = 'Mettre à jour';
    document.getElementById('tag_name').value = name;
    document.getElementById('tag_description').value = description;
    document.getElementById('method').value = 'PUT';
    document.getElementById('tagForm').action = `/admin/tags/${id}`;
    
    new bootstrap.Modal(document.getElementById('createTagModal')).show();
}

function resetModal() {
    document.getElementById('modal-title').textContent = 'Nouveau tag';
    document.getElementById('submit-text').textContent = 'Créer le tag';
    document.getElementById('tagForm').reset();
    document.getElementById('method').value = '';
    document.getElementById('tagForm').action = '{{ route("admin.tags.store") }}';
}

document.getElementById('createTagModal').addEventListener('hidden.bs.modal', resetModal);

function cleanUnusedTags() {
    if (confirm('Êtes-vous sûr de vouloir supprimer tous les tags non utilisés ?')) {
        fetch('{{ route("admin.tags.clean") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function exportTags() {
    window.open('{{ route("admin.tags.export") }}', '_blank');
}
</script>
@endpush