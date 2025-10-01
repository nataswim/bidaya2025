@extends('layouts.public')

@section('title', 'Guide d\'utilisation')

@section('content')

<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-water me-3 fs-1"></i>
                    <h1 class="display-4 fw-bold mb-0">Guide d'utilisation</h1>
                </div>
                <p class="lead mb-4">
                    Tout ce que vous devez savoir pour tirer le meilleur parti de Nataswim
                </p>
            </div>
            <div class="col-lg-5 text-center">
    <img src="{{ asset('assets/images/team/nataswim-application-banner-0.jpg') }}" 
         alt="Guide d'utilisation Nataswim" 
         class="img-fluid rounded shadow"
         style="max-height: 400px; object-fit: cover;">
</div>
        </div>
    </div>
</section>

<!-- Table des matières -->
<section class="py-4 bg-light border-bottom">
    <div class="container-lg">
        <nav class="d-flex flex-wrap justify-content-center gap-3">
            <a href="#carnets" class="btn btn-outline-primary btn-sm">📚 Carnets</a>
            <a href="#exercices" class="btn btn-outline-primary btn-sm">🏊 Exercices</a>
            <a href="#plans" class="btn btn-outline-primary btn-sm">📅 Plans</a>
            <a href="#ebooks" class="btn btn-outline-primary btn-sm">📖 eBooks</a>
            <a href="#fiches" class="btn btn-outline-primary btn-sm">📋 Fiches</a>
            <a href="#outils" class="btn btn-outline-primary btn-sm">🔧 Outils</a>
            <a href="#pages" class="btn btn-outline-primary btn-sm">🌐 Pages</a>
        </nav>
    </div>
</section>

<!-- Carnets d'entraînement -->
<section id="carnets" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-book text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Créez et personnalisez vos carnets d'entraînement</h2>
            <p class="text-muted">Organisez efficacement vos programmes de natation</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h6 mb-0">1️⃣ Création</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✓ Rendez-vous sur "Mes Carnets"</li>
                            <li class="mb-2">✓ Titre clair et pertinent</li>
                            <li class="mb-2">✓ Description précise</li>
                            <li>✓ Validez la création</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h6 mb-0">2️⃣ Personnalisation</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✓ Sélectionnez votre carnet</li>
                            <li class="mb-2">✓ Ajoutez des éléments</li>
                            <li class="mb-2">✓ Choisissez le type</li>
                            <li>✓ Validez vos choix</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h6 mb-0">3️⃣ Gestion</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✓ Accès 24h/24</li>
                            <li class="mb-2">✓ Consultation et modification</li>
                            <li class="mb-2">✓ Duplication de carnets</li>
                            <li>✓ Suppression possible</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h6 mb-0">4️⃣ Avantages</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✓ Confidentialité garantie</li>
                            <li class="mb-2">✓ Flexibilité totale</li>
                            <li class="mb-2">✓ Bibliothèque complète</li>
                            <li>✓ Interface intuitive</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

            <div class="text-center">
                    <i class="fas fa-plus-circle me-2"></i>
                    Créer un carnet
                    <i class="fas fa-book me-2"></i>
                    Mes carnets existants
            </div>
            <div class="alert alert-info text-center">
                <p class="mb-3">Connectez-vous pour créer vos carnets personnalisés</p>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Se connecter
                </a>
            </div>
    </div>
</section>

<!-- Exercices et séances -->
<section id="exercices" class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-swimmer text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Exercices et séances d'entraînement</h2>
            <p class="text-muted">Améliorez vos performances avec notre bibliothèque complète</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-dumbbell text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 mb-3">Bibliothèque d'exercices</h3>
                        <p class="text-muted mb-4">
                            Parcourez notre catalogue d'exercices spécifiques à la natation, 
                            filtrez par niveau, type de nage ou objectif d'entraînement.
                        </p>
                        <a href="{{ route('exercices.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>
                            Explorer les exercices
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-list-alt text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 mb-3">Séances personnalisées</h3>
                        <p class="text-muted mb-4">
                            Créez vos séances en combinant différents exercices, distances, 
                            répétitions et temps de repos adaptés à vos objectifs.
                        </p>
                        @auth
                            <a href="{{ route('user.training.index') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-check me-2"></i>
                                Mes séances d'entraînement
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Se connecter
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-success">
            <h4 class="h5 mb-2"><i class="fas fa-lightbulb me-2"></i>Astuce</h4>
            <p class="mb-0">
                Sauvegardez vos exercices et séances préférés dans vos listes personnelles 
                pour y accéder rapidement lors de vos prochains entraînements.
            </p>
        </div>
    </div>
</section>

