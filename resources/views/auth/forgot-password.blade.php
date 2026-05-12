@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-5">
        <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
                <h1 class="h4 fw-semibold text-primary mb-3">Mot de passe oublié</h1>
                <p class="text-muted small mb-4">Indiquez votre adresse e-mail : nous vous enverrons un lien pour définir un nouveau mot de passe.</p>

                @if (session('status'))
                    <div class="alert alert-success small">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label small fw-semibold">E-mail</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Envoyer le lien</button>
                </form>
                <div class="text-center mt-4 small">
                    <a href="{{ route('login') }}" class="link-success fw-medium text-decoration-none">Retour à la connexion</a>
                </div>
            </div>
        </div>
        <p class="text-center mt-3 mb-0 small">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none">Accueil</a>
        </p>
    </div>
</div>
@endsection
