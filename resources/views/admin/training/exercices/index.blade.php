@extends('layouts.admin')

@section('title', 'Gestion des Exercices')
@section('page-title', 'Exercices')
@section('page-description', 'Gestion des exercices d\'entraînement')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des exercices -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-running me-2"></i>Exercices
                            </h5>
                            <small class="opacity-75">{{ $exercices->total() ?? $exercices->count() }} exercice(s) au total</small>
                        </div>
                        <a href="{{ route('admin.training.exercices.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Nouvel exercice
                        </a>
                    </div>
                </div>
                
                <!-- Filtres -->
                <div class="card-body border-bottom p-4 bg-light">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       class="form-control border-start-0"
                                       placeholder="Rechercher...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="niveau" class="form-select">
                                <option value="">Tous niveaux</option>
                                <option value="debutant" {{ request('niveau') === 'debutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermediaire" {{ request('niveau') === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avance" {{ request('niveau') === 'avance' ? 'selected' : '' }}>Avancé</option>
                                <option value="special" {{ request('niveau') === 'special' ? 'selected' : '' }}>Spécial</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-select">
                                <option value="">Tous types</option>
                                <option value="cardio" {{ request('type') === 'cardio' ? 'selected' : '' }}>Cardio</option>
                                <option value="force" {{ request('type') === 'force' ? 'selected' : '' }}>Force</option>
                                <option value="flexibilite" {{ request('type') === 'flexibilite' ? 'selected' : '' }}>Flexibilité</option>
                                <option value="equilibre" {{ request('type') === 'equilibre' ? 'selected' : '' }}>Équilibre</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-2"></i>Filtrer
                                </button>
                                @if(request()->hasAny(['search', 'niveau', 'type']))
                                    <a href="{{ route('admin.training.exercices.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Exercices -->
                <div class="card-body p-0">
                    @if($exercices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Exercice</th>
                                        <th class="border-0 px-4 py-3">Type & Niveau</th>
                                        <th class="border-0 px-4 py-3">Muscles</th>
                                        <th class="border-0 px-4 py-3">Statut</th>
                                        <th class="border-0 px-4 py-3">Utilisation</th>
                                        <th class="border-0 px-4 py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exercices as $exercice)
                                        <tr class="border-bottom hover-bg">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-start">
                                                    @if($exercice->image)
                                                        <img src="{{ $exercice->image }}" 
                                                             class="rounded me-3" 
                                                             style="width: 60px; height: 45px; object-fit: cover;" 
                                                             alt="">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 45px;">
                                                            <i class="fas fa-running text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('admin.training.exercices.show', $exercice) }}" 
                                                               class="text-decoration-none text-dark">
                                                                {!! Str::limit($exercice->titre, 50) !!}
                                                            </a>
                                                        </h6>
                                                        @if($exercice->description)
    <small class="text-muted">{!! Str::limit(strip_tags($exercice->description), 60) !!}</small>
@endif
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $exercice->type_exercice_label }}
                                                    </span>
                                                    <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}-subtle text-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}">
                                                        {{ $exercice->niveau_label }}
                                                    </span>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <small class="text-muted">
                                                    {{ $exercice->muscles_cibles_formatted }}
                                                </small>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <span class="badge bg-{{ $exercice->is_active ? 'success' : 'secondary' }}-subtle text-{{ $exercice->is_active ? 'success' : 'secondary' }}">
                                                    {{ $exercice->is_active ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="fas fa-list me-1"></i>
                                                    <span>{{ $exercice->series()->count() }} série(s)</span>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary border-0" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" 
                                                               href="{{ route('admin.training.exercices.show', $exercice) }}">
                                                                <i class="fas fa-eye me-2 text-info"></i>Voir
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" 
                                                               href="{{ route('admin.training.exercices.edit', $exercice) }}">
                                                                <i class="fas fa-edit me-2 text-primary"></i>Modifier
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" 
                                                                  action="{{ route('admin.training.exercices.destroy', $exercice) }}" 
                                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="dropdown-item d-flex align-items-center text-danger">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
@if($exercices->hasPages())
    <div class="card-footer bg-white border-top p-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-muted">
                Affichage de {{ $exercices->firstItem() }} à {{ $exercices->lastItem() }} 
                sur {{ $exercices->total() }} résultat(s)
            </div>
            {{ $exercices->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-running fa-3x text-muted mb-3 opacity-25"></i>
                            <h5>Aucun exercice trouvé</h5>
                            @if(request()->hasAny(['search', 'niveau', 'type']))
                                <p class="text-muted mb-3">Aucun résultat ne correspond à vos critères de recherche.</p>
                                <a href="{{ route('admin.training.exercices.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Voir tous les exercices
                                </a>
                            @else
                                <p class="text-muted mb-3">Commencez par créer votre premier exercice</p>
                                <a href="{{ route('admin.training.exercices.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer un exercice
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar statistiques -->
        <div class="col-lg-3">
            <!-- Statistiques générales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php
                        $totalExercices = \App\Models\Exercice::count();
                        $activeExercices = \App\Models\Exercice::where('is_active', true)->count();
                        $forceExercices = \App\Models\Exercice::where('type_exercice', 'force')->count();
                        $cardioExercices = \App\Models\Exercice::where('type_exercice', 'cardio')->count();
                    @endphp
                    
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $totalExercices }}</h4>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-success mb-1">{{ $activeExercices }}</h4>
                                <small class="text-muted">Actifs</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-warning mb-1">{{ $forceExercices }}</h4>
                                <small class="text-muted">Force</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-info mb-1">{{ $cardioExercices }}</h4>
                                <small class="text-muted">Cardio</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-warning text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-tools me-2"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.training.exercices.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouvel exercice
                        </a>
                        <a href="{{ route('admin.training.series.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-list-ol me-2"></i>Gérer les séries
                        </a>
                        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-images me-2"></i>Médiathèque
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}

.hover-bg:hover {
    background-color: #f8f9fa;
}

.dropdown-menu {
    border: 0;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endpush