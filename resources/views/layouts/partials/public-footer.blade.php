@php
$chiffre1 = mt_rand(55, 188);
$chiffre2 = mt_rand(79, 123);
@endphp

<footer class="text-light" style="background-color: #0059ab !important;border-top: 20px solid #f9f5f4;margin-top: 50px;">
    <!-- statistiques  -->

    <div class="w-100 text-center py-3" style="background-color: #0059ab;">
        <div>
            <p class="mb-0">
                <a href="https://nataswimshop.com/boutique/" target="_blank" rel="noopener noreferrer" class="d-inline-block shop-link">
                    <img src="{{ asset('assets/images/team/nataswim-pays-monde-centre.png') }}"
                        alt="boutique natation triathlon offres club et promotions"
                        class="img-fluid shop-image"
                        style="max-width: 100%; height: auto;">
                </a>
            </p>
        </div>

    </div>


    <div class="w-100 text-center nataswim-titre py-3">

        <p class="mb-0">En Ligne : - Visiteurs : {{ $chiffre1 }} | Membres : {{ $chiffre2 }}</p>

    </div>

    <!-- Contenu principal du footer -->
    <div class="py-5">
        <div class="container-lg">


            <div class="row g-4">
                <!-- A propos -->
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 50px; height: 50px;">
                            <i class="fas fa-water text-white"></i>
                        </div>
                        <h5 class="mb-0 text-white">Nata'Swim</h5>
                    </div>
                    <p class="text-light opacity-75 mb-4">
Nous partageons nos connaissances avec la communauté du sport. 
 <a href="{{ route('public.catalogue.index') }}" class="text-white fw-bold text-decoration-none">
 Mettre à jour mes connaissances
                            </a>
                    </p>
                    <div class="text-light opacity-75">
                        <i class="fas fa-shield-alt me-2"></i>
                        <small>Vos données sont protégées. Aucun spam.</small>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Navigation</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-home me-2"></i>Accueil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('about') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-info-circle me-2"></i>À propos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('features') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-star me-2"></i>Fonctionnalités
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pricing') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-tag me-2"></i>Plans d'inscription
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('guide') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-book-open me-2"></i>Guide d'utilisation
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('contact') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-envelope me-2"></i>Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Ressources -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Ressources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('public.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-newspaper me-2"></i>Articles & Dossiers
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('public.fiches.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-file-alt me-2"></i>Fiches thématiques
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('ebook.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-download me-2"></i>Documents à télécharger
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('exercices.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-dumbbell me-2"></i>Exercices
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('plans.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-calendar-alt me-2"></i>Plans d'entraînement
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('tools.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-calculator me-2"></i>Outils & Calculateurs
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Informations légales -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Informations</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('legal') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-gavel me-2"></i>Mentions légales
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('privacy') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-shield-alt me-2"></i>Politique de confidentialité
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('cookies') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-cookie-bite me-2"></i>Politique de cookies
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('accessibility') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                <i class="fas fa-universal-access me-2"></i>Accessibilité
                            </a>
                        </li>
                    </ul>

                    <!-- Réseaux sociaux (optionnel) -->
                    <div class="mt-4">
                        <h6 class="text-white fw-semibold mb-3">Suivez-nous</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/Sports.Ressources/" class="btn btn-outline-light btn-sm" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="https://www.facebook.com/profile.php?id=100063768510820" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.instagram.com/med_hassan_el_haouat/" class="btn btn-outline-light btn-sm" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.youtube.com/@stevemarshvedravokivish2069" class="btn btn-outline-light btn-sm" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de copyright -->
    <div style="background-color: #082f3e;">


        <div class="container-lg py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light opacity-75">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
                    </p>
                    <p class="mb-0 text-light opacity-75 mt-2">
                        Conception et développement
                        <a href="https://mycreanet.fr/realisations-projets/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-white text-decoration-none hover-opacity-100 fw-semibold">
                            MyCreaNet Agency
                        </a>
                    </p>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-wrap justify-content-md-end gap-3">
                        <a href="{{ route('privacy') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                            Politique de confidentialité
                        </a>
                        <a href="{{ route('cookies') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                            Cookies
                        </a>
                        <a href="{{ route('legal') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                            Mentions légales
                        </a>
                    </div>
                </div>
            </div>
        </div>





    </div>
</footer>
@push('styles')
<style>
    .hover-opacity-100:hover {
        opacity: 1 !important;
        transition: opacity 0.3s ease;
    }

    /* Style pour l'image de la boutique avec effet hover */
    .shop-link {
        display: inline-block;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .shop-link:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    .shop-image {
        display: block;
        width: 100%;
        max-width: 1200px;
        height: auto;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .shop-image {
            max-width: 100%;
        }
    }
</style>
@endpush