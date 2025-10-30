@extends('layouts.admin')
@section('title', 'Modifier un Membre de l’Équipe')
@section('page-title', 'Modifier un Membre de l’Équipe')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.equipes.update', $equipe) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="fullname" value="{{ $equipe->fullname }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Poste</label>
                    <input type="text" name="poste" value="{{ $equipe->poste }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control">
                    @if($equipe->photo)
                        <img src="{{ asset('storage/' . $equipe->photo) }}" width="100" class="mt-2 rounded">
                    @endif
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Retour</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
