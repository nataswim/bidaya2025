@extends('layouts.public')

@section('title', 'Guide d\'utilisation')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-book-reader me-3 fs-1"></i>
                    <h1 class="display-4 fw-bold mb-0">Guide d'utilisation</h1>
                </div>
                <p class="lead mb-4">
                    Découvrez tout ce que Nataswim peut vous offrir pour améliorer vos performances
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-star me-2"></i>Créer un compte gratuit
                    </a>
                    <a href="{{ route('pricing') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-crown me-2"></i>Voir les plans Premium
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <img src="{{ asset('assets/images/team/nataswim-application-banner-0.jpg') }}" 
                     alt="Guide Nataswim" 
                     class="img-fluid rounded-4 shadow-lg"
                     style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Alerte Premium -->
<section class="py-3 bg-warning">
    <div class="container-lg">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3 fs-3"></i>
                <div>
                    <strong>Visiteurs :</strong> Accès limité aux fonctionnalités et contenus • 
                    <strong>Premium :</strong> Accès illimité + Carnets personnalisés
                </div>
            </div>
            <a href="{{ route('pricing') }}" class="btn btn-dark btn-sm">
                <i class="fas fa-arrow-right me-2"></i>Passer Premium
            </a>
        </div>
    </div>
</section>

<!-- Table des matières -->
<section class="py-4 bg-light border-bottom sticky-top" style="top: 70px; z-index: 100;">
    <div class="container-lg">
        <nav class="d-flex flex-wrap justify-content-center gap-2">
            <a href="#comparatif" class="btn btn-outline-primary btn-sm">📊 Comparatif</a>
            <a href="#carnets" class="btn btn-outline-primary btn-sm">📚 Carnets</a>
            <a href="#videos" class="btn btn-outline-primary btn-sm">🎥 Vidéos</a>
            <a href="#exercices" class="btn btn-outline-primary btn-sm">🏋️ Exercices</a>
            <a href="#plans" class="btn btn-outline-primary btn-sm">📅 Plans</a>
            <a href="#ebooks" class="btn btn-outline-primary btn-sm">📖 eBooks</a>
            <a href="#fiches" class="btn btn-outline-primary btn-sm">📋 Fiches</a>
            <a href="#outils" class="btn btn-outline-primary btn-sm">🔧 Outils</a>
        </nav>
    </div>
</section>

