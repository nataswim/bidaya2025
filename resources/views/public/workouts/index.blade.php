@extends('layouts.public')

@section('title', 'Workouts')
@section('meta_description', 'Découvrez nos workouts organisés par sections et catégories pour optimiser votre entraînement sportif.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="fas fa-dumbbell"></i>
            Workouts
        </h1>
        <p class="lead mb-0">
            Collection complète de workouts pour votre développement sportif
        </p>
        <div class="alert alert-info border-0 shadow-sm mt-4" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); max-width: 800px; margin: 0 auto;">
            <div class="d-flex align-items-start">
                <i class="fas fa-lightbulb text-warning me-3 mt-1" style="font-size: 1.5rem;"></i>
                <div class="text-dark">
                    <strong>Workouts structurés et progressifs</strong> pour vous accompagner 
                    dans votre progression sportive avec des séances organisées par thématique.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation par Sections -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Introduction -->
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">
                <i class="fas fa-layer-group me-2 text-primary"></i>
                Explorez par Section
            </h2>
            <p class="lead text-muted">
                Choisissez la section qui correspond à votre discipline sportive 
                pour accéder aux workouts adaptés à votre pratique.
            </p>
        </div>

        <!-- Sections de workouts -->
        @if($sections->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($sections as $section)
                    <div class="col-lg-6">
                        <a href="{{ route('public.workouts.section', $section) }}" 
                           class="text-decoration-none">
                            <div class="card h-100 shadow-lg border-0 bg-white hover-lift section-card">
                                <div class="card-header {{ $loop->index % 4 == 0 ? 'bg-primary' : ($loop->index % 4 == 1 ? 'bg-success' : ($loop->index % 4 == 2 ? 'bg-info' : 'bg-warning')) }} text-white">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-layer-group me-3" style="font-size: 2.5rem;"></i>
                                        <div>
                                            <h4 class="mb-1">{{ $section->name }}</h4>
                                            <p class="mb-0 opacity-75">
                                                {{ $section->categories->count() }} catégorie(s)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    @if($section->description)
                                        <p class="card-text text-muted mb-3">
                                            {!! Str::limit($section->description, 150) !!}
                                        </p>
                                    @else
                                        <p class="card-text text-muted mb-3">
                                            Découvrez nos workouts dans la section {{ $section->name }}.
                                        </p>
                                    @endif
                                    
                                    <!-- Liste des catégories -->
                                    @if($section->categories->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-muted fw-semibold d-block mb-2">Catégories disponibles :</small>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($section->categories->take(4) as $category)
                                                    <span class="badge bg-secondary-subtle text-secondary">
                                                        {{ $category->name }} ({{ $category->workouts_count }})
                                                    </span>
                                                @endforeach
                                                @if($section->categories->count() > 4)
                                                    <span class="badge bg-light text-dark">
                                                        +{{ $section->categories->count() - 4 }} autres
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">Découvrir les workouts →</span>
                                        <span class="badge bg-primary fs-6">
                                            {{ $section->categories->sum('workouts_count') }} workout(s)
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
                <i class="fas fa-layer-group fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted">Aucune section disponible pour le moment</h5>
            </div>
        @endif

        <!-- Guide d'Utilisation Rapide -->
        <div class="card shadow-lg border-0 mb-5">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-compass me-2"></i>
                    Comment utiliser nos Workouts
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
                            <h6 class="fw-bold">1. Choisissez votre Section</h6>
                            <p class="small text-muted">
                                Sélectionnez la discipline sportive qui vous intéresse 
                                (natation, course à pied, musculation, etc.)
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-folder text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">2. Parcourez les Catégories</h6>
                            <p class="small text-muted">
                                Explorez les différentes catégories de workouts 
                                organisées par niveau et objectif.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-dumbbell text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">3. Réalisez le Workout</h6>
                            <p class="small text-muted">
                                Suivez les instructions détaillées et 
                                progressez à votre rythme.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3">Notre Collection de Workouts</h2>
                <p class="lead mb-4">
                    Explorez nos workouts structurés par section et catégorie pour 
                    optimiser votre développement sportif.
                </p>
                
                @if($sections->count() > 0)
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @foreach($sections->take(3) as $section)
                            <a href="{{ route('public.workouts.section', $section) }}" 
                               class="btn {{ $loop->first ? 'btn-light' : 'btn-outline-light' }} btn-lg">
                                <i class="fas fa-layer-group me-2"></i>{{ $section->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
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

.section-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.section-card:hover {
    border-left-color: var(--bs-primary);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les cards
    const cards = document.querySelectorAll('.section-card, .hover-lift');
    
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