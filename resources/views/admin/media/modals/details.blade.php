<!-- Modal DÃ©tails Media -->
<div class="modal fade" id="mediaDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    DÃ©tails du mÃ©dia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Aperçu -->
                    <div class="col-md-5">
                        <div class="text-center">
                            <img id="detailsImage" 
                                 src="" 
                                 alt="" 
                                 class="img-fluid rounded shadow-sm mb-3"
                                 style="max-height: 300px;">
                            <div class="d-grid gap-2">
                                <a id="detailsViewLink" 
                                   href="" 
                                   target="_blank" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>Voir en taille rÃ©elle
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-success btn-sm"
                                        onclick="copyToClipboard('detailsUrl')">
                                    <i class="fas fa-copy me-1"></i>Copier l'URL
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Informations et Ã©dition -->
                    <div class="col-md-7">
                        <form id="updateMediaForm" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="detailsName" class="form-label fw-semibold">
                                        Nom d'affichage
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="detailsName" 
                                           class="form-control">
                                </div>

                                <div class="col-12">
                                    <label for="detailsAltText" class="form-label fw-semibold">
                                        Texte alternatif (Alt)
                                    </label>
                                    <input type="text" 
                                           name="alt_text" 
                                           id="detailsAltText" 
                                           class="form-control"
                                           placeholder="Description pour l'accessibilitÃ©">
                                </div>

                                <div class="col-12">
                                    <label for="detailsCategory" class="form-label fw-semibold">
                                        CatÃ©gorie
                                    </label>
                                    <select name="media_category_id" id="detailsCategory" class="form-select">
                                        <option value="">Aucune catÃ©gorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="detailsDescription" class="form-label fw-semibold">
                                        Description
                                    </label>
                                    <textarea name="description" 
                                              id="detailsDescription" 
                                              class="form-control" 
                                              rows="3"></textarea>
                                </div>

                                <!-- Informations techniques -->
                                <div class="col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <h6 class="fw-semibold mb-3">Informations techniques</h6>
                                        <div class="row g-2 small">
                                            <div class="col-6">
                                                <strong>Fichier :</strong> <span id="detailsFileName"></span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Taille :</strong> <span id="detailsSize"></span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Dimensions :</strong> <span id="detailsDimensions"></span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Type :</strong> <span id="detailsMimeType"></span>
                                            </div>
                                            <div class="col-6">
                                                <strong>UploadÃ© le :</strong> <span id="detailsCreatedAt"></span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Par :</strong> <span id="detailsUploader"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- URL pour copie -->
                                <div class="col-12">
                                    <label for="detailsUrl" class="form-label fw-semibold">
                                        URL du fichier
                                    </label>
                                    <div class="input-group">
                                        <input type="text" 
                                               id="detailsUrl" 
                                               class="form-control font-monospace small" 
                                               readonly>
                                        <button type="button" 
                                                class="btn btn-outline-secondary"
                                                onclick="copyToClipboard('detailsUrl')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" 
                        class="btn btn-outline-danger"
                        onclick="deleteMediaFromDetails()">
                    <i class="fas fa-trash me-2"></i>Supprimer
                </button>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Fermer
                    </button>
                    <button type="button" 
                            class="btn btn-primary"
                            onclick="updateMedia()">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>