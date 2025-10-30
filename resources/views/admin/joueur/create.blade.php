@extends('layouts.admin')

@section('title', 'Ajouter un joueur')
@section('page-title', 'Nouveau joueur')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5><i class="fas fa-user-plus me-2"></i> Ajouter un joueur</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.joueurs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Poids (kg)</label>
                    <input type="number" step="0.01" name="poids" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Taille (cm)</label>
                    <input type="number" step="0.01" name="taille" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sexe</label>
                    <select name="sexe" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Lieu de naissance</label>
                <input type="text" name="lieu_naissance" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Club</label>
                <select name="clubs_id" class="form-select" required>
                    <option value="">-- Sélectionner un club --</option>
                    @foreach ($clubs as $club)
                        <option value="{{ $club->id }}">{{ $club->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