<!-- Tableau Comparatif Visiteur vs Premium -->
<section id="comparatif" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <i class="fas fa-balance-scale text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3">Visiteur vs Premium : Quelle différence ?</h2>
            <p class="text-muted">Comparez les accès et débloquez tout le potentiel de Nataswim</p>
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
                        <p class="mb-0 small">À partir de 8€/mois</p>
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
                        <div class="text-center mt-4">
                            <a href="{{ route('pricing') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-arrow-right me-2"></i>Passer Premium maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bandeau Prix -->
        <div class="alert alert-warning border-0 shadow-sm text-center">
            <div class="row align-items-center">
                <div class="col-md-8 mx-auto">
                    <h4 class="mb-2">
                        <i class="fas fa-tag me-2"></i>Offre limitée : À partir de 8€/mois
                    </h4>
                    <p class="mb-3">
                        <strong>12 mois : 96€</strong> (8€/mois) • 
                        <strong>6 mois : 66€</strong> (11€/mois) • 
                        <strong>3 mois : 45€</strong> (15€/mois)
                    </p>
                    <a href="{{ route('pricing') }}" class="btn btn-dark btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Voir les tarifs détaillés
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Carnets d'entraînement (Premium uniquement) -->
<section id="carnets" class="py-5 bg-gradient-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <span class="badge bg-success text-white mb-3 px-4 py-2">
                <i class="fas fa-crown me-2"></i>EXCLUSIF PREMIUM
            </span>
            <h2 class="display-5 fw-bold">Carnets personnalisés</h2>
            <p class="text-muted lead">Organisez et suivez vos programmes d'entraînement</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-header bg-gradient-success text-white">
                        <h3 class="h6 mb-0">1️⃣ Création</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✅ Titre personnalisé</li>
                            <li class="mb-2">✅ Description détaillée</li>
                            <li class="mb-2">✅ Organisation par thèmes</li>
                            <li>✅ Carnets illimités</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-header bg-gradient-success text-white">
                        <h3 class="h6 mb-0">2️⃣ Contenu</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✅ Articles favoris</li>
                            <li class="mb-2">✅ Vidéos sélectionnées</li>
                            <li class="mb-2">✅ Exercices enregistrés</li>
                            <li>✅ Notes personnelles</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-header bg-gradient-success text-white">
                        <h3 class="h6 mb-0">3️⃣ Organisation</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✅ Réorganisation facile</li>
                            <li class="mb-2">✅ Duplication de carnets</li>
                            <li class="mb-2">✅ Export PDF</li>
                            <li>✅ Partage (bientôt)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-header bg-gradient-success text-white">
                        <h3 class="h6 mb-0">4️⃣ Avantages</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">✅ Accès 24/7</li>
                            <li class="mb-2">✅ Sauvegarde cloud</li>
                            <li class="mb-2">✅ Multi-appareils</li>
                            <li>✅ Confidentiel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-danger border-0 shadow-sm text-center">
            <div class="row align-items-center">
                <div class="col-md-8 mx-auto">
                    <i class="fas fa-lock fa-2x mb-3 text-danger"></i>
                    <h4 class="mb-3">Fonctionnalité réservée aux membres Premium</h4>
                    <p class="mb-3">
                        Créez vos carnets personnalisés et organisez vos contenus favoris. 
                        <strong>Passez Premium pour débloquer tout le contenu et profiter des mises à jour.</strong>
                    </p>
                    <a href="{{ route('pricing') }}" class="btn btn-danger btn-lg">
                        <i class="fas fa-unlock me-2"></i>Débloquer les Carnets (dès 8€/mois)
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bibliothèque Vidéos -->
<section id="videos" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                <span class="badge bg-success-subtle text-success px-3 py-2">
                    <i class="fas fa-check me-1"></i>Certaines gratuites
                </span>
                <span class="badge bg-warning-subtle text-warning px-3 py-2">
                    <i class="fas fa-crown me-1"></i>Majorité Premium
                </span>
            </div>
            <i class="fas fa-video text-danger" style="font-size: 3rem;"></i>
            <h2 class="mt-3 display-5 fw-bold">Bibliothèque de Vidéos</h2>
            <p class="text-muted lead">
                @php
                    $totalVideos = \App\Models\Video::where('is_published', true)->count();
                    $publicVideos = \App\Models\Video::where('is_published', true)->where('visibility', 'public')->count();
                    $premiumVideos = $totalVideos - $publicVideos;
                @endphp
                {{ $totalVideos }} vidéos disponibles • {{ $publicVideos }} gratuites • {{ $premiumVideos }} Premium
            </p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card h-100 border-success shadow-sm hover-lift">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-play-circle text-success mb-3" style="font-size: 3rem;"></i>
                        <h3 class="h4 mb-3">Vidéos Gratuites</h3>
                        <p class="text-muted mb-4">
                            Accédez à une sélection de {{ $publicVideos }} vidéos gratuites pour découvrir 
                            la qualité de nos contenus.
                        </p>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Techniques de base</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Exercices découverte</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Conseils généraux</li>
                        </ul>
                        <a href="{{ route('public.videos.index') }}" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-eye me-2"></i>Voir les vidéos gratuites
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 border-warning shadow-lg hover-lift position-relative">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="fas fa-crown me-1"></i>Premium
                        </span>
                    </div>
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-film text-warning mb-3" style="font-size: 3rem;"></i>
                        <h3 class="h4 mb-3">Bibliothèque Complète</h3>
                        <p class="text-muted mb-4">
                            Débloquez {{ $premiumVideos }} vidéos exclusives avec techniques avancées, 
                            programmes détaillés et contenus professionnels.
                        </p>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Tutoriels approfondis</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Programmes complets</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Contenus exclusifs</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Mises à jour régulières</li>
                        </ul>
                        <a href="{{ route('pricing') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-unlock me-2"></i>Débloquer tout (dès 8€/mois)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3 text-info"></i>
                <div>
                    <h5 class="mb-1">Comment ça marche ?</h5>
                    <p class="mb-0">
                        Les vidéos <strong>gratuites</strong> sont accessibles à tous. 
                        Les vidéos <strong>Premium</strong> nécessitent un compte actif. 
                        Consultez nos <a href="{{ route('pricing') }}" class="alert-link fw-bold">tarifs ici</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Exercices et Séances -->
