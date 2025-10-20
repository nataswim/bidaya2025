{{-- Bandeau utilisateur connecté --}}
@auth
<div class="user-top-banner py-2" style="background-color: #0066af;border-top: 20px solid #04adb9;border-left: 20px solid #fbf7f1;border-right: 20px solid #fbf7f1;">
    <div class="d-flex align-items-center justify-content-center flex-nowrap gap-2 px-2">
        {{-- Lien Mon espace --}}
        <a href="{{ route('user.dashboard') }}" 
           class="banner-link d-flex align-items-center text-white text-decoration-none px-1 py-1 rounded-pill {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home me-1"></i>
            <span class="banner-text">Mon espace</span>
        </a>

        {{-- Lien Mes carnets --}}
        <a href="{{ route('user.notebooks.index') }}" 
           class="banner-link d-flex align-items-center text-white text-decoration-none px-1 py-1 rounded-pill {{ request()->routeIs('user.notebooks.*') ? 'active' : '' }}">
            <i class="fas fa-book me-1"></i>
            <span class="banner-text">Mes Carnets</span>
        </a>

        {{-- Bouton Passer Premium (seulement pour les visiteurs) --}}
        @if(auth()->user()->hasRole('visitor'))
        <a href="{{ route('payments.index') }}" 
           class="banner-link banner-link-premium d-flex align-items-center text-white text-decoration-none px-1 py-1 rounded-pill">
            <i class="fas fa-crown me-1"></i>
            <span class="banner-text">Devenir Premium</span>
        </a>
        @endif
    </div>
</div>
@endauth

{{-- Navigation principale existante --}}
<nav class="navbar navbar-expand-lg sticky-top" style="border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;background-color: #f9f5f4 !important;border-bottom: 20px solid #04adb9;border-top: 20px solid #04adb9;">
    <div class="container-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/team/nataswim_app_logo_4.png') }}" 
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

                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('home') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('home') }}">
                        <i class="fas fa-home me-2 text-success"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.index', 'public.show') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.index') }}">
                        <i class="fas fa-newspaper me-2 text-info"></i>Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.fiches.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.fiches.index') }}">
                        <i class="fas fa-file-alt me-2 text-info"></i>Fiches
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.videos.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.videos.index') }}">
                        <i class="fas fa-video me-2 text-info"></i>Vidéos
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.workouts.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.workouts.index') }}">
                        <i class="fas fa-clipboard-check me-2 text-info"></i>Entrainements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('ebook.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('ebook.index') }}">
                        <i class="fas fa-download me-2 text-info"></i>Ressources
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('exercices.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('exercices.index') }}">
                        <i class="fas fa-dumbbell me-2 text-info"></i>Musculation
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('plans.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('tools.index') }}">
                        <i class="fas fa-heartbeat me-2  text-info"></i>Outils
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
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-tachometer-alt text-primary me-2"></i>Mon tableau de bord
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('user.profile.edit') }}">
                                    <i class="fas fa-user text-info me-2"></i>Mon profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
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
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary px-4">
                            S'inscrire
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- CSS personnalisé pour le bandeau --}}
@push('styles')
<style>
    /* Bandeau utilisateur - Pleine largeur */
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
        0%, 100% {
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
        }
        50% {
            box-shadow: 0 4px 16px rgba(255, 193, 7, 0.7);
        }
    }

    /* Responsive mobile - tout sur une ligne */
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

        .user-top-banner > div {
            gap: 0.35rem !important;
        }
    }

    /* Très petits écrans - textes encore plus courts */
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

        .user-top-banner > div {
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