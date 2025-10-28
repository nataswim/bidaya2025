@extends('layouts.public')

@section('title', 'Dossiers sport et performance')
@section('meta_description', 'Plongez dans nos catégories dédiées au sport. Conseils d\'experts, méthodes d\'entraînement avancées et décryptage des dernières tendances sportives.')

@section('content')

<section class="py-5 bg-primary text-white text-center" style="background: linear-gradient(
1deg, #04adb9 0%, rgb(15 92 135) 100%);border-top: 20px solid #0cb3ff;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            Dossiers Thématiques
        </h1>
        <p class="lead mb-0">
            <strong>Dossiers structurées et accessibles</strong> pour vous accompagner 
                    dans votre progression avec des contenus organisés par domaine.
        </p>

            </div>
            <div class="col-lg-5 text-center">
                <a href="{{ route('contact') }}">
                    <img src="{{ asset('assets/images/team/nataswim-sport-net-systemes-10.jpg') }}"
                        alt="Guide Nataswim"
                        class="img-fluid rounded-4"
                        style="max-height: 300px; object-fit: cover;">
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Grille des catégories -->
<section class="py-5">
    <div class="container-lg">
        @if($categories->count() > 0)
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 hover-card">
                            <!-- Image de la catégorie -->
                            <div style="height: 200px; overflow: hidden; position: relative;">
                                @if($category->image)
                                    <img src="{{ $category->image }}" 
                                         alt="{{ $category->name }}"
                                         class="card-img-top"
                                         style="height: 100%; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-info d-flex align-items-center justify-content-center text-white" 
                                         style="height: 100%;">
                                        <i class="fas fa-folder fs-1"></i>
                                    </div>
                                @endif
                                
                                <!-- Badge nombre d'articles -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-danger shadow-sm fs-6">
                                        <i class="fas fa-file-alt me-1"></i>
                                        {{ $category->posts_count }} article{{ $category->posts_count > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenu de la carte -->
                            <div class="card-body d-flex flex-column">
                                <!-- Nom de la catégorie -->
                                <h3 class="card-title h5 mb-3">
                                    <a href="{{ route('public.category', $category->slug) }}" 
   class="text-decoration-none text-dark stretched-link">
                                        {{ $category->name }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                @if($category->description)
                                    <p class="card-text text-muted small mb-3">
                                        {{ Str::limit($category->description, 120) }}
                                    </p>
                                @endif

                                <!-- Groupe (si existe) -->
                                @if($category->group_name)
                                    <div class="mb-3">
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            <i class="fas fa-layer-group me-1"></i>{{ $category->group_name }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Derniers articles de cette catégorie -->
                                @if($category->posts->count() > 0)
                                    <div class="mt-auto pt-3 border-top">
                                        <h6 class="small fw-bold text-muted mb-2">
                                            <i class="fas fa-clock me-1"></i>Articles récents
                                        </h6>
                                        <ul class="list-unstyled small mb-0">
                                            @foreach($category->posts->take(4) as $post)
                                                <li class="mb-2">
                                                    <a href="{{ route('public.show', $post) }}" 
                                                       class="text-decoration-none text-dark">
                                                        <i class="fas fa-chevron-right text-primary me-1 small"></i>
                                                        {{ Str::limit($post->name, 50) }}
                                                    </a>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $post->published_at->format('d/m/Y') }}
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer avec bouton -->
                            <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                                <a href="{{ route('public.category', $category->slug) }}" 
   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-arrow-right me-2"></i>Voir tous les articles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Message si aucune catégorie -->
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                <h3 class="text-muted">Aucune catégorie disponible</h3>
                <p class="text-muted">Les catégories seront bientôt disponibles.</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA vers les articles -->
<section class="py-5 bg-light">
    <div class="container-lg text-center">
        <h2 class="h4 mb-4">Vous cherchez un sujet en particulier ?</h2>
        <p class="mb-4 text-muted">Que vous soyez un athlète cherchant à optimiser votre préparation physique ou un passionné souhaitant simplement progresser, l'entraînement est la clé de la réussite dans le sport. Notre plateforme se spécialise dans les programmes structurés pour atteindre vos objectifs. Découvrez nos stratégies spécifiques pour le Triathlon, où l'enchaînement de la natation, du vélo et de la course requiert une endurance et une musculation ciblées. Explorez nos dossiers détaillés sur les meilleures techniques de nage, les séances de renforcement musculaire pour prévenir les blessures, et les plans de préparation physique générale pour garantir des performances durables. Maîtrisez chaque discipline et transformez votre potentiel athlétique.</p>
        <a href="{{ route('public.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-search me-2"></i>Parcourir 
        </a>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Style pour l'effet hover sur les cartes */
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
}

/* Gradient pour l'image par défaut */
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

/* Limiter la hauteur des listes d'articles */
.card-body ul {
    max-height: 200px;
    overflow-y: auto;
}

/* Amélioration responsive */
@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem !important;
    }
    
    .card-body ul {
        max-height: 150px;
    }
}
</style>
@endpush
