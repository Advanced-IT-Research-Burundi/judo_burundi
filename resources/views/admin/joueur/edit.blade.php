@extends('layouts.admin')

@section('title', 'Modifier un joueur')
@section('page-title', 'Modification du joueur')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5><i class="fas fa-edit me-2"></i> Modifier le joueur : {{ $joueur->prenom }} {{ $joueur->nom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.joueurs.update', $joueur->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="{{ $joueur->nom }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="{{ $joueur->prenom }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Poids (kg)</label>
                    <input type="number" step="0.01" name="poids" class="form-control" value="{{ $joueur->poids }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Taille (cm)</label>
                    <input type="number" step="0.01" name="taille" class="form-control" value="{{ $joueur->taille }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sexe</label>
                    <select name="sexe" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        <option value="M" {{ $joueur->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ $joueur->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Lieu de naissance</label>
                <input type="text" name="lieu_naissance" class="form-control" value="{{ $joueur->lieu_naissance }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Club</label>
                <select name="clubs_id" class="form-select" required>
                    @foreach ($clubs as $club)
                        <option value="{{ $club->id }}" {{ $joueur->clubs_id == $club->id ? 'selected' : '' }}>
                            {{ $club->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Image actuelle</label><br>
                <img src="{{ asset('storage/' . $joueur->image) }}" alt="Image joueur" class="rounded" width="120">
            </div>

            <div class="mb-3">
                <label class="form-label">Changer l’image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-warning text-white">
                    <i class="fas fa-save me-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
