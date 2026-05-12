@extends('layouts.admin')
@section('title', 'Ajouter une Image')
@section('page-title', 'Ajouter une Image')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Compétition liée (album)</label>
                <select name="competition_id" class="form-select">
                    <option value="">— Galerie générale —</option>
                    @foreach($competitions as $c)
                        <option value="{{ $c->id }}" @selected(old('competition_id') == $c->id)>{{ $c->nom }} @if($c->date_competition)({{ $c->date_competition->format('Y') }})@endif</option>
                    @endforeach
                </select>
                <small class="text-muted">Les photos ainsi liées apparaissent dans l’onglet « Photos » de la page hub compétition.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="images" class="form-control" required>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Annuler</a>
                <button class="btn btn-success"><i class="fas fa-save me-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
