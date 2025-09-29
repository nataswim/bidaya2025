<nav class="sidebar bg-dark text-white d-flex flex-column" style="width: 280px; min-height: 100vh;">
    <!-- Logo Admin -->
    <div class="p-4 border-bottom border-secondary">
        <div class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/images/team/nataswim_app_logo_4.png') }}" 
                 alt="nataswim application pour tous" 
                 class="img-fluid" 
                 style="height: 80px; width: auto; filter: brightness(0) invert(1);">
        </div>
        <div class="text-center mt-3">
            <h5 class="mb-0 fw-bold">Administration</h5>
            <small class="text-light opacity-75">{{ config('app.name') }}</small>
        </div>
    </div>
    
    <!-- Navigation -->
    <div class="flex-fill py-3">
        <div class="px-3 mb-3">
            <small class="text-uppercase text-light opacity-50 fw-semibold">Principal</small>
        </div>
        
        <ul class="nav nav-pills flex-column px-3">
            <li class="nav-item mb-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-water me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        
        <div class="px-3 mb-3 mt-4">
            <small class="text-uppercase text-light opacity-50 fw-semibold">Contenu</small>
        </div>
        
        <ul class="nav nav-pills flex-column px-3">
            <!-- NOUVEAU : Section Medias -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.media.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.media.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-images me-3"></i>
                    <span>Medias</span>
                    @php
                        $mediaCount = App\Models\Media::count();
                    @endphp
                    @if($mediaCount > 0)
                        <span class="badge bg-success ms-auto">{{ $mediaCount }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('admin.posts.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.posts.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-water me-3"></i>
                    <span>Articles</span>
                    <span class="badge bg-info ms-auto">{{ App\Models\Post::count() }}</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.categories.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.categories.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-folder me-3"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.tags.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.tags.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-tags me-3"></i>
                    <span>Tags</span>
                </a>
            </li>
        </ul>
        

<div class="px-3 mb-3 mt-4">
    <small class="text-uppercase text-light opacity-50 fw-semibold">Entraînement</small>
</div>

<ul class="nav nav-pills flex-column px-3">
    <li class="nav-item mb-1">
        <a href="{{ route('admin.training.plans.index') }}" 
           class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.training.plans.*') ? 'active bg-primary' : '' }}">
            <i class="fas fa-calendar-alt me-3"></i>
            <span>Plans</span>
            <span class="badge bg-info ms-auto">{{ App\Models\Plan::count() }}</span>
        </a>
    </li>
    <li class="nav-item mb-1">
        <a href="{{ route('admin.training.cycles.index') }}" 
           class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.training.cycles.*') ? 'active bg-primary' : '' }}">
            <i class="fas fa-sync-alt me-3"></i>
            <span>Cycles</span>
        </a>
    </li>
    <li class="nav-item mb-1">
        <a href="{{ route('admin.training.seances.index') }}" 
           class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.training.seances.*') ? 'active bg-primary' : '' }}">
            <i class="fas fa-dumbbell me-3"></i>
            <span>Séances</span>
        </a>
    </li>
    <li class="nav-item mb-1">
        <a href="{{ route('admin.training.series.index') }}" 
           class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.training.series.*') ? 'active bg-primary' : '' }}">
            <i class="fas fa-list-ol me-3"></i>
            <span>Séries</span>
        </a>
    </li>
    <li class="nav-item mb-1">
        <a href="{{ route('admin.training.exercices.index') }}" 
           class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.training.exercices.*') ? 'active bg-primary' : '' }}">
            <i class="fas fa-running me-3"></i>
            <span>Exercices</span>
        </a>
    </li>
</ul>


        <div class="px-3 mb-3 mt-4">
            <small class="text-uppercase text-light opacity-50 fw-semibold">Utilisateurs</small>
        </div>
        
        <ul class="nav nav-pills flex-column px-3">
            <li class="nav-item mb-1">
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-users me-3"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.roles.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.roles.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-user-shield me-3"></i>
                    <span>Rôles</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.permissions.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-key me-3"></i>
                    <span>Permissions</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.payments.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.permissions.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-key me-3"></i>
                    <span>Paiements</span>
                </a>
            </li>

            <div class="px-3 mb-3 mt-4">
                <small class="text-uppercase text-light opacity-50 fw-semibold">Téléchargements</small>
            </div>

            <ul class="nav nav-pills flex-column px-3">
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.downloadables.index') }}" 
                       class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.downloadables.*') ? 'active bg-primary' : '' }}">
                        <i class="fas fa-water me-3"></i>
                        <span>Fichiers</span>
                        @php
                            $downloadCount = \App\Models\Downloadable::count();
                        @endphp
                        @if($downloadCount > 0)
                            <span class="badge bg-success ms-auto">{{ $downloadCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.download-categories.index') }}" 
                       class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.download-categories.*') ? 'active bg-primary' : '' }}">
                        <i class="fas fa-folder-open me-3"></i>
                        <span>Catégories</span>
                    </a>
                </li>
            </ul>
        </ul>
    </div>
    
    <!-- Footer Sidebar -->
    <div class="p-3 border-top border-secondary">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 35px; height: 35px; font-size: 14px;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-fill">
                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                <small class="text-light opacity-75">Administrateur</small>
            </div>
        </div>
    </div>
</nav>