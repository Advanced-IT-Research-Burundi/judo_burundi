@extends('layouts.admin')

@section('title', 'Posts')
@section('page-title', 'Gestion des Posts')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Post
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <!-- Filtres -->
        <div class="card-header">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search"
                        placeholder="Rechercher dans le contenu ou auteur..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="typepost_id">
                        <option value="">Tous les types</option>
                        @foreach ($typeposts as $typepost)
                            <option value="{{ $typepost->id }}"
                                {{ request('typepost_id') == $typepost->id ? 'selected' : '' }}>
                                {{ $typepost->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="user_id">
                        <option value="">Tous les auteurs</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_debut" placeholder="Date début"
                        value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_fin" placeholder="Date fin"
                        value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Auteur</th>
                            <th>Type</th>
                            <th>Contenu</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $post->date_post->format('d/m/Y') }}</strong>
                                    </div>
                                    <small class="text-muted">{{ $post->date_post->format('H:i') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $post->date_post_humain }}</small>
                                </td>
                                <td>
                                    @if ($post->user)
                                        <div>
                                            <strong>{{ $post->user->name }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $post->user->email }}</small>
                                    @else
                                        <span class="text-danger">Utilisateur supprimé</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($post->typepost)
                                        <span class="badge bg-info">{{ $post->typepost->nom }}</span>
                                    @else
                                        <span class="badge bg-secondary">Type supprimé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="post-content" style="max-width: 300px;">
                                        {{ $post->contenu_extrait }}
                                    </div>
                                    @if (strlen($post->contenu) > 100)
                                        <small class="text-muted">{{ strlen($post->contenu) }} caractères</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info"
                                            title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning" title="Éditer">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-file-alt fa-3x mb-3 d-block"></i>
                                    Aucun post trouvé.
                                    @if (request()->hasAny(['search', 'typepost_id', 'user_id', 'date_debut', 'date_fin']))
                                        <br>
                                        <a href="{{ route('admin.posts.index') }}"
                                            class="btn btn-sm btn-outline-secondary mt-2">
                                            Réinitialiser les filtres
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Affichage de {{ $posts->firstItem() ?? 0 }} à {{ $posts->lastItem() ?? 0 }}
                    sur {{ $posts->total() }} résultats
                </div>
                <div>
                    {{ $posts->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
