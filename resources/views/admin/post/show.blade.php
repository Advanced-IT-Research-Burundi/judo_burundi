@extends('layouts.admin')

@section('title', 'Détails du Post')
@section('page-title', 'Détails du post')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Modifier
    </a>
    <button type="button" 
            class="btn btn-danger"
            onclick="confirmerSuppression({{ $post->id }})">
        <i class="fas fa-trash"></i> Supprimer
    </button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Contenu principal du post -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title mb-1">Post #{{ $post->id }}</h4>
                        <div class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $post->date_post_formattee }}
                            <span class="ms-2">({{ $post->date_post_humain }})</span>
                        </div>
                    </div>
                    @if($post->typepost)
                        <span class="badge bg-info fs-6">{{ $post->typepost->nom }}</span>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="post-content" style="white-space: pre-wrap; line-height: 1.6;">
                    {{ $post->contenu }}
                </div>
            </div>

            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col-md-6">
                        <small>
                            <strong>Nombre de caractères :</strong> {{ strlen($post->contenu) }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small>
                            <strong>Nombre de mots :</strong> {{ str_word_count($post->contenu) }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Informations sur l'auteur -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user"></i> Auteur
                </h5>
            </div>
            <div class="card-body">
                @if($post->user)
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $post->user->name }}</h6>
                            <p class="text-muted mb-2">{{ $post->user->email }}</p>
                            @if($post->user->posts_count ?? false)
                                <small class="text-muted">
                                    {{ $post->user->posts_count }} posts au total
                                </small>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center text-danger">
                        <i class="fas fa-user-slash fa-2x mb-2"></i>
                        <p class="mb-0">Utilisateur supprimé</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Informations
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="fw-bold">ID :</td>
                        <td>{{ $post->id }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Type :</td>
                        <td>
                            @if($post->typepost)
                                <span class="badge bg-info">{{ $post->typepost->nom }}</span>
                            @else
                                <span class="text-muted">Type supprimé</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Date de publication :</td>
                        <td>{{ $post->date_post->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Créé le :</td>
                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Modifié le :</td>
                        <td>{{ $post->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools"></i> Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier ce post
                    </a>
                    
                    @if($post->user)
                        <a href="{{ route('admin.posts.index', ['user_id' => $post->user_id]) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> Autres posts de {{ $post->user->name }}
                        </a>
                    @endif
                    
                    @if($post->typepost)
                        <a href="{{ route('admin.posts.index', ['typepost_id' => $post->typepost_id]) }}" 
                           class="btn btn-outline-info">
                            <i class="fas fa-tags"></i> Posts de type "{{ $post->typepost->nom }}"
                        </a>
                    @endif
                    
                    <hr>
                    
                    <button type="button" 
                            class="btn btn-outline-danger"
                            onclick="confirmerSuppression({{ $post->id }})">
                        <i class="fas fa-trash"></i> Supprimer ce post
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste des posts
        </a>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmerSuppression(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce post ?\n\nCette action est irréversible.')) {
        const form = document.getElementById('delete-form');
        form.action = '{{ route("admin.posts.destroy", "") }}/' + id;
        form.submit();
    }
}
</script>
@endsection