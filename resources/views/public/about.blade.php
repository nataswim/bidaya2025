@extends('layouts.public')

@section('title', 'A propos')

@section('content')


<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">À propos </h1>
                <p class="lead mb-0">
                    Depuis 2006, nous accompagnons sportifs et entraîneurs dans leur quête d'excellence. Plus de 30 ans d'expertise au service de la performance.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 200px; height: 200px;">
                    <i class="fas fa-water" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Notre Mission -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <header class="text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4">Notre Mission</h2>
                    <p class="lead text-muted">
                        Démocratiser l'accès aux connaissances pour tous les passionnés, du débutant au compétiteur confirmé.
                    </p>
                </header>
                
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <article class="card border-0 shadow-sm h-100 text-center">
                            <div class="card-body p-4">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-lightbulb text-warning fa-2x"></i>
                                </div>
                                <h3 class="h5 fw-bold mb-3">Excellence & Innovation</h3>
                                <p class="text-muted mb-0">
                                    Nous développons des outils d'entraînement innovants basés sur les dernières recherches en sciences du sport et préparation physique.
                                </p>
                            </div>
                        </article>
                    </div>
                    
                    <div class="col-md-4">
                        <article class="card border-0 shadow-sm h-100 text-center">
                            <div class="card-body p-4">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-graduation-cap text-success fa-2x"></i>
                                </div>
                                <h3 class="h5 fw-bold mb-3">Pédagogie & Transmission</h3>
                                <p class="text-muted mb-0">
                                    Notre approche pédagogique rend les techniques et la préparation physique accessibles à tous les niveaux de pratique.
                                </p>
                            </div>
                        </article>
                    </div>
                    
                    <div class="col-md-4">
                        <article class="card border-0 shadow-sm h-100 text-center">
                            <div class="card-body p-4">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-handshake text-info fa-2x"></i>
                                </div>
                                <h3 class="h5 fw-bold mb-3">Communauté & Partage</h3>
                                <p class="text-muted mb-0">
                                    Nous créons des ponts entre nageurs, triathlètes et entraîneurs pour favoriser l'entraide et le partage d'expériences.
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Notre Histoire -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="display-6 fw-bold mb-4">Notre Histoire</h2>
                <div class="timeline">
                    <article class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="min-width: 60px; height: 60px;">
                                <strong>2006</strong>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold">Les débuts</h3>
                                <p class="text-muted">
                                    Création de Nataswim par Hassan El Haouat et Steve Marsh Vedravokivish, deux passionnés de aps et de préparation physique souhaitant partager leur expertise.
                                </p>
                            </div>
                        </div>
                    </article>
                    
                    <article class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="min-width: 60px; height: 60px;">
                                <strong>2010</strong>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold">Partenariats clubs</h3>
                                <p class="text-muted">
                                    Début des collaborations avec plusieurs clubs et coachs. Mise en place de programmes d'entraînement personnalisés.
                                </p>
                            </div>
                        </div>
                    </article>
                    
                    <article class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="min-width: 60px; height: 60px;">
                                <strong>2015</strong>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold">Extension triathlon</h3>
                                <p class="text-muted">
                                    Développement de programmes spécialisés pour triathlètes. Intégration d'outils de calcul et de planification triathlon.
                                </p>
                            </div>
                        </div>
                    </article>
                    
                    <article>
                        <div class="d-flex align-items-start">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="min-width: 60px; height: 60px;">
                                <strong>{{ now()->year }}</strong>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold">Refonte de la Plateforme </h3>
                                <p class="text-muted">
                                    Aujourd'hui, nous offrons une plateforme nouvelle avec plus de 300 articles, 100 plans et 500 exercices.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="display-4 fw-bold text-primary mb-2">25+</div>
                            <small class="text-muted">Années d'expérience</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="display-4 fw-bold text-success mb-2">350+</div>
                            <small class="text-muted">Utilisateurs actifs</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="display-4 fw-bold text-warning mb-2">35000+</div>
                            <small class="text-muted">Vues mensuelles</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4 h-100">
                            <div class="display-4 fw-bold text-info mb-2">50+</div>
                            <small class="text-muted">Plans d'entraînement</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- L'Équipe Fondatrice -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <header class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-3">L'Équipe Fondatrice</h2>
            <p class="lead text-muted">Experts en sport et passionnés</p>
        </header>
        
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user-tie text-primary" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-2">Hassan El Haouat</h3>
                        <p class="text-primary mb-3">Co-fondateur &  Modélisation</p>
                        <p class="text-muted mb-3">
                            Spécialiste en physiologie de l exercice et performance. Développeur d'outils d aide à l entraînement evidence-based. Plus de 25 ans d'expérience dans la préparation physique des nageurs.
                        </p>
                        
                    </div>
                </article>
            </div>
            
            <div class="col-md-6 col-lg-5">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user-tie text-primary" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-2">Steve Marsh Vedravokivish</h3>
                        <p class="text-success mb-3">Co-fondateur & Expert Entraînement</p>
                        <p class="text-muted mb-3">
                            Expert en méthodologie de l'entraînement. Concepteur de programmes adaptés à tous niveaux. Passionné par l'innovation pédagogique et la transmission des techniques de nage.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>


