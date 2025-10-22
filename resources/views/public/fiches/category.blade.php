@extends('layouts.public')

@section('title', $category->name . ' - Fiches Pratiques')
@section('meta_description', $category->description ?? 'Découvrez toutes les fiches pratiques de la catégorie ' . $category->name)

@section('content')
<!-- Section titre avec breadcrumb -->
<section class="text-white py-5" style="background-color: #007dab;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-top: 20px solid #04adb9;border-bottom: 20px solid #04adb9;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                 {{ $category->name }}
                </h1>
                
                @if($category->description)
                    <p class="lead mb-0">{{ $category->description }}</p>
                @endif
                
                <div class="d-flex align-items-center gap-3 mt-4">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-file-alt me-1"></i>{{ $fiches->total() }} fiche(s)
                    </span>
                </div>
            </div>
            
            @if($category->image)
                <div class="col-lg-4 text-center mt-4 mt-lg-0">
                    <img src="{{ $category->image }}" 
                         alt="{{ $category->name }}" 
                         class="img-fluid rounded shadow-lg"
                         style="max-height: 250px; object-fit: cover;">
                </div>
            @endif
        </div>
    </div>
    
</section>

<!-- Sous-catégories disponibles -->
@if(isset($sousCategories) && $sousCategories->count() > 0)
<section class="py-4">
    <div class="container">
        <div class="row g-3">
            @foreach($sousCategories as $sousCategory)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('public.fiches.sous-category', [$category, $sousCategory]) }}" 
                       class="text-decoration-none">
                        <div class="card h-100 border shadow-sm hover-lift">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    @if($sousCategory->image)
                                        <img src="{{ $sousCategory->image }}" 
                                             class="rounded me-3" 
                                             style="width: 50px; height: 50px; object-fit: cover;"
                                             alt="{{ $sousCategory->name }}">
                                    @else
                                        <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-layer-group text-info"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $sousCategory->name }}</h6>
                                        <small class="text-muted">
                                            {{ $sousCategory->published_fiches_count }} fiche(s)
                                        </small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <hr class="my-4">
    </div>
</section>
@endif


<!-- Liste des fiches -->
<section class="py-5 bg-light">
    <div class="container">
               <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-primary px-3 py-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.fiches.index') }}" class="text-white">
                        <i class="fas fa-home me-1"></i>Fiches
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $category->name }}
                </li>
            </ol>
        </nav>

        @if($fiches->count() > 0)
            <div class="row g-4">
                @foreach($fiches as $fiche)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-lg hover-lift">
                            @if($fiche->image)
                                <img src="{{ $fiche->image }}" 
                                     class="card-img-top" 
                                     style="height: 220px; object-fit: cover;"
                                     alt="{{ $fiche->title }}">
                            @else
                                <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" 
                                     style="height: 220px;">
                                    <i class="fas fa-file-alt fa-4x text-white opacity-50"></i>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @if($fiche->is_featured)
                                        <span class="badge bg-warning">
                                            <i class="fas fa-star me-1"></i>En vedette
                                        </span>
                                    @endif
                                    @if($fiche->visibility === 'authenticated')
                                        <span class="badge bg-info">
                                            <i class="fas fa-lock me-1"></i>Membres
                                        </span>
                                    @endif
                                </div>
                                
                                <h5 class="card-title mb-3">{{ $fiche->title }}</h5>
                                
                                <p class="card-text text-muted flex-grow-1">
                                    {!! Str::limit(strip_tags($fiche->short_description), 120) !!}
                                </p>
                                
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i>{{ number_format($fiche->views_count) }} vues
                                    </small>
                                    <a href="{{ route('public.fiches.show', [$category, $fiche]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Lire <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($fiches->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $fiches->links() }}
                </div>
            @endif
        @else
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3 opacity-25"></i>
                    <h5 class="text-muted mb-3">Aucune fiche disponible dans cette catégorie</h5>
                    <a href="{{ route('public.fiches.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux catégories
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
            <a href="{{ route('public.fiches.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-th me-2"></i>Toutes les catégories
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

.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}
</style>
@endpush