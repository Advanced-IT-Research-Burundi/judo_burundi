@extends('layouts.admin')

@section('title', 'Gestion des Joueurs')
@section('page-title', 'Gestion des Joueurs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Liste des Joueurs ({{ $joueurs->total() }})</h4>
            <p class="text-muted">Gérez les inscriptions et informations des judokas</p>
        </div>
        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un Joueur
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Rechercher</label>
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nom, prénom, email...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" 
                                    {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sexe</label>
                    <select name="sexe" class="form-select">
                        <option value="">Tous</option>
                        <option value="M" {{ request('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ request('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des joueurs -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Joueurs Inscrits</h5>
        </div>
        <div class="card-body p-0">
            @if($joueurs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>Nom Complet</th>
                                <th>Contact</th>
                                <th>Catégorie</th>
                                <th>Âge</th>
                                <th>Inscription</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($joueurs as $joueur)
                                <tr>
                                    <td>
                                        <div class="avatar">
                                            {{ strtoupper(substr($joueur->prenom, 0, 1) . substr($joueur->nom, 0, 1)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $joueur->nom_complet }}</strong>
                                            @if($joueur->sexe)
                                                <small class="badge bg-{{ $joueur->sexe === 'M' ? 'primary' : 'pink' }}">
                                                    {{ $joueur->sexe === 'M' ? 'M' : 'F' }}
                                                </small>
                                            @endif
                                        </div>
                                        @if($joueur->lieu_naissance)
                                            <small class="text-muted">{{ $joueur->lieu_naissance }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($joueur->email)
                                            <div><i class="fas fa-envelope me-1"></i>{{ $joueur->email }}</div>
                                        @endif
                                        @if($joueur->telephone)
                                            <div><i class="fas fa-phone me-1"></i>{{ $joueur->telephone }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $joueur->categorie->nom ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        {{ $joueur->age ? $joueur->age . ' ans' : 'N/A' }}
                                    </td>
                                    <td>
                                        <small>{{ $joueur->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.joueurs.show', $joueur) }}" 
                                               class="btn btn-sm btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.joueurs.edit', $joueur) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete({{ $joueur->id }}, '{{ $joueur->nom_complet }}')" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer">
                    {{ $joueurs->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun joueur trouvé</h5>
                    <p class="text-muted">Commencez par ajouter votre premier joueur</p>
                    <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter un Joueur
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer le joueur <strong id="joueurName"></strong> ?</p>
                    <p class="text-danger"><small>Cette action est irréversible.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        document.getElementById('joueurName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/joueurs/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush