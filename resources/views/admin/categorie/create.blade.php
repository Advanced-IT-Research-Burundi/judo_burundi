@extends('layouts.admin')

@section('title', 'Nouvelle Catégorie')
@section('page-title', 'Créer une Catégorie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-plus me-2"></i>
        Nouvelle Catégorie
    </h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Retour à la liste
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations de la catégorie
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">
                            Nom de la catégorie <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" 
                               name="nom" 
                               value="{{ old('nom') }}" 
                               required
                               placeholder="Saisissez le nom de la catégorie">
                        @error('nom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Le nom doit être unique et descriptif.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Description détaillée de la catégorie (optionnel)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Description optionnelle pour préciser l'usage de cette catégorie.
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Créer la catégorie
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
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
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Conseils
                </h6>
            </div>
            <div class="card-body">
                <div class="small text-muted">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        <strong>Nom unique :</strong> Choisissez un nom distinctif et facilement reconnaissable.
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        <strong>Description claire :</strong> Une bonne description aide à comprendre l'utilisation de la catégorie.
                    </div>
                    <div class="mb-0">
                        <i class="fas fa-info-circle text-info me-1"></i>
                        <strong>Joueurs :</strong> Cette catégorie pourra être assignée aux joueurs pour les organiser par niveau ou âge.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection