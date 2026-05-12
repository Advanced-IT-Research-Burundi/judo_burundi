@extends('layouts.auth')

@section('title', 'Vérification de l\'e-mail')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
                <h1 class="h5 fw-semibold text-primary mb-3">Vérifiez votre messagerie</h1>
                <p class="text-muted small mb-4">
                    Merci pour votre inscription ! Avant de commencer, veuillez confirmer votre adresse via le lien que nous vous avons envoyé. Si vous n'avez rien reçu, nous pouvons en envoyer un autre.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small mb-4">Un nouveau lien a été envoyé à l'adresse indiquée.</div>
                @endif

                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-stretch align-items-sm-center">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Renvoyer l'e-mail</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
