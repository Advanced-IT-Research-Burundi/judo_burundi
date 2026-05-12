@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-6">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5 bg-primary bg-gradient text-white d-none d-md-flex flex-column justify-content-center p-4">
                    <div class="text-center px-2">
                        <p class="text-uppercase small text-white-50 mb-2">Fédération du Burundi</p>
                        <h2 class="fw-bold mb-4">Judo</h2>
                        <ul class="list-unstyled small text-white text-opacity-75 text-start ps-2 mx-auto">
                            <li class="mb-2"><i class="fas fa-fist-raised me-2 text-success"></i> Formation d'excellence</li>
                            <li class="mb-2"><i class="fas fa-users me-2 text-success"></i> Communauté unie</li>
                            <li><i class="fas fa-trophy me-2 text-success"></i> Tradition & honneur</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4 p-xl-5">
                        <div class="text-center text-md-start mb-4">
                            <h1 class="h3 fw-semibold text-primary mb-2">Connexion</h1>
                            <p class="text-muted small mb-0">Accédez à votre espace membre.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success small py-2" role="alert">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Adresse e-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autocomplete="email" autofocus placeholder="vous@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label small fw-semibold">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="••••••••">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4 small">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">Se souvenir de moi</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-success fw-medium text-decoration-none">Mot de passe oublié ?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-semibold">Se connecter</button>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0 border-top pt-3">
                            Pas encore de compte ?
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="link-primary fw-semibold text-decoration-none">Créer un compte</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center mt-4 small mb-0">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Retour à l'accueil</a>
        </p>
    </div>
</div>
@endsection
