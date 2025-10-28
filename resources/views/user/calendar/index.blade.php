@extends('layouts.user')

@section('title', 'Mon Calendrier')

@section('content')
<div class="container-lg py-5">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-2">Mes Acitivitées </h1>
                    <p class="text-muted mb-0">Planifiez et suivez vos activités</p>
                </div>
                <a href="{{ route('user.calendar.create') }}" class="btn btn-danger text-white">
                    <i class="fas fa-plus me-2"></i>Planifier une activité
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques du mois -->
    @if($monthStats['total_completed'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #16558f 0%, #0f5c78 100%);">
                <div class="card-body p-4 text-white">
                    <h5 class="mb-3">Ce mois-ci</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="mb-0">{{ $monthStats['total_completed'] }}</h3>
                                <small>Activités réalisées</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="mb-0">{{ $monthStats['average_effort'] }}/10</h3>
                                <small>Ressenti moyen</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="mb-0">{{ $monthStats['objectives_percentage'] }}%</h3>
                                <small>Objectifs atteints</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="mb-0">{{ $monthStats['objectives_achieved'] }}/{{ $monthStats['objectives_total'] }}</h3>
                                <small>Objectifs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Événements de cette semaine -->
    @if($thisWeekEvents->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">Cette semaine ({{ $thisWeekEvents->count() }})</h4>
                    
                    <div class="list-group list-group-flush">
                        @foreach($thisWeekEvents as $event)
                        <div class="list-group-item border-0 px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background-color: {{ $event->type_color }}20;">
                                        <i class="{{ $event->type_icon }} fa-lg" style="color: {{ $event->type_color }};"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">
                                        <a href="{{ route('user.calendar.show', $event) }}" class="text-decoration-none text-dark">
                                            {{ $event->title }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $event->formatted_date }}
                                        <i class="fas fa-clock ms-2 me-1"></i>{{ $event->formatted_time }}
                                        @if($event->location)
                                            <i class="fas fa-map-marker-alt ms-2 me-1"></i>{{ $event->location }}
                                        @endif
                                    </small>
                                    @if($event->objective)
                                        <br><small class="text-muted"><i class="fas fa-bullseye me-1"></i>{{ $event->objective }}</small>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    {!! $event->status_badge !!}
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.calendar.show', $event) }}" class="btn btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.calendar.edit', $event) }}" class="btn btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($event->status === 'planned')
                                        <button type="button" class="btn btn-outline-danger" onclick="confirmCancel({{ $event->id }})" title="Annuler">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Événements à compléter -->
    @if($needsCompletion->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm border-start border-warning border-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">⏱️ À compléter ({{ $needsCompletion->count() }})</h4>
                    
                    <div class="list-group list-group-flush">
                        @foreach($needsCompletion as $event)
                        <div class="list-group-item border-0 px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background-color: {{ $event->type_color }}20;">
                                        <i class="{{ $event->type_icon }} fa-lg" style="color: {{ $event->type_color }};"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">{{ $event->title }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $event->formatted_date }}
                                        <i class="fas fa-clock ms-2 me-1"></i>{{ $event->formatted_time }}
                                    </small>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-warning btn-sm" onclick="openCompleteModal({{ $event->id }})">
                                        <i class="fas fa-check-circle me-1"></i>Compléter mon retour
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Événements à venir -->
    @if($upcomingEvents->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">Planifiées</h4>
                    
                    <div class="list-group list-group-flush">
                        @foreach($upcomingEvents as $event)
                        <div class="list-group-item border-0 px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background-color: {{ $event->type_color }}20;">
                                        <i class="{{ $event->type_icon }} fa-lg" style="color: {{ $event->type_color }};"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">
                                        <a href="{{ route('user.calendar.show', $event) }}" class="text-decoration-none text-dark">
                                            {{ $event->title }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $event->formatted_date }}
                                        <i class="fas fa-clock ms-2 me-1"></i>{{ $event->formatted_time }}
                                        @if($event->location)
                                            <i class="fas fa-map-marker-alt ms-2 me-1"></i>{{ $event->location }}
                                        @endif
                                    </small>
                                    @if($event->linkable)
                                        <br><small class="text-primary">
                                            <i class="fas fa-link me-1"></i>Lié à: {{ $event->linkable->title ?? $event->linkable->titre ?? 'Contenu' }}
                                        </small>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    {!! $event->status_badge !!}
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.calendar.show', $event) }}" class="btn btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.calendar.edit', $event) }}" class="btn btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Événements passés complétés -->
    @if($pastEvents->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">Passés</h4>
                    
                    <div class="list-group list-group-flush">
                        @foreach($pastEvents as $event)
                        <div class="list-group-item border-0 px-0 opacity-75">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background-color: {{ $event->type_color }}20;">
                                        <i class="{{ $event->type_icon }} fa-lg" style="color: {{ $event->type_color }};"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">
                                        <a href="{{ route('user.calendar.show', $event) }}" class="text-decoration-none text-dark">
                                            {{ $event->title }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $event->formatted_date }}
                                        <i class="fas fa-clock ms-2 me-1"></i>{{ $event->formatted_time }}
                                    </small>
                                    @if($event->effort_feeling)
                                        <br><small class="text-success">
                                            <i class="fas fa-star me-1"></i>Ressenti: {{ $event->effort_feeling }}/10
                                            @if($event->objective_achieved)
                                                | Objectif: {{ $event->objective_achieved_label }}
                                            @endif
                                        </small>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    {!! $event->status_badge !!}
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('user.calendar.show', $event) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Voir détails
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Message si aucun événement -->
    @if($thisWeekEvents->count() === 0 && $upcomingEvents->count() === 0 && $needsCompletion->count() === 0 && $pastEvents->count() === 0)
    <div class="text-center py-5">
        <i class="fas fa-calendar-alt fa-3x text-muted mb-4 opacity-25"></i>
        <h4>Aucune activité planifiée</h4>
        <p class="text-muted mb-4">Commencez à planifier vos activités</p>
        <a href="{{ route('user.calendar.create') }}" class="btn btn-danger text-white">
            <i class="fas fa-plus me-2"></i>Planifier ma première activité
        </a>
    </div>
    @endif
