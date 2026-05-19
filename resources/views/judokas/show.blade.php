@extends('layouts.user')

@section('title', $joueur->nom . ' ' . $joueur->prenom . ' — ' . $club->nom)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/competition-hub.css') }}">
@endpush

@section('content')
    <div class="judoka-profile-hero">
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-auto">
                    @if ($joueur->image)
                        <img src="{{ asset('storage/' . $joueur->image) }}" alt=""
                            class="rounded border border-light border-2 shadow"
                            style="width:96px;height:96px;object-fit:cover;">
                    @else
                        <div class="rounded bg-white bg-opacity-10 d-flex align-items-center justify-content-center border border-light border-2"
                            style="width:96px;height:96px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h1 class="h3 fw-bold text-uppercase mb-1">{{ $joueur->nom }} {{ $joueur->prenom }}</h1>
                    <div class="text-white-75">
                        <i class="bi bi-flag me-1"></i>{{ strtoupper($club->nom) }}
                    </div>
                    @if ($joueur->sexe || $joueur->poids)
                        <div class="small text-white-50 mt-2">

                            @if ($joueur->sexe)
                                Sexe : {{ $joueur->sexe }}
                            @endif

                            @if ($joueur->poids)
                                <span class="mx-2">·</span>
                                Poids : {{ $joueur->poids }} kg
                            @endif

                        </div>
                    @endif
                </div>
                <div class="col-lg-3 text-lg-end">
                    @php($lastCat = $results->first()?->categorie_label)
                    <div class="display-6 fw-bold">{{ $lastCat ?? 'Cat.' }}</div>
                    <hr class="border-light opacity-50 mt-2 mb-0">
                </div>
            </div>
        </div>
    </div>

    <div class="judoka-tabs-nav">
        <div class="container">
            <ul class="nav nav-pills flex-nowrap overflow-auto py-0" id="judokaTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active px-3 py-3" data-bs-toggle="tab"
                        data-bs-target="#j-overview" type="button" role="tab">Overview</button></li>
                <li class="nav-item"><button class="nav-link px-3 py-3" data-bs-toggle="tab" data-bs-target="#j-results"
                        type="button" role="tab">Résultats</button></li>
                <li class="nav-item"><button class="nav-link px-3 py-3" data-bs-toggle="tab" data-bs-target="#j-photos"
                        type="button" role="tab">Photos</button></li>
            </ul>
        </div>
    </div>

    <div class="bg-body-secondary py-5">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('clubs.show', $club) }}" class="btn btn-sm btn-outline-secondary rounded-pill"><i
                        class="bi bi-arrow-left"></i> Club {{ $club->nom }}</a>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="j-overview" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header fw-semibold bg-white">Chiffres</div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Résultats</th>
                                                <td>{{ $results->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Photos compétitions</th>
                                                <td>{{ $photos->count() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Or</th>
                                                <td>{{ $medals['gold'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Argent</th>
                                                <td>{{ $medals['silver'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Bronze</th>
                                                <td>{{ $medals['bronze'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Autres places</th>
                                                <td>{{ $medals['other'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header fw-semibold bg-white">Derniers résultats</div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light small">
                                            <tr>
                                                <th>Date</th>
                                                <th>Compétition</th>
                                                <th class="text-end">Place</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results->take(8) as $r)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        {{ $r->competition?->date_competition?->format('d.m.Y') ?? '—' }}
                                                    </td>
                                                    <td>{{ $r->competition?->nom }}</td>
                                                    <td class="text-end fw-semibold">{{ $r->placement ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="j-results" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header fw-semibold bg-white">Synthèse médailles</div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0 text-center">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th><span class="medal-dot medal-dot-gold"></span></th>
                                                <th><span class="medal-dot medal-dot-silver"></span></th>
                                                <th><span class="medal-dot medal-dot-bronze"></span></th>
                                                <th>Autres</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-start">Total</td>
                                                <td>{{ $medals['gold'] }}</td>
                                                <td>{{ $medals['silver'] }}</td>
                                                <td>{{ $medals['bronze'] }}</td>
                                                <td>{{ $medals['other'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header fw-semibold bg-white">Toutes les compétitions</div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light small">
                                            <tr>
                                                <th>Date</th>
                                                <th>Compétition</th>
                                                <th>Catégorie</th>
                                                <th class="text-end">Place</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results as $r)
                                                <tr>
                                                    <td class="text-nowrap">
                                                        {{ $r->competition?->date_competition?->format('d.m.Y') }}</td>
                                                    <td>
                                                        @if ($r->competition)
                                                            <a href="{{ route('competitions.show', $r->competition) }}"
                                                                class="text-decoration-none">{{ $r->competition->nom }}</a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>
                                                    <td class="small">{{ $r->categorie_label }}</td>
                                                    <td class="text-end">{{ $r->placement ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="j-photos" role="tabpanel">
                    <form method="get" action="{{ route('judokas.show', [$club, $joueur]) }}"
                        class="row g-2 mb-4 align-items-end">
                        <div class="col-md-10">
                            <label class="visually-hidden" for="q_photo">Recherche photos</label>
                            <input type="search" name="q_photo" id="q_photo" value="{{ $qPhoto ?? '' }}"
                                class="form-control" placeholder="Filtrer par titre de photo…">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100">Filtrer</button>
                        </div>
                    </form>
                    <p class="small text-muted">Images issues des compétitions où ce judoka a un résultat enregistré.</p>
                    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                        @forelse($photosFiltered as $img)
                            <div class="col">
                                <a href="{{ asset('storage/' . $img->images) }}" target="_blank" rel="noopener"
                                    class="ratio ratio-1x1 d-block rounded overflow-hidden shadow-sm border">
                                    <img src="{{ asset('storage/' . $img->images) }}" alt="{{ $img->titre }}"
                                        class="w-100 h-100 object-fit-cover">
                                </a>
                                <div class="small text-truncate mt-1">{{ $img->titre }}</div>
                            </div>
                        @empty
                            <div class="col-12 text-muted">Aucune photo pour ces critères.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
