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

    <section class="py-5 bg-body-secondary">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="get" action="{{ route('competitions.index') }}" class="row g-3 align-items-end mb-4">
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

                    <div class="table-responsive rounded border">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Compétition</th>
                                    <th scope="col" class="d-none d-md-table-cell">Lieu</th>
                                    <th scope="col" class="d-none d-md-table-cell">Date</th>
                                    <th scope="col" class="d-none d-md-table-cell">Clubs</th>
                                    <th scope="col" class="text-nowrap text-end">Voir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($competitions as $competition)
                                    <tr>
                                        <td class="fw-semibold text-primary">
                                            <a href="{{ route('competitions.show', $competition) }}" class="text-decoration-none">{{ $competition->nom }}</a>
                                            @if($competition->type)
                                                <div class="small text-muted">{{ $competition->type }}</div>
                                            @endif
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted small">{{ $competition->lieu ?? '—' }}</td>
                                        <td class="d-none d-md-table-cell text-muted small">
                                            {{ $competition->date_competition ? $competition->date_competition->format('Y-m-d') : '—' }}
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted small">
                                            @php($labels = $competition->participatingClubLabels())
                                            @if(count($labels))
                                                {{ implode(', ', $labels) }}
                                            @else
                                                <span>—</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('competitions.show', $competition) }}" class="btn btn-sm btn-outline-primary">Fiche</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            Aucune compétition ne correspond à ces critères.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $competitions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
