/**
 * ========================================
 * QUILL AI OPTIMIZER
 * Optimisation de contenu avec IA pour Laravel 12
 * ========================================
 */

(function() {
    'use strict';
    
    console.log('🤖 Quill AI Optimizer - Chargement...');
    
    let debugMode = true;
    
    // Fonction de debug
    function debugLog(message, data = null) {
        if (debugMode) {
            console.log('🤖 AI Optimizer:', message, data || '');
        }
    }
    
    /**
     * Afficher le menu IA pour le contenu sélectionné
     */
    function showAIMenu(quillInstance) {
        if (!quillInstance) {
            showNotification('Éditeur non trouvé', 'error');
            return;
        }
        
        const selectedContent = quillInstance.getSelection();
        if (!selectedContent || selectedContent.length === 0) {
            showNotification('Sélectionnez du texte à optimiser', 'warning');
            return;
        }
        
        const selectedText = quillInstance.getText(selectedContent.index, selectedContent.length);
        
        if (!selectedText || selectedText.trim() === '') {
            showNotification('Sélectionnez du texte à optimiser', 'warning');
            return;
        }
        
        debugLog('Affichage du menu IA', { text: selectedText });
        
        // Supprimer menu existant
        const existingMenu = document.getElementById('ai-text-menu');
        if (existingMenu) {
            existingMenu.remove();
        }
        
        // Créer le menu
        const menu = document.createElement('div');
        menu.id = 'ai-text-menu';
        menu.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border: 2px solid #0ea5e9;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            z-index: 999999;
            min-width: 340px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
        `;
        
        menu.innerHTML = `
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb; font-weight: 600; background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%); color: white; border-radius: 6px 6px 0 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-robot" style="font-size: 20px;"></i>
                <span>Optimiser avec l'IA</span>
            </div>
            <div class="ai-menu-item" data-action="optimize" style="padding: 14px 20px; cursor: pointer; border-bottom: 1px solid #e5e7eb; transition: all 0.2s; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-magic" style="color: #0ea5e9; width: 20px;"></i>
                <div>
                    <div style="font-weight: 500;">Optimiser (SEO + Style)</div>
                    <small style="color: #6b7280;">Correction + amélioration globale</small>
                </div>
            </div>
            <div class="ai-menu-item" data-action="correct" style="padding: 14px 20px; cursor: pointer; border-bottom: 1px solid #e5e7eb; transition: all 0.2s; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-spell-check" style="color: #10b981; width: 20px;"></i>
                <div>
                    <div style="font-weight: 500;">Corriger les fautes</div>
                    <small style="color: #6b7280;">Orthographe et grammaire</small>
                </div>
            </div>
            <div class="ai-menu-item" data-action="enrich" style="padding: 14px 20px; cursor: pointer; border-bottom: 1px solid #e5e7eb; transition: all 0.2s; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-expand-alt" style="color: #f59e0b; width: 20px;"></i>
                <div>
                    <div style="font-weight: 500;">Enrichir le contenu</div>
                    <small style="color: #6b7280;">Ajouter détails et exemples</small>
                </div>
            </div>
            <div class="ai-menu-item" data-action="create_content" style="padding: 14px 20px; cursor: pointer; border-bottom: 1px solid #e5e7eb; transition: all 0.2s; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-file-alt" style="color: #8b5cf6; width: 20px;"></i>
                <div>
                    <div style="font-weight: 500;">Créer du contenu web</div>
                    <small style="color: #6b7280;">Générer article complet</small>
                </div>
            </div>
            <div style="padding: 14px 20px; text-align: center; background: #f9fafb; border-radius: 0 0 6px 6px;">
                <button id="ai-close-menu" style="padding: 8px 16px; background: #6b7280; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.2s;">
                    <i class="fas fa-times me-1"></i>Annuler
                </button>
            </div>
        `;
        
        document.body.appendChild(menu);
        
        // Gérer les clics sur les options
        const menuItems = menu.querySelectorAll('.ai-menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                menu.remove();
                processAIText(action, quillInstance, selectedText, selectedContent);
            });
            
            // Effets hover
            item.addEventListener('mouseenter', function() {
                this.style.background = '#f0f9ff';
            });
            item.addEventListener('mouseleave', function() {
                this.style.background = 'white';
            });
        });
        
        // Bouton fermer
        const closeBtn = menu.querySelector('#ai-close-menu');
        closeBtn.addEventListener('click', function() {
            menu.remove();
        });
        
        closeBtn.addEventListener('mouseenter', function() {
            this.style.background = '#4b5563';
        });
        closeBtn.addEventListener('mouseleave', function() {
            this.style.background = '#6b7280';
        });
        
        // Fermer en cliquant à côté
        setTimeout(() => {
            document.addEventListener('click', function closeMenu(e) {
                if (!menu.contains(e.target)) {
                    menu.remove();
                    document.removeEventListener('click', closeMenu);
                }
            });
        }, 100);
    }
    
    /**
     * Traiter le texte avec l'IA
     */
    function processAIText(actionType, quillInstance, selectedText, selection) {
        debugLog('Traitement IA:', actionType);
        
        showNotification('Traitement en cours...', 'info');
        
        // Récupérer le titre si disponible
        const titleField = document.getElementById('title') || 
                          document.getElementById('name') || 
                          document.getElementById('titre');
        const title = titleField ? titleField.value : '';
        
        // Préparer les données
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/admin/aitext/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                content: selectedText,
                action_type: actionType,
                title: title
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.content) {
                if (actionType === 'create_content') {
                    showContentPreview(quillInstance, data.content, selection);
                } else {
                    // Remplacer le texte sélectionné
                    quillInstance.deleteText(selection.index, selection.length);
                    quillInstance.clipboard.dangerouslyPasteHTML(selection.index, data.content);
                    showNotification('✅ Contenu optimisé avec succès !', 'success');
                }
            } else {
                showNotification('❌ ' + (data.message || 'Erreur lors du traitement'), 'error');
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            showNotification('❌ Erreur de connexion au serveur', 'error');
        });
    }
    
    /**
     * Prévisualisation du contenu créé
     */
    function showContentPreview(quillInstance, content, selection) {
        const modal = document.createElement('div');
        modal.id = 'ai-content-preview-modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        `;
        
        modal.innerHTML = `
            <div style="
                background: white;
                border-radius: 12px;
                padding: 0;
                max-width: 90%;
                max-height: 90%;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0,0,0,0.4);
                display: flex;
                flex-direction: column;
            ">
                <div style="padding: 24px; border-bottom: 1px solid #e5e7eb; background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%); color: white;">
                    <h3 style="margin: 0; font-size: 20px; font-weight: 600;">
                        <i class="fas fa-eye me-2"></i>Prévisualisation du contenu généré
                    </h3>
                </div>
                <div style="
                    border: 1px solid #e5e7eb;
                    padding: 24px;
                    margin: 24px;
                    overflow-y: auto;
                    flex: 1;
                    background: #f9fafb;
                    border-radius: 8px;
                    max-height: 500px;
                ">${content}</div>
                <div style="padding: 20px 24px; text-align: right; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; gap: 12px; justify-content: flex-end;">
                    <button id="ai-preview-cancel" style="
                        padding: 10px 20px;
                        background: #6b7280;
                        color: white;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                        font-weight: 500;
                        transition: all 0.2s;
                    ">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button id="ai-preview-insert" style="
                        padding: 10px 20px;
                        background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
                        color: white;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                        font-weight: 500;
                        transition: all 0.2s;
                    ">
                        <i class="fas fa-check me-2"></i>Insérer le contenu
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Bouton insérer
        modal.querySelector('#ai-preview-insert').addEventListener('click', function() {
            quillInstance.deleteText(selection.index, selection.length);
            quillInstance.clipboard.dangerouslyPasteHTML(selection.index, content);
            modal.remove();
            showNotification('✅ Contenu inséré avec succès !', 'success');
        });
        
        // Bouton annuler
        modal.querySelector('#ai-preview-cancel').addEventListener('click', function() {
            modal.remove();
        });
        
        // Effets hover
        const insertBtn = modal.querySelector('#ai-preview-insert');
        insertBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(14, 165, 233, 0.4)';
        });
        insertBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        
        const cancelBtn = modal.querySelector('#ai-preview-cancel');
        cancelBtn.addEventListener('mouseenter', function() {
            this.style.background = '#4b5563';
        });
        cancelBtn.addEventListener('mouseleave', function() {
            this.style.background = '#6b7280';
        });
        
        // Fermer en cliquant sur le fond
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
    
    /**
     * Ajouter le bouton IA à la toolbar Quill
     */
    function addAIButtonToQuill(quillInstance, editorId) {
        const toolbar = document.querySelector(`#${editorId}`).previousElementSibling;
        
        if (!toolbar || toolbar.querySelector('.ai-optimize-btn')) {
            return; // Déjà ajouté
        }
        
        const aiButton = document.createElement('button');
        aiButton.type = 'button';
        aiButton.className = 'ai-optimize-btn ql-ai-optimize';
        aiButton.innerHTML = '<i class="fas fa-robot"></i> IA';
        aiButton.title = 'Optimiser avec l\'IA';
        aiButton.style.cssText = `
            background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
            color: white;
            border: none;
            padding: 6px 12px;
            margin: 0 4px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        `;
        
        aiButton.addEventListener('click', function(e) {
            e.preventDefault();
            showAIMenu(quillInstance);
        });
        
        aiButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(14, 165, 233, 0.4)';
        });
        
        aiButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        
        // Ajouter à la fin de la toolbar
        const toolbarContainer = toolbar.querySelector('.ql-formats:last-child') || toolbar;
        toolbarContainer.appendChild(aiButton);
        
        debugLog('Bouton IA ajouté à:', editorId);
    }
    
    /**
     * Système de notifications
     */
    function showNotification(message, type = 'info') {
        // Supprimer notifications existantes
        const existing = document.querySelectorAll('.ai-notification');
        existing.forEach(el => el.remove());
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#0ea5e9'
        };
        
        const notification = document.createElement('div');
        notification.className = `ai-notification ai-notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 90px;
            right: 20px;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 999999;
            font-size: 14px;
            font-weight: 500;
            min-width: 300px;
            max-width: 500px;
            background: white;
            border-left: 4px solid ${colors[type]};
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            transition: all 0.3s ease;
            animation: slideInRight 0.3s ease;
        `;
        
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas ${icons[type]}" style="color: ${colors[type]}; font-size: 20px;"></i>
                <div style="flex: 1; color: #1f2937;">${message}</div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-suppression
        const duration = type === 'error' ? 8000 : 4000;
        setTimeout(function() {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, duration);
        
        // Clic pour fermer
        notification.style.cursor = 'pointer';
        notification.addEventListener('click', function() {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        });
    }
    
    /**
     * Optimiser le titre
     */
    window.optimizeTitle = function(titleFieldId) {
        const titleField = document.getElementById(titleFieldId);
        if (!titleField) {
            showNotification('Champ titre non trouvé', 'error');
            return;
        }
        
        const currentTitle = titleField.value.trim();
        if (!currentTitle) {
            showNotification('Veuillez saisir un titre avant de l\'optimiser', 'warning');
            return;
        }
        
        showNotification('Optimisation du titre en cours...', 'info');
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/admin/aitext/optimize-title', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title: currentTitle
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.title) {
                titleField.value = data.title;
                titleField.focus();
                showNotification('✅ Titre optimisé avec succès !', 'success');
                
                // Déclencher les événements
                ['input', 'change'].forEach(eventType => {
                    titleField.dispatchEvent(new Event(eventType, { bubbles: true }));
                });
            } else {
                showNotification('❌ ' + (data.message || 'Erreur lors de l\'optimisation'), 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('❌ Erreur de connexion', 'error');
        });
    };
    
    /**
     * Optimiser le slug
     */
    window.optimizeSlug = function(slugFieldId, titleFieldId) {
        const slugField = document.getElementById(slugFieldId);
        const titleField = document.getElementById(titleFieldId);
        
        if (!slugField || !titleField) {
            showNotification('Champs titre ou slug non trouvés', 'error');
            return;
        }
        
        const title = titleField.value.trim();
        if (!title) {
            showNotification('Veuillez saisir un titre avant d\'optimiser le slug', 'warning');
            return;
        }
        
        showNotification('Optimisation du slug en cours...', 'info');
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/admin/aitext/optimize-slug', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title: title
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.slug) {
                slugField.value = data.slug;
                slugField.focus();
                showNotification('✅ Slug optimisé avec succès !', 'success');
                
                // Déclencher les événements
                ['input', 'change'].forEach(eventType => {
                    slugField.dispatchEvent(new Event(eventType, { bubbles: true }));
                });
            } else {
                showNotification('❌ ' + (data.message || 'Erreur lors de l\'optimisation'), 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('❌ Erreur de connexion', 'error');
        });
    };
    







    /**
 * Initialisation automatique - VERSION AMÉLIORÉE
 */
