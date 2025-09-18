@extends('layouts.admin')

@section('title', 'Nouvelle Catégorie')
@section('page-title', 'Nouvelle Catégorie')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Créer une Nouvelle Catégorie</h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="nom" class="form-label">
                                Nom de la Catégorie <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom') }}" required
                                   placeholder="Ex: Minimes -60kg, Cadets -73kg...">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Utilisez un nom descriptif incluant l'âge et le poids si applicable
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4"
                                      placeholder="Décrivez les critères d'âge, de poids ou autres spécificités...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Exemples de catégories courantes :</strong>
                            <ul class="mb-0 mt-2">
                                <li>Minimes -60kg (16-17 ans, moins de 60kg)</li>
                                <li>Cadets -73kg (18-19 ans, moins de 73kg)</li>
                                <li>Juniors -81kg (20-21 ans, moins de 81kg)</li>
                                <li>Seniors +100kg (22 ans et plus, plus de 100kg)</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer la Catégorie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection