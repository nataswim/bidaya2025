@extends('layouts.public')

@section('title', 'Calculateur Vitesse de Nage Critique (VNC) & Zones d\'Entraînement - Outil Pro')
@section('meta_description', 'Calculez votre VNC et vos zones d\'entraînement natation avec la mÃ©thode scientifique validÃ©e. Formule : (Temps 400m - Temps 200m) / 2. Simple, rapide, efficace.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-3">
        <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="fas fa-tachometer-alt"></i>
            Calculateur de Vitesse de Nage Critique (VNC)
        </h1>
        <div class="alert alert-info border-0 shadow-sm" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="d-flex align-items-start">
                <i class="fas fa-calculator text-info me-3 mt-1"></i>
                <div class="text-dark">
                    <strong>Calculez votre VNC et vos zones d'entraînement :</strong><br>
                    <code class="bg-light text-dark px-2 py-1 rounded">VNC = (Temps 400m - Temps 200m) ÷ 2</code>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculateur Principal -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Saisissez vos temps de rÃ©fÃ©rence</h3>
                
                <!-- Messages d'erreur -->
                <div id="errorMessage" class="alert alert-danger d-none">
                    <!-- Sera rempli par JavaScript -->
                </div>
                
                <!-- Formulaire de saisie -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold mb-2 text-primary">
                            <i class="fas fa-stopwatch me-2"></i>Temps sur 200m
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="number" id="time200min" class="form-control border-primary" 
                                   placeholder="Min" min="0" max="59">
                            <span class="input-group-text bg-primary text-white">min</span>
                            <input type="number" id="time200sec" class="form-control border-primary" 
                                   placeholder="Sec" min="0" max="59.9" step="0.1">
                            <span class="input-group-text bg-primary text-white">sec</span>
                        </div>
                        <small class="text-muted">Exemple : 2 min 30.5 sec</small>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-bold mb-2 text-success">
                            <i class="fas fa-stopwatch me-2"></i>Temps sur 400m
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="number" id="time400min" class="form-control border-success" 
                                   placeholder="Min" min="0" max="59">
                            <span class="input-group-text bg-success text-white">min</span>
                            <input type="number" id="time400sec" class="form-control border-success" 
                                   placeholder="Sec" min="0" max="59.9" step="0.1">
                            <span class="input-group-text bg-success text-white">sec</span>
                        </div>
                        <small class="text-muted">Exemple : 5 min 15.2 sec</small>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-lg px-4 py-3 fw-bold w-100" onclick="calculateVNC()">
                            <i class="fas fa-calculator me-2"></i>Calculer ma VNC
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary btn-lg px-4 py-3 fw-bold w-100" onclick="resetForm()">
                            <i class="fas fa-redo me-2"></i>RÃ©initialiser
                        </button>
                    </div>
                </div>

                <!-- RÃ©sultats VNC -->
                <div id="vncResults" class="d-none">
                    <div class="alert alert-success shadow-sm">
                        <h5 class="alert-heading text-center mb-4">
                            <i class="fas fa-trophy me-2"></i>Votre Vitesse de Nage Critique
                        </h5>
                        
                        <div class="text-center mb-4">
                            <div class="display-4 text-primary fw-bold" id="vncValue">
                                <!-- Sera rempli par JavaScript -->
                            </div>
                            <p class="text-muted fs-5">
                                C'est votre allure cible pour l'entraînement au seuil
                            </p>
                        </div>

                        <!-- Zones d'entraînement -->
                        <h6 class="text-center mb-3">
                            <i class="fas fa-layer-group me-2"></i>Vos Zones d'Entraînement
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Zone</th>
                                        <th class="text-center">% VNC</th>
                                        <th class="text-center">Allure / 100m</th>
                                        <th class="text-center">Objectif</th>
                                        <th class="text-center">Sensation</th>
                                    </tr>
                                </thead>
                                <tbody id="zonesTableBody">
                                    <!-- Sera rempli par JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>
                                Ces zones sont des estimations basÃ©es sur votre VNC. Adaptez selon votre ressenti 
                                et les conseils de votre entraîneur.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
<section class="py-5">
    <div class="container">
        <!-- Comprendre la VNC -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Comprendre la Vitesse de Nage Critique (VNC)
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>DÃ©finition :</strong> La VNC reprÃ©sente la vitesse maximale qu'un nageur peut maintenir 
                    de maniÃ¨re quasi-stationnaire sans accumulation significative de lactate. C'est votre seuil anaÃ©robie en natation.
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>
                            <i class="fas fa-flask me-2 text-primary"></i>Base Scientifique
                        </h6>
                        <p>La formule utilisÃ©e est simple mais efficace :</p>
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <code class="fs-5">VNC = (T400m - T200m) ÷ 2</code>
                                <p class="small mt-2 mb-0">RÃ©sultat en secondes par 100 mÃ¨tres</p>
                            </div>
                        </div>
                        <p class="mt-3">
                            Cette mÃ©thode est basÃ©e sur la diffÃ©rence de temps entre deux distances sub-maximales 
                            pour rÃ©vÃ©ler votre seuil d'endurance.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>
                            <i class="fas fa-bullseye me-2 text-success"></i>Pourquoi s'entraîner Ã la VNC ?
                        </h6>
                        <ul>
                            <li><strong>AmÃ©lioration du seuil :</strong> Repousse votre limite lactique</li>
                            <li><strong>Endurance de puissance :</strong> Combine endurance et vitesse</li>
                            <li><strong>Ã©conomie de nage :</strong> AmÃ©liore votre efficacitÃ© technique</li>
                            <li><strong>Progression mesurable :</strong> Test reproductible dans le temps</li>
                        </ul>
                        
                        <div class="alert alert-success">
                            <small>
                                <strong>La VNC est un excellent indicateur</strong> de votre capacitÃ© aÃ©robie 
                                et de votre efficacitÃ© propulsive en natation.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DÃ©tail des Zones -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-layer-group me-2"></i>
                    DÃ©tail des Zones d'Entraînement
                </h3>
            </div>
            <div class="card-body">
                <p>
                    L'entraînement Ã diffÃ©rentes intensitÃ©s permet de cibler des adaptations physiologiques 
                    spÃ©cifiques. Voici le dÃ©tail de chaque zone :
                </p>
                
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-info h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">Zone 1 : RÃ©cupÃ©ration</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>IntensitÃ© :</strong> 115-125% VNC</p>
                                <p><strong>Sensation :</strong> TrÃ¨s facile, conversation fluide</p>
                                <p><strong>Objectif :</strong> Favoriser la circulation et la rÃ©cupÃ©ration musculaire</p>
                                <p><strong>Usage :</strong> Ã©chauffement, rÃ©cupÃ©ration active</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Zone 2 : Endurance AÃ©robie</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>IntensitÃ© :</strong> 105-115% VNC</p>
                                <p><strong>Sensation :</strong> Facile Ã modÃ©rÃ©, soutenable longtemps</p>
                                <p><strong>Objectif :</strong> DÃ©velopper la base aÃ©robie et l'efficacitÃ© Ã©nergÃ©tique</p>
                                <p><strong>Usage :</strong> SÃ©ries longues, fond</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-warning h-100">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">Zone 3 : Seuil (VNC)</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>IntensitÃ© :</strong> 98-102% VNC</p>
                                <p><strong>Sensation :</strong> Difficile mais soutenable</p>
                                <p><strong>Objectif :</strong> Maintenir une vitesse Ã©levÃ©e sur la durÃ©e</p>
                                <p><strong>Usage :</strong> SÃ©ries au seuil, tempo</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-6">
                        <div class="card border-danger h-100">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">Zone 4 : VO2 Max</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>IntensitÃ© :</strong> 90-98% VNC</p>
                                <p><strong>Sensation :</strong> TrÃ¨s difficile, effort maximal sur courtes durÃ©es</p>
                                <p><strong>Objectif :</strong> AmÃ©liorer la puissance aÃ©robie maximale</p>
                                <p><strong>Usage :</strong> SÃ©ries courtes intenses, fractionnÃ©</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-6">
                        <div class="card border-dark h-100">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0">Zone 5 : Vitesse Maximale</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>IntensitÃ© :</strong> 80-90% VNC</p>
                                <p><strong>Sensation :</strong> Sprint, effort maximal</p>
                                <p><strong>Objectif :</strong> DÃ©velopper la vitesse pure et la puissance neuromusculaire</p>
                                <p><strong>Usage :</strong> Sprints, dÃ©parts, virages</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications Pratiques -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-swimming-pool me-2"></i>
                    Applications Pratiques
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-primary h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Planification d'Entraînement</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>DÃ©finir les allures de sÃ©ries</li>
                                    <li>PÃ©riodiser les intensitÃ©s</li>
                                    <li>Suivre la progression</li>
                                    <li>Adapter les charges</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Test et Ã©valuation</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>Test reproductible mensuel</li>
                                    <li>Indicateur de forme</li>
                                    <li>Validation des progrÃ¨s</li>
                                    <li>Ajustement des objectifs</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">Optimisation Performance</h6>
                            </div>
                            <div class="card-body">
                                <ul class="small">
                                    <li>StratÃ©gie de course</li>
                                    <li>Gestion de l'effort</li>
                                    <li>AmÃ©lioration technique</li>
                                    <li>PrÃ©paration compÃ©tition</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RÃ©fÃ©rences Scientifiques -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-book me-2"></i>
                    RÃ©fÃ©rences Scientifiques
                </h3>
            </div>
            <div class="card-body">
                <p>
                    La mÃ©thode VNC est largement reconnue et utilisÃ©e en physiologie de l'exercice 
                    et en entraînement sportif depuis les annÃ©es 1990.
                </p>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6>Ã©tudes Fondamentales</h6>
                        <ul class="small">
                            <li><strong>Wakayoshi et al. (1993)</strong> - Validation de la VNC comme standard aÃ©robie en natation</li>
                            <li><strong>Pelayo et al. (1996)</strong> - ValiditÃ© chez les nageurs masculins et fÃ©minins</li>
                            <li><strong>Dekerle et al. (2002)</strong> - Applications pratiques en entraînement</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Applications Modernes</h6>
                        <ul class="small">
                            <li><strong>Costill et al. (1985)</strong> - MÃ©tabolisme Ã©nergÃ©tique en natation</li>
                            <li><strong>Olbrecht (2000)</strong> - Science de l'entraînement optimal</li>
                            <li><strong>Maglischo (2003)</strong> - BiomÃ©canique et physiologie</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>
                        La VNC reste un outil de rÃ©fÃ©rence utilisÃ© par les entraîneurs du monde entier 
                        pour optimiser les performances de leurs nageurs.
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section CrÃ©dit et Contact -->
     <div class="card mb-4">
            <a href="{{ route('tools.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Essayer d'autres outils
            </a>
        </div>
<section class="py-5 bg-primary text-white">

    <div class="container">


        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Ã Propos de nos Outils</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">DÃ©veloppement & Expertise</h6>
                        <p class="mb-3">
                            Contenus et outils dÃ©veloppÃ©s par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Expert en sciences du sport, physiologie de l'exercice et dÃ©veloppement 
                            d'outils d'aide Ã la performance sportive evidence-based.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Collaboration & AmÃ©lioration</h6>
                        <p class="mb-3 small">
                            Si vous constatez une erreur dans nos calculateurs ou souhaitez suggÃ©rer 
                            de nouveaux outils, n'hÃ©sitez pas Ã nous contacter.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-envelope me-2"></i>Nous Contacter
                            </a>
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fab fa-linkedin me-2"></i>LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="bg-white bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/med_Hassan_EL_HAOUAT.png') }}" 
                         alt="MED Hassan El Haouat - Expert en sciences du sport" 
                         class="w-100 h-100 rounded-circle"
                         style="object-fit: cover;">
                </div>
                <div class="mt-3">
                    <h6 class="text-warning mb-1">Evidence-Based</h6>
                    <small class="text-light opacity-75">Recherches 2024 intÃ©grÃ©es</small>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- DerniÃ¨res Publications -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-newspaper text-primary me-2"></i>DerniÃ¨res Publications
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
                                        {{ Str::limit(strip_tags($post->intro), 100) }}
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
                <i class="fas fa-info-circle me-2"></i>Aucun article n'est disponible actuellement.
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

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.input-group-lg .form-control {
    font-size: 1.1rem;
}
</style>
@endpush

@push('scripts')
<script>
function convertToSeconds(minutes, seconds) {
    return (parseInt(minutes) || 0) * 60 + (parseFloat(seconds) || 0);
}

function formatSecondsToTime(totalSeconds) {
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = (totalSeconds % 60).toFixed(1).padStart(4, '0');
    return `${minutes}:${seconds}`;
}

function calculateVNC() {
    // RÃ©cupÃ©rer les valeurs
    const time200min = document.getElementById('time200min').value;
    const time200sec = document.getElementById('time200sec').value;
    const time400min = document.getElementById('time400min').value;
    const time400sec = document.getElementById('time400sec').value;
    
    // Convertir en secondes
    const t200 = convertToSeconds(time200min, time200sec);
    const t400 = convertToSeconds(time400min, time400sec);
    
    // Validation
    const errorDiv = document.getElementById('errorMessage');
    if (t200 <= 0 || t400 <= 0) {
        errorDiv.textContent = "Veuillez entrer des temps valides pour les deux distances.";
        errorDiv.classList.remove('d-none');
        document.getElementById('vncResults').classList.add('d-none');
        return;
    }
    
    if (t400 <= t200) {
        errorDiv.textContent = "Le temps sur 400m doit être supÃ©rieur au temps sur 200m.";
        errorDiv.classList.remove('d-none');
        document.getElementById('vncResults').classList.add('d-none');
        return;
    }
    
    // Masquer les erreurs
    errorDiv.classList.add('d-none');
    
    // Calcul VNC : (T400 - T200) / 2
    const vnc = (t400 - t200) / 2;
    
    // Affichage du rÃ©sultat principal
    document.getElementById('vncValue').textContent = formatSecondsToTime(vnc) + " / 100m";
    
    // DÃ©finition des zones d'entraînement
    const zones = [
        {
            name: "Zone 1: RÃ©cupÃ©ration",
            percentage: "115-125%",
            min: vnc * 1.15,
            max: vnc * 1.25,
            objectif: "Circulation, rÃ©cupÃ©ration musculaire",
            sensation: "TrÃ¨s facile, conversation fluide",
            color: "table-info"
        },
        {
            name: "Zone 2: Endurance AÃ©robie",
            percentage: "105-115%",
            min: vnc * 1.05,
            max: vnc * 1.15,
            objectif: "Base aÃ©robie, efficacitÃ© Ã©nergÃ©tique",
            sensation: "Facile Ã modÃ©rÃ©, longue durÃ©e",
            color: "table-success"
        },
        {
            name: "Zone 3: Seuil (VNC)",
            percentage: "98-102%",
            min: vnc * 0.98,
            max: vnc * 1.02,
            objectif: "Maintenir vitesse Ã©levÃ©e sur durÃ©e",
            sensation: "Difficile mais soutenable",
            color: "table-warning"
        },
        {
            name: "Zone 4: VO2 Max",
            percentage: "90-98%",
            min: vnc * 0.90,
            max: vnc * 0.98,
            objectif: "Puissance aÃ©robie maximale",
            sensation: "TrÃ¨s difficile, courtes durÃ©es",
            color: "table-danger"
        },
        {
            name: "Zone 5: Vitesse Maximale",
            percentage: "80-90%",
            min: vnc * 0.80,
            max: vnc * 0.90,
            objectif: "Vitesse pure, puissance neuromusculaire",
            sensation: "Sprint, effort maximal",
            color: "table-dark"
        }
    ];
    
    // Remplissage du tableau des zones
    const tbody = document.getElementById('zonesTableBody');
    tbody.innerHTML = zones.map(zone => `
        <tr class="${zone.color}">
            <td class="fw-bold">${zone.name}</td>
            <td class="text-center">${zone.percentage}</td>
            <td class="text-center fw-bold">
                ${formatSecondsToTime(zone.min)} - ${formatSecondsToTime(zone.max)}
            </td>
            <td>${zone.objectif}</td>
            <td><em>${zone.sensation}</em></td>
        </tr>
    `).join('');
    
    // Afficher les rÃ©sultats
    document.getElementById('vncResults').classList.remove('d-none');
    
    // Scroll vers les rÃ©sultats
    document.getElementById('vncResults').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function resetForm() {
    document.getElementById('time200min').value = '';
    document.getElementById('time200sec').value = '';
    document.getElementById('time400min').value = '';
    document.getElementById('time400sec').value = '';
    document.getElementById('vncResults').classList.add('d-none');
    document.getElementById('errorMessage').classList.add('d-none');
}

// Validation en temps rÃ©el
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            // Validation simple des valeurs
            if (this.id.includes('min') && parseFloat(this.value) > 59) {
                this.value = 59;
            }
            if (this.id.includes('sec') && parseFloat(this.value) >= 60) {
                this.value = 59.9;
            }
            if (parseFloat(this.value) < 0) {
                this.value = 0;
            }
        });
    });
});
</script>
@endpush