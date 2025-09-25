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
                    Decouvrez notre mission, notre equipe et notre passion pour le developpement web et les technologies modernes.
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
                    Nous nous engageons Ã partager nos connaissances en developpement web et Ã creer une communaute 
                    d'apprentissage où developpeurs debutants et experimentes peuvent grandir ensemble.
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            @php
                $values = [
                    [
                        'icon' => 'fas fa-lightbulb',
                        'title' => 'Innovation',
                        'description' => 'Nous explorons constamment les nouvelles technologies et partageons nos decouvertes avec la communaute.',
                        'color' => 'warning'
                    ],
                    [
                        'icon' => 'fas fa-graduation-cap',
                        'title' => 'Pedagogie',
                        'description' => 'Nous croyons en une approche pedagogique claire et accessible pour tous les niveaux de competence.',
                        'color' => 'success'
                    ],
                    [
                        'icon' => 'fas fa-handshake',
                        'title' => 'Communaute',
                        'description' => 'Nous favorisons les echanges et l\'entraide entre developpeurs de tous horizons et experiences.',
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
                    Fonde en 2025, {{ config('app.name') }} est ne de la passion de developpeurs experimentes 
                    souhaitant partager leurs connaissances avec la communaute. Ce qui a commence comme un simple 
                    blog personnel s'est transforme en une plateforme d'apprentissage reconnue.
                </p>
                <p class="text-muted mb-4">
                    Aujourd'hui, nous publions regulierement des tutoriels, des analyses techniques et des 
                    retours d'experience pour aider les developpeurs Ã progresser dans leur carriere et 
                    rester Ã jour avec les evolutions technologiques.
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
                            <small class="text-muted">Articles publies</small>
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
                            <small class="text-muted">Categories</small>
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
                <h2 class="display-6 fw-bold mb-4">Rejoignez-nous des aujourd'hui</h2>
                <p class="lead mb-4">
                    Faites partie de notre communaute grandissante de developpeurs passionnes.
                </p>
                @guest
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            Creer un compte
                        </a>
                        <a href="{{ route('public.index') }}" class="btn btn-outline-light btn-lg">
                            Decouvrir nos articles
                        </a>
                    </div>
                @else
                    <div class="alert alert-light d-inline-block">
                        Merci de faire partie de notre communaute, {{ auth()->user()->name }} !
                    </div>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection