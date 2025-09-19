@extends('layouts.public')

@section('title', 'Articles')

@section('content')
<!-- En-tête de section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Nos Articles</h1>
                <p class="lead mb-0">Découvrez nos derniers contenus sur le développement web, les technologies modernes et les bonnes pratiques.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 120px; height: 120px;">
                    <i class="fas fa-book-open" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtres et recherche -->
<section class="py-4 bg-white border-bottom">
    <div class="container-lg">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           class="form-control"
                           placeholder="Rechercher dans les articles...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $category === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        Filtrer
                    </button>
                    @if($search || $category)
                        <a href="{{ route('public.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Articles -->
<section class="py-5 bg-light">
    <div class="container-lg">
        @if($posts->count() > 0)
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <article class="card border-0 shadow-sm h-100 hover-lift">
                            @if($post->image)
                                <div class="position-relative">
                                    <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->name }}" 
                                         style="height: 220px; object-fit: cover;">
                                    @if($post->is_featured)
                                        <div class="position-absolute top-3 end-3">
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star me-1"></i>Featured
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="bg-gradient-primary d-flex align-items-center justify-content-center text-white" 
                                     style="height: 220px;">
                                    <div class="text-center">
                                        <i class="fas fa-file-alt fa-3x opacity-50 mb-3"></i>
                                        <div>{{ $post->category->name ?? 'Article' }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column p-4">
                                <!-- Métadonnées -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $post->category->name ?? 'Non catégorisé' }}
                                        </span>
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $post->created_at?->format('d M Y') ?? 'Non daté' }}
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Titre -->
                                <h5 class="card-title mb-3">
                                    <a href="{{ route('public.show', $post) }}" 
                                       class="text-decoration-none text-dark stretched-link">
                                        {{ $post->name }}
                                    </a>
                                </h5>
                                
                                <!-- Intro -->
                                @if($post->intro)
                                    <p class="card-text text-muted flex-grow-1 mb-3">
                                        {{ Str::limit($post->intro, 120) }}
                                    </p>
                                @endif
                                
                                <!-- Footer -->
                                <div class="mt-auto">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-eye me-1"></i>
                                            <span>{{ $post->hits }}</span>
                                        </div>
                                        <div class="text-primary fw-medium">
                                            Lire la suite
                                            <i class="fas fa-arrow-right ms-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- État vide -->
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                     style="width: 120px; height: 120px;">
                    <i class="fas fa-search text-muted fa-3x"></i>
                </div>
                <h3 class="fw-bold mb-3">Aucun article trouvé</h3>
                <p class="text-muted mb-4">
                    @if($search || $category)
                        Aucun résultat ne correspond à vos critères de recherche.
                    @else
                        Il n'y a pas encore d'articles publiés.
                    @endif
                </p>
                @if($search || $category)
                    <a href="{{ route('public.index') }}" class="btn btn-primary">
                        Voir tous les articles
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection