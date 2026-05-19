@extends('layouts.user')

@section('title', $competition->nom . ' — FBUJA')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/competition-hub.css') }}">
<link rel="stylesheet" href="{{ asset('css/club-results.css') }}">
@endpush

@section('content')
<div class="comp-hub pb-5">
    <div class="comp-hub-hero">
        <div class="container">
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('competitions.index') }}" class="btn btn-sm btn-outline-light rounded-pill">
                    <i class="bi bi-arrow-left"></i> Liste des compétitions
                </a>
                @foreach($competition->participatingClubLabels() as $nomClub)
                    <span class="badge rounded-pill badge-chip">{{ $nomClub }}</span>
                @endforeach
            </div>
            <div class="row align-items-end gy-3">
                <div class="col-lg-9">
                    <h1 class="h2 fw-bold text-uppercase mb-2 lh-sm">{{ $competition->nom }}</h1>
                    <p class="mb-0 text-white-50">
                        <i class="bi bi-geo-alt me-1"></i>{{ $competition->lieu ?? 'Lieu à confirmer' }}
                        @if($competition->type)
                            <span class="mx-2">·</span><i class="bi bi-tag me-1"></i>{{ $competition->type }}
                        @endif
                    </p>
                </div>
                <div class="col-lg-3 text-lg-end">
                    @if($competition->saison)
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">{{ $competition->saison }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="comp-hub-stats py-4">
        <div class="container">
            <div class="row row-cols-2 row-cols-md-5 g-3 text-center align-items-center">
                <div class="col">
                    <div class="stat-num">{{ $stats['judokas'] ?: '—' }}</div>
                    <div class="stat-label mt-2">Judokas</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['clubs'] ?: '—' }}</div>
                    <div class="stat-label mt-2">Clubs</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['hommes'] }}</div>
                    <div class="stat-label mt-2">Hommes</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['femmes'] }}</div>
                    <div class="stat-label mt-2">Femmes</div>
                </div>
                <div class="col vr-soft d-none d-md-block"></div>
                <div class="col">
                    <div class="stat-num">{{ $stats['photos'] }}</div>
                    <div class="stat-label mt-2">Photos</div>
                </div>
            </div>
        </div>
    </div>

    <div class="comp-hub-nav-wrap sticky-top shadow-sm" style="top: var(--site-header-extra); z-index: 1020;">
        <div class="container">
            <ul class="nav nav-pills flex-nowrap overflow-auto py-0 border-0" id="compHubTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-pane" type="button" role="tab">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="results-tab" data-bs-toggle="tab" data-bs-target="#results-pane" type="button" role="tab">Résultats</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos-pane" type="button" role="tab">Photos</button>
                </li>
                @if($competition->resultat)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="brief-tab" data-bs-toggle="tab" data-bs-target="#brief-pane" type="button" role="tab">Communiqué</button>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="container py-4">
        <div class="tab-content" id="compHubTabContent">
            <div class="tab-pane fade show active" id="overview-pane" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header fw-semibold bg-white border-bottom py-3">Dates</div>
                            <div class="card-body">
                                <table class="table table-sm mb-0">
                                    <tbody>
                                        <tr><th class="text-muted">Du</th><td>{{ $competition->date_competition ? $competition->date_competition->format('d. F Y') : '—' }}</td></tr>
                                        <tr><th class="text-muted">Au</th><td>{{ $competition->date_competition ? $competition->date_competition->format('d. F Y') : '—' }}</td></tr>
                                    </tbody>
                                </table>
                                {{-- <p class="small text-muted mt-3 mb-0">Une seule journée renseignée dans la base : adaptez si vous ajoutez une date de fin au formulaire admin.</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header fw-semibold bg-white border-bottom py-3">Classement médailles (clubs)</div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm mb-0 align-middle">
                                        <thead class="table-light small text-uppercase">
                                            <tr>
                                                <th>#</th>
                                                <th>Club</th>
                                                <th class="text-center"><span class="medal-dot medal-dot-gold"></span></th>
                                                <th class="text-center"><span class="medal-dot medal-dot-silver"></span></th>
                                                <th class="text-center"><span class="medal-dot medal-dot-bronze"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($medalRanking as $clubNom => $m)
                                                @php($rank = $loop->iteration)
                                                <tr>
                                                    <td class="text-muted">{{ $rank }}</td>
                                                    <td class="fw-medium">{{ $clubNom }}</td>
                                                    <td class="text-center">{{ $m['g'] }}</td>
                                                    <td class="text-center">{{ $m['s'] }}</td>
                                                    <td class="text-center">{{ $m['b'] }}</td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="5" class="text-center text-muted py-4">Ajoutez des résultats judoka depuis l’admin pour alimenter ce tableau.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header fw-semibold bg-white border-bottom py-3">Catégories programmées</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Bloc</th>
                                                <th>Heure</th>
                                                <th>Catégories</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($cats = $resultsByCategory->keys()->filter())
                                            @forelse($cats as $catLabel)
                                                <tr>
                                                    <td>Jour 1</td>
                                                    <td>{{ $competition->date_competition ? $competition->date_competition->format('H:i') : '—' }}</td>
                                                    <td>{{ $catLabel }}</td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="3" class="text-muted">Aucune catégorie — saisissez le champ « catégorie » dans les résultats judoka.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="results-pane" role="tabpanel">
                <form method="get" action="{{ route('competitions.show', $competition) }}" class="row g-2 mb-4 align-items-center">
                    <div class="col-md-8">
                        <label class="visually-hidden" for="q_results">Recherche résultats</label>
                        <input type="search" name="q_results" id="q_results" value="{{ $qResults ?? '' }}" class="form-control"
                               placeholder="Filtrer par judoka, catégorie, code pays…">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-dark w-100">Rechercher</button>
                    </div>
                </form>

                @forelse($filteredByCategory as $category => $rows)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-semibold py-3">{{ $category }}</div>
                        <div class="row g-0">
                            @php($chunks = $rows->chunk((int) max(1, ceil($rows->count() / 2))))
                            @foreach($chunks as $chunk)
                                <div class="col-lg-6 border-lg-end">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0 align-middle">
                                            <tbody>
                                                @foreach($chunk as $r)
                                                    @php($j = $r->joueur)
                                                    <tr class="{{ $r->medalBorderClass() }}">
                                                        <td class="text-muted small text-nowrap px-3" style="width:2.5rem;">{{ $r->placement ?? '—' }}</td>
                                                        <td class="py-2 ps-0 pe-2" style="width:3rem;">
                                                            @if($j && $j->image)
                                                                <img src="{{ asset('storage/'.$j->image) }}" alt="" class="judoka-thumb">
                                                            @else
                                                                <div class="judoka-thumb bg-secondary-subtle d-flex align-items-center justify-content-center small text-muted">?</div>
                                                            @endif
                                                        </td>
                                                        <td class="py-2">
                                                            @if($j && $j->club)
                                                                <a href="{{ route('judokas.show', [$j->club, $j]) }}" class="text-decoration-none text-dark fw-bold text-uppercase d-block lh-sm">
                                                                    {{ $j->nom }}
                                                                </a>
                                                                <span class="small">{{ $j->prenom }}</span>
                                                                <span class="small text-muted d-block mt-1">{{ $j->poidsLabel() }} · {{ $j->genreCourt() }}</span>
                                                            @elseif($j)
                                                                <span class="fw-bold text-uppercase">{{ $j->nom }}</span>
                                                                <span class="small d-block">{{ $j->prenom }}</span>
                                                                <span class="small text-muted d-block mt-1">{{ $j->poidsLabel() }} · {{ $j->genreCourt() }}</span>
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                    <td class="text-end small text-nowrap px-3 py-2">
                                                        @php($jClub = $j?->club)
                                                        @php($codeBadge = '')
                                                        @if ($jClub)
                                                            @php($codeBadge = $jClub->displayCode(3))
                                                        @elseif ($r->pays_code !== null && trim((string) $r->pays_code) !== '')
                                                            @php($codeBadge = strtoupper(mb_substr(preg_replace('/\s+/u', '', (string) $r->pays_code), 0, 3)))
                                                        @else
                                                            @php($codeBadge = 'BDI')
                                                        @endif
                                                        <div class="d-inline-flex align-items-center gap-2 flex-row-reverse">
                                                            <span class="badge bg-light text-dark border font-monospace small">{{ $codeBadge }}</span>
                                                            @if ($jClub && $jClub->logo)
                                                                <span class="club-res-team-logo-wrap" title="{{ $jClub->nom }}">
                                                                    <img src="{{ asset('storage/'.$jClub->logo) }}" alt="" class="club-res-team-logo-img">
                                                                </span>
                                                            @elseif ($jClub)
                                                                <span class="club-res-team-icon" title="{{ $jClub->nom }}">{{ $jClub->initialsAvatar(2) }}</span>
                                                            @else
                                                                <span class="club-res-team-icon text-muted" title="Club inconnu">—</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light border text-muted">Aucun classement structuré pour cette compétition. Ajoutez des lignes depuis l’administration.</div>
                @endforelse
            </div>

            <div class="tab-pane fade" id="photos-pane" role="tabpanel">
                <p class="text-muted small">Images associées à cette compétition (assignation lors de l’upload dans la galerie admin).</p>
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                    @forelse($competition->galleryImages as $img)
                        <div class="col">
                            <a href="{{ asset('storage/'.$img->images) }}" class="d-block rounded overflow-hidden shadow-sm border ratio ratio-1x1" target="_blank" rel="noopener">
                                <img src="{{ asset('storage/'.$img->images) }}" alt="{{ $img->titre }}" class="object-fit-cover w-100 h-100">
                            </a>
                            <div class="small text-truncate mt-1" title="{{ $img->titre }}">{{ $img->titre }}</div>
                        </div>
                    @empty
                        <div class="col-12 text-muted">Pas encore de photos liées à cette compétition.</div>
                    @endforelse
                </div>
            </div>

            @if($competition->resultat)
                <div class="tab-pane fade" id="brief-pane" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="resultat-content">{!! $competition->resultat !!}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(!empty($qResults))
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.querySelector('#results-tab');
    if (btn && window.bootstrap && bootstrap.Tab) {
        bootstrap.Tab.getOrCreateInstance(btn).show();
    }
});
</script>
@endif
@endpush
