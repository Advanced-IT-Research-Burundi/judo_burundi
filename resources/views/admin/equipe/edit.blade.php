@extends('layouts.admin')

@section('title', 'Modifier Membre')
@section('page-title', 'Modifier un membre de l’équipe')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.equipes.update', $equipe) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="fullname" class="form-label">Nom complet</label>
                <input type="text" name="fullname" id="fullname" class="form-control" 
                       value="{{ old('fullname', $equipe->fullname) }}" required>
            </div>

            <div class="mb-3">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" name="poste" id="poste" class="form-control" 
                       value="{{ old('poste', $equipe->poste) }}">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
                @if($equipe->photo)
                    <img src="{{ asset('storage/'.$equipe->photo) }}" width="100" height="100" class="mt-2 rounded-circle" alt="Photo de {{ $equipe->fullname }}">
                @endif
            </div>

            <button class="btn btn-success"><i class="fas fa-save"></i> Mettre à jour</button>
            <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
