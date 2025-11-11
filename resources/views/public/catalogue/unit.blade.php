@extends('layouts.public')

@section('title', $unit->title . ' - ' . $module->name . ' - Catalogue')
@section('meta_description', $unit->description ?? 'Unité de formation : ' . $unit->title)
@section('meta_keywords', 'formation, ' . $unit->title . ', ' . $module->name)

@section('content')

<!-- Section Titre avec Breadcrumb -->
<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">
        <!-- Fil d'Ariane -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white text-decoration-none">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.catalogue.index') }}" class="text-white text-decoration-none">
                        Catalogue
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.catalogue.section', $section->slug) }}" class="text-white text-decoration-none">
                        {{ $section->name }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.catalogue.module', [$section->slug, $module->slug]) }}" class="text-white text-decoration-none">
                        {{ $module->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $unit->title }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <!-- Badges -->
                <div class="mb-3 d-flex flex-wrap gap-2 justify-content-center">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        Module {{ $module->order }}
                    </span>
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        Unité {{ $unit->order }}
                    </span>
                    @if($unit->unitable)
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="fas {{ 
                                $unit->unitable_type == 'App\Models\Video' ? 'fa-video' : 
                                ($unit->unitable_type == 'App\Models\Fiche' ? 'fa-file-alt' : 
                                ($unit->unitable_type == 'App\Models\Exercice' ? 'fa-dumbbell' : 
                                ($unit->unitable_type == 'App\Models\Workout' ? 'fa-running' : 
                                ($unit->unitable_type == 'App\Models\Downloadable' ? 'fa-download' : 'fa-book'))))
                            }} me-1"></i>
                            {{ $unit->content_type_label }}
                        </span>
                    @endif
                </div>

                <h1 class="display-4 fw-bold mb-3">
                    {{ $unit->title }}
                </h1>
                @if($unit->description)
                    <p class="lead mb-0">
                        {{ $unit->description }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                @if($unit->unitable && $unit->content_url)
                    <!-- Redirection vers le contenu -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-external-link-alt fa-4x text-primary opacity-50"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-3">Accéder au contenu</h2>
                            <p class="text-muted mb-4">
                                Cette unité contient un contenu de type <strong>{{ $unit->content_type_label }}</strong>.
                                Cliquez sur le bouton ci-dessous pour y accéder.
                            </p>
                            <a href="{{ $unit->content_url }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-play-circle me-2"></i>
                                Accéder au {{ strtolower($unit->content_type_label) }}
                            </a>
                        </div>
                    </div>
                @elseif($unit->unitable)
                    <!-- Contenu lié mais pas d'URL -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-info-circle fa-4x text-info opacity-50"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-3">Contenu en préparation</h2>
                            <p class="text-muted mb-0">
                                Cette unité est associée à un contenu de type <strong>{{ $unit->content_type_label }}</strong>
                                qui sera bientôt disponible.
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Aucun contenu lié -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-hourglass-half fa-4x text-warning opacity-50"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-3">Unité en cours de préparation</h2>
                            <p class="text-muted mb-0">
                                Le contenu de cette unité est actuellement en cours de préparation
                                et sera disponible prochainement.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Informations sur l'unité -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informations sur l'unité
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong class="text-muted d-block mb-1">Section</strong>
                                <a href="{{ route('public.catalogue.section', $section->slug) }}" 
                                   class="text-decoration-none">
                                    {{ $section->name }}
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="text-muted d-block mb-1">Module</strong>
                                <a href="{{ route('public.catalogue.module', [$section->slug, $module->slug]) }}" 
                                   class="text-decoration-none">
                                    {{ $module->name }}
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong class="text-muted d-block mb-1">Ordre</strong>
                                <span>Unité {{ $unit->order }} du module</span>
                            </div>
                            @if($unit->unitable)
                                <div class="col-md-6 mb-3">
                                    <strong class="text-muted d-block mb-1">Type de contenu</strong>
                                    <span>{{ $unit->content_type_label }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <!-- Bouton retour module -->
                    <a href="{{ route('public.catalogue.module', [$section->slug, $module->slug]) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour au module
                    </a>

                    <!-- Bouton retour catalogue -->
                    <a href="{{ route('public.catalogue.index') }}" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-th-large me-2"></i>
                        Retour au catalogue
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Breadcrumb personnalisé */
.breadcrumb {
    background: transparent;
    margin-bottom: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.7);
}

/* Cartes avec effet hover */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
}

/* Animation des icônes */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.fa-4x {
    animation: float 3s ease-in-out infinite;
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée pour les cartes
        const cards = document.querySelectorAll('.card');

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