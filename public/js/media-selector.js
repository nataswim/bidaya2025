// Selecteur de medias reutilisable
class MediaFieldSelector {
    constructor() {
        this.currentFieldId = null;
        this.previewElementId = null;
        this.modal = null;
    }

    // Ouvrir le selecteur pour un champ specifique
    openForField(fieldId, previewElementId = null) {
        this.currentFieldId = fieldId;
        this.previewElementId = previewElementId;
        
        if (!this.modal) {
            this.createModal();
        }
        
        this.loadMedias();
        this.showModal();
    }

    createModal() {
        const modalHTML = `
            <div class="modal fade" id="mediaFieldSelectorModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-images me-2"></i>Selectionner une image
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-body">
                            <!-- Recherche -->
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" id="mediaFieldSearch" class="form-control" 
                                               placeholder="Rechercher une image...">
                                    </div>
                                    <div class="col-md-4">
                                        <select id="mediaFieldCategory" class="form-select">
                                            <option value="">Toutes les categories</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary w-100" onclick="mediaFieldSelector.loadMedias()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Grille d'images -->
                            <div id="mediaFieldGrid" class="row g-3" style="max-height: 400px; overflow-y: auto;">
                                <div class="col-12 text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = document.getElementById('mediaFieldSelectorModal');
        this.setupEvents();
    }

    setupEvents() {
        // Recherche
        const searchInput = this.modal.querySelector('#mediaFieldSearch');
        searchInput.addEventListener('input', (e) => {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.loadMedias();
            }, 300);
        });
    }

    async loadMedias() {
        try {
            const search = document.getElementById('mediaFieldSearch').value;
            const category = document.getElementById('mediaFieldCategory').value;
            
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            const response = await fetch(`/admin/media-api?${params}`, {
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Erreur de chargement');
            
            const data = await response.json();
            this.renderMedias(data.data || []);
        } catch (error) {
            console.error('Erreur:', error);
            this.showError('Erreur lors du chargement des medias');
        }
    }

    renderMedias(medias) {
        const grid = this.modal.querySelector('#mediaFieldGrid');
        
        if (!medias || medias.length === 0) {
            grid.innerHTML = `
                <div class="col-12 text-center py-4">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune image trouvee</h5>
                    <p class="text-muted">Uploadez des images dans votre mediatheque.</p>
                    <a href="/admin/media" class="btn btn-primary" target="_blank">
                        <i class="fas fa-upload me-2"></i>Gerer les medias
                    </a>
                </div>
            `;
            return;
        }

        grid.innerHTML = medias.map(media => {
            const imageUrl = media.url || `/storage/${media.path}`;
            const imageName = media.name || media.original_name || 'Sans nom';
            
            return `
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="card h-100 media-select-item" style="cursor: pointer;" 
                         onclick="mediaFieldSelector.selectMedia('${imageUrl}', '${imageName}')">
                        <div class="card-img-top" style="height: 120px; overflow: hidden;">
                            <img src="${imageUrl}" alt="${imageName}" 
                                 class="img-fluid w-100 h-100" style="object-fit: cover;"
                                 loading="lazy">
                        </div>
                        <div class="card-body p-2">
                            <p class="card-text small text-truncate mb-0" title="${imageName}">
                                ${imageName}
                            </p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    selectMedia(imageUrl, imageName) {
    // Mettre A jour le champ input
    const field = document.getElementById(this.currentFieldId);
    if (field) {
        field.value = imageUrl;
        
        // Supprimer toute validation personnalisee
        field.setCustomValidity('');
        
        // Declencher les evenements
        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.dispatchEvent(new Event('change', { bubbles: true }));
    }

    // Mettre A jour l'aperçu
    if (this.previewElementId) {
        const preview = document.getElementById(this.previewElementId);
        if (preview) {
            preview.src = imageUrl;
            preview.alt = imageName;
            preview.style.display = 'block';
            
            // Afficher le conteneur d'aperçu
            const previewContainer = preview.closest('.mt-3, .d-none');
            if (previewContainer && previewContainer.classList.contains('d-none')) {
                previewContainer.classList.remove('d-none');
            }
        }
    }

    this.hideModal();
    this.showNotification('Image selectionnee avec succes');
}





    

    showModal() {
        if (typeof bootstrap !== 'undefined') {
            const modal = new bootstrap.Modal(this.modal);
            modal.show();
        } else {
            this.modal.style.display = 'block';
            this.modal.classList.add('show');
        }
    }

    hideModal() {
        if (typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getInstance(this.modal);
            if (modal) modal.hide();
        } else {
            this.modal.style.display = 'none';
            this.modal.classList.remove('show');
        }
    }

    showError(message) {
        const grid = this.modal.querySelector('#mediaFieldGrid');
        grid.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${message}
                </div>
            </div>
        `;
    }

    showNotification(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success position-fixed';
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        alert.innerHTML = `<i class="fas fa-check me-2"></i>${message}`;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
}

// Instance globale
const mediaFieldSelector = new MediaFieldSelector();

// Fonctions utilitaires
function openMediaSelector(fieldId, previewId = null) {
    mediaFieldSelector.openForField(fieldId, previewId);
}