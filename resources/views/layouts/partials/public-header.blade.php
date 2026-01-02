

{{-- Navigation principale existante --}}
<nav class="navbar navbar-expand-lg" style="border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px solid #00acc0;border-top: 20px solid #00acc0;">
    <div class="container-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/team/nataswim_app_logo_3.png') }}"
                alt="nataswim application pour tous"
                class="img-fluid"
                style="height: 80px; width: auto;">
        </a>

        <!-- Toggle mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation principale -->
            <ul class="navbar-nav me-auto ms-lg-4">


                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2 {{ request()->routeIs('public.index', 'public.show') ? 'active bg-primary text-white' : 'text-primary' }}"
                        href="{{ route('public.index') }}">
                        <i class="fas fa-water me-2"></i>Dossiers
                    </a>
                </li>
                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2 {{ request()->routeIs('public.fiches.*') ? 'active bg-primary text-white' : 'text-primary' }}"
                        href="{{ route('public.fiches.index') }}">
                        <i class="fas fa-water me-2"></i>Fiches
                    </a>
                </li>

                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2 {{ request()->routeIs('public.videos.*') ? 'active bg-primary text-white' : 'text-primary' }}"
                        href="{{ route('public.videos.index') }}">
                        <i class="fas fa-water me-2"></i>Vidéos
                    </a>
                </li>

                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2 {{ request()->routeIs('public.workouts.*') ? 'active bg-primary text-white' : 'text-primary' }}"
                        href="{{ route('public.workouts.index') }}">
                        <i class="fas fa-water me-2"></i>Entrainements
                    </a>
                </li>
                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2 {{ request()->routeIs('ebook.*') ? 'active bg-primary text-white' : 'text-primary' }}"
                        href="{{ route('ebook.index') }}">
                        <i class="fas fa-water me-2"></i>Ressources
                    </a>
                </li>
                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2 {{ request()->routeIs('exercices.*') ? 'active bg-primary text-white' : 'text-primary' }}"
                        href="{{ route('exercices.index') }}">
                        <i class="fas fa-water me-2"></i>Musculation
                    </a>
                </li>
                <li class="nav-item" style="font-weight: 600;">
                    <a class="nav-link navurl px-1 py-2"
                        href="{{ route('tools.index') }}">
                        <i class="fas fa-water me-2"></i>Outils
                    </a>
                </li>


        

            </ul>

            <!-- Section utilisateur -->
            <div class="d-flex align-items-center">
                @auth
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center"
                        type="button"
                        id="userDropdown"
                        data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 32px; height: 32px; font-size: 14px;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="d-none d-md-inline">{{ auth()->user()->first_name ?: auth()->user()->name }}</span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                        @if(auth()->user()->hasRole('admin'))
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-cog text-danger me-2"></i>Administration
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @endif
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-tachometer-alt text-dark me-2"></i>Mon tableau de bord
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('user.profile.edit') }}">
                                <i class="fas fa-user text-info me-2"></i>Mon profil
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-success d-flex align-items-center px-2 text-white">
                        <i class="fas fa-user-plus"></i> Connexion
                    </a>

                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>


{{-- Bandeau utilisateur connecté --}}
@auth
<div class="user-top-banner py-2" style="background-color: #fff !important;margin: 20px 0px;">
    <div class="d-flex align-items-center justify-content-center flex-nowrap gap-2 px-2">
        {{-- Lien Mon espace --}}
        <a href="{{ route('user.dashboard') }}"
            class="banner-link d-flex align-items-center text-white text-decoration-none  {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" style="background-image: linear-gradient(45deg, rgb(6.4465116279, 50.6511627907, 112.3534883721) 25%, #009ee3 90%);background-color: #046cae;border-radius: 5px 10px;padding: 10px 10px;">

            <span class="banner-text">Mon Espace</span>
        </a>

        {{-- Lien Mes carnets --}}
        <a href="{{ route('user.notebooks.index') }}"
            class="banner-link d-flex align-items-center text-white text-decoration-none  {{ request()->routeIs('user.notebooks.*') ? 'active' : '' }}" style="background-image: linear-gradient(45deg, rgb(6.4465116279, 50.6511627907, 112.3534883721) 25%, #009ee3 90%);background-color: #046cae;border-radius: 5px 10px;padding: 10px 10px;">

            <span class="banner-text">Mes Carnets</span>
        </a>
        {{-- Lien calendar --}}
        <a href="{{ route('user.calendar.index') }}"
            class="banner-link d-flex align-items-center text-white text-decoration-none  {{ request()->routeIs('user.notebooks.*') ? 'active' : '' }}" style="background-image: linear-gradient(45deg, rgb(6.4465116279, 50.6511627907, 112.3534883721) 25%, #009ee3 90%);background-color: #046cae;border-radius: 5px 10px;padding: 10px 10px;">

            <span class="banner-text">Ma Planification</span>
        </a>
        {{-- Bouton Passer Premium (seulement pour les visiteurs) --}}
        @if(auth()->user()->hasRole('visitor'))
        <a href="{{ route('payments.index') }}"
            class="banner-link banner-link-premium d-flex align-items-center text-dark text-decoration-none px-1 py-1 rounded-pill">
            <i class="fas fa-crown me-1"></i>
            <span class="banner-text">Devenir Premium</span>
        </a>
        @endif
    </div>
</div>
@endauth





