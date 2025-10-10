@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🗺️ Gestion du Sitemap</h2>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#discoverModal">
                <i class="bi bi-search"></i> Découvrir les URLs
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generateModal">
                <i class="bi bi-rocket"></i> Générer le Sitemap
            </button>
        </div>
    </div>

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Liens rapides SEO --}}
    @include('admin.sitemap.partials.quick-links')

    {{-- Statistiques --}}
    @include('admin.sitemap.partials.stats', ['statistics' => $statistics])

    {{-- Filtres --}}
    @include('admin.sitemap.partials.filters')

    {{-- Tableau des URLs --}}
    @include('admin.sitemap.partials.table', ['urls' => $urls])

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $urls->links() }}
    </div>
</div>

{{-- Modal Découverte --}}
<div class="modal fade" id="discoverModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🔍 Découvrir les URLs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Cette action va scanner votre application et ajouter toutes les URLs trouvées dans la base de données.</p>
                <div class="alert alert-info">
                    <strong>Note :</strong> Les URLs dynamiques nécessiteront une approbation manuelle avant d'être incluses dans le sitemap.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('admin.sitemap.discover') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Lancer la découverte
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Génération --}}
<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🚀 Générer le Sitemap XML</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Cette action va générer le fichier <code>sitemap.xml</code> avec toutes les URLs <strong>approuvées et actives</strong>.</p>
                <div class="alert alert-success">
                    <strong>URLs qui seront incluses :</strong> {{ $statistics['approved_urls'] ?? 0 }}
                </div>
                <div class="alert alert-info">
                    <strong>📍 Le sitemap sera accessible sur :</strong><br>
                    <code>{{ config('app.url') }}/sitemap.xml</code>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('admin.sitemap.generate') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-rocket"></i> Générer maintenant
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ajouter URL --}}
<div class="modal fade" id="addUrlModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.sitemap.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">➕ Ajouter une URL manuelle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">URL *</label>
                        <input type="url" name="url" class="form-control" placeholder="https://votresite.com/page-exemple" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priorité</label>
                        <input type="number" name="priority" class="form-control" value="0.5" step="0.1" min="0" max="1">
                        <small class="text-muted">Entre 0.0 et 1.0 (1.0 = priorité maximale)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fréquence de changement</label>
                        <select name="changefreq" class="form-select">
                            <option value="always">Toujours</option>
                            <option value="hourly">Toutes les heures</option>
                            <option value="daily">Quotidien</option>
                            <option value="weekly" selected>Hebdomadaire</option>
                            <option value="monthly">Mensuel</option>
                            <option value="yearly">Annuel</option>
                            <option value="never">Jamais</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Nettoyage --}}
<div class="modal fade" id="cleanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">⚠️ Nettoyer toutes les URLs</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>⚠️ ATTENTION :</strong> Cette action va supprimer <strong>TOUTES</strong> les URLs de la base de données de manière irréversible.
                </div>
                <p>Vous devrez relancer la découverte et réapprouver les URLs après cette action.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('admin.sitemap.clean') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Confirmer le nettoyage
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Sélection multiple
    const checkboxes = document.querySelectorAll('.url-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    const bulkActionsDiv = document.getElementById('bulkActions');

    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.url-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActionsDiv.classList.remove('d-none');
            document.getElementById('selectedCount').textContent = checkedCount;
        } else {
            bulkActionsDiv.classList.add('d-none');
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActions();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkActions);
    });

    // Actions en masse
    function bulkAction(approved) {
        const checkedIds = Array.from(document.querySelectorAll('.url-checkbox:checked'))
            .map(cb => cb.value);

        if (checkedIds.length === 0) {
            alert('Veuillez sélectionner au moins une URL');
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.sitemap.bulk-approve") }}';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const approvedInput = document.createElement('input');
        approvedInput.type = 'hidden';
        approvedInput.name = 'approved';
        approvedInput.value = approved ? '1' : '0';
        form.appendChild(approvedInput);

        checkedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'url_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }

    window.bulkApprove = () => bulkAction(true);
    window.bulkDisapprove = () => bulkAction(false);
</script>
@endpush
@endsection