@extends('layouts.guest')

@section('content')
<div class="min-vh-100 d-flex align-items-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-water text-white fa-2x"></i>
                            </div>
                            <h2 class="fw-bold">{{ config('app.name') }}</h2>
                            <p class="text-muted">Connectez-vous Ã votre compte</p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

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
                                           placeholder="votre@email.com"
                                           required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
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

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="remember" 
                                           id="remember" 
                                           class="form-check-input">
                                    <label for="remember" class="form-check-label">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    Mot de passe oubliÃ© ?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <span class="text-muted">Pas encore de compte ?</span>
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                                    CrÃ©er un compte
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Retour accueil -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Retour Ã l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection