@extends('layouts.admin')

@section('title', 'Détails du club')
@section('page-title', 'Détails du club')

@section('content')
    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>{{ $club->nom }}
                    </h5>
                    <div>
                        <a href="{{ route('admin.clubs.edit', $club) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('admin.clubs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Description -->
                    @if ($club->description)
                        <div class="mb-4">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-info-circle me-2"></i>Description
                            </h6>
                            <p class="text-muted">{{ $club->description }}</p>
                        </div>
                    @endif

                    <!-- Coordonnées -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>Coordonnées
                        </h6>
                        <div class="row">
                            @if ($club->adresse)
                                <div class="col-md-12 mb-2">
                                    <i class="fas fa-home me-2 text-muted"></i>
                                    <strong>Adresse:</strong> {{ $club->adresse }}
                                </div>
                            @endif
                            @if ($club->ville || $club->code_postal)
                                <div class="col-md-12 mb-2">
                                    <i class="fas fa-city me-2 text-muted"></i>
                                    <strong>Ville:</strong>
                                    {{ $club->code_postal ? $club->code_postal : '' }}
                                    {{ $club->ville ? $club->ville : '' }}
                                </div>
                            @endif
                            @if ($club->telephone)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    <strong>Téléphone:</strong>
                                    <a href="tel:{{ $club->telephone }}">{{ $club->telephone }}</a>
                                </div>
                            @endif
                            @if ($club->email)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    <strong>Email:</strong>
                                    <a href="mailto:{{ $club->email }}">{{ $club->email }}</a>
                                </div>
                            @endif
                            @if ($club->site_web)
                                <div class="col-md-12 mb-2">
                                    <i class="fas fa-globe me-2 text-muted"></i>
                                    <strong>Site web:</strong>
                                    <a href="{{ $club->site_web }}" target="_blank">
                                        {{ $club->site_web }} <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Responsable -->
                    @if ($club->responsable || $club->tel_responsable)
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user-tie me-2"></i>Responsable
                            </h6>
                            <div class="row">
                                @if ($club->responsable)
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-user me-2 text-muted"></i>
                                        <strong>Nom:</strong> {{ $club->responsable }}
                                    </div>
                                @endif
                                @if ($club->tel_responsable)
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        <strong>Téléphone:</strong>
                                        <a href="tel:{{ $club->tel_responsable }}">{{ $club->tel_responsable }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Statistiques -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chart-bar me-2"></i>Statistiques
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-users me-2 text-muted"></i>
                                <strong>Nombre de joueurs:</strong> ({{ $club->joueurs->count() ?? 0 }})
                            </div>
                            @if ($club->capacite)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-warehouse me-2 text-muted"></i>
                                    <strong>Capacité:</strong> {{ $club->capacite }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="pt-3 border-top">
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Créé le {{ $club->created_at->format('d/m/Y à H:i') }}
                            </div>
                            <div class="col-md-6 text-md-end">
                                <i class="fas fa-calendar-check me-1"></i>
                                Modifié le {{ $club->updated_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des joueurs -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>Joueurs du club ({{ $club->joueurs->count() ?? 0 }})
                    </h5>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addPlayerModal">
                        <i class="fas fa-user-plus me-2"></i>Ajouter un joueur
                    </button>
                </div>
                <div class="card-body">
                    @if (isset($club->joueurs) && $club->joueurs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($club->joueurs as $joueur)
                                        <tr>
                                            <td>{{ $joueur->nom }}</td>
                                            <td>{{ $joueur->prenom }}</td>
                                            <td>
                                                <a href="{{ route('admin.joueurs.show', $joueur) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>Aucun joueur enregistré dans ce club.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Logo -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if ($club->logo)
                        <img src="{{ asset('storage/' . $club->logo) }}" alt="Logo {{ $club->nom }}"
                            class="img-fluid mb-3" style="max-width: 200px;">
                    @else
                        <div class="stat-icon green mb-3"
                            style="width: 150px; height: 150px; font-size: 4rem; margin: 0 auto;">
                            <i class="fas fa-building"></i>
                        </div>
                    @endif
                    <h5 class="mb-0">{{ $club->nom }}</h5>
                    <p class="text-muted mb-0">{{ $club->joueurs_count ?? 0 }} joueur(s)</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-cog me-2"></i>Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.clubs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations rapides -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-users me-1"></i> Joueurs:</span>
                        <strong>({{ $club->joueurs->count() ?? 0 }})</strong>
                    </div>
                    @if ($club->capacite)
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-warehouse me-1"></i> Capacité:</span>
                            <strong>{{ $club->capacite }}</strong>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $club->capacite > 0 ? (($club->joueurs_count ?? 0) / $club->capacite) * 100 : 0 }}%"
                                aria-valuenow="{{ $club->joueurs_count ?? 0 }}" aria-valuemin="0"
                                aria-valuemax="{{ $club->capacite }}">
                                {{ $club->capacite > 0 ? round((($club->joueurs_count ?? 0) / $club->capacite) * 100) : 0 }}%
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de joueur -->
    <div class="modal fade" id="addPlayerModal" tabindex="-1" aria-labelledby="addPlayerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.joueurs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="clubs_id" value="{{ $club->id }}">

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addPlayerModalLabel">
                            <i class="fas fa-user-plus me-2"></i>Ajouter un nouveau joueur
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Le joueur sera automatiquement ajouté au club <strong>{{ $club->nom }}</strong>
                        </div>

                        <div class="row">

                            <!-- Nom -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-user me-1"></i>Nom <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nom"
                                    class="form-control @error('nom') is-invalid @enderror" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-user me-1"></i>Prénom <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="prenom"
                                    class="form-control @error('prenom') is-invalid @enderror" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sexe -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-venus-mars me-1"></i>Genre</label>
                                <select name="sexe" class="form-select @error('sexe') is-invalid @enderror">
                                    <option value="">Sélectionner...</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                                @error('sexe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Poids -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-weight me-1"></i>Poids (kg)</label>
                                <input type="number" step="0.01" name="poids"
                                    class="form-control @error('poids') is-invalid @enderror">
                                @error('poids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Taille -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-ruler-vertical me-1"></i>Taille (cm)</label>
                                <input type="number" step="0.01" name="taille"
                                    class="form-control @error('taille') is-invalid @enderror">
                                @error('taille')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lieu de naissance -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Lieu de
                                    naissance</label>
                                <input type="text" name="lieu_naissance"
                                    class="form-control @error('lieu_naissance') is-invalid @enderror">
                                @error('lieu_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Photo -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label"><i class="fas fa-camera me-1"></i>Photo <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg"
                                    class="form-control @error('image') is-invalid @enderror" required>
                                <small class="text-muted">Formats : JPEG, PNG - Taille max : 2MB</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Enregistrer le joueur
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce club ?</p>
                    <p class="text-danger fw-bold">
                        <i class="fas fa-warning me-1"></i>Cette action est irréversible !
                    </p>
                    <p class="mb-0">
                        Club : <strong>{{ $club->nom }}</strong>
                    </p>
                    @if ($club->joueurs_count > 0)
                        <div class="alert alert-warning mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Ce club contient {{ $club->joueurs_count }} joueur(s). Ils seront également affectés.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <form action="{{ route('admin.clubs.destroy', $club) }}" method="POST" class="d-inline">
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
@endsection
