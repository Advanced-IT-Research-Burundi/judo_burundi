@extends('layouts.admin')

@section('title', 'Modifier un Joueur')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i> Modifier {{ $joueur->nom_complet }}
                    </h3>
                </div>

                <form action="{{ route('admin.joueurs.update', $joueur) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Informations personnelles -->
                            <div class="col-md-6">
                                <h5 class="mb-3 text-primary">
                                    <i class="fas fa-user"></i> Informations personnelles
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" 
                                           name="nom" 
                                           value="{{ old('nom', $joueur->nom) }}" 
                                           required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" 
                                           name="prenom" 
                                           value="{{ old('prenom', $joueur->prenom) }}" 
                                           required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="date_naissance" class="form-label">Date de naissance</label>
                                    <input type="date" 
                                           class="form-control @error('date_naissance') is-invalid @enderror" 
                                           id="date_naissance" 
                                           name="date_naissance" 
                                           value="{{ old('date_naissance', $joueur->date_naissance ? $joueur->date_naissance->format('Y-m-d') : '') }}">
                                    @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                                    <input type="text" 
                                           class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                           id="lieu_naissance" 
                                           name="lieu_naissance" 
                                           value="{{ old('lieu_naissance', $joueur->lieu_naissance) }}">
                                    @error('lieu_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="sexe" class="form-label">Sexe</label>
                                    <select class="form-select @error('sexe') is-invalid @enderror" 
                                            id="sexe" 
                                            name="sexe">
                                        <option value="">Sélectionner...</option>
                                        <option value="M" {{ old('sexe', $joueur->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe', $joueur->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Coordonnées et affiliation -->
                            <div class="col-md-6">
                                <h5 class="mb-3 text-success">
                                    <i class="fas fa-address-book"></i> Coordonnées
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" 
                                           class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" 
                                           name="telephone" 
                                           value="{{ old('telephone', $joueur->telephone) }}">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $joueur->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h5 class="mb-3 text-warning">
                                    <i class="fas fa-tags"></i> Affiliation
                                </h5>

                                <div class="mb-3">
                                    <label for="colline_id" class="form-label">Colline <span class="text-danger">*</span></label>
                                    <select class="form-select @error('colline_id') is-invalid @enderror" 
                                            id="colline_id" 
                                            name="colline_id" 
                                            required>
                                        <option value="">Sélectionner une colline...</option>
                                        @foreach($collines as $colline)
                                            <option value="{{ $colline->id }}" 
                                                    {{ old('colline_id', $joueur->colline_id) == $colline->id ? 'selected' : '' }}>
                                                {{ $colline->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('colline_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                            id="categorie_id" 
                                            name="categorie_id" 
                                            required>
                                        <option value="">Sélectionner une catégorie...</option>
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
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                                <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Modifier
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection