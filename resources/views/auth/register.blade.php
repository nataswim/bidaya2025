@extends('layouts.guest')

@section('content')
<div class="min-vh-100 d-flex align-items-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user-plus text-white fa-2x"></i>
                            </div>
                            <h2 class="fw-bold">Créer un compte</h2>
                            <p class="text-muted">Rejoignez notre communauté</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nom complet</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name') }}"
                                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                                           placeholder="Jean Dupont"
                                           required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email') }}"
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           placeholder="jean@example.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               name="password" 
                                               id="password" 
                                               class="form-control border-start-0 @error('password') is-invalid @enderror"
                                               placeholder="••••••••"
                                               required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirmer</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation" 
                                               class="form-control border-start-0"
                                               placeholder="••••••••"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="terms" 
                                           id="terms" 
                                           class="form-check-input"
                                           required>
                                    <label for="terms" class="form-check-label">
                                        J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a> 
                                        et la <a href="#" class="text-decoration-none">politique de confidentialité</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Créer mon compte
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <span class="text-muted">Déjà membre ?</span>
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                    Se connecter
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Retour accueil -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection