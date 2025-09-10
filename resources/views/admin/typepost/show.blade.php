@extends('layouts.admin')

@section('title', 'Détails Type de Post')
@section('page-title', 'Détails du Type de Post')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $typePost->nom }}</h5>
                    <div>
                        <a href="{{ route('admin.typeposts.edit', $typePost) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('admin.typeposts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong></p>
                <p>{{ $typePost->description ?? 'Aucune description' }}</p>
                
                <hr>
                
                <p><strong>Date de création:</strong> {{ $typePost->created_at->format('d/m/Y à H:i') }}</p>
                <p><strong>Dernière modification:</strong> {{ $typePost->updated_at->format('d/m/Y à H:i') }}</p>
                <p><strong>Nombre de posts:</strong> <span class="badge bg-primary">{{ $typePost->posts->count() }}</span></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Posts de ce type</h6>
            </div>
            <div class="card-body">
                @if($typePost->posts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($typePost->posts->take(5) as $post)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <strong>{{ $post->joueur->nom_complet }}</strong>
                                        <p class="mb-1 text-muted">{{ Str::limit($post->contenu, 60) }}</p>
                                        <small class="text-muted">{{ $post->date_post->format('d/m/Y') }}</small>
                                    </div>
                                    <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($typePost->posts->count() > 5)
                        <a href="{{ route('admin.posts.index', ['type_post_id' => $typePost->id]) }}" class="btn btn-sm btn-outline-primary mt-2">
                            Voir tous les posts
                        </a>
                    @endif
                @else
                    <p class="text-muted mb-0">Aucun post de ce type.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection