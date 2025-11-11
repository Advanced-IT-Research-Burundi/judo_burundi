@extends('layouts.user')

@section('title', 'Liste des Compétitions')
@section('content')
<div class="container py-5">
    <!-- En-tête -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">
            <i class="bi bi-trophy-fill text-warning me-2"></i>
            Nos Compétitions
        </h1>
        <p class="text-muted">Découvrez tous nos événements et résultats</p>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-md-4">
            <select class="form-select" id="filterType">
                <option value="">Tous les types</option>
                <option value="Cadets">Cadets</option>
                <option value="Benjamins">Benjamins</option>
                <option value="Minimes">Minimes</option>
                <option value="Juniors">Juniors</option>
                <option value="Séniors">Séniors</option>
                <option value="Kata">Kata</option>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="filterSaison">
                <option value="">Toutes les saisons</option>
                @foreach($saisons as $saison)
                    <option value="{{ $saison }}">{{ $saison }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchCompetition" placeholder="Rechercher...">
        </div>
    </div>

    <!-- Liste des compétitions -->
    <div class="row g-4">
        @forelse($competitions as $competition)
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm hover-shadow transition">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ $competition->nom }}
                        </h5>
                        <span class="badge bg-light text-dark">{{ $competition->type }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informations -->
                    <div class="mb-3">
                        <p class="mb-2">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                            <strong>Lieu:</strong> {{ $competition->lieu ?? 'Non défini' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-calendar3 text-info me-2"></i>
                            <strong>Date:</strong> {{ $competition->date_competition ? $competition->date_competition->format('d/m/Y') : 'À définir' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-clock-history text-warning me-2"></i>
                            <strong>Saison:</strong> {{ $competition->saison ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Clubs -->
                    @if($competition->clubDomicile || $competition->clubAdversaire)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                        <div class="text-center flex-fill">
                            <i class="bi bi-house-fill text-success fs-4"></i>
                            <p class="mb-0 small fw-bold">{{ $competition->clubDomicile->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="text-center">
                            <span class="badge bg-secondary">VS</span>
                        </div>
                        <div class="text-center flex-fill">
                            <i class="bi bi-airplane-fill text-primary fs-4"></i>
                            <p class="mb-0 small fw-bold">{{ $competition->clubAdversaire->nom ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Description -->
                    @if($competition->description)
                    <p class="text-muted small">
                        {{ Str::limit($competition->description, 100) }}
                    </p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('competitions.result', $competition->id) }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye me-2"></i>Voir les détails
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-3"></i>
                <p class="mb-0 mt-2">Aucune compétition disponible pour le moment.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $competitions->links() }}
    </div>
</div>
@endsection
