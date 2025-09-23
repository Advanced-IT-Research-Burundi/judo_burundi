@extends('layouts.admin')

@section('title', 'Équipes')
@section('page-title', 'Gestion des Membres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-tags me-2"></i>
        Liste des Membres
    </h2>
    <a href="{{ route('admin.equipes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        Nouvelle Membre
    </a>
</div>

<div class="row">
    @forelse($equipes as $equipe)
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img src="{{ $equipe->photo ? asset('storage/'.$equipe->photo) : 'https://via.placeholder.com/150' }}" 
                         class="rounded-circle mb-2" width="100" height="100" alt="{{ $equipe->fullname }}">
                    <h5>{{ $equipe->fullname }}</h5>
                    <p class="text-muted">{{ $equipe->poste ?? 'N/A' }}</p>
                    
                    <!-- Boutons actions -->
                    <a href="{{ route('admin.equipes.show', $equipe) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i> Voir</a>
                    <a href="{{ route('admin.equipes.edit', $equipe) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i> Modifier</a>
                    <form action="{{ route('admin.equipes.destroy', $equipe) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce membre ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">Aucun membre trouvé.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $equipes->links() }}
</div>
@endsection