<!-- Plans d'entraînement -->
<section id="plans" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-calendar-alt text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Plans d'entraînement</h2>
            <p class="text-muted">Suivez des programmes complets adaptés à vos objectifs</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-4">Comment utiliser les plans d'entraînement :</h3>
                        <ol class="mb-4">
                            <li class="mb-3">
                                <strong>Parcourez</strong> les plans disponibles dans la bibliothèque
                            </li>
                            <li class="mb-3">
                                <strong>Sélectionnez</strong> un plan adapté à votre niveau et objectif
                            </li>
                            <li class="mb-3">
                                <strong>Commencez</strong> votre programme d'entraînement
                            </li>
                            <li class="mb-3">
                                <strong>Suivez</strong> la progression semaine par semaine
                            </li>
                            <li class="mb-3">
                                <strong>Enregistrez</strong> vos performances dans votre carnet
                            </li>
                        </ol>
                        
                        <div class="text-center">
                            <a href="{{ route('plans.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Découvrir les plans
                            </a>
                            @auth
                                <a href="{{ route('user.training.mes-plans') }}" class="btn btn-outline-primary btn-lg ms-2">
                                    <i class="fas fa-star me-2"></i>
                                    Mes plans
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- eBooks -->
<section id="ebooks" class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-book-reader text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Bibliothèque eBooks</h2>
            <p class="text-muted">Accédez à des ressources complètes pour progresser</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-3">📚 Que trouverez-vous dans nos eBooks ?</h3>
                        <ul class="mb-4">
                            <li class="mb-2">Guides techniques détaillés pour chaque nage</li>
                            <li class="mb-2">Programmes d'entraînement complets</li>
                            <li class="mb-2">Conseils nutrition pour nageurs</li>
                            <li class="mb-2">Préparation mentale et motivation</li>
                            <li class="mb-2">Prévention des blessures</li>
                        </ul>

                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Téléchargement gratuit</strong> - Tous nos eBooks sont disponibles 
                            au format PDF pour consultation hors ligne.
                        </div>

                        <div class="text-center">
                            <a href="{{ route('ebook.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-download me-2"></i>
                                Accéder aux eBooks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fiches techniques -->
<section id="fiches" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-file-alt text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Fiches techniques</h2>
            <p class="text-muted">Consultez nos fiches pratiques et mémos rapides</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-3">📋 Contenu des fiches techniques :</h3>
                        <ul class="mb-4">
                            <li class="mb-2">Fiches techniques par type de nage</li>
                            <li class="mb-2">Points clés des exercices</li>
                            <li class="mb-2">Conseils d'entraînement rapides</li>
                            <li class="mb-2">Mémos des bonnes pratiques</li>
                            <li class="mb-2">Synthèses visuelles et schémas</li>
                        </ul>

                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Format pratique</strong> - Imprimez vos fiches pour les avoir 
                            au bord du bassin pendant vos entraînements.
                        </div>

                        <div class="text-center">
                            <a href="{{ route('public.fiches.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-file-alt me-2"></i>
                                Consulter les fiches
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Outils et Utilitaires -->
<section id="outils" class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-tools text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Outils et Utilitaires</h2>
            <p class="text-muted">Tous les calculateurs et outils pour optimiser votre entraînement</p>
        </div>

        <!-- Lien principal vers tous les outils -->
        <div class="text-center mb-5">
            <a href="{{ route('tools.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-wrench me-2"></i>
                Voir tous les outils par catégorie
            </a>
        </div>

        <!-- Santé et Composition Corporelle -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="h5 mb-0">
                    <i class="fas fa-heartbeat me-2"></i>
                    Santé et Composition Corporelle
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.bmi') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-weight me-2"></i>
                            Calculateur IMC
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.masse-grasse') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-percentage me-2"></i>
                            Masse Grasse
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.fitness') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-running me-2"></i>
                            Niveau Fitness
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nutrition et Énergie -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="h5 mb-0">
                    <i class="fas fa-utensils me-2"></i>
                    Nutrition et Énergie
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.calories') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-fire me-2"></i>
                            Calories
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.tdee-calculator') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-calculator me-2"></i>
                            TDEE
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.kcal-macros') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-balance-scale me-2"></i>
                            Kcal/Macros
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.hydratation') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-tint me-2"></i>
                            Hydratation
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Cardiaque -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h3 class="h5 mb-0">
                    <i class="fas fa-heartbeat me-2"></i>
                    Performance Cardiaque
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.heart-rate-zones') }}" class="btn btn-outline-danger w-100">
                            <i class="fas fa-chart-line me-2"></i>
                            Zones Cardiaques
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.coherence-cardiaque') }}" class="btn btn-outline-danger w-100">
                            <i class="fas fa-heart me-2"></i>
                            Cohérence Cardiaque
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sports Aquatiques et Natation -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="h5 mb-0">
                    <i class="fas fa-swimmer me-2"></i>
                    Sports Aquatiques et Natation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.swimming-predictor') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-chart-bar me-2"></i>
                            Prédicteur Performance
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.swimming-planner') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Planificateur Natation
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.vnc') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            VNC (Vitesse Critique)
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.swimming-efficiency') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-bolt me-2"></i>
                            Efficacité Technique
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.chronometre') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-stopwatch me-2"></i>
                            Chronomètre Natation
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.chronometre-pro') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-clock me-2"></i>
                            Chronomètre Pro
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course et Endurance -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="h5 mb-0">
                    <i class="fas fa-running me-2"></i>
                    Course et Endurance
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.running-planner') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-route me-2"></i>
                            Planificateur Course
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.triathlon-planner') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-medal me-2"></i>
                            Planificateur Triathlon
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Force et Musculation -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h3 class="h5 mb-0">
                    <i class="fas fa-dumbbell me-2"></i>
                    Force et Musculation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.onermcalculator') }}" class="btn btn-outline-dark w-100">
                            <i class="fas fa-weight-hanging me-2"></i>
                            1RM / Charge Maximale
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outils Pratiques -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="h5 mb-0">
                    <i class="fas fa-map-marked-alt me-2"></i>
                    Outils Pratiques
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('tools.carte-interactive') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-map me-2"></i>
                            Carte Interactive
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info text-center mt-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Tous nos outils sont gratuits</strong> et accessibles sans inscription. 
            Créez un compte pour sauvegarder vos résultats et suivre votre progression !
        </div>
    </div>
