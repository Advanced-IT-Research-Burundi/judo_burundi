@extends('layouts.admin')

@section('title', 'Gestion des Actualités')
@section('page-title', 'Gestion des Actualités')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Actualités ({{ $posts->total() }})</h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $posts->firstItem() ?? 0 }} à {{ $posts->lastItem() ?? 0 }} sur {{ $posts->total() }} articles
            </div>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle actualité
            </a>
        </div>

        <div class="row g-3 admin-grid-card">
            @forelse($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::limit($post->title, 50) }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $post->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="btn-group btn-group-sm w-100 admin-table-actions" role="group" aria-label="Actions article">
                                <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3"></i>
                        <p class="mb-3">Aucune actualité trouvée.</p>
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Créer la première actualité
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @if($posts->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $posts->currentPage() }} / {{ $posts->lastPage() }}</div>
            <div>{{ $posts->links() }}</div>
        </div>
    @endif
</div>
@endsection
