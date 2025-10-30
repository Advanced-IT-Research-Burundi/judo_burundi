@extends('layouts.admin')
@section('title', $gallery->titre)
@section('page-title', 'Détails de l’Image')

@section('content')
<div class="card shadow-sm text-center">
    <div class="card-body">
        <img src="{{ asset('storage/' . $gallery->images) }}" class="img-fluid rounded mb-3" style="max-height:400px;object-fit:cover;">
        <h4>{{ $gallery->titre }}</h4>
        <div class="mt-3">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Retour</a>
            <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Modifier</a>
        </div>
    </div>
</div>
@endsection
