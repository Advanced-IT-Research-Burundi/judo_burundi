@extends('layouts.admin')

@section('title', 'Types de Posts')
@section('page-title', 'Types de Posts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Types d'Articles ({{ $typePosts->total() }})</h4>
            <p class="text-muted">Gérez les catégories d'actualités et d'événements</p>
        </div>
        <a href="{{ route('admin.type-posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau Type
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if ($typePosts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th width="150">Nombre d'Articles</th>
                                <th width="120">Date Création</th>
                                <th width="150" class="text-center">Actions</th>
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
                                        <span class="badge bg-primary fs-6">
                                            {{ $typePost->posts_count }}
                                            {{ $typePost->posts_count > 1
                                                ? 'art_
                                            icles'
                                                : 'article' }}
                                        </span>
                                    </td>
                                    <td>{{ $typePost->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.type-posts.show', $typePost->id) }}"
                                            class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.type-posts.edit', $typePost->id) }}"
                                            class="btn btn-sm btn-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.type-posts.destroy', $typePost->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de post ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4">
                    <p class="mb-0">Aucun type de post trouvé. <a href="{{ route('admin.type-posts.create') }}">Créer un
                        nouveau type</a>.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
