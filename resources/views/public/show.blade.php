@extends('layouts.public')

@section('title', $post->meta_title ?: $post->name)
@section('meta_description', $post->meta_description ?: Str::limit($post->intro, 160))

@section('content')
<!-- Breadcrumb -->
<nav class="bg-light py-3">
    <div class="container-lg">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Accueil
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('public.index') }}" class="text-decoration-none">Articles</a>
            </li>
            @if($post->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('public.index', ['category' => $post->category->slug]) }}" class="text-decoration-none">
                        {{ $post->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ Str::limit($post->name, 50) }}</li>
        </ol>
    </div>
</nav>

<!-- Article principal -->
<article class="py-5">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- En-tête article -->
                <div class="mb-5">
                    <!-- Métadonnées -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            {{ $post->category->name ?? 'Non catégorisé' }}
                        </span>
                        
                        @if($post->is_featured)
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                <i class="fas fa-star me-1"></i>Article mis en avant
                            </span>
                        @endif
                        
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-calendar me-2"></i>
                            <span>{{ $post->published_at?->format('d F Y') ?? $post->created_at?->format('d F Y') ?? 'Non daté' }}</span>
                        </div>
                        
                        @if($post->creator)
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-user me-2"></i>
                                <span>{{ $post->creator->name }}</span>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-eye me-2"></i>
                            <span>{{ number_format($post->hits) }} vue{{ $post->hits > 1 ? 's' : '' }}</span>
                        </div>
                    </div>

                    <!-- Titre -->
                    <h1 class="display-4 fw-bold mb-4">{{ $post->name }}</h1>

                    <!-- Introduction -->
                    @if($post->intro)
                        <div class="lead text-muted mb-4 p-4 bg-light rounded-3 border-start border-primary border-4">
                            {{ $post->intro }}
                        </div>
                    @endif
                </div>

                <!-- Image à la une -->
                @if($post->image)
                    <div class="mb-5">
                        <img src="{{ $post->image }}" 
                             alt="{{ $post->name }}" 
                             class="img-fluid rounded-3 shadow-sm">
                    </div>
                @endif

                <!-- Contenu -->
                <div class="article-content mb-5">
                    <div class="fs-5 lh-lg">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="mb-5">
                        <h5 class="fw-semibold mb-3">Tags associés</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Partage -->
                <div class="border-top border-bottom py-4 mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-2">Partagez cet article</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-twitter me-1"></i>Twitter
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook me-1"></i>Facebook
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-linkedin me-1"></i>LinkedIn
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(window.location.href)">
                                    <i class="fas fa-link me-1"></i>Copier le lien
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Dernière mise à jour : {{ $post->updated_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Articles similaires -->
@if($relatedPosts && $relatedPosts->count() > 0)
    <section class="py-5 bg-light">
        <div class="container-lg">
            <h2 class="text-center fw-bold mb-5">Articles similaires</h2>
            <div class="row g-4">
                @foreach($relatedPosts as $relatedPost)
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100 hover-lift">
                            @if($relatedPost->image)
                                <img src="{{ $relatedPost->image }}" 
                                     class="card-img-top" 
                                     alt="{{ $relatedPost->name }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-file-alt text-primary fa-2x"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('public.show', $relatedPost) }}" 
                                       class="text-decoration-none text-dark stretched-link">
                                        {{ $relatedPost->name }}
                                    </a>
                                </h5>
                                @if($relatedPost->intro)
                                    <p class="card-text text-muted">
                                        {{ Str::limit($relatedPost->intro, 100) }}
                                    </p>
                                @endif
                                <small class="text-muted">
                                    {{ $relatedPost->published_at?->format('d M Y') ?? $relatedPost->created_at?->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection

@push('styles')
<style>
.article-content p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
}

.article-content h2,
.article-content h3,
.article-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content blockquote {
    border-left: 4px solid var(--bs-primary);
    padding-left: 1.5rem;
    font-style: italic;
    color: var(--bs-secondary);
    margin: 2rem 0;
}

.article-content code {
    background-color: var(--bs-light);
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}
</style>
@endpush