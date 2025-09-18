@extends('layouts.admin')

@section('title', 'Inscrire un Joueur')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">Inscrire un nouveau joueur</h1>
            <p class="text-muted mb-0">Ajoutez un nouveau joueur à la fédération</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erreurs de validation :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.joueurs.store') }}">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Informations personnelles -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Informations personnelles
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom *</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_naissance" class="form-label">Date de naissance</label>
                                <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                                       id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                                @error('date_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sexe" class="form-label">Sexe</label>
                                <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe">
                                    <option value="">Sélectionner</option>
                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('sexe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                   id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}">
                            @error('lieu_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations de contact -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-address-book me-2"></i>Informations de contact
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Affiliation -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>Affiliation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">Catégorie *</label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    id="categorie_id" name="categorie_id" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                            {{ old('categorie_id', request('categorie')) == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                        @if($categorie->description)
                                            - {{ Str::limit($categorie->description, 30) }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="colline_id" class="form-label">Colline *</label>
                            <select class="form-select @error('colline_id') is-invalid @enderror" 
                                    id="colline_id" name="colline_id" required>
                                <option value="">Sélectionner une colline</option>
                                @foreach($collines as $colline)
                                    <option value="{{ $colline->id }}" 
                                            {{ old('colline_id') == $colline->id ? 'selected' : '' }}>
                                        {{ $colline->nom }}
                                        @if($colline->zone)
                                            ({{ $colline->zone->nom }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('colline_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Inscrire le joueur
                            </button>
                            <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection