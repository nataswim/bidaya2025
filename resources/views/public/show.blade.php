@extends('layouts.public')

{{-- SEO Meta --}}
@section('title', $post->meta_title ?: $post->name)
@section('meta_description', $post->meta_description ?: ($post->intro ? Str::limit(strip_tags($post->intro), 160) : Str::limit(strip_tags($post->content), 160)))
@section('meta_keywords', $post->meta_keywords ?: '')

{{-- Open Graph / Facebook --}}
@section('og_type', 'article')
@section('og_title', $post->name)
@section('og_description', $post->intro ? Str::limit(strip_tags($post->intro), 200) : Str::limit(strip_tags($post->content), 200))
@section('og_url', route('public.show', $post))
@if($post->image)
@section('og_image', $post->image)
@section('og_image_alt', $post->name)
@endif

{{-- Twitter Card --}}
@section('twitter_title', $post->name)
@section('twitter_description', $post->intro ? Str::limit(strip_tags($post->intro), 200) : Str::limit(strip_tags($post->content), 200))
@if($post->image)
@section('twitter_image', $post->image)
@section('twitter_image_alt', $post->name)
@endif

@section('content')


<!-- Section titre -->
<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-lg mb-4 mb-lg-0">
                    <h1 class="fw-bold mb-0">{{ $post->name }}</h1>
                </div>
            </div>
</section>


<section class="py-5 text-center">
    <div class="container-lg">
        <div class="container-lg">
            <div class="row justify-content-center align-items-center">
                @if($post->image)
                <div class="col-lg">
                    <img src="{{ $post->image }}"
                        alt="{{ $post->name }}"
                        class="img-fluid rounded shadow"
                        style="object-fit: cover; width: auto !important;">
                        </div>
                @endif
            </div>
        </div>
    </div>
</section>





