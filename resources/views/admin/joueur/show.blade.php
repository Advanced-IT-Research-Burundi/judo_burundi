@extends('layouts.admin')

@section('title', 'Détails du Joueur')


@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> {{ $joueur->nom_complet }}
                        </h3>
                        <div>
                            <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button type="button" 
                                    class="btn btn-danger btn-sm"
                                    onclick="confirmerSuppression({{ $joueur->id }})">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Informations personnelles -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-primary">
                                <i class="fas fa-user"></i> Informations personnelles
                            </h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Nom :</td>
                                    <td>{{ $joueur->nom }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Prénom :</td>
                                    <td>{{ $joueur->prenom }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Date de naissance :</td>
                                    <td>
                                        @if($joueur->date_naissance)
                                            {{ $joueur->date_naissance->format('d/m/Y') }}
                                            @if($joueur->age)
                                                <span class="badge bg-light text-dark ms-2">{{ $joueur->age }} ans</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Non renseignée</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Lieu de naissance :</td>
                                    <td>{{ $joueur->lieu_naissance ?? 'Non renseigné' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sexe :</td>
                                    <td>
                                        @if($joueur->sexe)
                                            <span class="badge {{ $joueur->sexe == 'M' ? 'bg-primary' : 'bg-pink' }}">
                                                {{ $joueur->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Coordonnées et affiliation -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-success">
                                <i class="fas fa-address-book"></i> Coordonnées
                            </h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Téléphone :</td>
                                    <td>
                                        @if($joueur->telephone)
                                            <a href="tel:{{ $joueur->telephone }}" class="text-decoration-none">
                                                <i class="fas fa-phone"></i> {{ $joueur->telephone }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email :</td>
                                    <td>
                                        @if($joueur->email)
                                            <a href="mailto:{{ $joueur->email }}" class="text-decoration-none">
                                                <i class="fas fa-envelope"></i> {{ $joueur->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <h5 class="mb-3 text-warning mt-4">
                                <i class="fas fa-tags"></i> Affiliation
                            </h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Colline :</td>
                                    <td>
                                        @if($joueur->colline)
                                            <span class="badge bg-secondary">{{ $joueur->colline->name }}</span>
                                        @else
                                            <span class="text-muted">Non assignée</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Catégorie :</td>
                                    <td>
                                        @if($joueur->categorie)
                                            <span class="badge bg-info">{{ $joueur->categorie->nom }}</span>
                                        @else
                                            <span class="text-muted">Non assignée</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Informations système -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3 text-muted">
                                <i class="fas fa-info-circle"></i> Informations système
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Créé le :</strong> {{ $joueur->created_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Modifié le :</strong> {{ $joueur->updated_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                        <div>
                            <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmerSuppression(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?\n\nCette action est irréversible.')) {
        const form = document.getElementById('delete-form');
        form.action = '{{ route("admin.joueurs.destroy", "") }}/' + id;
        form.submit();
    }
}
</script>
@endsection