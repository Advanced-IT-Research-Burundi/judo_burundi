@extends('layouts.admin')

@section('title', 'Modifier le Type de Post')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">Modifier le type de post</h1>
            <p class="text-muted mb-0">{{ $typePost->nom }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.type-posts.show', $typePost) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>Voir
            </a>
            <a href="{{ route('admin.type-posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
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
                        <i class="fas fa-edit me-2"></i>Modifier les informations
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.type-posts.update', $typePost) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du type *</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $typePost->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $typePost->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Sauvegarder les modifications
                            </button>
                            <a href="{{ route('admin.type-posts.show', $typePost) }}" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>Voir le type
                            </a>
                            <a href="{{ route('admin.type-posts.index') }}" class="btn btn-secondary">
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
                        <i class="fas fa-info-circle me-2"></i>Informations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Posts de ce type</h6>
                        <p class="h4 text-success mb-0">{{ $typePost->posts_count }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Date de création</h6>
                        <p class="mb-0">{{ $typePost->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($typePost->updated_at != $typePost->created_at)
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Dernière modification</h6>
                            <p class="mb-0">{{ $typePost->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif

                    @if($typePost->posts_count > 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Ce type contient des posts. Modifiez avec précaution.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection