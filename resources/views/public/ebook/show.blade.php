@extends('layouts.public')

@section('title', $downloadable->title . ' - ' . $category->name)
@section('meta_description', $downloadable->short_description ?? 'Téléchargez ' . $downloadable->title . ' - ' . $downloadable->format_display)

@push('styles')
<style>
.hero-download {
    background: linear-gradient(116deg, #0f5c78 0%, #016170 100%);
    padding: 3rem 0;
    color: white;
}

.download-info-card {
    border: none;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    border-radius: 1rem;
}

.related-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.related-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.access-alert {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 1rem;
    padding: 2rem;
}

.download-stats {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.content-display {
    line-height: 1.8;
}

.content-display h1,
.content-display h2,
.content-display h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.content-display p {
    margin-bottom: 1.5rem;
}

.content-display ul,
.content-display ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}
</style>
@endpush

@section('content')
<!-- En-tête du téléchargement -->
<section class="hero-download">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item">
                    <a href="{{ route('ebook.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-home me-1"></i>Espace Téléchargement
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ebook.category', $category->slug) }}" class="text-white text-decoration-none">
                        {{ $category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ Str::limit($downloadable->title, 50) }}
                </li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-light text-dark fs-6">{{ $downloadable->format_display }}</span>
                    <span class="badge bg-primary-subtle text-primary fs-6">{{ $category->name }}</span>
                    @if($downloadable->is_featured)
                        <span class="badge bg-warning fs-6">
                            <i class="fas fa-star me-1"></i>Vedette
                        </span>
                    @endif
                </div>
                
                <h1 class="display-5 fw-bold mb-3">{{ $downloadable->title }}</h1>
                
                @if($downloadable->short_description)
                    <p class="lead opacity-90 mb-4">{{ $downloadable->short_description }}</p>
                @endif
                
                <!-- Actions principales -->
                <div class="d-flex gap-3 flex-wrap">
                    @if($downloadable->canBeDownloadedBy(auth()->user()))
                        <a href="{{ route('ebook.download', [$category->slug, $downloadable->slug]) }}" 
                           class="btn btn-success btn-lg">
                            <i class="fas fa-water me-2"></i>Télécharger maintenant
                        </a>
                    @else
                        <div class="access-alert">
                            <div class="text-center">
                                <i class="fas fa-lock fa-2x text-warning mb-3"></i>
                                <h6 class="fw-bold mb-2">Accès restreint</h6>
                                <p class="mb-3">{{ $downloadable->getAccessMessage(auth()->user()) }}</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('login') }}" class="btn btn-warning">
                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>S'inscrire
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <button class="btn btn-outline-light btn-lg" onclick="shareContent()">
                        <i class="fas fa-share-alt me-2"></i>Partager
                    </button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-white bg-opacity-10 rounded-3 p-4 text-center">
                    <div class="row g-3">
                        <div class="col-6">
                            <h4 class="fw-bold mb-1">{{ number_format($downloadable->download_count) }}</h4>
                            <small class="opacity-75">Téléchargements</small>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold mb-1">{{ $downloadable->file_size ?? '?' }}</h4>
                            <small class="opacity-75">Taille</small>
                        </div>
                        <div class="col-12">
                            <h4 class="fw-bold mb-1">{{ $downloadable->format_display }}</h4>
                            <small class="opacity-75">Format</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <!-- Description complète -->
                @if($downloadable->long_description)
                    <div class="card download-info-card mb-5">
                        <div class="card-body p-5">
                            <h3 class="fw-bold mb-4">
                                <i class="fas fa-water text-primary me-2"></i>Description
                            </h3>
                            <div class="content-display">
                                {!! $downloadable->long_description !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Informations techniques -->
                <div class="card download-info-card">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">
                            <i class="fas fa-cog text-primary me-2"></i>Informations techniques
                        </h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-file fa-2x text-primary me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Format</h6>
                                        <span class="text-muted">{{ $downloadable->format_display }}</span>
                                    </div>
                                </div>
                            </div>
                            @if($downloadable->file_size)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <i class="fas fa-hdd fa-2x text-success me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Taille</h6>
                                            <span class="text-muted">{{ $downloadable->file_size }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-calendar fa-2x text-info me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Ajouté le</h6>
                                        <span class="text-muted">{{ $downloadable->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-water fa-2x text-primary me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Téléchargements</h6>
                                        <span class="text-muted">{{ number_format($downloadable->download_count) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Image de couverture -->
                @if($downloadable->cover_image)
                    <div class="card download-info-card mb-4">
                        <img src="{{ $downloadable->cover_image }}" 
                             class="card-img-top" 
                             style="height: 300px; object-fit: cover;"
                             alt="{{ $downloadable->title }}">
                    </div>
                @endif

                <!-- Actions -->
                <div class="card download-info-card mb-4">
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold mb-3">Actions</h6>
                        <div class="d-grid gap-2">
                            @if($downloadable->canBeDownloadedBy(auth()->user()))
                                <a href="{{ route('ebook.download', [$category->slug, $downloadable->slug]) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-water me-2"></i>Télécharger
                                </a>
                            @else
                                <div class="access-alert">
                                    <div class="mb-2">
                                        <i class="fas fa-lock text-warning me-1"></i>
                                        <small class="text-muted d-block">
                                            {{ $downloadable->getAccessMessage(auth()->user()) }}
                                        </small>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-user-plus me-2"></i>S'inscrire
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <button class="btn btn-outline-primary" onclick="shareContent()">
                                <i class="fas fa-share-alt me-2"></i>Partager
                            </button>
                            
                            <a href="{{ route('ebook.category', $category->slug) }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour à {{ $category->name }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Auteur -->
                @if($downloadable->creator)
                    <div class="card download-info-card">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-user me-2"></i>Auteur
                            </h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <span class="fw-bold text-primary">
                                        {{ substr($downloadable->creator->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $downloadable->creator->name }}</h6>
                                    <small class="text-muted">
                                        Ajouté le {{ $downloadable->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Suggestions -->
@if($relatedDownloads->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="fw-bold mb-3">Autres ressources de {{ $category->name }}</h3>
                <p class="text-muted">Découvrez d'autres contenus qui pourraient vous intéresser</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($relatedDownloads as $related)
                <div class="col-lg-3 col-md-6">
                    <div class="card related-card h-100">
                        <div class="position-relative">
                            @if($related->cover_image)
                                <img src="{{ $related->cover_image }}" 
                                     class="card-img-top" 
                                     style="height: 150px; object-fit: cover;"
                                     alt="{{ $related->title }}">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 150px;">
                                    <i class="fas fa-file-{{ $related->format === 'pdf' ? 'pdf' : ($related->format === 'mp4' ? 'video' : 'alt') }} fa-2x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-dark">{{ strtoupper($related->format) }}</span>
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold mb-2">{{ Str::limit($related->title, 60) }}</h6>
                            <small class="text-muted mb-3">
                                <i class="fas fa-water me-1"></i>{{ number_format($related->download_count) }} téléchargements
                            </small>
                            <div class="mt-auto">
                                <a href="{{ route('ebook.show', [$category->slug, $related->slug]) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-eye me-2"></i>Voir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

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
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0';
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check me-2"></i>Lien copié dans le presse-papiers !
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 3000);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.download-info-card, .related-card');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush