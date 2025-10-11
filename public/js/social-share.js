/**
 * Bandeau de partage social sticky
 */
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('socialShareToggle');
    const buttons = document.getElementById('socialShareButtons');
    const closeBtn = document.getElementById('socialShareClose');
    const copyBtn = document.getElementById('copyLinkBtn');
    
    // URL et titre de la page actuelle
    const currentUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent(document.title);
    const pageDescription = encodeURIComponent(
        document.querySelector('meta[name="description"]')?.content || ''
    );
    
    // Toggle l'affichage des boutons
    if (toggle) {
        toggle.addEventListener('click', function() {
            buttons.classList.toggle('active');
        });
    }
    
    // Fermer les boutons
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            buttons.classList.remove('active');
        });
    }
    
    // Fermer en cliquant en dehors
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.social-share-sticky')) {
            buttons.classList.remove('active');
        }
    });
    
    // Configurer les liens de partage
    const shareLinks = {
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${currentUrl}`,
        twitter: `https://twitter.com/intent/tweet?url=${currentUrl}&text=${pageTitle}`,
        linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${currentUrl}`,
        whatsapp: `https://wa.me/?text=${pageTitle}%20${currentUrl}`,
        email: `mailto:?subject=${pageTitle}&body=${pageDescription}%0A%0A${currentUrl}`
    };
    
    // Appliquer les liens
    document.querySelectorAll('[data-network]').forEach(function(link) {
        const network = link.getAttribute('data-network');
        if (shareLinks[network]) {
            link.href = shareLinks[network];
        }
    });
    
    // Copier le lien
    if (copyBtn) {
        copyBtn.addEventListener('click', async function() {
            try {
                await navigator.clipboard.writeText(window.location.href);
                
                // Feedback visuel
                copyBtn.classList.add('copied');
                const originalText = copyBtn.querySelector('span').textContent;
                copyBtn.querySelector('span').textContent = 'Copié !';
                
                setTimeout(function() {
                    copyBtn.classList.remove('copied');
                    copyBtn.querySelector('span').textContent = originalText;
                }, 2000);
                
            } catch (err) {
                console.error('Erreur lors de la copie :', err);
                // Fallback pour les navigateurs plus anciens
                const textArea = document.createElement('textarea');
                textArea.value = window.location.href;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                copyBtn.classList.add('copied');
                setTimeout(() => copyBtn.classList.remove('copied'), 2000);
            }
        });
    }
    
    // Analytics (optionnel)
    document.querySelectorAll('.social-share-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const network = this.getAttribute('data-network') || 'copy';
            console.log('Partage sur:', network);
            
            // Intégration Google Analytics si présent
            if (typeof gtag !== 'undefined') {
                gtag('event', 'share', {
                    'method': network,
                    'content_type': 'page',
                    'item_id': window.location.pathname
                });
            }
        });
    });
});