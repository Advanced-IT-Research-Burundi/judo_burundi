@extends('layouts.admin')

@section('title', 'Détails du joueur')
@section('page-title', 'Détails du joueur')

@section('content')
<div class="row">
    <!-- Informations principales -->
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>{{ $joueur->nom }} {{ $joueur->prenom }}
                </h5>
                <div>
                    <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Informations personnelles -->
                <div class="mb-4">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-id-card me-2"></i>Informations personnelles
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Nom :</strong> {{ $joueur->nom }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Prénom :</strong> {{ $joueur->prenom }}
                        </div>
                        @if($joueur->sexe)
                            <div class="col-md-6 mb-2">
                                <strong>Sexe :</strong> {{ ucfirst($joueur->sexe) }}
                            </div>
                        @endif
                        @if($joueur->poids)
                            <div class="col-md-6 mb-2">
                                <strong>Poids :</strong> {{ $joueur->poids }} kg
                            </div>
                        @endif
                        @if($joueur->taille)
                            <div class="col-md-6 mb-2">
                                <strong>Taille :</strong> {{ $joueur->taille }} cm
                            </div>
                        @endif
                        @if($joueur->lieu_naissance)
                            <div class="col-md-6 mb-2">
                                <strong>Lieu de naissance :</strong> {{ $joueur->lieu_naissance }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Club -->
                @if($joueur->club)
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-building me-2"></i>Club d'appartenance
                        </h6>
                        <p class="mb-1">
                            <strong>Nom du club :</strong> 
                            <a href="{{ route('admin.clubs.show', $joueur->club) }}" class="text-decoration-none">
                                {{ $joueur->club->nom }}
                            </a>
                        </p>
                    </div>
                @endif

                <!-- Dates -->
                <div class="pt-3 border-top">
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-calendar-plus me-1"></i>
                            Créé le {{ $joueur->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <i class="fas fa-calendar-check me-1"></i>
                            Modifié le {{ $joueur->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions supplémentaires -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Autres actions</h6>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Modifier le joueur
                    </a>
                    <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce joueur ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Image -->
        <div class="card shadow-sm mb-4 text-center">
            <div class="card-body">
                @if($joueur->image)
                    <img src="{{ asset('storage/' . $joueur->image) }}" 
                         alt="Photo de {{ $joueur->nom }}" 
                         class="img-fluid rounded-circle mb-3" 
                         style="max-width: 200px; height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mb-3" 
                         style="width: 200px; height: 200px; margin: 0 auto;">
                        <i class="fas fa-user fa-5x text-muted"></i>
                    </div>
                @endif
                <h5 class="mb-1">{{ $joueur->nom }} {{ $joueur->prenom }}</h5>
                <p class="text-muted mb-0">{{ $joueur->club ? $joueur->club->nom : 'Aucun club' }}</p>
            </div>
        </div>

        <!-- Infos rapides -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informations rapides
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-venus-mars me-1"></i> Sexe :</span>
                    <strong>{{ $joueur->sexe ?? '-' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-weight me-1"></i> Poids :</span>
                    <strong>{{ $joueur->poids ? $joueur->poids . ' kg' : '-' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-ruler-vertical me-1"></i> Taille :</span>
                    <strong>{{ $joueur->taille ? $joueur->taille . ' cm' : '-' }}</strong>
                </div>
                @if($joueur->lieu_naissance)
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-map-marker-alt me-1"></i> Lieu :</span>
                    <strong>{{ $joueur->lieu_naissance }}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
