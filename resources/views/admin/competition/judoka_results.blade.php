@extends('layouts.admin')

@section('title', 'Résultats judoka — '.$competition->nom)
@section('page-title', 'Résultats judoka')

@section('content')
<div class="mb-3 d-flex flex-wrap gap-2">
    <a href="{{ route('admin.competitions.show', $competition) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Compétition</a>
    <a href="{{ route('competitions.show', $competition) }}" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">Voir page publique</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-semibold">Ajouter une ligne de classement</div>
    <div class="card-body">
        <form action="{{ route('admin.competitions.judoka-results.store', $competition) }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Judoka</label>
                <select name="joueur_id" class="form-select @error('joueur_id') is-invalid @enderror" required>
                    <option value="">—</option>
                    @foreach($joueurs as $j)
                        <option value="{{ $j->id }}" @selected(old('joueur_id') == $j->id)>{{ $j->nom }} {{ $j->prenom }} @if($j->club)({{ $j->club->nom }})@endif</option>
                    @endforeach
                </select>
                @error('joueur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Place</label>
                <input type="number" name="placement" class="form-control @error('placement') is-invalid @enderror" min="1" max="999" value="{{ old('placement') }}">
                @error('placement')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Médaille</label>
                <select name="medal" class="form-select @error('medal') is-invalid @enderror">
                    <option value="">—</option>
                    <option value="gold" @selected(old('medal') === 'gold')>Or</option>
                    <option value="silver" @selected(old('medal') === 'silver')>Argent</option>
                    <option value="bronze" @selected(old('medal') === 'bronze')>Bronze</option>
                </select>
                @error('medal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Catégorie</label>
                <input type="text" name="categorie_label" class="form-control @error('categorie_label') is-invalid @enderror" placeholder="-60 kg" value="{{ old('categorie_label') }}">
                @error('categorie_label')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Pays</label>
                <input type="text" name="pays_code" class="form-control @error('pays_code') is-invalid @enderror" placeholder="BDI" value="{{ old('pays_code') }}">
                @error('pays_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Ajouter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-semibold">Lignes enregistrées ({{ $lines->count() }})</div>
    <div class="table-responsive">
        <table class="table table-striped mb-0 align-middle">
            <thead class="table-light small text-uppercase">
                <tr>
                    <th>Judoka</th>
                    <th>Club</th>
                    <th>Catégorie</th>
                    <th>Place</th>
                    <th>Médaille</th>
                    <th>Pays</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($lines as $line)
                    <tr>
                        <td>{{ $line->joueur?->nom }} {{ $line->joueur?->prenom }}</td>
                        <td>{{ $line->joueur?->club?->nom }}</td>
                        <td>{{ $line->categorie_label }}</td>
                        <td>{{ $line->placement ?? '—' }}</td>
                        <td>{{ $line->medal ?? '—' }}</td>
                        <td>{{ $line->pays_code }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.competitions.judoka-results.destroy', [$competition, $line]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette ligne ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucune ligne.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
