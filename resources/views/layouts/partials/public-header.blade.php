<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;background-color: #f9f5f4 !important;border-bottom: 20px solid #0f5c78;border-top: 20px solid #0f5c78;">
    <div class="container-lg">
        <!-- Logo avec style aquatique -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                <i class="fas fa-water text-white"></i>
            </div>
            <span class="fw-bold fs-4 text-primary">{{ config('app.name') }}</span>
        </a>
        
        <!-- Toggle mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation principale -->
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('home') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('public.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('public.index') }}">
                        <i class="fas fa-newspaper me-2"></i>Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('about') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-2"></i>Ã propos
                    </a>
                </li>
                <li class="nav-item">
    <a class="nav-link px-3 py-2 {{ request()->routeIs('ebook.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
       href="{{ route('ebook.index') }}">
        <i class="fas fa-download me-2"></i>Téléchargements
    </a>
</li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('contact') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-2"></i>Contact
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
                                        <i class="fas fa-sign-out-alt me-2"></i>Se deconnecter
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