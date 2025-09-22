<!-- Modal Nouvelle Catégorie -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-folder-plus text-success me-2"></i>
                    Nouvelle catégorie
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('admin.media.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="categoryName" class="form-label fw-semibold">
                                Nom de la catégorie *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="categoryName" 
                                   class="form-control"
                                   placeholder="Ex: Photos de blog, Bannières..."
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="categoryDescription" class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="categoryDescription" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Description optionnelle de la catégorie"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="categoryColor" class="form-label fw-semibold">
                                Couleur
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" 
                                       name="color" 
                                       id="categoryColor" 
                                       class="form-control form-control-color" 
                                       value="#6366f1"
                                       style="width: 50px;">
                                <input type="text" 
                                       class="form-control" 
                                       id="colorHex" 
                                       value="#6366f1"
                                       placeholder="#000000">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="categoryOrder" class="form-label fw-semibold">
                                Ordre d'affichage
                            </label>
                            <input type="number" 
                                   name="order" 
                                   id="categoryOrder" 
                                   class="form-control"
                                   value="0"
                                   min="0">
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="categoryActive" 
                                       class="form-check-input"
                                       value="1"
                                       checked>
                                <label for="categoryActive" class="form-check-label">
                                    Catégorie active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Créer la catégorie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>