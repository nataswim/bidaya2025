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
                @auth
                    <a href="{{ route('user.dashboard') }}" class="btn btn-light btn-lg">
                        Mon Espace Perso
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        Créer mon compte
                    </a>
                @endauth
            </div>
            <div class="col-lg-5 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 200px; height: 200px;">
                    <i class="fas fa-book-open" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Carnets d'entraînement -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h3 mb-0">Créez et personnalisez vos carnets d'entraînement</h2>
            </div>
            <div class="card-body">
                <p class="card-text mb-4">
                    Organisez efficacement vos programmes de natation en quelques étapes simples.
                </p>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">1. Création d'un carnet</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">• Rendez-vous sur la page "Mes Carnets"</li>
                                    <li class="list-group-item">• Attribuez un titre clair et pertinent</li>
                                    <li class="list-group-item">• Ajoutez une description précise</li>
                                    <li class="list-group-item">• Validez la création du carnet</li>
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">2. Personnalisation</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">• Sélectionnez votre carnet créé</li>
                                    <li class="list-group-item">• Cliquez sur "Ajouter des éléments"</li>
                                    <li class="list-group-item">• Choisissez le type d'élément à ajouter</li>
                                    <li class="list-group-item">• Sélectionnez et validez vos choix</li>
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">3. Gestion des carnets</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">• Accédez à vos carnets 24h/24</li>
                                    <li class="list-group-item">• Consultez ou modifiez vos carnets</li>
                                    <li class="list-group-item">• Dupliquez pour créer des variantes</li>
                                    <li class="list-group-item">• Supprimez les carnets non utilisés</li>
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">4. Points clés</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">• Confidentialité garantie</li>
                                    <li class="list-group-item">• Flexibilité selon vos objectifs</li>
                                    <li class="list-group-item">• Bibliothèque complète disponible</li>
                                    <li class="list-group-item">• Interface intuitive pour faciliter l'usage</li>
                                </ul>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="alert alert-info">
                    <h4 class="h5 mb-3">+ Conseils supplémentaires</h4>
                    <ul class="mb-0">
                        <li>Utilisez des titres précis pour retrouver facilement vos carnets.</li>
                        <li>Dupliquez un carnet existant pour créer rapidement une nouvelle version.</li>
                        <li>Organisez vos carnets par objectif ou niveau pour faciliter la navigation.</li>
                        <li>N'hésitez pas à combiner des séances de différentes intensités dans un même carnet.</li>
                    </ul>
                </div>

                @auth
                    <div class="text-center mt-4">
                        <a href="{{ route('user.mylists.new') }}" class="btn btn-primary me-2">
                            <i class="fas fa-list me-2"></i>
                            Créer mon premier carnet
                        </a>
                        <a href="{{ route('user.mylists') }}" class="btn btn-outline-primary">
                            <i class="fas fa-book me-2"></i>
                            Mes carnets existants
                        </a>
                    </div>
                @else
                    <div class="text-center mt-4">
                        <p class="text-muted mb-3">Connectez-vous pour créer vos carnets personnalisés</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Se connecter
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Exercices et séances -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h3 mb-0">Exercices et séances d'entraînement</h2>
            </div>
            <div class="card-body">
                <p class="card-text mb-4">
                    Consultez notre bibliothèque complète d'exercices et séances pour améliorer vos performances en natation.
                </p>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-dumbbell me-2"></i>
                                    Trouver des exercices
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    Parcourez notre catalogue d'exercices spécifiques à la natation, filtrez par niveau, 
                                    type de nage ou objectif d'entraînement.
                                </p>
                                <a href="{{ route('exercices.index') }}" class="btn btn-outline-primary btn-sm">
                                    Accéder aux exercices
                                </a>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-swimmer me-2"></i>
                                    Trouver des séances
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    Séances personnalisées en combinant différents exercices, distances, répétitions 
                                    et temps de repos.
                                </p>
                                @auth
                                    <a href="{{ route('user.training.index') }}" class="btn btn-outline-primary btn-sm">
                                        Voir les séances d'entraînement
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                        Se connecter pour voir les séances
                                    </a>
                                @endauth
                            </div>
                        </article>
                    </div>
                </div>

                <div class="alert alert-success">
                    <h4 class="h5">Bon à savoir</h4>
                    <p class="mb-0">
                        Vous pouvez sauvegarder vos exercices et séances préférés dans vos listes personnelles 
                        pour y accéder rapidement lors de vos prochains entraînements.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans d'entraînement -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h3 mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Plans d'entraînement
                </h2>
            </div>
            <div class="card-body">
                <p class="card-text mb-4">
                    Suivez des plans d'entraînement complets adaptés à vos objectifs et à votre niveau.
                </p>

                <div class="row mb-4">
                    <div class="col-12 mb-4">
                        <article class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Comment utiliser les plans d'entraînement :</h3>
                                <ol class="list-group list-group-numbered mb-4">
                                    <li class="list-group-item">Parcourez les plans disponibles dans la bibliothèque</li>
                                    <li class="list-group-item">Sélectionnez un plan adapté à votre niveau et objectif</li>
                                    <li class="list-group-item">Ajoutez-le à vos favoris pour un accès rapide</li>
                                    <li class="list-group-item">Suivez la progression semaine par semaine</li>
                                    <li class="list-group-item">Gardez une trace de vos performances dans votre carnet</li>
                                </ol>
                                
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('plans.index') }}" class="btn btn-primary">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Découvrir les plans
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pages à la une -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h3 mb-0">Pages à la une</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-user-cog me-2"></i>
                                    Espace utilisateur
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @auth
                                        <li class="list-group-item">
                                            <a href="{{ route('user.dashboard') }}" class="text-decoration-none">Mon Espace</a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('user.profile.edit') }}" class="text-decoration-none">Mon profil</a>
                                        </li>
                                    @else
                                        <li class="list-group-item">
                                            <a href="{{ route('login') }}" class="text-decoration-none">Se connecter</a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('register') }}" class="text-decoration-none">Créer un compte</a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-4 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-swimmer me-2"></i>
                                    Exercices et entraînements
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('exercices.index') }}" class="text-decoration-none">Tous les exercices</a>
                                    </li>
                                    @auth
                                        <li class="list-group-item">
                                            <a href="{{ route('user.training.index') }}" class="text-decoration-none">Mes séances</a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-4 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Plans et carnets
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('plans.index') }}" class="text-decoration-none">Tous les plans</a>
                                    </li>
                                    @auth
                                        <li class="list-group-item">
                                            <a href="{{ route('user.mylists') }}" class="text-decoration-none">Mes carnets</a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-4 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-tools me-2"></i>
                                    Outils et calculateurs
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('tools.index') }}" class="text-decoration-none">Tous les outils</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('tools.bmi') }}" class="text-decoration-none">Calculateur IMC</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('tools.swimming-predictor') }}" class="text-decoration-none">Prédicteur de performance</a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-4 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-home me-2"></i>
                                    Pages principales
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('home') }}" class="text-decoration-none">Accueil</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('about') }}" class="text-decoration-none">À propos</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('contact') }}" class="text-decoration-none">Contact</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('features') }}" class="text-decoration-none">Fonctionnalités</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('pricing') }}" class="text-decoration-none">Plans d'inscription</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('public.index') }}" class="text-decoration-none">Articles</a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-4 mb-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-gavel me-2"></i>
                                    Pages légales
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('legal') }}" class="text-decoration-none">Mentions légales</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('privacy') }}" class="text-decoration-none">Politique de confidentialité</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('cookies') }}" class="text-decoration-none">Politique des cookies</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ route('accessibility') }}" class="text-decoration-none">Accessibilité</a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Besoin d'aide -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container-lg">
        <h2 class="h4 mb-4">Besoin d'aide supplémentaire ?</h2>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
            <i class="fas fa-envelope me-2"></i>
            Contactez notre équipe
        </a>
    </div>
</section>

@endsection