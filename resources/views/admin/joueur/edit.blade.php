@extends('layouts.admin')

@section('title', 'Modifier le Joueur')
@section('page-title', 'Modifier le Joueur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-user-edit me-2"></i>
        Modifier : {{ $joueur->prenom }} {{ $joueur->nom }}
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-1"></i>
            Voir
        </a>
        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Retour à la liste
        </a>
    </div>
</div>

<form action="{{ route('admin.joueurs.update', $joueur) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">
                                    Nom <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom', $joueur->nom) }}" 
                                       required
                                       placeholder="Nom de famille">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prenom" class="form-label">
                                    Prénom <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="{{ old('prenom', $joueur->prenom) }}" 
                                       required
                                       placeholder="Prénom">
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_naissance" class="form-label">
                                    Date de naissance
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_naissance') is-invalid @enderror" 
                                       id="date_naissance" 
                                       name="date_naissance" 
                                       value="{{ old('date_naissance', $joueur->date_naissance ? $joueur->date_naissance->format('Y-m-d') : '') }}">
                                @error('date_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($joueur->date_naissance)
                                    <div class="form-text">
                                        Âge actuel : {{ $joueur->date_naissance->age }} ans
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lieu_naissance" class="form-label">
                                    Lieu de naissance
                                </label>
                                <input type="text" 
                                       class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                       id="lieu_naissance" 
                                       name="lieu_naissance" 
                                       value="{{ old('lieu_naissance', $joueur->lieu_naissance) }}"
                                       placeholder="Ville, pays">
                                @error('lieu_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sexe" class="form-label">
                                    Sexe
                                </label>
                                <select class="form-select @error('sexe') is-invalid @enderror" 
                                        id="sexe" 
                                        name="sexe">
                                    <option value="">Sélectionner le sexe</option>
                                    <option value="M" 
                                            {{ old('sexe', $joueur->sexe) == 'M' ? 'selected' : '' }}>
                                        Masculin
                                    </option>
                                    <option value="F" 
                                            {{ old('sexe', $joueur->sexe) == 'F' ? 'selected' : '' }}>
                                        Féminin
                                    </option>
                                </select>
                                @error('sexe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">
                                    Téléphone
                                </label>
                                <input type="tel" 
                                       class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" 
                                       name="telephone" 
                                       value="{{ old('telephone', $joueur->telephone) }}"
                                       placeholder="+257 XX XX XX XX">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $joueur->email) }}"
                               placeholder="exemple@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Informations de classification
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categorie_id" class="form-label">
                                    Catégorie <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                        id="categorie_id" 
                                        name="categorie_id" 
                                        required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @if(isset($categories))
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}" 
                                                    {{ old('categorie_id', $joueur->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                                @if($categorie->description)
                                                    - {{ Str::limit($categorie->description, 50) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('categorie_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($joueur->categorie_id != old('categorie_id', $joueur->categorie_id))
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Changer la catégorie peut affecter les compétitions en cours.
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="colline_id" class="form-label">
                                    Colline <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('colline_id') is-invalid @enderror" 
                                        id="colline_id" 
                                        name="colline_id" 
                                        required>
                                    <option value="">Sélectionner une colline</option>
                                    @if(isset($collines))
                                        @foreach($collines as $colline)
                                            <option value="{{ $colline->id }}" 
                                                    {{ old('colline_id', $joueur->colline_id) == $colline->id ? 'selected' : '' }}>
                                                {{ $colline->nom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('colline_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Mettre à jour
                </button>
                <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info">
                    <i class="fas fa-eye me-1"></i>
                    Voir le joueur
                </a>
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    Annuler
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations du joueur
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto mb-2">
                            {{ strtoupper(substr($joueur->prenom, 0, 1) . substr($joueur->nom, 0, 1)) }}
                        </div>
                        <h6 class="mb-0">{{ $joueur->prenom }} {{ $joueur->nom }}</h6>
                        <small class="text-muted">ID: #{{ $joueur->id }}</small>
                    </div>
                    
                    <hr>
                    
                    <div class="small">
                        <div class="mb-2">
                            <strong>Catégorie actuelle :</strong><br>
                            @if($joueur->categorie)
                                <span class="badge bg-success">{{ $joueur->categorie->nom }}</span>
                            @else
                                <span class="text-muted">Non assignée</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <strong>Colline actuelle :</strong><br>
                            @if($joueur->colline)
                                <span class="badge bg-info">{{ $joueur->colline->nom }}</span>
                            @else
                                <span class="text-muted">Non assignée</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <strong>Enregistré le :</strong><br>
                            {{ $joueur->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div class="mb-0">
                            <strong>Dernière modification :</strong><br>
                            {{ $joueur->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</form>

@push('styles')
<style>
.avatar-lg {
    width: 4rem;
    height: 4rem;
    font-size: 1.5rem;
}
</style>
@endpush
@endsection