@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')
@section('page-title', 'Modifier la Catégorie')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Modifier : {{ $categorie->nom }}</h5>
                    <div>
                        <a href="{{ route('admin.categories.show', $categorie) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-2"></i>Voir
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $categorie) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-4">
                            <label for="nom" class="form-label">
                                Nom de la Catégorie <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $categorie->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $categorie->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($categorie->joueurs_count > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Cette catégorie contient <strong>{{ $categorie->joueurs_count }} joueurs</strong>. 
                                Les modifications affecteront tous ces joueurs.
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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