</div>

<!-- Modal Finalisation Événement -->
@include('user.calendar.partials.complete-modal')

@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endpush
@push('scripts')
<script>
let currentEventId = null;

// Fonction universelle pour ouvrir un modal (compatible avec différentes versions de Bootstrap)
function openModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) {
        console.error('Modal non trouvé:', modalId);
        return;
    }
    
    // Méthode 1: Bootstrap 5 via window.bootstrap
    if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
        const modal = new window.bootstrap.Modal(modalEl);
        modal.show();
        return;
    }
    
    // Méthode 2: Bootstrap via variable globale bootstrap
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        return;
    }
    
    // Méthode 3: jQuery Bootstrap
    if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
        $(modalEl).modal('show');
        return;
    }
    
    // Méthode 4: Manipulation DOM manuelle (fallback)
    modalEl.classList.add('show');
    modalEl.style.display = 'block';
    modalEl.setAttribute('aria-modal', 'true');
    modalEl.setAttribute('role', 'dialog');
    modalEl.removeAttribute('aria-hidden');
    document.body.classList.add('modal-open');
    
    // Créer le backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.id = 'modalBackdrop-' + modalId;
    document.body.appendChild(backdrop);
    
    // Gestion de la fermeture
    const closeButtons = modalEl.querySelectorAll('[data-bs-dismiss="modal"]');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            closeModal(modalId);
        });
    });
    
    // Fermeture au clic sur le backdrop
    backdrop.addEventListener('click', function() {
        closeModal(modalId);
    });
}

// Fonction universelle pour fermer un modal
function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    // Méthode 1: Bootstrap 5
    if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal) {
        const modalInstance = window.bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
        return;
    }
    
    // Méthode 2: Bootstrap
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
        return;
    }
    
    // Méthode 3: jQuery
    if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
        $(modalEl).modal('hide');
        return;
    }
    
    // Méthode 4: DOM manuel
    modalEl.classList.remove('show');
    modalEl.style.display = 'none';
    modalEl.setAttribute('aria-hidden', 'true');
    modalEl.removeAttribute('aria-modal');
    modalEl.removeAttribute('role');
    document.body.classList.remove('modal-open');
    
    // Supprimer le backdrop
    const backdrop = document.getElementById('modalBackdrop-' + modalId);
    if (backdrop) {
        backdrop.remove();
    }
}

// Ouvrir le modal de finalisation
function openCompleteModal(eventId) {
    currentEventId = eventId;
    
    // Réinitialiser le formulaire
    const form = document.getElementById('completeEventForm');
    if (form) {
        form.reset();
    }
    
    // Ouvrir le modal
    openModal('completeEventModal');
}

// Soumettre la finalisation
function submitComplete() {
    if (!currentEventId) {
        alert('Erreur: ID événement manquant');
        return;
    }
    
    const form = document.getElementById('completeEventForm');
    const formData = new FormData(form);
    
    // Vérifier les champs requis
    const effortFeeling = formData.get('effort_feeling');
    const objectiveAchieved = formData.get('objective_achieved');
    
    if (!effortFeeling) {
        alert('Veuillez sélectionner un ressenti de l\'effort');
        return;
    }
    
    if (!objectiveAchieved) {
        alert('Veuillez indiquer si l\'objectif a été atteint');
        return;
    }
    
    // Afficher un loader sur le bouton
    const submitBtn = event.target;
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Enregistrement...';
    
    // Envoyer la requête
    fetch(`/user/calendar/${currentEventId}/complete`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Fermer le modal
            closeModal('completeEventModal');
            
            // Afficher message succès
            alert('✅ Activité finalisée avec succès !');
            
            // Recharger la page
            location.reload();
        } else {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            alert('Erreur: ' + (data.message || 'Erreur lors de la finalisation'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        alert('Erreur lors de la finalisation. Veuillez réessayer.');
    });
}

// Confirmer annulation
function confirmCancel(eventId) {
    if (!confirm('Voulez-vous annuler cette activité ?')) return;
    
    fetch(`/user/calendar/${eventId}/cancel`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Activité annulée');
            location.reload();
        } else {
            alert('Erreur lors de l\'annulation');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'annulation');
    });
}
</script>
@endpush