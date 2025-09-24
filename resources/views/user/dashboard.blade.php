@extends('layouts.user')

@section('title', 'Mon tableau de bord')

@section('content')
<div class="container-lg py-5">
    <!-- En-tête utilisateur -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-primary text-white p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-4" 
                                         style="width: 80px; height: 80px; font-size: 2rem;">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h2 class="mb-2">
                                            Bonjour, {{ auth()->user()->first_name ?: auth()->user()->name }} !
                                        </h2>
                                        <p class="mb-0 opacity-90">
                                            Bienvenue sur votre espace personnel
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div class="text-white opacity-90">
                                    <div class="mb-1">Membre depuis</div>
                                    <div class="fw-semibold">{{ auth()->user()->created_at->format('F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Notification pour les visiteurs -->
    @if(auth()->user()->hasRole('visitor'))
        <div class="row mb-4">
            <div class="col-12">
                @php
                    $completedPayment = auth()->user()->payments()->where('status', 'completed')->where('admin_status', 'pending')->first();
                @endphp
                
                @if($completedPayment)
                    <div class="alert alert-warning border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-clock text-warning fa-lg"></i>
                            </div>
                            <div class="flex-fill">
                                <h5 class="alert-heading mb-2">
                                    <i class="fas fa-hourglass-half"></i> Paiement en attente de validation
                                </h5>
                                <p class="mb-2">
                                    Votre paiement de <strong>{{ $completedPayment->formatted_price }}</strong> pour 
                                    <strong>{{ $completedPayment->plan_name }}</strong> a été reçu avec succès.
                                </p>
                                <p class="mb-0 small text-muted">
                                    Un administrateur validera votre accès premium prochainement. 
                                    Vous recevrez une notification dès l'activation.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-crown text-info fa-lg"></i>
                            </div>
                            <div class="flex-fill">
                                <h5 class="alert-heading mb-2">
                                    <i class="fas fa-lock"></i> Accès limité - Compte Visiteur
                                </h5>
                                <p class="mb-3">
                                    Votre compte vous donne accès au contenu public uniquement. 
                                    Pour débloquer tous les articles et contenus premium, passez à un compte utilisateur.
                                </p>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('payments.index') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-up me-2"></i>Passer Premium
                                    </a>
                                    <a href="{{ route('payments.history') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-history me-2"></i>Mes paiements
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Notification pour les utilisateurs premium -->
    @if(auth()->user()->hasRole('user'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px;">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                        <div class="flex-fill">
                            <h5 class="alert-heading mb-2">
                                <i class="fas fa-crown"></i> Compte Premium Actif
                            </h5>
                            <p class="mb-0">
                                Félicitations ! Vous avez accès à tous les contenus premium de la plateforme.
                                Profitez pleinement de votre expérience utilisateur.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif





    <!-- Statistiques utilisateur -->
    <div class="row g-4 mb-5">
        @php
            $userStats = [
                [
                    'title' => 'Connexions',
                    'value' => auth()->user()->login_count ?? 0,
                    'icon' => 'fas fa-sign-in-alt',
                    'color' => 'primary',
                    'description' => 'Nombre de connexions'
                ],
                [
                    'title' => 'Articles lus',
                    'value' => '0', // À implémenter selon vos besoins
                    'icon' => 'fas fa-book-reader',
                    'color' => 'info',
                    'description' => 'Articles consultés'
                ],
                [
                    'title' => 'Jours actif',
                    'value' => auth()->user()->created_at->diffInDays(now()),
                    'icon' => 'fas fa-calendar-check',
                    'color' => 'success',
                    'description' => 'Depuis l\'inscription'
                ]
            ];
        @endphp
        
        @foreach($userStats as $stat)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-{{ $stat['color'] }} bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="{{ $stat['icon'] }} text-{{ $stat['color'] }} fa-lg"></i>
                        </div>
                        <h3 class="fw-bold mb-2">{{ number_format($stat['value']) }}</h3>
                        <p class="text-muted mb-0">{{ $stat['description'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <!-- Articles récents -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Articles récents</h5>
                        <a href="{{ route('public.index') }}" class="btn btn-sm btn-outline-primary">
                            Voir tous les articles
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php
                        $recentArticles = App\Models\Post::where('status', 'published')
                            ->whereNotNull('published_at')
                            ->orderBy('published_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @forelse($recentArticles as $article)
                        <div class="d-flex align-items-center p-4 {{ !$loop->last ? 'border-bottom' : '' }} hover-bg-light">
                            <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                @if($article->image)
                                    <img src="{{ $article->image }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                @else
                                    <i class="fas fa-file-alt text-primary"></i>
                                @endif
                            </div>
                            <div class="flex-fill">
                                <h6 class="mb-1">
                                    <a href="{{ route('public.show', $article) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($article->name, 60) }}
                                    </a>
                                </h6>
                                <div class="d-flex align-items-center text-muted">
                                    <span class="badge bg-primary-subtle text-primary me-2">
                                        {{ $article->category->name ?? 'Non catégorisé' }}
                                    </span>
                                    <small>{{ $article->published_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ $article->hits }}
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-muted">
                            <i class="fas fa-newspaper fa-3x mb-3 opacity-50"></i>
                            <div>Aucun article publié récemment</div>
                            <small>Revenez bientôt pour découvrir nos nouveaux contenus</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Profil et actions -->
        <div class="col-lg-4">
            <!-- Profil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0">Mon profil</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                        @if(auth()->user()->role)
                            <div class="mt-2">
                                <span class="badge bg-info-subtle text-info">
                                    {{ auth()->user()->role->display_name }}
                                </span>
                            </div>
                        @endif
                    </div>

                    @if(auth()->user()->bio)
                        <div class="mb-3">
                            <small class="text-muted">{{ Str::limit(auth()->user()->bio, 100) }}</small>
                        </div>
                    @endif

                    <div class="d-grid">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Modifier mon profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('public.index') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-newspaper me-2"></i>
                            <div>
                                <div class="fw-semibold">Parcourir les articles</div>
                                <small class="opacity-75">Découvrir les derniers contenus</small>
                            </div>
                        </a>
                        

                        @if(auth()->user()->hasRole('visitor'))
                            <a href="{{ route('payments.index') }}" class="btn btn-outline-warning text-start">
                                <i class="fas fa-crown me-2"></i>
                                <div>
                                    <div class="fw-semibold">Passer Premium</div>
                                    <small class="opacity-75">Débloquer tous les contenus</small>
                                </div>
                            </a>
                        @endif

                        <a href="{{ route('payments.history') }}" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-credit-card me-2"></i>
                            <div>
                                <div class="fw-semibold">Mes paiements</div>
                                <small class="opacity-75">Historique des transactions</small>
                            </div>
                        </a>

                        
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger text-start">
                                <i class="fas fa-cog me-2"></i>
                                <div>
                                    <div class="fw-semibold">Administration</div>
                                    <small class="opacity-75">Gérer la plateforme</small>
                                </div>
                            </a>
                        @endif
                        
                        <a href="{{ route('contact') }}" class="btn btn-outline-info text-start">
                            <i class="fas fa-envelope me-2"></i>
                            <div>
                                <div class="fw-semibold">Nous contacter</div>
                                <small class="opacity-75">Une question ? Écrivez-nous</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-bg-light:hover {
    background-color: var(--bs-light) !important;
}
</style>
@endpush