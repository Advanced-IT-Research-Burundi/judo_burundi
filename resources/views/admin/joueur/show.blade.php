@extends('layouts.admin')

@section('title', 'Joueur : ' . $joueur->nom_complet)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                     style="width: 60px; height: 60px; font-size: 1.5rem;">
                    {{ $joueur->initiales }}
                </div>
                <div>
                    <h1 class="h3 mb-1">{{ $joueur->nom_complet }}</h1>
                    <p class="text-muted mb-0">
                        {{ $joueur->categorie->nom }} • {{ $joueur->colline->nom }}
                        @if($joueur->age)
                            • {{ $joueur->age }} ans
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Informations personnelles -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Nom complet</h6>
                            <p class="h5 mb-0">{{ $joueur->nom_complet }}</p>
                        </div>
                        
                        @if($joueur->date_naissance)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-1">Date de naissance</h6>
                                <p class="mb-0">
                                    {{ $joueur->date_naissance->format('d/m/Y') }}
                                    <span class="badge bg-info ms-2">{{ $joueur->age }} ans</span>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        @if($joueur->sexe)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-1">Sexe</h6>
                                <p class="mb-0">
                                    <i class="fas fa-{{ $joueur->sexe == 'M' ? 'mars' : 'venus' }} me-2"></i>
                                    {{ $joueur->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                                </p>
                            </div>
                        @endif

                        @if($joueur->lieu_naissance)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-1">Lieu de naissance</h6>
                                <p class="mb-0">
                                    <i class="fas fa-map-pin me-2"></i>{{ $joueur->lieu_naissance }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informations de contact -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-address-book me-2"></i>Informations de contact
                    </h5>
                </div>
                <div class="card-body">
                    @if($joueur->email || $joueur->telephone)
                        <div class="row">
                            @if($joueur->email)
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted mb-1">Email</h6>
                                    <p class="mb-0">
                                        <i class="fas fa-envelope me-2"></i>
                                        <a href="mailto:{{ $joueur->email }}" class="text-decoration-none">
                                            {{ $joueur->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if($joueur->telephone)
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted mb-1">Téléphone</h6>
                                    <p class="mb-0">
                                        <i class="fas fa-phone me-2"></i>
                                        <a href="tel:{{ $joueur->telephone }}" class="text-decoration-none">
                                            {{ $joueur->telephone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-light">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune information de contact disponible.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Affiliation -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Affiliation
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Catégorie</h6>
                            <div>
                                <span class="badge bg-primary fs-6">{{ $joueur->categorie->nom }}</span>
                                @if($joueur->categorie->description)
                                    <p class="text-muted small mt-2 mb-0">{{ $joueur->categorie->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1">Colline</h6>
                            <div>
                                <p class="h6 mb-1">{{ $joueur->colline->nom }}</p>
                                @if($joueur->colline->zone)
                                    <p class="text-muted small mb-0">Zone : {{ $joueur->colline->zone->nom }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier ce joueur
                        </a>
                        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-user-plus me-2"></i>Ajouter un nouveau joueur
                        </a>
                        <hr>
                        <button class="btn btn-outline-danger" id="deleteBtn">
                            <i class="fas fa-trash me-2"></i>Supprimer ce joueur
                        </button>
                    </div>
                </div>
            </div>

            <!-- Informations système -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations système
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">ID du joueur</h6>
                        <code>#{{ $joueur->id }}</code>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Date d'inscription</h6>
                        <p class="mb-0">{{ $joueur->created_at->format('d/m/Y à H:i') }}</p>
                        <small class="text-muted">{{ $joueur->created_at->diffForHumans() }}</small>
                    </div>

                    @if($joueur->updated_at != $joueur->created_at)
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Dernière modification</h6>
                            <p class="mb-0">{{ $joueur->updated_at->format('d/m/Y à H:i') }}</p>
                            <small class="text-muted">{{ $joueur->updated_at->diffForHumans() }}</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            @php
                $nextJoueur = App\Models\Joueur::where('id', '>', $joueur->id)->orderBy('id')->first();
                $prevJoueur = App\Models\Joueur::where('id', '<', $joueur->id)->orderBy('id', 'desc')->first();
            @endphp

            @if($nextJoueur || $prevJoueur)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-arrow-circle-right me-2"></i>Navigation
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($prevJoueur)
                            <a href="{{ route('admin.joueurs.show', $prevJoueur) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="fas fa-chevron-left me-2"></i>{{ Str::limit($prevJoueur->nom_complet, 25) }}
                            </a>
                        @endif

                        @if($nextJoueur)
                            <a href="{{ route('admin.joueurs.show', $nextJoueur) }}" class="btn btn-outline-primary btn-sm w-100">
                                {{ Str::limit($nextJoueur->nom_complet, 25) }}<i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
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
                <p>Êtes-vous sûr de vouloir supprimer le joueur :</p>
                <p class="fw-bold">{{ $joueur->nom_complet }}</p>
                <p class="text-danger small mb-0">Cette action supprimera définitivement toutes les données du joueur.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('admin.joueurs.destroy', $joueur) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Supprimer définitivement
                    </button>
                </form>
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