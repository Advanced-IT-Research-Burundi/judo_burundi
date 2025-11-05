@extends('layouts.user')

@section('title', 'Résultat de la compétition')

@section('content')
<div class="container mt-4">
    <h2>{{ $competition->nom }}</h2>
    <p><strong>Lieu :</strong> {{ $competition->lieu }}</p>
    <p><strong>Date :</strong> {{ $competition->date_competition }}</p>
    <p><strong>Clubs :</strong>{{ $competition->clubdomicile->nom ?? '—' }} vs {{ $competition->clubadversaire->nom ?? '—' }}</p>
    <p><strong>Résultat :</strong> {{ $competition->resultat ?? 'Pas encore disponible' }}</p>
</div>
@endsection
