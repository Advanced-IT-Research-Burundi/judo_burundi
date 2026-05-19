@extends('layouts.admin')

@section('title', 'Liste des joueurs')
@section('page-title', 'Gestion des joueurs')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Joueurs ({{ $joueurs->total() }})</h5>
        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-light btn-sm text-primary">
            <i class="fas fa-plus me-1"></i>Nouveau joueur
        </a>
    </div>

    <div class="card-body table-responsive">
        <div class="text-muted small mb-3">
            Affichage de {{ $joueurs->firstItem() ?? 0 }} à {{ $joueurs->lastItem() ?? 0 }} sur {{ $joueurs->total() }} joueurs
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Nom & prénom</th>
                    <th>Sexe</th>
                    <th>Poids (kg)</th>
                    <th>Taille (cm)</th>
                    <th>Club</th>
                    <th>Date d’ajout</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($joueurs as $joueur)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($joueur->image)
                                <img src="{{ asset('storage/' . $joueur->image) }}" alt="" class="rounded-circle" width="50" height="50">
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>{{ $joueur->prenom }} {{ $joueur->nom }}</td>
                        <td>{{ $joueur->sexe ?? '-' }}</td>
                        <td>{{ $joueur->poids ?? '-' }}</td>
                        <td>{{ $joueur->taille ?? '-' }}</td>
                        <td>{{ $joueur->club->nom ?? '-' }}</td>
                        <td>{{ $joueur->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions joueur">
                                <a href="{{ route('admin.joueurs.show', $joueur->id) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.joueurs.edit', $joueur->id) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.joueurs.destroy', $joueur->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer ce joueur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                            Aucun joueur enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($joueurs->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $joueurs->currentPage() }} / {{ $joueurs->lastPage() }}</div>
            <div>{{ $joueurs->links() }}</div>
        </div>
    @endif
</div>
@endsection
