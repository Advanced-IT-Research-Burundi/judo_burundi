@extends('layouts.admin')

@section('title', 'Créer un club')
@section('page-title', 'Créer un nouveau club')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-building me-2"></i>Informations du club
        </h5>
        <a href="{{ route('admin.clubs.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.clubs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Informations de base -->
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom du club <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                           id="nom" name="nom" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="capacite" class="form-label">Capacité</label>
                    <input type="number" class="form-control @error('capacite') is-invalid @enderror" 
                           id="capacite" name="capacite" value="{{ old('capacite') }}" min="0">
                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Coordonnées -->
                <div class="col-md-6 mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                           id="adresse" name="adresse" value="{{ old('adresse') }}">
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control @error('ville') is-invalid @enderror" 
                           id="ville" name="ville" value="{{ old('ville') }}">
                    @error('ville')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="code_postal" class="form-label">Code postal</label>
                    <input type="text" class="form-control @error('code_postal') is-invalid @enderror" 
                           id="code_postal" name="code_postal" value="{{ old('code_postal') }}">
                    @error('code_postal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <div class="col-md-6 mb-3">
                    <label for="site_web" class="form-label">Site web</label>
                    <input type="url" class="form-control @error('site_web') is-invalid @enderror" 
                           id="site_web" name="site_web" value="{{ old('site_web') }}" 
                           placeholder="https://...">
                    @error('site_web')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Responsable -->
                <div class="col-md-6 mb-3">
                    <label for="responsable" class="form-label">Nom du responsable</label>
                    <input type="text" class="form-control @error('responsable') is-invalid @enderror" 
                           id="responsable" name="responsable" value="{{ old('responsable') }}">
                    @error('responsable')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tel_responsable" class="form-label">Téléphone du responsable</label>
                    <input type="tel" class="form-control @error('tel_responsable') is-invalid @enderror" 
                           id="tel_responsable" name="tel_responsable" value="{{ old('tel_responsable') }}">
                    @error('tel_responsable')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Logo -->
                <div class="col-md-6 mb-3">
                    <label for="logo" class="form-label">Logo du club</label>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                           id="logo" name="logo" accept="image/*">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Formats acceptés: JPG, PNG, GIF (Max: 2MB)</small>
                </div>

                <!-- Description -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.clubs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection