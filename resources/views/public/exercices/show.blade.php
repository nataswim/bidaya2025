@extends('layouts.public')

{{-- SEO Meta --}}
@section('title', $exercice->titre . ' - Exercice d\'Entraînement')
@section('meta_description', 'Découvrez l\'exercice ' . $exercice->titre . ' - ' . $exercice->type_exercice_label . ' niveau ' . $exercice->niveau_label . '. Instructions détaillées et conseils de sécurité.')

{{-- Open Graph / Facebook --}}
@section('og_type', 'article')
@section('og_title', $exercice->titre . ' - Exercice ' . $exercice->type_exercice_label)
@section('og_description', $exercice->description ? Str::limit(strip_tags($exercice->description), 200) : 'Exercice ' . $exercice->type_exercice_label . ' niveau ' . $exercice->niveau_label)
@section('og_url', route('exercices.show', $exercice))
@if($exercice->image)
@section('og_image', $exercice->image)
@section('og_image_alt', $exercice->titre)
@endif

{{-- Twitter Card --}}
@section('twitter_title', $exercice->titre)
@section('twitter_description', $exercice->description ? Str::limit(strip_tags($exercice->description), 200) : 'Exercice ' . $exercice->type_exercice_label)
@if($exercice->image)
@section('twitter_image', $exercice->image)
@endif

@section('content')

<!-- En-tête de section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-{{ $exercice->image ? '7' : '12' }}">
                <h1 class="display-5 fw-bold mb-0">{{ $exercice->titre }}</h1>
            </div>
            @if($exercice->image)
            <div class="col-lg-5">
                <img src="{{ $exercice->image }}"
                    alt="{{ $exercice->titre }}"
                    class="img-fluid w-100 rounded shadow"
                    style="max-height: 300px; object-fit: cover; background-color: #ffffff;">
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="py-3 bg-light border-bottom">
    <div class="container-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('exercices.index') }}">
                        <i class="fas fa-dumbbell me-1"></i>Exercices
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {!! Str::limit($exercice->titre, 50) !!}
                </li>
            </ol>
        </nav>
    </div>
</section>

