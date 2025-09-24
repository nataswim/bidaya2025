@extends('layouts.public')

@section('title', 'Ã propos')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Ã propos de nous</h1>
                <p class="lead mb-0">
                    DÃ©couvrez notre mission, notre Ã©quipe et notre passion pour le dÃ©veloppement web et les technologies modernes.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 200px; height: 200px;">
                    <i class="fas fa-users" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-4">Notre Mission</h2>
                <p class="lead text-muted mb-5">
                    Nous nous engageons Ã partager nos connaissances en dÃ©veloppement web et Ã crÃ©er une communautÃ© 
                    d'apprentissage où dÃ©veloppeurs dÃ©butants et expÃ©rimentÃ©s peuvent grandir ensemble.
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            @php
                $values = [
                    [
                        'icon' => 'fas fa-lightbulb',
                        'title' => 'Innovation',
                        'description' => 'Nous explorons constamment les nouvelles technologies et partageons nos dÃ©couvertes avec la communautÃ©.',
                        'color' => 'warning'
                    ],
                    [
                        'icon' => 'fas fa-graduation-cap',
                        'title' => 'PÃ©dagogie',
                        'description' => 'Nous croyons en une approche pÃ©dagogique claire et accessible pour tous les niveaux de compÃ©tence.',
                        'color' => 'success'
                    ],
                    [
                        'icon' => 'fas fa-handshake',
                        'title' => 'CommunautÃ©',
                        'description' => 'Nous favorisons les Ã©changes et l\'entraide entre dÃ©veloppeurs de tous horizons et expÃ©riences.',
                        'color' => 'info'
                    ]
                ];
            @endphp
            
            @foreach($values as $value)
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100 text-center">
                        <div class="card-body p-5">
                            <div class="bg-{{ $value['color'] }} bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                                 style="width: 80px; height: 80px;">
                                <i class="{{ $value['icon'] }} text-{{ $value['color'] }} fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $value['title'] }}</h4>
                            <p class="text-muted">{{ $value['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Histoire -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-6 fw-bold mb-4">Notre Histoire</h2>
                <p class="text-muted mb-4">
                    FondÃ© en 2025, {{ config('app.name') }} est nÃ© de la passion de dÃ©veloppeurs expÃ©rimentÃ©s 
                    souhaitant partager leurs connaissances avec la communautÃ©. Ce qui a commencÃ© comme un simple 
                    blog personnel s'est transformÃ© en une plateforme d'apprentissage reconnue.
                </p>
                <p class="text-muted mb-4">
                    Aujourd'hui, nous publions rÃ©guliÃ¨rement des tutoriels, des analyses techniques et des 
                    retours d'expÃ©rience pour aider les dÃ©veloppeurs Ã progresser dans leur carriÃ¨re et 
                    rester Ã jour avec les Ã©volutions technologiques.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('public.index') }}" class="btn btn-primary">
                        Nos articles
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                        Nous contacter
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <h3 class="fw-bold text-primary mb-2">{{ App\Models\Post::count() }}+</h3>
                            <small class="text-muted">Articles publiÃ©s</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <h3 class="fw-bold text-success mb-2">{{ App\Models\User::count() }}+</h3>
                            <small class="text-muted">Membres actifs</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <h3 class="fw-bold text-warning mb-2">{{ App\Models\Post::sum('hits') }}+</h3>
                            <small class="text-muted">Vues totales</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <h3 class="fw-bold text-info mb-2">{{ App\Models\Category::count() }}+</h3>
                            <small class="text-muted">CatÃ©gories</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="display-6 fw-bold mb-4">Rejoignez-nous dÃ¨s aujourd'hui</h2>
                <p class="lead mb-4">
                    Faites partie de notre communautÃ© grandissante de dÃ©veloppeurs passionnÃ©s.
                </p>
                @guest
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            CrÃ©er un compte
                        </a>
                        <a href="{{ route('public.index') }}" class="btn btn-outline-light btn-lg">
                            DÃ©couvrir nos articles
                        </a>
                    </div>
                @else
                    <div class="alert alert-light d-inline-block">
                        Merci de faire partie de notre communautÃ©, {{ auth()->user()->name }} !
                    </div>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection