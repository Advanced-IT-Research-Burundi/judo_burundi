@extends('layouts.admin')

@section('title', 'Types de Posts')
@section('page-title', 'Gestion des Types de Posts')

@section('page-actions')
<a href="{{ route('admin.typeposts.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Ajouter un Type
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
                        <th>Nombre de Posts</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($typesPosts as $typePost)
                        <tr>
                            <td>
                                <strong>{{ $typePost->nom }}</strong>
                            </td>
                            <td>{{ $typePost->description ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $typePost->posts_count }} posts</span>
                            </td>
                            <td>{{ $typePost->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.typeposts.show', $typePost) }}" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.typeposts.edit', $typePost) }}" 
                                       class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($typePost->posts_count == 0)
                                        <form action="{{ route('admin.typeposts.destroy', $typePost) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de post ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-danger" disabled title="Impossible de supprimer (contient des posts)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-list fa-3x mb-3 d-block"></i>
                                Aucun type de post trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Affichage de {{ $typesPosts->firstItem() ?? 0 }} à {{ $typesPosts->lastItem() ?? 0 }} 
                sur {{ $typesPosts->total() }} résultats
            </div>
            <div>
                {{ $typesPosts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

