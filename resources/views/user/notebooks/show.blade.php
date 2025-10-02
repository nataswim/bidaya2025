@extends('layouts.user')

@section('title', $notebook->title)

@section('content')
<div class="container-lg py-5">
    <!-- En-tête du carnet -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid {{ $notebook->color }} !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 60px; height: 60px; background-color: {{ $notebook->color }}20;">
                                <i class="{{ $notebook->content_type_icon }} fa-2x" style="color: {{ $notebook->color }};"></i>
                            </div>
                            <div>
                                <h1 class="mb-1">{{ $notebook->title }}</h1>
                                <span class="badge bg-secondary-subtle text-secondary">
                                    {{ $notebook->content_type_label }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="toggleFavorite({{ $notebook->id }})">
                                <i class="fas fa-star {{ $notebook->is_favorite ? '' : 'text-muted' }}"></i>
                            </button>
                            <a href="{{ route('user.notebooks.export-pdf', $notebook) }}" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-file-pdf me-1"></i>PDF
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNotebookModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('user.notebooks.destroy', $notebook) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Supprimer ce carnet ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if($notebook->description)
                        <p class="text-muted mb-0">{{ $notebook->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contenus du carnet -->
    @if($notebook->items->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Contenus ({{ $notebook->items->count() }})</h4>
                    <small class="text-muted">Glissez-déposez pour réorganiser</small>
                </div>
            </div>
        </div>

        <div id="sortable-items" class="row g-3">
            @foreach($notebook->items as $item)
                <div class="col-12" data-item-id="{{ $item->id }}">
                    <div class="card border-0 shadow-sm sortable-item">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-grip-vertical text-muted handle" style="cursor: move;"></i>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">
                                        @if($item->content_url)
                                            <a href="{{ $item->content_url }}" class="text-decoration-none text-dark">
                                                {{ $item->content_title }}
                                            </a>
                                        @else
                                            <span class="text-muted">{{ $item->content_title }}</span>
                                        @endif
                                    </h6>
                                    @if($item->personal_note)
                                        <small class="text-muted">
                                            <i class="fas fa-sticky-note me-1"></i>{{ $item->personal_note }}
                                        </small>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" 
                                            onclick="editNote({{ $item->id }}, '{{ addslashes($item->personal_note ?? '') }}')">
                                        <i class="fas fa-sticky-note"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="removeItem({{ $item->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-25"></i>
            <h5>Aucun contenu dans ce carnet</h5>
            <p class="text-muted">Ajoutez des contenus depuis les pages de détail</p>
        </div>
    @endif

    <!-- Navigation -->
    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('user.notebooks.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à mes carnets
            </a>
        </div>
    </div>
</div>

<!-- Modal Edition Carnet -->
<div class="modal fade" id="editNotebookModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.notebooks.update', $notebook) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le carnet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre du carnet</label>
                        <input type="text" name="title" class="form-control" value="{{ $notebook->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $notebook->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Couleur</label>
                        <input type="color" name="color" class="form-control form-control-color" value="{{ $notebook->color }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edition Note -->
<div class="modal fade" id="editNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Note personnelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <textarea id="noteTextarea" class="form-control" rows="4" maxlength="1000"></textarea>
                <small class="text-muted">Maximum 1000 caractères</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveNote()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
let currentItemId = null;
const notebookId = {{ $notebook->id }};

// Sortable.js pour drag & drop
const sortableEl = document.getElementById('sortable-items');
if (sortableEl) {
    const sortable = new Sortable(sortableEl, {
        animation: 150,
        handle: '.handle',
        onEnd: function() {
            updateOrder();
        }
    });
}

function updateOrder() {
    const items = document.querySelectorAll('[data-item-id]');
    const orderData = Array.from(items).map((item, index) => ({
        id: parseInt(item.dataset.itemId),
        order: index
    }));
    
    fetch(`/user/notebooks/${notebookId}/reorder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items: orderData })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Erreur lors de la réorganisation');
            location.reload();
        }
    });
}

function editNote(itemId, currentNote) {
    currentItemId = itemId;
    document.getElementById('noteTextarea').value = currentNote;
    openModal('editNoteModal');
}

function saveNote() {
    const note = document.getElementById('noteTextarea').value;
    
    fetch(`/user/notebooks/items/${currentItemId}/note`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ personal_note: note })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('editNoteModal');
            location.reload();
        }
    });
}

function removeItem(itemId) {
    if (!confirm('Retirer ce contenu du carnet ?')) return;
    
    fetch(`/user/notebooks/items/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function toggleFavorite(notebookId) {
    fetch(`/user/notebooks/${notebookId}/toggle-favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Fonction universelle pour ouvrir un modal
function openModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } else if (typeof $ !== 'undefined') {
        $(modalEl).modal('show');
    } else {
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        document.body.classList.add('modal-open');
        
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.id = 'modalBackdrop';
        document.body.appendChild(backdrop);
    }
}

// Fonction universelle pour fermer un modal
function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    } else if (typeof $ !== 'undefined') {
        $(modalEl).modal('hide');
    } else {
        modalEl.classList.remove('show');
        modalEl.style.display = 'none';
        document.body.classList.remove('modal-open');
        
        const backdrop = document.getElementById('modalBackdrop');
        if (backdrop) backdrop.remove();
    }
}

// Gestion des fermetures avec les boutons close
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-bs-dismiss="modal"]') || e.target.closest('[data-bs-dismiss="modal"]')) {
        const modal = e.target.closest('.modal');
        if (modal) closeModal(modal.id);
    }
});
</script>
@endpush