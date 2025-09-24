@extends('layouts.public')

@section('title', $category->name . ' - Espace TÃ©lÃ©chargement')
@section('meta_description', $category->short_description ?? 'DÃ©couvrez tous les tÃ©lÃ©chargements de la catÃ©gorie ' . $category->name)

@push('styles')
<style>
.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3rem 0;
    color: white;
}

.download-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.download-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.filter-card {
    background: #f8f9fa;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.stats-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
}

.format-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    font-size: 0.75rem;
    font-weight: bold;
}

.permission-icon {
    font-size: 0.8rem;
}
</style>
@endpush

@section('content')
<!-- En-tête de catÃ©gorie -->
<section class="category-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb text-white">
                        <li class="breadcrumb-item">
                            <a href="{{ route('ebook.index') }}" class="text-white text-decoration-none">
                                <i class="fas fa-home me-1"></i>Espace TÃ©lÃ©chargement
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">
                            {{ $category->name }}
                        </li>
                    </ol>
                </nav>
                
                <div class="d-flex align-items-center mb-3">
                    @if($category->icon)
                        <i class="{{ $category->icon }} fa-3x me-3"></i>
                    @endif
                    <div>
                        <h1 class="display-5 fw-bold mb-2">{{ $category->name }}</h1>
                        @if($category->short_description)
                            <p class="lead mb-0 opacity-90">{{ $category->short_description }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-white bg-opacity-10 rounded-3 p-4 text-center">
                    <div class="row g-3">
                        <div class="col-6">
                            <h3 class="fw-bold mb-1">{{ $stats['total'] }}</h3>
                            <small class="opacity-75">Ressources</small>
                        </div>
                        <div class="col-6">
                            <h3 class="fw-bold mb-1">{{ $stats['formats']->count() }}</h3>
                            <small class="opacity-75">Formats</small>
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
        <div class="row g-4">
            <!-- Sidebar filtres -->
            <div class="col-lg-3">
                <div class="card filter-card sticky-top" style="top: 2rem;">
                    <div class="card-header bg-white border-0 pb-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-filter me-2"></i>Filtres
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('ebook.category', $category->slug) }}">
                            <!-- Recherche -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Rechercher</label>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       class="form-control form-control-sm"
                                       placeholder="Mots-clÃ©s...">
                            </div>

                            <!-- Formats -->
                            @if($stats['formats']->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label fw-semibold small">Format</label>
                                    <select name="format" class="form-select form-select-sm">
                                        <option value="">Tous les formats</option>
                                        @foreach($stats['formats'] as $format => $count)
                                            <option value="{{ $format }}" {{ request('format') === $format ? 'selected' : '' }}>
                                                {{ strtoupper($format) }} ({{ $count }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Tri -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Trier par</label>
                                <select name="sort" class="form-select form-select-sm">
                                    <option value="title" {{ request('sort', 'title') === 'title' ? 'selected' : '' }}>
                                        Titre A-Z
                                    </option>
                                    <option value="downloads" {{ request('sort') === 'downloads' ? 'selected' : '' }}>
                                        Plus tÃ©lÃ©chargÃ©s
                                    </option>
                                    <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>
                                        Plus rÃ©cents
                                    </option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search me-2"></i>Filtrer
                                </button>
                                @if(request()->hasAny(['search', 'format', 'sort']))
                                    <a href="{{ route('ebook.category', $category->slug) }}" 
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-2"></i>RÃ©initialiser
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste des tÃ©lÃ©chargements -->
            <div class="col-lg-9">
                @if($downloadables->count() > 0)
                    <!-- En-tête avec compteur -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">
                            {{ $downloadables->total() }} ressource(s) disponible(s)
                        </h4>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="view" id="grid-view" checked>
                            <label class="btn btn-outline-secondary" for="grid-view">
                                <i class="fas fa-th"></i>
                            </label>
                            <input type="radio" class="btn-check" name="view" id="list-view">
                            <label class="btn btn-outline-secondary" for="list-view">
                                <i class="fas fa-list"></i>
                            </label>
                        </div>
                    </div>

                    <!-- Vue grille (par dÃ©faut) -->
                    <div id="downloads-grid" class="row g-4">
                        @foreach($downloadables as $download)
                            <div class="col-lg-4 col-md-6">
                                <div class="card download-card h-100">
                                    <div class="position-relative">
                                        @if($download->cover_image)
                                            <img src="{{ $download->cover_image }}" 
                                                 class="card-img-top" 
                                                 style="height: 200px; object-fit: cover;"
                                                 alt="{{ $download->title }}">
                                        @else
                                            <div class="card-img-top bg-gradient-secondary d-flex align-items-center justify-content-center" 
                                                 style="height: 200px;">
                                                <i class="fas fa-file-{{ $download->format === 'pdf' ? 'pdf' : ($download->format === 'mp4' ? 'video' : 'alt') }} fa-3x text-white"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="format-badge">
                                            <span class="badge bg-dark">{{ strtoupper($download->format) }}</span>
                                        </div>
                                        
                                        <div class="stats-badge">
                                            <i class="fas fa-download me-1"></i>{{ number_format($download->download_count) }}
                                        </div>

                                        <!-- Indicateur de permission -->
                                        <div class="position-absolute" style="bottom: 1rem; left: 1rem;">
                                            @if($download->user_permission === 'public')
                                                <span class="badge bg-success permission-icon" title="AccÃ¨s libre">
                                                    <i class="fas fa-globe"></i>
                                                </span>
                                            @elseif($download->user_permission === 'visitor')
                                                <span class="badge bg-info permission-icon" title="Visiteurs uniquement">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            @else
                                                <span class="badge bg-warning permission-icon" title="Membres uniquement">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-bold mb-3">{{ $download->title }}</h5>
                                        
                                        @if($download->short_description)
                                            <p class="card-text text-muted flex-grow-1 small">
                                                {{ Str::limit($download->short_description, 100) }}
                                            </p>
                                        @endif

                                        @if($download->file_size)
                                            <div class="mb-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-hdd me-1"></i>{{ $download->file_size }}
                                                </small>
                                            </div>
                                        @endif
                                        
                                        <div class="mt-auto">
                                            @if($download->canBeDownloadedBy(auth()->user()))
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('ebook.show', [$category->slug, $download->slug]) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye me-2"></i>Voir les dÃ©tails
                                                    </a>
                                                    <a href="{{ route('ebook.download', [$category->slug, $download->slug]) }}" 
                                                       class="btn btn-success btn-sm">
                                                        <i class="fas fa-download me-2"></i>TÃ©lÃ©charger
                                                    </a>
                                                </div>
                                            @else
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('ebook.show', [$category->slug, $download->slug]) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye me-2"></i>Voir les dÃ©tails
                                                    </a>
                                                    <div class="text-center mt-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-lock me-1"></i>
                                                            @if($download->user_permission === 'user' && !auth()->check())
                                                                <a href="{{ route('login') }}" class="text-decoration-none">
                                                                    Connexion requise
                                                                </a>
                                                            @else
                                                                AccÃ¨s restreint
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Vue liste (cachÃ©e par dÃ©faut) -->
                    <div id="downloads-list" class="d-none">
                        @foreach($downloadables as $download)
                            <div class="card download-card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <div class="position-relative">
                                            @if($download->cover_image)
                                                <img src="{{ $download->cover_image }}" 
                                                     class="img-fluid rounded-start h-100" 
                                                     style="object-fit: cover;"
                                                     alt="{{ $download->title }}">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                                    <i class="fas fa-file-{{ $download->format === 'pdf' ? 'pdf' : ($download->format === 'mp4' ? 'video' : 'alt') }} fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title fw-bold">{{ $download->title }}</h5>
                                                    @if($download->short_description)
                                                        <p class="card-text text-muted">{{ Str::limit($download->short_description, 150) }}</p>
                                                    @endif
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <span class="badge bg-secondary">{{ strtoupper($download->format) }}</span>
                                                        @if($download->file_size)
                                                            <span class="badge bg-light text-dark">{{ $download->file_size }}</span>
                                                        @endif
                                                        <span class="badge bg-primary-subtle text-primary">
                                                            <i class="fas fa-download me-1"></i>{{ number_format($download->download_count) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-end ms-3">
                                                    @if($download->canBeDownloadedBy(auth()->user()))
                                                        <div class="d-grid gap-2" style="min-width: 150px;">
                                                            <a href="{{ route('ebook.show', [$category->slug, $download->slug]) }}" 
                                                               class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-eye me-2"></i>DÃ©tails
                                                            </a>
                                                            <a href="{{ route('ebook.download', [$category->slug, $download->slug]) }}" 
                                                               class="btn btn-success btn-sm">
                                                                <i class="fas fa-download me-2"></i>TÃ©lÃ©charger
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="d-grid" style="min-width: 150px;">
                                                            <a href="{{ route('ebook.show', [$category->slug, $download->slug]) }}" 
                                                               class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-eye me-2"></i>DÃ©tails
                                                            </a>
                                                            <small class="text-muted text-center mt-2">
                                                                <i class="fas fa-lock me-1"></i>AccÃ¨s restreint
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($downloadables->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $downloadables->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3 opacity-50"></i>
                        <h4>Aucune ressource trouvÃ©e</h4>
                        @if(request()->hasAny(['search', 'format']))
                            <p class="text-muted mb-3">Aucun rÃ©sultat ne correspond Ã vos critÃ¨res de recherche.</p>
                            <a href="{{ route('ebook.category', $category->slug) }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Voir toutes les ressources
                            </a>
                        @else
                            <p class="text-muted">Cette catÃ©gorie ne contient pas encore de ressources.</p>
                            <a href="{{ route('ebook.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Retour Ã l'accueil
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Description complÃ¨te de la catÃ©gorie -->
@if($category->description)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ã propos de cette catÃ©gorie</h5>
                        <div class="content-display">
                            {!! nl2br(e($category->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des vues grille/liste
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const downloadsGrid = document.getElementById('downloads-grid');
    const downloadsList = document.getElementById('downloads-list');
    
    if (gridView && listView) {
        gridView.addEventListener('change', function() {
            if (this.checked) {
                downloadsGrid.classList.remove('d-none');
                downloadsList.classList.add('d-none');
                localStorage.setItem('ebook-view-preference', 'grid');
            }
        });
        
        listView.addEventListener('change', function() {
            if (this.checked) {
                downloadsGrid.classList.add('d-none');
                downloadsList.classList.remove('d-none');
                localStorage.setItem('ebook-view-preference', 'list');
            }
        });
        
        // Restaurer la prÃ©fÃ©rence de vue
        const savedView = localStorage.getItem('ebook-view-preference');
        if (savedView === 'list') {
            listView.checked = true;
            listView.dispatchEvent(new Event('change'));
        }
    }

    // Animation des cartes au scroll
    const cards = document.querySelectorAll('.download-card');
    
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