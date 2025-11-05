@extends('layouts.admin')
@section('title', 'Modifier une Compétition')
@section('page-title', 'Modifier une Compétition')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.competitions.update', $competition) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label>Nom</label><input name="nom" value="{{ $competition->nom }}" class="form-control" required></div>
                <div class="col-md-6"><label>Lieu</label><input name="lieu" value="{{ $competition->lieu }}" class="form-control"></div>
                <div class="col-md-6"><label>Type</label><input name="type" value="{{ $competition->type }}" class="form-control"></div>
                <div class="col-md-6"><label>Saison</label><input name="saison" value="{{ $competition->saison }}" class="form-control"></div>
                <div class="col-md-6"><label>Date</label><input type="date" name="date_competition" value="{{ $competition->date_competition }}" class="form-control"></div>
                <div class="col-md-6"><label>Résultat</label><input name="resultat" value="{{ $competition->resultat }}" class="form-control"></div>
                <div class="col-md-6"><label>Club Domicile</label>
                    <select name="clubdomicile_id" class="form-select">
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" {{ $competition->clubdomicile_id == $club->id ? 'selected' : '' }}>{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"><label>Club Adversaire</label>
                    <select name="clubadversaire_id" class="form-select">
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" {{ $competition->clubadversaire_id == $club->id ? 'selected' : '' }}>{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12"><label>Description</label><textarea name="description" rows="3" class="form-control">{{ $competition->description }}</textarea></div>
            </div>
            <div class="mt-4 text-end">
                <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary">Retour</a>
                <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