<section id="exercices" class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                <span class="badge bg-info-subtle text-info px-3 py-2">
                    <i class="fas fa-eye me-1"></i>Aperçu gratuit
                </span>
                <span class="badge bg-success-subtle text-success px-3 py-2">
                    <i class="fas fa-unlock me-1"></i>Détails Premium
                </span>
            </div>
            <i class="fas fa-dumbbell text-success" style="font-size: 3rem;"></i>
            <h2 class="mt-3 display-5 fw-bold">Exercices & Préparation physique</h2>
            <p class="text-muted lead">
                @php
                    $totalExercices = \App\Models\Exercice::where('is_active', true)->count();
                @endphp
                {{ $totalExercices }} exercices détaillés avec techniques et conseils
            </p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-search text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 mb-3">Bibliothèque d'exercices</h3>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-light text-dark">Visiteur : Aperçu</span>
                            <span class="badge bg-success">Premium : Tout</span>
                        </div>
                        <p class="text-muted mb-4">
                            Parcourez {{ $totalExercices }} exercices. <strong>Visiteurs :</strong> aperçu limité. 
                            <strong>Premium :</strong> accès aux vidéos, détails complets et programmes.
                        </p>
                        <a href="{{ route('exercices.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Explorer les exercices
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 shadow-sm hover-lift border-success">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-calendar-check text-success mb-3" style="font-size: 2.5rem;"></i>
                        <h3 class="h4 mb-3">Programmes personnalisés</h3>
                        <span class="badge bg-success mb-3">Premium uniquement</span>
                        <p class="text-muted mb-4">
                            Créez vos programmes en combinant exercices, séries, répétitions. 
                            Sauvegardez dans vos carnets.
                        </p>
                        <a href="{{ route('pricing') }}" class="btn btn-success">
                            <i class="fas fa-unlock me-2"></i>Débloquer (dès 8€/mois)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-warning border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-lightbulb fa-2x me-3 text-warning"></i>
                <div>
                    <h5 class="mb-1">Astuce Premium</h5>
                    <p class="mb-0">
                        Membres Premium : Sauvegardez vos exercices favoris dans vos carnets pour y accéder rapidement !
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans d'entraînement -->
<section id="plans" class="py-5 bg-white">
    <div class="container-lg">
        <div class="text-center mb-5">
            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                <span class="badge bg-info-subtle text-info px-3 py-2">
                    <i class="fas fa-eye me-1"></i>Aperçu gratuit
                </span>
                <span class="badge bg-success-subtle text-success px-3 py-2">
                    <i class="fas fa-file-download me-1"></i>Accès complet Premium
                </span>
            </div>
            <i class="fas fa-calendar-alt text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3 display-5 fw-bold">Plans d'entraînement</h2>
            <p class="text-muted lead">Programmes structurés pour tous niveaux</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h3 class="h5 mb-4 fw-bold">Fonctionnement des plans :</h3>
                        <ol class="mb-4">
                            <li class="mb-3">
                                <strong>Parcourez</strong> les plans disponibles
                                <span class="badge bg-info-subtle text-info ms-2">Gratuit</span>
                            </li>
                            <li class="mb-3">
                                <strong>Aperçu</strong> du programme (visiteurs)
                                <span class="badge bg-warning-subtle text-warning ms-2">Limité</span>
                            </li>
                            <li class="mb-3">
                                <strong>Accès complet</strong> aux séances (Premium)
                                <span class="badge bg-success-subtle text-success ms-2">Premium</span>
                            </li>
                            <li class="mb-3">
                                <strong>Suivez</strong> votre progression
                                <span class="badge bg-success-subtle text-success ms-2">Premium</span>
                            </li>
                            <li class="mb-3">
                                <strong>Enregistrez</strong> dans vos carnets
                                <span class="badge bg-success-subtle text-success ms-2">Premium</span>
                            </li>
                        </ol>
                        
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('plans.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-eye me-2"></i>Voir les plans
                            </a>
                            <a href="{{ route('pricing') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-unlock me-2"></i>Accès complet (dès 8€/mois)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- eBooks et Ressources -->
<section id="ebooks" class="py-5 bg-gradient-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                <span class="badge bg-info-subtle text-info px-3 py-2">
                    <i class="fas fa-eye me-1"></i>Extraits gratuits
                </span>
                <span class="badge bg-success-subtle text-success px-3 py-2">
                    <i class="fas fa-download me-1"></i>Téléchargement Premium
                </span>
            </div>
            <i class="fas fa-book-reader text-primary" style="font-size: 3rem;"></i>
            <h2 class="mt-3 display-5 fw-bold">Bibliothèque eBooks & Documents</h2>
            <p class="text-muted lead">
                @php
                    $totalDownloads = \App\Models\Downloadable::where('status', 'active')->count();
                @endphp
                {{ $totalDownloads }} ressources à télécharger
            </p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3 fw-bold">📚 Contenu de la bibliothèque :</h3>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Guides techniques</strong>
                                        <div class="small text-muted">Détaillés par spécialité</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Programmes complets</strong>
                                        <div class="small text-muted">Plans PDF téléchargeables</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Conseils nutrition</strong>
                                        <div class="small text-muted">Adaptés aux sportifs</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Préparation mentale</strong>
                                        <div class="small text-muted">Motivation et focus</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mb-4 border-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Visiteurs :</strong> Consultez les aperçus et sommaires. 
                                    <strong>Premium :</strong> Téléchargement illimité de tous les documents.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('ebook.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-eye me-2"></i>Voir la bibliothèque
                            </a>
                            <a href="{{ route('pricing') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-download me-2"></i>Tout télécharger (dès 8€/mois)
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
            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                <span class="badge bg-info-subtle text-info px-3 py-2">
                    <i class="fas fa-eye me-1"></i>Quelques gratuites
                </span>
                <span class="badge bg-success-subtle text-success px-3 py-2">
                    <i class="fas fa-unlock me-1"></i>Toutes en Premium
                </span>
            </div>
            <i class="fas fa-file-alt text-info" style="font-size: 3rem;"></i>
            <h2 class="mt-3 display-5 fw-bold">Fiches techniques</h2>
            <p class="text-muted lead">
                @php
                    $totalFiches = \App\Models\Fiche::where('is_published', true)->count();
                    $publicFiches = \App\Models\Fiche::where('is_published', true)->where('visibility', 'public')->count();
                @endphp
                {{ $totalFiches }} fiches pratiques • {{ $publicFiches }} gratuites
            </p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3 fw-bold">📋 Types de fiches disponibles :</h3>
                        <ul class="mb-4">
                            <li class="mb-2">Fiches techniques par spécialité</li>
                            <li class="mb-2">Points clés et mémos</li>
                            <li class="mb-2">Conseils d'entraînement</li>
                            <li class="mb-2">Synthèses visuelles</li>
                            <li class="mb-2">Schémas et illustrations</li>
                        </ul>

                        <div class="alert alert-success mb-4 border-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>
                                    <strong>Format pratique</strong> - Imprimez vos fiches pour les avoir au bord du bassin. 
                                    Membres Premium : accès à toutes les fiches.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('public.fiches.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-eye me-2"></i>Consulter les fiches
                            </a>
                            <a href="{{ route('pricing') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-unlock me-2"></i>Tout débloquer (dès 8€/mois)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Outils et Calculateurs (GRATUITS) -->
<section id="outils" class="py-5 bg-light">
    <div class="container-lg">
        <div class="text-center mb-5">
            <span class="badge bg-success text-white mb-3 px-4 py-2">
                <i class="fas fa-gift me-2"></i>100% GRATUIT POUR TOUS
            </span>
            <i class="fas fa-tools text-warning" style="font-size: 3rem;"></i>
            <h2 class="mt-3 display-5 fw-bold">Outils & Calculateurs</h2>
            <p class="text-muted lead">18 outils professionnels gratuits sans inscription</p>
        </div>

        <div class="row g-4 mb-4">
            @php
            $toolCategories = [
                [
                    'name' => 'Santé & Composition',
                    'icon' => 'fas fa-heartbeat',
                    'color' => 'danger',
                    'tools' => ['IMC', 'Masse Grasse', 'Fitness']
                ],
                [
                    'name' => 'Nutrition & Énergie',
                    'icon' => 'fas fa-utensils',
                    'color' => 'success',
                    'tools' => ['Calories', 'TDEE', 'Hydratation', 'Kcal/Macros']
                ],
                [
                    'name' => 'Performance Cardiaque',
                    'icon' => 'fas fa-heart',
                    'color' => 'danger',
                    'tools' => ['Zones Cardiaques', 'Cohérence Cardiaque']
                ],
                [
                    'name' => 'Natation',
                    'icon' => 'fas fa-swimmer',
                    'color' => 'info',
                    'tools' => ['VNC', 'Prédicteur', 'Efficacité', 'Chronomètre']
                ]
            ];
            @endphp

            @foreach($toolCategories as $category)
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm hover-lift border-{{ $category['color'] }}">
                    <div class="card-header bg-{{ $category['color'] }}-subtle">
                        <div class="d-flex align-items-center">
                            <i class="{{ $category['icon'] }} text-{{ $category['color'] }} me-3 fs-3"></i>
                            <div>
                                <h3 class="h5 mb-0">{{ $category['name'] }}</h3>
                                <small class="text-muted">{{ count($category['tools']) }} outils disponibles</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($category['tools'] as $tool)
                            <span class="badge bg-{{ $category['color'] }}-subtle text-{{ $category['color'] }} px-3 py-2">
                                {{ $tool }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('tools.index') }}" class="btn btn-warning btn-lg px-5">
                <i class="fas fa-calculator me-2"></i>Accéder aux outils gratuits
            </a>
        </div>

        <div class="alert alert-success border-0 shadow-sm text-center mt-4">
            <div class="d-flex align-items-center justify-content-center">
                <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                <div>
                    <strong>Tous nos outils sont 100% gratuits</strong> et accessibles sans inscription. 
                    Créez un compte Premium pour sauvegarder vos résultats et accéder à tous les contenus !
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final Premium -->
<section class="py-5 bg-gradient-primary text-white">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
                <i class="fas fa-crown fa-3x mb-3"></i>
                <h2 class="display-5 fw-bold mb-3">Prêt à passer Premium ?</h2>
                <p class="lead mb-0">
                    Débloquez tout le contenu, créez vos carnets personnalisés et profitez des mises à jour régulières. 
                    <strong>À partir de 8€/mois seulement.</strong>
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <a href="{{ route('pricing') }}" class="btn btn-warning btn-lg btn-block w-100 py-3 mb-3">
                    <i class="fas fa-star me-2"></i>Voir les tarifs
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg btn-block w-100 py-3">
                    <i class="fas fa-envelope me-2"></i>Nous contacter
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-light {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}

.card {
    border-radius: 1rem;
}

.badge {
    font-weight: 500;
}
</style>
@endpush