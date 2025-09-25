class QuillMediaManager {
    constructor() {
        this.quillInstances = new Map();
        this.imageModal = null;
        this.selectedImageSize = 'medium';
        this.imageSizeOptions = {
            small: { width: '25%', maxWidth: '200px', label: 'Petite (25%)' },
            medium: { width: '50%', maxWidth: '400px', label: 'Moyenne (50%)' },
            large: { width: '75%', maxWidth: '600px', label: 'Grande (75%)' },
            full: { width: '100%', maxWidth: '100%', label: 'Pleine largeur (100%)' }
        };
    }

    initQuillEditor(selector, textareaId) {
        const container = document.querySelector(selector);
        const textarea = document.getElementById(textareaId);
        
        if (!container || !textarea) return;

        const quill = new Quill(container, {
            theme: 'snow',
            placeholder: 'Redigez votre contenu...',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'blockquote', 'code-block'],
                        ['clean']
                    ],
                    handlers: {
                        'image': () => this.showImageModal(quill)
                    }
                }
            }
        });

        // Synchroniser avec le textarea
        quill.on('text-change', () => {
            textarea.value = quill.root.innerHTML;
        });

        // Charger le contenu initial
        if (textarea.value) {
            quill.root.innerHTML = textarea.value;
            this.makeImagesResponsive(quill);
        }

        this.quillInstances.set(textareaId, quill);
        return quill;
    }

    makeImagesResponsive(quill) {
        const images = quill.root.querySelectorAll('img');
        images.forEach(img => {
            if (!img.classList.contains('responsive-image')) {
                this.applyResponsiveStyles(img);
                img.addEventListener('click', () => this.showImageResizeOptions(img));
            }
        });
    }

    applyResponsiveStyles(img) {
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
        img.style.display = 'block';
        img.style.margin = '10px auto';
        img.style.borderRadius = '4px';
        img.style.cursor = 'pointer';
        img.classList.add('responsive-image');
    }

    showImageModal(quillInstance) {
        this.createImageModal();
        this.loadMediaImages();
        
        // Associer l'instance Quill au modal
        this.imageModal.quillInstance = quillInstance;
        
        if (typeof bootstrap !== 'undefined') {
            const modal = new bootstrap.Modal(this.imageModal);
            modal.show();
        } else {
            this.imageModal.style.display = 'block';
            this.imageModal.classList.add('show');
        }
    }

    createImageModal() {
        // Supprimer le modal existant
        const existingModal = document.getElementById('advancedImageModal');
        if (existingModal) {
            existingModal.remove();
        }

        const modalHTML = `
            <div class="modal fade" id="advancedImageModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-images me-2"></i>Inserer une image
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-body">
                            <!-- Selection de taille -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Taille d'insertion :</label>
                                <div class="btn-group w-100" role="group">
                                    ${Object.entries(this.imageSizeOptions).map(([size, config]) => `
                                        <input type="radio" class="btn-check" name="imageSize" id="size-${size}" 
                                               ${this.selectedImageSize === size ? 'checked' : ''}>
                                        <label class="btn btn-outline-primary" for="size-${size}">
                                            ${config.label}
                                        </label>
                                    `).join('')}
                                </div>
                            </div>

                            <!-- Recherche -->
                            <div class="mb-3">
                                <input type="text" id="imageSearchInput" class="form-control" 
                                       placeholder="Rechercher une image...">
                            </div>

                            <!-- Grille d'images -->
                            <div id="imageGrid" class="row g-3" style="max-height: 400px; overflow-y: auto;">
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
        this.imageModal = document.getElementById('advancedImageModal');
        
        // evenements
        this.setupModalEvents();
    }

    setupModalEvents() {
        // Selection de taille
        const sizeInputs = this.imageModal.querySelectorAll('input[name="imageSize"]');
        sizeInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.selectedImageSize = e.target.id.replace('size-', '');
                this.updateImagePreviews();
            });
        });

        // Recherche
        const searchInput = this.imageModal.querySelector('#imageSearchInput');
        searchInput.addEventListener('input', (e) => {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.filterImages(e.target.value);
            }, 300);
        });
    }






async loadMediaImages() {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        const response = await fetch('/admin/media-api', {
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`Erreur ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('Donnees API reçues:', data); // Debug
        
        this.renderImages(data.data || []);
    } catch (error) {
        console.error('Erreur lors du chargement des medias:', error);
        this.showImageError(error.message);
    }
}

