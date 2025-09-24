@extends('layouts.public')

@section('title', 'Outils Performance Cardiaque & Zones d\'Entraînement - Physiologie Evidence-Based')
@section('meta_description', 'Outils scientifiques pour optimiser votre entraînement cardiaque : zones d\'entraînement personnalisÃ©es et cohÃ©rence cardiaque. Approche physiologique sÃ©curisÃ©e et evidence-based.')

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
                    Outils basÃ©s sur la recherche en cardiologie du sport et la variabilitÃ© cardiaque pour un entraînement sÃ©curisÃ© et efficace.
                </p>
                <div class="alert alert-warning border-0 bg-white bg-opacity-25">
                    <small>
                        <i class="fas fa-stethoscope me-2"></i>
                        <strong>2 outils disponibles</strong> - Approche mÃ©dicale sÃ©curisÃ©e et personnalisÃ©e
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

<!-- Avertissement mÃ©dical important -->
<section class="py-4 bg-warning">
    <div class="container">
        <div class="alert alert-dark border-0 mb-0">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="fas fa-user-md fa-2x text-dark"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="fw-bold mb-2">Avertissement MÃ©dical Important</h6>
                    <p class="mb-0 small">
                        <strong>L'entraînement cardiaque nÃ©cessite une approche prudente et personnalisÃ©e.</strong> 
                        Consultez un mÃ©decin du sport avant de dÃ©buter tout programme d'entraînement intensif, 
                        particuliÃ¨rement si vous avez des antÃ©cÃ©dents cardiovasculaires, ressentez des douleurs thoraciques, 
                        des palpitations ou tout symptôme inhabituel. Ces outils ne remplacent pas un suivi mÃ©dical professionnel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Outils de la catÃ©gorie -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            
            <!-- 1. Zones Cardiaques AvancÃ©es -->
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
                                        <h5 class="card-title mb-0 text-dark fw-bold">Zones Cardiaques AvancÃ©es</h5>
                                        <span class="badge bg-warning ms-2">Pro</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Calcul personnalisÃ© des zones d'entraînement avec 6 formules FC max validÃ©es scientifiquement. 
                                        IntÃ©gration FC repos, HRV et adaptation individuelle pour optimisation sÃ©curisÃ©e de l'entraînement.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
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

            <!-- 2. CohÃ©rence Cardiaque -->
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
                                        <h5 class="card-title mb-0 text-dark fw-bold">CohÃ©rence Cardiaque</h5>
                                        <span class="badge bg-info ms-2">Bien-être</span>
                                    </div>
                                    <p class="card-text text-muted mb-3">
                                        Simulateur et guide de pratique cohÃ©rence cardiaque pour gestion du stress, 
                                        rÃ©cupÃ©ration et optimisation du systÃ¨me nerveux autonome. Technique validÃ©e scientifiquement.
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-primary fw-semibold">AccÃ©der Ã l'outil →</small>
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
                    <i class="fas fa-arrow-left me-2"></i>Nutrition & Ã©nergie
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

