<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.sitemap.index') }}">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="static" {{ request('type') === 'static' ? 'selected' : '' }}>Statique</option>
                        <option value="dynamic" {{ request('type') === 'dynamic' ? 'selected' : '' }}>Dynamique</option>
                        <option value="manual" {{ request('type') === 'manual' ? 'selected' : '' }}>Manuel</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Statut</label>
                    <select name="approved" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ request('approved') === 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="true" {{ request('approved') === 'true' ? 'selected' : '' }}>Approuvées</option>
                        <option value="false" {{ request('approved') === 'false' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Source</label>
                    <select name="source" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ request('source') === 'all' ? 'selected' : '' }}>Toutes</option>
                        <option value="posts" {{ request('source') === 'posts' ? 'selected' : '' }}>Articles</option>
                        <option value="fiches" {{ request('source') === 'fiches' ? 'selected' : '' }}>Fiches</option>
                        <option value="downloadables" {{ request('source') === 'downloadables' ? 'selected' : '' }}>Téléchargements</option>
                        <option value="exercices" {{ request('source') === 'exercices' ? 'selected' : '' }}>Exercices</option>
                        <option value="plans" {{ request('source') === 'plans' ? 'selected' : '' }}>Plans</option>
                        <option value="workouts" {{ request('source') === 'workouts' ? 'selected' : '' }}>Workouts</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Recherche</label>
                    <input type="text" name="search" class="form-control" placeholder="Rechercher une URL..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.sitemap.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Réinitialiser
                        </a>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addUrlModal">
                            <i class="bi bi-plus-circle"></i> Ajouter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Actions en masse --}}
<div id="bulkActions" class="alert alert-info d-none">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <strong><span id="selectedCount">0</span> URL(s) sélectionnée(s)</strong>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-success" onclick="bulkApprove()">
                <i class="bi bi-check-circle"></i> Approuver
            </button>
            <button type="button" class="btn btn-sm btn-warning" onclick="bulkDisapprove()">
                <i class="bi bi-x-circle"></i> Désapprouver
            </button>
        </div>
    </div>
</div>