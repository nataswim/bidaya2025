@extends('layouts.admin')

@section('title', 'Gestion des Articles')
@section('page-title', 'Articles')
@section('page-description', 'Gestion des articles et contenus')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des articles -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-newspaper me-2"></i>Articles
                            </h5>
                            <small class="opacity-75">{{ $posts->total() ?? $posts->count() }} article(s) au total</small>
                        </div>
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Nouvel article
                        </a>
                    </div>
                </div>
                
                <!-- Filtres -->
                <div class="card-body border-bottom p-4 bg-light">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
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
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                                    <i class="fas fa-check"></i> Publiés
                                </option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                                    <i class="fas fa-edit"></i> Brouillons
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="visibility" class="form-select">
                                <option value="">Toute visibilité</option>
                                <option value="public" {{ request('visibility') === 'public' ? 'selected' : '' }}>
                                    <i class="fas fa-globe"></i> Public
                                </option>
                                <option value="authenticated" {{ request('visibility') === 'authenticated' ? 'selected' : '' }}>
                                    <i class="fas fa-lock"></i> Membres
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">Toutes catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-2"></i>Filtrer
                                </button>
                                @if(request()->hasAny(['search', 'status', 'visibility', 'category']))
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Articles -->
                <div class="card-body p-0">
                    @if($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Article</th>
                                        <th class="border-0 px-4 py-3">Statut & Visibilité</th>
                                        <th class="border-0 px-4 py-3">Catégorie</th>
                                        <th class="border-0 px-4 py-3">Auteur</th>
                                        <th class="border-0 px-4 py-3">Stats</th>
                                        <th class="border-0 px-4 py-3">Date</th>
                                        <th class="border-0 px-4 py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                        <tr class="border-bottom hover-bg">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-start">
                                                    @if($post->image)
                                                        <img src="{{ $post->image }}" 
                                                             class="rounded me-3" 
                                                             style="width: 60px; height: 45px; object-fit: cover;" 
                                                             alt="">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 45px;">
                                                            <i class="fas fa-file-alt text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('admin.posts.show', $post) }}" 
                                                               class="text-decoration-none text-dark">
                                                                {{ Str::limit($post->name, 60) }}
                                                            </a>
                                                        </h6>
                                                        @if($post->intro)
                                                            <small class="text-muted">{{ Str::limit($post->intro, 80) }}</small>
                                                        @endif
                                                        @if($post->is_featured)
                                                            <span class="badge bg-warning-subtle text-warning ms-2">
                                                                <i class="fas fa-star me-1"></i>À la une
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column gap-1">
                                                    <!-- Statut -->
                                                    <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}-subtle text-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                                        <i class="fas fa-{{ $post->status === 'published' ? 'check' : 'edit' }} me-1"></i>
                                                        {{ ucfirst($post->status) }}
                                                    </span>
                                                    
                                                    <!-- Visibilité -->
                                                    @if($post->visibility === 'authenticated')
                                                        <span class="badge bg-info-subtle text-info" title="Contenu réservé aux membres connectés">
                                                            <i class="fas fa-lock me-1"></i>Membres
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success-subtle text-success" title="Contenu accessible à tous">
                                                            <i class="fas fa-globe me-1"></i>Public
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                @if($post->category)
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $post->category->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Non catégorisé</span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                @if($post->creator)
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                             style="width: 32px; height: 32px;">
                                                            <span class="small fw-bold text-primary">
                                                                {{ substr($post->creator->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $post->creator->name }}</div>
                                                            <small class="text-muted">{{ $post->creator->role->display_name ?? $post->creator->role->name ?? 'Utilisateur' }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Auteur inconnu</span>
                                                @endif
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center text-muted">
                                                        <i class="fas fa-eye me-1"></i>
                                                        <span>{{ number_format($post->hits) }}</span>
                                                    </div>
                                                    @if($post->tags->count() > 0)
                                                        <small class="text-muted">
                                                            <i class="fas fa-tags me-1"></i>{{ $post->tags->count() }} tag(s)
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column">
                                                    <small class="fw-semibold">
                                                        {{ $post->published_at?->format('d/m/Y') ?? $post->created_at?->format('d/m/Y') ?? 'N/A' }}
                                                    </small>
                                                    <small class="text-muted">
                                                        {{ $post->published_at?->format('H:i') ?? $post->created_at?->format('H:i') ?? '' }}
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
                                                               href="{{ route('admin.posts.show', $post) }}">
                                                                <i class="fas fa-eye me-2 text-info"></i>Voir
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center" 
                                                               href="{{ route('admin.posts.edit', $post) }}">
                                                                <i class="fas fa-edit me-2 text-primary"></i>Modifier
                                                            </a>
                                                        </li>
                                                        @if($post->status === 'published')
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center" 
                                                                   href="{{ route('public.show', $post) }}" 
                                                                   target="_blank">
                                                                    <i class="fas fa-external-link-alt me-2 text-success"></i>Voir en ligne
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" 
                                                                  action="{{ route('admin.posts.destroy', $post) }}" 
                                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
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
                        @if($posts->hasPages())
                            <div class="card-footer bg-white border-top p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-muted">
                                        Affichage de {{ $posts->firstItem() }} à {{ $posts->lastItem() }} 
                                        sur {{ $posts->total() }} résultat(s)
                                    </div>
                                    {{ $posts->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3 opacity-25"></i>
                            <h5>Aucun article trouvé</h5>
                            @if(request()->hasAny(['search', 'status', 'visibility', 'category']))
                                <p class="text-muted mb-3">Aucun résultat ne correspond à vos critères de recherche.</p>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Voir tous les articles
                                </a>
                            @else
                                <p class="text-muted mb-3">Commencez par créer votre premier article</p>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer un article
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
                        $totalPosts = \App\Models\Post::count();
                        $publishedPosts = \App\Models\Post::where('status', 'published')->count();
                        $draftPosts = \App\Models\Post::where('status', 'draft')->count();
                        $publicPosts = \App\Models\Post::where('visibility', 'public')->count();
                        $memberPosts = \App\Models\Post::where('visibility', 'authenticated')->count();
                    @endphp
                    
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $totalPosts }}</h4>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-success mb-1">{{ $publishedPosts }}</h4>
                                <small class="text-muted">Publiés</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-warning mb-1">{{ $draftPosts }}</h4>
                                <small class="text-muted">Brouillons</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-info mb-1">{{ $memberPosts }}</h4>
                                <small class="text-muted">Membres</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Répartition visibilité -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Visibilité
                    </h6>
                </div>
                <div class="card-body p-3">
                    @if($totalPosts > 0)
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-semibold text-success">
                                    <i class="fas fa-globe me-1"></i>Public
                                </span>
                                <span class="badge bg-success-subtle text-success">{{ $publicPosts }}</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ ($publicPosts / $totalPosts) * 100 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-semibold text-info">
                                    <i class="fas fa-lock me-1"></i>Membres
                                </span>
                                <span class="badge bg-info-subtle text-info">{{ $memberPosts }}</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" 
                                     style="width: {{ ($memberPosts / $totalPosts) * 100 }}%"></div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">Aucun article créé</p>
                    @endif
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
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouvel article
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-folder me-2"></i>Gérer les catégories
                        </a>
                        <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="btn btn-outline-info">
                            <i class="fas fa-edit me-2"></i>Voir les brouillons ({{ $draftPosts }})
                        </a>
                        @if($memberPosts > 0)
                            <a href="{{ route('admin.posts.index', ['visibility' => 'authenticated']) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-lock me-2"></i>Articles membres ({{ $memberPosts }})
                            </a>
                        @endif
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