@extends('layouts.public')

@section('title', 'Séances d\'Entraînement ' . $section->name)
@section('meta_description', $section->description ?? 'Découvrez tous les programmes d\'entraînement ' . $section->name . ' : séances structurées par niveau, du débutant au confirmé.')
@section('meta_keywords', 'entraînement ' . strtolower($section->name) . ', séances ' . strtolower($section->name) . ', programme ' . strtolower($section->name) . ', plan entraînement')

@section('content')




<section class="py-5 bg-primary text-white text-center" style="background: linear-gradient( 58deg, #4897ce 0%, #004e67 100%);border-top: 20px solid #FFD700;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
                     {{ $section->name }}
                </h1>
                
                @if($section->description)
                    <p class="lead mb-0">{{ $section->description }}</p>
                @else
                    <p class="lead mb-0">
                         {{ $section->name }} 
                    </p>
                @endif
                
                <div class="d-flex align-items-center gap-3 mt-4">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-folder me-1"></i>{{ $categories->count() }} programme(s)
                    </span>
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-running me-1"></i>{{ $categories->sum('workouts_count') }} séance(s)
                    </span>
                </div>
            </div>
        </div>
        
    </div>
</section>





<!-- Liste des programmes -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-primary rounded px-3 py-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.index') }}" class="text-white">
                        <i class="fas fa-home me-1"></i>Séances d'Entraînement
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $section->name }}
                </li>
            </ol>
        </nav>

        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">
                <i class="fas fa-folder-open me-2 text-primary"></i>
                {{ $section->name }}
            </h2>

        </div>

        @if($categories->count() > 0)
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-lg hover-lift">
                            <div class="card-header bg-primary text-white p-3">
                                <h3 class="mb-1 h5">
                                    <i class="fas fa-folder me-2"></i>{{ $category->name }}
                                </h3>
                                <small class="opacity-75">{{ $category->workouts_count }} modéles</small>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                @if($category->description)
                                    <p class="card-text text-muted flex-grow-1">
                                        {!! Str::limit($category->description, 120) !!}
                                    </p>
                                @else
                                    <p class="card-text text-muted flex-grow-1">
                                         {{ $category->name }} avec {{ $category->workouts_count }} pages.
                                    </p>
                                @endif
                                
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                    <a href="{{ route('public.workouts.category', [$section, $category]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Voir les pages <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                    <span class="badge bg-primary">{{ $category->workouts_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-folder fa-3x text-muted mb-3 opacity-25"></i>
                    <h3 class="text-muted mb-3 h5">Aucun programme disponible dans cette discipline</h3>
                    <p class="text-muted">Les programmes d'entraînement seront bientôt ajoutés</p>
                    <a href="{{ route('public.workouts.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
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
            <a href="{{ route('public.workouts.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-th me-2"></i>Toutes les categories
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
                        <h2 class="h4 fw-bold mb-3"> {{ $section->name }}</h2>
                        <p class="text-muted">
                            Nos <strong>programmes  {{ $section->name }}</strong> sont structurés 
                            pour vous faire progresser efficacement. Chaque <strong>séance d'entraînement</strong> 
                            est conçue avec des objectifs précis et une progression logique adaptée à votre niveau.
                        </p>
                        <p class="text-muted mb-0">
                            Que vous soyez <strong>débutant</strong> ou <strong>confirmé</strong>, 
                            nos <strong>plans d'entraînement {{ $section->name }}</strong> vous accompagnent 
                            vers l'atteinte de vos objectifs sportifs.
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

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}
</style>
@endpush