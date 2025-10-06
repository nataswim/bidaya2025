@extends('layouts.admin')

@section('title', 'Configuration AI Text Optimizer')
@section('page-title', 'AI Text Optimizer')
@section('page-description', 'Configuration de l\'intelligence artificielle pour l\'optimisation de contenu')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Configuration API -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-robot me-2"></i>Configuration de l'API IA
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form id="aitext-config-form">
                        @csrf
                        
                        <!-- Provider -->
                        <div class="mb-4">
                            <label for="provider" class="form-label fw-semibold">Fournisseur d'API *</label>
                            <select id="provider" name="provider" class="form-select" required>
                                <option value="gemini" {{ $currentConfig['provider'] === 'gemini' ? 'selected' : '' }}>
                                    🆓 Google Gemini (Gratuit)
                                </option>
                                <option value="groq" {{ $currentConfig['provider'] === 'groq' ? 'selected' : '' }}>
                                    ⚡ Groq (Gratuit + Rapide)
                                </option>
                                <option value="openai" {{ $currentConfig['provider'] === 'openai' ? 'selected' : '' }}>
                                    💰 OpenAI (Payant)
                                </option>
                                <option value="cohere" {{ $currentConfig['provider'] === 'cohere' ? 'selected' : '' }}>
                                    📝 Cohere (Gratuit)
                                </option>
                                <option value="huggingface" {{ $currentConfig['provider'] === 'huggingface' ? 'selected' : '' }}>
                                    🤗 Hugging Face (Gratuit)
                                </option>
                            </select>
                            <div class="form-text">
                                Sélectionnez votre fournisseur d'API IA
                            </div>
                        </div>

                        <!-- Modèle -->
                        <div class="mb-4">
                            <label for="model" class="form-label fw-semibold">Modèle IA *</label>
                            <select id="model" name="model" class="form-select" required>
                                @foreach($models[$currentConfig['provider']] ?? [] as $value => $label)
                                    <option value="{{ $value }}" {{ $currentConfig['model'] === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Choisissez le modèle à utiliser
                            </div>
                        </div>

                        <!-- Clé API -->
                        <div class="mb-4">
                            <label for="api_key" class="form-label fw-semibold">Clé API *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    @if($currentConfig['has_api_key'])
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    @endif
                                </span>
                                <input type="password" 
                                       id="api_key" 
                                       name="api_key"
                                       class="form-control" 
                                       value="{{ $currentConfig['api_key'] }}"
                                       placeholder="Saisissez votre clé API"
                                       required>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleApiKeyVisibility()">
                                    <i class="fas fa-eye" id="toggle-icon"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Votre clé API sera stockée de manière sécurisée dans la base de données
                            </div>
                        </div>

                        <!-- Paramètres avancés -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="temperature" class="form-label fw-semibold">Température</label>
                                <input type="number" 
                                       id="temperature" 
                                       name="temperature"
                                       class="form-control" 
                                       value="{{ $currentConfig['temperature'] }}"
                                       min="0" 
                                       max="1" 
                                       step="0.1"
                                       required>
                                <div class="form-text">Créativité (0 = conservateur, 1 = créatif)</div>
                            </div>
                            <div class="col-md-6">
                                <label for="max_tokens" class="form-label fw-semibold">Tokens maximum</label>
                                <input type="number" 
                                       id="max_tokens" 
                                       name="max_tokens"
                                       class="form-control" 
                                       value="{{ $currentConfig['max_tokens'] }}"
                                       min="100" 
                                       max="4096"
                                       required>
                                <div class="form-text">Longueur maximale de la réponse</div>
                            </div>
                        </div>

                        <!-- Bouton de sauvegarde -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Enregistrer la configuration
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Instructions -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-gradient-info text-white p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Obtenir une clé API gratuite
                    </h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Gemini :</strong> 
                            <a href="https://makersuite.google.com/app/apikey" target="_blank">
                                makersuite.google.com/app/apikey
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Groq :</strong> 
                            <a href="https://console.groq.com/keys" target="_blank">
                                console.groq.com/keys
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Cohere :</strong> 
                            <a href="https://dashboard.cohere.ai/api-keys" target="_blank">
                                dashboard.cohere.ai/api-keys
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Test et Statut -->
        <div class="col-lg-4">
            <!-- Test de connexion -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-success text-white p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-vial me-2"></i>Test de connexion
                    </h6>
                </div>
                <div class="card-body p-4">
                    <button type="button" 
                            id="test-connection-btn" 
                            class="btn btn-success w-100 mb-3"
                            @if(!$currentConfig['has_api_key']) disabled @endif>
                        <i class="fas fa-plug me-2"></i>Tester la connexion API
                    </button>

                    <div id="test-result" class="d-none"></div>
                </div>
            </div>

            <!-- Statut -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-gradient-warning text-white p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Statut actuel
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Provider</span>
                        <strong id="status-provider">{{ ucfirst($currentConfig['provider']) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Modèle</span>
                        <strong class="small" id="status-model">{{ $currentConfig['model'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Clé API</span>
                        <span class="badge bg-success" id="status-key">Configurée</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Accès</span>
                        <span class="badge bg-primary">Admin uniquement</span>
                    </div>
                </div>
            </div>

            <!-- Fonctionnalités -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-star me-2"></i>Fonctionnalités IA
                    </h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Corriger les fautes
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Optimiser (SEO + Style)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Enrichir le contenu
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Créer du contenu
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Optimiser les titres
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Optimiser les slugs
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}
</style>
@endpush

@push('scripts')
<script>
// Afficher/Masquer la clé API
function toggleApiKeyVisibility() {
    const apiKeyInput = document.getElementById('api_key');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (apiKeyInput.type === 'password') {
        apiKeyInput.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
    } else {
        apiKeyInput.type = 'password';
        toggleIcon.className = 'fas fa-eye';
    }
}

// Charger les modèles selon le provider
const modelsData = @json($models);

document.getElementById('provider').addEventListener('change', function() {
    const provider = this.value;
    const modelSelect = document.getElementById('model');
    
    // Vider les options
    modelSelect.innerHTML = '';
    
    // Ajouter les nouveaux modèles
    if (modelsData[provider]) {
        Object.entries(modelsData[provider]).forEach(([value, label]) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = label;
            modelSelect.appendChild(option);
        });
    }
    
    // Mettre à jour le statut
    document.getElementById('status-provider').textContent = provider.charAt(0).toUpperCase() + provider.slice(1);
});

// Soumission du formulaire
document.getElementById('aitext-config-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Désactiver le bouton
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enregistrement...';
    
    fetch('{{ route('admin.aitext.save') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Notification de succès
            showNotification('Configuration enregistrée avec succès !', 'success');
            
            // Mettre à jour le statut
            document.getElementById('status-model').textContent = document.getElementById('model').value;
            document.getElementById('status-key').textContent = 'Configurée';
            document.getElementById('status-key').className = 'badge bg-success';
            
            // Activer le bouton de test
            document.getElementById('test-connection-btn').disabled = false;
        } else {
            // Afficher les erreurs
            let errorMsg = 'Erreur lors de l\'enregistrement';
            if (data.errors) {
                errorMsg = Object.values(data.errors).flat().join('<br>');
            }
            showNotification(errorMsg, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Test de connexion
document.getElementById('test-connection-btn').addEventListener('click', function() {
    const testBtn = this;
    const testResult = document.getElementById('test-result');
    
    testBtn.disabled = true;
    testBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Test en cours...';
    testResult.classList.add('d-none');

    fetch('{{ route('admin.aitext.test') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        testResult.classList.remove('d-none');
        
        if (data.success) {
            testResult.innerHTML = `
                <div class="alert alert-success border-0 mb-0">
                    <h6 class="alert-heading">
                        <i class="fas fa-check-circle me-2"></i>Connexion réussie !
                    </h6>
                    <hr>
                    <p class="mb-2"><strong>Provider :</strong> ${data.provider}</p>
                    <p class="mb-2"><strong>Modèle :</strong> ${data.model}</p>
                    <p class="mb-0 small text-muted">${data.message}</p>
                </div>
            `;
        } else {
            testResult.innerHTML = `
                <div class="alert alert-danger border-0 mb-0">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-circle me-2"></i>Erreur de connexion
                    </h6>
                    <hr>
                    <p class="mb-0 small">${data.error || data.message}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        testResult.classList.remove('d-none');
        testResult.innerHTML = `
            <div class="alert alert-danger border-0 mb-0">
                <i class="fas fa-times-circle me-2"></i>
                Erreur réseau : ${error.message}
            </div>
        `;
    })
    .finally(() => {
        testBtn.disabled = false;
        testBtn.innerHTML = '<i class="fas fa-plug me-2"></i>Tester la connexion API';
    });
});

// Système de notifications
function showNotification(message, type = 'info') {
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#f59e0b',
        info: '#0ea5e9'
    };
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const notification = document.createElement('div');
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
    `;
    
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fas ${icons[type]}" style="color: ${colors[type]}; font-size: 20px;"></i>
            <div style="flex: 1; color: #1f2937;">${message}</div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => notification.remove(), 300);
    }, type === 'error' ? 8000 : 4000);
}
</script>
@endpush
@endsection