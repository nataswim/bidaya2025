<footer class="text-light" style="border-left: 20px solid #0f5c78;border-right: 20px solid #0f5c78;background-color:#006170 !important;border-bottom: 20px solid #f9f5f3;border-top: 20px solid #f9f5f3;">

    <!-- Contenu principal du footer -->
    <div class="py-5">
        <div class="container-lg">
            <div class="row g-4">
                <!-- Ã propos -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px;">
                            <i class="fas fa-water text-white"></i>
                        </div>
                        <h5 class="mb-0 text-white">{{ config('app.name') }}</h5>
                    </div>
                    <p class="text-light opacity-75 mb-4">
                        Votre plateforme de rÃ©fÃ©rence pour le dÃ©veloppement web et les technologies modernes. 
                        Nous partageons nos connaissances pour faire grandir la communautÃ©.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">Navigation</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                Accueil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('public.index') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                Articles
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('about') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                Ã propos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('contact') }}" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- CatÃ©gories -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-semibold mb-3">CatÃ©gories</h6>
                    <ul class="list-unstyled">
                        @php
                            $footerCategories = App\Models\Category::where('status', 'active')->limit(5)->get();
                        @endphp
                        @forelse($footerCategories as $category)
                            <li class="mb-2">
                                <a href="{{ route('public.index', ['category' => $category->slug]) }}" 
                                   class="text-light opacity-75 text-decoration-none hover-opacity-100">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li class="mb-2">
                                <span class="text-light opacity-50">Aucune catÃ©gorie</span>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-4">
                    <h6 class="text-white fw-semibold mb-3">Restez connectÃ©</h6>
                    <p class="text-light opacity-75 mb-3">
                        Recevez nos derniers articles directement dans votre boîte mail.
                    </p>
                    <form class="mb-4">
                        <div class="input-group">
                            <input type="email" 
                                   class="form-control" 
                                   placeholder="Votre adresse email"
                                   required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <div class="d-flex align-items-center text-light opacity-75">
                        <i class="fas fa-shield-alt me-2"></i>
                        <small>Vos donnÃ©es sont protÃ©gÃ©es. Aucun spam.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de copyright -->
<div style="border-top: 2px solid #ffffff; background-color:#0f5c78;">
        <div class="container-lg py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light opacity-75">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits rÃ©servÃ©s.
                    </p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-wrap justify-content-md-end gap-4">
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                            Politique de confidentialitÃ©
                        </a>
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                            Conditions d'utilisation
                        </a>
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-opacity-100">
                            Mentions lÃ©gales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('styles')
<style>
.hover-opacity-100:hover {
    opacity: 1 !important;
}
</style>
@endpush