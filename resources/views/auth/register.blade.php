@extends('layouts.public')


@section('content')
<div class="min-vh-100 d-flex align-items-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user-plus text-white fa-2x"></i>
                            </div>
                            <h2 class="fw-bold">Creer un compte</h2>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nom complet</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        class="form-control border-start-0 @error('name') is-invalid @enderror"
                                        placeholder="Jean Dupont"
                                        required autofocus>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email valide</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        placeholder="jean@example.com"
                                        required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password"
                                            name="password"
                                            id="password"
                                            class="form-control border-start-0 @error('password') is-invalid @enderror"
                                            placeholder="••••••••"
                                            required>
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirmer</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            class="form-control border-start-0"
                                            placeholder="••••••••"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox"
                                        name="terms"
                                        id="terms"
                                        class="form-check-input"
                                        required>
                                    <label for="terms" class="form-check-label">
                                        J'accepte les <a href="{{ route('privacy') }}">conditions d'utilisation</a>
                                        et la <a href="{{ route('privacy') }}">
                                            Politique de confidentialité
                                        </a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Creer mon compte
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <span class="text-muted">Deja membre ?</span>
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                    Se connecter
                                </a>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>






<!-- Tableau Comparatif Visiteur vs Premium -->
<section id="comparatif" class="py-5 bg-white">
    <div class="container-lg">


        <div class="alert alert-warning border-0 shadow-sm text-center">
            <div class="row align-items-center">
                <div class="col mx-auto">
                    <p class="mb-3">
                        <strong>Pour les inscriptions premium de groupes, clubs ou centres de formation, veuillez <a href="{{ route('contact') }}">
                                Nous contacter <i class="fas fa-envelope me-2"></i> </a>.</strong>
                    </p>
                </div>
            </div>
        </div>


        <div class="mb-5">

            <h2 class="mt-3">Comment obtenir un compte Premium </h2>
            <p class="text-muted">1. Créez un compte utilisateur.
            </p>

            <p class="text-muted">
                2. Connectez-vous à votre espace avec votre adresse e-mail et votre mot de passe. </p>

            <p class="text-muted"> 3. Sélectionnez une formule premium et valider.</p>

            <p class="text-muted"> 4. Vous débloquerez ainsi l'accès à l'intégralité du contenu réservé aux membres premium.</p>


        </div>

        <div class="row g-4 mb-5">
            <!-- Colonne Visiteur -->
            <div class="col-lg-6">
                <div class="card h-100 border-danger">
                    <div class="card-header bg-danger text-white text-center p-4">
                        <i class="fas fa-user fa-2x mb-2"></i>
                        <h3 class="h4 mb-0">Compte Visiteur</h3>
                        <p class="mb-0 small">Gratuit - Accès limité</p>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-3"></i>
                                <span>Accès <strong>limité</strong> aux articles</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-3"></i>
                                <span>Quelques vidéos gratuites seulement</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-3"></i>
                                <span>Aperçu des plans d'entraînement</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-3"></i>
                                <span>Extraits d'eBooks uniquement</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-3"></i>
                                <span>Fiches techniques limitées</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-3"></i>
                                <span><strong>Pas de carnets personnalisés</strong></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>Outils gratuits (calculateurs)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Colonne Premium -->
            <div class="col-lg-6">
                <div class="card h-100 border-success shadow-lg position-relative">
                    <div class="position-absolute top-0 start-50 translate-middle">
                        <span class="badge bg-warning text-dark px-4 py-2 fs-6">
                            <i class="fas fa-star me-1"></i>Recommandé
                        </span>
                    </div>
                    <div class="card-header bg-success text-white text-center p-4">
                        <i class="fas fa-crown fa-2x mb-2"></i>
                        <h3 class="h4 mb-0">Compte Premium</h3>
                        <p class="mb-0 small">À partir de 5€/mois</p>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span><strong>Accès illimité</strong> à tous les articles</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span><strong>Bibliothèque vidéos complète</strong></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>Plans d'entraînement complets</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>Téléchargement illimité d'eBooks</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>Toutes les fiches techniques</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span><strong>Carnets personnalisés illimités</strong></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>Mises à jour et nouveaux contenus</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <span>Support prioritaire</span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>


    </div>
</section>