renderImages(images) {
    const grid = this.imageModal.querySelector('#imageGrid');
    
    if (!grid) {
        console.error('Grid element not found');
        return;
    }
    
    grid.innerHTML = '';
    
    if (!images || images.length === 0) {
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
    
    images.forEach(image => {
        console.log('Traitement de l\'image:', image); // Debug
        
        // Construire l'URL correctement selon votre modele Media
        let imageUrl = '';
        if (image.url) {
            imageUrl = image.url;
        } else if (image.path) {
            imageUrl = `/storage/${image.path}`;
        } else {
            console.warn('Aucune URL trouvee pour:', image);
            return;
        }
        
        const imageName = image.name || image.original_name || 'Sans nom';
        
        console.log(`Image: ${imageName}, URL construite: ${imageUrl}`); // Debug
        
        const col = document.createElement('div');
        col.className = 'col-md-3 col-sm-4 col-6 image-item';
        col.setAttribute('data-name', imageName.toLowerCase());
        
        col.innerHTML = `
            <div class="card h-100 hover-lift" style="cursor: pointer;" data-image-url="${imageUrl}">
                <div class="card-img-top" style="height: 120px; overflow: hidden;">
                    <img src="${imageUrl}" alt="${imageName}" 
                         class="img-fluid w-100 h-100" style="object-fit: cover;"
                         onload="console.log('Image chargee:', this.src)"
                         onerror="console.error('Erreur chargement image:', this.src); this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIiBmb250LXNpemU9IjEyIiBmaWxsPSIjOTk5Ij5Erreur<L3RleHQ+PC9zdmc+';">
                </div>
                <div class="card-body p-2">
                    <p class="card-text small text-truncate mb-1" title="${imageName}">
                        ${imageName}
                    </p>
                    <small class="text-muted size-preview">
                        Sera inseree en ${this.imageSizeOptions[this.selectedImageSize].label.toLowerCase()}
                    </small>
                </div>
            </div>
        `;
        
        // Ajouter l'evenement de clic
        col.addEventListener('click', () => {
            console.log('Insertion image URL:', imageUrl);
            this.insertImage(imageUrl, imageName);
        });
        
        grid.appendChild(col);
    });
    
    // Ajouter les evenements de recherche
    const searchInput = this.imageModal.querySelector('#imageSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.filterImages(e.target.value);
            }, 300);
        });
    }
}




    insertImage(imageUrl, altText = '') {
        const quill = this.imageModal.quillInstance;
        if (!quill) return;

        const range = quill.getSelection() || { index: quill.getLength() };
        const sizeConfig = this.imageSizeOptions[this.selectedImageSize];
        
        // Inserer l'image
        quill.insertEmbed(range.index, 'image', imageUrl);
        
        // Appliquer les styles responsifs
        setTimeout(() => {
            const imgElement = quill.root.querySelector(`img[src="${imageUrl}"]`);
            if (imgElement) {
                imgElement.setAttribute('alt', altText || 'Image inseree');
                imgElement.style.width = sizeConfig.width;
                imgElement.style.maxWidth = sizeConfig.maxWidth;
                this.applyResponsiveStyles(imgElement);
                
                imgElement.addEventListener('click', () => {
                    this.showImageResizeOptions(imgElement);
                });
            }
        }, 100);
        
        // Deplacer le curseur
        quill.setSelection(range.index + 1);
        
        // Fermer le modal
        this.closeImageModal();
    }

    showImageResizeOptions(imgElement) {
        // Supprimer les contrôles existants
        document.querySelectorAll('.image-resize-control').forEach(el => el.remove());
        
        const resizeControl = document.createElement('div');
        resizeControl.className = 'image-resize-control';
        resizeControl.style.cssText = `
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        `;
        
        Object.entries(this.imageSizeOptions).forEach(([size, config]) => {
            const btn = document.createElement('button');
            btn.textContent = config.label.split(' ')[0];
            btn.style.cssText = `
                padding: 4px 8px;
                border: 1px solid #ddd;
                background: #f8f9fa;
                cursor: pointer;
                font-size: 11px;
                border-radius: 2px;
            `;
            btn.addEventListener('click', () => {
                imgElement.style.width = config.width;
                imgElement.style.maxWidth = config.maxWidth;
                resizeControl.remove();
            });
            resizeControl.appendChild(btn);
        });
        
        // Positionner
        const rect = imgElement.getBoundingClientRect();
        resizeControl.style.left = rect.left + 'px';
        resizeControl.style.top = (rect.bottom + 5) + 'px';
        document.body.appendChild(resizeControl);
        
        // Supprimer en cliquant ailleurs
        setTimeout(() => {
            const removeControl = (e) => {
                if (!resizeControl.contains(e.target) && e.target !== imgElement) {
                    resizeControl.remove();
                    document.removeEventListener('click', removeControl);
                }
            };
            document.addEventListener('click', removeControl);
        }, 100);
    }

    updateImagePreviews() {
        const previews = this.imageModal.querySelectorAll('.size-preview');
        previews.forEach(preview => {
            preview.textContent = `Sera inseree en ${this.imageSizeOptions[this.selectedImageSize].label.toLowerCase()}`;
        });
    }

    filterImages(searchTerm) {
        const items = this.imageModal.querySelectorAll('.image-item');
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            if (name.includes(searchTerm.toLowerCase())) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    showImageError(message) {
        const grid = this.imageModal.querySelector('#imageGrid');
        grid.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Erreur: ${message}
                </div>
            </div>
        `;
    }

    closeImageModal() {
        if (typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getInstance(this.imageModal);
            if (modal) modal.hide();
        } else {
            this.imageModal.style.display = 'none';
            this.imageModal.classList.remove('show');
        }
    }
}

// Instance globale
const quillManager = new QuillMediaManager();

// Fonctions publiques
function initQuillEditor(selector, textareaId) {
    return quillManager.initQuillEditor(selector, textareaId);
}

function openMediaSelectorForImageField() {
    const imageUrl = prompt('Entrez l\'URL de l\'image:');
    if (imageUrl) {
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.value = imageUrl;
            imageInput.dispatchEvent(new Event('input'));
        }
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        if (document.getElementById('intro-editor')) {
            initQuillEditor('#intro-editor', 'intro');
        }
        if (document.getElementById('content-editor')) {
            initQuillEditor('#content-editor', 'content');
        }
    }, 100);
});