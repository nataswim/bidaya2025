<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editEventForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_event_id" name="event_id">
                
                <div class="modal-header">
                    <h5 class="modal-title">✏️ Modifier l'activité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Informations générales -->
                    <h6 class="mb-3 text-primary">━━━ INFORMATIONS GÉNÉRALES ━━━</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Discipline</label>
                            <input type="text" id="edit_discipline" name="discipline" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Titre de l'activité *</label>
                            <input type="text" id="edit_title" name="title" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type d'activité *</label>
                            <select id="edit_type" name="type" class="form-select" required>
                                <option value="entrainement">🏋️ Entraînement</option>
                                <option value="rendez-vous">📅 Rendez-vous</option>
                                <option value="stage">🍽️ Stage</option>
                                <option value="competition">💊 Compétition</option>
                                <option value="autres">📝 Autres</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Objectif</label>
                            <input type="text" id="edit_objective" name="objective" class="form-control">
                        </div>
                    </div>
                    
                    <!-- Date & Lieu -->
                    <h6 class="mb-3 mt-4 text-primary">━━━ DATE & LIEU ━━━</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Date *</label>
                            <input type="date" id="edit_event_date" name="event_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Heure *</label>
                            <input type="time" id="edit_event_time" name="event_time" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lieu</label>
                            <input type="text" id="edit_location" name="location" class="form-control">
                        </div>
                    </div>
                    
                    <!-- Détails -->
                    <h6 class="mb-3 mt-4 text-primary">━━━ DÉTAILS ━━━</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Remarques</label>
                        <textarea id="edit_remarks" name="remarks" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Matériel nécessaire</label>
                        <input type="text" id="edit_material" name="material" class="form-control">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Durée prévue</label>
                            <input type="text" id="edit_planned_duration" name="planned_duration" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Distance prévue</label>
                            <input type="text" id="edit_planned_distance" name="planned_distance" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('editEventForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const eventId = document.getElementById('edit_event_id').value;
    const formData = new FormData(this);
    
    fetch(`/user/calendar/${eventId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('editEventModal');
            location.reload();
        }
    });
});
</script>