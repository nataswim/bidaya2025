<div class="modal fade" id="completeEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="completeEventForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">📊 Compléter l'activité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Performance -->
                    <h6 class="mb-3 text-success">━━━ PERFORMANCE ━━━</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ressenti de l'effort * (1-10)</label>
                            <select name="effort_feeling" class="form-select" required>
                                <option value="">Sélectionner</option>
                                <optgroup label="Facile">
                                    <option value="1">1 - Très facile</option>
                                    <option value="2">2 - Facile</option>
                                    <option value="3">3 - Assez facile</option>
                                </optgroup>
                                <optgroup label="Modéré">
                                    <option value="4">4 - Léger</option>
                                    <option value="5">5 - Modéré</option>
                                    <option value="6">6 - Un peu dur</option>
                                </optgroup>
                                <optgroup label="Difficile">
                                    <option value="7">7 - Dur</option>
                                    <option value="8">8 - Très dur</option>
                                    <option value="9">9 - Extrêmement dur</option>
                                </optgroup>
                                <optgroup label="Maximum">
                                    <option value="10">10 - Effort maximal</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Objectif *</label>
                            <select name="objective_achieved" class="form-select" required>
                                <option value="">Sélectionner</option>
                                <option value="not_achieved">❌ Non atteint</option>
                                <option value="achieved">✅ Atteint</option>
                                <option value="exceeded">🎯 Dépassé</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Durée réelle</label>
                            <input type="text" name="actual_duration" class="form-control" placeholder="Ex: 1h25">
                            <small class="text-muted">Durée effective de l'activité</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Distance réelle</label>
                            <input type="text" name="actual_distance" class="form-control" placeholder="Ex: 10.5 km">
                            <small class="text-muted">Distance effective parcourue</small>
                        </div>
                    </div>
                    
                    <!-- Conditions -->
                    <h6 class="mb-3 mt-4 text-info">━━━ CONDITIONS ━━━</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Conditions météo</label>
                        <select name="weather_conditions" class="form-select">
                            <option value="">Sélectionner</option>
                            <option value="sunny">☀️ Ensoleillé</option>
                            <option value="cloudy">☁️ Nuageux</option>
                            <option value="rainy">🌧️ Pluie</option>
                            <option value="windy">💨 Vent</option>
                            <option value="cold">❄️ Froid</option>
                            <option value="hot">🔥 Chaud</option>
                        </select>
                    </div>
                    
                    <!-- État physique -->
                    <h6 class="mb-3 mt-4 text-danger">━━━ ÉTAT PHYSIQUE ━━━</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Douleurs/Gênes</label>
                        <textarea name="pain_discomfort" class="form-control" rows="3" 
                                  placeholder="Ex: Légère douleur au genou droit..."></textarea>
                        <small class="text-muted">Notez toute douleur ou gêne ressentie</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" onclick="submitComplete()">
                        <i class="fas fa-check-circle me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>