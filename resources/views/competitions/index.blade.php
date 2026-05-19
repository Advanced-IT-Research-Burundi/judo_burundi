@extends('layouts.user')

@section('title', 'Compétitions et résultats — Fédération de Judo du Burundi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/activites.css') }}">
<link rel="stylesheet" href="{{ asset('css/club-results.css') }}">
@endpush

@section('content')
    <section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo2.jpg') }}');">
        <div class="page-hero-content">
            <h1>Compétitions &amp; résultats</h1>
            <p>Liste des compétitions, catégories de poids et participants par club</p>
            <div class="page-hero-breadcrumb">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
                <i class="fas fa-chevron-right"></i>
                <span>Compétitions</span>
            </div>
        </div>
    </section>

    <section class="py-5 bg-body-secondary competition-index-shell">
        <div class="container">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form method="get" action="{{ route('competitions.index') }}" class="row g-3 align-items-end mb-0">
                        <div class="col-md-4">
                            <label for="filterSaison" class="form-label fw-semibold">Saison</label>
                            <select name="saison" id="filterSaison" class="form-select form-select-lg">
                                <option value="">Toutes les saisons</option>
                                @foreach($saisons as $saison)
                                    <option value="{{ $saison }}" @selected(($filterSaison ?? '') === $saison)>
                                        {{ $saison }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filterType" class="form-label fw-semibold">Catégorie</label>
                            <select name="type" id="filterType" class="form-select form-select-lg">
                                <option value="">Toutes les catégories</option>
                                @foreach($types as $t)
                                    <option value="{{ $t }}" @selected(($filterType ?? '') === $t)>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="compSearch" class="form-label fw-semibold">Rechercher</label>
                            <input type="search" name="q" id="compSearch" value="{{ $q ?? '' }}"
                                   class="form-control form-control-lg" placeholder="Compétition, lieu…" autocomplete="off">
                        </div>
                    </form>
                </div>
            </div>

            @forelse($competitions as $competition)
                @php($resultsByCategory = $competition->judokaResultsGroupedByCategory())
                @php($participantCount = $resultsByCategory->sum(fn ($rows) => $rows->count()))
                <div class="card shadow-sm border-0 mb-4 overflow-hidden competition-index-card">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div class="min-w-0">
                                <h2 class="h5 fw-bold mb-1">
                                    <a href="{{ route('competitions.show', $competition) }}" class="text-primary text-decoration-none text-break">
                                        {{ $competition->nom }}
                                    </a>
                                </h2>
                                <div class="small text-muted">
                                    @if($competition->lieu)
                                        <span><i class="fas fa-map-marker-alt me-1"></i>{{ $competition->lieu }}</span>
                                    @endif
                                    @if($competition->date_competition)
                                        <span class="ms-md-3 d-inline-block mt-1 mt-md-0">
                                            <i class="far fa-calendar-alt me-1"></i>{{ $competition->date_competition->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    @if($competition->type)
                                        <span class="ms-md-3 d-inline-block mt-1 mt-md-0">{{ $competition->type }}</span>
                                    @endif
                                </div>
                                @php($clubLabels = $competition->participatingClubLabels())
                                @if(count($clubLabels))
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @foreach($clubLabels as $nomClub)
                                            <span class="badge rounded-pill bg-light text-dark border fw-normal">{{ $nomClub }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('competitions.show', $competition) }}" class="btn btn-outline-primary btn-sm">
                                    Fiche détaillée <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 bg-white">
                        <div class="px-3 py-2 border-bottom small fw-semibold text-uppercase text-muted">
                            Participants
                            <span class="text-body-secondary fw-normal text-lowercase">({{ $participantCount }} ligne{{ $participantCount > 1 ? 's' : '' }} au tableau)</span>
                        </div>
                        @if($participantCount === 0)
                            <div class="p-4 text-muted small mb-0">
                                Aucun participant renseigné pour cette compétition. Ajoutez des lignes dans l’administration (résultats judoka), avec catégorie, ou ouvrez la fiche pour plus de détails.
                            </div>
                        @else
                            @foreach($resultsByCategory as $categoryLabel => $rows)
                                <div class="competition-index-category-head">{{ $categoryLabel }}</div>
                                @foreach($rows as $r)
                                    @php($j = $r->joueur)
                                    @php($jClub = $j?->club)
                                    @php($codeBadge = $jClub ? $jClub->displayCode(3) : (trim((string) ($r->pays_code ?? '')) !== '' ? strtoupper(mb_substr(preg_replace('/\s+/u', '', (string) $r->pays_code), 0, 3)) : '—'))
                                    <div class="club-res-line {{ $r->medalBorderClass() }}">
                                        <div class="club-res-rank text-center">{{ $r->placement ?? '—' }}</div>
                                        <div class="club-res-photo flex-shrink-0">
                                            @if($j && $j->image)
                                                <img src="{{ asset('storage/'.$j->image) }}" alt="" class="judoka-thumb rounded">
                                            @else
                                                <div class="judoka-thumb rounded bg-secondary-subtle d-flex align-items-center justify-content-center small text-muted">?</div>
                                            @endif
                                        </div>
                                        <div class="club-res-names min-w-0">
                                            @if($j && $jClub)
                                                <a href="{{ route('judokas.show', [$jClub, $j]) }}" class="text-decoration-none text-dark">
                                                    <div class="name-up text-truncate">{{ $j->nom }}</div>
                                                    <div class="name-down text-truncate">{{ $j->prenom }}</div>
                                                </a>
                                            @elseif($j)
                                                <div class="name-up text-truncate">{{ $j->nom }}</div>
                                                <div class="name-down text-truncate">{{ $j->prenom }}</div>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </div>
                                        <div class="club-res-meta-col" title="Poids">{{ $j ? $j->poidsLabel() : '—' }}</div>
                                        <div class="club-res-meta-col" title="Genre">{{ $j ? $j->genreCourt() : '—' }}</div>
                                        <div class="club-res-team ms-auto">
                                            @if($jClub && $jClub->logo)
                                                <span class="club-res-team-logo-wrap" title="{{ $jClub->nom }}">
                                                    <img src="{{ asset('storage/'.$jClub->logo) }}" alt="" class="club-res-team-logo-img">
                                                </span>
                                            @elseif($jClub)
                                                <span class="club-res-team-icon" title="{{ $jClub->nom }}">{{ $jClub->initialsAvatar(2) }}</span>
                                            @else
                                                <span class="club-res-team-icon text-muted" title="">—</span>
                                            @endif
                                            <span class="club-res-code">{{ $codeBadge }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>
            @empty
                <div class="card shadow-sm border-0">
                    <div class="card-body py-5 text-center text-muted">
                        Aucune compétition ne correspond à ces critères.
                    </div>
                </div>
            @endforelse

            <div class="mt-4 d-flex justify-content-center">
                {{ $competitions->links() }}
            </div>
        </div>
    </section>
@endsection
