@extends('layouts.auth')

@section('title', 'Confirmation')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-5">
        <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
                <h1 class="h5 fw-semibold text-primary mb-3">Confirmation</h1>
                <p class="text-muted small mb-4">Merci de saisir à nouveau votre mot de passe pour continuer.</p>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="form-label small fw-semibold">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
