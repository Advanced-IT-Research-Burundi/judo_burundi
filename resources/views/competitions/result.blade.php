@extends('layouts.user')

@section('title', 'Résultat de la compétition')

@section('content')
<div class="container py-4">
    <!-- Bouton retour -->
    <div class="mb-4">
        <a href="{{ route('competitions.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <!-- En-tête -->
    <div class="card border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div class="mb-2 mb-md-0">
                    <h2 class="mb-1 fs-4 d-flex align-items-center flex-wrap">
                        <i class="bi bi-trophy-fill me-2 fs-3"></i>
                        {{ $competition->nom }}
                    </h2>
                    <p class="mb-0 fs-6">
                        <i class="bi bi-tag-fill me-2"></i>{{ $competition->type }}
                    </p>
                </div>
                <div>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2 rounded-pill">
                        {{ $competition->saison ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-10 mx-auto">

            <!-- Informations principales -->
            <div class="card border mb-4">
                <div class="card-header bg-light py-2">
                    <h5 class="mb-0 fs-5">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Informations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <i class="bi bi-calendar-event-fill text-info fs-4 me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Date</small>
                                    <strong class="fs-6">
                                        {{ $competition->date_competition ? $competition->date_competition->format('d/m/Y') : 'À définir' }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <i class="bi bi-geo-alt-fill text-danger fs-4 me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Lieu</small>
                                    <strong class="fs-6">{{ $competition->lieu ?? 'Non défini' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clubs participants -->
            @if($competition->clubDomicile || $competition->clubAdversaire)
            <div class="card border mb-4">
                <div class="card-header bg-light py-2">
                    <h5 class="mb-0 fs-5">
                        <i class="bi bi-people-fill text-success me-2"></i>
                        Clubs participants
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center align-items-center">
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <div class="p-4 bg-success bg-opacity-10 rounded">
                                <i class="bi bi-house-fill text-success fs-1 mb-2 d-block"></i>
                                <h5 class="mb-1 fs-6">{{ $competition->clubDomicile->nom ?? 'N/A' }}</h5>
                                <span class="badge bg-success">Domicile</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 my-2 my-md-0">
                            <h4 class="fw-bold text-muted mb-0">VS</h4>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="p-4 bg-primary bg-opacity-10 rounded">
                                <i class="bi bi-airplane-fill text-primary fs-1 mb-2 d-block"></i>
                                <h5 class="mb-1 fs-6">{{ $competition->clubAdversaire->nom ?? 'N/A' }}</h5>
                                <span class="badge bg-primary">Adversaire</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($competition->description)
            <div class="card border mb-4">
                <div class="card-header bg-light py-2">
                    <h5 class="mb-0 fs-5">
                        <i class="bi bi-file-text-fill text-secondary me-2"></i>
                        Description
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0 fs-6">{{ $competition->description }}</p>
                </div>
            </div>
            @endif

            <!-- Résultats détaillés -->
            @if($competition->resultat)
            <div class="card border mb-4">
                <div class="card-header bg-warning text-dark py-2">
                    <h5 class="mb-0 fs-5">
                        <i class="bi bi-award-fill me-2"></i>
                        Résultats détaillés
                    </h5>
                </div>
                <div class="card-body bg-light">
                    <div class="resultat-content fs-6">
                        {!! $competition->resultat !!}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

