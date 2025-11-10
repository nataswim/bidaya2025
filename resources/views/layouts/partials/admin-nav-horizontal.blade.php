<nav class="navbar navbar-expand-lg sticky-top" style="border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;background-color: #f9f5f4 !important;border-bottom: 20px solid #0a7283;border-top: 20px solid #087383;">

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
                        <i class="fas fa-images me-1"></i>
                        Médias
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
                        <i class="fas fa-newspaper me-1"></i>
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
                        <i class="fas fa-file-alt me-1"></i>
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
                    </ul>
                </li>

                <!-- Vidéos (dropdown) -->
                <li class="nav-item dropdown">
                    @php $videosActive = request()->routeIs('admin.videos.*', 'admin.video-categories.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $videosActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-video me-1"></i>
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
                        <i class="fas fa-dumbbell me-1"></i>
                        Workouts
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.workouts.index', 'admin.workouts.create', 'admin.workouts.edit', 'admin.workouts.show') ? 'active' : '' }}" href="{{ route('admin.workouts.index') }}">
                                <i class="fas fa-running fa-fw me-2"></i>Workouts
                                @php $workoutsCount = App\Models\Workout::count(); @endphp
                                @if($workoutsCount > 0)
                                <span class="badge bg-warning ms-2">{{ $workoutsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.workout-categories.*') ? 'active' : '' }}" href="{{ route('admin.workout-categories.index') }}">
                                <i class="fas fa-folder fa-fw me-2"></i>Catégories
                                @php $workoutCategoriesCount = App\Models\WorkoutCategory::count(); @endphp
                                @if($workoutCategoriesCount > 0)
                                <span class="badge bg-info ms-2">{{ $workoutCategoriesCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.workout-sections.*') ? 'active' : '' }}" href="{{ route('admin.workout-sections.index') }}">
                                <i class="fas fa-layer-group fa-fw me-2"></i>Sections
                                @php $workoutSectionsCount = App\Models\WorkoutSection::count(); @endphp
                                @if($workoutSectionsCount > 0)
                                <span class="badge bg-secondary ms-2">{{ $workoutSectionsCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Musculation (dropdown) -->
                <li class="nav-item dropdown">
                    @php $trainingActive = request()->routeIs('admin.training.*', 'admin.exercice-categories.*', 'admin.exercice-sous-categories.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $trainingActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-dumbbell me-1"></i>
                        Musculation
                    </a>
                    <ul class="dropdown-menu">
                        <li><h6 class="dropdown-header">Gestion</h6></li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.plans.*') ? 'active' : '' }}" href="{{ route('admin.training.plans.index') }}">
                                <i class="fas fa-file-invoice fa-fw me-2"></i>Plans
                                <span class="badge bg-info ms-2">{{ App\Models\Plan::count() }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.cycles.*') ? 'active' : '' }}" href="{{ route('admin.training.cycles.index') }}">
                                <i class="fas fa-sync-alt fa-fw me-2"></i>Cycles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.seances.*') ? 'active' : '' }}" href="{{ route('admin.training.seances.index') }}">
                                <i class="fas fa-stopwatch fa-fw me-2"></i>Séances
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.series.*') ? 'active' : '' }}" href="{{ route('admin.training.series.index') }}">
                                <i class="fas fa-list-ol fa-fw me-2"></i>Séries
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.training.exercices.*') ? 'active' : '' }}" href="{{ route('admin.training.exercices.index') }}">
                                <i class="fas fa-running fa-fw me-2"></i>Exercices
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.exercice-categories.*') ? 'active' : '' }}" href="{{ route('admin.exercice-categories.index') }}">
                                <i class="fas fa-folder fa-fw me-2"></i>Catégories
                                @php $exerciceCategoriesCount = App\Models\ExerciceCategory::count(); @endphp
                                @if($exerciceCategoriesCount > 0)
                                <span class="badge bg-info ms-2">{{ $exerciceCategoriesCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.exercice-sous-categories.*') ? 'active' : '' }}" href="{{ route('admin.exercice-sous-categories.index') }}">
                                <i class="fas fa-layer-group fa-fw me-2"></i>Sous-catégories
                                @php $exerciceSousCategoriesCount = App\Models\ExerciceSousCategory::count(); @endphp
                                @if($exerciceSousCategoriesCount > 0)
                                <span class="badge bg-secondary ms-2">{{ $exerciceSousCategoriesCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Utilisateurs (dropdown) -->
                <li class="nav-item dropdown">
                    @php $adminUsersActive = request()->routeIs('admin.users.*', 'admin.payments.*', 'admin.roles.*', 'admin.permissions.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $adminUsersActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-cog me-1"></i>
                        Utilisateurs
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

                <!-- eBooks (dropdown) -->
                <li class="nav-item dropdown">
                    @php $ebooksActive = request()->routeIs('admin.downloadables.*', 'admin.download-categories.*', 'admin.ebook-files.*'); @endphp
                    <a class="nav-link dropdown-toggle {{ $ebooksActive ? 'active fw-bold text-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-book me-1"></i>
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