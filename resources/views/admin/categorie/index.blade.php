@extends('layouts.admin')

@section('title', 'Catégories')
@section('page-title', 'Gestion des Catégories')

@section('page-actions')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Ajouter une Catégorie
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Nombre de Joueurs</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $categorie)
                        <tr>
                            <td>
                                <strong>{{ $categorie->nom }}</strong>
                            </td>
                            <td>{{ $categorie->description ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $categorie->joueurs_count }} joueurs</span>
                            </td>
                            <td>{{ $categorie->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.categories.show', $categorie) }}" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $categorie) }}" 
                                       class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($categorie->joueurs_count == 0)
                                        <form action="{{ route('admin.categories.destroy', $categorie) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-danger" disabled title="Impossible de supprimer (contient des joueurs)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                Aucune catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Affichage de {{ $categories->firstItem() ?? 0 }} à {{ $categories->lastItem() ?? 0 }} 
                sur {{ $categories->total() }} résultats
            </div>
            <div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

