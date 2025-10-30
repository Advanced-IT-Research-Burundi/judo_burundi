@extends('layouts.admin')
@section('title', $competition->nom)
@section('page-title', 'Détails de la Compétition')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4>{{ $competition->nom }}</h4>
        <p class="text-muted">{{ $competition->description }}</p>
        <ul class="list-group">
            <li class="list-group-item"><strong>Lieu :</strong> {{ $competition->lieu }}</li>
            <li class="list-group-item"><strong>Type :</strong> {{ $competition->type }}</li>
            <li class="list-group-item"><strong>Saison :</strong> {{ $competition->saison }}</li>
            <li class="list-group-item"><strong>Date :</strong> {{ $competition->date_competition }}</li>
            <li class="list-group-item"><strong>Résultat :</strong> {{ $competition->resultat }}</li>
            <li class="list-group-item"><strong>Club Domicile :</strong> {{ $competition->clubDomicil->nom ?? '—' }}</li>
            <li class="list-group-item"><strong>Club Adversaire :</strong> {{ $competition->clubAdversaire->nom ?? '—' }}</li>
        </ul>
        <div class="mt-3 text-end">
            <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary">Retour</a>
            <a href="{{ route('admin.competitions.edit', $competition) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Modifier</a>
        </div>
    </div>
</div>
@endsection
