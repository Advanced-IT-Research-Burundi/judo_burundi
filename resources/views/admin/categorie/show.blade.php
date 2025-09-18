@extends('layouts.admin')

@section('title', 'Catégorie : ' . $categorie->nom)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">{{ $categorie->nom }}</h1>
            <p class="text-muted mb-0">
                Créée le {{ $categorie->created_at->format('d/m/Y à H:i') }}
                @if($categorie->updated_at != $categorie->created_at)
                    • Modifiée le {{ $categorie->updated_at->format('d/m/Y à H:i') }}
                @endif
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations générales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Nom de la catégorie</h6>
                            <p class="h5 mb-3">{{ $categorie->nom }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Nombre de joueurs</h6>
                            <p class="h5 mb-3">
                                <span class="badge bg-primary fs-6">{{ $categorie->joueurs_count }}</span>
                            </p>
                        </div>
                    </div>
                    
                    @if($categorie->description)
                        <div>
                            <h6 class="text-muted mb-1">Description</h6>
                            <p class="mb-0">{{ $categorie->description }}</p>
                        </div>
                    @else
                        <div class="alert alert-light">
                            <i class="fas fa-info-circle me-2"></i>Aucune description pour cette catégorie.
                        </div>
                    @endif
                </div>
            </div>

            @if($categorie->joueurs->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i>Joueurs de cette catégorie
                        </h5>
                        <a href="{{ route('admin.joueurs.index', ['categorie' => $categorie->id]) }}" class="btn btn-primary btn-sm">
                            Voir tous
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Joueur</th>
                                    <th>Colline</th>
                                    <th>Contact</th>
                                    <th>Inscription</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorie->joueurs->take(10) as $joueur)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ $joueur->initiales }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $joueur->nom_complet }}</h6>
                                                @if($joueur->age)
                                                    <small class="text-muted">{{ $joueur->age }} ans</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $joueur->colline->nom }}</td>
                                    <td>
                                        @if($joueur->email)
                                            <small>{{ $joueur->email }}</small>
                                        @elseif($joueur->telephone)
                                            <small>{{ $joueur->telephone }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $joueur->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($categorie->joueurs->count() > 10)
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.joueurs.index', ['categorie' => $categorie->id]) }}" class="btn btn-outline-primary">
                                Voir les {{ $categorie->joueurs->count() - 10 }} autres joueurs
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier cette catégorie
                        </a>
                        <a href="{{ route('admin.joueurs.create', ['categorie' => $categorie->id]) }}" class="btn btn-outline-success">
                            <i class="fas fa-user-plus me-2"></i>Ajouter un joueur
                        </a>
                        <hr>
                        <button class="btn btn-outline-danger" id="deleteBtn">
                            <i class="fas fa-trash me-2"></i>Supprimer cette catégorie
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 text-primary mb-1">{{ $categorie->joueurs_count }}</div>
                            <div class="text-muted small">Joueurs</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-success mb-1">
                                {{ $categorie->joueurs->where('sexe', 'M')->count() }}
                            </div>
                            <div class="text-muted small">Hommes</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 text-info mb-1">
                                {{ $categorie->joueurs->where('sexe', 'F')->count() }}
                            </div>
                            <div class="text-muted small">Femmes</div>
                        </div>
                        <div class="col-6">
                            @php
                                $avgAge = $categorie->joueurs->whereNotNull('date_naissance')->avg(function($joueur) {
                                    return $joueur->age;
                                });
                            @endphp
                            <div class="h4 text-warning mb-1">
                                {{ $avgAge ? round($avgAge) : '-' }}
                            </div>
                            <div class="text-muted small">Âge moyen</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie :</p>
                <p class="fw-bold">{{ $categorie->nom }}</p>
                @if($categorie->joueurs_count > 0)
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Impossible :</strong> Cette catégorie contient {{ $categorie->joueurs_count }} joueur(s).
                        Vous devez d'abord déplacer ou supprimer ces joueurs.
                    </div>
                @else
                    <p class="text-danger small">Cette action est irréversible.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                @if($categorie->joueurs_count == 0)
                    <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Supprimer définitivement
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fas fa-ban me-1"></i>Suppression impossible
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    deleteBtn.addEventListener('click', function() {
        deleteModal.show();
    });
});
</script>
@endpush