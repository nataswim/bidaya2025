@extends('layouts.public')

@section('title', 'Outils & Calculateurs Sportifs - Collection Evidence-Based')
@section('meta_description', 'Suite complete d\'outils et calculateurs pour optimiser votre sante, performance et entraînement sportif. Organises par categories specialisees, bases sur les recherches scientifiques 2024.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="fas fa-calculator text-warning"></i>
            Outils & Calculateurs Sportifs
            <i class="fas fa-chart-line text-success"></i>
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-flask text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Collection scientifique complete</strong> d'outils pour optimiser votre sante, 
                    performance et entraînement sportif bases sur les recherches 2024
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation par Categories -->
<section class="py-5 bg-light">
    <div class="container">
        
        <!-- Introduction -->
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Explorez nos Outils par Categorie</h2>
            <p class="lead text-muted">
                Choisissez la categorie qui correspond Ã vos besoins pour acceder aux outils specialises 
                et calculateurs scientifiques adaptes Ã votre pratique sportive.
            </p>
        </div>

        <!-- Categories d'outils -->
        <div class="row g-4 mb-5">
            
            <!-- 1. Sante & Composition Corporelle -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.health') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-heartbeat me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Sante & Composition Corporelle</h4>
                                    <p class="mb-0 opacity-75">4 outils disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Analysez votre sante et composition corporelle avec precision scientifique : 
                                IMC, masse grasse, TDEE, indices de forme physique.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Essentiel</span>
                                    <span class="badge bg-primary">Avance</span>
                                    <span class="badge bg-warning">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Nutrition & energie -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.nutrition') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-apple-alt me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Nutrition & energie</h4>
                                    <p class="mb-0 opacity-75">3 outils disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Optimisez votre nutrition sportive : conversion calories-macros, 
                                besoins caloriques et hydratation personnalisee.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-success fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Essentiel</span>
                                    <span class="badge bg-primary">Avance</span>
                                    <span class="badge bg-warning">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Performance Cardiaque -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.cardiac') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-heart me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Performance Cardiaque</h4>
                                    <p class="mb-0 opacity-75">2 outils disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Optimisez votre entraînement cardio : zones d'entraînement scientifiques 
                                et coherence cardiaque pour la performance.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-danger fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-info">Bien-être</span>
                                    <span class="badge bg-warning">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 4. Sports Aquatiques & Natation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.swimming') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-info text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-swimmer me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Sports Aquatiques & Natation</h4>
                                    <p class="mb-0 opacity-75">6 outils disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Suite complete natation : prediction performance, planification, 
                                VNC, efficacite technique, triathlon et chronometrage.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-info fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Essentiel</span>
                                    <span class="badge bg-primary">Avance</span>
                                    <span class="badge bg-warning">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 5. Course Ã Pied & Endurance -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.running') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-warning text-dark">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-running me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Course Ã Pied & Endurance</h4>
                                    <p class="mb-0 opacity-75">1 outil disponible</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Planification intelligente course Ã pied : plans d'entraînement 
                                personnalises selon votre objectif et niveau.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-primary">Avance</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 6. Force & Musculation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.strength') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-dark text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-dumbbell me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Force & Musculation</h4>
                                    <p class="mb-0 opacity-75">1 outil disponible</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Calculs musculation precis : repetition maximale (1RM) 
                                et pourcentages d'entraînement pour optimiser vos charges.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-primary">Avance</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 7. Outils Pratiques -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.practical') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-secondary text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tools me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Outils Pratiques</h4>
                                    <p class="mb-0 opacity-75">2 outils disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Utilitaires d'entraînement : chronometrage professionnel 
                                multi-athletes et carte interactive pour planification parcours.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary fw-bold">Decouvrir les outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-secondary">Pratique</span>
                                    <span class="badge bg-warning">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 8. Outils en Developpement -->
            <div class="col-lg-6">
                <a href="{{ route('tools.category.development') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-warning text-dark">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-wrench me-3" style="font-size: 2rem;"></i>
                                <div>
                                    <h4 class="mb-1">Outils en Developpement</h4>
                                    <p class="mb-0 opacity-75">40+ outils prevus</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Aperçu des innovations Ã venir : biomecanique, recuperation avancee, 
                                nutrition specialisee, psychologie sportive et plus encore.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning fw-bold">Decouvrir le roadmap →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-danger">Priorite 1</span>
                                    <span class="badge bg-warning">Priorite 2</span>
                                    <span class="badge bg-secondary">Priorite 3</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Guide d'Utilisation Rapide -->
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-compass me-2"></i>
                    Guide d'Utilisation Rapide
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-play text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">1. Commencez Simple</h6>
                            <p class="small text-muted">
                                Debutez avec les outils niveau "Essentiel" : IMC, hydratation, 
                                zones cardiaques de base.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-chart-line text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">2. Progressez Intelligemment</h6>
                            <p class="small text-muted">
                                evoluez vers les outils "Avance" pour approfondir votre analyse 
                                et optimiser vos resultats.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-trophy text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">3. Expertise "Pro"</h6>
                            <p class="small text-muted">
                                Utilisez les outils "Pro" pour une analyse scientifique 
                                complete et un coaching personnalise.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</section>

