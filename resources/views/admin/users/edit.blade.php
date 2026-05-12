@extends('layouts.admin')

@section('title', 'Modifier utilisateur')
@section('page-title', 'Modifier utilisateur')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning">
        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>{{ $user->name ?: $user->email }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $user->name) }}" autocomplete="name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email', $user->email) }}" autocomplete="email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nouveau mot de passe <small class="text-muted">(optionnel)</small></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
            </div>
            <div class="mb-3">
                @if($user->id === auth()->id())
                    <p class="small text-muted mb-0"><i class="fas fa-info-circle me-1"></i>Les droits administrateur de votre compte ne peuvent pas être modifiés depuis votre propre fiche.</p>
                @else
                    <div class="form-check">
                        <input type="checkbox" name="is_admin" value="1" class="form-check-input" id="is_admin" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">Compte administrateur (accès au tableau de bord)</label>
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Retour</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
    @if($user->id !== auth()->id())
        <div class="card-footer bg-light border-top">
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer définitivement cet utilisateur ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-1"></i>Supprimer ce compte</button>
            </form>
        </div>
    @endif
</div>
@endsection
