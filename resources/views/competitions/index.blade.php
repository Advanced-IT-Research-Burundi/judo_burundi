@extends('layouts.user')

@section('title', 'Compétitions et résultats — Fédération de Judo du Burundi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/activites.css') }}">
@endpush

@section('content')
    <section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo2.jpg') }}');">
        <div class="page-hero-content">
            <h1>Compétitions &amp; résultats</h1>
            <p>Calendrier, lieux et clubs participants</p>
            <div class="page-hero-breadcrumb">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
                <i class="fas fa-chevron-right"></i>
                <span>Compétitions</span>
            </div>
        </div>
    </section>

    <section id="liste-competitions" class="py-5 activites-results-wrap position-relative"
             style="background-image: linear-gradient(135deg, rgba(26, 54, 93, 0.92), rgba(15, 26, 42, 0.94)), url('{{ asset('images/judo4.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container position-relative">
            <div class="activites-results-panel text-white">
                <form method="get" action="{{ route('competitions.index') }}" class="row g-3 align-items-end mb-3" id="competitionsFilters">
                    <div class="col-md-3">
                        <label for="filterSaison" class="form-label small text-white-50 mb-1">Saison</label>
                        <select name="saison" id="filterSaison" class="form-select form-select-sm">
                            <option value="">Toutes les saisons</option>
                            @foreach($saisons as $saison)
                                <option value="{{ $saison }}" @selected(($filterSaison ?? '') === $saison)>
                                    {{ $saison }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterType" class="form-label small text-white-50 mb-1">Catégorie</label>
                        <select name="type" id="filterType" class="form-select form-select-sm">
                            <option value="">Toutes les catégories</option>
                            @foreach($types as $t)
                                <option value="{{ $t }}" @selected(($filterType ?? '') === $t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="compSearch" class="form-label small text-white-50 mb-1">Recherche</label>
                        <input type="search" name="q" id="compSearch" value="{{ $q ?? '' }}"
                               class="form-control form-control-sm" placeholder="Compétition, lieu, club…" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100">Afficher</button>
                    </div>
                </form>

                <div class="table-shell shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover table-bordered align-middle mb-0 text-dark">
                            <thead class="table-light text-center text-uppercase small">
                                <tr>
                                    <th scope="col">Saison</th>
                                    <th scope="col" class="text-start">Compétition</th>
                                    <th scope="col" class="text-start">Lieu</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="text-start">Clubs (équipes)</th>
                                    <th scope="col" class="text-nowrap">Détail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($competitions as $competition)
                                    <tr>
                                        <td class="text-center small">{{ $competition->saison ?? '—' }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $competition->nom }}</span>
                                            @if($competition->type)
                                                <div class="activites-competition-muted">{{ $competition->type }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $competition->lieu ?? '—' }}</td>
                                        <td class="text-center text-nowrap small">
                                            {{ $competition->date_competition ? $competition->date_competition->format('Y-m-d') : '—' }}
                                        </td>
                                        <td class="small">
                                            @php($labels = $competition->participatingClubLabels())
                                            @if(count($labels))
                                                {{ implode(', ', $labels) }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('competitions.show', $competition) }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            Aucune compétition ne correspond à ces critères.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $competitions->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
