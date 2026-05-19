@extends('layouts.admin')

@section('title', 'Types de Posts')
@section('page-title', 'Types de Posts')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Types de posts ({{ $typePosts->total() }})</h5>
    </div>

    <div class="card-body p-0">
        @if ($typePosts->count() > 0)
            <div class="p-3 border-bottom bg-body-tertiary">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <p class="text-muted small mb-0">Catégories d’actualités et d’événements</p>
                    <a href="{{ route('admin.type-posts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Nouveau type
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th width="150">Nombre de posts</th>
                            <th width="120">Date création</th>
                            <th width="180" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($typePosts as $typePost)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $typePost->nom }}</strong></td>
                                <td>
                                    @if ($typePost->description)
                                        <span class="text-muted">{{ Str::limit($typePost->description, 80) }}</span>
                                    @else
                                        <em class="text-muted">Aucune description</em>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $typePost->posts_count }} {{ $typePost->posts_count > 1 ? 'posts' : 'post' }}
                                    </span>
                                </td>
                                <td>{{ $typePost->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions type">
                                        <a href="{{ route('admin.type-posts.show', $typePost->id) }}" class="btn btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.type-posts.edit', $typePost->id) }}" class="btn btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.type-posts.destroy', $typePost->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de post ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-muted">
                <p class="mb-3">Aucun type de post trouvé.</p>
                <a href="{{ route('admin.type-posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Créer un type
                </a>
            </div>
        @endif
    </div>

    @if($typePosts->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $typePosts->currentPage() }} / {{ $typePosts->lastPage() }}</div>
            <div>{{ $typePosts->links() }}</div>
        </div>
    @endif
</div>
@endsection