<article class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-12">



                <!-- Card 2: Muscles ciblés (si présents) -->
                @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-0"
                            style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-crosshairs fs-3 text-info me-3"></i>
                                <div>
                                    <p class="mb-0 lead">{{ $exercice->muscles_cibles_formatted }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Card 3: Description -->

                            @if($exercice->image)
            <div class="border-0 mb-4">

                <div class="col-lg" style="text-align: center;">
                    <img src="{{ $exercice->image }}"
                        alt="{{ $exercice->titre }}">
                </div>
            </div>
            @endif
            
                @if($exercice->description)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-file-text me-2"></i>Description
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="content-display fs-6 lh-lg">
                            {!! $exercice->description !!}
                        </div>
                    </div>
                </div>
                @endif




            </div>

        </div>




        <!-- Card 4: Consignes de sécurité -->
        @if($exercice->consignes_securite)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Consignes
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="content-display-warning fs-6 lh-lg">
                    {!! $exercice->consignes_securite !!}
                </div>
            </div>
        </div>
        @endif
















        <!-- Card 5: Vidéo explicative -->
        @if($exercice->video_url)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success text-white">

            </div>
            <div class="card-body p-4">
                @php
                $videoUrl = $exercice->video_url;
                $isYoutube = str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be');
                $isVimeo = str_contains($videoUrl, 'vimeo.com');
                $isDirectFile = preg_match('/\.(mp4|webm|ogg)$/i', $videoUrl);

                // Conversion URL YouTube
                if ($isYoutube) {
                if (str_contains($videoUrl, 'youtu.be/')) {
                $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                } else {
                $embedUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                }
                }

                // Conversion URL Vimeo
                if ($isVimeo) {
                $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                $embedUrl = "https://player.vimeo.com/video/{$videoId}";
                }
                @endphp

                {{-- YouTube --}}
                @if($isYoutube)
                <div class="ratio ratio-16x9">
                    <iframe
                        src="{{ $embedUrl }}"
                        title="Vidéo YouTube"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        class="rounded">
                    </iframe>
                </div>


                {{-- Vimeo --}}
                @elseif($isVimeo)
                <div class="ratio ratio-16x9">
                    <iframe
                        src="{{ $embedUrl }}"
                        title="Vidéo Vimeo"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                        class="rounded">
                    </iframe>
                </div>


                {{-- Fichier direct (MP4, WebM, OGG) --}}
                @elseif($isDirectFile)
                <div class="ratio ratio-16x9">
                    <video
                        controls
                        controlsList="nodownload"
                        class="rounded w-100"
                        preload="metadata">
                        <source src="{{ $videoUrl }}" type="video/{{ pathinfo($videoUrl, PATHINFO_EXTENSION) }}">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                </div>


                {{-- URL non reconnue - Fallback --}}
                @else
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Format de vidéo non supporté.
                    <a href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer" class="alert-link">
                        Ouvrir la vidéo dans un nouvel onglet
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Card 6: Exercices similaires -->
        @if($exercicesSimilaires->count() > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-dumbbell me-2 text-primary"></i>
                    Autres Exercices
                </h5>
            </div>
            <div class="card-body p-0">
                @foreach($exercicesSimilaires as $similaire)
                <div class="p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="row align-items-center">
                        @if($similaire->image)
                        <div class="col-auto">
                            <img src="{{ $similaire->image }}"
                                class="rounded"
                                style="width: 80px; height: 60px; object-fit: cover;"
                                alt="">
                        </div>
                        @else
                        <div class="col-auto">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 60px;">
                                <i class="fas fa-dumbbell text-muted fa-2x"></i>
                            </div>
                        </div>
                        @endif
                        <div class="col">
                            <a href="{{ route('exercices.show', $similaire) }}"
                                class="text-decoration-none">
                                <h6 class="mb-1">{!! Str::limit($similaire->titre, 60) !!}</h6>
                            </a>
                            <div class="small text-muted">
                                <span class="badge bg-{{ $similaire->niveau === 'debutant' ? 'success' : ($similaire->niveau === 'avance' ? 'danger' : 'warning') }}-subtle text-{{ $similaire->niveau === 'debutant' ? 'success' : ($similaire->niveau === 'avance' ? 'danger' : 'warning') }} me-2">
                                    {{ $similaire->niveau_label }}
                                </span>
                                {{ $similaire->type_exercice_label }}
                            </div>
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

<!-- Section Découvrez aussi -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <h3 class="fw-bold text-center mb-4">Découvrez aussi</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('plans.index') }}" class="btn btn-outline-primary btn-lg w-100">
                    <i class="fas fa-calendar-alt me-2"></i>Plans de musculation
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('tools.index') }}" class="btn btn-outline-success btn-lg w-100">
                    <i class="fas fa-calculator me-2"></i>Outils de calcul
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('public.index') }}" class="btn btn-outline-info btn-lg w-100">
                    <i class="fas fa-book me-2"></i>Articles & conseils
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Styles pour le contenu HTML */
    .content-display h1,
    .content-display h2,
    .content-display h3,
    .content-display-warning h1,
    .content-display-warning h2,
    .content-display-warning h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
        line-height: 1.3;
    }

    .content-display h1,
    .content-display-warning h1 {
        font-size: 1.8rem;
        color: #2d3748;
    }

    .content-display h2,
    .content-display-warning h2 {
        font-size: 1.5rem;
        color: #2d3748;
    }

    .content-display h3,
    .content-display-warning h3 {
        font-size: 1.3rem;
        color: #2d3748;
    }

    .content-display p,
    .content-display-warning p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        text-align: justify;
        color: #4a5568;
    }

    .content-display ul,
    .content-display ol,
    .content-display-warning ul,
    .content-display-warning ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
        line-height: 1.7;
    }

    .content-display li,
    .content-display-warning li {
        margin-bottom: 0.5rem;
    }

    .content-display blockquote,
    .content-display-warning blockquote {
        border-left: 4px solid #3182ce;
        padding: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        background: #f7fafc;
        border-radius: 0.375rem;
        color: #2d3748;
    }

    .content-display-warning blockquote {
        border-left-color: #f59e0b;
        background: #fffbeb;
    }

    .content-display img,
    .content-display-warning img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 2rem 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .content-display pre,
    .content-display-warning pre {
        background: #1a202c;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 2rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .content-display code,
    .content-display-warning code {
        background-color: #edf2f7;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
        color: #d63384;
        font-family: 'Courier New', monospace;
    }

    .content-display strong,
    .content-display-warning strong {
        font-weight: 600;
        color: #1e293b;
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

        .content-display,
        .content-display-warning {
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