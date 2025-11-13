@extends('layouts.public')

@section('title', 'Catalogue de Formations')
@section('meta_description', 'Découvrez notre catalogue de formations organisé par sections thématiques. Accédez à des modules et contenus pédagogiques de qualité.')
@section('meta_keywords', 'catalogue formations, modules pédagogiques, apprentissage en ligne, formations sportives')

@section('content')

<!-- Section Titre -->
<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
                    Se Former S'informer
                </h1>
                <p class="lead mb-0">
                    <strong>Explorez</strong> nos dossiers structurées
                    en sections thématiques pour progresser à votre rythme.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Grille des Sections -->
<section class="py-5 bg-light">
    <div class="container-lg">

        @if($sections->count() > 0)
            <!-- Grille responsive de cartes -->
            <div class="row g-4">
                @foreach($sections as $section)
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card h-100 border-0 shadow-sm hover-catalogue-card">
                            
                        <!-- Image de la section -->
                            <div class="catalogue-image-wrapper position-relative">
                                @if($section->image)
                                    <img src="{{ $section->image }}" 
                                         class="card-img-top catalogue-card-image" 
                                         alt="{{ $section->name }}">
                                @else
                                    <div class="catalogue-image-placeholder d-flex align-items-center justify-content-center text-white"
                                         style="background: linear-gradient(135deg, {{ $loop->index % 4 == 0 ? '#0d6efd' : ($loop->index % 4 == 1 ? '#198754' : ($loop->index % 4 == 2 ? '#0dcaf0' : '#ffc107')) }} 0%, {{ $loop->index % 4 == 0 ? '#084298' : ($loop->index % 4 == 1 ? '#0f5132' : ($loop->index % 4 == 2 ? '#087990' : '#cc9a06')) }} 100%);">
                                        <i class="fas fa-book-open" style="font-size: 4rem;"></i>
                                    </div>
                                @endif

                                <!-- Badge nombre de modules -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-primary shadow-sm fs-6">
                                        <i class="fas fa-layer-group me-1"></i>
                                        {{ $section->modules_count }} module{{ $section->modules_count > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenu de la carte -->
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title h5 fw-bold mb-3">
                                    <a href="{{ route('public.catalogue.section', $section->slug) }}" 
                                       class="text-decoration-none text-dark catalogue-link stretched-link">
                                        {{ $section->name }}
                                    </a>
                                </h3>

                                <!-- Description courte -->
                                @if($section->short_description)
                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($section->short_description, 120) }}
                                    </p>
                                @endif

                                <!-- Spacer pour pousser le badge en bas -->
                                <div class="mt-auto pt-2">
                                    <div class="card-header text-dark nataswim-titre4">
                                        <small class="text-muted">
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            Voir les modules
                                        </small>
                                        <i class="fas fa-arrow-right text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Message si aucune section -->
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucune section disponible pour le moment</h5>
                <p class="text-muted">Revenez bientôt pour découvrir nos formations</p>
            </div>
        @endif

        

    </div>
</section>

<!-- Section SEO -->
<section class="py-5 nataswim-titre1">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">Explorez nos dossiers et cours</h2>
                        <p class="text-muted mb-0">
                            Que vous soyez débutant ou expérimenté, nos <strong>contenus structurés</strong>
                            vous accompagnent dans votre progression avec des ressources accessibles à tout moment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avantages du catalogue -->


<section class="py-5 nataswim-titre1">
    <div class="container-lg">
         <div class="row g-4 mt-5">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-book-reader text-primary fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Contenu Structuré</h4>
                        <p class="small text-muted mb-0">
                            Modules organisés pour une progression logique
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-tasks text-success fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Apprentissage Ciblé</h4>
                        <p class="small text-muted mb-0">
                            Unités pédagogiques adaptées à vos objectifs
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-clipboard-list text-info fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Ressources Variées</h4>
                        <p class="small text-muted mb-0">
                            Vidéos, fiches, exercices et plus encore
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-infinity text-warning fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Accès Illimité</h4>
                        <p class="small text-muted mb-0">
                            Progressez à votre propre rythme
                        </p>
                    </div>
                </div>
            </div>
        </div>


    
    </div>
</section>






       










@endsection

@push('styles')
<style>
/* Cartes catalogue avec effet hover */
.hover-catalogue-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.hover-catalogue-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 2rem rgba(13, 110, 253, 0.25) !important;
}

/* Image de la section */
.catalogue-image-wrapper {
    height: 200px;
    overflow: hidden;
}

.catalogue-card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hover-catalogue-card:hover .catalogue-card-image {
    transform: scale(1.05);
}

.catalogue-image-placeholder {
    width: 100%;
    height: 200px;
    transition: transform 0.3s ease;
}

.hover-catalogue-card:hover .catalogue-image-placeholder {
    transform: scale(1.05);
}

/* Lien avec effet hover */
.catalogue-link {
    transition: color 0.3s ease;
}

.hover-catalogue-card:hover .catalogue-link {
    color: #0d6efd !important;
}

/* Effet hover sur les cartes d'avantages */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

/* Responsive */
@media (max-width: 767px) {
    .catalogue-image-wrapper {
        height: 180px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée pour les cards
        const cards = document.querySelectorAll('.hover-catalogue-card, .hover-lift');

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