@extends('layouts.admin')

@section('title', 'Membres')
@section('page-title', 'Gestion des Membres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-users me-2"></i>
        Liste des Membres
    </h2>
    <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        Nouveau Membre
    </a>
</div>

{{-- Filtres de recherche --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Rechercher</label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nom, prénom, email...">
            </div>
            <div class="col-md-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-select" name="categorie" id="categorie">
                    <option value="">Toutes les catégories</option>
                    @if(isset($categories))
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" 
                                    {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label for="sexe" class="form-label">Sexe</label>
                <select class="form-select" name="sexe" id="sexe">
                    <option value="">Tous</option>
                    <option value="Masculin" {{ request('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="Féminin" {{ request('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search me-1"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($joueurs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Nom complet</th>
                            <th>Sexe</th>
                            <th>Contact</th>
                            <th>Catégorie</th>
                            <th>Colline</th>
                            <th>Âge</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($joueurs as $joueur)
                        <tr>
                            <td>{{ $joueur->id }}</td>
                            <td>
                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white">
                                    {{ strtoupper(substr($joueur->prenom, 0, 1) . substr($joueur->nom, 0, 1)) }}
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $joueur->prenom }} {{ $joueur->nom }}</strong>
                                    @if($joueur->date_naissance)
                                        <br><small class="text-muted">Né(e) le {{ $joueur->date_naissance->format('d/m/Y') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($joueur->sexe)
                                    <span class="badge {{ $joueur->sexe == 'Masculin' ? 'bg-info' : 'bg-pink' }}">
                                        {{ $joueur->sexe }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($joueur->telephone)
                                    <small><i class="fas fa-phone me-1"></i>{{ $joueur->telephone }}</small><br>
                                @endif
                                @if($joueur->email)
                                    <small><i class="fas fa-envelope me-1"></i>{{ $joueur->email }}</small>
                                @endif
                                @if(!$joueur->telephone && !$joueur->email)
                                    <span class="text-muted">Aucun contact</span>
                                @endif
                            </td>
                            <td>
                                @if($joueur->categorie)
                                    <span class="badge bg-success">{{ $joueur->categorie->nom }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($joueur->colline)
                                    <small>{{ $joueur->colline->nom ?? 'N/A' }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($joueur->date_naissance)
                                    <span class="badge bg-light text-dark">
                                        {{ $joueur->date_naissance->age }} ans
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.joueurs.show', $joueur) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.joueurs.edit', $joueur) }}" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.joueurs.destroy', $joueur) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Supprimer">
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

            <div class="d-flex justify-content-center mt-4">
                {{ $joueurs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun joueur trouvé</h5>
                <p class="text-muted">Commencez par enregistrer votre premier joueur.</p>
                <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Ajouter un joueur
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
    font-size: 0.875rem;
}
.bg-pink {
    background-color: #e91e63 !important;
}
</style>
@endpush
@endsection