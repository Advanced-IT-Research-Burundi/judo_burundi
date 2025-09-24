@extends('layouts.admin')

@section('title', $category->nom)
@section('page-title', 'Détail de la Catégorie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-tag me-2"></i>
        {{ $category->nom }}
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            Modifier
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Retour à la liste
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations générales
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Nom :</strong>
                    </div>
                    <div class="col-md-9">
                        <span class="badge bg-primary fs-6">{{ $category->nom }}</span>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-3">
                        <strong>Description :</strong>
                    </div>
                    <div class="col-md-9">
                        @if($category->description)
                            <p class="mb-0">{{ $category->description }}</p>
                        @else
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Aucune description fournie
                            </p>
                        @endif
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-3">
                        <strong>Nombre de membres :</strong>
                    </div>
                    <div class="col-md-9">
                        <span class="badge bg-info fs-6">
                            {{ $category->joueurs->count() }} membres(s)
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($category->joueurs->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    membres dans cette catégorie ({{ $category->joueurs->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($category->joueurs as $joueur)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-1">
                                            {{ $joueur->nom ?? 'N/A' }} {{ $joueur->prenom ?? '' }}
                                        </h6>
                                        <small class="text-muted">
                                            @if(isset($joueur->email))
                                                {{ $joueur->email }}
                                            @elseif(isset($joueur->telephone))
                                                {{ $joueur->telephone }}
                                            @else
                                                ID: {{ $joueur->id }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    @if(Route::has('admin.joueurs.show'))
                                        <a href="{{ route('admin.joueurs.show', $joueur) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>
                                            Voir
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="card mt-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun membre dans cette catégorie</h5>
                <p class="text-muted">Cette catégorie ne contient encore aucun membre.</p>
                @if(Route::has('admin.joueurs.create'))
                    <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Ajouter un membre
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Informations système
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">ID de la catégorie</small>
                    <strong># {{ $category->id }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Date de création</small>
                    <strong>{{ $category->created_at->format('d/m/Y à H:i') }}</strong>
                    <small class="text-muted d-block">
                        {{ $category->created_at->diffForHumans() }}
                    </small>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Dernière modification</small>
                    <strong>{{ $category->updated_at->format('d/m/Y à H:i') }}</strong>
                    <small class="text-muted d-block">
                        {{ $category->updated_at->diffForHumans() }}
                    </small>
                </div>

                <hr>
                <div class="mb-0">
                    <small class="text-muted d-block">Statistiques</small>
                    <div class="d-flex justify-content-between">
                        <span>membres :</span>
                        <span class="badge bg-info">{{ $category->joueurs->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Actions rapides
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        Créer une nouvelle catégorie
                    </a>                  
                    <hr class="my-2">
                    
                    @if($category->joueurs->count() > 0)
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Cette catégorie contient {{ $category->joueurs->count() }} joueur(s) et ne peut pas être supprimée.
                        </div>
                        <button class="btn btn-danger w-100" disabled title="Suppression bloquée">
                            <i class="fas fa-ban me-2"></i>
                            Suppression bloquée
                        </button>
                        <small class="text-muted text-center d-block mt-1">
                            {{ $category->joueurs->count() }} membre(s) dans cette catégorie
                        </small>
                    @else
                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                Supprimer définitivement
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
}
</style>
@endpush
@endsection