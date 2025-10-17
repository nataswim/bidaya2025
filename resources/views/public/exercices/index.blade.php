@extends('layouts.public')

@section('title', 'Exercices d\'Entraînement - Bibliothèque Complète')
@section('meta_description', 'Découvrez notre bibliothèque complète d\'exercices d\'entraînement pour tous niveaux. Cardio, force, flexibilité et équilibre avec instructions détaillées.')

@section('content')
<!-- Section titre -->


<section class="text-white py-5" style="border-left: 2px dashed #f9f5f4;margin-bottom: 20px;background: linear-gradient(
76deg, #086690 0%, #0f5c78 100%);border-right: 2px dashed #f9f5f4;border-bottom: 2px dashed #f9f5f4;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Exercices Zone
        </h1>
        <p class="lead mb-0">
                    Découvrez notre bibliothèque d'exercices pour tous niveaux, avec instructions détaillées et conseils de sécurité
 </p>

            </div>
            <div class="col-lg-5 text-center">
                <a href="{{ route('contact') }}">
                    <img src="{{ asset('assets/images/team/auteur-coach-hassan-el-haouat-nataswim-2.png') }}"
                        alt="Guide Nataswim"
                        class="img-fluid rounded-4"
                        style="max-height: 200px; object-fit: cover;">
                </a>
            </div>
        </div>
    </div>
</section>



<!-- Filtres et recherche -->
<section class="py-5">
    <div class="container">
        <div class="card border-0">
            <div class="card-body">
                
                <form method="GET" class="row g-3">
                    <div class="col-md">
                        <label class="fw-bold mb-2"><i class="fas fa-dumbbell text-primary me-2"></i></label>
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

                @if(request()->hasAny(['search', 'niveau', 'type']))
                    <div class="text-center mt-3">
                        <a href="{{ route('exercices.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Réinitialiser Retour aux exercices complets
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
                            {{ $exercices->total() }} Exercices Trouvés
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
