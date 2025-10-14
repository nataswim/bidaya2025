@extends('layouts.public')

@section('title', 'Séances et Plans d\'Entraînement Sportif')
@section('meta_description', 'Découvrez nos séances d\'entraînement et plans sportifs organisés par discipline : natation, course à pied, musculation. Programmes structurés pour optimiser votre progression.')
@section('meta_keywords', 'séances entraînement, plans entraînement sportif, programme natation, workout français, entraînement course à pied, programme musculation')

@section('content')


<section class="text-white py-5" style="border-left: 2px dashed #f9f5f4;margin-bottom: 20px;background: linear-gradient(
76deg, #086690 0%, #0f5c78 100%);border-right: 2px dashed #f9f5f4;border-bottom: 2px dashed #f9f5f4;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
            Séances et Plans
        </h1>
        <p class="lead mb-0">
<strong>Programmes</strong> pour vous accompagner 
                    dans votre progression avec des séances organisées par niveau et par discipline.        </p>

            </div>
            <div class="col-lg-5 text-center">
                <a href="{{ route('contact') }}">
                    <img src="{{ asset('assets/images/team/auteur-coach-hassan-el-haouat-nataswim-9.png') }}"
                        alt="Guide Nataswim"
                        class="img-fluid rounded-4"
                        style="max-height: 200px; object-fit: cover;">
                </a>
            </div>
        </div>
    </div>
</section>



<!-- Navigation par Disciplines Sportives -->
<section class="py-5 bg-light">
    <div class="container">
        

        <!-- Sections de séances -->
        @if($sections->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($sections as $section)
                    <div class="col-lg-6">
                        <a href="{{ route('public.workouts.section', $section) }}" 
                           class="text-decoration-none">
                            <div class="card h-100 shadow-lg border-0 bg-white hover-lift section-card">
                                <div class="card-header {{ $loop->index % 4 == 0 ? 'bg-primary' : ($loop->index % 4 == 1 ? 'bg-success' : ($loop->index % 4 == 2 ? 'bg-info' : 'bg-warning')) }} text-white">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h3 class="mb-1 h4">{{ $section->name }}</h3>
                                            <p class="mb-0 opacity-75">
                                                {{ $section->categories->count() }} programme(s) d'entraînement
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
                                             {{ $section->name }}.
                                        </p>
                                    @endif
                                    
                                    <!-- Liste des programmes -->
                                    @if($section->categories->count() > 0)
                                        <div class="mb-3">
                                            <small class="text-muted fw-semibold d-block mb-2">Programmes disponibles :</small>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($section->categories->take(4) as $category)
                                                    <span class="badge bg-secondary-subtle text-secondary">
                                                        {{ $category->name }} ({{ $category->workouts_count }} séance{{ $category->workouts_count > 1 ? 's' : '' }})
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
                                        <span class="text-primary fw-bold">Découvrir les séances →</span>
                                        <span class="badge bg-primary fs-6">
                                            {{ $section->categories->sum('workouts_count') }} séance(s)
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
                <h5 class="text-muted">Aucune discipline disponible pour le moment</h5>
                <p class="text-muted">Revenez bientôt pour découvrir nos programmes d'entraînement</p>
            </div>
        @endif

        <!-- Guide d'Utilisation -->
        <div class="card shadow-lg border-0 mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-2 h3">
                    <i class="fas fa-compass me-2"></i>
                    Comment utiliser nos Séances d'Entraînement
                </h2>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-search text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="fw-bold h6">1. Choisissez votre Discipline</h3>
                            <p class="small text-muted">
                                Sélectionnez votre sport : natation, course à pied, 
                                musculation, cyclisme, triathlon, etc.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-folder text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="fw-bold h6">2. Parcourez les Programmes</h3>
                            <p class="small text-muted">
                                Explorez les différents programmes d'entraînement 
                                classés par niveau (débutant, intermédiaire, avancé).
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-running text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="fw-bold h6">3. Suivez la Séance</h3>
                            <p class="small text-muted">
                                Appliquez les instructions détaillées, respectez les intensités 
                                et progressez à votre rythme.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avantages des programmes -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-chart-line text-primary fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Progression Structurée</h4>
                        <p class="small text-muted mb-0">
                            Plans évolutifs adaptés à votre niveau
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-bullseye text-success fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Objectifs Ciblés</h4>
                        <p class="small text-muted mb-0">
                            Séances spécifiques pour chaque objectif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-clipboard-check text-info fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Instructions Détaillées</h4>
                        <p class="small text-muted mb-0">
                            Descriptions complètes et faciles à suivre
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-users text-warning fs-4"></i>
                        </div>
                        <h4 class="h6 fw-bold">Tous Niveaux</h4>
                        <p class="small text-muted mb-0">
                            Du débutant au compétiteur confirmé
                        </p>
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
                <h2 class="display-6 fw-bold mb-3">Commencez Aujourd'hui</h2>
                <p class="lead mb-4">
                    Accédez à notre bibliothèque complète  
                    organisées par discipline sportive et niveau de pratique.
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

<!-- Section SEO - Contenu additionnel -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">Pourquoi suivre nos programmes d'entraînement ?</h2>
                        <p class="text-muted">
                            Nos <strong>séances d'entraînement sportif</strong> sont conçues par des professionnels 
                            pour vous garantir une progression optimale dans votre discipline. Que vous pratiquiez 
                            la <strong>natation</strong>, la <strong>course à pied</strong>, la <strong>musculation</strong> 
                            ou tout autre sport, nos <strong>plans d'entraînement structurés</strong> vous accompagnent 
                            du niveau débutant jusqu'à la compétition.
                        </p>
                        <p class="text-muted mb-0">
                            Chaque <strong>séance sportive</strong> inclut des instructions détaillées, 
                            des volumes adaptés et une progressivité respectant les principes de 
                            l'entraînement moderne. Accédez gratuitement à notre bibliothèque et 
                            commencez dès aujourd'hui votre transformation physique.
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