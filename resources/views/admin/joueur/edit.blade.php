@extends('layouts.admin')

@section('title', 'Modifier le Joueur')
@section('page-title', 'Modifier le Joueur')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Modifier : {{ $joueur->nom_complet }}</h5>
                    <div>
                        <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-2"></i>Voir
                        </a>
                        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.joueurs.update', $joueur) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informations personnelles -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-user me-2"></i>Informations Personnelles
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" name="nom" value="{{ old('nom', $joueur->nom) }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" name="prenom" value="{{ old('prenom', $joueur->prenom) }}" required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="date_naissance" class="form-label">Date de Naissance</label>
                                    <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                                           id="date_naissance" name="date_naissance" 
                                           value="{{ old('date_naissance', $joueur->date_naissance?->format('Y-m-d')) }}">
                                    @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="sexe" class="form-label">Sexe</label>
                                    <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe">
                                        <option value="">Choisir...</option>
                                        <option value="M" {{ old('sexe', $joueur->sexe) === 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe', $joueur->sexe) === 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="lieu_naissance" class="form-label">Lieu de Naissance</label>
                                    <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                           id="lieu_naissance" name="lieu_naissance" 
                                           value="{{ old('lieu_naissance', $joueur->lieu_naissance) }}">
                                    @error('lieu_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-phone me-2"></i>Informations de Contact
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" name="telephone" 
                                           value="{{ old('telephone', $joueur->telephone) }}">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $joueur->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations sportives -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-medal me-2"></i>Informations Sportives
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="colline_id" class="form-label">Colline/Quartier <span class="text-danger">*</span></label>
                                    <select class="form-select @error('colline_id') is-invalid @enderror" 
                                            id="colline_id" name="colline_id" required>
                                        <option value="">Choisir...</option>
                                        @foreach($collines as $colline)
                                            <option value="{{ $colline->id }}" 
                                                    {{ old('colline_id', $joueur->colline_id) == $colline->id ? 'selected' : '' }}>
                                                {{ $colline->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('colline_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                            id="categorie_id" name="categorie_id" required>
                                        <option value="">Choisir...</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}" 
                                                    {{ old('categorie_id', $joueur->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categorie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection