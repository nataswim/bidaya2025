@extends('layouts.public')

@section('title', 'Programme ' . $category->name . ' - Entraînement ' . $section->name)
@section('meta_description', $category->description ?? 'Découvrez toutes les séances du programme ' . $category->name . ' pour votre entraînement ' . $section->name . '. Séances progressives et détaillées.')
@section('meta_keywords', 'programme ' . strtolower($category->name) . ', séances ' . strtolower($section->name) . ', entraînement ' . strtolower($category->name))

@section('content')
<!-- Section titre  -->


<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
                     {{ $category->name }}
                </h1>
                
                @if($category->description)
                    <p class="lead mb-0">{{ $category->description }}</p>
                @else
                    <p class="lead mb-0">
                        {{ $category->name }} pour {{ $section->name }}
                    </p>
                @endif
                
                <div class="d-flex align-items-center gap-3 mt-4">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-layer-group me-1"></i>{{ $section->name }}
                    </span>
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-running me-1"></i>{{ $workouts->count() }} séance(s)
                    </span>
                </div>
            </div>
        </div>
        
    </div>
</section>






<!-- Liste des séances -->
<section class="py-5 bg-light">
    <div class="container">
                <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-primary rounded px-3 py-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.index') }}" class="text-white">
                        <i class="fas fa-home me-1"></i>Séances
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.section', $section) }}" class="text-white">
                        {{ $section->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $category->name }}
                </li>
            </ol>
        </nav>



        @if($workouts->count() > 0)
            <div class="row g-4">
                @foreach($workouts as $workout)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-lg hover-lift">
                            <div class="card-header text-white p-3" style=" background: #0f6b9b;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="badge bg-light text-dark">
                                        Séance #{{ $workout->pivot->order_number }}
                                    </span>
                                    <span class="badge bg-light text-dark">
                                        {{ $workout->formatted_total }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title mb-3 h5">{{ $workout->title }}</h3>
                                
                                <p class="card-text text-muted flex-grow-1">
                                    {!! Str::limit(strip_tags($workout->short_description), 120) !!}
                                </p>
                                
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                    <a href="{{ route('public.workouts.show', [$section, $category, $workout]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Voir  <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-running fa-3x text-muted mb-3 opacity-25"></i>
                    <h3 class="text-muted mb-3 h5">Aucune séance disponible dans ce programme</h3>
                    <p class="text-muted">Les séances d'entraînement seront bientôt ajoutées</p>
                    <a href="{{ route('public.workouts.section', $section) }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à {{ $section->name }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Navigation rapide -->
<section class="py-4 bg-white border-top">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('public.workouts.section', $section) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Retour à {{ $section->name }}
            </a>
            <a href="{{ route('public.workouts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-th me-2"></i>Toutes les disciplines
            </a>
        </div>
    </div>
</section>

<!-- Section SEO -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">À propos du programme {{ $category->name }}</h2>
                        <p class="text-muted">
                            Le <strong>programme d'entraînement {{ $category->name }}</strong> comprend 
                            {{ $workouts->count() }} <strong>séance(s) d'entraînement {{ $section->name }}</strong> 
                            structurée(s) pour vous faire progresser efficacement.
                        </p>
                        <p class="text-muted mb-0">
                            Chaque <strong>séance</strong> est numérotée et doit être réalisée dans l'ordre 
                            pour garantir une progression optimale et éviter les blessures.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}
</style>
@endpush