<!-- Section Credit et Contact -->
     <div class="card mb-4">
            <a href="{{ route('tools.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Essayer d'autres outils
            </a>
        </div>
<section class="py-5 bg-primary text-white">

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Ã Propos de nos Outils</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">Developpement & Expertise</h6>
                        <p class="mb-3">
                            Contenus et outils developpes par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Expert en sciences du sport, physiologie de l'exercice et developpement 
                            d'outils d'aide Ã la performance sportive evidence-based.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Collaboration & Amelioration</h6>
                        <p class="mb-3 small">
                            Si vous constatez une erreur dans nos calculateurs ou souhaitez suggerer 
                            de nouveaux outils, n'hesitez pas Ã nous contacter.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-envelope me-2"></i>Nous Contacter
                            </a>
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fab fa-linkedin me-2"></i>LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="bg-white bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/med_Hassan_EL_HAOUAT.png') }}" 
                         alt="MED Hassan El Haouat - Expert en sciences du sport" 
                         class="w-100 h-100 rounded-circle"
                         style="object-fit: cover;">
                </div>
                <div class="mt-3">
                    <h6 class="text-warning mb-1">Evidence-Based</h6>
                    <small class="text-light opacity-75">Recherches 2024 integrees</small>
                </div>
            </div>
        </div>
    </div>
</section>






<!-- Dernieres Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-newspaper text-primary me-2"></i>Dernieres Publications
            </h2>
            <a href="{{ route('public.index') }}" class="btn btn-outline-primary">
                Tous les articles <i class="fas fa-angle-right ms-1"></i>
            </a>
        </div>
        
        @php
            $latestPosts = App\Models\Post::with('category')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        @endphp
        
        @if($latestPosts->count() > 0)
            <div class="row g-4">
                @foreach($latestPosts as $post)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm hover-lift border-0">
                            <div style="height: 180px; overflow: hidden;">
                                @if($post->image)
                                    <img src="{{ $post->image }}" 
                                         alt="{{ $post->name }}"
                                         class="card-img-top"
                                         style="height: 100%; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                        <i class="fas fa-swimmer text-muted" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($post->category)
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    </div>
                                @endif
                                <h3 class="card-title h5 mb-3">{{ $post->name }}</h3>
                                @if($post->intro)
                                    <p class="card-text text-muted small">
                                        {{ Str::limit(strip_tags($post->intro), 100) }}
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $post->published_at->format('d/m/Y') }}
                                </small>
                                <a href="{{ route('public.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                    Lire la suite
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>Aucun article n'est disponible actuellement.
            </div>
        @endif
    </div>
</section>













<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3">Commencez votre Analyse Scientifique</h2>
                <p class="lead mb-4">
                    Explorez nos outils par categorie et beneficiez d'une approche scientifique 
                    personnalisee pour optimiser votre sante et performance sportive.
                </p>
                
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('tools.category.health') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-heartbeat me-2"></i>Sante & Composition
                    </a>
                    <a href="{{ route('tools.category.swimming') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-swimmer me-2"></i>Natation & Aquatique
                    </a>
                    <a href="{{ route('tools.category.cardiac') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-heart me-2"></i>Performance Cardiaque
                    </a>
                </div>

                <div class="alert alert-info border-0 bg-white bg-opacity-25 mt-4 d-inline-block">
                    <small>
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong>Avis medical :</strong> Ces outils ne remplacent pas l'avis d'un professionnel de sante. 
                        Consultez un medecin avant tout programme sportif intense.
                    </small>
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
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.category-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.category-card:hover {
    border-left-color: var(--bs-primary);
}

.card {
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entree pour les cards
    const cards = document.querySelectorAll('.category-card');
    
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