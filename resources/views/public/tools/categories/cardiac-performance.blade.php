@extends('layouts.public')

@section('title', 'Outils Performance Cardiaque & Zones d\'Entraînement - Physiologie Evidence-Based')
@section('meta_description', 'Outils scientifiques pour optimiser votre entraînement cardiaque : zones d\'entraînement personnalisées et cohérence cardiaque. Approche physiologique sécurisée et evidence-based.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-danger text-white">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('tools.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-home me-1"></i>Outils
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    Performance Cardiaque & Zones d'Entraînement
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-heart me-3"></i>
                    Performance Cardiaque & Zones d'Entraînement
                </h1>
                <p class="lead mb-4">
                    Optimisez votre entraînement cardiovasculaire avec une approche physiologique scientifique. 
                    Outils basés sur la recherche en cardiologie du sport et la variabilité cardiaque pour un entraînement sécurisé et efficace.
                </p>
                <div class="alert alert-warning border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-stethoscope me-2"></i>
                        <strong>2 outils disponibles</strong> - Approche médicale sécurisée et personnalisée
                    </small>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle p-4 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-heart text-white" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avertissement médical important -->
<section class="py-4 bg-warning">
    <div class="container">
        <div class="alert alert-dark border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-user-md fa-2x text-dark"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2">Avertissement Médical Important</h6>
                    <p class="mb-0 small">
                        <strong>L'entraînement cardiaque nécessite une approche prudente et personnalisée.</strong> 
                        Consultez un médecin du sport avant de débuter tout programme d'entraînement intensif, 
                        particulièrement si vous avez des antécédents cardiovasculaires, ressentez des douleurs thoraciques, 
                        des palpitations ou tout symptôme inhabituel. Ces outils ne remplacent pas un suivi médical professionnel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Outils de la catégorie -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            <!-- 1. Zones Cardiaques Avancées -->
            <div class="col-lg-6">
                <a href="{{ route('tools.heart-rate-zones') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-bullseye text-danger" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Zones Cardiaques Avancées</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Calcul personnalisé des zones d'entraînement avec 6 formules FC max validées scientifiquement. 
                                        Intégration FC repos, HRV et adaptation individuelle pour optimisation sécurisée de l'entraînement.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">Accéder à l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>8-12 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Cohérence Cardiaque -->
            <div class="col-lg-6">
                <a href="{{ route('tools.coherence-cardiaque') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-brain text-info" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Cohérence Cardiaque</h5>
                                        <span class="badge bg-info ms-2">Bien-être</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Simulateur et guide de pratique cohérence cardiaque pour gestion du stress, 
                                        récupération et optimisation du système nerveux autonome. Technique validée scientifiquement.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">Accéder à l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>5-15 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Navigation -->
        <div class="row g-3 mt-5">
            <div class="col-md-6">
                <a href="{{ route('tools.category.nutrition') }}" class="btn btn-outline-danger btn-lg w-100">
                    <i class="fas fa-arrow-left me-2"></i>Nutrition & Énergie
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tools.category.swimming') }}" class="btn btn-danger btn-lg w-100">
                    Sports Aquatiques <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu éducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- Physiologie cardiaque fondamentale -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-2">
                    <i class="fas fa-heartbeat me-2"></i>
                    Physiologie Cardiaque et Entraînement
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">Fonction Cardiaque de Base</h6>
                        <p class="small">
                            Le cœur est une pompe musculaire qui s'adapte remarquablement à l'entraînement. 
                            La fréquence cardiaque (FC) reflète l'intensité de l'effort et permet de quantifier 
                            la charge cardiovasculaire. L'adaptation cardiaque se manifeste par une baisse 
                            de la FC de repos et une amélioration de l'efficacité de pompage.
                        </p>
                        
                        <h6 class="text-primary mt-3">Adaptations à l'Entraînement</h6>
                        <ul class="small">
                            <li><strong>Bradycardie de repos :</strong> FC repos diminuée (athlètes 40-60 bpm)</li>
                            <li><strong>Volume d'éjection :</strong> Augmentation du volume sanguin éjecté</li>
                            <li><strong>Débit cardiaque :</strong> Optimisation efficacité énergétique</li>
                            <li><strong>Récupération :</strong> Retour plus rapide à la FC basale</li>
                            <li><strong>Variabilité :</strong> Amélioration HRV (Heart Rate Variability)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Zones d'Entraînement Physiologiques</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Zone</th>
                                        <th>% FC max</th>
                                        <th>Métabolisme</th>
                                        <th>Adaptations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td>Zone 1</td>
                                        <td>50-60%</td>
                                        <td>Aérobie facile</td>
                                        <td>Récupération active</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Zone 2</td>
                                        <td>60-70%</td>
                                        <td>Aérobie base</td>
                                        <td>Endurance fondamentale</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Zone 3</td>
                                        <td>70-80%</td>
                                        <td>Aérobie intensif</td>
                                        <td>Seuil aérobie</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Zone 4</td>
                                        <td>80-90%</td>
                                        <td>Seuil lactique</td>
                                        <td>Puissance métabolique</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Zone 5</td>
                                        <td>90-100%</td>
                                        <td>Anaérobie</td>
                                        <td>VO2 max, puissance</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-warning alert-sm mt-3">
                            <h6 class="small">Principe de Spécificité</h6>
                            <p class="small mb-0">
                                Chaque zone développe des adaptations spécifiques. Un entraînement 
                                équilibré utilise toutes les zones selon la périodisation et les objectifs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calcul FC max et personnalisation -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-calculator me-2"></i>
                    Calcul FC Max et Personnalisation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Formules FC Max Validées</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Formule</th>
                                        <th>Équation</th>
                                        <th>Population</th>
                                        <th>Précision</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Astrand</td>
                                        <td>220 - âge</td>
                                        <td>Générale</td>
                                        <td>±12 bpm</td>
                                    </tr>
                                    <tr>
                                        <td>Tanaka</td>
                                        <td>208 - (0.7 × âge)</td>
                                        <td>Adultes sains</td>
                                        <td>±10 bpm</td>
                                    </tr>
                                    <tr>
                                        <td>Gulati (F)</td>
                                        <td>206 - (0.88 × âge)</td>
                                        <td>Femmes</td>
                                        <td>±8 bpm</td>
                                    </tr>
                                    <tr>
                                        <td>Nes</td>
                                        <td>211 - (0.64 × âge)</td>
                                        <td>Athlètes</td>
                                        <td>±7 bpm</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Test d'Effort - Gold Standard</h6>
                            <p class="small mb-0">
                                Le test d'effort maximal en laboratoire reste la méthode de référence 
                                pour déterminer la FC max réelle. Les formules donnent des estimations.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Facteurs de Personnalisation</h6>
                        <ul class="small">
                            <li><strong>Génétique :</strong> Variabilité individuelle importante (±15-20 bpm)</li>
                            <li><strong>Condition physique :</strong> Athlètes vs sédentaires</li>
                            <li><strong>Discipline sportive :</strong> Spécificités métaboliques</li>
                            <li><strong>Environnement :</strong> Altitude, température, humidité</li>
                            <li><strong>État de forme :</strong> Fatigue, stress, maladie</li>
                            <li><strong>Médication :</strong> Bêta-bloquants, stimulants</li>
                        </ul>
                        
                        <h6 class="text-warning mt-3">FC de Réserve (Karvonen)</h6>
                        <p class="small">
                            Méthode plus précise utilisant FC repos : 
                            <strong>Zone = [(FC max - FC repos) × %intensité] + FC repos</strong>
                        </p>
                        
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">Monitoring Continue</h6>
                            <p class="small mb-0">
                                La FC de repos matinale est un excellent indicateur de récupération 
                                et d'adaptation. Une élévation persistante peut signaler fatigue ou maladie.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cohérence cardiaque et HRV -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-wave-square me-2"></i>
                    Cohérence Cardiaque et Variabilité
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info">Qu'est-ce que la Cohérence Cardiaque ?</h6>
                        <p class="small">
                            La cohérence cardiaque est un état physiologique où le rythme cardiaque, 
                            la respiration et la pression artérielle se synchronisent naturellement. 
                            Cette pratique respiratoire (5 secondes inspiration, 5 secondes expiration) 
                            optimise le système nerveux autonome et favorise l'équilibre sympathique-parasympathique.
                        </p>
                        
                        <h6 class="text-success mt-3">Bénéfices Scientifiquement Démontrés</h6>
                        <ul class="small">
                            <li><strong>Gestion du stress :</strong> Réduction cortisol et anxiété</li>
                            <li><strong>Récupération :</strong> Activation parasympathique accélérée</li>
                            <li><strong>Performance cognitive :</strong> Amélioration focus et concentration</li>
                            <li><strong>Santé cardiovasculaire :</strong> Amélioration HRV et pression artérielle</li>
                            <li><strong>Sommeil :</strong> Qualité et efficacité du sommeil améliorées</li>
                            <li><strong>Régulation émotionnelle :</strong> Meilleure gestion des émotions</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Protocole de Pratique</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>Durée</th>
                                        <th>Fréquence</th>
                                        <th>Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Initiation</td>
                                        <td>3-5 min</td>
                                        <td>2-3×/jour</td>
                                        <td>Matin, après-midi, soir</td>
                                    </tr>
                                    <tr>
                                        <td>Développement</td>
                                        <td>5-10 min</td>
                                        <td>3×/jour</td>
                                        <td>Routines fixes</td>
                                    </tr>
                                    <tr>
                                        <td>Maintien</td>
                                        <td>5-15 min</td>
                                        <td>2-3×/jour</td>
                                        <td>Selon besoins</td>
                                    </tr>
                                    <tr>
                                        <td>Situations spéciales</td>
                                        <td>3-5 min</td>
                                        <td>À la demande</td>
                                        <td>Stress, pré-compétition</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-primary alert-sm">
                            <h6 class="small">Technique de Base</h6>
                            <p class="small mb-0">
                                <strong>Respiration 5-5 :</strong> 5 secondes inspiration, 5 secondes expiration, 
                                soit 6 cycles par minute. Position confortable, attention sur le cœur, 
                                respiration abdominale douce et régulière.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prévention et sécurité -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    Sécurité et Prévention en Entraînement Cardiaque
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">Signaux d'Alarme à Surveiller</h6>
                        <ul class="small">
                            <li><strong>Douleur thoracique :</strong> Pendant ou après l'effort</li>
                            <li><strong>Essoufflement excessif :</strong> Disproportionné à l'effort</li>
                            <li><strong>Palpitations :</strong> Rythme irrégulier ou très rapide</li>
                            <li><strong>Vertiges/malaises :</strong> Pendant ou après l'exercice</li>
                            <li><strong>Fatigue inhabituelle :</strong> Persistante malgré le repos</li>
                            <li><strong>FC anormale :</strong> Très élevée au repos ou qui ne descend pas</li>
                        </ul>
                        
                        <div class="alert alert-danger alert-sm">
                            <h6 class="small">Action Immédiate Requise</h6>
                            <p class="small mb-0">
                                En cas de douleur thoracique, malaise, ou tout symptôme cardiaque suspect : 
                                <strong>arrêt immédiat de l'activité et consultation médicale urgente.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Bonnes Pratiques de Sécurité</h6>
                        <ul class="small">
                            <li><strong>Échauffement progressif :</strong> 10-15 minutes minimum</li>
                            <li><strong>Progression graduelle :</strong> Augmentation 10% max/semaine</li>
                            <li><strong>Hydratation adequate :</strong> Avant, pendant, après effort</li>
                            <li><strong>Récupération surveillée :</strong> FC doit descendre normalement</li>
                            <li><strong>Écoute corporelle :</strong> Respecter fatigue et signaux</li>
                            <li><strong>Suivi médical :</strong> Bilan cardiologique régulier</li>
                        </ul>
                        
                        <h6 class="text-primary mt-3">Populations à Risque</h6>
                        <p class="small">
                            Hommes >45 ans, femmes >55 ans, antécédents familiaux, hypertension, 
                            diabète, obésité, tabagisme nécessitent un suivi médical renforcé 
                            avant tout programme d'entraînement intensif.
                        </p>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Test d'Effort Recommandé</h6>
                            <p class="small mb-0">
                                Un test d'effort sous surveillance médicale est recommandé pour évaluer 
                                la réponse cardiaque à l'exercice et détecter d'éventuelles anomalies.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-stethoscope me-2"></i>Rappel Important</h6>
                    <p class="mb-0 small">
                        L'entraînement cardiaque doit toujours privilégier la sécurité et la progression graduelle. 
                        <strong>Aucun objectif de performance ne justifie de prendre des risques pour sa santé.</strong> 
                        En cas de doute, consultez toujours un professionnel de santé qualifié. 
                        Ces outils sont des aides à l'entraînement, non des substituts à l'accompagnement médical.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Section Crédit et Contact -->
     <div class="card mb-4">
            <a href="{{ route('tools.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Essayer d'autres outils
            </a>
        </div>
<section class="py-5 bg-primary text-white">

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">À Propos de nos Outils</h3>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info mb-2">Développement & Expertise</h6>
                        <p class="mb-3">
                            Contenus et outils développés par 
                            <a href="https://www.linkedin.com/in/med-hassan-el-haouat-98909541/" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="text-warning fw-bold text-decoration-none">
                                Med Hassan El Haouat
                                <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        </p>
                        <p class="small text-light opacity-75">
                            Expert en sciences du sport, physiologie de l'exercice et développement 
                            d'outils d'aide à la performance sportive evidence-based.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">Collaboration & Amélioration</h6>
                        <p class="mb-3 small">
                            Si vous constatez une erreur dans nos calculateurs ou souhaitez suggérer 
                            de nouveaux outils, n'hésitez pas à nous contacter.
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
                    <small class="text-light opacity-75">Recherches 2024 intégrées</small>
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
                <i class="fas fa-newspaper text-primary me-2"></i>Dernières Publications
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
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.7);
}

.breadcrumb-item.active {
    color: rgba(255,255,255,0.9);
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.table th {
    border-top: none;
}

.table-success, .table-info, .table-primary, .table-warning, .table-danger {
    --bs-table-accent-bg: var(--bs-table-bg);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les cards
    const cards = document.querySelectorAll('.hover-lift');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush