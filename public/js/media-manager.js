// Media Manager JavaScript
class MediaManager {
    constructor() {
        this.selectedFiles = [];
        this.maxFileSize = 5 * 1024 * 1024; // 5MB
        this.allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupDragAndDrop();
        this.setupColorPicker();
        this.setupModals();
    }

    setupEventListeners() {
        // Gestion des fichiers selectionnes
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                this.handleFileSelect(e.target.files);
            });
        }

        // Reset du formulaire Ã la fermeture du modal
        const uploadModal = document.getElementById('uploadModal');
        if (uploadModal) {
            uploadModal.addEventListener('hidden.bs.modal', () => {
                this.resetUploadForm();
            });
        }

        // Synchronisation du color picker
        const categoryColor = document.getElementById('categoryColor');
        const colorHex = document.getElementById('colorHex');
        
        if (categoryColor && colorHex) {
            categoryColor.addEventListener('change', (e) => {
                colorHex.value = e.target.value;
            });
            
            colorHex.addEventListener('input', (e) => {
                if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
                    categoryColor.value = e.target.value;
                }
            });
        }
    }

    setupDragAndDrop() {
        const uploadZone = document.getElementById('uploadZone');
        if (!uploadZone) return;

        const overlay = uploadZone.querySelector('.upload-overlay');

        // Prevenir les comportements par defaut
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, this.preventDefaults, false);
            document.body.addEventListener(eventName, this.preventDefaults, false);
        });

        // Effets visuels
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.remove('dragover');
            });
        });

        // Gestion du drop
        uploadZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            this.handleFileSelect(files);
        });
    }

    setupColorPicker() {
        // Synchronisation entre le color picker et l'input text
        const colorPicker = document.getElementById('categoryColor');
        const colorInput = document.getElementById('colorHex');
        
        if (colorPicker && colorInput) {
            colorPicker.addEventListener('input', (e) => {
                colorInput.value = e.target.value;
            });
            
            colorInput.addEventListener('input', (e) => {
                const value = e.target.value;
                if (/^#[0-9A-Fa-f]{6}$/i.test(value)) {
                    colorPicker.value = value;
                }
            });
        }
    }

    setupModals() {
        // Configuration des modals Bootstrap si necessaire
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', (e) => {
                // Actions Ã effectuer lors de l'ouverture des modals
            });
        });
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    handleFileSelect(files) {
        const validFiles = [];
        const errors = [];

        Array.from(files).forEach(file => {
            if (!this.allowedTypes.includes(file.type)) {
                errors.push(`${file.name}: Type de fichier non autorise`);
                return;
            }

            if (file.size > this.maxFileSize) {
                errors.push(`${file.name}: Fichier trop volumineux (max 5MB)`);
                return;
            }

            validFiles.push(file);
        });

        if (errors.length > 0) {
            this.showAlert('Erreurs de validation', errors.join('\n'), 'warning');
        }

        if (validFiles.length > 0) {
            this.selectedFiles = validFiles;
            this.updateFilePreview();
            this.updateUploadButton();
        }
    }

    updateFilePreview() {
        const previewContainer = document.getElementById('previewContainer');
        const filePreview = document.getElementById('filePreview');
        
        if (!previewContainer || !filePreview) return;

        previewContainer.innerHTML = '';

        this.selectedFiles.forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4';
            
            const reader = new FileReader();
            reader.onload = (e) => {
                col.innerHTML = `
                    <div class="file-preview-item">
                        <div class="position-relative">
                            <img src="${e.target.result}" alt="${file.name}" class="w-100">
                            <button type="button" 
                                    class="btn btn-danger btn-sm file-preview-remove"
                                    onclick="mediaManager.removeFile(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="file-form">
                            <div class="mb-2">
                                <input type="text" 
                                       name="names[${index}]" 
                                       class="form-control form-control-sm" 
                                       placeholder="Nom personnalise"
                                       value="${this.cleanFileName(file.name)}">
                            </div>
                            <div>
                                <input type="text" 
                                       name="alt_texts[${index}]" 
                                       class="form-control form-control-sm" 
                                       placeholder="Texte alternatif">
                            </div>
                        </div>
                        <div class="file-preview-info">
                            <div class="small">
                                <div class="text-truncate">${file.name}</div>
                                <div>${this.formatFileSize(file.size)}</div>
                            </div>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
            
            previewContainer.appendChild(col);
        });

        filePreview.classList.remove('d-none');
    }

    removeFile(index) {
        this.selectedFiles.splice(index, 1);
        
        if (this.selectedFiles.length === 0) {
            document.getElementById('filePreview').classList.add('d-none');
            document.getElementById('fileInput').value = '';
        } else {
            this.updateFilePreview();
        }
        
        this.updateUploadButton();
    }

    updateUploadButton() {
        const uploadBtn = document.getElementById('uploadBtn');
        const fileCount = document.getElementById('fileCount');
        
        if (uploadBtn && fileCount) {
            const count = this.selectedFiles.length;
            uploadBtn.disabled = count === 0;
            fileCount.textContent = count;
        }
    }

    resetUploadForm() {
        this.selectedFiles = [];
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').classList.add('d-none');
        document.getElementById('previewContainer').innerHTML = '';
        document.getElementById('uploadProgress').classList.add('d-none');
        this.updateUploadButton();
    }

    cleanFileName(filename) {
        const name = filename.replace(/\.[^/.]+$/, ""); // Supprimer l'extension
        return name.replace(/[_-]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    showAlert(title, message, type = 'info') {
        // Utiliser Bootstrap Toast ou Alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
        alertDiv.innerHTML = `
            <strong>${title}</strong><br>
            ${message.replace(/\n/g, '<br>')}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-supprimer apres 5 secondes
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
}

// Fonctions globales pour les actions des medias
function viewMedia(mediaId) {
    fetch(`/admin/media/${mediaId}`)
        .then(response => response.text())
        .then(html => {
            // Afficher dans un modal ou rediriger
            window.location.href = `/admin/media/${mediaId}`;
        })
        .catch(error => {
            console.error('Erreur:', error);
            mediaManager.showAlert('Erreur', 'Impossible de charger les details du media', 'danger');
        });
}

function selectMedia(mediaId) {
    const mediaItem = document.querySelector(`[data-media-id="${mediaId}"]`);
    if (mediaItem) {
        mediaItem.classList.toggle('selected');
        
        // Si c'est dans un contexte de selection (modal), gerer la selection
        if (window.mediaSelector) {
            window.mediaSelector.toggleSelection(mediaId);
        }
    }
}

function deleteMedia(mediaId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce media ? Cette action est irreversible.')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/media/${mediaId}`;
    form.innerHTML = `
        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
        <input type="hidden" name="_method" value="DELETE">
    `;
    
    document.body.appendChild(form);
    form.submit();
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.select();
        element.setSelectionRange(0, 99999); // Pour mobile
        
        try {
            document.execCommand('copy');
            mediaManager.showAlert('Succes', 'URL copiee dans le presse-papiers', 'success');
        } catch (err) {
            // Fallback pour les navigateurs modernes
            navigator.clipboard.writeText(element.value).then(() => {
                mediaManager.showAlert('Succes', 'URL copiee dans le presse-papiers', 'success');
            }).catch(() => {
                mediaManager.showAlert('Erreur', 'Impossible de copier l\'URL', 'danger');
            });
        }
    }
}

