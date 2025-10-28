@extends('layouts.public')

{{-- SEO Meta --}}
@section('title', $downloadable->title . ' - ' . $category->name)
@section('meta_description', $downloadable->short_description ?? 'Téléchargez ' . $downloadable->title . ' - ' . $downloadable->format_display)

{{-- Open Graph / Facebook --}}
@section('og_type', 'article')
@section('og_title', $downloadable->title)
@section('og_description', $downloadable->short_description ?? 'Document téléchargeable - ' . $downloadable->format_display)
@section('og_url', route('ebook.show', [$category->slug, $downloadable->slug]))
@if($downloadable->cover_image)
@section('og_image', $downloadable->cover_image)
@section('og_image_alt', $downloadable->title)
@endif

{{-- Twitter Card --}}
@section('twitter_title', $downloadable->title)
@section('twitter_description', $downloadable->short_description ?? 'Document ' . $downloadable->format_display)
@if($downloadable->cover_image)
@section('twitter_image', $downloadable->cover_image)
@endif

@section('content')
<!-- En-tête de section -->


<section class="py-5 bg-primary text-white text-center" style="background: linear-gradient(
1deg, #04adb9 0%, rgb(15 92 135) 100%);border-top: 20px solid #04adb9;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">
    <div class="container-lg">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-lg">
                    <h1 class="fw-bold mb-0">{{ $downloadable->title }}</h1>
                </div>
            </div>
        </div>
</section>
<!-- Breadcrumb -->
<section class="py-3 bg-light border-bottom">
    <div class="container-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('ebook.index') }}">
                        <i class="fas fa-home me-1"></i>Espace Téléchargement
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ebook.category', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {!! Str::limit($downloadable->title, 50) !!}
                </li>
            </ol>
        </nav>
    </div>
</section>
                <!-- Card 4.5: Image du fichier -->



 @if($downloadable->cover_image)
               <div>

                    <div>
                                                <div class="text-center">
                            <img src="{{ $downloadable->cover_image }}"
                                alt="{{ $downloadable->title }}"
                                class="img-fluid cursor-pointer"
                                style="max-height: 800px; object-fit: contain; cursor: pointer;"
                                onclick="openImageModal('{{ $downloadable->cover_image }}', '{{ addslashes($downloadable->title) }}')"
                                title="Cliquez pour agrandir">

                        </div>
                    </div>
                </div>

 @endif









