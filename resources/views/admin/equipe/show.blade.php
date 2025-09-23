@extends('layouts.admin')

@section('title', 'Membre Détail')
@section('page-title', 'Détails du membre')

@section('content')
<div class="card text-center">
    <div class="card-body">
        <img src="{{ $equipe->photo ? asset('storage/'.$equipe->photo) : 'https://via.placeholder.com/150' }}" 
             class="rounded-circle mb-3" width="150" height="150">
        <h3>{{ $equipe->fullname }}</h3>
        <p class="text-muted">{{ $equipe->poste ?? 'N/A' }}</p>
        <a href="{{ route('admin.equipes.edit', $equipe) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
        <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection
