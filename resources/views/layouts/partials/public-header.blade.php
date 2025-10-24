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
                        <i class="fas fa-life-ring me-2 text-primary"></i>Dossiers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.fiches.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.fiches.index') }}">
                        <i class="fas fa-life-ring me-2 text-primary"></i>Fiches
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.videos.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.videos.index') }}">
                        <i class="fas fa-life-ring me-2 text-primary"></i>Vidéos
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('public.workouts.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.workouts.index') }}">
                        <i class="fas fa-life-ring me-2 text-primary"></i>Entrainements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('ebook.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('ebook.index') }}">
                        <i class="fas fa-life-ring me-2 text-primary"></i>Ressources
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-1 py-2 {{ request()->routeIs('exercices.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('exercices.index') }}">
                        <i class="fas fa-life-ring me-2 text-primary"></i>Musculation
                    </a>
                </li>

                {{-- Menu Outils avec sous-menu --}}
                <li class="nav-item dropdown position-static">
                    <a class="nav-link px-1 py-2 dropdown-toggle {{ request()->routeIs('tools.*', 'plans.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="#" 
                       id="toolsDropdown"
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        <i class="fas fa-water me-2 text-primary"></i>Outils
                    </a>
                    
                    {{-- Mega Menu Desktop --}}
                    <div class="dropdown-menu mega-menu-tools shadow-lg border-0 mt-0 p-0 animate__animated animate__fadeIn" aria-labelledby="toolsDropdown">
                        <div class="container-fluid px-4 py-4">
                            <div class="row">
                                {{-- Colonne 1 : Santé & Nutrition --}}
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                        <i class="fas fa-heartbeat me-2"></i>Santé & Nutrition
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('tools.bmi') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-weight me-2 text-info"></i>
                                                <span>Calculateur IMC</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.masse-grasse') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-percentage me-2 text-info"></i>
                                                <span>Masse grasse</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.calories') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-fire me-2 text-danger"></i>
                                                <span>Conso Calories</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.tdee-calculator') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-chart-line me-2 text-success"></i>
                                                <span>Calculateur TDEE</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.kcal-macros') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-calculator me-2 text-warning"></i>
                                                <span>Kcal/Macros</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.hydratation') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-tint me-2 text-primary"></i>
                                                <span>Hydratation</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Colonne 2 : Sports aquatiques --}}
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                        <i class="fas fa-swimmer me-2"></i>Natation
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('tools.chronometre') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-stopwatch me-2 text-info"></i>
                                                <span>Chrono Sport</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.vnc') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-tachometer-alt me-2 text-success"></i>
                                                <span>Calculateur VNC</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.swimming-predictor') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-swimmer me-2 text-purple"></i>
                                                <span>Prédicteur NAT</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.swimming-planner') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                <span>Planificateur NAT</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.swimming-efficiency') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-chart-area me-2 text-warning"></i>
                                                <span>Efficacité TECH</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Colonne 3 : Performance --}}
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                        <i class="fas fa-running me-2"></i>Performance
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('tools.heart-rate-zones') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-heart me-2 text-danger"></i>
                                                <span>Zones CARDIO</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.coherence-cardiaque') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-lungs me-2 text-info"></i>
                                                <span>Cohérence CARDIO</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.running-planner') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-route me-2 text-success"></i>
                                                <span>Planificateur CAP</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.onermcalculator') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-dumbbell me-2 text-dark"></i>
                                                <span>Calculateur RM</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.fitness') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-chart-pie me-2 text-warning"></i>
                                                <span>Calculateur FIT</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Colonne 4 : Outils pratiques & Plans --}}
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                        <i class="fas fa-cogs me-2"></i>Outils pratiques
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('tools.chronometre-pro') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-stopwatch-20 me-2 text-danger"></i>
                                                <span>Chrono Pro</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.carte-interactive') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-map-marked-alt me-2 text-info"></i>
                                                <span>Ou Suis-Je</span>
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('tools.triathlon-planner') }}" class="tool-link d-flex align-items-center">
                                                <i class="fas fa-biking me-2 text-success"></i>
                                                <span>Planificateur Tri</span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>

                            {{-- Ligne de catégories rapides --}}
                            <div class="row mt-3 pt-3 border-top">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <a href="{{ route('tools.index') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-th me-1"></i>Tous les outils
                                        </a>
                                        <a href="{{ route('tools.category.health') }}" class="btn btn-sm btn-outline-info">
                                            Santé
                                        </a>
                                        <a href="{{ route('tools.category.nutrition') }}" class="btn btn-sm btn-outline-warning">
                                            Nutrition
                                        </a>
                                        <a href="{{ route('tools.category.swimming') }}" class="btn btn-sm btn-outline-primary">
                                            Natation
                                        </a>
                                        <a href="{{ route('tools.category.cardiac') }}" class="btn btn-sm btn-outline-danger">
                                            Cardiaque
                                        </a>
                                        <a href="{{ route('tools.category.strength') }}" class="btn btn-sm btn-outline-dark">
                                            Musculation
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Menu mobile dépliable --}}
                    <div class="mobile-tools-menu d-lg-none">
                        <ul class="list-unstyled ps-3 mt-2" style="display: none;">
                            <li><a href="{{ route('tools.index') }}" class="dropdown-item"><i class="fas fa-th me-2"></i>Tous les outils</a></li>
                            <li class="dropdown-divider"></li>
                            
                            {{-- Santé & Nutrition --}}
                            <li class="fw-bold text-muted small ps-2 pt-2">SANTÉ & NUTRITION</li>
                            <li><a href="{{ route('tools.bmi') }}" class="dropdown-item"><i class="fas fa-weight me-2"></i>Calculateur IMC</a></li>
                            <li><a href="{{ route('tools.masse-grasse') }}" class="dropdown-item"><i class="fas fa-percentage me-2"></i>Masse grasse</a></li>
                            <li><a href="{{ route('tools.calories') }}" class="dropdown-item"><i class="fas fa-fire me-2"></i>Calories</a></li>
                            <li><a href="{{ route('tools.tdee-calculator') }}" class="dropdown-item"><i class="fas fa-chart-line me-2"></i>TDEE</a></li>
                            <li><a href="{{ route('tools.kcal-macros') }}" class="dropdown-item"><i class="fas fa-calculator me-2"></i>Kcal/Macros</a></li>
                            <li><a href="{{ route('tools.hydratation') }}" class="dropdown-item"><i class="fas fa-tint me-2"></i>Hydratation</a></li>
                            
                            {{-- Natation --}}
                            <li class="fw-bold text-muted small ps-2 pt-2">NATATION</li>
                            <li><a href="{{ route('tools.chronometre') }}" class="dropdown-item"><i class="fas fa-stopwatch me-2"></i>Chronomètre</a></li>
                            <li><a href="{{ route('tools.vnc') }}" class="dropdown-item"><i class="fas fa-tachometer-alt me-2"></i>VNC</a></li>
                            <li><a href="{{ route('tools.swimming-predictor') }}" class="dropdown-item"><i class="fas fa-crystal-ball me-2"></i>Prédicteur</a></li>
                            <li><a href="{{ route('tools.swimming-planner') }}" class="dropdown-item"><i class="fas fa-calendar-alt me-2"></i>Planificateur</a></li>
                            <li><a href="{{ route('tools.swimming-efficiency') }}" class="dropdown-item"><i class="fas fa-chart-area me-2"></i>Efficacité</a></li>
                            
                            {{-- Performance --}}
                            <li class="fw-bold text-muted small ps-2 pt-2">PERFORMANCE</li>
                            <li><a href="{{ route('tools.heart-rate-zones') }}" class="dropdown-item"><i class="fas fa-heart me-2"></i>Zones cardiaques</a></li>
                            <li><a href="{{ route('tools.coherence-cardiaque') }}" class="dropdown-item"><i class="fas fa-lungs me-2"></i>Cohérence cardiaque</a></li>
                            <li><a href="{{ route('tools.running-planner') }}" class="dropdown-item"><i class="fas fa-route me-2"></i>Course à pied</a></li>
                            <li><a href="{{ route('tools.onermcalculator') }}" class="dropdown-item"><i class="fas fa-dumbbell me-2"></i>RM/Charge max</a></li>
                            <li><a href="{{ route('tools.fitness') }}" class="dropdown-item"><i class="fas fa-chart-pie me-2"></i>Fitness</a></li>
                            
                            {{-- Pratiques --}}
                            <li class="fw-bold text-muted small ps-2 pt-2">PRATIQUES</li>
                            <li><a href="{{ route('tools.chronometre-pro') }}" class="dropdown-item"><i class="fas fa-stopwatch-20 me-2"></i>Chrono Pro</a></li>
                            <li><a href="{{ route('tools.carte-interactive') }}" class="dropdown-item"><i class="fas fa-map-marked-alt me-2"></i>Carte</a></li>
                            <li><a href="{{ route('tools.triathlon-planner') }}" class="dropdown-item"><i class="fas fa-biking me-2"></i>Triathlon</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ route('plans.index') }}" class="dropdown-item fw-bold"><i class="fas fa-clipboard-list me-2"></i>Plans d'entraînement</a></li>
                        </ul>
                    </div>
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