<article class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-12">

                <!-- Card 1: Métadonnées et Introduction -->
                <div class="card border-0 shadow-sm mb-4" style="background-color: #fbf7f0;">
                    <div class="card-body p-4">
                        <!-- Métadonnées -->
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted mb-4">
                            <span class="badge bg-primary px-3 py-2">
                                {{ $post->category->name ?? 'Actualites' }}
                            </span>

                            <span class="d-flex align-items-center">
                                <i class="fas fa-eye me-1"></i>
                                {{ number_format($post->hits) }} vue{{ $post->hits > 1 ? 's' : '' }}
                            </span>

                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $post->published_at?->format('d M Y') ?? $post->created_at?->format('d M Y') }}
                            </span>

                            <span class="d-flex align-items-center">
                                <i class="fas fa-clock me-1"></i>
                                {{ $post->reading_time ?? 5 }} min de lecture
                            </span>

                            @if($post->tags->count() > 0)
                            <span class="d-flex align-items-center">
                                <i class="fas fa-tags me-1"></i>
                                @foreach($post->tags as $tag)
                                <span class="badge bg-secondary-subtle text-secondary me-1 small">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <x-add-to-notebook-button
                                content-type="posts"
                                :content-id="$post->id" />
                        </div>
                        <!-- Introduction -->
                        @if($post->intro)
                        <div class="border-top pt-4">
                            <div class="lead text-dark" style="font-size: 100%;">
                                {!! $post->intro !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Card 2: Contenu principal -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="article-content">
                            @if($contentVisible)
                            <div class="fs-6 lh-lg">
                                {!! $post->content !!}
                            </div>
                            @else
                            <!-- Message d'acces restreint -->
                            <div class="content-restricted">
                                <div class="alert alert-info border-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-lock text-primary fs-2"></i>
                                        </div>
                                        <div class="col">
                                            <h5 class="alert-heading mb-2">Contenu exclusif membre</h5>
                                            <p class="mb-3">
                                                Cet article fait partie de nos contenus premium. Creez votre compte gratuit pour continuer la lecture.
                                            </p>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-user-plus me-2"></i>Inscription
                                                </a>
                                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Apercu tronque -->
                                @if($post->content)
                                <div class="content-preview position-relative mt-3">
                                    <div class="text-muted p-3 border rounded" style="max-height: 150px; overflow: hidden;">
                                        {!! Str::limit(strip_tags($post->content), 300) !!}
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 w-100 text-center py-2"
                                        style="background: linear-gradient(transparent, white, white);">
                                        <small class="text-muted">Contenu complet disponible pour les membres</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card 3: Dernieres publications -->
                @if(isset($recentPosts) && $recentPosts->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-water me-2 text-success"></i>
                            Dernieres publications
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($recentPosts->take(4) as $recentPost)
                        <div class="p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="row align-items-center">
                                @if($recentPost->image)
                                <div class="col-auto">
                                    <img src="{{ $recentPost->image }}"
                                        class="rounded"
                                        style="width: 80px; height: 60px; object-fit: cover;"
                                        alt="">
                                </div>
                                @endif
                                <div class="col">
                                    <a href="{{ route('public.show', $recentPost) }}"
                                        class="text-decoration-none">
                                        <h6 class="mb-1">{!! Str::limit($recentPost->name, 60) !!}</h6>
                                    </a>

                                    <div class="small text-muted d-flex align-items-center gap-3">
                                        <span>
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $recentPost->published_at?->format('d M Y') ?? $recentPost->created_at?->format('d M Y') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-eye me-1"></i>
                                            {{ $recentPost->hits }} vues
                                        </span>
                                        @if($recentPost->visibility === 'authenticated')
                                        <span class="badge bg-warning-subtle text-warning small">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($recentPosts->count() > 4)
                        <div class="card-footer bg-light text-center">
                            <a href="{{ route('public.index') }}" class="btn btn-outline-primary btn-sm">
                                Voir tous les articles
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Card 4: Informations de l'article -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Informations 
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-folder me-1"></i>Categorie:
                                    </span>
                                    <strong>{{ $post->category->name ?? 'Non categorise' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Publie le:
                                    </span>
                                    <strong>{{ $post->published_at?->format('d F Y') ?? $post->created_at?->format('d F Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-eye me-1"></i>Nombre de vues:
                                    </span>
                                    <strong>{{ number_format($post->hits) }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-clock me-1"></i>Temps de lecture:
                                    </span>
                                    <strong>{{ $post->reading_time ?? 5 }} min</strong>
                                </div>
                            </div>
                            @if($post->creator)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-user me-1"></i>Auteur:
                                    </span>
                                    <strong><a href="https://www.instagram.com/med_hassan_el_haouat/" target="_blank" rel="noopener noreferrer" class="text-reset text-decoration-none">
            Med H EL HAOUAT
        </a></strong>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise a jour:
                                    </span>
                                    <strong>{{ $post->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton retour -->
                <div class="text-center">
                    <a href="{{ route('public.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour aux articles
                    </a>
                </div>

            </div>
        </div>
    </div>
</article>




<!-- Partage social -->

<div class="container-lg">
    <div class="card mb-4">
        <a href="{{ route('tools.index') }}" class="btn btn-primary text-light btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Essayer Nos Outils & Calculateurs
        </a>
    </div>
</div>





<!-- Dernieres Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-water text-primary me-2"></i>Publications
            </h2>

        </div>

        @php
        $latestPosts = App\Models\Post::with('category')
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
            @endphp

            @if($latestPosts->count() > 0)
            <div class="row g-4">
                @foreach($latestPosts as $post)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm hover-lift border-0">
                        <div style="height: 180px; overflow: hidden;">
                            @if($post->image)
                            <img src="{{ $post->image }}"
                                alt="{{ $post->name }}"
                                class="card-img-top"
                                style="height: 100%; width: 100%; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                <i class="fas fa-swimmer text-muted" style="font-size: 2.5rem;"></i>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($post->category)
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $post->category->name }}</span>
                            </div>
                            @endif
                            <h3 class="card-title h5 mb-3">{{ $post->name }}</h3>

                            @if($post->intro)
                            <p class="card-text text-muted small">
                                {!! Str::limit(strip_tags($post->intro), 100) !!}
                            </p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <small class="text-muted d-flex align-items-center">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $post->published_at->format('d/m/Y') }}
                            </small>
                            <a href="{{ route('public.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                Lire la suite
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info" role="alert">
                <i class="fas fa-water me-2"></i>Aucun article n'est disponible actuellement.
            </div>
            @endif
    </div>
</section>






@endsection

@push('styles')
<style>
    /* Styles pour le contenu Quill */
    .article-content h1,
    .article-content h2,
    .article-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
        line-height: 1.3;
    }

    .article-content h1 {
        font-size: 1.8rem;
        color: #2d3748;
    }

    .article-content h2 {
        font-size: 1.5rem;
        color: #2d3748;
    }

    .article-content h3 {
        font-size: 1.3rem;
        color: #2d3748;
    }

    .article-content p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        text-align: justify;
        color: #4a5568;
    }

    .article-content ul,
    .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
        line-height: 1.7;
    }

    .article-content li {
        margin-bottom: 0.5rem;
    }

    .article-content blockquote {
        border-left: 4px solid #3182ce;
        padding: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        background: #f7fafc;
        border-radius: 0.375rem;
        color: #2d3748;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 2rem 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .article-content pre {
        background: #1a202c;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 2rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .article-content code {
        background-color: #edf2f7;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
        color: #d63384;
        font-family: 'Courier New', monospace;
    }

    .article-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 2rem 0;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .article-content th,
    .article-content td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .article-content th {
        background-color: #f7fafc;
        font-weight: 600;
    }

    .content-preview {
        opacity: 0.7;
    }

    .card {
        transition: box-shadow 0.2s ease;
    }

    @media (max-width: 991px) {

        /* Sur mobile/tablette, l'image passe en dessous du titre */
        .col-lg-7,
        .col-lg-5 {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .article-content {
            font-size: 0.95rem;
        }

        .display-5 {
            font-size: 1.75rem !important;
        }

        .d-flex.gap-3 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.75rem !important;
        }
    }
</style>
@endpush