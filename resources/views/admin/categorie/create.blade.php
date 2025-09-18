@extends('layouts.admin')

@section('title', 'Créer une Catégorie')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">Créer une nouvelle catégorie</h1>
            <p class="text-muted mb-0">Ajoutez une nouvelle catégorie de joueurs</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Informations de la catégorie
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la catégorie *</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom') }}" required autofocus>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nom unique de la catégorie (ex: Senior, Junior, Vétéran)</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Description détaillée de la catégorie (optionnel)</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer la catégorie
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Aide
                    </h5>
                </div>
                <div class="card-body">
                    <h6>Conseils pour les catégories :</h6>
                    <ul class="small mb-0">
                        <li><strong>Nom :</strong> Choisissez un nom clair et unique</li>
                        <li><strong>Description :</strong> Expliquez les critères d'appartenance</li>
                        <li><strong>Exemples :</strong> U15, U18, Senior, Vétéran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