<section class="py-5 bg-light">
    <div class="container-lg">
        <header class="text-center mb-5">
            <h2 class="fw-bold display-6">Tout ce dont vous avez besoin</h2>

        </header>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- 1. Séances & Plans -->
            <div class="col">
                <a href="{{ route('public.workouts.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clipboard-list me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Séances & Plans</h4>
                                    @php
                                    $workoutSectionsCount = \App\Models\WorkoutSection::where('is_active', true)->count();
                                    $workoutsCount = \App\Models\Workout::count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $workoutSectionsCount }} sections • {{ $workoutsCount }} workouts</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Programmes structurés pour tous niveaux : technique, endurance, sprint. Plans hebdomadaires et cycles d'entraînement pour les sportifs.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">Choisir vos plans →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Débutant</span>
                                    <span class="badge bg-warning">Avancé</span>
                                    <span class="badge bg-danger">Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Exercices spécialisés -->
            <div class="col">
                <a href="{{ route('exercices.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-dumbbell me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Exercices spécialisés</h4>
                                    @php
                                    $exercicesCount = \App\Models\Exercice::where('is_active', true)->count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $exercicesCount }} {{ $exercicesCount > 1 ? 'exercices disponibles' : 'exercice disponible' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Bibliothèque d'exercices musculation, natation et préparation physique. Techniques détaillées avec vidéos et conseils professionnels.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-success fw-bold">Voir les exercices →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-info">Vidéos</span>
                                    <span class="badge bg-primary">Détaillés</span>
                                    <span class="badge bg-warning">Techniques</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Fiches techniques -->
            <div class="col">
                <a href="{{ route('public.fiches.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-info text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book-open me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Fiches techniques</h4>
                                    @php
                                    $fichesCount = \App\Models\Fiche::where('is_published', true)->where('visibility', 'public')->count();
                                    $fichesCategoriesCount = \App\Models\FichesCategory::where('is_active', true)->count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $fichesCategoriesCount }} catégories • {{ $fichesCount }} fiches</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Des guides complets sur les techniques, préparation physique, entraînement, sciences, stratégies et plus.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-info fw-bold">Accéder aux fiches →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Sciences</span>
                                    <span class="badge bg-primary">Techniques</span>
                                    <span class="badge bg-warning">Stratégies</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 4. Calculateurs & Outils -->
            <div class="col">
                <a href="{{ route('tools.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-warning text-dark">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calculator me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Calculateurs & Outils</h4>
                                    <p class="mb-0 opacity-75">18 outils spécialisés disponibles</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Outils de calcul spécialisés : VNC, prédicteur de temps natation, zones cardiaques, planification triathlon.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning fw-bold">Utiliser nos outils →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">Gratuit</span>
                                    <span class="badge bg-primary">Précis</span>
                                    <span class="badge bg-info">Pratique</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 5. Suivi de progression -->
            <div class="col">
                <div class="card h-100 shadow-lg border-0 bg-white category-card opacity-75">
                    <div class="card-header bg-secondary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line me-3" style="font-size: 2rem;"></i>
                            <div class="flex-grow-1">
                                <h4 class="mb-1">Suivi de progression</h4>
                                <p class="mb-0 opacity-75">Bientôt disponible</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="card-text text-muted mb-3">
                            Enregistrez vos performances, analysez votre évolution avec graphiques et statistiques détaillés.
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary fw-bold">Prochainement →</span>
                            <div class="d-flex gap-1">
                                <span class="badge bg-info">Statistiques</span>
                                <span class="badge bg-success">Graphiques</span>
                                <span class="badge bg-primary">Analyses</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Ressources téléchargeables -->
            <div class="col">
                <a href="{{ route('ebook.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-download me-3" style="font-size: 2rem;"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1">Ressources téléchargeables</h4>
                                    @php
                                    $totalDownloads = \App\Models\Downloadable::where('status', 'active')->count();
                                    $downloadCategoriesCount = \App\Models\DownloadCategory::where('status', 'active')->count();
                                    @endphp
                                    <p class="mb-0 opacity-75">{{ $downloadCategoriesCount }} catégories • {{ $totalDownloads }} ressources</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="card-text text-muted mb-3">
                                Documents PDF, vidéos d'entraînement, guides techniques et supports pédagogiques pour techniciens, sportifs et entraîneurs.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-danger fw-bold">Télécharger les documents →</span>
                                <div class="d-flex gap-1">
                                    <span class="badge bg-success">PDF</span>
                                    <span class="badge bg-primary">Vidéos</span>
                                    <span class="badge bg-warning">Guides</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>




@endsection