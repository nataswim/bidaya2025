@extends('layouts.public')

@section('title', 'Outils Nutrition & Énergie Sportive - Calculateurs Evidence-Based')
@section('meta_description', 'Outils scientifiques pour optimiser votre nutrition sportive : conversion calories-macros, besoins énergétiques personnalisés, hydratation. Approche équilibrée et evidence-based.')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-success text-white">
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
                    Nutrition & Énergie
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-apple-alt me-3"></i>
                    Nutrition & Énergie Sportive
                </h1>
                <p class="lead mb-4">
                    Optimisez votre nutrition sportive avec une approche scientifique équilibrée. 
                    Outils basés sur les recommandations nutritionnelles internationales et la physiologie énergétique.
                </p>
                <div class="alert alert-warning border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>3 outils disponibles</strong> - Approche équilibrée et santé-centrée
                    </small>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle p-4 d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-apple-alt text-white" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Outils de la catégorie -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            <!-- 1. Convertisseur Calories ↔ Macros -->
            <div class="col-lg-6">
                <a href="{{ route('tools.kcal-macros') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-exchange-alt text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Convertisseur Calories ↔ Macros</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Calculs énergétiques précis et répartition macronutriments adaptée aux objectifs sportifs. 
                                        Multiple stratégies nutritionnelles evidence-based pour optimiser performance et récupération.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">Accéder à l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>5-8 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Besoins Caloriques Sportifs -->
            <div class="col-lg-6">
                <a href="{{ route('tools.calories') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-running text-success" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Besoins Caloriques Sportifs</h5>
                                        <span class="badge bg-primary ms-2">Avancé</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Adaptation des besoins énergétiques selon l'activité physique, les objectifs et la périodisation. 
                                        Calculs personnalisés pour maintenir performance et santé optimales.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">Accéder à l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>6-10 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Calculateur Hydratation -->
            <div class="col-lg-6">
                <a href="{{ route('tools.hydratation') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="fas fa-tint text-info" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0 text-dark fw-bold">Calculateur Hydratation</h5>
                                        <span class="badge bg-success ms-2">Essentiel</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Besoins hydriques personnalisés selon l'environnement, l'activité et les caractéristiques individuelles. 
                                        Stratégies d'hydratation pré, pendant et post-effort evidence-based.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">Accéder à l'outil →</small>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <small>3-5 min</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Navigation -->
        <div class="row g-3 mt-5">
            <div class="col-md-6">
                <a href="{{ route('tools.index') }}" class="btn btn-outline-success btn-lg w-100">
                    <i class="fas fa-arrow-left me-2"></i>Retour aux Catégories
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tools.category.cardiac') }}" class="btn btn-success btn-lg w-100">
                    Performance Cardiaque <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Message important nutrition responsable -->
<section class="py-4 bg-warning">
    <div class="container">
        <div class="alert alert-dark border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-shield-alt fa-2x text-dark"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2">Approche Nutrition Responsable</h6>
                    <p class="mb-0 small">
                        Nos outils visent à optimiser la performance et la santé, non à promouvoir des restrictions alimentaires. 
                        <strong>Une nutrition équilibrée et adaptée à vos besoins est essentielle.</strong> 
                        Consultez un nutritionniste du sport pour un accompagnement personnalisé, particulièrement si vous avez des objectifs spécifiques 
                        ou des préoccupations concernant votre relation à l'alimentation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu éducatif -->
