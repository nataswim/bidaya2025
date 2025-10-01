@extends('layouts.admin')

@section('title', 'Gestion des Workouts')
@section('page-title', 'Workouts')
@section('page-description', 'Gestion des workouts')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des workouts -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-warning text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-dumbbell me-2"></i>Workouts
                            </h5>
                            <small class="opacity-75">{{ $workouts->total() ?? $workouts->count() }} workout(s) au total</small>
                        </div>
                        <a href="{{ route('admin.workouts.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Nouveau workout
                        </a>
                    </div>
                </div>
                
                <!-- Filtres -->
                <div class="card-body border-bottom p-4 bg-light">
                    <form method="GET" class="row g-3">
                        <div class="col-md-5">
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
                        <div class="col-md-4">
                            <select name="category" class="form-select">
                                <option value="">Toutes catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->section->name ?? '' }} → {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-2"></i>Filtrer
                                </button>
                                @if(request()->hasAny(['search', 'category']))
                                    <a href="{{ route('admin.workouts.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Workouts -->
                <div class="card-body p-0">
                    @if($workouts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Workout</th>
                                        <th class="border-0 px-4 py-3">Catégories</th>
                                        <th class="border-0 px-4 py-3 text-center">Total</th>
                                        <th class="border-0 px-4 py-3">Date</th>
                                        <th class="border-0 px-4 py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workouts as $workout)
                                        <tr class="border-bottom hover-bg">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="bg-warning bg-opacity-10 rounded me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 45px;">
                                                        <i class="fas fa-dumbbell text-warning"></i>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('admin.workouts.show', $workout) }}" 
                                                               class="text-decoration-none text-dark">
                                                                {!! Str::limit($workout->title, 60) !!}
                                                            </a>
                                                        </h6>
                                                        @if($workout->short_description)
                                                            <small class="text-muted">{!! Str::limit(strip_tags($workout->short_description), 80) !!}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                @if($workout->categories->count() > 0)
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($workout->categories->take(2) as $category)
                                                            <span class="badge bg-primary-subtle text-primary">
                                                                {{ $category->name }}
                                                            </span>
                                                        @endforeach
                                                        @if($workout->categories->count() > 2)
                                                            <span class="badge bg-secondary-subtle text-secondary">
                                                                +{{ $workout->categories->count() - 2 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">Non catégorisé</span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-4 py-3 text-center">
                                                <span class="badge bg-info-subtle text-info">
                                                    {{ $workout->formatted_total }}
                                                </span>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column">
                                                    <small class="fw-semibold">
                                                        {{ $workout->created_at?->format('d/m/Y') ?? 'N/A' }}
                                                    </small>
                                                    <small class="text-muted">
                                                        {{ $workout->created_at?->format('H:i') ?? '' }}
                                                    </small>
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
                                                               href="{{ route('admin.workouts.show', $workout) }}">
                                                                <i class="fas fa-eye me-2 text-info"></i>Voir
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" 
                                                               href="{{ route('admin.workouts.edit', $workout) }}">
                                                                <i class="fas fa-edit me-2 text-primary"></i>Modifier
                                                            </a>
                                                        </li>
                                                        @if($workout->categories->first())
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" 
                                                                   href="{{ route('public.workouts.show', [$workout->categories->first()->section, $workout->categories->first(), $workout]) }}" 
                                                                   target="_blank">
                                                                    <i class="fas fa-external-link-alt me-2 text-success"></i>Voir en ligne
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" 
                                                                  action="{{ route('admin.workouts.destroy', $workout) }}" 
                                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce workout ?')">
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
                        @if($workouts->hasPages())
                            <div class="card-footer bg-white border-top p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-muted">
                                        Affichage de {{ $workouts->firstItem() }} à {{ $workouts->lastItem() }} 
                                        sur {{ $workouts->total() }} résultat(s)
                                    </div>
                                    {{ $workouts->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-dumbbell fa-3x text-muted mb-3 opacity-25"></i>
                            <h5>Aucun workout trouvé</h5>
                            @if(request()->hasAny(['search', 'category']))
                                <p class="text-muted mb-3">Aucun résultat ne correspond à vos critères de recherche.</p>
                                <a href="{{ route('admin.workouts.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Voir tous les workouts
                                </a>
                            @else
                                <p class="text-muted mb-3">Commencez par créer votre premier workout</p>
                                <a href="{{ route('admin.workouts.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer un workout
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
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $stats['total'] }}</h4>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-info mb-1">{{ $stats['categories_count'] }}</h4>
                                <small class="text-muted">Catégories</small>
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
                        <a href="{{ route('admin.workouts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouveau workout
                        </a>
                        <a href="{{ route('admin.workout-categories.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-folder me-2"></i>Gérer les catégories
                        </a>
                        <a href="{{ route('admin.workout-sections.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-layer-group me-2"></i>Gérer les sections
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
.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
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