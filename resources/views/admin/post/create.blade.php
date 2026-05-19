@extends('layouts.admin')

@section('title', 'Nouvelle Actualité')
@section('page-title', 'Créer une actualité')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Créer une nouvelle actualité</h5>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contenu <span class="text-danger">*</span></label>
                <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if(isset($typePosts) && $typePosts->count())
                <div class="mb-3">
                    <label class="form-label">Type d’article</label>
                    <select name="typepost_id" class="form-select @error('typepost_id') is-invalid @enderror">
                        <option value="">— Aucun —</option>
                        @foreach($typePosts as $type)
                            <option value="{{ $type->id }}" @selected(old('typepost_id') == $type->id)>{{ $type->nom }}</option>
                        @endforeach
                    </select>
                    @error('typepost_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Image (optionnelle)</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Publier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
