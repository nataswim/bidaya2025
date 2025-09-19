import 'bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

// Configuration Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF Token
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Scripts personnalisés
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Confirmation de suppression
    const deleteButtons = document.querySelectorAll('[data-confirm="delete"]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
});