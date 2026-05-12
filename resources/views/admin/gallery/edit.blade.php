@extends('layouts.admin')
@section('title', 'Modifier une Image')
@section('page-title', 'Modifier une Image')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="{{ $gallery->titre }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Compétition liée (album)</label>
                <select name="competition_id" class="form-select">
                    <option value="">— Galerie générale —</option>
                    @foreach($competitions as $c)
                        <option value="{{ $c->id }}" @selected(old('competition_id', $gallery->competition_id) == $c->id)>{{ $c->nom }} @if($c->date_competition)({{ $c->date_competition->format('Y') }})@endif</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="images" class="form-control">
                @if($gallery->images)
                    <img src="{{ asset('storage/' . $gallery->images) }}" class="mt-2 rounded" width="120">
                @endif
            </div>
            <div class="text-end">
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Retour</a>
                <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