</section>

<!-- Pages à la une -->
<section id="pages" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-sitemap text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Navigation du site</h2>
            <p class="text-muted">Accédez rapidement à toutes les sections</p>
        </div>

        <div class="row g-4">
            <!-- Espace utilisateur -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h6 mb-0">
                            <i class="fas fa-user-cog me-2"></i>
                            Espace Personnel
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                        <i class="fas fa-tachometer-alt me-1"></i> Mon Tableau de bord
                                </li>
                                <li class="mb-2">
                                        <i class="fas fa-user-edit me-1"></i> Mon Profil
                                </li>
                                <li class="mb-2">
                                        <i class="fas fa-book me-1"></i> Mes Carnets
                                </li>
                                <li>
                                        <i class="fas fa-star me-1"></i> Mes Plans
                                </li>
                                <li class="mb-2">
                                    <a href="{{ route('login') }}" class="text-decoration-none">
                                        <i class="fas fa-sign-in-alt me-1"></i> Se connecter
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="text-decoration-none">
                                        <i class="fas fa-user-plus me-1"></i> Créer un compte
                                    </a>
                                </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Ressources -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h3 class="h6 mb-0">
                            <i class="fas fa-book-reader me-2"></i>
                            Ressources
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="{{ route('exercices.index') }}" class="text-decoration-none">
                                    <i class="fas fa-swimmer me-1"></i> Exercices
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('plans.index') }}" class="text-decoration-none">
                                    <i class="fas fa-calendar-alt me-1"></i> Plans d'entraînement
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('ebook.index') }}" class="text-decoration-none">
                                    <i class="fas fa-book me-1"></i> eBooks
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public.fiches.index') }}" class="text-decoration-none">
                                    <i class="fas fa-file-alt me-1"></i> Fiches Techniques
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pages principales -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h3 class="h6 mb-0">
                            <i class="fas fa-home me-2"></i>
                            Pages Principales
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i> Accueil
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('about') }}" class="text-decoration-none">
                                    <i class="fas fa-info-circle me-1"></i> À propos
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('features') }}" class="text-decoration-none">
                                    <i class="fas fa-star me-1"></i> Fonctionnalités
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('pricing') }}" class="text-decoration-none">
                                    <i class="fas fa-tags me-1"></i> Tarifs
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public.index') }}" class="text-decoration-none">
                                    <i class="fas fa-newspaper me-1"></i> Articles
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pages légales -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="h6 mb-0">
                            <i class="fas fa-gavel me-2"></i>
                            Informations Légales
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="{{ route('legal') }}" class="text-decoration-none">
                                    <i class="fas fa-file-contract me-1"></i> Mentions légales
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('privacy') }}" class="text-decoration-none">
                                    <i class="fas fa-shield-alt me-1"></i> Confidentialité
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('cookies') }}" class="text-decoration-none">
                                    <i class="fas fa-cookie-bite me-1"></i> Cookies
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('accessibility') }}" class="text-decoration-none">
                                    <i class="fas fa-universal-access me-1"></i> Accessibilité
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Besoin d'aide -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container-lg">
        <i class="fas fa-life-ring mb-3" style="font-size: 3rem;"></i>
        <h2 class="h3 mb-4">Besoin d'aide supplémentaire ?</h2>
        <p class="lead mb-4">Notre équipe est là pour vous accompagner</p>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
            <i class="fas fa-envelope me-2"></i>
            Contactez-nous
        </a>
    </div>
</section>

@endsection