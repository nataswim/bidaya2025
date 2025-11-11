@extends('layouts.admin')

@section('title', 'Gestion des Sections du Catalogue')
@section('page-title', 'Sections du Catalogue')
@section('page-description', 'Gestion des sections du catalogue')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des sections -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-layer-group me-2"></i>Sections du Catalogue
                            </h5>
                            <small class="opacity-75">{{ $sections->total() ?? $sections->count() }} section(s) au total</small>
                        </div>
                        <a href="{{ route('admin.catalogue-sections.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Nouvelle section
                        </a>
                    </div>
                </div>
                
                <!-- Filtres -->
                <div class="card-body border-bottom p-4 bg-light">
                    <form method="GET" class="row g-3">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       class="form-control border-start-0"
                                       placeholder="Rechercher une section...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-2"></i>Filtrer
                                </button>
                                @if(request()->has('search'))
                                    <a href="{{ route('admin.catalogue-sections.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Sections -->
                <div class="card-body p-0">
                    @if($sections->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Section</th>
                                        <th class="border-0 px-4 py-3">Modules</th>
                                        <th class="border-0 px-4 py-3">Ordre</th>
                                        <th class="border-0 px-4 py-3">Statut</th>
                                        <th class="border-0 px-4 py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sections as $section)
                                        <tr class="border-bottom hover-bg">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-start">
                                                    @if($section->image)
                                                        <img src="{{ $section->image }}" 
                                                             class="rounded me-3" 
                                                             style="width: 60px; height: 45px; object-fit: cover;" 
                                                             alt="">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 45px;">
                                                            <i class="fas fa-layer-group text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('admin.catalogue-sections.show', $section) }}" 
                                                               class="text-decoration-none text-dark">
                                                                {{ Str::limit($section->name, 60) }}
                                                            </a>
                                                        </h6>
                                                        @if($section->short_description)
                                                            <small class="text-muted">{{ Str::limit(strip_tags($section->short_description), 80) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <span class="badge bg-primary-subtle text-primary">
                                                    {{ $section->modules_count }} module(s)
                                                </span>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <span class="badge bg-secondary">{{ $section->order }}</span>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                @if($section->is_active)
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="fas fa-check me-1"></i>Actif
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <i class="fas fa-pause me-1"></i>Inactif
                                                    </span>
                                                @endif
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
                                                               href="{{ route('admin.catalogue-sections.show', $section) }}">
                                                                <i class="fas fa-eye me-2 text-info"></i>Voir
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" 
                                                               href="{{ route('admin.catalogue-sections.edit', $section) }}">
                                                                <i class="fas fa-edit me-2 text-primary"></i>Modifier
                                                            </a>
                                                        </li>
                                                        @if($section->is_active)
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" 
                                                                   href="{{ route('public.catalogue.section', $section) }}" 
                                                                   target="_blank">
                                                                    <i class="fas fa-external-link-alt me-2 text-success"></i>Voir en ligne
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" 
                                                                  action="{{ route('admin.catalogue-sections.destroy', $section) }}" 
                                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette section ?')">
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
                        @if($sections->hasPages())
                            <div class="card-footer bg-white border-top p-4">
                                {{ $sections->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-layer-group fa-3x text-muted mb-3 opacity-25"></i>
                            <h5>Aucune section trouvée</h5>
                            <p class="text-muted mb-3">Commencez par créer votre première section</p>
                            <a href="{{ route('admin.catalogue-sections.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Créer une section
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar statistiques -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3 text-center">
                        <div class="col-12">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $stats['total'] }}</h4>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-success mb-1">{{ $stats['active'] }}</h4>
                                <small class="text-muted">Actives</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-warning mb-1">{{ $stats['inactive'] }}</h4>
                                <small class="text-muted">Inactives</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-warning text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-tools me-2"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.catalogue-sections.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouvelle section
                        </a>
                        <a href="{{ route('admin.catalogue-modules.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-th me-2"></i>Gérer les modules
                        </a>
                        <a href="{{ route('admin.catalogue-units.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-file-alt me-2"></i>Gérer les unités
                        </a>
                        <a href="{{ route('public.catalogue.index') }}" class="btn btn-outline-success" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Voir le catalogue
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
.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}
.hover-bg:hover {
    background-color: #f8f9fa;
}
</style>
@endpush