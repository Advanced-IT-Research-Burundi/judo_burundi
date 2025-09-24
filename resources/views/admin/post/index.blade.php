@extends('layouts.admin')

@section('title', 'Gestion des Actualités')
@section('page-title', 'Gestion des Actualités')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Articles & Actualités ({{ $posts->total() }})</h4>
            <p class="text-muted">Gérez les actualités, compétitions et événements de la fédération</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvel Article
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Rechercher</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Titre, contenu...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type d'Article</label>
                    <select name="type_id" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach ($typePosts as $typePost)
                            <option value="{{ $typePost->id }}" {{ request('type_id') == $typePost->id ? 'selected' : '' }}>
                                {{ $typePost->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des articles -->
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 post-card">
                    @if ($post->image)
                        <img src="{{ Storage::url($post->image) }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-info ms-1">{{ $post->typePost->nom }}</span>
                            @if ($post->niveau_competition)
                                {{-- <span class="badge bg-{{ formatNiveauCompetition($post->niveau_competition)['class'] }} ms-1">
                                    <i class="{{ formatNiveauCompetition($post->niveau_competition)['icon'] }} me-1"></i>
                                    {{ $post->niveau_competition }}
                                </span> --}}
                            @endif
                        </div>

                        <h6 class="card-title">{{ Str::limit($post->titre, 60) }}</h6>
                        <p class="card-text text-muted small flex-grow-1">{{ $post->extrait }}</p>

                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $post->date_post_formatee }}
                                @if ($post->lieu_evenement)
                                    <br><i class="fas fa-map-marker-alt me-1"></i>{{ $post->lieu_evenement }}
                                @endif
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy',$post) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger btn-sm" type="submit" data-confirme="Suppimer cet post">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($posts->count() == 0)
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun article trouvé</h5>
                    <p class="text-muted">Commencez par créer votre premier article</p>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Créer un Article
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if ($posts->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    @endif
@endsection

@push('styles')
    <style>
        .post-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

@push('scripts')
    <script>
        function toggleStatus(postId, currentStatus) {
            const newStatus = currentStatus === 'published' ? 'draft' : 'published';
            const message = newStatus === 'published' ? 'Publier cet article ?' : 'Mettre cet article en brouillon ?';

            if (confirm(message)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/posts/${postId}/toggle-status`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';

                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function confirmDelete(id, title) {
            if (confirm(`Êtes-vous sûr de vouloir supprimer l'article "${title}" ?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/posts/${id}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
