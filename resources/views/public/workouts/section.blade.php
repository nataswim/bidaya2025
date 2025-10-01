@extends('layouts.public')

@section('title', $section->name . ' - Workouts')
@section('meta_description', $section->description ?? 'Découvrez tous les workouts de la section ' . $section->name)

@section('content')
<!-- Section titre avec breadcrumb -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white bg-opacity-10 rounded px-3 py-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.index') }}" class="text-white">
                        <i class="fas fa-home me-1"></i>Workouts
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $section->name }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-12">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-layer-group me-3"></i>{{ $section->name }}
                </h1>
                
                @if($section->description)
                    <p class="lead mb-0">{{ $section->description }}</p>
                @endif
                
                <div class="d-flex align-items-center gap-3 mt-4">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-folder me-1"></i>{{ $categories->count() }} catégorie(s)
                    </span>
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-dumbbell me-1"></i>{{ $categories->sum('workouts_count') }} workout(s)
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Liste des catégories -->
<section class="py-5 bg-light">
    <div class="container">
        @if($categories->count() > 0)
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-lg hover-lift">
                            <div class="card-header bg-gradient-info text-white p-3">
                                <h5 class="mb-1">
                                    <i class="fas fa-folder me-2"></i>{{ $category->name }}
                                </h5>
                                <small class="opacity-75">{{ $category->workouts_count }} workout(s)</small>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                @if($category->description)
                                    <p class="card-text text-muted flex-grow-1">
                                        {!! Str::limit($category->description, 120) !!}
                                    </p>
                                @endif
                                
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                    <a href="{{ route('public.workouts.category', [$section, $category]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Voir les workouts <i class="fas fa-arrow-right ms-1"></i>
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
                    <h5 class="text-muted mb-3">Aucune catégorie disponible dans cette section</h5>
                    <a href="{{ route('public.workouts.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux sections
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
                <i class="fas fa-th me-2"></i>Toutes les sections
            </a>
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