@extends('layouts.user')

@section('title', $club->nom . ' — Vue d’ensemble')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/competition-hub.css') }}">
@endpush

@section('content')
<section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo3.jpg') }}');">
    <div class="page-hero-content">
        <h1>{{ $club->nom }}</h1>
        <p>Vue d’ensemble et compétitions</p>
        <div class="page-hero-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('clubs.index') }}">Clubs</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $club->nom }}</span>
        </div>
    </div>
</section>

<div class="py-5 bg-body-secondary">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('clubs.results', $club) }}" class="btn btn-dark rounded-pill px-4">Résultats du club</a>
            <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary rounded-pill">Tous les clubs</a>
        </div>

        <div class="comp-hub-stats rounded-3 mb-4 py-4 px-3">
            <div class="row row-cols-2 row-cols-md-5 g-3 text-center align-items-center">
                <div class="col">
                    <div class="stat-num">{{ $stats['competitions_count'] }}</div>
                    <div class="stat-label mt-2">Compétitions</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['judokas_count'] }}</div>
                    <div class="stat-label mt-2">Judokas</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['gold'] }}</div>
                    <div class="stat-label mt-2">Or</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['silver'] }}</div>
                    <div class="stat-label mt-2">Argent</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['bronze'] }}</div>
                    <div class="stat-label mt-2">Bronze</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-semibold py-3 d-flex justify-content-between align-items-center">
                        <span>Compétitions récentes</span>
                        <a href="{{ route('competitions.index') }}" class="small">Calendrier national</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-uppercase">
                                <tr>
                                    <th>Épreuve</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($competitions as $c)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $c->nom }}</span>
                                            @if($c->saison)<div class="small text-muted">{{ $c->saison }}</div>@endif
                                        </td>
                                        <td class="text-nowrap small">{{ $c->date_competition ? $c->date_competition->format('d/m/Y') : '—' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('competitions.show', $c) }}" class="btn btn-sm btn-outline-primary">Hub</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Aucune compétition liée à ce club pour le moment.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white fw-semibold py-3">Derniers résultats</div>
                    <ul class="list-group list-group-flush">
                        @forelse($latestResults as $line)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="small text-muted">{{ $line->competition?->nom }}</div>
                                    <div class="fw-medium">{{ $line->joueur?->nom }} {{ $line->joueur?->prenom }}</div>
                                    <div class="small">{{ $line->categorie_label }}</div>
                                </div>
                                <span class="badge bg-primary-subtle text-primary border">{{ $line->placement ?? '—' }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted small">Pas encore de résultats structurés.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <h2 class="h5 fw-bold mt-5 mb-3">Judokas du club</h2>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
            @foreach($judokas as $j)
                <div class="col">
                    <a href="{{ route('judokas.show', [$club, $j]) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0 text-center py-3">
                            @if($j->image)
                                <img src="{{ asset('storage/'.$j->image) }}" alt="" class="rounded-circle mx-auto mb-2 object-fit-cover" style="width:72px;height:72px;">
                            @else
                                <div class="rounded-circle bg-light mx-auto mb-2 d-flex align-items-center justify-content-center text-muted" style="width:72px;height:72px;">
                                    <i class="bi bi-person fs-3"></i>
                                </div>
                            @endif
                            <div class="small fw-semibold text-uppercase px-2">{{ $j->nom }}</div>
                            <div class="small text-muted">{{ $j->prenom }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
