@extends('layouts.admin')

@section('title', $joueur->prenom . ' ' . $joueur->nom)
@section('page-title', 'Profil du Joueur')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">
            <i class="fas fa-user me-2"></i>
            {{ $joueur->prenom }} {{ $joueur->nom }}
        </h2>
        <div class="btn-group">
            <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>
                Modifier
            </a>
            <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div
                                class="avatar-xl bg-primary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto">
                                {{ strtoupper(substr($joueur->prenom, 0, 1) . substr($joueur->nom, 0, 1)) }}
                            </div>
                        </div>
                        <div class="col-md-10 d-flex align-items-center">
                            <div>
                                <h4 class="mb-1">{{ $joueur->prenom }} {{ $joueur->nom }}</h4>
                                <div class="d-flex gap-2 mb-2">
                                    @if ($joueur->sexe)
                                        <span class="badge {{ $joueur->sexe == 'Masculin' ? 'bg-info' : 'bg-pink' }}">
                                            {{ $joueur->sexe }}
                                        </span>
                                    @endif
                                    @if ($joueur->date_naissance)
                                        <span class="badge bg-light text-dark">
                                            {{ $joueur->date_naissance->age }} ans
                                        </span>
                                    @endif
                                    @if ($joueur->categorie)
                                        <span class="badge bg-success">{{ $joueur->categorie->nom }}</span>
                                    @endif
                                </div>
                                <small class="text-muted">Joueur #{{ $joueur->id }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informations de base</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nom complet :</strong></td>
                                    <td>{{ $joueur->prenom }} {{ $joueur->nom }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date de naissance :</strong></td>
                                    <td>
                                        @if ($joueur->date_naissance)
                                            {{ $joueur->date_naissance->format('d/m/Y') }}
                                            <small class="text-muted">({{ $joueur->date_naissance->age }} ans)</small>
                                        @else
                                            <span class="text-muted">Non renseignée</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Lieu de naissance :</strong></td>
                                    <td>
                                        @if ($joueur->lieu_naissance)
                                            {{ $joueur->lieu_naissance }}
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Sexe :</strong></td>
                                    <td>
                                        @if ($joueur->sexe)
                                            <span class="badge {{ $joueur->sexe == 'Masculin' ? 'bg-info' : 'bg-pink' }}">
                                                {{ $joueur->sexe }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non spécifié</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Contact</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Téléphone :</strong></td>
                                    <td>
                                        @if ($joueur->telephone)
                                            <a href="tel:{{ $joueur->telephone }}" class="text-decoration-none">
                                                <i class="fas fa-phone me-1"></i>{{ $joueur->telephone }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Email :</strong></td>
                                    <td>
                                        @if ($joueur->email)
                                            <a href="mailto:{{ $joueur->email }}" class="text-decoration-none">
                                                <i class="fas fa-envelope me-1"></i>{{ $joueur->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Statut contact :</strong></td>
                                    <td>
                                        @if ($joueur->telephone || $joueur->email)
                                            <span class="badge bg-success">Joignable</span>
                                        @else
                                            <span class="badge bg-warning">Pas de contact</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Classification et localisation
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Catégorie</h6>
                            @if ($joueur->categorie)
                                <div class="card border-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-tag text-success me-2"></i>
                                            <h6 class="mb-0">{{ $joueur->categorie->nom }}</h6>
                                        </div>
                                        @if ($joueur->categorie->description)
                                            <p class="small text-muted mb-2">{{ $joueur->categorie->description }}</p>
                                        @endif
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                {{ $joueur->categorie->joueurs->count() }} joueur(s) dans cette catégorie
                                            </small>
                                            <a href="{{ route('admin.categories.show', $joueur->categorie) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye me-1"></i>
                                                Voir catégorie
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Aucune catégorie assignée
                                </div>
                            @endif
                        </div>
                        {{-- <div class="col-md-6">
                        <h6 class="text-muted mb-3">Colline</h6>
                        @if ($joueur->colline)
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt text-info me-2"></i>
                                        <h6 class="mb-0">{{ $joueur->colline->nom }}</h6>
                                    </div>
                                    @if (isset($joueur->colline->description))
                                        <p class="small text-muted mb-2">{{ $joueur->colline->description }}</p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if (method_exists($joueur->colline, 'joueurs'))
                                            <small class="text-muted">
                                                {{ $joueur->colline->joueurs->count() }} joueur(s) de cette colline
                                            </small>
                                        @endif
                                        @if (Route::has('admin.collines.show'))
                                            <a href="{{ route('admin.collines.show', $joueur->colline) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i>
                                                Voir colline
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Aucune colline assignée
                            </div>
                        @endif
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistiques rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Profil complété :</span>
                        @php
                            $completed_fields = 0;
                            $total_fields = 8; // nom, prenom, date_naissance, lieu_naissance, sexe, telephone, email, colline_id, categorie_id

                            if ($joueur->nom) {
                                $completed_fields++;
                            }
                            if ($joueur->prenom) {
                                $completed_fields++;
                            }
                            if ($joueur->date_naissance) {
                                $completed_fields++;
                            }
                            if ($joueur->lieu_naissance) {
                                $completed_fields++;
                            }
                            if ($joueur->sexe) {
                                $completed_fields++;
                            }
                            if ($joueur->telephone) {
                                $completed_fields++;
                            }
                            if ($joueur->email) {
                                $completed_fields++;
                            }
                            if ($joueur->categorie_id) {
                                $completed_fields++;
                            }

                            $percentage = round(($completed_fields / $total_fields) * 100);
                        @endphp
                        <span
                            class="badge bg-{{ $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }}">
                            {{ $percentage }}%
                        </span>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-{{ $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }}"
                            style="width: {{ $percentage }}%"></div>
                    </div>

                    <div class="small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Âge :</span>
                            <span>
                                @if ($joueur->date_naissance)
                                    {{ $joueur->date_naissance->age }} ans
                                @else
                                    <span class="text-warning">Non défini</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Contact :</span>
                            <span>
                                @if ($joueur->telephone || $joueur->email)
                                    <i class="fas fa-check text-success"></i>
                                @else
                                    <i class="fas fa-times text-danger"></i>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Classification :</span>
                            <span>
                                @if ($joueur->categorie_id)
                                    <i class="fas fa-check text-success"></i>
                                @else
                                    <i class="fas fa-times text-danger"></i>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations système
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-2">
                            <strong>ID :</strong> #{{ $joueur->id }}
                        </div>
                        <div class="mb-2">
                            <strong>Créé le :</strong><br>
                            {{ $joueur->created_at->format('d/m/Y à H:i') }}
                            <small class="text-muted d-block">{{ $joueur->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="mb-0">
                            <strong>Modifié le :</strong><br>
                            {{ $joueur->updated_at->format('d/m/Y à H:i') }}
                            <small class="text-muted d-block">{{ $joueur->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Modifier ce membre
                        </a>
                        <a href="{{ route('admin.joueurs.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>
                            Nouveau membre
                        </a>
                        {{-- <hr class="my-2">
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            La suppression est irréversible.
                        </div> --}}
                        <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                Supprimer définitivement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .avatar-xl {
                width: 5rem;
                height: 5rem;
                font-size: 2rem;
            }

            .bg-pink {
                background-color: #e91e63 !important;
            }
        </style>
    @endpush
@endsection
