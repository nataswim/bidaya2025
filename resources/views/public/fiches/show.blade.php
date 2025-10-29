@extends('layouts.public')

{{-- SEO Meta --}}
@section('title', $fiche->title)
@section('meta_description', strip_tags($fiche->short_description))

{{-- Open Graph / Facebook --}}
@section('og_type', 'article')
@section('og_title', $fiche->title)
@section('og_description', strip_tags($fiche->short_description))
@section('og_url', route('public.fiches.show', [$category, $fiche]))
@if($fiche->image)
    @section('og_image', $fiche->image)
    @section('og_image_alt', $fiche->title)
@endif

{{-- Twitter Card --}}
@section('twitter_title', $fiche->title)
@section('twitter_description', strip_tags($fiche->short_description))
@if($fiche->image)
    @section('twitter_image', $fiche->image)
@endif

@section('content')


<!-- En-tête section -->
<section class="py-5 bg-primary text-white text-center" style="background: linear-gradient(
1deg, #04adb9 0%, rgb(15 92 135) 100%);border-top: 20px solid #04adb9;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg">
                <h1 class="fw-bold mb-0">{{ $fiche->title }}</h1>
            </div>
        </div>
    </div>
</section>





<section class="py-5 text-center">
    <div class="container-lg">
        <div class="container-lg">
            <div class="row justify-content-center align-items-center">
@if($fiche->image)
                <div class="col-lg" style="background-color: white;">
                    <img src="{{ $fiche->image }}" 
                         alt="{{ $fiche->title }}" 
                         style="max-height: 600px; ">
                </div>
            @endif
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
                    <a href="{{ route('public.fiches.index') }}">
                        <i class="fas fa-home me-1"></i>Fiches
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.fiches.category', $category) }}">
                        {{ $category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {!! Str::limit($fiche->title, 50) !!}
                </li>
            </ol>
        </nav>
    </div>
</section>

<article class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-12">
                
                <!-- Card 1: Métadonnées -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted">
                            
                            @if($fiche->is_featured)
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star me-1"></i>En vedette
                                </span>
                            @endif
                            
                            @if($fiche->visibility === 'authenticated')
                                <span class="badge bg-info px-3 py-2">
                                    <i class="fas fa-lock me-1"></i>Membres
                                </span>
                            @endif
                            
                            <span class="d-flex align-items-center">
                                <i class="fas fa-eye me-1"></i>
                                1{{ number_format($fiche->views_count) }} vue{{ $fiche->views_count > 1 ? 's' : '' }}
                            </span>
                            
                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $fiche->published_at?->format('d M Y') ?? $fiche->created_at->format('d M Y') }}
                            </span>
                        
                        
                        <div class="mt-3">
            <x-add-to-notebook-button 
                content-type="fiches" 
                :content-id="$fiche->id" 
            />
                        
                        </div>
                    </div>
                </div>

                <!-- Card 2: Description courte (toujours visible) -->
                @if($fiche->short_description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 mb-0" 
                                 style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <div>
                                    {!! $fiche->short_description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 3: Description longue (selon visibilité) -->
                @if($fiche->long_description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            @if($fiche->canViewContent(auth()->user()))
                                <div class="content-display-full fs-6 lh-lg">
                                    {!! $fiche->long_description !!}
                                </div>
                            @else
                                <!-- Message d'accès restreint -->
                                <div class="content-restricted">
                                    <div class="alert alert-warning border-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <i class="fas fa-lock text-warning fs-2"></i>
                                            </div>
                                            <div class="col">
                                                <h5 class="alert-heading mb-2">Contenu réservé aux membres</h5>
                                                <p class="mb-3">
                                                    {{ $fiche->getAccessMessage(auth()->user()) }}
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
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Card 4: Fiches associées -->
                @if($relatedFiches->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-layer-group me-2 text-primary"></i>
                                Plus de Fiches
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach($relatedFiches as $related)
                                    <div class="col-md-4">
                                        <div class="card h-100 border">
                                            @if($related->image)
                                                <img src="{{ $related->image }}" 
                                                     class="card-img-top" 
                                                     style="height: 180px; object-fit: cover;"
                                                     alt="{{ $related->title }}">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                     style="height: 180px;">
                                                    <i class="fas fa-file-alt fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="card-body p-3">
                                                <h6 class="card-title">{!! Str::limit($related->title, 60) !!}</h6>
                                                <a href="{{ route('public.fiches.show', [$category, $related]) }}" 
                                                   class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 5: Informations de la fiche -->
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
                                        <i class="fas fa-calendar me-1"></i>Publié le:
                                    </span>
                                    <strong>{{ $fiche->published_at?->format('d F Y') ?? $fiche->created_at->format('d F Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-eye me-1"></i>Nombre de vues:
                                    </span>
                                    <strong>1{{ number_format($fiche->views_count) }}</strong>
                                </div>
                            </div>
                            @if($fiche->creator)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-user me-1"></i>Auteur:
                                        </span>
                                        <strong>Collectif</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise à jour:
                                    </span>
                                    <strong>{{ $fiche->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            @if($fiche->visibility === 'authenticated')
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-shield-alt me-1"></i>Visibilité:
                                        </span>
                                        <strong class="text-info">Membres uniquement</strong>
                                    </div>
                                </div>
                            @endif
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
                                <a href="{{ route('public.fiches.category', $category) }}" 
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
                                        <small class="text-muted">Voir toutes les fiches</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('public.fiches.category', $category) }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour à {!! Str::limit($category->name, 30) !!}
                                    </a>
                                    <a href="{{ route('public.fiches.index') }}" 
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



@endsection

@push('styles')
<style>
/* Styles pour le contenu HTML de Quill */
.content-display h1,
.content-display h2,
.content-display h3,
.content-display-full h1,
.content-display-full h2,
.content-display-full h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    line-height: 1.3;
}

.content-display h1, .content-display-full h1 { font-size: 1.8rem; color: #2d3748; }
.content-display h2, .content-display-full h2 { font-size: 1.5rem; color: #2d3748; }
.content-display h3, .content-display-full h3 { font-size: 1.3rem; color: #2d3748; }

.content-display p,
.content-display-full p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
    text-align: justify;
    color: #4a5568;
}

.content-display ul,
.content-display ol,
.content-display-full ul,
.content-display-full ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
    line-height: 1.7;
}

.content-display li,
.content-display-full li {
    margin-bottom: 0.5rem;
}

.content-display blockquote,
.content-display-full blockquote {
    border-left: 4px solid #3182ce;
    padding: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    background: #f7fafc;
    border-radius: 0.375rem;
    color: #2d3748;
}

.content-display img,
.content-display-full img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 2rem 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.content-display pre,
.content-display-full pre {
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
.content-display-full code {
    background-color: #edf2f7;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
    color: #d63384;
    font-family: 'Courier New', monospace;
}

.content-display table,
.content-display-full table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    overflow: hidden;
}

.content-display th,
.content-display td,
.content-display-full th,
.content-display-full td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.content-display th,
.content-display-full th {
    background-color: #f7fafc;
    font-weight: 600;
}

.card {
    transition: box-shadow 0.2s ease;
}

@media (max-width: 991px) {
    .col-lg-7, .col-lg-5 {
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .content-display,
    .content-display-full {
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