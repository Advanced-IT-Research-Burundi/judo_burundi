@extends('layouts.admin')

@section('title', 'Liste des joueurs')
@section('page-title', 'Gestion des joueurs')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
        <h5><i class="fas fa-users me-2"></i> Liste des joueurs</h5>
        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Nouveau joueur
        </a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Nom & Prénom</th>
                    <th>Sexe</th>
                    <th>Poids (kg)</th>
                    <th>Taille (cm)</th>
                    <th>Club</th>
                    <th>Date d’ajout</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($joueurs as $joueur)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $joueur->image) }}" 
                                 alt="Photo" class="rounded-circle" width="50" height="50">
                        </td>
                        <td>{{ $joueur->prenom }} {{ $joueur->nom }}</td>
                        <td>{{ $joueur->sexe ?? '-' }}</td>
                        <td>{{ $joueur->poids ?? '-' }}</td>
                        <td>{{ $joueur->taille ?? '-' }}</td>
                        <td>{{ $joueur->club->nom ?? '-' }}</td>
                        <td>{{ $joueur->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.joueurs.show', $joueur->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.joueurs.edit', $joueur->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.joueurs.destroy', $joueur->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce joueur ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Aucun joueur enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $joueurs->links() }}
        </div>
    </div>
</div>
@endsection
