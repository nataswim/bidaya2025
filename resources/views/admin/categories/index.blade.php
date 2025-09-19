@extends('layouts.admin')

@section('title', 'Gestion des Catégories')
@section('page-title', 'Catégories')
@section('page-description', 'Gestion des catégories d\'articles')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom p-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Liste des catégories</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouvelle catégorie
                </a>
            </div>
        </div>
        
        <!-- Filtres -->
        <div class="card-body border-bottom p-4">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               class="form-control border-start-0"
                               placeholder="Rechercher une catégorie...">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="fas fa-filter me-2"></i>Rechercher
                        </button>
                        @if($search)
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Tableau -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 px-4 py-3">Catégorie</th>
                        <th class="border-0 py-3">Groupe</th>
                        <th class="border-0 py-3">Articles</th>
                        <th class="border-0 py-3">Statut</th>
                        <th class="border-0 py-3">Ordre</th>
                        <th class="border-0 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 45px; height: 45px;">
                                        @if($category->image)
                                            <img src="{{ $category->image }}" class="rounded" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                                        @else
                                            <i class="fas fa-folder text-info"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $category->name }}</h6>
                                        @if($category->slug)
                                            <small class="text-muted">{{ $category->slug }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($category->group_name)
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $category->group_name }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold">{{ $category->posts_count ?? $category->posts()->count() }}</span>
                                    <small class="text-muted ms-1">articles</small>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'warning' }}-subtle text-{{ $category->status === 'active' ? 'success' : 'warning' }}">
                                    {{ $category->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3">
                                @if($category->order)
                                    <span class="badge bg-light text-dark border">{{ $category->order }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.categories.show', $category) }}">
                                                <i class="fas fa-eye me-2"></i>Voir
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.categories.edit', $category) }}">
                                                <i class="fas fa-edit me-2"></i>Modifier
                                            </a>
                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('public.index', ['category' => $category->slug]) }}" target="_blank">
                                                <i class="fas fa-external-link-alt me-2"></i>Voir sur le site
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="dropdown-item text-danger"
                                                        data-confirm="delete">
                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-3"></i>
                                    <div>Aucune catégorie trouvée</div>
                                    <small>Créez votre première catégorie pour organiser vos articles</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="card-footer bg-white border-top p-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection