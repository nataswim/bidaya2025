<nav class="sidebar bg-dark text-white d-flex flex-column" style="width: 280px; min-height: 100vh;">
    <!-- Logo Admin -->
    <div class="p-4 border-bottom border-secondary">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 45px; height: 45px;">
                <i class="fas fa-cog text-white"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">Administration</h5>
                <small class="text-light opacity-75">{{ config('app.name') }}</small>
            </div>
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
                    <i class="fas fa-tachometer-alt me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        
        <div class="px-3 mb-3 mt-4">
            <small class="text-uppercase text-light opacity-50 fw-semibold">Contenu</small>
        </div>
        
        <ul class="nav nav-pills flex-column px-3">
            <!-- NOUVEAU : Section Médias -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.media.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.media.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-images me-3"></i>
                    <span>Médias</span>
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
                    <i class="fas fa-newspaper me-3"></i>
                    <span>Articles</span>
                    <span class="badge bg-info ms-auto">{{ App\Models\Post::count() }}</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.categories.index') }}" 
                   class="nav-link text-white d-flex align-items-center rounded {{ request()->routeIs('admin.categories.*') ? 'active bg-primary' : '' }}">
                    <i class="fas fa-folder me-3"></i>
                    <span>Catégories</span>
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