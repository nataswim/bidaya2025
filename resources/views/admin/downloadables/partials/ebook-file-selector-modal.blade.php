<!-- Modal Sélecteur de Fichiers eBook -->
<div class="modal fade" id="ebookFileSelectorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-folder-open me-2"></i>
                    Sélectionner un fichier eBook
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <!-- Filtres -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <input type="text" 
                               id="ebookSearchInput" 
                               class="form-control" 
                               placeholder="Rechercher un fichier...">
                    </div>
                    <div class="col-md-4">
                        <select id="ebookFormatFilter" class="form-select">
                            <option value="">Tous les formats</option>
                            <option value="pdf">PDF</option>
                            <option value="epub">EPUB</option>
                            <option value="mp4">MP4</option>
                            <option value="zip">ZIP</option>
                            <option value="doc">DOC</option>
                            <option value="docx">DOCX</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" 
                                class="btn btn-primary w-100"
                                onclick="searchEbookFiles()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Info rapide -->
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Vous pouvez uploader de nouveaux fichiers dans 
                    <a href="{{ route('admin.ebook-files.index') }}" target="_blank" class="alert-link">
                        Gestion des fichiers eBook <i class="fas fa-external-link-alt ms-1"></i>
                    </a>
                </div>

                <!-- Grille des fichiers -->
                <div id="ebookFilesGrid" class="row g-3">
                    <!-- Chargé dynamiquement -->
                </div>

                <!-- Loading -->
                <div id="ebookFilesLoading" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="text-muted mt-2">Chargement des fichiers...</p>
                </div>

                <!-- Aucun résultat -->
                <div id="noEbookFilesFound" class="text-center py-5 d-none">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5>Aucun fichier trouvé</h5>
                    <p class="text-muted mb-3">Aucun fichier ne correspond à vos critères</p>
                    <a href="{{ route('admin.ebook-files.index') }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Uploader des fichiers
                    </a>
                </div>

                <!-- Pagination -->
                <div id="ebookFilesPagination" class="d-flex justify-content-center mt-4">
                    <!-- Chargé dynamiquement -->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>