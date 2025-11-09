

@extends('layouts.public')

{{-- SEO Meta --}}
@section('title', $workout->title)
@section('meta_description', strip_tags($workout->short_description))

{{-- Open Graph / Facebook --}}
@section('og_type', 'article')
@section('og_title', $workout->title)
@section('og_description', strip_tags($workout->short_description))
@if($workout->image)
    @section('og_image', $workout->image)
    @section('og_image_alt', $workout->title)
@endif

{{-- Twitter Card --}}
@section('twitter_title', $workout->title)
@section('twitter_description', strip_tags($workout->short_description))
@if($workout->image)
    @section('twitter_image', $workout->image)
@endif

@section('content')








<!-- En-tête de section -->


<section class="py-5 text-white text-center nataswim-titre3">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-5 fw-bold mb-0">{{ $workout->title }}</h1>
                
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="fas fa-ruler me-1"></i>{{ $workout->formatted_total }}
                    </span>
                    
                </div>
            </div>

        </div>
        
    </div>
</section>








<!-- Breadcrumb -->
<section class="py-3 bg-light border-bottom">
    <div class="container-lg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.index') }}">
                        <i class="fas fa-home me-1"></i>Séances
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.section', $section) }}">
                        {{ $section->name }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.workouts.category', [$section, $category]) }}">
                        {{ $category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {!! Str::limit($workout->title, 50) !!}
                </li>
            </ol>
        </nav>
    </div>
</section>

<article class="py-4">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-12">
                
                <!-- Dans la page de détail d'un workout -->
<div class="card-body">
    <!-- Contenu existant du workout... -->
    
    <div class="d-flex gap-2 mt-4">
        <!-- Boutons existants (ajouter aux favoris, etc.) -->
        
        <!-- NOUVEAU : Bouton Planifier -->
        @auth
            @if(auth()->user()->hasRole('user') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('admin'))
                <a href="{{ route('user.calendar.create', [
    'linkable_type' => 'workout',
    'linkable_id' => $workout->id,
    'linkable_title' => $workout->title,
    'title' => 'Entraînement: ' . $workout->title,
    'type' => 'entrainement'
]) }}" class="btn btn-outline-primary">
    <i class="fas fa-calendar-plus me-1"></i>Planifier cet entraînement
</a>
            @endif
        @endauth
    </div>