<section class="py-5">
    <div class="container">
        
        <!-- Principes nutrition sportive -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-lightbulb me-2"></i>
                    Principes de la Nutrition Sportive Evidence-Based
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">Fondamentaux Énergétiques</h6>
                        <p class="small">
                            La nutrition sportive repose sur l'équilibre entre apports et dépenses énergétiques, 
                            l'optimisation de la composition corporelle et la maximisation de la performance. 
                            Elle vise le maintien de la santé globale avant tout.
                        </p>
                        
                        <h6 class="text-primary mt-3">Périodisation Nutritionnelle</h6>
                        <p class="small">
                            L'adaptation des apports selon les phases d'entraînement (volume, intensité, récupération) 
                            optimise les adaptations physiologiques et la progression. Cette approche respecte 
                            les besoins variables du corps selon la charge d'entraînement.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Individualisation</h6>
                        <p class="small">
                            Chaque individu a des besoins nutritionnels uniques selon sa génétique, son métabolisme, 
                            ses préférences alimentaires et son mode de vie. Les recommandations générales servent 
                            de point de départ, non de prescriptions rigides.
                        </p>
                        
                        <h6 class="text-info mt-3">Approche Holistique</h6>
                        <p class="small">
                            La nutrition sportive intègre performance, santé, plaisir alimentaire et durabilité. 
                            Une approche équilibrée favorise l'adhésion long terme et prévient les comportements 
                            alimentaires dysfonctionnels.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Macronutriments et timing -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-2">
                    <i class="fas fa-chart-pie me-2"></i>
                    Macronutriments et Timing Nutritionnel
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-bread-slice me-2"></i>Glucides
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2">
                                    <strong>Rôle :</strong> Carburant principal muscles et cerveau
                                </p>
                                <p class="small mb-2">
                                    <strong>Besoins sportifs :</strong> 5-12g/kg selon intensité
                                </p>
                                <p class="small mb-2">
                                    <strong>Timing optimal :</strong> Pré/pendant/post effort
                                </p>
                                <p class="small mb-0">
                                    <strong>Sources :</strong> Céréales complètes, fruits, légumes
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-drumstick-bite me-2"></i>Protéines
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2">
                                    <strong>Rôle :</strong> Construction, réparation, récupération
                                </p>
                                <p class="small mb-2">
                                    <strong>Besoins sportifs :</strong> 1.2-2.0g/kg selon discipline
                                </p>
                                <p class="small mb-2">
                                    <strong>Timing optimal :</strong> Post-effort et répartition journalière
                                </p>
                                <p class="small mb-0">
                                    <strong>Sources :</strong> Viandes, poissons, légumineuses, produits laitiers
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-seedling me-2"></i>Lipides
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2">
                                    <strong>Rôle :</strong> Énergie, hormones, vitamines liposolubles
                                </p>
                                <p class="small mb-2">
                                    <strong>Besoins sportifs :</strong> 20-35% apports énergétiques
                                </p>
                                <p class="small mb-2">
                                    <strong>Timing optimal :</strong> Distance des séances intenses
                                </p>
                                <p class="small mb-0">
                                    <strong>Sources :</strong> Huiles, oléagineux, poissons gras, avocat
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hydratation stratégies -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-tint me-2"></i>
                    Stratégies d'Hydratation Sportive
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info">Physiologie de l'Hydratation</h6>
                        <p class="small">
                            L'eau représente 50-70% du poids corporel et joue un rôle crucial dans la thermorégulation, 
                            le transport des nutriments et l'élimination des déchets métaboliques. 
                            Une déshydratation de 2% peut réduire la performance de 10-15%.
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>Objectif</th>
                                        <th>Stratégie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pré-effort</td>
                                        <td>Optimiser statut hydrique</td>
                                        <td>400-600ml 2-3h avant</td>
                                    </tr>
                                    <tr>
                                        <td>Pendant effort</td>
                                        <td>Maintenir équilibre</td>
                                        <td>150-250ml/15-20min</td>
                                    </tr>
                                    <tr>
                                        <td>Post-effort</td>
                                        <td>Restaurer déficit</td>
                                        <td>150% pertes hydriques</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Facteurs Individuels</h6>
                        <ul class="small">
                            <li><strong>Taux de sudation :</strong> Variable selon individu (0.5-3L/h)</li>
                            <li><strong>Composition sueur :</strong> Sodium 200-700mg/L</li>
                            <li><strong>Conditions environnementales :</strong> Température, humidité, altitude</li>
                            <li><strong>Intensité effort :</strong> Plus intense = besoins supérieurs</li>
                            <li><strong>Acclimatation :</strong> Adaptation progressive aux conditions</li>
                        </ul>
                        
                        <div class="alert alert-warning alert-sm mt-3">
                            <h6 class="small">Signaux d'Alarme Déshydratation</h6>
                            <p class="small mb-0">
                                Soif intense, urine foncée, fatigue marquée, crampes, nausées, 
                                diminution performance. <strong>L'hyperhydratation est également dangereuse</strong> 
                                (hyponatrémie).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supplémentation evidence-based -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-pills me-2"></i>
                    Supplémentation Sportive Evidence-Based
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Principe Fondamental</h6>
                    <p class="mb-0 small">
                        La supplémentation ne doit jamais remplacer une alimentation équilibrée. 
                        Elle peut être utile dans des contextes spécifiques mais nécessite une évaluation individuelle. 
                        <strong>Consultez un professionnel de santé avant toute supplémentation.</strong>
                    </p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">Suppléments à Efficacité Démontrée</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Supplément</th>
                                        <th>Bénéfice</th>
                                        <th>Dosage</th>
                                        <th>Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Créatine</td>
                                        <td>Puissance, force</td>
                                        <td>3-5g/jour</td>
                                        <td>Quotidien</td>
                                    </tr>
                                    <tr>
                                        <td>Caféine</td>
                                        <td>Endurance, focus</td>
                                        <td>3-6mg/kg</td>
                                        <td>30-60min pré-effort</td>
                                    </tr>
                                    <tr>
                                        <td>Bêta-alanine</td>
                                        <td>Tampon lactique</td>
                                        <td>3-5g/jour</td>
                                        <td>Divisé en prises</td>
                                    </tr>
                                    <tr>
                                        <td>Nitrates</td>
                                        <td>Efficacité O2</td>
                                        <td>5-9mmol</td>
                                        <td>2-3h pré-effort</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Précautions et Recommandations</h6>
                        <ul class="small">
                            <li><strong>Sécurité d'abord :</strong> Vérifier absence de contre-indications médicales</li>
                            <li><strong>Qualité produits :</strong> Choisir marques certifiées anti-dopage</li>
                            <li><strong>Progressivité :</strong> Tester en entraînement, jamais en compétition</li>
                            <li><strong>Individualisation :</strong> Réponses variables selon les personnes</li>
                            <li><strong>Surveillance :</strong> Monitoring effets et ajustements nécessaires</li>
                        </ul>
                        
                        <div class="alert alert-danger alert-sm mt-3">
                            <h6 class="small">Suppléments à Éviter ou Questionner</h6>
                            <p class="small mb-0">
                                Brûleurs de graisse, détox, méga-doses vitamines, produits non réglementés. 
                                <strong>Méfiez-vous des promesses miraculeuses</strong> et privilégiez toujours 
                                l'approche nutritionnelle complète.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section développement responsable -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-heart me-2"></i>
                    Nutrition et Relation Saine à l'Alimentation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">Signaux d'Alarme à Surveiller</h6>
                        <ul class="small">
                            <li>Obsession du calcul calorique ou des macronutriments</li>
                            <li>Restriction alimentaire sévère ou évitement de groupes d'aliments</li>
                            <li>Culpabilité intense après avoir mangé certains aliments</li>
                            <li>Isolation sociale liée aux contraintes alimentaires</li>
                            <li>Fatigue chronique, irritabilité, troubles du sommeil</li>
                            <li>Perte de plaisir alimentaire ou peur de manger</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Approche Équilibrée Recommandée</h6>
                        <ul class="small">
                            <li>Flexibilité et adaptation selon les situations</li>
                            <li>Plaisir alimentaire et convivialité préservés</li>
                            <li>Écoute des signaux de faim et satiété</li>
                            <li>Variété alimentaire et découverte de nouveaux goûts</li>
                            <li>Objectifs réalistes et progression graduelle</li>
                            <li>Soutien professionnel si nécessaire</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-hands-helping me-2"></i>Ressources et Soutien</h6>
                    <p class="mb-0 small">
                        Si vous ressentez des difficultés avec votre relation à l'alimentation, 
                        n'hésitez pas à consulter un nutritionniste du sport, un diététicien ou un psychologue spécialisé. 
                        <strong>Votre bien-être global prime toujours sur la performance sportive.</strong> 
                        Une approche nutritionnelle saine et durable favorise à la fois la santé et la performance à long terme.
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