<!-- Nos Partenariats -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <header class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-3">Nos Partenariats</h2>
            <p class="lead text-muted">Collaborations avec clubs et coachs</p>
        </header>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-swimming-pool text-primary fa-2x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2">Clubs </h3>
                        <p class="text-muted small mb-0">
                            Partenariats avec plusieurs clubs pour le développement de leurs athletes
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-medal text-success fa-2x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2">Coachs de renom</h3>
                        <p class="text-muted small mb-0">
                            Collaboration avec entraîneurs reconnus pour valider nos programmes
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-university text-warning fa-2x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2">Formations STAPS</h3>
                        <p class="text-muted small mb-0">
                            Support pédagogique pour étudiants en sciences du sport
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-heartbeat text-info fa-2x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2">Préparateurs physiques</h3>
                        <p class="text-muted small mb-0">
                            Outils spécialisés pour la préparation physique et la formation continue
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nos Valeurs -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <header class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-3">Valeurs</h2>
            <p class="lead text-muted">Ce qui guide notre travail au quotidien</p>
        </header>
        
        <div class="row g-4">
            <div class="col-md-6">
                <article class="d-flex align-items-start">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-microscope fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-2">Evidence-Based</h3>
                        <p class="text-muted mb-0">
                            Nos programmes d'entraînement s'appuient sur les recherches les plus récentes en physiologie de l'exercice et biomécanique.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col-md-6">
                <article class="d-flex align-items-start">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-2">Sécurité & Progression</h3>
                        <p class="text-muted mb-0">
                            La sécurité des pratiquants est notre priorité. Nos plans intègrent une progression adaptée pour prévenir les blessures et optimiser les performances.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col-md-6">
                <article class="d-flex align-items-start">
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-2">Accessibilité</h3>
                        <p class="text-muted mb-0">
                            Nous croyons que l'entraînement de qualité doit être accessible à tous, quels que soient le niveau et les objectifs.
                        </p>
                    </div>
                </article>
            </div>
            
            <div class="col-md-6">
                <article class="d-flex align-items-start">
                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-sync-alt fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-2">Amélioration Continue</h3>
                        <p class="text-muted mb-0">
                            Nous mettons à jour régulièrement nos contenus et outils pour intégrer les dernières avancées en entraînement et préparation physique.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>







<!-- CTA -->
<section class="py-5 bg-primary text-white">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <p class="lead mb-4">
                    Faites partie de notre communaute grandissante de passionnes.
                </p>
                @guest
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            Creer un compte
                        </a>
                        <a href="{{ route('public.index') }}" class="btn btn-outline-light btn-lg">
                            Decouvrir nos articles
                        </a>
                    </div>
                @else
                    <div class="alert alert-light d-inline-block">
                        Merci de faire partie de notre communaute, {{ auth()->user()->name }} !
                    </div>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection