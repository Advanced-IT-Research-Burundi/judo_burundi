@extends('layouts.admin')

@section('title', isset($equipe) ? 'Modifier Membre' : 'Ajouter Membre')
@section('page-title', isset($equipe) ? 'Modifier un membre' : 'Ajouter un membre')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ isset($equipe) ? route('admin.equipes.update', $equipe) : route('admin.equipes.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($equipe)) @method('PUT') @endif

            <div class="mb-3">
                <label for="fullname" class="form-label">Nom complet</label>
                <input type="text" name="fullname" id="fullname" class="form-control" 
                       value="{{ old('fullname', $equipe->fullname ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" name="poste" id="poste" class="form-control" 
                       value="{{ old('poste', $equipe->poste ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
                @if(isset($equipe) && $equipe->photo)
                    <img src="{{ asset('storage/'.$equipe->photo) }}" width="100" height="100" class="mt-2 rounded-circle">
                @endif
            </div>

            <button class="btn btn-success">{{ isset($equipe) ? 'Mettre à jour' : 'Ajouter' }}</button>
            <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
