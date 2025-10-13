// Variables globales
let currentEbookPage = 1;
let selectedEbookFileId = null;

/**
 * Ouvrir le sélecteur de fichiers eBook
 */
function openEbookFileSelector() {
    const modal = new bootstrap.Modal(document.getElementById('ebookFileSelectorModal'));
    modal.show();
    
    // Charger les fichiers
    loadEbookFiles();
}

/**
 * Charger les fichiers eBook
 */
async function loadEbookFiles(page = 1) {
    const grid = document.getElementById('ebookFilesGrid');
    const loading = document.getElementById('ebookFilesLoading');
    const noResults = document.getElementById('noEbookFilesFound');
    
    // Afficher loading
    grid.classList.add('d-none');
    noResults.classList.add('d-none');
    loading.classList.remove('d-none');
    
    try {
        const search = document.getElementById('ebookSearchInput').value;
        const format = document.getElementById('ebookFormatFilter').value;
        
        const params = new URLSearchParams({
            page: page,
            search: search,
            format: format
        });
        
        const response = await fetch(`/admin/ebook-files/api/files?${params}`);
        const result = await response.json();
        
        loading.classList.add('d-none');
        
        if (result.data.length === 0) {
            noResults.classList.remove('d-none');
            return;
        }
        
        // Afficher les fichiers
        grid.innerHTML = '';
        grid.classList.remove('d-none');
        
        result.data.forEach(file => {
            const col = document.createElement('div');
            col.className = 'col-md-3 col-sm-6';
            
            const isSelected = selectedEbookFileId === file.id;
            
            col.innerHTML = `
                <div class="card h-100 ebook-file-item ${isSelected ? 'border-primary selected' : ''}" 
                     style="cursor: pointer;"
                     onclick="selectEbookFile(${file.id}, '${escapeHtml(file.name)}', '${file.formatted_size}', '${file.format_label}', '${file.icon}')">
                    <div class="card-body text-center">
                        <i class="fas ${file.icon} fa-3x text-primary mb-3"></i>
                        <h6 class="card-title mb-2">${escapeHtml(file.name)}</h6>
                        <div class="mb-2">
                            <span class="badge bg-secondary">${file.format_label}</span>
                        </div>
                        <small class="text-muted d-block">${file.formatted_size}</small>
                        <small class="text-muted d-block">${file.original_name}</small>
                        ${file.description ? `<small class="text-muted d-block mt-2">${escapeHtml(file.description)}</small>` : ''}
                        ${isSelected ? '<div class="mt-2"><i class="fas fa-check-circle text-primary"></i> Sélectionné</div>' : ''}
                    </div>
                </div>
            `;
            
            grid.appendChild(col);
        });
        
        // Pagination
        renderEbookFilesPagination(result.current_page, result.last_page);
        
    } catch (error) {
        console.error('Erreur chargement fichiers eBook:', error);
        loading.classList.add('d-none');
        noResults.classList.remove('d-none');
    }
}

/**
 * Sélectionner un fichier eBook
 */
function selectEbookFile(id, name, size, formatLabel, icon) {
    selectedEbookFileId = id;
    
    // Mettre à jour le champ caché
    document.getElementById('ebook_file_id').value = id;
    
    // Mettre à jour l'aperçu
    document.getElementById('ebook_icon').className = `fas ${icon} fa-2x text-primary me-3`;
    document.getElementById('ebook_name').textContent = name;
    document.getElementById('ebook_info').textContent = `${size} • ${formatLabel}`;
    
    document.getElementById('selected_ebook_preview').classList.remove('d-none');
    document.getElementById('no_ebook_selected').classList.add('d-none');
    
    // Fermer la modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('ebookFileSelectorModal'));
    modal.hide();
    
    // Mettre en surbrillance dans la grille
    document.querySelectorAll('.ebook-file-item').forEach(item => {
        item.classList.remove('border-primary', 'selected');
    });
    event.currentTarget.classList.add('border-primary', 'selected');
}

/**
 * Effacer la sélection
 */
function clearSelectedEbookFile() {
    selectedEbookFileId = null;
    document.getElementById('ebook_file_id').value = '';
    document.getElementById('selected_ebook_preview').classList.add('d-none');
    document.getElementById('no_ebook_selected').classList.remove('d-none');
}

/**
 * Rechercher des fichiers
 */
function searchEbookFiles() {
    currentEbookPage = 1;
    loadEbookFiles(1);
}

/**
 * Pagination
 */
function renderEbookFilesPagination(currentPage, lastPage) {
    const container = document.getElementById('ebookFilesPagination');
    
    if (lastPage <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let html = '<nav><ul class="pagination">';
    
    // Bouton précédent
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadEbookFiles(${currentPage - 1}); return false;">
            Précédent
        </a>
    </li>`;
    
    // Pages
    for (let i = 1; i <= lastPage; i++) {
        if (i === 1 || i === lastPage || (i >= currentPage - 2 && i <= currentPage + 2)) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadEbookFiles(${i}); return false;">${i}</a>
            </li>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    // Bouton suivant
    html += `<li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadEbookFiles(${currentPage + 1}); return false;">
            Suivant
        </a>
    </li>`;
    
    html += '</ul></nav>';
    container.innerHTML = html;
}

/**
 * Toggle entre upload et existing
 */
function selectFileSource(source) {
    // Mettre à jour les radio buttons
    document.getElementById('file_source_upload').checked = (source === 'upload');
    document.getElementById('file_source_existing').checked = (source === 'existing');
    
    // Mettre à jour les cartes
    document.querySelectorAll('.source-card').forEach(card => {
        card.classList.remove('border-primary', 'selected');
    });
    event.currentTarget.classList.add('border-primary', 'selected');
    
    // Afficher/masquer les sections
    const uploadSection = document.getElementById('upload_section');
    const existingSection = document.getElementById('existing_section');
    
    if (source === 'upload') {
        uploadSection.style.display = 'block';
        existingSection.style.display = 'none';
        
        // Effacer ebook_file_id
        document.getElementById('ebook_file_id').value = '';
    } else {
        uploadSection.style.display = 'none';
        existingSection.style.display = 'block';
        
        // Effacer le file input
        const fileInput = document.getElementById('file');
        if (fileInput) fileInput.value = '';
    }
}

/**
 * Échapper HTML pour éviter XSS
 */
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Recherche en temps réel
    const searchInput = document.getElementById('ebookSearchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchEbookFiles();
            }, 500);
        });
    }
    
    // Filtre format
    const formatFilter = document.getElementById('ebookFormatFilter');
    if (formatFilter) {
        formatFilter.addEventListener('change', searchEbookFiles);
    }
});