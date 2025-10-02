@props(['contentType', 'contentId'])

@auth
    @if(auth()->user()->hasRole('user') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('admin'))
        <button type="button" 
                class="btn btn-sm btn-outline-success add-to-notebook-btn"
                data-content-type="{{ $contentType }}"
                data-content-id="{{ $contentId }}">
            <i class="fas fa-book me-1"></i>Ajouter au carnet
        </button>
    @endif
@endauth

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.add-to-notebook-btn');
        if (!btn) return;
        
        e.preventDefault();
        const contentType = btn.dataset.contentType;
        const contentId = btn.dataset.contentId;
        
        showNotebookModal(contentType, contentId);
    });
});




function showNotebookModal(contentType, contentId) {
    fetch(`/user/notebooks/api/by-type?content_type=${contentType}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 403) {
                throw new Error('Accès refusé. Fonctionnalité réservée aux membres premium.');
            }
            if (response.status === 401) {
                throw new Error('Veuillez vous connecter pour utiliser cette fonctionnalité.');
            }
            throw new Error(`Erreur ${response.status}`);
        }
        return response.json();
    })
    .then(notebooks => {
        const modalHtml = `
            <div class="modal fade" id="addToNotebookModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter à un carnet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeNotebookModal()"></button>
                        </div>
                        <div class="modal-body">
                            ${notebooks.length > 0 ? `
                                <div class="list-group mb-3">
                                    ${notebooks.map(nb => `
                                        <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" 
                                                onclick="addToNotebook(${nb.id}, '${contentType}', ${contentId})">
                                            <div>
                                                <i class="${nb.icon}" style="color: ${nb.color};"></i>
                                                <span class="ms-2">${nb.title}</span>
                                            </div>
                                            <span class="badge bg-secondary">${nb.items_count}</span>
                                        </button>
                                    `).join('')}
                                </div>
                            ` : `
                                <div class="alert alert-info">
                                    <p class="mb-2">Aucun carnet de type "${getContentTypeLabel(contentType)}".</p>
                                    <p class="mb-0 small">Créez-en un pour organiser vos contenus.</p>
                                </div>
                            `}
                            <hr>
                            <a href="/user/notebooks" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Créer un nouveau carnet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        const oldModal = document.getElementById('addToNotebookModal');
        if (oldModal) oldModal.remove();
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modalEl = document.getElementById('addToNotebookModal');
        
        // Ouvrir le modal selon la méthode disponible
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        } else if (typeof $ !== 'undefined') {
            $(modalEl).modal('show');
        } else {
            // Fallback manuel
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
            document.body.classList.add('modal-open');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
        
        modalEl.addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    })
    .catch(error => {
        showNotification(error.message || 'Erreur lors du chargement des carnets', 'danger');
    });
}

// Fonction pour fermer le modal
function closeNotebookModal() {
    const modalEl = document.getElementById('addToNotebookModal');
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
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
    }
}




function addToNotebook(notebookId, contentType, contentId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
        showNotification('Erreur : Token CSRF manquant', 'danger');
        return;
    }
    
    fetch('/user/notebooks/items/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
            notebook_id: notebookId,
            content_type: contentType,
            content_id: contentId
        })
    })
    .then(response => response.json())
    .then(data => {
        // Fermer le modal
        const modalEl = document.getElementById('addToNotebookModal');
        if (modalEl) {
            // Méthode 1 : Via Bootstrap si disponible
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
            } 
            // Méthode 2 : Via jQuery si disponible
            else if (typeof $ !== 'undefined') {
                $(modalEl).modal('hide');
            }
            // Méthode 3 : Manuellement
            else {
                modalEl.classList.remove('show');
                modalEl.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        }
        
        if (data.success) {
            showNotification('✓ Contenu ajouté au carnet !', 'success');
        } else {
            showNotification(data.message || 'Erreur lors de l\'ajout', 'warning');
        }
    })
    .catch(error => {
        showNotification('Erreur lors de l\'ajout', 'danger');
    });
}








function getContentTypeLabel(type) {
    const labels = {
        'posts': 'Articles',
        'fiches': 'Fiches Pratiques',
        'exercices': 'Exercices',
        'workouts': 'Séances d\'Entraînement',
        'plans': 'Plans d\'Entraînement',
        'downloadables': 'Documents'
    };
    return labels[type] || 'Contenus';
}

function showNotification(message, type = 'success') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 
                      'alert-danger';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" 
             style="z-index: 9999; min-width: 300px; max-width: 500px;" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="this.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto-suppression simple
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        const lastAlert = Array.from(alerts).pop();
        if (lastAlert) lastAlert.remove();
    }, 4000);
}



</script>
@endpush
@endonce