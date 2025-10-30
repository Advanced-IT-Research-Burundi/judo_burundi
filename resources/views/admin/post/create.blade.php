@extends('layouts.admin')

@section('title', 'Nouvelle Actualité')
@section('page-title', 'Créer une actualité')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5><i class="fas fa-plus me-2"></i>Créer une nouvelle actualité</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <textarea name="content" rows="6" class="form-control" required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Image (optionnelle)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Publier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
