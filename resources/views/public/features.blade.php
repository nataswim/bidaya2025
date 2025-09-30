@extends('layouts.public')

@section('title', 'Fonctionnalités')

@section('content')

<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-water me-3 fs-1"></i>
                    <h1 class="display-4 fw-bold mb-0">Fonctionnalités</h1>
                </div>
                <p class="lead mb-4">
                    Des fonctionnalités conçues spécifiquement pour améliorer vos performances en natation et vous 
                    aider à atteindre vos objectifs dans l'eau.
                </p>
            </div>
            <div class="col-lg-5 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 200px; height: 200px;">
                    <i class="fas fa-swimming-pool" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités principales -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-4">Fonctionnalités principales</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Des outils puissants pour optimiser vos entraînements de natation et suivre vos progrès avec précision
            </p>
        </div>

        <div class="row g-4">
            <!-- Planification avancée -->
            <div class="col-md-6 col-lg-3">
                <article class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-swimming-pool text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="h4 mb-3">Planification avancée</h3>
                        <p class="text-muted">
                            Créez et personnalisez des plans d'entraînement détaillés adaptés à votre niveau, vos objectifs 
                            et votre emploi du temps. Organisez vos séances de manière optimale.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Suivi de performance -->
            <div class="col-md-6 col-lg-3">
                <article class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-chart-line text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="h4 mb-3">Suivi de performance</h3>
                        <p class="text-muted">
                            Suivez en temps réel votre progression avec des statistiques détaillées, des graphiques 
                            d'évolution et des analyses comparatives pour optimiser vos performances.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Bibliothèque d'exercices -->
            <div class="col-md-6 col-lg-3">
                <article class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-clipboard-list text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="h4 mb-3">Bibliothèque d'exercices</h3>
                        <p class="text-muted">
                            Accédez à une bibliothèque complète d'exercices techniques spécifiques à la natation, classés 
                            par niveau, style et objectif d'entraînement.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Gestion des séries -->
            <div class="col-md-6 col-lg-3">
                <article class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-stopwatch text-info" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="h4 mb-3">Gestion des séries</h3>
                        <p class="text-muted">
                            Créez et suivez des séries de natation personnalisées avec contrôle précis des distances, 
                            répétitions, intensités et temps de récupération.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités spécifiques -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-4">Fonctionnalités spécialisées</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Développées spécifiquement pour les besoins des nageurs, triathlètes et entraîneurs
            </p>
        </div>

        <div class="row g-4">
            <!-- Entraînement technique -->
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-dumbbell text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Entraînement technique</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Améliorez votre technique de nage grâce à des exercices ciblés pour chaque style : 
                            crawl, brasse, dos et papillon.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Analyse de vitesse -->
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-tachometer-alt text-success"></i>
                            </div>
                            <h3 class="h5 mb-0">Analyse de vitesse</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Mesurez et analysez vos performances par section de nage, identifiez vos points forts et 
                            vos opportunités d'amélioration.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Gestion de l'intensité -->
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-heartbeat text-danger"></i>
                            </div>
                            <h3 class="h5 mb-0">Gestion de l'intensité</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Contrôlez l'intensité de vos entraînements grâce à des indicateurs de fréquence cardiaque 
                            et d'effort perçu.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Modèles de séances -->
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-list-alt text-warning"></i>
                            </div>
                            <h3 class="h5 mb-0">Modèles de séances</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Utilisez des modèles de séances pré-établis ou créez et sauvegardez vos propres modèles 
                            pour une réutilisation facile.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Espace coach -->
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-user-cog text-info"></i>
                            </div>
                            <h3 class="h5 mb-0">Espace coach</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Fonctionnalités dédiées aux entraîneurs pour créer, assigner et suivre les programmes 
                            d'entraînement de leurs athlètes.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Historique complet -->
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-database text-secondary"></i>
                            </div>
                            <h3 class="h5 mb-0">Historique complet</h3>
                        </div>
                        <p class="text-muted mb-0">
                            Archivage et visualisation de l'historique complet de vos entraînements, avec possibilité 
                            d'export et d'analyse.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Interface intuitive -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Interface intuitive et puissante</h2>
                <p class="mb-4">
                    Notre application a été conçue pour offrir une expérience utilisateur optimale, que vous soyez 
                    un nageur débutant ou un athlète de haut niveau.
                </p>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3"></i>
                        <span>Navigation simple et intuitive pour tous les niveaux</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3"></i>
                        <span>Visualisation claire de vos données et statistiques</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3"></i>
                        <span>Personnalisation complète selon vos préférences</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-3"></i>
                        <span>Accessible sur tous vos appareils, même au bord du bassin</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="bg-light rounded p-5 text-center">
                    <i class="fas fa-laptop text-primary" style="font-size: 8rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avantages -->
