// Gestion des confirmations de suppression
document.addEventListener('DOMContentLoaded', function() {
    // Confirmation de suppression
    document.querySelectorAll('[data-confirm="delete"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Êtes-vous sûr de vouloir supprimer cet element ? Cette action est irreversible.')) {
                if (this.tagName === 'BUTTON' && this.closest('form')) {
                    this.closest('form').submit();
                } else if (this.tagName === 'A') {
                    window.location.href = this.href;
                }
            }
        });
    });
    
    // Auto-generation des slugs
    const nameInputs = document.querySelectorAll('input[name="name"]');
    const slugInputs = document.querySelectorAll('input[name="slug"]');
    
    nameInputs.forEach((nameInput, index) => {
        if (slugInputs[index]) {
            nameInput.addEventListener('input', function() {
                if (!slugInputs[index].value || slugInputs[index].dataset.autoGenerate !== 'false') {
                    slugInputs[index].value = generateSlug(this.value);
                }
            });
            
            slugInputs[index].addEventListener('input', function() {
                this.dataset.autoGenerate = 'false';
            });
        }
    });
    
    // Previsualisation d'images
    document.querySelectorAll('input[name="image"]').forEach(input => {
        input.addEventListener('input', function() {
            const previewContainer = this.closest('.form-group')?.querySelector('.image-preview');
            if (previewContainer && this.value) {
                previewContainer.innerHTML = `
                    <img src="${this.value}" class="img-thumbnail mt-2" style="max-width: 200px; max-height: 150px;">
                `;
            }
        });
    });
    
    // Sauvegarde automatique des brouillons
    const contentTextareas = document.querySelectorAll('textarea[name="content"]');
    contentTextareas.forEach(textarea => {
        let saveTimeout;
        textarea.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                saveDraft(this);
            }, 2000);
        });
    });
    
    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl+S pour sauvegarder
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const saveButton = document.querySelector('button[type="submit"]');
            if (saveButton) {
                saveButton.click();
            }
        }
        
        // Ctrl+N pour nouveau
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            const newButton = document.querySelector('a[href*="create"]');
            if (newButton) {
                window.location.href = newButton.href;
            }
        }
    });
    
    // Notifications toast
    initializeToasts();
    
    // Tables responsives ameliorees
    enhanceResponsiveTables();
    
    // Filtres en temps reel
    initializeLiveFilters();
});

// Fonction de generation de slug
function generateSlug(text) {
    return text
        .toLowerCase()
        .trim()
        .replace(/[Ãáâãäå]/g, 'a')
        .replace(/[eeêë]/g, 'e')
        .replace(/[ìíîï]/g, 'i')
        .replace(/[òóôõö]/g, 'o')
        .replace(/[ùúûü]/g, 'u')
        .replace(/[ç]/g, 'c')
        .replace(/[ñ]/g, 'n')
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
}

// Sauvegarde automatique des brouillons
function saveDraft(textarea) {
    const formData = new FormData();
    formData.append('content', textarea.value);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
    const draftKey = `draft_${window.location.pathname}`;
    localStorage.setItem(draftKey, textarea.value);
    
    // Afficher un indicateur de sauvegarde
    showSaveIndicator();
}

// Indicateur de sauvegarde
function showSaveIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'position-fixed top-0 end-0 m-3 alert alert-success alert-dismissible fade show';
    indicator.innerHTML = `
        <i class="fas fa-check me-2"></i>Brouillon sauvegarde
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(indicator);
    
    setTimeout(() => {
        indicator.remove();
    }, 3000);
}

// Initialisation des toasts
function initializeToasts() {
    const toastElements = document.querySelectorAll('.toast');
    toastElements.forEach(toastEl => {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
}

// Tables responsives ameliorees
function enhanceResponsiveTables() {
    const tables = document.querySelectorAll('.table-responsive-stack table');
    tables.forEach(table => {
        const headers = table.querySelectorAll('thead th');
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    cell.setAttribute('data-label', headers[index].textContent.trim());
                }
            });
        });
    });
}

// Filtres en temps reel
function initializeLiveFilters() {
    const searchInputs = document.querySelectorAll('input[name="search"]');
    searchInputs.forEach(input => {
        let searchTimeout;
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterTable(this.value);
            }, 300);
        });
    });
}

// Filtrage des tables
function filterTable(searchTerm) {
    const tables = document.querySelectorAll('.table tbody');
    tables.forEach(tbody => {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm.toLowerCase()) ? '' : 'none';
        });
    });
}

// Upload de fichiers avec previsualisation
function initializeFileUploads() {
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'img-thumbnail mt-2';
                    preview.style.maxWidth = '200px';
                    preview.style.maxHeight = '150px';
                    
                    const existingPreview = input.parentNode.querySelector('.img-thumbnail');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    input.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// Gestion des modals dynamiques
function openModal(modalId, data = {}) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Remplir les champs avec les donnees
        Object.keys(data).forEach(key => {
            const field = modal.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        });
        
        new bootstrap.Modal(modal).show();
    }
}

// Export des donnees
function exportData(format, endpoint) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = endpoint;
    form.style.display = 'none';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
    
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'format';
    formatInput.value = format;
    
    form.appendChild(csrfToken);
    form.appendChild(formatInput);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Validation côte client amelioree
function initializeFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'Ce champ est requis');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    // Validation des emails
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Format d\'email invalide');
            isValid = false;
        }
    });
    
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    field.classList.add('is-invalid');
    
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.textContent = message;
    field.parentNode.appendChild(feedback);
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    const existingFeedback = field.parentNode.querySelector('.invalid-feedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Theme sombre/clair
function initializeThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Mettre Ã jour l'icône
            const icon = this.querySelector('i');
            icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        });
        
        // Charger le theme sauvegarde
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    }
}

// Initialisation globale
document.addEventListener('DOMContentLoaded', function() {
    initializeFileUploads();
    initializeFormValidation();
    initializeThemeToggle();
});