@extends('layouts.user')

@section('title', 'Clubs affiliés — Fédération de Judo du Burundi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/activites.css') }}">
@endpush

@section('content')
    <section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo3.jpg') }}');">
        <div class="page-hero-content">
            <h1>Clubs</h1>
            <p>Clubs affiliés et partenaires du mouvement judo burundais</p>
            <div class="page-hero-breadcrumb">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
                <i class="fas fa-chevron-right"></i>
                <span>Clubs</span>
            </div>
        </div>
    </section>

    <section class="py-5 bg-body-secondary">
        <div class="container">
            <div class="card shadow-sm border-0 clubs-directory-card">
                <div class="card-body p-4">
                    <form method="get" action="{{ route('clubs.index') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-10">
                            <label for="clubSearch" class="form-label fw-semibold">Rechercher un club</label>
                            <input type="search" name="q" id="clubSearch" value="{{ $q ?? '' }}"
                                   class="form-control form-control-lg" placeholder="Nom du club, mots-clés…" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100 btn-lg">Afficher</button>
                        </div>
                    </form>

                    <div class="table-responsive rounded border">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Club</th>
                                    <th scope="col" class="d-none d-md-table-cell">Description</th>
                                    <th scope="col" class="text-nowrap text-end">Voir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clubs as $club)
                                <tr>
                                    <td class="fw-semibold text-primary">
                                        <a href="{{ route('clubs.show', $club) }}" class="text-decoration-none">{{ $club->nom }}</a>
                                    </td>
                                        <td class="d-none d-md-table-cell text-muted small">
                                            {{ $club->description ? Str::limit(strip_tags($club->description), 120) : '—' }}
                                        </td>
                                        <td>{{ $club->capacite ?? '—' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('clubs.show', $club) }}" class="btn btn-sm btn-outline-primary">Fiche</a>
                                            <a href="{{ route('clubs.results', $club) }}" class="btn btn-sm btn-outline-secondary">Résultats</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            Aucun club ne correspond à votre recherche.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $clubs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
