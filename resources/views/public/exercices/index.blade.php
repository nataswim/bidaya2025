@extends('layouts.public')

@section('title', 'Exercices d\'Entraînement - Bibliothèque Complète')
@section('meta_description', 'Découvrez notre bibliothèque complète d\'exercices d\'entraînement pour tous niveaux. Cardio, force, flexibilité et équilibre avec instructions détaillées.')

@section('content')

<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center" style="background: #353839;border-top: 20px solid #FF8800;border-left: 20px solid #04adb9;border-right: 20px solid #04adb9;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">     <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Exercices Zone</h1>
                <p class="lead mb-0">
                    Découvrez notre bibliothèque d'exercices pour tous niveaux, avec instructions détaillées et conseils de sécurité
                </p>
            </div>
            <div class="col-lg-5 text-center">
                <a href="{{ route('contact') }}">
                    <img src="{{ asset('assets/images/team/nataswim-sport-net-systemes-6.jpg') }}"
                        alt="Guide Nataswim"
                        class="img-fluid rounded-4"
                        style="max-height: 300px; object-fit: cover;">
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Navigation par Catégories -->
@if(isset($categories) && $categories->count() > 0)
<section class="py-5 bg-light">
    <div class="container">

        <!-- Catégories d'exercices -->
        <div class="row g-4 mb-5">
            @foreach($categories as $category)
                <div class="col-lg-6">
                    <a href="{{ route('exercices.category', $category) }}" 
                       class="text-decoration-none">
                        <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                            <div class="card-header {{ $loop->index % 4 == 0 ? 'bg-primary' : ($loop->index % 4 == 1 ? 'bg-success' : ($loop->index % 4 == 2 ? 'bg-info' : 'bg-warning')) }} text-white">
                                <div class="d-flex align-items-center">
                                    @if($category->image)
                                        <img src="{{ $category->image }}" 
                                             class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;"
                                             alt="{{ $category->name }}">
                                    @else
                                        <i class="fas fa-dumbbell me-3" style="font-size: 2.5rem;"></i>
                                    @endif
                                    <div>
                                        <h4 class="mb-1">{{ $category->name }}</h4>
                                        <p class="mb-0 opacity-75">{{ $category->exercices_count ?? 0 }} exercice(s)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @if($category->description)
                                    <p class="card-text text-muted mb-3">
                                        {!! Str::limit(strip_tags($category->description), 150) !!}
                                    </p>
                                @else
                                    <p class="card-text text-muted mb-3">
                                        Découvrez nos exercices dans la catégorie {{ $category->name }}.
                                    </p>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold">Découvrir les exercices →</span>
                                    <span class="badge bg-primary fs-6">
                                        {{ $category->exercices_count ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Filtres et recherche -->
<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md">
                        <label class="fw-bold mb-2"><i class="fas fa-search text-primary me-2"></i>Recherche</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="form-control form-control-lg border-primary"
                               placeholder="Nom de l'exercice...">
                    </div>
                   
                    <div class="col-md">
                        <label class="fw-bold mb-2">&nbsp;</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                        </div>
                    </div>
                </form>

                @if(request()->hasAny(['search']))
                    <div class="text-center mt-3">
                        <a href="{{ route('exercices.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Réinitialiser
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Liste des exercices -->
<section class="py-5">
    <div class="container">
        @if($exercices->count() > 0)
            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="fw-bold mb-0">
                            <i class="fas fa-running text-primary me-2"></i>
                            {{ $exercices->total() }} Exercices Trouvés
                        </h2>
                        @if(request()->hasAny(['search']))
                            <span class="badge bg-info fs-6">Filtres appliqués</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grille des exercices -->
            <div class="row g-4">
                @foreach($exercices as $exercice)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100 hover-lift">
                            @if($exercice->image)
                                <img src="{{ $exercice->image }}" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover;" 
                                     alt="{{ $exercice->titre }}">
                            @else
                                <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                     style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <i class="fas fa-running fa-3x text-muted opacity-25"></i>
                                </div>
                            @endif
                            
                            <div class="card-body p-4 d-flex flex-column">
                                <!-- Badges catégories -->
@if($exercice->categories->isNotEmpty() || $exercice->sousCategories->isNotEmpty())
    <div class="d-flex flex-wrap gap-2 mb-3">
        @foreach($exercice->categories as $cat)
            <span class="badge bg-primary">
                <i class="fas fa-folder me-1"></i>{{ $cat->name }}
            </span>
        @endforeach
        @foreach($exercice->sousCategories as $sousCat)
            <span class="badge bg-info">
                <i class="fas fa-layer-group me-1"></i>{{ $sousCat->name }}
            </span>
        @endforeach
    </div>
@endif

                                <h5 class="card-title fw-bold mb-2">{{ $exercice->titre }}</h5>
                                
                                @if($exercice->description)
                                    <p class="card-text text-muted small flex-fill">
                                        {!! Str::limit(strip_tags($exercice->description), 100) !!}
                                    </p>
                                @endif
                                
                                <div class="mt-auto">
                                    <a href="{{ route('exercices.show', $exercice) }}" 
                                       class="btn btn-outline-primary w-100 fw-bold">
                                        <i class="fas fa-eye me-2"></i>Voir l'exercice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($exercices->hasPages())
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="mt-5 d-flex justify-content-center">
                            {{ $exercices->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Aucun résultat -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-running fa-4x text-muted mb-4 opacity-25"></i>
                    <h4 class="fw-bold mb-3">Aucun exercice trouvé</h4>
                    @if(request()->hasAny(['search']))
                        <p class="text-muted mb-4">
                            Aucun exercice ne correspond à vos critères de recherche.<br>
                            Essayez de modifier votre terme de recherche.
                        </p>
                        <a href="{{ route('exercices.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-dumbbell me-2"></i>Voir tous les exercices
                        </a>
                    @else
                        <p class="text-muted mb-4">
                            La bibliothèque d'exercices sera bientôt disponible.<br>
                            Revenez prochainement pour découvrir nos exercices.
                        </p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Guide d'Utilisation -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-header text-white" style="background-color: #04adb9;">
                <h3 class="mb-2">
                    <i class="fas fa-compass me-2"></i>
                    Comment utiliser nos Exercices
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-search text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">1. Explorez les Catégories</h6>
                            <p class="small text-muted">
                                Parcourez nos catégories pour trouver 
                                les exercices adaptés à vos objectifs.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-book-reader text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">2. Consultez les Instructions</h6>
                            <p class="small text-muted">
                                Accédez aux descriptions détaillées avec 
                                conseils de sécurité et vidéos.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-rocket text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold">3. Pratiquez en Sécurité</h6>
                            <p class="small text-muted">
                                Suivez les recommandations pour 
                                optimiser votre entraînement.
                            </p>
                        </div>
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
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
.category-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}
.category-card:hover {
    border-left-color: var(--bs-primary);
}
.bg-gradient {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
</style>
@endpush