{{-- CSS personnalisé pour le bandeau et les dropdowns --}}
@push('styles')
<style>
    /* ========== BANDEAU UTILISATEUR ========== */
    .user-top-banner {
        background-color: #198754 !important;
        border-bottom: 2px solid #146c43;
        position: relative;
        z-index: 1040;
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
    }

    .user-top-banner::-webkit-scrollbar {
        height: 3px;
    }

    .user-top-banner::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    /* Liens du bandeau */
    .banner-link {
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .banner-link:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
        transform: translateY(-1px);
    }

    .banner-link.active {
        background-color: rgba(255, 255, 255, 0.25) !important;
        font-weight: 600;
    }

    /* Bouton Premium avec effet spécial */
    .banner-link-premium {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%) !important;
        color: #000 !important;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
        animation: pulse-premium 2s ease-in-out infinite;
    }

    .banner-link-premium:hover {
        background: linear-gradient(135deg, #ffcd38 0%, #ffb74d 100%) !important;
        color: #000 !important;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.6);
    }

    .banner-link-premium i,
    .banner-link-premium span {
        color: #000 !important;
    }

    @keyframes pulse-premium {

        0%,
        100% {
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
        }

        50% {
            box-shadow: 0 4px 16px rgba(255, 193, 7, 0.7);
        }
    }

    /* ========== DROPDOWN MENUS ========== */

    /* Menu principal dropdown */
    .dropdown-menu {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 0.5rem;
        min-width: 260px;
    }

    /* Items du dropdown */
    .dropdown-item {
        border-radius: 0.375rem;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        color: #495057;
    }

    .dropdown-item:hover {
        background-color: rgba(4, 173, 185, 0.1);
        color: #0066af;
        transform: translateX(5px);
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
        font-size: 1rem;
    }

    /* Sous-menus imbriqués (dropend) */
    .dropend>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: 0.125rem;
    }

    /* Flèche pour les sous-menus sur desktop */
    .dropend>.dropdown-toggle::after {
        border: none;
        content: "\f054";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 0.7rem;
        margin-left: auto;
        float: right;
        padding-left: 0.5rem;
    }

    /* Séparateur */
    .dropdown-divider {
        margin: 0.5rem 0;
        border-color: rgba(0, 0, 0, 0.08);
    }

    /* ========== RESPONSIVE MOBILE ========== */
    @media (max-width: 991px) {

        /* Sur mobile, les sous-menus apparaissent en dessous */
        .dropend>.dropdown-menu {
            position: static !important;
            transform: none !important;
            border: none;
            box-shadow: none;
            padding-left: 1rem;
            margin-top: 0.25rem;
            background-color: #f8f9fa;
            border-left: 3px solid #04adb9;
        }

        /* Flèche vers le bas sur mobile */
        .dropend>.dropdown-toggle::after {
            content: "\f078";
            float: right;
        }

        /* Items plus compacts sur mobile */
        .dropdown-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        .dropdown-menu {
            min-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .user-top-banner {
            padding: 0.5rem 0 !important;
        }

        .banner-link {
            font-size: 0.75rem;
            padding: 0.35rem 0.6rem !important;
        }

        .banner-link i {
            font-size: 0.85rem;
        }

        .banner-text {
            font-size: 0.75rem;
        }

        .user-top-banner>div {
            gap: 0.35rem !important;
        }
    }

    /* Très petits écrans */
    @media (max-width: 380px) {
        .banner-link {
            font-size: 0.7rem;
            padding: 0.3rem 0.5rem !important;
        }

        .banner-link i {
            font-size: 0.8rem;
            margin-right: 0.25rem !important;
        }

        .banner-text {
            font-size: 0.7rem;
        }

        .user-top-banner>div {
            gap: 0.25rem !important;
            padding: 0 0.5rem !important;
        }
    }

    /* iPhone SE et similaires */
    @media (max-width: 320px) {
        .banner-link {
            padding: 0.25rem 0.4rem !important;
        }

        .banner-link i {
            margin-right: 0.2rem !important;
        }
    }
</style>
@endpush

{{-- JavaScript pour les sous-menus imbriqués --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des sous-menus sur desktop
        if (window.innerWidth >= 992) {
            // Ouverture au hover sur desktop
            const dropendItems = document.querySelectorAll('.dropend');

            dropendItems.forEach(function(item) {
                const submenu = item.querySelector('.dropdown-menu');

                if (submenu) {
                    item.addEventListener('mouseenter', function() {
                        submenu.classList.add('show');
                    });

                    item.addEventListener('mouseleave', function() {
                        submenu.classList.remove('show');
                    });
                }
            });
        } else {
            // Gestion des clics sur mobile pour les sous-menus
            const dropendToggles = document.querySelectorAll('.dropend > .dropdown-toggle');

            dropendToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const submenu = this.nextElementSibling;

                    if (submenu && submenu.classList.contains('dropdown-menu')) {
                        // Toggle le sous-menu
                        const isVisible = submenu.style.display === 'block';

                        // Fermer tous les autres sous-menus
                        document.querySelectorAll('.dropend .dropdown-menu').forEach(function(menu) {
                            menu.style.display = 'none';
                        });

                        // Toggle le sous-menu actuel
                        submenu.style.display = isVisible ? 'none' : 'block';
                    }
                });
            });
        }
    });
</script>
@endpush