<div class="modal fade" id="createEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.calendar.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">📅 Planifier une activité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Informations générales -->
                    <h6 class="mb-3 text-primary">━━━ INFORMATIONS GÉNÉRALES ━━━</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Discipline</label>
                            <input type="text" name="discipline" class="form-control" placeholder="Ex: Course à pied, Natation...">
                            <small class="text-muted">Sport ou activité pratiquée</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Titre de l'activité *</label>
                            <input type="text" name="title" class="form-control" required maxlength="200">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type d'activité *</label>
                            <select name="type" class="form-select" required>
                                <option value="">Sélectionner un type</option>
                                <option value="entrainement">🏋️ Entraînement</option>
                                <option value="rendez-vous">📅 Rendez-vous</option>
                                <option value="stage">🍽️ Stage</option>
                                <option value="competition">💊 Compétition</option>
                                <option value="autres">📝 Autres</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Objectif</label>
                            <input type="text" name="objective" class="form-control" placeholder="Ex: Améliorer endurance...">
                        </div>
                    </div>
                    
                    <!-- Date & Lieu -->
                    <h6 class="mb-3 mt-4 text-primary">━━━ DATE & LIEU ━━━</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Date *</label>
                            <input type="date" name="event_date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Heure *</label>
                            <input type="time" name="event_time" class="form-control" required value="14:00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lieu</label>
                            <input type="text" name="location" class="form-control" placeholder="Ex: Salle de sport">
                        </div>
                    </div>
                    
                    <!-- Détails -->
                    <h6 class="mb-3 mt-4 text-primary">━━━ DÉTAILS ━━━</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Détails de l'activité..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Remarques</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="Notes personnelles..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Matériel nécessaire</label>
                        <input type="text" name="material" class="form-control" placeholder="Ex: Chaussures trail, ceinture...">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Durée prévue</label>
                            <input type="text" name="planned_duration" class="form-control" placeholder="Ex: 1h30">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Distance prévue</label>
                            <input type="text" name="planned_distance" class="form-control" placeholder="Ex: 10 km">
                        </div>
                    </div>
                    
                    <!-- Lier à un contenu -->
                    <h6 class="mb-3 mt-4 text-primary">━━━ LIER À UN CONTENU (optionnel) ━━━</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type de contenu</label>
                            <select name="linkable_type" class="form-select" id="linkable_type">
                                <option value="">Aucun</option>
                                <option value="workout">Séance d'entraînement</option>
                                <option value="plan">Plan d'entraînement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contenu</label>
                            <select name="linkable_id" class="form-select" id="linkable_id" disabled>
                                <option value="">Sélectionner</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-1"></i>Planifier l'activité
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Gestion du chargement dynamique des contenus liés
document.getElementById('linkable_type')?.addEventListener('change', function() {
    const type = this.value;
    const select = document.getElementById('linkable_id');
    
    if (!type) {
        select.disabled = true;
        select.innerHTML = '<option value="">Sélectionner</option>';
        return;
    }
    
    select.disabled = false;
    select.innerHTML = '<option value="">Chargement...</option>';
    
    // Charger les contenus selon le type
    fetch(`/user/calendar/get-linkable/${type}`)
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Sélectionner</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.title;
                select.appendChild(option);
            });
        })
        .catch(() => {
            select.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});
</script>