<section class="py-5 bg-primary text-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Avantages Nataswim</h2>
            <p class="lead mx-auto" style="max-width: 700px;">
                Pourquoi des milliers de nageurs et d'entraîneurs nous font confiance
            </p>
        </div>

        <div class="row g-4">
            <!-- Progression structurée -->
            <div class="col-md-6">
                <article class="card bg-white bg-opacity-10 border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white rounded-circle p-2 me-3">
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                            <h3 class="h5 mb-0">Progression structurée</h3>
                        </div>
                        <p class="mb-0 opacity-75">
                            Progressez de manière méthodique et scientifique avec des plans adaptés à votre niveau 
                            actuel et vos objectifs.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Expertise intégrée -->
            <div class="col-md-6">
                <article class="card bg-white bg-opacity-10 border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white rounded-circle p-2 me-3">
                                <i class="fas fa-lightbulb text-warning fs-4"></i>
                            </div>
                            <h3 class="h5 mb-0">Expertise intégrée</h3>
                        </div>
                        <p class="mb-0 opacity-75">
                            Bénéficiez de l'expertise d'entraîneurs professionnels dans la conception de vos programmes 
                            d'entraînement.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Communauté motivante -->
            <div class="col-md-6">
                <article class="card bg-white bg-opacity-10 border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white rounded-circle p-2 me-3">
                                <i class="fas fa-users text-info fs-4"></i>
                            </div>
                            <h3 class="h5 mb-0">Communauté motivante</h3>
                        </div>
                        <p class="mb-0 opacity-75">
                            Rejoignez une communauté de nageurs partageant les mêmes objectifs pour rester motivé et 
                            échanger des conseils.
                        </p>
                    </div>
                </article>
            </div>

            <!-- Accessibilité maximale -->
            <div class="col-md-6">
                <article class="card bg-white bg-opacity-10 border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white rounded-circle p-2 me-3">
                                <i class="fas fa-mobile-alt text-primary fs-4"></i>
                            </div>
                            <h3 class="h5 mb-0">Accessibilité maximale</h3>
                        </div>
                        <p class="mb-0 opacity-75">
                            Accédez à vos plans et suivez vos performances depuis n'importe quel appareil, même au 
                            bord du bassin.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Témoignages -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Ce qu'en disent nos utilisateurs</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Découvrez comment notre application aide les nageurs à atteindre leurs objectifs
            </p>
        </div>

        <div class="row g-4">
            <!-- Témoignage 1 -->
            <div class="col-md-4">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-4 fst-italic">
                            "Cette application a révolutionné mon approche de l'entraînement. J'ai amélioré mon 200m 
                            papillon de 3 secondes en seulement deux mois grâce aux séries personnalisées et au suivi précis."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold">S</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">Sophie E.</h5>
                                <small class="text-muted">Nageuse de compétition</small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Témoignage 2 -->
            <div class="col-md-4">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-4 fst-italic">
                            "En tant qu'entraîneur, je peux désormais gérer facilement les programmes de toute mon équipe. 
                            La possibilité de personnaliser les plans selon le niveau de chaque nageur est inestimable."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold">N</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">Nicolas G.</h5>
                                <small class="text-muted">Coach de club</small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Témoignage 3 -->
            <div class="col-md-4">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="mb-4 fst-italic">
                            "La planification intuitive et le suivi détaillé m'ont permis d'améliorer considérablement mes 
                            performances. L'application s'est parfaitement intégrée à ma préparation pour mon premier triathlon."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px;">
                                <span class="fw-bold">T</span>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">Thomas D.</h5>
                                <small class="text-muted">Triathlète amateur</small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container-lg py-3">
        <h2 class="mb-4 fw-bold">Prêt à transformer votre entraînement ?</h2>
        <p class="lead mb-4 mx-auto" style="max-width: 700px;">
            Rejoignez des milliers de nageurs, triathlètes et entraîneurs qui utilisent notre application pour atteindre 
            leurs objectifs dans l'eau.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                Nous contacter
                <i class="fas fa-chevron-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

@endsection