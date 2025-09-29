@extends('layouts.user')

@section('title', 'Passer Premium')

@section('head')
@endsection

@section('content')
<script src="https://js.stripe.com/v3/"></script>

<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Passer Premium</h4>
                            <p class="text-muted mb-0">Debloquez l'acces A tous les contenus exclusifs</p>
                        </div>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    @if($hasCompletedPayment)
                        <div class="alert alert-info border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-water fa-2x text-info me-3"></i>
                                <div>
                                    <h6 class="mb-1">Paiement dejA effectue</h6>
                                    <p class="mb-0">Vous avez dejA effectue un paiement. Un administrateur validera votre acces premium prochainement.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Avantages Premium -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="bg-light rounded p-4">
                                <h5 class="mb-3"><i class="fas fa-crown text-warning me-2"></i>Pourquoi passer Premium ?</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-unlock text-success me-2"></i>
                                            <span>Acces complet aux articles</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-tools text-primary me-2"></i>
                                            <span>Outils exclusifs</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-headset text-info me-2"></i>
                                            <span>Support prioritaire</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Plans de tarification -->
                    <div class="row g-4 mb-4">
                        @foreach($plans as $planKey => $plan)
                        <div class="col-lg-4">
                            <div class="card h-100 border {{ $planKey === '6_months' ? 'border-primary' : '' }} position-relative">
                                @if($planKey === '6_months')
                                    <div class="position-absolute top-0 start-50 translate-middle">
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="fas fa-star me-1"></i>Le plus populaire
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="card-body text-center p-4">
                                    <h5 class="card-title mb-3">{{ $plan['name'] }}</h5>
                                    
                                    <div class="mb-3">
                                        <span class="h2 fw-bold text-primary">{{ number_format($plan['price'] / 100, 0) }}€</span>
                                    </div>
                                    
                                    <p class="text-muted mb-4">
                                        Soit {{ number_format($plan['price'] / 100 / $plan['duration_months'], 2) }}€/mois
                                    </p>
                                    
                                    <ul class="list-unstyled text-start mb-4">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Acces illimite</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>{{ $plan['duration_months'] }} mois d'acces</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Tous les outils premium</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Support inclus</li>
                                    </ul>
                                </div>
                                
                                <div class="card-footer bg-white border-top-0 p-4">
                                    <button class="btn btn-{{ $planKey === '6_months' ? 'primary' : 'outline-primary' }} w-100 payment-btn" 
                                            data-plan="{{ $planKey }}"
                                            data-amount="{{ $plan['price'] }}"
                                            data-name="{{ $plan['name'] }}"
                                            {{ $hasCompletedPayment ? 'disabled' : '' }}>
                                        @if($hasCompletedPayment)
                                            <i class="fas fa-check me-2"></i>DejA paye
                                        @else
                                            <i class="fas fa-credit-card me-2"></i>Choisir ce plan
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Formulaire de paiement (masque initialement) -->
                    <div id="payment-section" class="d-none">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Finaliser le paiement</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6>Plan selectionne</h6>
                                        <div id="selected-plan-info" class="p-3 bg-light rounded"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Securite</h6>
                                        <div class="p-3 bg-light rounded">
                                            <div class="d-flex align-items-center text-success">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                <span>Paiement securise par Stripe</span>
                                            </div>
                                            <small class="text-muted">Vos donnees sont protegees</small>
                                        </div>
                                    </div>
                                </div>

                                <form id="payment-form">
                                    <div id="payment-element" class="mb-4"></div>
                                    
                                    <div class="text-center">
                                        <button id="submit-button" type="submit" class="btn btn-success btn-lg px-5" disabled>
                                            <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none"></span>
                                            <span id="button-text">Payer maintenant</span>
                                        </button>
                                    </div>
                                    
                                    <div id="payment-messages" class="mt-3"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Informations legales -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="text-center">
                                <small class="text-muted">
                                    En procedant au paiement, vous acceptez nos conditions d'utilisation. 
                                    Paiement securise SSL 256 bits.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendre que Stripe soit charge
    function waitForStripe(callback) {
        if (typeof Stripe !== 'undefined') {
            callback();
        } else {
            console.log('En attente du chargement de Stripe...');
            setTimeout(() => waitForStripe(callback), 100);
        }
    }

    waitForStripe(function() {
        console.log('Stripe charge avec succes');
        
        const stripe = Stripe('{{ config('stripe.publishable_key') }}');
        let elements, paymentElement, selectedPlan;

        console.log('Cle publique Stripe:', '{{ config('stripe.publishable_key') }}');

        // Gestionnaire des boutons de plan
        document.querySelectorAll('.payment-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.disabled) return;
                
                selectedPlan = {
                    key: this.dataset.plan,
                    amount: this.dataset.amount,
                    name: this.dataset.name
                };
                
                console.log('Bouton clique, plan:', selectedPlan);
                initializePayment();
            });
        });

        async function initializePayment() {
            try {
                console.log('Plan selectionne:', selectedPlan);
                showLoading(true);
                
                // Afficher les informations du plan selectionne
                document.getElementById('selected-plan-info').innerHTML = `
                    <strong>${selectedPlan.name}</strong><br>
                    <span class="h5 text-primary">${(selectedPlan.amount / 100).toFixed(0)}€</span>
                    <small class="text-muted d-block">Paiement unique</small>
                `;
                
                // Mettre A jour le texte du bouton
                document.getElementById('button-text').textContent = `Payer ${(selectedPlan.amount / 100).toFixed(0)}€`;

                console.log('Envoi de la requête vers:', '{{ route('payments.create-intent') }}');
                
                // Creer le PaymentIntent
                const response = await fetch('{{ route('payments.create-intent') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        plan: selectedPlan.key
                    })
                });

                console.log('Reponse reçue:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Donnees:', data);

                if (data.error) {
                    console.error('Erreur Stripe:', data.error);
                    showMessage(data.error, 'error');
                    return;
                }

                if (!data.client_secret) {
                    console.error('Pas de client_secret reçu');
                    showMessage('Erreur: Pas de client_secret reçu', 'error');
                    return;
                }

                console.log('Creation des Elements Stripe...');

                // Creer les Elements Stripe
                elements = stripe.elements({
                    clientSecret: data.client_secret,
                    appearance: {
                        theme: 'stripe'
                    }
                });

                paymentElement = elements.create('payment');
                paymentElement.mount('#payment-element');

                // Afficher la section de paiement
                document.getElementById('payment-section').classList.remove('d-none');
                
                // Activer le bouton quand prêt
                paymentElement.on('ready', () => {
                    console.log('Stripe Elements prêt');
                    document.getElementById('submit-button').disabled = false;
                    showLoading(false);
                });

            } catch (error) {
                console.error('Erreur complete:', error);
                showMessage('Erreur lors de l\'initialisation: ' + error.message, 'error');
                showLoading(false);
            }
        }

        // Gestionnaire du formulaire de paiement
        document.getElementById('payment-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!stripe || !elements) {
                console.error('Stripe ou Elements non disponible');
                return;
            }

            console.log('Soumission du formulaire de paiement');
            showLoading(true);

            const {error} = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route('payments.confirm') }}?payment_intent={PAYMENT_INTENT}'
                }
            });

            if (error) {
                console.error('Erreur de paiement:', error);
                showMessage(error.message, 'error');
                showLoading(false);
            }
        });

        function showLoading(loading) {
            const button = document.getElementById('submit-button');
            const spinner = document.getElementById('spinner');
            const text = document.getElementById('button-text');

            if (loading) {
                button.disabled = true;
                spinner.classList.remove('d-none');
                text.textContent = 'Traitement en cours...';
            } else {
                button.disabled = false;
                spinner.classList.add('d-none');
                if (selectedPlan) {
                    text.textContent = `Payer ${(selectedPlan.amount / 100).toFixed(0)}€`;
                }
            }
        }

        function showMessage(message, type = 'error') {
            const container = document.getElementById('payment-messages');
            const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
            
            container.innerHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
    });
});
</script>


@endsection