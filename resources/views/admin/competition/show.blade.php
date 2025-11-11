@extends('layouts.admin')
@section('title', $competition->nom)
@section('page-title', 'Détails de la Compétition')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
    <a href="{{ route('admin.competitions.edit', $competition->id) }}" class="btn btn-warning">
        <i class="bi bi-pencil-square me-2"></i>Modifier
    </a>
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
        <i class="bi bi-trash me-2"></i>Supprimer
    </button>
</div>

<div class="row g-4">
    <!-- Informations principales -->
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-trophy-fill me-2"></i>
                    {{ $competition->nom }}
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th width="200"><i class="bi bi-tag text-primary me-2"></i>Type</th>
                            <td><span class="badge bg-info">{{ $competition->type }}</span></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-geo-alt text-danger me-2"></i>Lieu</th>
                            <td>{{ $competition->lieu ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-calendar-event text-success me-2"></i>Date</th>
                            <td>{{ $competition->date_competition ? $competition->date_competition->format('d/m/Y à H:i') : 'À définir' }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-clock-history text-warning me-2"></i>Saison</th>
                            <td>{{ $competition->saison ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-house-fill text-success me-2"></i>Club Domicile</th>
                            <td>
                                @if($competition->clubDomicile)
                                    <a href="{{ route('admin.clubs.show', $competition->clubDomicile->id) }}" class="text-decoration-none">
                                        {{ $competition->clubDomicile->nom }}
                                    </a>
                                @else
                                    <span class="text-muted">Non défini</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-airplane-fill text-primary me-2"></i>Club Adversaire</th>
                            <td>
                                @if($competition->clubAdversaire)
                                    <a href="{{ route('admin.clubs.show', $competition->clubAdversaire->id) }}" class="text-decoration-none">
                                        {{ $competition->clubAdversaire->nom }}
                                    </a>
                                @else
                                    <span class="text-muted">Non défini</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Description -->
        @if($competition->description)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-file-text text-secondary me-2"></i>Description</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $competition->description }}</p>
            </div>
        </div>
        @endif

        <!-- Résultats -->
        @if($competition->resultat)
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-award text-dark me-2"></i>Résultats détaillés</h5>
            </div>
            <div class="card-body">
                {!! $competition->resultat !!}
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Métadonnées -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Métadonnées</h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <i class="bi bi-hash text-primary me-2"></i>
                    <strong>ID:</strong> {{ $competition->id }}
                </p>
                <p class="mb-2">
                    <i class="bi bi-calendar-plus text-success me-2"></i>
                    <strong>Créé le:</strong><br>
                    <small>{{ $competition->created_at->format('d/m/Y à H:i') }}</small>
                </p>
                <p class="mb-0">
                    <i class="bi bi-arrow-repeat text-info me-2"></i>
                    <strong>Modifié le:</strong><br>
                    <small>{{ $competition->updated_at->format('d/m/Y à H:i') }}</small>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette compétition ?</p>
                <p class="text-danger fw-bold">Cette action est irréversible !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.competitions.destroy', $competition->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
