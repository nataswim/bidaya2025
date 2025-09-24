@extends('layouts.public')

@section('title', 'Outils Nutrition & Ã©nergie Sportive - Calculateurs Evidence-Based')
@section('meta_description', 'Outils scientifiques pour optimiser votre nutrition sportive : conversion calories-macros, besoins Ã©nergÃ©tiques personnalisÃ©s, hydratation. Approche Ã©quilibrÃ©e et evidence-based.')

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
                    Nutrition & Ã©nergie
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-apple-alt me-3"></i>
                    Nutrition & Ã©nergie Sportive
                </h1>
                <p class="lead mb-4">
                    Optimisez votre nutrition sportive avec une approche scientifique Ã©quilibrÃ©e. 
                    Outils basÃ©s sur les recommandations nutritionnelles internationales et la physiologie Ã©nergÃ©tique.
                </p>
                <div class="alert alert-warning border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>3 outils disponibles</strong> - Approche Ã©quilibrÃ©e et santÃ©-centrÃ©e
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

<!-- Outils de la catÃ©gorie -->
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
                                        Calculs Ã©nergÃ©tiques prÃ©cis et rÃ©partition macronutriments adaptÃ©e aux objectifs sportifs. 
                                        Multiple stratÃ©gies nutritionnelles evidence-based pour optimiser performance et rÃ©cupÃ©ration.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
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
                                        <span class="badge bg-primary ms-2">AvancÃ©</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Adaptation des besoins Ã©nergÃ©tiques selon l'activitÃ© physique, les objectifs et la pÃ©riodisation. 
                                        Calculs personnalisÃ©s pour maintenir performance et santÃ© optimales.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
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
                                        Besoins hydriques personnalisÃ©s selon l'environnement, l'activitÃ© et les caractÃ©ristiques individuelles. 
                                        StratÃ©gies d'hydratation prÃ©, pendant et post-effort evidence-based.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
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
                    <i class="fas fa-arrow-left me-2"></i>Retour aux CatÃ©gories
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
                        Nos outils visent Ã optimiser la performance et la santÃ©, non Ã promouvoir des restrictions alimentaires. 
                        <strong>Une nutrition Ã©quilibrÃ©e et adaptÃ©e Ã vos besoins est essentielle.</strong> 
                        Consultez un nutritionniste du sport pour un accompagnement personnalisÃ©, particuliÃ¨rement si vous avez des objectifs spÃ©cifiques 
                        ou des prÃ©occupations concernant votre relation Ã l'alimentation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contenu Ã©ducatif -->
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
                        <h6 class="text-success">Fondamentaux Ã©nergÃ©tiques</h6>
                        <p class="small">
                            La nutrition sportive repose sur l'Ã©quilibre entre apports et dÃ©penses Ã©nergÃ©tiques, 
                            l'optimisation de la composition corporelle et la maximisation de la performance. 
                            Elle vise le maintien de la santÃ© globale avant tout.
                        </p>
                        
                        <h6 class="text-primary mt-3">PÃ©riodisation Nutritionnelle</h6>
                        <p class="small">
                            L'adaptation des apports selon les phases d'entraînement (volume, intensitÃ©, rÃ©cupÃ©ration) 
                            optimise les adaptations physiologiques et la progression. Cette approche respecte 
                            les besoins variables du corps selon la charge d'entraînement.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Individualisation</h6>
                        <p class="small">
                            Chaque individu a des besoins nutritionnels uniques selon sa gÃ©nÃ©tique, son mÃ©tabolisme, 
                            ses prÃ©fÃ©rences alimentaires et son mode de vie. Les recommandations gÃ©nÃ©rales servent 
                            de point de dÃ©part, non de prescriptions rigides.
                        </p>
                        
                        <h6 class="text-info mt-3">Approche Holistique</h6>
                        <p class="small">
                            La nutrition sportive intÃ¨gre performance, santÃ©, plaisir alimentaire et durabilitÃ©. 
                            Une approche Ã©quilibrÃ©e favorise l'adhÃ©sion long terme et prÃ©vient les comportements 
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
                                    <strong>Besoins sportifs :</strong> 5-12g/kg selon intensitÃ©
                                </p>
                                <p class="small mb-2">
                                    <strong>Timing optimal :</strong> PrÃ©/pendant/post effort
                                </p>
                                <p class="small mb-0">
                                    <strong>Sources :</strong> CÃ©rÃ©ales complÃ¨tes, fruits, lÃ©gumes
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-drumstick-bite me-2"></i>ProtÃ©ines
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2">
                                    <strong>Rôle :</strong> Construction, rÃ©paration, rÃ©cupÃ©ration
                                </p>
                                <p class="small mb-2">
                                    <strong>Besoins sportifs :</strong> 1.2-2.0g/kg selon discipline
                                </p>
                                <p class="small mb-2">
                                    <strong>Timing optimal :</strong> Post-effort et rÃ©partition journaliÃ¨re
                                </p>
                                <p class="small mb-0">
                                    <strong>Sources :</strong> Viandes, poissons, lÃ©gumineuses, produits laitiers
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
                                    <strong>Rôle :</strong> Ã©nergie, hormones, vitamines liposolubles
                                </p>
                                <p class="small mb-2">
                                    <strong>Besoins sportifs :</strong> 20-35% apports Ã©nergÃ©tiques
                                </p>
                                <p class="small mb-2">
                                    <strong>Timing optimal :</strong> Distance des sÃ©ances intenses
                                </p>
                                <p class="small mb-0">
                                    <strong>Sources :</strong> Huiles, olÃ©agineux, poissons gras, avocat
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hydratation stratÃ©gies -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-tint me-2"></i>
                    StratÃ©gies d'Hydratation Sportive
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info">Physiologie de l'Hydratation</h6>
                        <p class="small">
                            L'eau reprÃ©sente 50-70% du poids corporel et joue un rôle crucial dans la thermorÃ©gulation, 
                            le transport des nutriments et l'Ã©limination des dÃ©chets mÃ©taboliques. 
                            Une dÃ©shydratation de 2% peut rÃ©duire la performance de 10-15%.
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>Objectif</th>
                                        <th>StratÃ©gie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>PrÃ©-effort</td>
                                        <td>Optimiser statut hydrique</td>
                                        <td>400-600ml 2-3h avant</td>
                                    </tr>
                                    <tr>
                                        <td>Pendant effort</td>
                                        <td>Maintenir Ã©quilibre</td>
                                        <td>150-250ml/15-20min</td>
                                    </tr>
                                    <tr>
                                        <td>Post-effort</td>
                                        <td>Restaurer dÃ©ficit</td>
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
                            <li><strong>Conditions environnementales :</strong> TempÃ©rature, humiditÃ©, altitude</li>
                            <li><strong>IntensitÃ© effort :</strong> Plus intense = besoins supÃ©rieurs</li>
                            <li><strong>Acclimatation :</strong> Adaptation progressive aux conditions</li>
                        </ul>
                        
                        <div class="alert alert-warning alert-sm mt-3">
                            <h6 class="small">Signaux d'Alarme DÃ©shydratation</h6>
                            <p class="small mb-0">
                                Soif intense, urine foncÃ©e, fatigue marquÃ©e, crampes, nausÃ©es, 
                                diminution performance. <strong>L'hyperhydratation est Ã©galement dangereuse</strong> 
                                (hyponatrÃ©mie).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SupplÃ©mentation evidence-based -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-pills me-2"></i>
                    SupplÃ©mentation Sportive Evidence-Based
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Principe Fondamental</h6>
                    <p class="mb-0 small">
                        La supplÃ©mentation ne doit jamais remplacer une alimentation Ã©quilibrÃ©e. 
                        Elle peut être utile dans des contextes spÃ©cifiques mais nÃ©cessite une Ã©valuation individuelle. 
                        <strong>Consultez un professionnel de santÃ© avant toute supplÃ©mentation.</strong>
                    </p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">SupplÃ©ments Ã EfficacitÃ© DÃ©montrÃ©e</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>SupplÃ©ment</th>
                                        <th>BÃ©nÃ©fice</th>
                                        <th>Dosage</th>
                                        <th>Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CrÃ©atine</td>
                                        <td>Puissance, force</td>
                                        <td>3-5g/jour</td>
                                        <td>Quotidien</td>
                                    </tr>
                                    <tr>
                                        <td>CafÃ©ine</td>
                                        <td>Endurance, focus</td>
                                        <td>3-6mg/kg</td>
                                        <td>30-60min prÃ©-effort</td>
                                    </tr>
                                    <tr>
                                        <td>Bêta-alanine</td>
                                        <td>Tampon lactique</td>
                                        <td>3-5g/jour</td>
                                        <td>DivisÃ© en prises</td>
                                    </tr>
                                    <tr>
                                        <td>Nitrates</td>
                                        <td>EfficacitÃ© O2</td>
                                        <td>5-9mmol</td>
                                        <td>2-3h prÃ©-effort</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">PrÃ©cautions et Recommandations</h6>
                        <ul class="small">
                            <li><strong>SÃ©curitÃ© d'abord :</strong> VÃ©rifier absence de contre-indications mÃ©dicales</li>
                            <li><strong>QualitÃ© produits :</strong> Choisir marques certifiÃ©es anti-dopage</li>
                            <li><strong>ProgressivitÃ© :</strong> Tester en entraînement, jamais en compÃ©tition</li>
                            <li><strong>Individualisation :</strong> RÃ©ponses variables selon les personnes</li>
                            <li><strong>Surveillance :</strong> Monitoring effets et ajustements nÃ©cessaires</li>
                        </ul>
                        
                        <div class="alert alert-danger alert-sm mt-3">
                            <h6 class="small">SupplÃ©ments Ã Ã©viter ou Questionner</h6>
                            <p class="small mb-0">
                                Brûleurs de graisse, dÃ©tox, mÃ©ga-doses vitamines, produits non rÃ©glementÃ©s. 
                                <strong>MÃ©fiez-vous des promesses miraculeuses</strong> et privilÃ©giez toujours 
                                l'approche nutritionnelle complÃ¨te.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section dÃ©veloppement responsable -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-2">
                    <i class="fas fa-heart me-2"></i>
                    Nutrition et Relation Saine Ã l'Alimentation
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-success">Signaux d'Alarme Ã Surveiller</h6>
                        <ul class="small">
                            <li>Obsession du calcul calorique ou des macronutriments</li>
                            <li>Restriction alimentaire sÃ©vÃ¨re ou Ã©vitement de groupes d'aliments</li>
                            <li>CulpabilitÃ© intense aprÃ¨s avoir mangÃ© certains aliments</li>
                            <li>Isolation sociale liÃ©e aux contraintes alimentaires</li>
                            <li>Fatigue chronique, irritabilitÃ©, troubles du sommeil</li>
                            <li>Perte de plaisir alimentaire ou peur de manger</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Approche Ã©quilibrÃ©e RecommandÃ©e</h6>
                        <ul class="small">
                            <li>FlexibilitÃ© et adaptation selon les situations</li>
                            <li>Plaisir alimentaire et convivialitÃ© prÃ©servÃ©s</li>
                            <li>Ã©coute des signaux de faim et satiÃ©tÃ©</li>
                            <li>VariÃ©tÃ© alimentaire et dÃ©couverte de nouveaux goûts</li>
                            <li>Objectifs rÃ©alistes et progression graduelle</li>
                            <li>Soutien professionnel si nÃ©cessaire</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-hands-helping me-2"></i>Ressources et Soutien</h6>
                    <p class="mb-0 small">
                        Si vous ressentez des difficultÃ©s avec votre relation Ã l'alimentation, 
                        n'hÃ©sitez pas Ã consulter un nutritionniste du sport, un diÃ©tÃ©ticien ou un psychologue spÃ©cialisÃ©. 
                        <strong>Votre bien-être global prime toujours sur la performance sportive.</strong> 
                        Une approche nutritionnelle saine et durable favorise Ã la fois la santÃ© et la performance Ã long terme.
                    </p>
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
    // Animation d'entrÃ©e pour les cards
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