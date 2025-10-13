<!-- Modal Upload Fichiers eBooks -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-upload me-2"></i>Uploader des fichiers eBooks
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('admin.ebook-files.store') }}" method="POST" enctype="multipart/form-data" id="ebookUploadForm">
                @csrf
                <div class="modal-body">
                    <!-- Zone de drop -->
                    <div class="upload-zone border-2 border-dashed border-primary rounded-3 p-5 text-center mb-4" 
                         id="ebookUploadZone">
                        <div class="upload-zone-content">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                            <h5 class="text-primary">Glissez-déposez vos fichiers ici</h5>
                            <p class="text-muted mb-3">ou cliquez pour sélectionner</p>
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('ebookFileInput').click()">
                                <i class="fas fa-folder-open me-2"></i>Parcourir les fichiers
                            </button>
                            <input type="file" 
                                   id="ebookFileInput" 
                                   name="files[]" 
                                   multiple 
                                   accept=".pdf,.epub,.mp4,.zip,.doc,.docx"
                                   style="display: none;"
                                   onchange="handleEbookFileSelect(this.files)">
                        </div>
                    </div>

                    <!-- Informations format -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Formats acceptés :</strong> PDF, EPUB, MP4, ZIP, DOC, DOCX •
                        <strong>Taille max :</strong> 200 MB par fichier
                    </div>

                    <!-- Prévisualisation des fichiers -->
                    <div id="ebookFilePreview" class="d-none">
                        <h6 class="fw-semibold mb-3">Fichiers sélectionnés</h6>
                        <div id="ebookPreviewContainer"></div>
                    </div>

                    <!-- Barre de progression -->
                    <div id="ebookUploadProgress" class="d-none mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-semibold">Upload en cours...</span>
                            <span id="ebookProgressText">0%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 id="ebookProgressBar" 
                                 style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" id="ebookUploadBtn" disabled>
                        <i class="fas fa-upload me-2"></i>Uploader <span id="ebookFileCount">0</span> fichier(s)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let ebookFilesToUpload = [];

// Gestion du drag & drop
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('ebookUploadZone');
    
    if (uploadZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, unhighlight, false);
        });
        
        uploadZone.addEventListener('drop', handleEbookDrop, false);
    }
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    document.getElementById('ebookUploadZone').classList.add('border-success', 'bg-light');
}

function unhighlight(e) {
    document.getElementById('ebookUploadZone').classList.remove('border-success', 'bg-light');
}

function handleEbookDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    handleEbookFileSelect(files);
}

function handleEbookFileSelect(files) {
    if (files.length === 0) return;
    
    ebookFilesToUpload = Array.from(files);
    displayEbookFilePreview();
    
    document.getElementById('ebookUploadBtn').disabled = false;
    document.getElementById('ebookFileCount').textContent = files.length;
}

function displayEbookFilePreview() {
    const previewContainer = document.getElementById('ebookPreviewContainer');
    const previewSection = document.getElementById('ebookFilePreview');
    
    previewContainer.innerHTML = '';
    
    ebookFilesToUpload.forEach((file, index) => {
        const fileExt = file.name.split('.').pop().toLowerCase();
        const icon = getEbookFileIcon(fileExt);
        const fileSize = formatBytes(file.size);
        
        const fileCard = document.createElement('div');
        fileCard.className = 'card mb-3';
        fileCard.innerHTML = `
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fas ${icon} fa-2x text-primary"></i>
                    </div>
                    <div class="col">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Nom d'affichage (optionnel)</label>
                                <input type="text" 
                                       name="names[${index}]" 
                                       class="form-control form-control-sm"
                                       placeholder="${file.name}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Description (optionnel)</label>
                                <input type="text" 
                                       name="descriptions[${index}]" 
                                       class="form-control form-control-sm"
                                       placeholder="Description du fichier">
                            </div>
                        </div>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-file me-1"></i>${file.name} 
                            <span class="ms-2"><i class="fas fa-hdd me-1"></i>${fileSize}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger"
                                onclick="removeEbookFile(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        previewContainer.appendChild(fileCard);
    });
    
    previewSection.classList.remove('d-none');
}

function removeEbookFile(index) {
    ebookFilesToUpload.splice(index, 1);
    
    if (ebookFilesToUpload.length === 0) {
        document.getElementById('ebookFilePreview').classList.add('d-none');
        document.getElementById('ebookUploadBtn').disabled = true;
        document.getElementById('ebookFileInput').value = '';
    } else {
        displayEbookFilePreview();
    }
    
    document.getElementById('ebookFileCount').textContent = ebookFilesToUpload.length;
}

function getEbookFileIcon(extension) {
    const icons = {
        'pdf': 'fa-file-pdf',
        'epub': 'fa-book',
        'mp4': 'fa-file-video',
        'zip': 'fa-file-archive',
        'doc': 'fa-file-word',
        'docx': 'fa-file-word'
    };
    return icons[extension] || 'fa-file';
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
@endpush

@push('styles')
<style>
.upload-zone {
    position: relative;
    transition: all 0.3s ease;
}

.upload-zone.border-success {
    background-color: rgba(16, 185, 129, 0.1) !important;
}
</style>
@endpush