@extends('layouts.user')

@section('title', 'Liste des Compétitions')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">Compétitions</h1>

    <!-- FILTRES -->
    <form method="GET" action="{{ route('competitions.index') }}" class="mb-4 row g-3">
        <div class="col-md-4">
            <label class="form-label">Année</label>
            <select name="year" class="form-select" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach(range(date('Y')+1, date('Y')-5) as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected':'' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Lieu</label>
            <input type="text" name="lieu" value="{{ request('lieu') }}" class="form-control" placeholder="Ex: Paris">
        </div>

        <div class="col-md-4">
            <button class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>

    <!-- LISTE -->
    <div class="list-group">
        @foreach($competitions as $competition)
        <div class="list-group-item py-3">

            <div class="row align-items-center">
                
                <!-- DATE -->
                <div class="col-md-2 text-center">
                    <div class="fw-bold">{{ \Carbon\Carbon::parse($competition->date_competition)->format('F') }}</div>
                    <div class="text-muted">{{ \Carbon\Carbon::parse($competition->date_competition)->format('d') }}</div>
                </div>

                <!-- NOM & INFO -->
                <div class="col-md-6">
                    <h5 class="mb-1">{{ $competition->nom }}</h5>
                    <small class="text-muted">
                        {{ $competition->lieu }} |
                        {{ $competition->clubdomicile->nom ?? '—' }} vs {{ $competition->clubadversaire->nom ?? '—' }}
                    </small>
                </div>
                <!-- LIEN RÉSULTAT -->
                <div class="col-md-4 text-end">
                    @if($competition->resultat)
                        <a href="{{ route('competitions.result', $competition->id) }}" class="btn btn-outline-primary btn-sm">
                            Voir Résultat
                        </a>
                    @else
                        <span class="badge bg-secondary">Pas encore disponible</span>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
