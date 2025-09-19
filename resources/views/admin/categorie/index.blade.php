@extends('layouts.admin')

@section('title', 'Catégories')
@section('page-title', 'Gestion des Catégories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-tags me-2"></i>
        Liste des Catégories
    </h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        Nouvelle Catégorie
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Joueurs</th>
                            <th>Date de création</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <strong>{{ $category->nom }}</strong>
                            </td>
                            <td>
                                @if($category->description)
                                    {{ Str::limit($category->description, 100) }}
                                @else
                                    <span class="text-muted">Aucune description</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $category->joueurs_count ?? 0 }} joueur(s)
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $category->created_at->format('d/m/Y à H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($category->joueurs_count > 0)
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Suppression bloquée - Contient des joueurs"
                                                disabled>
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune catégorie trouvée</h5>
                <p class="text-muted">Commencez par créer votre première catégorie.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Créer une catégorie
                </a>
            </div>
        @endif
    </div>
</div>
@endsection