@extends('layouts.admin')

@section('title', 'Type de Post : ' . $typePost->nom)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">{{ $typePost->nom }}</h1>
            <p class="text-muted mb-0">
                Créé le {{ $typePost->created_at->format('d/m/Y à H:i') }}
                @if($typePost->updated_at != $typePost->created_at)
                    • Modifié le {{ $typePost->updated_at->format('d/m/Y à H:i') }}
                @endif
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.type-posts.edit', $typePost) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('admin.type-posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations générales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Nom du type</h6>
                            <p class="h5 mb-3">{{ $typePost->nom }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Nombre de posts</h6>
                            <p class="h5 mb-3">
                                <span class="badge bg-success fs-6">{{ $typePost->posts_count }}</span>
                            </p>
                        </div>
                    </div>
                    
                    @if($typePost->description)
                        <div>
                            <h6 class="text-muted mb-1">Description</h6>
                            <p class="mb-0">{{ $typePost->description }}</p>
                        </div>
                    @else
                        <div class="alert alert-light">
                            <i class="fas fa-info-circle me-2"></i>Aucune description pour ce type de post.
                        </div>
                    @endif
                </div>
            </div>

            @if($typePost->posts->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-newspaper me-2"></i>Posts de ce type
                        </h5>
                        <a href="{{ route('admin.posts.index', ['type' => $typePost->id]) }}" class="btn btn-primary btn-sm">
                            Voir tous
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($typePost->posts->take(10) as $post)
                                <tr>
                                    <td>
                                        {{-- <div>
                                            <h6 class="mb-1">{{ Str::limit($post->titre, 50) }}</h6>
                                            @if($post->isEvent())
                                                <span class="badge bg-info">Événement</span>
                                            @endif
                                            <p class="text-muted small mb-0">{{ Str::limit($post->excerpt, 60) }}</p>
                                        </div> --}}
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        {{-- @if($post->isEvent())
                                            <i class="fas fa-calendar text-info me-1"></i>
                                        @else
                                            <i class="fas fa-newspaper text-secondary me-1"></i>
                                        @endif
                                        {{ $post->isEvent() ? 'Événement' : 'Article' }}
                                    </td> --}}
                                    <td>
                                        <small class="text-muted">{{ $post->date_post->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($typePost->posts->count() > 10)
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.posts.index', ['type' => $typePost->id]) }}" class="btn btn-outline-primary">
                                Voir les {{ $typePost->posts->count() - 10 }} autres posts
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.type-posts.edit', $typePost) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier ce type
                        </a>
                        <a href="{{ route('admin.posts.create', ['type' => $typePost->id]) }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>Créer un post de ce type
                        </a>
                        <hr>
                        <button class="btn btn-outline-danger" id="deleteBtn">
                            <i class="fas fa-trash me-2"></i>Supprimer ce type
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 text-success mb-1">{{ $typePost->posts_count }}</div>
                            <div class="text-muted small">Posts</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-info mb-1">
                                {{ $typePost->posts->where('lieu_evenement', '!=', null)->count() }}
                            </div>
                            <div class="text-muted small">Événements</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 text-primary mb-1">
                                {{ $typePost->posts->where('created_at', '>=', now()->subDays(30))->count() }}
                            </div>
                            <div class="text-muted small">Ce mois</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-warning mb-1">
                                {{ $typePost->posts->where('created_at', '>=', now()->subDays(7))->count() }}
                            </div>
                            <div class="text-muted small">Cette semaine</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le type de post :</p>
                <p class="fw-bold">{{ $typePost->nom }}</p>
                @if($typePost->posts_count > 0)
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Impossible :</strong> Ce type contient {{ $typePost->posts_count }} post(s).
                        Vous devez d'abord déplacer ou supprimer ces posts.
                    </div>
                @else
                    <p class="text-danger small">Cette action est irréversible.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                @if($typePost->posts_count == 0)
                    <form method="POST" action="{{ route('admin.type-posts.destroy', $typePost) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Supprimer définitivement
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fas fa-ban me-1"></i>Suppression impossible
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    deleteBtn.addEventListener('click', function() {
        deleteModal.show();
    });
});
</script>
@endpush