<article class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-12">

                <!-- Card 1: Métadonnées -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted">

                            <span class="d-flex align-items-center">
                                <i class="fas fa-download me-1"></i>
                                11{{ number_format($downloadable->download_count) }} téléchargement{{ $downloadable->download_count > 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Description courte -->
                @if($downloadable->short_description)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-0"
                            style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                            <div class="lead">
                                {{ $downloadable->short_description }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Card 3: Description complète -->
                @if($downloadable->long_description)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Description détaillée
                        </h5>
                        <div class="content-display fs-6 lh-lg">
                            {!! $downloadable->long_description !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Card 4: Action de téléchargement -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4">
                            <i class="fas fa-download me-2 text-success"></i>
                            Téléchargement
                        </h5>

                        @if($downloadable->canBeDownloadedBy(auth()->user()))
                        <div class="d-grid gap-2 d-md-block">
                            <a href="{{ route('ebook.download', [$category->slug, $downloadable->slug]) }}"
                                class="btn btn-success btn-lg">
                                <i class="fas fa-download me-2"></i>Télécharger maintenant
                            </a>
                            <button class="btn btn-outline-primary btn-lg" onclick="shareContent()">
                                <i class="fas fa-share-alt me-2"></i>Partager
                            </button>
                        </div>

                        <div class="alert alert-success border-0 mt-4 mb-0">
                            <i class="fas fa-check-circle me-2"></i>
                            Vous avez accès à ce téléchargement. Cliquez sur le bouton ci-dessus pour commencer.
                        </div>
                        @else
                        <div class="alert alert-warning border-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-lock text-warning fs-2"></i>
                                </div>
                                <div class="col">
                                    <h5 class="alert-heading mb-2">Accès restreint</h5>
                                    <p class="mb-3">
                                        {{ $downloadable->getAccessMessage(auth()->user()) }}
                                    </p>
                                    @if(!auth()->check())
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('register') }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-user-plus me-2"></i>Inscription gratuite
                                        </a>
                                        <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>





                <!-- FIN DE LA NOUVELLE SECTION -->






















                <!-- Card 5: Informations du fichier -->
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
                                        <i class="fas fa-folder me-1"></i>Catégorie:
                                    </span>
                                    <strong>{{ $category->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-file me-1"></i>Format:
                                    </span>
                                    <strong>{{ $downloadable->format_display }}</strong>
                                </div>
                            </div>
                            @if($downloadable->file_size)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-hdd me-1"></i>Taille:
                                    </span>
                                    <strong>{{ $downloadable->file_size }}</strong>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-download me-1"></i>Téléchargements:
                                    </span>
                                    <strong>11{{ number_format($downloadable->download_count) }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>verifié le:
                                    </span>
                                    <strong>{{ $downloadable->created_at->format('d F Y') }}</strong>
                                </div>
                            </div>
                            @if($downloadable->creator)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-user me-1"></i>Conseillé par:
                                    </span>
                                    <strong>{{ $downloadable->creator->name }}</strong>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise à jour:
                                    </span>
                                    <strong>{{ $downloadable->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Navigation -->
                <div class="row g-4 mb-4">
                    <!-- Catégorie -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-folder me-2"></i>Catégorie
                                </h5>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('ebook.category', $category->slug) }}"
                                    class="d-flex align-items-center text-decoration-none">
                                    @if($category->image)
                                    <img src="{{ $category->image }}"
                                        class="rounded me-3"
                                        style="width: 70px; height: 70px; object-fit: cover;"
                                        alt="{{ $category->name }}">
                                    @else
                                    <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3"
                                        style="width: 70px; height: 70px;">
                                        <i class="fas fa-folder text-primary fs-3"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1 text-dark">{{ $category->name }}</h6>
                                        <small class="text-muted">Voir tous les téléchargements</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-compass me-2"></i>Navigation
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('ebook.category', $category->slug) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour à {!! Str::limit($category->name, 30) !!}
                                    </a>
                                    <a href="{{ route('ebook.index') }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-th me-2"></i>Toutes les catégories
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</article>

<!-- Ressources similaires -->
@if($relatedDownloads->count() > 0)
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-download text-primary me-2"></i>Autres ressources de {{ $category->name }}
            </h2>
        </div>

        <div class="row g-4">
            @foreach($relatedDownloads as $related)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative" style="height: 180px; overflow: hidden;">
                        @if($related->cover_image)
                        <img src="{{ $related->cover_image }}"
                            class="card-img-top"
                            style="height: 100%; width: 100%; object-fit: cover;"
                            alt="{{ $related->title }}">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                            style="height: 100%;">
                            <i class="fas fa-file-{{ $related->format === 'pdf' ? 'pdf' : ($related->format === 'mp4' ? 'video' : 'alt') }} text-muted"
                                style="font-size: 2.5rem;"></i>
                        </div>
                        @endif

                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-dark">{{ strtoupper($related->format) }}</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-2">{!! Str::limit($related->title, 60) !!}</h6>
                        <small class="text-muted mb-3">
                            <i class="fas fa-download me-1"></i>{{ number_format($related->download_count) }} téléchargements
                        </small>
                    </div>

                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('ebook.show', [$category->slug, $related->slug]) }}"
                            class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-eye me-2"></i>Voir
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Modal Image en grand -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0" onclick="event.stopPropagation()">
            <div class="modal-header border-0 position-absolute top-0 end-0 z-3" style="z-index: 1050;">
                <button type="button"
                    class="btn-close btn-close-white bg-dark rounded-circle p-3"
                    onclick="closeImageModal()"
                    aria-label="Fermer"
                    style="opacity: 0.9;">
                </button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="modalImage"
                    src=""
                    alt=""
                    class="img-fluid rounded shadow-lg"
                    style="max-height: 90vh; width: auto;"
                    onclick="event.stopPropagation()">
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styles pour le contenu HTML */
    .content-display h1,
    .content-display h2,
    .content-display h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
        line-height: 1.3;
    }

    .content-display h1 {
        font-size: 1.8rem;
        color: #2d3748;
    }

    .content-display h2 {
        font-size: 1.5rem;
        color: #2d3748;
    }

    .content-display h3 {
        font-size: 1.3rem;
        color: #2d3748;
    }

    .content-display p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        text-align: justify;
        color: #4a5568;
    }

    .content-display ul,
    .content-display ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
        line-height: 1.7;
    }

    .content-display li {
        margin-bottom: 0.5rem;
    }

    .content-display blockquote {
        border-left: 4px solid #3182ce;
        padding: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        background: #f7fafc;
        border-radius: 0.375rem;
        color: #2d3748;
    }

    .content-display img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 2rem 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .content-display pre {
        background: #1a202c;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 2rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .content-display code {
        background-color: #edf2f7;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
        color: #d63384;
        font-family: 'Courier New', monospace;
    }

    .card {
        transition: box-shadow 0.2s ease;
    }

    @media (max-width: 991px) {

        .col-lg-7,
        .col-lg-5 {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .content-display {
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

    /* Styles pour l'image cliquable */
    .cursor-pointer {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cursor-pointer:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    /* Modal personnalisée */
    #imageModal {
        z-index: 1050;
    }

    #imageModal.show {
        display: block !important;
    }

    #imageModal .modal-dialog {
        max-width: 95vw;
        margin: 1.75rem auto;
    }

    #imageModal .modal-content {
        background-color: rgba(0, 0, 0, 0.95) !important;
        border: none;
    }

    #imageModal img {
        cursor: zoom-out;
        max-height: 90vh;
        width: auto;
        max-width: 100%;
    }

    /* Backdrop personnalisé */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .modal-backdrop.fade {
        opacity: 0;
    }

    .modal-backdrop.show {
        opacity: 1;
    }

    /* Empêcher le scroll quand la modal est ouverte */
    body.modal-open {
        overflow: hidden;
    }

    /* Animation d'ouverture */
    @keyframes modalZoomIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    #imageModal.show img {
        animation: modalZoomIn 0.3s ease-out;
    }

    /* Bouton de fermeture amélioré */
    #imageModal .btn-close {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease;
        width: 50px;
        height: 50px;
        padding: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #imageModal .btn-close:hover {
        transform: rotate(90deg) scale(1.1);
        background-color: #dc3545 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #imageModal img {
            max-height: 80vh;
        }

        #imageModal .btn-close {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function shareContent() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $downloadable->title }}',
                text: '{{ $downloadable->short_description ?? "Découvrez cette ressource" }}',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Lien copié dans le presse-papiers !');
            });
        }
    }

    // Fonction pour ouvrir l'image en modal (JAVASCRIPT PUR)
    function openImageModal(imageUrl, imageTitle) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');

        modalImage.src = imageUrl;
        modalImage.alt = imageTitle;

        // Afficher la modal
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.classList.add('modal-open');

        // Créer le backdrop
        if (!document.querySelector('.modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.style.zIndex = '1040';
            document.body.appendChild(backdrop);
        }
    }

    // Fonction pour fermer la modal
    function closeImageModal() {
        const modal = document.getElementById('imageModal');

        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');

        // Supprimer le backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }

    // Event listeners pour fermer la modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('imageModal');
        const closeBtn = modal.querySelector('.btn-close');

        // Fermer avec le bouton X
        if (closeBtn) {
            closeBtn.addEventListener('click', closeImageModal);
        }

        // Fermer en cliquant en dehors de l'image
        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.classList.contains('modal-content')) {
                closeImageModal();
            }
        });

        // Fermer avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    });
</script>
@endpush