{{-- CSS personnalisé pour le bandeau et le mega menu --}}
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

    /* ========== MEGA MENU STYLES ========== */
    .mega-menu-tools {
        position: absolute;
        left: 0;
        right: 0;
        top: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-top: 3px solid #04adb9;
        min-height: 400px;
        display: none;
        animation-duration: 0.3s;
    }

    .dropdown:hover .mega-menu-tools,
    .dropdown.show .mega-menu-tools {
        display: block !important;
    }

    /* Style des liens dans le mega menu */
    .tool-link {
        color: #495057;
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .tool-link:hover {
        background-color: rgba(4, 173, 185, 0.1);
        color: #0066af;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(4, 173, 185, 0.15);
    }

    .tool-link i {
        font-size: 1.1rem;
        width: 25px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .tool-link:hover i {
        transform: scale(1.2) rotate(10deg);
    }

    /* Headers de catégories dans le mega menu */
    .mega-menu-tools h6 {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #0066af;
    }

    .mega-menu-tools h6 i {
        color: #04adb9;
    }

    /* Effet de survol sur les colonnes */
    .mega-menu-tools .col-lg-3:hover {
        background-color: rgba(4, 173, 185, 0.03);
        border-radius: 0.5rem;
        transition: background-color 0.3s ease;
    }

    /* Boutons de catégories */
    .mega-menu-tools .btn-outline-primary:hover,
    .mega-menu-tools .btn-outline-info:hover,
    .mega-menu-tools .btn-outline-warning:hover,
    .mega-menu-tools .btn-outline-danger:hover,
    .mega-menu-tools .btn-outline-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Icône violette personnalisée */
    .text-purple {
        color: #6f42c1 !important;
    }

    /* ========== RESPONSIVE MOBILE ========== */
    @media (max-width: 991px) {
        /* Cache le mega menu sur mobile */
        .mega-menu-tools {
            display: none !important;
        }

        /* Style du menu mobile */
        .mobile-tools-menu ul {
            background-color: #f8f9fa;
            border-left: 3px solid #04adb9;
            margin-top: 0.5rem;
            border-radius: 0.375rem;
        }

        .mobile-tools-menu .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .mobile-tools-menu .dropdown-item:hover {
            background-color: rgba(4, 173, 185, 0.1);
            color: #0066af;
        }

        .mobile-tools-menu .dropdown-item i {
            width: 20px;
            font-size: 0.9rem;
        }

        .mobile-tools-menu .fw-bold.text-muted {
            background-color: rgba(4, 173, 185, 0.05);
            padding: 0.5rem 0.75rem !important;
            margin-top: 0.5rem;
            font-size: 0.75rem !important;
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

        .user-top-banner > div {
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

{{-- JavaScript pour le menu mobile --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du menu mobile dépliable
    const toolsDropdown = document.getElementById('toolsDropdown');
    const mobileMenu = document.querySelector('.mobile-tools-menu ul');
    
    if (window.innerWidth < 992 && toolsDropdown && mobileMenu) {
        toolsDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle du menu mobile
            if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
                mobileMenu.style.display = 'block';
                // Animation d'ouverture
                mobileMenu.style.opacity = '0';
                setTimeout(() => {
                    mobileMenu.style.transition = 'opacity 0.3s ease';
                    mobileMenu.style.opacity = '1';
                }, 10);
            } else {
                mobileMenu.style.opacity = '0';
                setTimeout(() => {
                    mobileMenu.style.display = 'none';
                }, 300);
            }
        });

        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                if (mobileMenu && mobileMenu.style.display === 'block') {
                    mobileMenu.style.opacity = '0';
                    setTimeout(() => {
                        mobileMenu.style.display = 'none';
                    }, 300);
                }
            }
        });
    }
});
</script>
@endpush