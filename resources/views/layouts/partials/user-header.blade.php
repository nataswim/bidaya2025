<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-lg">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('user.dashboard') }}">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 35px; height: 35px;">
                <i class="fas fa-user text-white"></i>
            </div>
            <span class="fw-bold text-primary">Mon Espace</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="userNav">
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
                       href="{{ route('user.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.*') ? 'active' : '' }}" 
                       href="{{ route('public.index') }}">
                        <i class="fas fa-newspaper me-1"></i>Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}" 
                       href="{{ route('user.profile.edit') }}">
                        <i class="fas fa-user-edit me-1"></i>Mon profil
                    </a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center">
@if(auth()->check() && auth()->user()->role && auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-danger me-3">
                        <i class="fas fa-cog me-1"></i>Admin
                    </a>
                @endif
                
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" 
                            data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 28px; height: 28px; font-size: 12px;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        {{ auth()->user()->first_name ?: auth()->user()->name }}
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-globe me-2"></i>Site public
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Se dÃ©connecter
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>