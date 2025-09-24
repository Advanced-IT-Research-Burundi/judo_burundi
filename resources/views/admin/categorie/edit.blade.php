@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')
@section('page-title', 'Modifier la Catégorie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-edit me-2"></i>
        Modifier : {{ $category->nom }}
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-1"></i>
            Voir
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Retour à la liste
        </a>
    </div>
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
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">
                            Nom de la catégorie <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" 
                               name="nom" 
                               value="{{ old('nom', $category->nom) }}" 
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
                                  placeholder="Description détaillée de la catégorie (optionnel)">{{ old('description', $category->description) }}</textarea>
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
                            Mettre à jour
                        </button>
                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-1"></i>
                            Voir la catégorie
                        </a>
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
                    <i class="fas fa-info-circle me-2"></i>
                    Informations
                </h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <div class="mb-2">
                        <strong>ID :</strong> {{ $category->id }}
                    </div>
                    <div class="mb-2">
                        <strong>Joueurs associés :</strong> 
                        <span class="badge bg-info">{{ $category->joueurs()->count() }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Créée le :</strong><br>
                        {{ $category->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>Modifiée le :</strong><br>
                        {{ $category->updated_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
                <hr>
                <div class="small text-muted">
                    <div class="mb-2">
                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                        <strong>Attention :</strong> La modification du nom peut affecter les membres associés.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection