@extends('layouts.public')

@section('title', 'Fiches Pratiques')
@section('meta_description', 'Découvrez nos fiches pratiques organisées par thématique pour optimiser votre entraînement et performance sportive.')

@section('content')
<!-- Section titre -->
<section class="text-white py-5" style="border-left: 10px solid rgb(15 92 120);margin-bottom: 20px;background-color: #306f75;">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Fiches Thématique
        </h1>
        <p class="lead mb-0">
            <strong>Ressources structurées et accessibles</strong> pour vous accompagner 
                    dans votre progression sportive avec des contenus organisés par domaine.
        </p>
        
    </div>
</section>

<!-- Fiches en vedette -->
@if($featuredFiches->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="h3 mb-0">
                <i class="fas fa-star text-warning me-2"></i>Fiches en Vedette
            </h2>
        </div>
        
        <div class="row g-4">
            @foreach($featuredFiches as $fiche)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg hover-lift">
                        @if($fiche->image)
                            <img src="{{ $fiche->image }}" 
                                 class="card-img-top" 
                                 style="height: 220px; object-fit: cover;"
                                 alt="{{ $fiche->title }}">
                        @else
                            <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" 
                                 style="height: 220px;">
                                <i class="fas fa-file-alt fa-4x text-white opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if($fiche->category)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-folder me-1"></i>{{ $fiche->category->name }}
                                    </span>
                                @endif
                                @if($fiche->visibility === 'authenticated')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-lock me-1"></i>Membres
                                    </span>
                                @endif
                                <span class="badge bg-success">
                                    <i class="fas fa-star me-1"></i>En vedette
                                </span>
                            </div>
                            
                            <h5 class="card-title mb-3">{{ $fiche->title }}</h5>
                            
                            <p class="card-text text-muted flex-grow-1">
                                {!! Str::limit(strip_tags($fiche->short_description), 120) !!}
                            </p>
                            
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>{{ number_format($fiche->views_count) }} vues
                                </small>
                                @if($fiche->category)
                                    <a href="{{ route('public.fiches.show', [$fiche->category, $fiche]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Découvrir <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Navigation par Catégories -->
<section class="py-5 {{ $featuredFiches->count() > 0 ? 'bg-white' : 'bg-light' }}">
    <div class="container">
        
        <!-- Introduction -->
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">
                <i class="fas fa-folder-open me-2 text-primary"></i>
                Explorez nos Catégorie
            </h2>
            <p class="lead text-muted">
                Choisissez la thématique qui correspond à vos besoins pour accéder 
                aux fiches pratiques adaptées à votre pratique.
            </p>
        </div>

        <!-- Catégories de fiches -->
        @if($categories->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($categories as $category)
                    <div class="col-lg-6">
                        <a href="{{ route('public.fiches.category', $category) }}" 
                           class="text-decoration-none">
                            <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                                <div class="card-header {{ $loop->index % 4 == 0 ? 'bg-primary' : ($loop->index % 4 == 1 ? 'bg-success' : ($loop->index % 4 == 2 ? 'bg-info' : 'bg-warning')) }} text-white">
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                            <img src="{{ $category->image }}" 
                                                 class="rounded me-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;"
                                                 alt="{{ $category->name }}">
                                        @else
                                            <i class="fas fa-folder me-3" style="font-size: 2.5rem;"></i>
                                        @endif
                                        <div>
                                            <h4 class="mb-1">{{ $category->name }}</h4>
                                            <p class="mb-0 opacity-75">{{ $category->published_fiches_count }} fiche(s)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    @if($category->description)
                                        <p class="card-text text-muted mb-3">
                                            {!! Str::limit($category->description, 150) !!}
                                        </p>
                                    @else
                                        <p class="card-text text-muted mb-3">
                                            Découvrez nos fiches pratiques dans la catégorie {{ $category->name }}.
                                        </p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">Découvrir les fiches →</span>
                                        <span class="badge bg-primary fs-6">
                                            {{ $category->published_fiches_count }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucune catégorie disponible pour le moment</h5>
            </div>
        @endif

        <!-- Guide d'Utilisation Rapide -->
        <div class="card shadow-lg border-0 mb-5">
            <div class="card-header text-white" style="border-left: 10px solid rgb(150 230 77);margin-bottom: 20px;background-color: #316f75;">
                <h3 class="mb-2">
                    <i class="fas fa-compass me-2"></i>
                    Comment utiliser nos Fiches
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-search text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">1. Explorez les Catégories</h6>
                            <p class="small text-muted">
                                Parcourez nos catégories thématiques pour trouver 
                                les fiches adaptées à vos besoins.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-book-reader text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">2. Consultez les Fiches</h6>
                            <p class="small text-muted">
                                Accédez au contenu détaillé avec des informations 
                                pratiques et applicables immédiatement.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-rocket text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">3. Appliquez les Conseils</h6>
                            <p class="small text-muted">
                                Mettez en pratique les recommandations pour 
                                optimiser votre progression sportive.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@push('styles')
<style>
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.category-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.category-card:hover {
    border-left-color: var(--bs-primary);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les cards
    const cards = document.querySelectorAll('.category-card, .hover-lift');
    
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
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush