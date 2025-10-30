@extends('layouts.admin')
@section('title', 'Ajouter une Compétition')
@section('page-title', 'Ajouter une Compétition')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.competitions.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label>Nom</label><input name="nom" class="form-control" required></div>
                <div class="col-md-6"><label>Lieu</label><input name="lieu" class="form-control"></div>
                <div class="col-md-6"><label>Type</label><input name="type" class="form-control"></div>
                <div class="col-md-6"><label>Saison</label><input name="saison" class="form-control"></div>
                <div class="col-md-6"><label>Date</label><input type="date" name="date_competition" class="form-control"></div>
                <div class="col-md-6"><label>Résultat</label><input name="resultat" class="form-control"></div>
                <div class="col-md-6"><label>Club Domicile</label>
                    <select name="clubsdomicil_id" class="form-select">
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"><label>Club Adversaire</label>
                    <select name="clubadversaire_id" class="form-select">
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12"><label>Description</label><textarea name="description" rows="3" class="form-control"></textarea></div>
            </div>
            <div class="mt-4 text-end">
                <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary">Annuler</a>
                <button class="btn btn-success"><i class="fas fa-save me-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
