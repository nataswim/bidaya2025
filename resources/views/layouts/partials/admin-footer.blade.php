<footer class="admin-footer bg-white border-top mt-5">
    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Colonne 1 : Sitemap -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading text-primary mb-3">
                    <i class="fas fa-sitemap me-2"></i>Sitemap
                </h6>
                <ul class="footer-links list-unstyled">
                    <li><a href="{{ route('admin.sitemap.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Gestion Sitemap
                    </a></li>
                    <li><a href="{{ route('admin.posts.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Articles SEO
                    </a></li>
                    <li><a href="{{ route('admin.fiches.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Fiches techniques
                    </a></li>
                    <li><a href="{{ route('admin.videos.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Vidéos
                    </a></li>
                    <li><a href="{{ route('admin.workouts.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Workouts
                    </a></li>
                </ul>
            </div>

            <!-- Colonne 2 : Utilisateurs -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading text-primary mb-3">
                    <i class="fas fa-users me-2"></i>Utilisateurs
                </h6>
                <ul class="footer-links list-unstyled">
                    <li><a href="{{ route('admin.users.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Gestion utilisateurs
                    </a></li>
                    <li><a href="{{ route('admin.roles.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Rôles & permissions
                    </a></li>
                    <li><a href="{{ route('admin.payments.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Paiements
                    </a></li>
                    <li><a href="{{ route('admin.profile.show') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Mon profil
                    </a></li>
                </ul>
            </div>

            <!-- Colonne 3 : eBooks -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading text-primary mb-3">
                    <i class="fas fa-book me-2"></i>eBooks & Ressources
                </h6>
                <ul class="footer-links list-unstyled">
                    <li><a href="{{ route('admin.downloadables.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Téléchargements
                    </a></li>
                    <li><a href="{{ route('admin.download-categories.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Catégories
                    </a></li>
                    <li><a href="{{ route('admin.ebook-files.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Fichiers eBook
                    </a></li>
                    <li><a href="{{ route('admin.media.index') }}" class="footer-link">
                        <i class="fas fa-angle-right me-2"></i>Médiathèque
                    </a></li>
                </ul>
            </div>

            <!-- Colonne 4 : Liens externes -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading text-primary mb-3">
                    <i class="fas fa-external-link-alt me-2"></i>Liens & Outils
                </h6>
                <ul class="footer-links list-unstyled">
                    <!-- Outils admin internes -->
                    <li><a href="https://www.nataswim.fr/diffusion/admin/" target="_blank" rel="noopener noreferrer" class="footer-link">
                        <i class="fas fa-envelope me-2"></i>Newsletter <i class="fas fa-external-link-alt ms-1 small"></i>
                    </a></li>
                    <li><a href="https://www.nataswim.fr/analytics/index.php" target="_blank" rel="noopener noreferrer" class="footer-link">
                        <i class="fas fa-chart-line me-2"></i>Analytics <i class="fas fa-external-link-alt ms-1 small"></i>
                    </a></li>
                    
                    <!-- Outils SEO & Web -->
                    <li><a href="https://search.google.com/search-console" target="_blank" rel="noopener noreferrer" class="footer-link">
                        <i class="fab fa-google me-2"></i>Search Console <i class="fas fa-external-link-alt ms-1 small"></i>
                    </a></li>
                    <li><a href="https://analytics.google.com/" target="_blank" rel="noopener noreferrer" class="footer-link">
                        <i class="fas fa-chart-bar me-2"></i>Google Analytics <i class="fas fa-external-link-alt ms-1 small"></i>
                    </a></li>
                </ul>
            </div>
        </div>

        <!-- Section ressources externes -->
        <div class="row mt-4 pt-4 border-top">
            <div class="col-12">
                <h6 class="footer-heading text-primary mb-3">
                    <i class="fas fa-link me-2"></i>Ressources & Partenaires
                </h6>
                <div class="d-flex flex-wrap gap-3">
                    <!-- Fédérations & Organisations -->
                    <a href="https://www.ffnatation.fr/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-primary" title="Fédération Française de Natation">
                        <i class="fas fa-swimming-pool me-1"></i>FFN
                    </a>
                    <a href="https://www.fina.org/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-primary" title="World Aquatics">
                        <i class="fas fa-globe me-1"></i>World Aquatics
                    </a>
                    
                    <!-- Outils développement -->
                    <a href="https://laravel.com/docs/12.x" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-secondary" title="Documentation Laravel 12">
                        <i class="fab fa-laravel me-1"></i>Laravel Docs
                    </a>
                    <a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-secondary" title="Bootstrap Framework">
                        <i class="fab fa-bootstrap me-1"></i>Bootstrap
                    </a>
                    
                    <!-- Outils SEO -->
                    <a href="https://www.semrush.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-info" title="SEMrush">
                        <i class="fas fa-search me-1"></i>SEMrush
                    </a>
                    <a href="https://ahrefs.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-info" title="Ahrefs">
                        <i class="fas fa-chart-line me-1"></i>Ahrefs
                    </a>
                    
                    <!-- Réseaux sociaux -->
                    <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-danger" title="YouTube">
                        <i class="fab fa-youtube me-1"></i>YouTube
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-danger" title="Instagram">
                        <i class="fab fa-instagram me-1"></i>Instagram
                    </a>
                    
                    <!-- Sites sportifs de référence -->
                    <a href="https://www.sports.fr/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-success" title="Sports.fr">
                        <i class="fas fa-trophy me-1"></i>Sports.fr
                    </a>
                    <a href="https://www.lequipe.fr/Natation/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-success" title="L'Équipe Natation">
                        <i class="fas fa-newspaper me-1"></i>L'Équipe
                    </a>
                    
                    <!-- Outils test performance -->
                    <a href="https://pagespeed.web.dev/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-warning" title="PageSpeed Insights">
                        <i class="fas fa-tachometer-alt me-1"></i>PageSpeed
                    </a>
                    <a href="https://gtmetrix.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-warning" title="GTmetrix">
                        <i class="fas fa-stopwatch me-1"></i>GTmetrix
                    </a>
                    
                    <!-- Outils validation -->
                    <a href="https://validator.w3.org/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-dark" title="W3C Validator">
                        <i class="fas fa-check-circle me-1"></i>W3C Validator
                    </a>
                    <a href="https://www.xml-sitemaps.com/" target="_blank" rel="noopener noreferrer" 
                       class="btn btn-sm btn-outline-dark" title="XML Sitemap Generator">
                        <i class="fas fa-sitemap me-1"></i>Sitemap Tool
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright et informations -->
        <div class="row mt-4 pt-4 border-top">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-1 text-muted">
                    <i class="fas fa-copyright me-1"></i>
                    {{ date('Y') }} <strong>{{ config('app.name') }}</strong> - Administration
                </p>
                <p class="mb-0 small text-muted">
                    Plateforme d'entraînement sportif professionnelle
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="footer-meta d-flex justify-content-center justify-content-md-end align-items-center gap-3 flex-wrap">
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle me-1"></i>Laravel {{ app()->version() }}
                    </span>
                    <span class="badge bg-info">
                        <i class="fas fa-server me-1"></i>PHP {{ PHP_VERSION }}
                    </span>
                    <span class="text-muted small">
                        <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i>Voir le site
                    </a>
                </div>
            </div>
        </div>

        <!-- Liens légaux -->
        <div class="row mt-3 pt-3 border-top">
            <div class="col-12 text-center">
                <div class="footer-legal d-flex justify-content-center gap-3 flex-wrap small">
                    <a href="#" class="text-muted footer-link-legal">Mentions légales</a>
                    <span class="text-muted">•</span>
                    <a href="#" class="text-muted footer-link-legal">Politique de confidentialité</a>
                    <span class="text-muted">•</span>
                    <a href="#" class="text-muted footer-link-legal">CGU</a>
                    <span class="text-muted">•</span>
                    <a href="#" class="text-muted footer-link-legal">Contact</a>
                    <span class="text-muted">•</span>
                    <a href="https://github.com/nataswim/bidaya2025" target="_blank" rel="noopener noreferrer" class="text-muted footer-link-legal">
                        <i class="fab fa-github me-1"></i>GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>