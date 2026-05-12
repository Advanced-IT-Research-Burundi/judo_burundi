@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-6">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="row g-0 flex-md-row-reverse">
                <div class="col-md-5 bg-success bg-opacity-75 text-white d-none d-md-flex flex-column justify-content-center p-4">
                    <div class="text-center px-2">
                        <p class="text-uppercase small mb-2 opacity-75">Rejoignez-nous</p>
                        <h2 class="fw-bold mb-4">Famille judo</h2>
                        <p class="small opacity-90 mb-0">Créez votre compte pour suivre les actualités et accéder à votre espace.</p>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4 p-xl-5">
                        <div class="text-center text-md-start mb-4">
                            <h1 class="h3 fw-semibold text-primary mb-2">Inscription</h1>
                            <p class="text-muted small mb-0">Rejoignez la communauté.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label small fw-semibold">Nom complet</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autocomplete="name" autofocus placeholder="Jean Dupont">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Adresse e-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autocomplete="email" placeholder="vous@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label small fw-semibold">Confirmation</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-semibold">S'inscrire</button>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0 border-top pt-3">
                            Déjà inscrit ?
                            <a href="{{ route('login') }}" class="link-primary fw-semibold text-decoration-none">Se connecter</a>
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
