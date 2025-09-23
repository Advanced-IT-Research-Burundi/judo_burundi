@extends('layouts.admin')

@section('title', 'Modifier Image')
@section('page-title', 'Modifier une Image')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre', $gallery->titre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image (laisser vide pour ne pas changer)</label>
                <input type="file" name="images" class="form-control">
                <div class="mt-2">
                    <img src="{{ $gallery->images ? asset('storage/'.$gallery->images) : asset('images/default.png') }}"
                         alt="{{ $gallery->titre }}" class="img-thumbnail" width="150">
                </div>
            </div>
            <button class="btn btn-success">Mettre à jour</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
