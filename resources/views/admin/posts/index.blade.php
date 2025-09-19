@extends('layouts.admin')

@section('title', 'Gestion des Articles')
@section('page-title', 'Articles')
@section('page-description', 'Gestion des articles et publications')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom p-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Liste des articles</h5>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouvel article
                </a>
            </div>
        </div>
        
        <!-- Filtres et recherche -->
        <div class="card-body border-bottom p-4">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               class="form-control border-start-0"
                               placeholder="Rechercher un article...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="fas fa-filter me-2"></i>Filtrer
                        </button>
                        @if($search || request('status'))
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
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
                        <th class="border-0 px-4 py-3">Article</th>
                        <th class="border-0 py-3">Catégorie</th>
                        <th class="border-0 py-3">Statut</th>
                        <th class="border-0 py-3">Vues</th>
                        <th class="border-0 py-3">Date</th>
                        <th class="border-0 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 45px; height: 45px;">
                                        @if($post->image)
                                            <img src="{{ $post->image }}" class="rounded" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                                        @else
                                            <i class="fas fa-file-alt text-primary"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $post->name }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($post->is_featured)
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="fas fa-star me-1"></i>Featured
                                                </span>
                                            @endif
                                            <small class="text-muted">{{ Str::limit($post->slug, 30) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($post->category)
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-muted">Non catégorisé</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}-subtle text-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-eye text-muted me-2"></i>
                                    {{ number_format($post->hits) }}
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-muted">
                                    {{ $post->created_at?->format('d/m/Y') ?? 'N/A' }}
                                    @if($post->created_at)
                                        <br><small>{{ $post->created_at->format('H:i') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.posts.show', $post) }}">
                                                <i class="fas fa-eye me-2"></i>Voir
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.posts.edit', $post) }}">
                                                <i class="fas fa-edit me-2"></i>Modifier
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('public.show', $post) }}" target="_blank">
                                                <i class="fas fa-external-link-alt me-2"></i>Voir sur le site
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline">
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
                                    <i class="fas fa-inbox fa-2x mb-3"></i>
                                    <div>Aucun article trouvé</div>
                                    <small>Commencez par créer votre premier article</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="card-footer bg-white border-top p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-muted">
                        Affichage de {{ $posts->firstItem() }} à {{ $posts->lastItem() }} 
                        sur {{ $posts->total() }} résultats
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection