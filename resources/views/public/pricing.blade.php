@extends('layouts.public')

@section('title', 'Plans d\'inscription')

@section('content')

<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-4">Inscription</h1>
                <p class="lead mb-0">
                    Choisissez la durée qui vous convient et accédez à la totalité des services
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 200px; height: 200px;">
                    <i class="fas fa-star" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans d'inscription -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <p class="lead mb-4">
                    Choisissez la durée qui vous convient : 12 / 6 / 3 mois, et accédez à la totalité des services 
                    sans dépenser davantage.
                </p>
            </div>
        </div>

        <div class="row g-4 justify-content-center mb-5">
            <!-- Plan 12 mois -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 border-primary shadow">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <span class="badge bg-white text-primary">Meilleure valeur</span>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-swimmer text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h2 class="card-title h3 mb-2">12 mois</h2>
                        <p class="text-muted mb-3">
                            Accès complet à tous les services pendant une année complète.
                        </p>
                        <div class="mb-3">
                            <span class="text-muted me-2" style="font-weight: bold;"> 8€ par mois = 96€</span>
                        </div>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Paiement unique non récurrent</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Pas de Renouvellement Automatique</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Accès illimité à toutes les ressources</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Support prioritaire</span>
                            </li>
                        </ul>
                        <!-- Plan 12 mois -->
<a href="https://buy.stripe.com/dRm28r5AOfEDaHn0JxgnK02" 
   class="btn btn-success btn-lg w-100"
   target="_blank">
    <i class="fas fa-credit-card me-2"></i>S'inscrire pour 12 mois
</a>

<div class="text-primary mb-3" style="font-size: 2.5rem;">
                            <i class="fab fa-paypal"></i>
                        </div>
<p class="text-muted mb-0">
                            S'inscrire avec Paypal.
                        </p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="WXXYSM9EF42ZN" />
  <input type="hidden" name="currency_code" value="EUR" />
  <input type="image" src="https://www.paypalobjects.com/fr_FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" title="PayPal, votre réflexe sécurité pour payer en ligne." alt="Acheter" />
</form>
                    </div>
                </article>
            </div>

            <!-- Plan 6 mois -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-tie text-warning" style="font-size: 2.5rem;"></i>
                        </div>
                        <h2 class="card-title h3 mb-2">6 mois</h2>
                        <p class="text-muted mb-3">
                            Solution intermédiaire avec tous les services pendant 6 mois.
                        </p>
                        <div class="mb-3">
                            <span class="text-muted me-2" style="font-weight: bold;"> 11€ par mois = 66€</span>
                        </div>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Paiement unique non récurrent</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Pas de Renouvellement Automatique</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Accès illimité à toutes les ressources</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Support standard</span>
                            </li>
                        </ul>
                        <!-- Plan 6 mois -->
<a href="https://buy.stripe.com/6oU9AT7IW8cbeXD1NBgnK01" 
   class="btn btn-outline-primary btn-lg w-100"
   target="_blank">
    <i class="fas fa-credit-card me-2"></i>S'inscrire pour 6 mois
</a>

<div class="text-primary mb-3" style="font-size: 2.5rem;">
                            <i class="fab fa-paypal"></i>
                        </div>
<p class="text-muted mb-0">
                            S'inscrire avec Paypal.
                        </p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="8UFX4YSD4G68G" />
  <input type="hidden" name="currency_code" value="EUR" />
  <input type="image" src="https://www.paypalobjects.com/fr_FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" title="PayPal, votre réflexe sécurité pour payer en ligne." alt="Acheter" />
</form>

                    </div>
                </article>
            </div>

            <!-- Plan 3 mois -->
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-swimmer text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                        <span class="text-muted me-2" style="font-weight: bold;"> 3 mois</h2>
                        <p class="text-muted mb-3">
                            Formule découverte avec tous les services pendant 3 mois.
                        </p>
                        <div class="mb-3">
                            <span class="text-muted me-2">15€ par mois = 45€</span>
                        </div>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Paiement unique non récurrent</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Pas de Renouvellement Automatique</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Accès illimité à toutes les ressources</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Support standard</span>
                            </li>
                        </ul>
                        <!-- Plan 3 mois -->
