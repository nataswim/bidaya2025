@extends('layouts.public')

@section('title', 'Articles')

@section('content')
<!-- En-tête de section -->

<section class="text-white py-5" style="border-left: 2px dashed #f9f5f4;margin-bottom: 20px;background: linear-gradient(
76deg, #086690 0%, #0f5c78 100%);border-right: 2px dashed #f9f5f4;border-bottom: 2px dashed #f9f5f4;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h1 class="display-5 fw-bold mb-3">Articles & Dossiers</h1>
                <p class="lead mb-0">Decouvrez nos derniers contenus et dossiers pratiques.</p>

            </div>
            <div class="col-lg-5 text-center">

                <a href="{{ route('contact') }}">



                    <img src="{{ asset('assets/images/team/auteur-coach-hassan-el-haouat-nataswim-15.png') }}"
                        alt="Guide Nataswim"
                        class="img-fluid rounded-4"
                        style="max-height: 200px; object-fit: cover;">

                </a>

            </div>
        </div>
    </div>
</section>










<!-- Filtres et recherche -->
<section class="py-4 border-bottom" style="border-right: 10px solid #0e5f7f;margin-bottom: 20px;background-color: #ecf0f3;border-left: 10px solid #0c5e7d;">
    <div class="container-lg">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
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
                    <option value="">Toutes les categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ $category === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }} ({{ $cat->posts_count ?? 0 }})
                    </option>
                    @endforeach
                </select>
            </div>
            @if(isset($tags) && $tags->count() > 0)
            <div class="col-md-2">
                <select name="tag" class="form-select">
                    <option value="">Tous les tags</option>
                    @foreach($tags as $tagItem)
                    <option value="{{ $tagItem->slug }}" {{ ($tag ?? '') === $tagItem->slug ? 'selected' : '' }}>
                        {{ $tagItem->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                    @if($search || $category || ($tag ?? ''))
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
        <!-- Statistiques de recherche -->
        @if($search || $category || ($tag ?? ''))
        <div class="mb-4">
            <div class="alert alert-info border-0">
                <i class="fas fa-water me-2"></i>
                {{ $posts->total() }} resultat(s) trouve(s)
                @if($search)
                pour "<strong>{{ $search }}</strong>"
                @endif
                @if($category)
                dans la categorie "<strong>{{ $categories->where('slug', $category)->first()->name ?? $category }}</strong>"
                @endif
            </div>
        </div>
        @endif

        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <article class="card border-0 shadow-sm h-100 hover-lift">
                    <!-- Image et badges -->
                    <div class="position-relative">
                        @if($post->image)
                        <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->name }}"
                            style="height: 220px; object-fit: cover;">
                        @else
                        <div class="bg-gradient-secondary d-flex align-items-center justify-content-center text-white"
                            style="height: 220px;">
                            <div class="text-center">
                                <i class="fas fa-file-alt fa-3x opacity-50 mb-3"></i>
                                <div>{{ $post->category->name ?? 'Article' }}</div>
                            </div>
                        </div>
                        @endif

                        <!-- Badges en overlay -->
                        <div class="position-absolute top-0 end-0 p-3">
                            @if($post->is_featured)
                            <span class="badge bg-warning text-dark mb-2 d-block">
                                <i class="fas fa-star me-1"></i>A la une
                            </span>
                            @endif

                            @if($post->visibility === 'authenticated')
                            <span class="badge bg-info d-block">
                                <i class="fas fa-lock me-1"></i>Membre
                            </span>
                            @endif
                        </div>

                        <!-- Indicateur de temps de lecture -->
                        <div class="position-absolute bottom-0 start-0 p-3">
                            <span class="badge bg-dark bg-opacity-75">
                                <i class="fas fa-clock me-1"></i>{{ $post->reading_time ?? 5 }} min
                            </span>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <!-- Metadonnees -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $post->category->name ?? 'Non categorise' }}
                                </span>
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') ?? 'Non date' }}
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

                        <!-- Intro (toujours visible) -->
                        @if($post->intro)
                        <p class="card-text text-muted flex-grow-1 mb-3">
                            {!! Str::limit(strip_tags($post->intro), 120) !!}
                        </p>
                        @endif

                        <!-- Footer avec informations de visibilite -->
                        <div class="mt-auto">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-eye me-1"></i>
                                    <span>{{ number_format($post->hits) }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    @if($post->visibility === 'authenticated' && auth()->guest())
                                    <small class="text-warning">
                                        <i class="fas fa-lock me-1"></i>Connexion requise
                                    </small>
                                    @else
                                    <div class="text-primary fw-medium">
                                        Lire l'article
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </div>
                                    @endif
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
            {{ $posts->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif
        @else
        <!-- etat vide -->
        <div class="text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                style="width: 120px; height: 120px;">
                <i class="fas fa-search text-muted fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Aucun article trouve</h3>
            <p class="text-muted mb-4">
                @if($search || $category || ($tag ?? ''))
                Aucun resultat ne correspond A vos criteres de recherche.
                @else
                Il n'y a pas encore d'articles publies.
                @endif
            </p>
            @if($search || $category || ($tag ?? ''))
            <a href="{{ route('public.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Voir tous les articles
            </a>
            @endif
        </div>
        @endif
    </div>
</section>


@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
    }

    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    }

    .hover-lift {
        transition: transform 0.2s ease-in-out;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.1);
    }

    .pagination .page-link {
        border-color: #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #0f5c78;
        border-color: #ffffff;
    }

    .pagination .page-link:hover {
        color: #0284c7;
        background-color: #f8f9fa;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
</style>
@endpush