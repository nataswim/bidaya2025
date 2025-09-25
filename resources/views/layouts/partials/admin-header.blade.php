<header class="bg-white border-bottom p-3">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-secondary d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h4 class="mb-0">@yield('page-title', 'Administration')</h4>
                <small class="text-muted">@yield('page-description', 'Gestion du contenu et des utilisateurs')</small>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <!-- Recherche rapide -->
            <div class="position-relative d-none d-md-block">
                <input type="text" class="form-control ps-4" 
                       placeholder="Recherche rapide..." style="width: 250px;">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </div>
            
            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-outline-primary position-relative rounded-circle" 
                        style="width: 40px; height: 40px;" 
                        data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        3
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px;">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">Notifications</h6>
                    </div>
                    <div class="p-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 35px; height: 35px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="flex-fill">
                                <div class="fw-semibold">Nouvel utilisateur</div>
                                <small class="text-muted">Il y a 5 minutes</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir toutes les notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Menu utilisateur -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" 
                        data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                         style="width: 32px; height: 32px; font-size: 14px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                            <i class="fas fa-user me-2"></i>Mon profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="fas fa-globe me-2"></i>Voir le site
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Se deconnecter
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>