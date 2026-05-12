@extends('layouts.user')

@php
    $genderLabel = match ($genderFilter) {
        'F' => 'Femmes',
        'all' => 'Tous',
        default => 'Hommes',
    };
@endphp

@section('title', 'Résultats (' . $genderLabel . ') — ' . $club->nom)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/competition-hub.css') }}">
<link rel="stylesheet" href="{{ asset('css/club-results.css') }}">
@endpush

@php
    $routeFilter = function (array $extra = []) {
        return array_filter(
            array_merge([
                'club' => $club,
                'competition' => $selectedCompetitionId ?: null,
                'q' => $q,
                'gender' => $genderFilter,
                'cat' => $categoryToken !== '' ? $categoryToken : null,
            ], $extra),
            fn ($v) => $v !== null && $v !== ''
        );
    };
@endphp

@section('content')
<section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo2.jpg') }}');">
    <div class="page-hero-content">
        <h1>Résultats — {{ $club->nom }}</h1>
        <p>Classements par catégorie de poids — judokas et clubs représentés</p>
        <div class="page-hero-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('clubs.show', $club) }}">{{ $club->nom }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>Résultats</span>
        </div>
    </div>
</section>

<div class="club-results-shell comp-hub pb-5">
    {{-- Barre d’onglets façon portail (résultats actifs) --}}
    <div class="comp-hub-nav-wrap sticky-top shadow-sm" style="top: var(--site-header-extra); z-index: 1015;">
        <div class="container">
            <ul class="nav nav-pills flex-nowrap overflow-auto py-0 mb-0 small text-uppercase" style="letter-spacing:0.05em;" role="tablist">
                @if ($selectedCompetition)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('competitions.show', $selectedCompetition) }}">Overview</a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <span class="nav-link text-white-50 pe-none user-select-none">Judokas</span>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <span class="nav-link text-white-50 pe-none user-select-none">Contests</span>
                    </li>
                @endif
                <li class="nav-item">
                    <span class="nav-link active" role="tab">Résultats</span>
                </li>
                @if ($selectedCompetition)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('competitions.show', $selectedCompetition) }}#photos-pane">Photos</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="container py-4">
        @if ($competitionsList->isEmpty())
            <div class="alert alert-light border shadow-sm mb-4">
                Aucune compétition liée à ce club. Associez le club (domicile, adversaire ou participant) dans l’administration.
            </div>
        @else
            <form method="get" class="club-results-filter-card border-0 mb-4">
                <input type="hidden" name="gender" value="{{ $genderFilter }}">
                @if ($categoryToken !== '')
                    <input type="hidden" name="cat" value="{{ $categoryToken }}">
                @endif
                <div class="p-3 row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1" for="competitionPick">Compétition</label>
                        <select name="competition" id="competitionPick" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach ($competitionsList as $c)
                                <option value="{{ $c->id }}" @selected((int) $selectedCompetitionId === (int) $c->id)>
                                    {{ $c->nom }} · {{ $c->date_competition?->format('d/m/Y') ?? '—' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold small mb-1" for="qClubRes">Recherche</label>
                        <input type="search" name="q" id="qClubRes" value="{{ $q ?? '' }}" class="form-control form-control-sm" placeholder="Judoka, club, catégorie…">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-dark btn-sm w-100">Filtrer</button>
                    </div>
                </div>
            </form>
        @endif

        @if ($selectedCompetition && $categoriesOrdered->isEmpty())
            <div class="alert alert-light border mb-0">
                @if ($genderFilter === 'F')
                    Aucun résultat féminin pour cette compétition ou filtre de poids trop strict. Essayez « Tous » les sexes ou une autre catégorie.
                @else
                    Aucun classement pour cette sélection. Vérifiez les données dans l’admin ou élargissez les filtres.
                @endif
            </div>
        @endif

        @if ($selectedCompetition && $categoriesOrdered->isNotEmpty())
            <div class="row gy-4">
                {{-- Sidebar filtres (Tout, M / F, poids) --}}
                <div class="col-lg-3">
                    <div class="club-results-sidebar-sticky">
                        <div class="club-results-filter-card p-3 mb-3">
                            <div class="d-grid gap-2 mb-3">
                                <span class="club-res-sidebar-title">Catégories</span>
                                <a href="{{ route('clubs.results', $routeFilter(['cat' => null])) }}"
                                   class="btn btn-sm {{ $categoryToken === '' ? 'btn-dark' : 'btn-outline-secondary' }} club-res-wt-btn">
                                    Tout
                                </a>
                            </div>

                            <div class="mb-3">
                                <span class="club-res-sidebar-title d-block mb-2">Sexe</span>
                                <div class="btn-group w-100" role="group" aria-label="Filtre sexe">
                                    <a href="{{ route('clubs.results', $routeFilter(['gender' => 'M', 'cat' => null])) }}"
                                       class="btn btn-sm flex-fill {{ $genderFilter === 'M' ? 'btn-dark' : 'btn-outline-secondary' }}">M</a>
                                    <a href="{{ route('clubs.results', $routeFilter(['gender' => 'F', 'cat' => null])) }}"
                                       class="btn btn-sm flex-fill {{ $genderFilter === 'F' ? 'btn-dark' : 'btn-outline-secondary' }}">F</a>
                                    <a href="{{ route('clubs.results', $routeFilter(['gender' => 'all', 'cat' => null])) }}"
                                       class="btn btn-sm flex-fill {{ $genderFilter === 'all' ? 'btn-dark' : 'btn-outline-secondary' }}">Tous</a>
                                </div>
                            </div>

                            @if (in_array($genderFilter, ['M', 'all'], true))
                                <div class="mb-2">
                                    <span class="club-res-sidebar-title d-block mb-2">Hommes</span>
                                    <div class="d-grid gap-1" style="grid-template-columns: repeat(2, minmax(0, 1fr));">
                                        @foreach ($menWeights as $w)
                                            <a href="{{ route('clubs.results', $routeFilter(['gender' => 'M', 'cat' => $w])) }}"
                                               class="btn btn-sm {{ $categoryToken === $w && $genderFilter === 'M' ? 'btn-dark' : 'btn-outline-secondary' }} club-res-wt-btn">{{ $w }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (in_array($genderFilter, ['F', 'all'], true))
                                <div class="mt-3">
                                    <span class="club-res-sidebar-title d-block mb-2">Femmes</span>
                                    <div class="d-grid gap-1" style="grid-template-columns: repeat(2, minmax(0, 1fr));">
                                        @foreach ($womenWeights as $w)
                                            <a href="{{ route('clubs.results', $routeFilter(['gender' => 'F', 'cat' => $w])) }}"
                                               class="btn btn-sm {{ $categoryToken === $w && $genderFilter === 'F' ? 'btn-dark' : 'btn-outline-secondary' }} club-res-wt-btn">{{ $w }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($genderFilter === 'all')
                                <p class="text-muted small mt-3 mb-0">« Tous » affiche messieurs et dames présents aux compétitions ; les boutons M / F et les poids restreignent l’affichage.</p>
                            @endif
                        </div>

                        {{-- Liens ancres vers chaque carte (catégories affichées) --}}
                        <div class="club-results-filter-card p-3">
                            <span class="club-res-sidebar-title d-block mb-2">Blocs classement</span>
                            <div class="d-flex flex-column gap-1">
                                @foreach ($categoriesOrdered as $anchorLabel)
                                    @php($anchorSlug = Str::slug((string) $anchorLabel ?: 'sans'))
                                    <a class="small text-decoration-none link-dark fw-semibold py-1" href="#club-res-{{ $anchorSlug }}">{{ $anchorLabel }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grille de cartes (2 colonnes grand écran) --}}
                <div class="col-lg-9">
                    <div class="row club-res-cards-grid row-cols-1 row-cols-xl-2">
                        @foreach ($categoriesOrdered as $categoryLabel)
                            @php($slug = Str::slug((string) $categoryLabel ?: 'sans'))
                            @php($rows = $byCategory->get($categoryLabel) ?? collect())

                            <div class="col">
                                <article class="club-res-category-card" id="club-res-{{ $slug }}">
                                    <header class="club-res-category-head">{{ $categoryLabel }}</header>
                                    <div class="club-res-list">
                                        @foreach ($rows as $r)
                                            @php($j = $r->joueur)
                                            @php($jClub = $j?->club)
                                            @php($isOwnClub = $j && (int) $j->clubs_id === (int) $club->id)

                                            {{-- Code affiché : club représenté en priorité, sinon code pays renseigné --}}
                                            @php($codeTeam = '')
                                            @if ($jClub)
                                                @php($codeTeam = $jClub->displayCode(3))
                                            @endif
                                            @php($fallbackPays = strtoupper(mb_substr(preg_replace('/\s+/u', '', (string) ($r->pays_code ?? '')), 0, 3)))
                                            @if (mb_strlen($codeTeam) < 2 && mb_strlen($fallbackPays) >= 2)
                                                @php($codeTeam = $fallbackPays)
                                            @elseif (mb_strlen($codeTeam) < 2)
                                                @php($codeTeam = '—')
                                            @endif

                                            <div class="club-res-line {{ $r->medalBorderClass() }} @if($isOwnClub) club-result-own-line @endif">
                                                <div class="club-res-rank">{{ $r->placement ?? '—' }}</div>
                                                <div class="club-res-photo flex-shrink-0">
                                                    @if ($j && $j->image)
                                                        <img src="{{ asset('storage/'.$j->image) }}" alt="" class="judoka-thumb rounded border border-light shadow-sm">
                                                    @else
                                                        <div class="judoka-thumb rounded border bg-secondary-subtle d-flex align-items-center justify-content-center small text-muted">?</div>
                                                    @endif
                                                </div>
                                                <div class="club-res-names">
                                                    @if ($j && $jClub)
                                                        <a href="{{ route('judokas.show', [$jClub, $j]) }}" class="text-decoration-none text-dark d-block">
                                                            <span class="name-up">{{ $j->nom }}</span>
                                                            <span class="name-down d-block">{{ $j->prenom }}</span>
                                                        </a>
                                                    @elseif ($j)
                                                        <span class="name-up d-block">{{ $j->nom }}</span>
                                                        <span class="name-down d-block">{{ $j->prenom }}</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                    @if ($isOwnClub)
                                                        <span class="club-own-pill badge text-bg-danger ms-1">Notre club</span>
                                                    @endif
                                                </div>
                                                <div class="club-res-team">
                                                    @if ($jClub)
                                                        <span class="club-res-team-icon {{ $isOwnClub ? 'club-res-team-icon--own' : '' }}" title="{{ $jClub->nom }}">
                                                            {{ $jClub->initialsAvatar(2) }}
                                                        </span>
                                                    @else
                                                        <span class="club-res-team-icon text-muted" title="—">—</span>
                                                    @endif
                                                    <span class="club-res-code">{{ $codeTeam }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-4 d-flex flex-wrap gap-2">
            <a href="{{ route('clubs.show', $club) }}" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="fas fa-arrow-left me-1"></i> Fiche club</a>
            <a href="{{ route('competitions.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">Compétitions</a>
        </div>
    </div>
</div>
@endsection
