/**
 * Sélecteur de vidéos depuis la bibliothèque locale
 * 
 * @file public/js/video-library-selector.js
 */

class VideoLibrarySelector {
    constructor() {
        this.currentPath = '';
        this.modal = null;
        this.onSelectCallback = null;
    }

    /**
     * Initialiser la modal
     */
    init() {
        if (document.getElementById('videoLibraryModal')) {
            return; // Déjà initialisé
        }

        const modalHTML = `
            <div class="modal fade" id="videoLibraryModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <div class="d-flex align-items-center w-100">
                                <i class="fas fa-folder-open me-2"></i>
                                <h5 class="modal-title mb-0">Bibliothèque Vidéo</h5>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-body p-0">
                            <!-- Barre d'outils -->
                            <div class="bg-light border-bottom p-3">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" id="btnBackLibrary" class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="fas fa-arrow-left"></i>
                                            </button>
                                            <div class="flex-fill">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-folder text-primary"></i>
                                                    </span>
                                                    <input type="text" id="currentPathLibrary" class="form-control" readonly value="/">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button type="button" id="btnNewFolder" class="btn btn-sm btn-success me-2">
                                            <i class="fas fa-folder-plus me-1"></i>Nouveau dossier
                                        </button>
                                        <button type="button" id="btnUploadVideo" class="btn btn-sm btn-primary">
                                            <i class="fas fa-upload me-1"></i>Upload vidéo
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Zone de contenu -->
                            <div id="libraryContent" class="p-4" style="min-height: 400px;">
                                <div class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal upload vidéo -->
            <div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload une vidéo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="uploadVideoForm">
                                <input type="hidden" id="uploadFolder" value="">
                                <div class="mb-3">
                                    <label class="form-label">Fichier vidéo (max 200 Mo)</label>
                                    <input type="file" id="videoFile" class="form-control" accept="video/*" required>
                                    <div class="form-text">Formats: mp4, webm, mov, avi, mkv, flv, wmv, mpeg, mpg, 3gp</div>
                                </div>
                                <div id="uploadProgress" class="d-none mb-3">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="btnConfirmUpload" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Uploader
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal nouveau dossier -->
            <div class="modal fade" id="newFolderModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Créer un dossier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="newFolderForm">
                                <div class="mb-3">
                                    <label class="form-label">Nom du dossier</label>
                                    <input type="text" id="folderName" class="form-control" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" id="btnConfirmNewFolder" class="btn btn-success">
                                <i class="fas fa-folder-plus me-2"></i>Créer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = new bootstrap.Modal(document.getElementById('videoLibraryModal'));
        
        this.attachEvents();
    }

    /**
     * Attacher les événements
     */
    attachEvents() {
        // Retour arrière
        document.getElementById('btnBackLibrary').addEventListener('click', () => {
            const parts = this.currentPath.split('/').filter(p => p);
            parts.pop();
            this.currentPath = parts.join('/');
            this.browse(this.currentPath);
        });

        // Nouveau dossier
        document.getElementById('btnNewFolder').addEventListener('click', () => {
            const newFolderModal = new bootstrap.Modal(document.getElementById('newFolderModal'));
            newFolderModal.show();
        });

        document.getElementById('btnConfirmNewFolder').addEventListener('click', () => {
            this.createFolder();
        });

        // Upload vidéo
        document.getElementById('btnUploadVideo').addEventListener('click', () => {
            document.getElementById('uploadFolder').value = this.currentPath;
            const uploadModal = new bootstrap.Modal(document.getElementById('uploadVideoModal'));
            uploadModal.show();
        });

        document.getElementById('btnConfirmUpload').addEventListener('click', () => {
            this.uploadVideo();
        });
    }

    /**
     * Ouvrir la modal et naviguer dans la bibliothèque
     */
    open(onSelect) {
        this.init();
        this.onSelectCallback = onSelect;
        this.currentPath = '';
        this.browse('');
        this.modal.show();
    }

    /**
     * Parcourir un dossier
     */
    async browse(path) {
        this.currentPath = path;
        
        const content = document.getElementById('libraryContent');
        content.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
        `;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            
            if (!csrfToken) {
                console.error('❌ Token CSRF introuvable dans la page');
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Erreur : Token CSRF manquant. Veuillez recharger la page.
                    </div>
                `;
                return;
            }

            console.log('📤 Envoi requête browse avec path:', path);

            const response = await fetch('/admin/video-library/browse', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ path })
            });

            console.log('📥 Réponse reçue:', response.status, response.statusText);

            // Vérifier si la réponse est du JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                console.error('❌ Réponse non-JSON reçue:', contentType);
                const text = await response.text();
                console.error('Contenu de la réponse:', text.substring(0, 500));
                
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Erreur de connexion</h5>
                        <p class="mb-0">La réponse du serveur n'est pas au format JSON.</p>
                        <hr>
                        <details>
                            <summary>Détails techniques</summary>
                            <small><strong>Status:</strong> ${response.status} ${response.statusText}</small><br>
                            <small><strong>Content-Type:</strong> ${contentType}</small><br>
                            <small><strong>URL:</strong> /admin/video-library/browse</small>
                        </details>
                    </div>
                `;
                return;
            }

            const data = await response.json();
            console.log('✅ Données JSON reçues:', data);

            if (data.success) {
                this.renderLibrary(data);
            } else {
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ${data.error || 'Erreur lors du chargement'}
                    </div>
                `;
            }
        } catch (error) {
            console.error('❌ Erreur catch:', error);
            content.innerHTML = `
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Erreur</h5>
                    <p><strong>Message:</strong> ${error.message}</p>
                    <hr>
                    <p class="mb-0 small">
                        Ouvrez la console du navigateur (F12) pour voir les détails.
                    </p>
                </div>
            `;
        }
    }

    /**
     * Afficher le contenu de la bibliothèque
     */
    renderLibrary(data) {
        const content = document.getElementById('libraryContent');
        const pathDisplay = document.getElementById('currentPathLibrary');
        const backBtn = document.getElementById('btnBackLibrary');

        pathDisplay.value = '/' + (data.currentPath || '');
        backBtn.disabled = !data.currentPath;

        if (data.items.length === 0) {
            content.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                    <h5>Aucun fichier</h5>
                    <p>Ce dossier est vide</p>
                </div>
            `;
            return;
        }

        let html = '<div class="row g-3">';

        data.items.forEach(item => {
            if (item.type === 'directory') {
                html += `
                    <div class="col-md-3">
                        <div class="card h-100 border hover-shadow cursor-pointer" onclick="videoLibrary.browse('${item.path}')">
                            <div class="card-body text-center">
                                <i class="fas fa-folder fa-3x text-warning mb-3"></i>
                                <h6 class="mb-0 text-truncate" title="${item.name}">${item.name}</h6>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                const validClass = item.isValid ? '' : 'opacity-50';
                const validBadge = item.isValid ? '' : '<span class="badge bg-danger position-absolute top-0 end-0 m-2">Trop volumineux</span>';
                const usedBadge = item.isUsed ? '<span class="badge bg-info position-absolute top-0 start-0 m-2"><i class="fas fa-check me-1"></i>Utilisée</span>' : '';
                const onClick = item.isValid ? `onclick="videoLibrary.selectVideo('${item.path}', '${item.name}')"` : '';
                
                html += `
                    <div class="col-md-3">
                        <div class="card h-100 border hover-shadow cursor-pointer ${validClass}" ${onClick}>
                            <div class="position-relative">
                                ${validBadge}
                                ${usedBadge}
                                <div class="card-body text-center">
                                    <i class="fas fa-file-video fa-3x text-primary mb-3"></i>
                                    <h6 class="mb-2 text-truncate small" title="${item.name}">${item.name}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">.${item.extension}</small>
                                        <span class="badge bg-light text-dark">${item.size}</span>
                                    </div>
                                    ${item.isValid ? '<button type="button" class="btn btn-sm btn-primary mt-2 w-100"><i class="fas fa-check me-1"></i>Utiliser</button>' : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        html += '</div>';
        content.innerHTML = html;
    }

    /**
     * Sélectionner une vidéo
     */
    async selectVideo(path, name) {
        const card = event.target.closest('.card');
        const originalHTML = card.innerHTML;
        
        // Désactiver temporairement la carte
        card.style.opacity = '0.6';
        card.style.pointerEvents = 'none';
        card.innerHTML = `
            <div class="card-body text-center">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="mb-0">Import en cours...</p>
            </div>
        `;

        try {
            const response = await fetch('/admin/video-library/import', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ path })
            });

            const data = await response.json();

            if (data.success && this.onSelectCallback) {
                // Appeler le callback avec les données de la vidéo
                this.onSelectCallback(data.data);
                
                // Fermer le modal
                this.modal.hide();
                
                // Afficher une notification de succès
                this.showNotification('✓ Vidéo importée avec succès', 'success');
                
                // Réinitialiser la carte après un court délai
                setTimeout(() => {
                    card.innerHTML = originalHTML;
                    card.style.opacity = '1';
                    card.style.pointerEvents = 'auto';
                }, 500);
            } else {
                this.showNotification(data.error || 'Erreur lors de l\'import', 'danger');
                // Restaurer la carte en cas d'erreur
                card.innerHTML = originalHTML;
                card.style.opacity = '1';
                card.style.pointerEvents = 'auto';
            }
        } catch (error) {
            console.error('Erreur:', error);
            this.showNotification('Erreur de connexion', 'danger');
            // Restaurer la carte en cas d'erreur
            card.innerHTML = originalHTML;
            card.style.opacity = '1';
            card.style.pointerEvents = 'auto';
        }
    }

    /**
     * Upload une vidéo
     */
    async uploadVideo() {
        const fileInput = document.getElementById('videoFile');
        const folder = document.getElementById('uploadFolder').value;
        const btn = document.getElementById('btnConfirmUpload');
        const progressDiv = document.getElementById('uploadProgress');
        const progressBar = progressDiv.querySelector('.progress-bar');

        if (!fileInput.files.length) {
            alert('Veuillez sélectionner un fichier');
            return;
        }

        const formData = new FormData();
        formData.append('video', fileInput.files[0]);
        formData.append('folder', folder);

        btn.disabled = true;
        progressDiv.classList.remove('d-none');

        try {
            const xhr = new XMLHttpRequest();
            
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                }
            });

            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        this.showNotification('Vidéo uploadée avec succès', 'success');
                        bootstrap.Modal.getInstance(document.getElementById('uploadVideoModal')).hide();
                        this.browse(this.currentPath);
                        fileInput.value = '';
                    }
                } else {
                    this.showNotification('Erreur lors de l\'upload', 'danger');
                }
                btn.disabled = false;
                progressDiv.classList.add('d-none');
                progressBar.style.width = '0%';
            });

            xhr.open('POST', '/admin/video-library/upload');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhr.send(formData);
        } catch (error) {
            console.error('Erreur:', error);
            this.showNotification('Erreur de connexion', 'danger');
            btn.disabled = false;
            progressDiv.classList.add('d-none');
        }
    }

    /**
     * Créer un nouveau dossier
     */
    async createFolder() {
        const folderName = document.getElementById('folderName').value.trim();
        
        if (!folderName) {
            alert('Veuillez saisir un nom de dossier');
            return;
        }

        try {
            const response = await fetch('/admin/video-library/create-folder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: folderName,
                    path: this.currentPath
                })
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Dossier créé avec succès', 'success');
                bootstrap.Modal.getInstance(document.getElementById('newFolderModal')).hide();
                document.getElementById('folderName').value = '';
                this.browse(this.currentPath);
            } else {
                this.showNotification(data.error || 'Erreur lors de la création', 'danger');
            }
        } catch (error) {
            console.error('Erreur:', error);
            this.showNotification('Erreur de connexion', 'danger');
        }
    }

    /**
     * Afficher une notification
     */
    showNotification(message, type = 'info') {
        // Supprimer les anciennes notifications
        document.querySelectorAll('.video-library-notification').forEach(el => el.remove());
        
        const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 video-library-notification shadow-lg" 
                 style="z-index: 9999; min-width: 300px;" 
                 role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    <span>${message}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHTML);
        
        // Auto-suppression après 3 secondes
        setTimeout(() => {
            const alert = document.querySelector('.video-library-notification');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 3000);
    }
}

// Instance globale
window.videoLibrary = new VideoLibrarySelector();