<!-- Contenu Ã©ducatif -->
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
                            Le cœur est une pompe musculaire qui s'adapte remarquablement Ã l'entraînement. 
                            La frÃ©quence cardiaque (FC) reflÃ¨te l'intensitÃ© de l'effort et permet de quantifier 
                            la charge cardiovasculaire. L'adaptation cardiaque se manifeste par une baisse 
                            de la FC de repos et une amÃ©lioration de l'efficacitÃ© de pompage.
                        </p>
                        
                        <h6 class="text-primary mt-3">Adaptations Ã l'Entraînement</h6>
                        <ul class="small">
                            <li><strong>Bradycardie de repos :</strong> FC repos diminuÃ©e (athlÃ¨tes 40-60 bpm)</li>
                            <li><strong>Volume d'Ã©jection :</strong> Augmentation du volume sanguin Ã©jectÃ©</li>
                            <li><strong>DÃ©bit cardiaque :</strong> Optimisation efficacitÃ© Ã©nergÃ©tique</li>
                            <li><strong>RÃ©cupÃ©ration :</strong> Retour plus rapide Ã la FC basale</li>
                            <li><strong>VariabilitÃ© :</strong> AmÃ©lioration HRV (Heart Rate Variability)</li>
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
                                        <th>MÃ©tabolisme</th>
                                        <th>Adaptations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td>Zone 1</td>
                                        <td>50-60%</td>
                                        <td>AÃ©robie facile</td>
                                        <td>RÃ©cupÃ©ration active</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Zone 2</td>
                                        <td>60-70%</td>
                                        <td>AÃ©robie base</td>
                                        <td>Endurance fondamentale</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Zone 3</td>
                                        <td>70-80%</td>
                                        <td>AÃ©robie intensif</td>
                                        <td>Seuil aÃ©robie</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Zone 4</td>
                                        <td>80-90%</td>
                                        <td>Seuil lactique</td>
                                        <td>Puissance mÃ©tabolique</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Zone 5</td>
                                        <td>90-100%</td>
                                        <td>AnaÃ©robie</td>
                                        <td>VO2 max, puissance</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-warning alert-sm mt-3">
                            <h6 class="small">Principe de SpÃ©cificitÃ©</h6>
                            <p class="small mb-0">
                                Chaque zone dÃ©veloppe des adaptations spÃ©cifiques. Un entraînement 
                                Ã©quilibrÃ© utilise toutes les zones selon la pÃ©riodisation et les objectifs.
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
                        <h6 class="text-primary">Formules FC Max ValidÃ©es</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Formule</th>
                                        <th>Ã©quation</th>
                                        <th>Population</th>
                                        <th>PrÃ©cision</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Astrand</td>
                                        <td>220 - âge</td>
                                        <td>GÃ©nÃ©rale</td>
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
                                        <td>AthlÃ¨tes</td>
                                        <td>±7 bpm</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Test d'Effort - Gold Standard</h6>
                            <p class="small mb-0">
                                Le test d'effort maximal en laboratoire reste la mÃ©thode de rÃ©fÃ©rence 
                                pour dÃ©terminer la FC max rÃ©elle. Les formules donnent des estimations.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Facteurs de Personnalisation</h6>
                        <ul class="small">
                            <li><strong>GÃ©nÃ©tique :</strong> VariabilitÃ© individuelle importante (±15-20 bpm)</li>
                            <li><strong>Condition physique :</strong> AthlÃ¨tes vs sÃ©dentaires</li>
                            <li><strong>Discipline sportive :</strong> SpÃ©cificitÃ©s mÃ©taboliques</li>
                            <li><strong>Environnement :</strong> Altitude, tempÃ©rature, humiditÃ©</li>
                            <li><strong>Ã©tat de forme :</strong> Fatigue, stress, maladie</li>
                            <li><strong>MÃ©dication :</strong> Bêta-bloquants, stimulants</li>
                        </ul>
                        
                        <h6 class="text-warning mt-3">FC de RÃ©serve (Karvonen)</h6>
                        <p class="small">
                            MÃ©thode plus prÃ©cise utilisant FC repos : 
                            <strong>Zone = [(FC max - FC repos) × %intensitÃ©] + FC repos</strong>
                        </p>
                        
                        <div class="alert alert-success alert-sm">
                            <h6 class="small">Monitoring Continue</h6>
                            <p class="small mb-0">
                                La FC de repos matinale est un excellent indicateur de rÃ©cupÃ©ration 
                                et d'adaptation. Une Ã©lÃ©vation persistante peut signaler fatigue ou maladie.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CohÃ©rence cardiaque et HRV -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-2">
                    <i class="fas fa-wave-square me-2"></i>
                    CohÃ©rence Cardiaque et VariabilitÃ©
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-info">Qu'est-ce que la CohÃ©rence Cardiaque ?</h6>
                        <p class="small">
                            La cohÃ©rence cardiaque est un Ã©tat physiologique où le rythme cardiaque, 
                            la respiration et la pression artÃ©rielle se synchronisent naturellement. 
                            Cette pratique respiratoire (5 secondes inspiration, 5 secondes expiration) 
                            optimise le systÃ¨me nerveux autonome et favorise l'Ã©quilibre sympathique-parasympathique.
                        </p>
                        
                        <h6 class="text-success mt-3">BÃ©nÃ©fices Scientifiquement DÃ©montrÃ©s</h6>
                        <ul class="small">
                            <li><strong>Gestion du stress :</strong> RÃ©duction cortisol et anxiÃ©tÃ©</li>
                            <li><strong>RÃ©cupÃ©ration :</strong> Activation parasympathique accÃ©lÃ©rÃ©e</li>
                            <li><strong>Performance cognitive :</strong> AmÃ©lioration focus et concentration</li>
                            <li><strong>SantÃ© cardiovasculaire :</strong> AmÃ©lioration HRV et pression artÃ©rielle</li>
                            <li><strong>Sommeil :</strong> QualitÃ© et efficacitÃ© du sommeil amÃ©liorÃ©es</li>
                            <li><strong>RÃ©gulation Ã©motionnelle :</strong> Meilleure gestion des Ã©motions</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Protocole de Pratique</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Phase</th>
                                        <th>DurÃ©e</th>
                                        <th>FrÃ©quence</th>
                                        <th>Timing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Initiation</td>
                                        <td>3-5 min</td>
                                        <td>2-3×/jour</td>
                                        <td>Matin, aprÃ¨s-midi, soir</td>
                                    </tr>
                                    <tr>
                                        <td>DÃ©veloppement</td>
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
                                        <td>Situations spÃ©ciales</td>
                                        <td>3-5 min</td>
                                        <td>Ã la demande</td>
                                        <td>Stress, prÃ©-compÃ©tition</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-primary alert-sm">
                            <h6 class="small">Technique de Base</h6>
                            <p class="small mb-0">
                                <strong>Respiration 5-5 :</strong> 5 secondes inspiration, 5 secondes expiration, 
                                soit 6 cycles par minute. Position confortable, attention sur le cœur, 
                                respiration abdominale douce et rÃ©guliÃ¨re.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PrÃ©vention et sÃ©curitÃ© -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt me-2"></i>
                    SÃ©curitÃ© et PrÃ©vention en Entraînement Cardiaque
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">Signaux d'Alarme Ã Surveiller</h6>
                        <ul class="small">
                            <li><strong>Douleur thoracique :</strong> Pendant ou aprÃ¨s l'effort</li>
                            <li><strong>Essoufflement excessif :</strong> DisproportionnÃ© Ã l'effort</li>
                            <li><strong>Palpitations :</strong> Rythme irrÃ©gulier ou trÃ¨s rapide</li>
                            <li><strong>Vertiges/malaises :</strong> Pendant ou aprÃ¨s l'exercice</li>
                            <li><strong>Fatigue inhabituelle :</strong> Persistante malgrÃ© le repos</li>
                            <li><strong>FC anormale :</strong> TrÃ¨s Ã©levÃ©e au repos ou qui ne descend pas</li>
                        </ul>
                        
                        <div class="alert alert-danger alert-sm">
                            <h6 class="small">Action ImmÃ©diate Requise</h6>
                            <p class="small mb-0">
                                En cas de douleur thoracique, malaise, ou tout symptôme cardiaque suspect : 
                                <strong>arrêt immÃ©diat de l'activitÃ© et consultation mÃ©dicale urgente.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Bonnes Pratiques de SÃ©curitÃ©</h6>
                        <ul class="small">
                            <li><strong>Ã©chauffement progressif :</strong> 10-15 minutes minimum</li>
                            <li><strong>Progression graduelle :</strong> Augmentation 10% max/semaine</li>
                            <li><strong>Hydratation adequate :</strong> Avant, pendant, aprÃ¨s effort</li>
                            <li><strong>RÃ©cupÃ©ration surveillÃ©e :</strong> FC doit descendre normalement</li>
                            <li><strong>Ã©coute corporelle :</strong> Respecter fatigue et signaux</li>
                            <li><strong>Suivi mÃ©dical :</strong> Bilan cardiologique rÃ©gulier</li>
                        </ul>
                        
                        <h6 class="text-primary mt-3">Populations Ã Risque</h6>
                        <p class="small">
                            Hommes >45 ans, femmes >55 ans, antÃ©cÃ©dents familiaux, hypertension, 
                            diabÃ¨te, obÃ©sitÃ©, tabagisme nÃ©cessitent un suivi mÃ©dical renforcÃ© 
                            avant tout programme d'entraînement intensif.
                        </p>
                        
                        <div class="alert alert-info alert-sm">
                            <h6 class="small">Test d'Effort RecommandÃ©</h6>
                            <p class="small mb-0">
                                Un test d'effort sous surveillance mÃ©dicale est recommandÃ© pour Ã©valuer 
                                la rÃ©ponse cardiaque Ã l'exercice et dÃ©tecter d'Ã©ventuelles anomalies.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h6><i class="fas fa-stethoscope me-2"></i>Rappel Important</h6>
                    <p class="mb-0 small">
                        L'entraînement cardiaque doit toujours privilÃ©gier la sÃ©curitÃ© et la progression graduelle. 
                        <strong>Aucun objectif de performance ne justifie de prendre des risques pour sa santÃ©.</strong> 
                        En cas de doute, consultez toujours un professionnel de santÃ© qualifiÃ©. 
                        Ces outils sont des aides Ã l'entraînement, non des substituts Ã l'accompagnement mÃ©dical.
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

.table-success, .table-info, .table-primary, .table-warning, .table-danger {
    --bs-table-accent-bg: var(--bs-table-bg);
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