window.initQuillAI = function() {
    // Attendre que Quill soit chargé
    if (typeof Quill === 'undefined') {
        console.warn('⚠️ Quill non chargé, réessai dans 500ms...');
        setTimeout(window.initQuillAI, 500);
        return;
    }
    
    debugLog('🔍 Recherche des éditeurs Quill...');
    
    // Détecter tous les éditeurs Quill existants
    const editors = document.querySelectorAll('[id$="-editor"]');
    
    editors.forEach(editor => {
        const editorId = editor.id;
        const textareaId = editorId.replace('-editor', '');
        
        debugLog('📝 Éditeur trouvé:', editorId);
        
        // Vérifier si le bouton IA existe déjà
        const toolbar = editor.previousElementSibling;
        if (toolbar && toolbar.querySelector('.ai-optimize-btn')) {
            debugLog('⏭️ Bouton IA déjà présent pour:', editorId);
            return;
        }
        
        let quillInstance = null;
        
        // MÉTHODE 1 : Essayer de récupérer depuis window.quillManager
        if (window.quillManager && window.quillManager.quillInstances) {
            quillInstance = window.quillManager.quillInstances.get(textareaId);
            if (quillInstance) {
                debugLog('✅ Instance trouvée via quillManager pour:', editorId);
            }
        }
        
        // MÉTHODE 2 : Chercher l'instance Quill directement dans le DOM
        if (!quillInstance && editor.classList.contains('ql-container')) {
            // L'éditeur Quill ajoute la classe 'ql-container' au conteneur
            const quillRoot = editor.querySelector('.ql-editor');
            if (quillRoot && quillRoot.__quill) {
                quillInstance = quillRoot.__quill;
                debugLog('✅ Instance trouvée via DOM pour:', editorId);
            }
        }
        
        // MÉTHODE 3 : Chercher via le parent
        if (!quillInstance) {
            const parent = editor.parentElement;
            if (parent && parent.__quill) {
                quillInstance = parent.__quill;
                debugLog('✅ Instance trouvée via parent pour:', editorId);
            }
        }
        
        // MÉTHODE 4 : Utiliser l'API Quill.find()
        if (!quillInstance && typeof Quill.find === 'function') {
            quillInstance = Quill.find(editor);
            if (quillInstance) {
                debugLog('✅ Instance trouvée via Quill.find() pour:', editorId);
            }
        }
        
        // Si une instance a été trouvée, ajouter le bouton IA
        if (quillInstance) {
            addAIButtonToQuill(quillInstance, editorId);
            debugLog('✅ Bouton IA ajouté pour:', editorId);
        } else {
            debugLog('❌ Aucune instance Quill trouvée pour:', editorId);
        }
    });
    
    debugLog('✅ Initialisation IA terminée');
};





    
    // Ajouter l'animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(400px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    `;
    document.head.appendChild(style);
    
    // Initialisation automatique au chargement
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', window.initQuillAI);
    } else {
        setTimeout(window.initQuillAI, 1000);
    }
    
    debugLog('✅ Module chargé avec succès');
    
})();