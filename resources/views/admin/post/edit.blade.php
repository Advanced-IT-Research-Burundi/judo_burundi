@extends('layouts.admin')

@section('title', 'Modifier une Actualité')
@section('page-title', 'Modifier une actualité')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5><i class="fas fa-edit me-2"></i>Modifier : {{ $post->title }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title', $post->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <textarea name="content" rows="6" class="form-control" required>{{ old('content', $post->content) }}</textarea>
            </div>

            @if($post->image)
                <div class="mb-3">
                    <label class="form-label">Image actuelle</label><br>
                    <img src="{{ asset('storage/' . $post->image) }}" class="rounded" width="200" alt="Image actuelle">
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Changer l’image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-warning text-white">
                    <i class="fas fa-save me-1"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
