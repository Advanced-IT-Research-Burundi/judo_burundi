@extends('layouts.admin')

@section('title', 'Gestion des Joueurs')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Liste des Joueurs</h3>
                        <div>
                            <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nouveau Joueur
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom Complet</th>
                                        <th>Date de naissance</th>
                                        <th>Contact</th>
                                        <th>Colline</th>
                                        <th>Catégorie</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($joueurs as $joueur)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $joueur->nom_complet }}</strong>
                                                    @if ($joueur->sexe)
                                                        <span
                                                            class="badge {{ $joueur->sexe == 'M' ? 'bg-primary' : 'bg-pink' }} ms-2">
                                                            {{ $joueur->sexe == 'M' ? 'M' : 'F' }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if ($joueur->lieu_naissance)
                                                    <small class="text-muted">{{ $joueur->lieu_naissance }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($joueur->date_naissance)
                                                    <div>{{ $joueur->date_naissance->format('d/m/Y') }}</div>
                                                    <small class="text-muted">{{ $joueur->age }} ans</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($joueur->telephone || $joueur->email)
                                                    @if ($joueur->telephone)
                                                        <div><i class="fas fa-phone fa-sm"></i> {{ $joueur->telephone }}
                                                        </div>
                                                    @endif
                                                    @if ($joueur->email)
                                                        <div><i class="fas fa-envelope fa-sm"></i> {{ $joueur->email }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $joueur->colline->nom ?? '-' }}</td>
                                            <td>
                                                @if ($joueur->categorie)
                                                    <span class="badge bg-info">{{ $joueur->categorie->nom }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.joueurs.show', $joueur) }}"
                                                        class="btn btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.joueurs.edit', $joueur) }}"
                                                        class="btn btn-outline-warning" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.joueurs.destroy', $joueur) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger"
                                                            title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                                Aucun joueur trouvé.
                                                @if (request()->hasAny(['search', 'colline_id', 'categorie_id', 'sexe']))
                                                    <br>
                                                    <a href="{{ route('admin.joueurs.index') }}"
                                                        class="btn btn-sm btn-outline-secondary mt-2">
                                                        Réinitialiser les filtres
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Affichage de {{ $joueurs->firstItem() ?? 0 }} à {{ $joueurs->lastItem() ?? 0 }}
                                sur {{ $joueurs->total() }} résultats
                            </div>
                            <div>
                                {{ $joueurs->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
@endsection
