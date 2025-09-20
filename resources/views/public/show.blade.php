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
                        <span class="badge bg-primary px-3 py-2">
                            {{ $post->category->name ?? 'Non catégorisé' }}
                        </span>
                        
                        @if($post->is_featured)
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-star me-1"></i>Article mis en avant
                            </span>
                        @endif

                        @if($post->visibility === 'authenticated')
                            <span class="badge bg-info px-3 py-2">
                                <i class="fas fa-lock me-1"></i>Contenu membre
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

                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-clock me-2"></i>
                            <span>{{ $post->reading_time ?? 5 }} min de lecture</span>
                        </div>
                    </div>

                    <!-- Titre -->
                    <h1 class="display-4 fw-bold mb-4">{{ $post->name }}</h1>

                    <!-- Introduction (toujours visible) -->
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

                <!-- Contenu (conditionnel selon visibilité) -->
                <div class="article-content mb-5">
                    @if($contentVisible)
                        <!-- Contenu complet pour les utilisateurs autorisés -->
                        <div class="fs-5 lh-lg">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    @else
                        <!-- Message pour les utilisateurs non autorisés -->
                        <div class="content-restricted">
                            <div class="alert alert-info border-0 shadow-sm">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-lock text-primary fs-3"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h4 class="alert-heading mb-2">
                                            <i class="fas fa-crown text-warning me-2"></i>
                                            Contenu exclusif membre
                                        </h4>
                                        <p class="mb-3">
                                            Cet article fait partie de nos contenus premium. Pour continuer la lecture et accéder à l'ensemble de nos ressources exclusives, créez votre compte gratuit ou connectez-vous.
                                        </p>
                                        <div class="d-flex flex-column flex-md-row gap-2">
                                            <a href="{{ route('register') }}" class="btn btn-primary">
                                                <i class="fas fa-user-plus me-2"></i>Créer un compte gratuit
                                            </a>
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Aperçu tronqué du contenu -->
                            @if($post->content)
                                <div class="content-preview position-relative mt-4">
                                    <div class="text-muted border rounded p-4" style="max-height: 200px; overflow: hidden;">
                                        <h5 class="text-dark mb-3">Aperçu du contenu :</h5>
                                        {{ Str::limit(strip_tags($post->content), 400) }}
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 w-100 text-center py-3" 
                                         style="background: linear-gradient(transparent, white, white);">
                                        <small class="text-muted">
                                            <i class="fas fa-ellipsis-h"></i> Contenu complet disponible pour les membres
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Tags (toujours visibles) -->
                @if($post->tags->count() > 0)
                    <div class="mb-5">
                        <h5 class="fw-semibold mb-3">
                            <i class="fas fa-tags me-2 text-warning"></i>Tags associés
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('public.index', ['tag' => $tag->slug]) }}" 
                                   class="badge bg-light text-dark border px-3 py-2 text-decoration-none">
                                    <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                                </a>
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
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->name) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-twitter me-1"></i>Twitter
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook me-1"></i>Facebook
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-linkedin me-1"></i>LinkedIn
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" 
                                        onclick="navigator.clipboard.writeText(window.location.href); alert('Lien copié!')">
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

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Call-to-action pour non-membres (si contenu restreint) -->
                @if(!$contentVisible)
                    <div class="card border-0 shadow-sm bg-gradient-primary text-white mb-4 sticky-top">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-crown fa-2x mb-3 opacity-75"></i>
                            <h5 class="mb-3">Devenez membre</h5>
                            <p class="mb-3 opacity-75 small">
                                Accédez à cet article et à tous nos contenus exclusifs en créant votre compte gratuit.
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('register') }}" class="btn btn-light">
                                    <i class="fas fa-user-plus me-2"></i>Inscription gratuite
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Articles similaires -->
                @if($relatedPosts && $relatedPosts->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light p-3">
                            <h6 class="mb-0">
                                <i class="fas fa-newspaper me-2 text-primary"></i>Articles similaires
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            @foreach($relatedPosts->take(4) as $relatedPost)
                                <div class="d-flex align-items-start mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                    @if($relatedPost->image)
                                        <img src="{{ $relatedPost->image }}" 
                                             class="rounded me-3" 
                                             style="width: 80px; height: 60px; object-fit: cover;" 
                                             alt="">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 80px; height: 60px;">
                                            <i class="fas fa-file-alt text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-fill">
                                        <a href="{{ route('public.show', $relatedPost) }}" 
                                           class="text-decoration-none">
                                            <h6 class="mb-1 small">{{ Str::limit($relatedPost->name, 60) }}</h6>
                                        </a>
                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted">
                                                {{ $relatedPost->published_at?->format('d M') ?? $relatedPost->created_at?->format('d M') }}
                                            </small>
                                            @if($relatedPost->visibility === 'authenticated')
                                                <span class="badge bg-warning-subtle text-warning small">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</article>

<!-- Articles similaires (section complète) -->
@if($relatedPosts && $relatedPosts->count() > 0)
    <section class="py-5 bg-light">
        <div class="container-lg">
            <h2 class="text-center fw-bold mb-5">Vous pourriez aussi aimer</h2>
            <div class="row g-4">
                @foreach($relatedPosts->take(3) as $relatedPost)
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100 hover-lift">
                            <div class="position-relative">
                                @if($relatedPost->image)
                                    <img src="{{ $relatedPost->image }}" 
                                         class="card-img-top" 
                                         alt="{{ $relatedPost->name }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-gradient-secondary d-flex align-items-center justify-content-center text-white" 
                                         style="height: 200px;">
                                        <i class="fas fa-file-alt fa-2x"></i>
                                    </div>
                                @endif

                                @if($relatedPost->visibility === 'authenticated')
                                    <span class="position-absolute top-0 end-0 m-3 badge bg-info">
                                        <i class="fas fa-lock me-1"></i>Membre
                                    </span>
                                @endif
                            </div>
                            
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
                                <small class="text-muted d-flex align-items-center justify-content-between">
                                    <span>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $relatedPost->published_at?->format('d M Y') ?? $relatedPost->created_at?->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-eye me-1"></i>
                                        {{ number_format($relatedPost->hits) }}
                                    </span>
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
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

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

.content-preview {
    opacity: 0.8;
}

.content-restricted .alert {
    border-left: 4px solid #0ea5e9;
}

.hover-lift {
    transition: transform 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-5px);
}

.sticky-top {
    top: 2rem;
}
</style>
@endpush