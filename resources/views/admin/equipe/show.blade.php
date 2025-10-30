@extends('layouts.admin')
@section('title', $equipe->fullname)
@section('page-title', 'Détails du Membre de l’Équipe')

@section('content')
<div class="card shadow-sm text-center">
    <div class="card-body">
        @if($equipe->photo)
            <img src="{{ asset('storage/' . $equipe->photo) }}" class="rounded-circle mb-3" style="width:150px;height:150px;object-fit:cover;">
        @endif
        <h4>{{ $equipe->fullname }}</h4>
        <p class="text-muted">{{ $equipe->poste }}</p>

        <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Retour</a>
        <a href="{{ route('admin.equipes.edit', $equipe) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Modifier</a>
    </div>
</div>
@endsection
