<nav class="navbar navbar-expand-lg" style="border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;background-color: #f9f5f4 !important;border-bottom: 20px solid #22a696;border-top: 20px solid #22a696;">

    <div class="container-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/images/team/nataswim_app_logo_4.png') }}"
                alt="nataswim"
                style="height: 50px; width: auto;">
        </a>

        <!-- Bouton burger pour mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu principal -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Médias -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.media.*') && !request()->routeIs('admin.media.categories') ? 'active fw-bold text-primary' : '' }}" href="{{ route('admin.media.index') }}">
                        Images
                        @php $mediaCount = App\Models\Media::count(); @endphp
                        @if($mediaCount > 0)
                        <span class="badge bg-success ms-1">{{ $mediaCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- Articles (dropdown) -->
                <li class="nav-item dropdown">
                    @php $articlesActive = request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.tags.*', 'admin.aitext.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $articlesActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        Articles
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                                <i class="fas fa-list fa-fw me-2"></i>Liste
                                <span class="badge bg-info ms-2">{{ App\Models\Post::count() }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.categories.*') && !request()->routeIs('admin.fiches-categories.*') && !request()->routeIs('admin.workout-categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-folder-open fa-fw me-2"></i>Catégories
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                                <i class="fas fa-tags fa-fw me-2"></i>Tags
                            </a>
                        </li>
                        @if(auth()->user()->hasRole('admin'))
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.aitext.*') ? 'active' : '' }}" href="{{ route('admin.aitext.settings') }}">
                                <i class="fas fa-robot fa-fw me-2"></i>AI Text Optimizer
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                <!-- Fiches (dropdown) -->
                <li class="nav-item dropdown">
                    @php $fichesActive = request()->routeIs('admin.fiches.*', 'admin.fiches-categories.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $fichesActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        Fiches
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.fiches.index', 'admin.fiches.create', 'admin.fiches.edit', 'admin.fiches.show') ? 'active' : '' }}" href="{{ route('admin.fiches.index') }}">
                                <i class="fas fa-list-alt fa-fw me-2"></i>Fiches
                                @php $fichesCount = App\Models\Fiche::count(); @endphp
                                @if($fichesCount > 0)
                                <span class="badge bg-success ms-2">{{ $fichesCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.fiches-categories.*') ? 'active' : '' }}" href="{{ route('admin.fiches-categories.index') }}">
                                <i class="fas fa-folder-open fa-fw me-2"></i>Catégories
                                @php $fichesCategoriesCount = App\Models\FichesCategory::count(); @endphp
                                @if($fichesCategoriesCount > 0)
                                <span class="badge bg-info ms-2">{{ $fichesCategoriesCount }}</span>
                                @endif
                            </a>
                        </li>
 <li>
                            <a  class="dropdown-item {{ request()->routeIs('admin.fiches-categories.*') ? 'active' : '' }}" href="{{ route('admin.fiches-sous-categories.index') }}">
                                <i class="fas fa-folder-tree fa-fw me-2"></i>Sous-catégories
                                @php $fichesSousCategoriesCount = App\Models\FichesSousCategory::count(); @endphp
                                @if($fichesSousCategoriesCount > 0)
                                <span class="badge bg-secondary ms-2">{{ $fichesSousCategoriesCount }}</span>
                                @endif
                            </a>
                        </li>


                    </ul>
                </li>

                <!-- Vidéos (dropdown) -->
                <li class="nav-item dropdown">
                    @php $videosActive = request()->routeIs('admin.videos.*', 'admin.video-categories.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $videosActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        Vidéos
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.videos.index', 'admin.videos.create', 'admin.videos.edit', 'admin.videos.show') ? 'active' : '' }}" href="{{ route('admin.videos.index') }}">
                                <i class="fas fa-play-circle fa-fw me-2"></i>Vidéos
                                @php $videosCount = App\Models\Video::count(); @endphp
                                @if($videosCount > 0)
                                <span class="badge bg-danger ms-2">{{ $videosCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.video-categories.*') ? 'active' : '' }}" href="{{ route('admin.video-categories.index') }}">
                                <i class="fas fa-folder-open fa-fw me-2"></i>Catégories
                                @php $videoCategoriesCount = App\Models\VideoCategory::count(); @endphp
                                @if($videoCategoriesCount > 0)
                                <span class="badge bg-info ms-2">{{ $videoCategoriesCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Workouts (dropdown) -->
                <li class="nav-item dropdown">
                    @php $workoutsActive = request()->routeIs('admin.workouts.*', 'admin.workout-categories.*', 'admin.workout-sections.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $workoutsActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Workouts
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.workouts.*') ? 'active' : '' }}" href="{{ route('admin.workouts.index') }}">
                                <i class="fas fa-running fa-fw me-2"></i>Séances
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.workout-categories.*') ? 'active' : '' }}" href="{{ route('admin.workout-categories.index') }}">
                                <i class="fas fa-folder fa-fw me-2"></i>Catégories
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.workout-sections.*') ? 'active' : '' }}" href="{{ route('admin.workout-sections.index') }}">
                                <i class="fas fa-th-large fa-fw me-2"></i>Sections
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Exercices (dropdown) -->
                <li class="nav-item dropdown">
                    @php $exercicesActive = request()->routeIs('admin.training.exercices.*', 'admin.exercice-categories.*', 'admin.exercice-sous-categories.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $exercicesActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
Exercices
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.exercices.*') ? 'active' : '' }}" href="{{ route('admin.training.exercices.index') }}">
                                <i class="fas fa-list fa-fw me-2"></i>Exercices
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.exercice-categories.*') ? 'active' : '' }}" href="{{ route('admin.exercice-categories.index') }}">
                                <i class="fas fa-folder fa-fw me-2"></i>Catégories
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.exercice-sous-categories.*') ? 'active' : '' }}" href="{{ route('admin.exercice-sous-categories.index') }}">
                                <i class="fas fa-folder-tree fa-fw me-2"></i>Sous-catégories
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Planification (dropdown) -->
                <li class="nav-item dropdown">
                    @php $planificationActive = request()->routeIs('admin.training.plans.*', 'admin.training.cycles.*', 'admin.training.seances.*', 'admin.training.series.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $planificationActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Planification
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.plans.*') ? 'active' : '' }}" href="{{ route('admin.training.plans.index') }}">
                                <i class="fas fa-clipboard-list fa-fw me-2"></i>Plans
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.cycles.*') ? 'active' : '' }}" href="{{ route('admin.training.cycles.index') }}">
                                <i class="fas fa-recycle fa-fw me-2"></i>Cycles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.seances.*') ? 'active' : '' }}" href="{{ route('admin.training.seances.index') }}">
                                <i class="fas fa-clock fa-fw me-2"></i>Séances
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.series.*') ? 'active' : '' }}" href="{{ route('admin.training.series.index') }}">
                                <i class="fas fa-layer-group fa-fw me-2"></i>Séries
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Utilisateurs (dropdown) -->
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item dropdown">
                    @php $adminUsersActive = request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.permissions.*', 'admin.payments.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $adminUsersActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Membres
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users fa-fw me-2"></i>Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                                <i class="fas fa-credit-card fa-fw me-2"></i>Paiements
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Accès & Sécurité</h6></li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                                <i class="fas fa-user-shield fa-fw me-2"></i>Rôles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                                <i class="fas fa-key fa-fw me-2"></i>Permissions
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- eBooks (dropdown) -->
                <li class="nav-item dropdown">
                    @php $ebooksActive = request()->routeIs('admin.downloadables.*', 'admin.download-categories.*', 'admin.ebook-files.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $ebooksActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                        eBooks
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.downloadables.*') ? 'active' : '' }}" href="{{ route('admin.downloadables.index') }}">
                                <i class="fas fa-download fa-fw me-2"></i>Téléchargements
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.download-categories.*') ? 'active' : '' }}" href="{{ route('admin.download-categories.index') }}">
                                <i class="fas fa-folder fa-fw me-2"></i>Catégories
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.ebook-files.*') ? 'active' : '' }}" href="{{ route('admin.ebook-files.index') }}">
                                <i class="fas fa-file-archive fa-fw me-2"></i>Fichiers eBook
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Catalogue (dropdown) - VERSION APRÈS CORRECTION WEB.PHP -->
                <li class="nav-item dropdown">
                    @php $catalogueActive = request()->routeIs('admin.catalogue-sections.*', 'admin.catalogue-modules.*', 'admin.catalogue-units.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $catalogueActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                        Formation
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.catalogue-sections.*') ? 'active' : '' }}" href="{{ route('admin.catalogue-sections.index') }}">
                                <i class="fas fa-layer-group fa-fw me-2"></i>Sections
                                @php $sectionsCount = App\Models\CatalogueSection::count(); @endphp
                                @if($sectionsCount > 0)
                                <span class="badge bg-primary ms-2">{{ $sectionsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.catalogue-modules.*') ? 'active' : '' }}" href="{{ route('admin.catalogue-modules.index') }}">
                                <i class="fas fa-book-open fa-fw me-2"></i>Modules
                                @php $modulesCount = App\Models\CatalogueModule::count(); @endphp
                                @if($modulesCount > 0)
                                <span class="badge bg-success ms-2">{{ $modulesCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.catalogue-units.*') ? 'active' : '' }}" href="{{ route('admin.catalogue-units.index') }}">
                                <i class="fas fa-puzzle-piece fa-fw me-2"></i>Unités
                                @php $unitsCount = App\Models\CatalogueUnit::count(); @endphp
                                @if($unitsCount > 0)
                                <span class="badge bg-info ms-2">{{ $unitsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('public.catalogue.index') }}" target="_blank">
                                <i class="fas fa-external-link-alt fa-fw me-2"></i>Voir le catalogue public
                            </a>
                        </li>
                    </ul>
                </li>

                
            </ul>

            <!-- Actions utilisateur (droite) -->
            <div class="d-flex align-items-center gap-2">

                
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm position-relative rounded-circle" 
                            style="width: 36px; height: 36px;" 
                            data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
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
                                <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu utilisateur -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle d-flex align-items-center" 
                            data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 28px; height: 28px; font-size: 12px;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="d-none d-xl-inline">{{ auth()->user()->name }}</span>
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                <i class="fas fa-user me-2"></i>Mon profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-water me-2"></i>Voir le site
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>