<a href="https://buy.stripe.com/6oUeVd9R478716NgIvgnK00" 
   class="btn btn-outline-primary btn-lg w-100"
   target="_blank">
    <i class="fas fa-credit-card me-2"></i>S'inscrire pour 3 mois
</a>
<div class="text-primary mb-3" style="font-size: 2.5rem;">
                            <i class="fab fa-paypal"></i>
                        </div>
<p class="text-muted mb-0">
                            S'inscrire avec Paypal.
                        </p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="FVB4LYV557SLY" />
  <input type="hidden" name="currency_code" value="EUR" />
  <input type="image" src="https://www.paypalobjects.com/fr_FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" title="PayPal, votre réflexe sécurité pour payer en ligne." alt="Acheter" />
</form>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Pourquoi Nataswim -->
<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3" style="font-size: 2.5rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Gagner du temps et de l'argent</h3>
                        <p class="text-muted mb-0">
                            Des ressources conçues pour optimiser votre progression et améliorer rapidement vos performances.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-lg-4 col-md-6">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3" style="font-size: 2.5rem;">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Souplesse et liberté d'utilisation</h3>
                        <p class="text-muted mb-0">
                            Accédez à nos contenus quand vous voulez, où vous voulez, selon votre propre rythme.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-lg-4 col-md-6">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3" style="font-size: 2.5rem;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Qualité professionnelle</h3>
                        <p class="text-muted mb-0">
                            Des contenus élaborés par des experts et professionnels reconnus dans le domaine sportif.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Ressources disponibles -->
<section class="py-5 bg-white">
    <div class="container-lg">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-4">Ressources disponibles</h2>
                <p class="lead">
                    Découvrez toutes les ressources qui vous attendent pour améliorer vos performances.
                </p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <article class="d-flex align-items-start">
                    <div class="text-primary me-3" style="font-size: 1.5rem;">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <h4 class="h6 fw-bold mb-2">Articles et Dossiers thématiques</h4>
                        <p class="text-muted mb-0">
                            Une bibliothèque complète d'articles de fond et dossiers spécialisés.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-lg-6">
                <article class="d-flex align-items-start">
                    <div class="text-primary me-3" style="font-size: 1.5rem;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h4 class="h6 fw-bold mb-2">Fiches d'entraînement par niveau</h4>
                        <p class="text-muted mb-0">
                            Des fiches d'exercices adaptées à tous les niveaux, du débutant au confirmé.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-lg-6">
                <article class="d-flex align-items-start">
                    <div class="text-primary me-3" style="font-size: 1.5rem;">
                        <i class="fas fa-download"></i>
                    </div>
                    <div>
                        <h4 class="h6 fw-bold mb-2">Documents téléchargeables</h4>
                        <p class="text-muted mb-0">
                            E-books, fiches techniques et documents spécifiques à télécharger.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-lg-6">
                <article class="d-flex align-items-start">
                    <div class="text-primary me-3" style="font-size: 1.5rem;">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div>
                        <h4 class="h6 fw-bold mb-2">Vidéos d'exercices</h4>
                        <p class="text-muted mb-0">
                            Bibliothèque de vidéos classées par domaine et spécialité, à visionner en ligne.
                        </p>
                    </div>
                </article>
            </div>

            <div class="col-lg-6">
                <article class="d-flex align-items-start">
                    <div class="text-primary me-3" style="font-size: 1.5rem;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h4 class="h6 fw-bold mb-2">Programmes et séances d'entraînement</h4>
                        <p class="text-muted mb-0">
                            Plans complets et séances détaillées pour structurer votre progression.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container-lg">
        <h2 class="mb-4 fw-bold">Des questions ?</h2>
        <p class="lead mb-4">
            N'hésitez pas à nous contacter ! Nous sommes là pour y répondre.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
            Contactez notre équipe !
        </a>
    </div>
</section>

@endsection