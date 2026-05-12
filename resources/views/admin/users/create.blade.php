@extends('layouts.admin')

@section('title', 'Nouvel utilisateur')
@section('page-title', 'Nouvel utilisateur')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Créer un compte</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}" autocomplete="name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" autocomplete="email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmation du mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_admin" value="1" class="form-check-input" id="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_admin">Compte administrateur (accès au tableau de bord)</label>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