</div>

                <!-- Card 2: Objectif de la séance (description courte) -->
                @if($workout->short_description)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info border-0 mb-0" 
                                 style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <div class="content-display lead">
                                    {!! $workout->short_description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif




                
<!-- Card 3: Déroulement de la séance (description longue) - UTILISATEURS  -->
@if($workout->long_description)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h2 class="mb-0 h5">
                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                Détails
            </h2>
        </div>
        <div class="card-body p-4">
            @auth
                {{-- Utilisateur connecté : affichage complet --}}
                <div class="content-display-full fs-6 lh-lg">
                    {!! $workout->long_description !!}
                </div>
            @else
                {{-- Utilisateur non connecté : aperçu tronqué --}}
                <div class="content-display-full fs-6 lh-lg text-muted">
                    {!! Str::limit(strip_tags($workout->long_description), 100, '...') !!}
                </div>
                
                <div class="alert alert-warning border-0 mt-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-lock text-warning fs-2"></i>
                        </div>
                        <div class="col">
                            <h5 class="alert-heading mb-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Contenu réservé aux membres premium
                            </h5>
                            <p class="mb-3">
                                Connectez-vous ou créez un compte pour accéder au déroulement complet de cette séance d'entraînement.
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('register') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-user-plus me-2"></i>Inscription
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endif

                <!-- Card 4: Autres séances du programme -->
                @if($relatedWorkouts->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="mb-0 h5">
                                <i class="fas fa-running me-2 text-primary"></i>
                                Plus : -  {{ $category->name }}
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach($relatedWorkouts as $related)
                                    <div class="col-md-4">
                                        <div class="card h-100 border">
                                            <div class="card-header bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">Séance #{{ $related->pivot->order_number }}</span>
                                                    <span class="badge bg-info">{{ $related->formatted_total }}</span>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <h3 class="card-title h6">{!! Str::limit($related->title, 60) !!}</h3>
                                                <a href="{{ route('public.workouts.show', [$section, $category, $related]) }}" 
                                                   class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 5: Autres programmes de cette séance -->
                @if($workout->categories->count() > 1)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="mb-0 h5">
                                <i class="fas fa-folder-open me-2 text-info"></i>
                                Fait aussi partie de
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                @foreach($workout->categories as $cat)
                                    @if($cat->id !== $category->id)
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="badge bg-primary mb-1">Séance #{{ $cat->pivot->order_number }}</span>
                                                            <h3 class="mb-1 h6">Programme {{ $cat->name }}</h3>
                                                            <small class="text-muted">
                                                                <i class="fas fa-layer-group me-1"></i>
                                                                {{ $cat->section->name ?? 'N/A' }}
                                                            </small>
                                                        </div>
                                                        <a href="{{ route('public.workouts.show', [$cat->section, $cat, $workout]) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            Voir
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 6: Caractéristiques de la séance -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h2 class="mb-0 h5">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Caractéristiques 
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-layer-group me-1"></i>Discipline :
                                    </span>
                                    <strong>{{ $section->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-folder me-1"></i>Programme :
                                    </span>
                                    <strong>{{ $category->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-ruler me-1"></i>Volume total :
                                    </span>
                                    <strong>{{ $workout->formatted_total }}</strong>
                                </div>
                            </div>
                            @if($orderNumber !== null)
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">
                                            <i class="fas fa-hashtag me-1"></i>Position :
                                        </span>
                                        <strong>Séance n°{{ $orderNumber }}</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Ajoutée le :
                                    </span>
                                    <strong>{{ $workout->created_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-edit me-1"></i>Mise à jour :
                                    </span>
                                    <strong>{{ $workout->updated_at->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Navigation -->
                <div class="row g-4 mb-4">
                    <!-- Programme -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h2 class="mb-0 h5">
                                    <i class="fas fa-folder me-2"></i>Programme
                                </h2>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('public.workouts.category', [$section, $category]) }}" 
                                   class="d-flex align-items-center text-decoration-none">
                                    <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 70px; height: 70px;">
                                        <i class="fas fa-folder text-info fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 text-dark h6">{{ $category->name }}</h3>
                                        <small class="text-muted">Voir toutes les séances</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-secondary text-white">
                                <h2 class="mb-0 h5">
                                    Plus
                                </h2>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('public.workouts.category', [$section, $category]) }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Retour au programme {!! Str::limit($category->name, 25) !!}
                                    </a>
                                    <a href="{{ route('public.workouts.section', $section) }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-layer-group me-2"></i>Discipline {{ $section->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</article>

<!-- Section SEO -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">À propos de cette séance d'entraînement</h2>
                        <p class="text-muted">
                            Cette <strong>séance d'entraînement {{ $section->name }}</strong> fait partie 
                            du <strong>programme {{ $category->name }}</strong> et représente un volume 
                            total de <strong>{{ $workout->formatted_total }}</strong>.
                        </p>
                        <p class="text-muted mb-0">
                            Suivez les instructions détaillées pour réaliser cette 
                            <strong>séance d'entraînement</strong> dans les meilleures conditions 
                            et progresser efficacement dans votre discipline.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection




@push('scripts')
<script>
function planifyWorkout(workoutId, workoutTitle) {
    // Pré-remplir le modal de création
    document.getElementById('create_discipline').value = '';
    document.getElementById('create_title').value = 'Entraînement: ' + workoutTitle;
    document.getElementById('create_type').value = 'entrainement';
    document.getElementById('create_linkable_type').value = 'workout';
    
    // Charger les workouts et pré-sélectionner celui-ci
    fetch(`/user/calendar/from-workout/${workoutId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('create_linkable_id');
                select.innerHTML = `<option value="${workoutId}" selected>${workoutTitle}</option>`;
                select.disabled = false;
            }
        });
    
    // Ouvrir le modal
    const modalEl = document.getElementById('createEventModalFromWorkout');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}
</script>
@endpush

<!-- Modal de planification simplifié pour workout -->
<div class="modal fade" id="createEventModalFromWorkout" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.calendar.store') }}" method="POST">
                @csrf
                <input type="hidden" name="linkable_type" value="workout" id="create_linkable_type">
                <input type="hidden" name="linkable_id" id="create_linkable_id" value="{{ $workout->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title">📅 Planifier cet entraînement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Discipline</label>
                        <input type="text" id="create_discipline" name="discipline" class="form-control" placeholder="Ex: Musculation">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" id="create_title" name="title" class="form-control" 
                               value="Entraînement: {{ $workout->title }}" required>
                    </div>
                    
                    <input type="hidden" id="create_type" name="type" value="entrainement">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Date *</label>
                            <input type="date" name="event_date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heure *</label>
                            <input type="time" name="event_time" class="form-control" required value="14:00">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Lieu</label>
                        <input type="text" name="location" class="form-control" placeholder="Salle de sport">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Objectif</label>
                        <input type="text" name="objective" class="form-control" placeholder="Ex: Améliorer force">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Remarques</label>
                        <textarea name="remarks" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-link me-2"></i>
                        Cette activité sera liée à l'entraînement <strong>{{ $workout->title }}</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check me-1"></i>Planifier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>





@push('styles')
<style>
/* Styles pour le contenu HTML de Quill */
.content-display h1,
.content-display h2,
.content-display h3,
.content-display-full h1,
.content-display-full h2,
.content-display-full h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    line-height: 1.3;
}

.content-display h1, .content-display-full h1 { font-size: 1.8rem; color: #2d3748; }
.content-display h2, .content-display-full h2 { font-size: 1.5rem; color: #2d3748; }
.content-display h3, .content-display-full h3 { font-size: 1.3rem; color: #2d3748; }

.content-display p,
.content-display-full p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
    text-align: justify;
    color: #4a5568;
}

.content-display ul,
.content-display ol,
.content-display-full ul,
.content-display-full ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
    line-height: 1.7;
}

.content-display li,
.content-display-full li {
    margin-bottom: 0.5rem;
}

.content-display blockquote,
.content-display-full blockquote {
    border-left: 4px solid #3182ce;
    padding: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    background: #f7fafc;
    border-radius: 0.375rem;
    color: #2d3748;
}

.content-display img,
.content-display-full img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 2rem 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.content-display pre,
.content-display-full pre {
    background: #1a202c;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 2rem 0;
    font-size: 0.875rem;
    line-height: 1.6;
}
</style>
@endpush