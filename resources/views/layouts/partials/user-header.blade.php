<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;background-color: #f9f5f4 !important;border-bottom: 20px solid #0f5c78;border-top: 20px solid #0f5c78;">
    <div class="container-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('user.dashboard') }}">
            <img src="{{ asset('assets/images/team/nataswim_app_logo_2.png') }}" 
                 alt="nataswim application pour tous" 
                 class="img-fluid" 
                 style="height: 100px; width: auto;">
        </a>
        
        <!-- Toggle mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="userNav">
            <!-- Navigation principale -->
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('user.dashboard') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('user.dashboard') }}">
                        <i class="fas fa-water me-2"></i>Mon Espace Personnel
                    </a>
                </li>
 
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('user.profile.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('user.profile.edit') }}">
                        <i class="fas fa-user-edit me-2"></i>Mon profil
                    </a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('home') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('home') }}">
                        <i class="fas fa-water me-2"></i>Voir Le Contenu
                    </a>
                </li>



<li class="nav-item">
                    <a class="nav-link px-3 py-2 {{ request()->routeIs('home') ? 'active bg-primary text-white' : 'text-dark' }}" 
                       href="{{ route('user.training.index') }}">
                        <i class="fas fa-water me-2"></i>Musculation
                    </a>
                </li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('user.notebooks.*') ? 'active' : '' }}" 
       href="{{ route('user.notebooks.index') }}">
        <i class="fas fa-book me-2"></i>Mes Carnets
    </a>
</li>

            </ul>
            
            <!-- Section utilisateur -->
            <div class="d-flex align-items-center">
                @if(auth()->check() && auth()->user()->role && auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger me-3 px-4">
                        <i class="fas fa-cog me-1"></i>Administration
                    </a>
                @endif
                
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
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('user.profile.edit') }}">
                                <i class="fas fa-user text-info me-2"></i>Mon profil
                            </a>
                        </li>





                        <li>
                            <a class="dropdown-item py-2" href="{{ route('home') }}">
                                <i class="fas fa-water text-success me-2"></i>Parcourir Le Site 
                            </a>
                        </li>
                        @if(auth()->user()->hasRole('admin'))
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog text-danger me-2"></i>Administration
                                </a>
                            </li>
                        @endif
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
            </div>
        </div>
    </div>
</nav>