function updateMedia() {
    const form = document.getElementById('updateMediaForm');
    if (form) {
        form.submit();
    }
}

function deleteMediaFromDetails() {
    const form = document.getElementById('updateMediaForm');
    if (form && confirm('Êtes-vous sûr de vouloir supprimer ce media ?')) {
        // Changer la methode pour DELETE
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.value = 'DELETE';
        }
        form.submit();
    }
}

// Classe pour la selection de medias (utilisee dans d'autres pages)
class MediaSelector {
    constructor(options = {}) {
        this.options = {
            multiple: false,
            onSelect: null,
            allowedTypes: ['image/*'],
            ...options
        };
        this.selectedItems = [];
        this.modal = null;
        this.init();
    }

    init() {
        this.createModal();
        this.setupEventListeners();
    }

    createModal() {
        const modalHTML = `
            <div class="modal fade" id="mediaSelectorModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Selectionner des medias</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" id="mediaSearch" class="form-control" placeholder="Rechercher...">
                                </div>
                                <div class="col-md-3">
                                    <select id="mediaCategoryFilter" class="form-select">
                                        <option value="">Toutes les categories</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="this.loadMedia()">
                                        <i class="fas fa-search me-1"></i>Rechercher
                                    </button>
                                </div>
                            </div>
                            <div id="mediaGrid" class="row g-3">
                                <!-- Contenu charge via AJAX -->
                            </div>
                            <div id="mediaLoadMore" class="text-center mt-3 d-none">
                                <button type="button" class="btn btn-outline-primary" onclick="this.loadMore()">
                                    Charger plus
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span id="selectionCount" class="text-muted me-auto">0 selectionne(s)</span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-primary" onclick="this.confirmSelection()">
                                Selectionner
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = new bootstrap.Modal(document.getElementById('mediaSelectorModal'));
    }

    show() {
        this.loadMedia();
        this.modal.show();
    }

    loadMedia(page = 1) {
        const search = document.getElementById('mediaSearch').value;
        const category = document.getElementById('mediaCategoryFilter').value;
        
        const params = new URLSearchParams({
            search,
            category,
            page
        });

        fetch(`/admin/media-api?${params}`)
            .then(response => response.json())
            .then(data => {
                this.renderMedia(data, page === 1);
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    renderMedia(data, replace = true) {
        const grid = document.getElementById('mediaGrid');
        
        if (replace) {
            grid.innerHTML = '';
        }

        data.data.forEach(media => {
            const col = document.createElement('div');
            col.className = 'col-md-3 col-sm-4 col-6';
            col.innerHTML = `
                <div class="card media-selector-item" data-media-id="${media.id}" onclick="mediaSelector.toggleSelection(${media.id})">
                    <img src="${media.url}" alt="${media.name}" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-2">
                        <h6 class="card-title small mb-0 text-truncate">${media.name}</h6>
                        <small class="text-muted">${media.formatted_size}</small>
                    </div>
                    <div class="selection-overlay position-absolute top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center bg-primary bg-opacity-75">
                        <i class="fas fa-check text-white fa-2x"></i>
                    </div>
                </div>
            `;
            grid.appendChild(col);
        });

        // Gestion du "Charger plus"
        const loadMore = document.getElementById('mediaLoadMore');
        if (data.current_page < data.last_page) {
            loadMore.classList.remove('d-none');
            loadMore.onclick = () => this.loadMedia(data.current_page + 1);
        } else {
            loadMore.classList.add('d-none');
        }
    }

    toggleSelection(mediaId) {
        const item = document.querySelector(`[data-media-id="${mediaId}"]`);
        const overlay = item.querySelector('.selection-overlay');
        
        if (this.selectedItems.includes(mediaId)) {
            // Deselectionner
            this.selectedItems = this.selectedItems.filter(id => id !== mediaId);
            item.classList.remove('selected');
            overlay.classList.add('d-none');
        } else {
            // Selectionner
            if (!this.options.multiple) {
                // Mode simple : deselectionner les autres
                this.selectedItems = [];
                document.querySelectorAll('.media-selector-item.selected').forEach(el => {
                    el.classList.remove('selected');
                    el.querySelector('.selection-overlay').classList.add('d-none');
                });
            }
            
            this.selectedItems.push(mediaId);
            item.classList.add('selected');
            overlay.classList.remove('d-none');
            overlay.classList.add('d-flex');
        }

        this.updateSelectionCount();
    }

    updateSelectionCount() {
        const count = document.getElementById('selectionCount');
        count.textContent = `${this.selectedItems.length} selectionne(s)`;
    }

    confirmSelection() {
        if (this.options.onSelect && this.selectedItems.length > 0) {
            this.options.onSelect(this.selectedItems);
        }
        this.modal.hide();
    }
}

// Initialisation
let mediaManager;
let mediaSelector;

document.addEventListener('DOMContentLoaded', function() {
    mediaManager = new MediaManager();
    
    // Initialiser le selecteur de medias si necessaire
    window.mediaSelector = mediaSelector;
});

// Fonction utilitaire pour ouvrir le selecteur de medias
function openMediaSelector(options = {}) {
    if (!mediaSelector) {
        mediaSelector = new MediaSelector(options);
    }
    mediaSelector.show();
}