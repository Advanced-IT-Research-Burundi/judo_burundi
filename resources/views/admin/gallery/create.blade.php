@extends('layouts.admin')

@section('title', 'Ajouter Image')
@section('page-title', 'Ajouter une Image')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="images" class="form-control" required>
            </div>
            <button class="btn btn-success">Enregistrer</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
