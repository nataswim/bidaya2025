@extends('layouts.public')

@section('title', 'Exercices d\'Entraînement - Bibliothèque Complète')
@section('meta_description', 'Découvrez notre bibliothèque complète d\'exercices d\'entraînement pour tous niveaux. Cardio, force, flexibilité et équilibre avec instructions détaillées.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Exercices de Musculation
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-water text-info me-3 mt-1"></i>
                <div class="text-dark">
                    Découvrez notre bibliothèque d'exercices pour tous niveaux, avec instructions détaillées et conseils de sécurité
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtres et recherche -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Rechercher et Filtrer</h3>
                
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="fw-bold mb-2">Recherche</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="form-control form-control-lg border-primary"
                               placeholder="Nom de l'exercice...">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold mb-2">Niveau</label>
                        <select name="niveau" class="form-select form-select-lg border-primary">
                            <option value="">Tous niveaux</option>
                            <option value="debutant" {{ request('niveau') === 'debutant' ? 'selected' : '' }}>Débutant</option>
                            <option value="intermediaire" {{ request('niveau') === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                            <option value="avance" {{ request('niveau') === 'avance' ? 'selected' : '' }}>Avancé</option>
                            <option value="special" {{ request('niveau') === 'special' ? 'selected' : '' }}>Spécial</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold mb-2">Type d'exercice</label>
                        <select name="type" class="form-select form-select-lg border-primary">
                            <option value="">Tous types</option>
                            <option value="cardio" {{ request('type') === 'cardio' ? 'selected' : '' }}>Cardio</option>
                            <option value="force" {{ request('type') === 'force' ? 'selected' : '' }}>Force</option>
                            <option value="flexibilite" {{ request('type') === 'flexibilite' ? 'selected' : '' }}>Flexibilité</option>
                            <option value="equilibre" {{ request('type') === 'equilibre' ? 'selected' : '' }}>Équilibre</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-bold mb-2">&nbsp;</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                        </div>
                    </div>
                </form>

                @if(request()->hasAny(['search', 'niveau', 'type']))
                    <div class="text-center mt-3">
                        <a href="{{ route('exercices.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Réinitialiser les filtres
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
                            <i class="fas fa-dumbbell text-primary me-2"></i>
                            {{ $exercices->total() }} exercice(s) trouvé(s)
                        </h2>
                        @if(request()->hasAny(['search', 'niveau', 'type']))
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
                                <h5 class="card-title fw-bold mb-2">{{ $exercice->titre }}</h5>
                                
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-{{ $exercice->niveau === 'debutant' ? 'success' : ($exercice->niveau === 'avance' ? 'danger' : 'warning') }}">
                                        {{ $exercice->niveau_label }}
                                    </span>
                                    <span class="badge bg-primary">
                                        {{ $exercice->type_exercice_label }}
                                    </span>
                                </div>
                                
                                @if($exercice->description)
                                    <p class="card-text text-muted small flex-fill">
                                        {!! Str::limit(strip_tags($exercice->description), 100) !!}
                                    </p>
                                @endif
                                
                                @if($exercice->muscles_cibles && count($exercice->muscles_cibles) > 0)
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-crosshairs me-1"></i>Muscles ciblés :
                                        </small>
                                        <small class="text-primary fw-semibold">
                                            {{ $exercice->muscles_cibles_formatted }}
                                        </small>
                                    </div>
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
                    @if(request()->hasAny(['search', 'niveau', 'type']))
                        <p class="text-muted mb-4">
                            Aucun exercice ne correspond à vos critères de recherche.<br>
                            Essayez de modifier vos filtres ou votre terme de recherche.
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



<!-- Section Navigation -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <h5 class="fw-bold mb-3">Découvrez aussi</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('tools.index') }}" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-calculator me-2"></i>Outils de calcul
                        </a>
                    </div>
                            <div class="col-md-4">
                                <a href="{{ route('plans.index') }}" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-dumbbell me-2"></i>Plans de Musculation
                                </a>
                            </div>

                    <div class="col-md-4">
                        <a href="{{ route('public.index') }}" class="btn btn-outline-info btn-lg w-100">
                            <i class="fas fa-water me-2"></i>Articles & conseils
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Dernières Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-water text-primary me-2"></i>Dernières Publications
            </h2>
            <a href="{{ route('public.index') }}" class="btn btn-outline-primary">
                Tous les articles <i class="fas fa-angle-right ms-1"></i>
            </a>
        </div>
        
        @php
            $latestPosts = App\Models\Post::with('category')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        @endphp
        
        @if($latestPosts->count() > 0)
            <div class="row g-4">
                @foreach($latestPosts as $post)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm hover-lift border-0">
                            <div style="height: 180px; overflow: hidden;">
                                @if($post->image)
                                    <img src="{{ $post->image }}" 
                                         alt="{{ $post->name }}"
                                         class="card-img-top"
                                         style="height: 100%; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                        <i class="fas fa-swimmer text-muted" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($post->category)
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    </div>
                                @endif
                                <h3 class="card-title h5 mb-3">{{ $post->name }}</h3>
                                @if($post->intro)
                                    <p class="card-text text-muted small">
                                        {!! Str::limit(strip_tags($post->intro), 100) !!}
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $post->published_at->format('d/m/Y') }}
                                </small>
                                <a href="{{ route('public.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                    Lire la suite
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info" role="alert">
                <i class="fas fa-water me-2"></i>Aucun article n'est disponible actuellement.
            </div>
        @endif
   
   <div class="text-center">
    <img src="{{ asset('assets/images/team/nataswim-application-banner-11.jpg') }}" 
         alt="exercice de musculation" 
         class="img-fluid rounded shadow">
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
.bg-gradient {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
</style>
@endpush
