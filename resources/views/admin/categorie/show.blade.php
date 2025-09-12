@extends('layouts.admin')

@section('title', 'Détails Catégorie')
@section('page-title', 'Détails de la Catégorie')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $category->nom }}</h5>
                    <div>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong></p>
                <p>{{ $category->description ?? 'Aucune description' }}</p>
                
                <hr>
                
                <p><strong>Date de création:</strong> {{ $category->created_at->format('d/m/Y à H:i') }}</p>
                <p><strong>Dernière modification:</strong> {{ $category->updated_at->format('d/m/Y à H:i') }}</p>
                <p><strong>Nombre de joueurs:</strong> <span class="badge bg-primary">{{ $category->joueurs->count() }}</span></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Joueurs de cette catégorie</h6>
            </div>
            <div class="card-body">
                @if($category->joueurs->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($category->joueurs as $joueur)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <strong>{{ $joueur->nom_complet }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $joueur->quartier->nom }}, {{ $joueur->quartier->zone->commune->nom }}
                                        </small>
                                    </div>
                                    <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Aucun joueur dans cette catégorie.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection