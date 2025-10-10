<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary mb-0">{{ $statistics['total_urls'] ?? 0 }}</h3>
                <small class="text-muted">Total URLs</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success mb-0">{{ $statistics['approved_urls'] ?? 0 }}</h3>
                <small class="text-muted">URLs Approuvées</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning mb-0">{{ $statistics['pending_approval'] ?? 0 }}</h3>
                <small class="text-muted">En Attente</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info mb-0">
                    @if($statistics['last_generated'] ?? false)
                        {{ $statistics['last_generated']->format('d/m/Y') }}
                    @else
                        Jamais
                    @endif
                </h3>
                <small class="text-muted">Dernière Génération</small>
            </div>
        </div>
    </div>
</div>

{{-- Détails par source --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title">📊 Répartition par source</h6>
        <div class="row text-center">
            <div class="col">
                <strong>{{ $statistics['posts_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Articles</small>
            </div>
            <div class="col">
                <strong>{{ $statistics['fiches_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Fiches</small>
            </div>
            <div class="col">
                <strong>{{ $statistics['downloadables_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Téléchargements</small>
            </div>
            <div class="col">
                <strong>{{ $statistics['exercices_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Exercices</small>
            </div>
            <div class="col">
                <strong>{{ $statistics['plans_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Plans</small>
            </div>
            <div class="col">
                <strong>{{ $statistics['workouts_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Workouts</small>
            </div>
            <div class="col">
                <strong>{{ $statistics['static_urls'] ?? 0 }}</strong>
                <small class="d-block text-muted">Statiques</small>
            </div>
        </div>
    </div>
</div>