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

    <!-- Messages de session -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px; font-weight: bold;">
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
                                            <div><i class="fas fa-envelope me-1 text-muted"></i>{{ $joueur->email }}</div>
                                        @endif
                                        @if($joueur->telephone)
                                            <div><i class="fas fa-phone me-1 text-muted"></i>{{ $joueur->telephone }}</div>
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
                                            <form method="POST" 
                                                  action="{{ route('admin.joueurs.destroy', $joueur) }}" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $joueur->nom_complet }} ? Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'categorie_id', 'sexe']))
                            Aucun joueur ne correspond à vos critères de recherche.
                        @else
                            Commencez par ajouter votre premier joueur.
                        @endif
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter un Joueur
                        </a>
                        @if(request()->hasAny(['search', 'categorie_id', 'sexe']))
                            <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-times me-2"></i>Effacer les filtres
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions en lot (optionnel) -->
    @if($joueurs->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Actions rapides</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        {{-- <a href="{{ route('admin.joueurs.export') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-download me-2"></i>Exporter la liste
                        </a> --}}
                    </div>
                    {{-- <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-upload me-2"></i>Importer des joueurs
                        </button>
                    </div> --}}
                    <div class="col-md-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-tags me-2"></i>Gérer les catégories
                        </a>
                    </div>
                    <div class="col-md-3">
                        {{-- <a href="{{ route('admin.collines.index') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-map-marker-alt me-2"></i>Gérer les collines
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
<style>
.avatar {
    width: 40px;
    height: 40px;
    font-size: 14px;
    font-weight: bold;
}

.badge.bg-pink {
    background-color: #e91e63 !important;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush