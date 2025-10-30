@extends('layouts.admin')

@section('title', 'Gestion des Actualités')
@section('page-title', 'Gestion des Actualités')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Liste des Actualités ({{ $posts->total() }})</h5>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Actualité
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
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
                        <div class="card-footer bg-white">
                            <div class="btn-group w-100">
                                <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
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
                        <p>Aucune actualité trouvée</p>
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Créer la première actualité
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @if($posts->hasPages())
        <div class="card-footer">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection