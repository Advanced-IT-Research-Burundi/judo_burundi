@extends('layouts.admin')

@section('title', 'Détails Catégorie')
@section('page-title', 'Détails d\'une Catégorie')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>{{ $category->nom }}</h4>
        <p>{{ $category->description }}</p>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection
