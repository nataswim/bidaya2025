@extends('layouts.public')

@section('title', 'Contact')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Contactez-nous</h1>
                <p class="lead mb-0">
                    Nous sommes lA pour repondre A vos questions, suggestions et commentaires. 
                    N'hesitez pas A nous ecrire !
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 150px; height: 150px;">
                    <i class="fas fa-envelope" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container-lg">
        <div class="row g-5">
            <!-- Formulaire -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-4">
                        <h3 class="mb-0">Envoyez-nous un message</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label fw-semibold">Prenom *</label>
                                    <input type="text" 
                                           name="first_name" 
                                           id="first_name" 
                                           class="form-control"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label fw-semibold">Nom *</label>
                                    <input type="text" 
                                           name="last_name" 
                                           id="last_name" 
                                           class="form-control"
                                           required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold">Email *</label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="form-control"
                                           required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label fw-semibold">Sujet *</label>
                                    <select name="subject" id="subject" class="form-select" required>
                                        <option value="">Choisir un sujet</option>
                                        <option value="question">Question generale</option>
                                        <option value="suggestion">Suggestion d'article</option>
                                        <option value="collaboration">Proposition de collaboration</option>
                                        <option value="technique">Support technique</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold">Message *</label>
                                    <textarea name="message" 
                                              id="message" 
                                              rows="6" 
                                              class="form-control"
                                              placeholder="Decrivez votre demande en detail..."
                                              required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               name="newsletter" 
                                               id="newsletter" 
                                               value="1"
                                               class="form-check-input">
                                        <label for="newsletter" class="form-check-label">
                                            J'aimerais recevoir la newsletter avec vos derniers articles
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informations contact -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0">Informations de contact</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Email</h6>
                                <p class="text-muted mb-0">contact@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}</p>
                                <small class="text-muted">Reponse sous 24h</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-map-marker-alt text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Localisation</h6>
                                <p class="text-muted mb-0">France</p>
                                <small class="text-muted">equipe distribuee</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-users text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Reseaux sociaux</h6>
                                <div class="d-flex gap-2 mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-4">
                        <h5 class="mb-0">Questions frequentes</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed border-0 bg-light" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#faq1">
                                        Puis-je proposer un article ?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Absolument ! Nous sommes toujours A la recherche de nouveaux contenus. 
                                        Contactez-nous avec votre idee.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed border-0 bg-light" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#faq2">
                                        Comment signaler un probleme ?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Utilisez le formulaire avec le sujet "Support technique" pour nous signaler 
                                        tout probleme rencontre.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection