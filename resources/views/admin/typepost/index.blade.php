@extends('layouts.admin')

@section('title', 'Gestion des Types de Posts')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">Gestion des Types de Posts</h1>
            <p class="text-muted mb-0">Gérez les catégories de contenu de la fédération</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.type-posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouveau Type
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-filter me-2"></i>Filtres
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.type-posts.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Recherche</label>
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Nom ou description...">
                </div>
                
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Rechercher
                    </button>
                    @if(request()->hasAny(['search']))
                        <a href="{{ route('admin.type-posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des types -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Types de Posts <span class="badge bg-secondary">{{ $typesPosts->total() }}</span>
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Nombre de Posts</th>
                        <th>Date de création</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($typesPosts as $typePost)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2" 
                                     style="width: 36px; height: 36px;">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $typePost->nom }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-muted mb-0">
                                {{ $typePost->description ? Str::limit($typePost->description, 60) : 'Aucune description' }}
                            </p>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $typePost->posts_count }}</span>
                                @if($typePost->posts_count > 0)
                                    <small class="text-muted">post{{ $typePost->posts_count > 1 ? 's' : '' }}</small>
                                @else
                                    <small class="text-muted">Aucun post</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                {{ $typePost->created_at->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">{{ $typePost->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.type-posts.show', $typePost) }}" 
                                   class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.type-posts.edit', $typePost) }}" 
                                   class="btn btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger delete-btn" 
                                        title="Supprimer" data-typepost-id="{{ $typePost->id }}" 
                                        data-typepost-nom="{{ $typePost->nom }}"
                                        data-posts-count="{{ $typePost->posts_count }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-bookmark fa-3x mb-3 d-block"></i>
                                <h5>Aucun type de post trouvé</h5>
                                @if(request('search'))
                                    <p class="mb-3">Aucun résultat pour "{{ request('search') }}"</p>
                                    <a href="{{ route('admin.type-posts.index') }}" class="btn btn-outline-secondary me-2">
                                        Voir tous les types
                                    </a>
                                @else
                                    <p class="mb-3">Commencez par créer votre premier type de post !</p>
                                @endif
                                <a href="{{ route('admin.type-posts.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer un type
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($typesPosts->hasPages())
        <div class="card-footer">
            {{ $typesPosts->withQueryString()->links() }}
        </div>
        @endif
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
                <p class="fw-bold" id="typePostNom"></p>
                <div id="warningPosts" class="alert alert-warning" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Attention :</strong> Ce type contient <span id="postsCount"></span> post(s). 
                    Vous devez d'abord déplacer ou supprimer ces posts.
                </div>
                <p class="text-danger small mb-0">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" id="deleteForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const typePostNom = document.getElementById('typePostNom');
    const warningPosts = document.getElementById('warningPosts');
    const postsCount = document.getElementById('postsCount');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const typePostId = this.dataset.typepostId;
            const nom = this.dataset.typepostNom;
            const postsCountValue = parseInt(this.dataset.postsCount);
            
            typePostNom.textContent = nom;
            deleteForm.action = `{{ route('admin.type-posts.index') }}/${typePostId}`;
            
            if (postsCountValue > 0) {
                warningPosts.style.display = 'block';
                postsCount.textContent = postsCountValue;
                confirmDeleteBtn.disabled = true;
                confirmDeleteBtn.innerHTML = '<i class="fas fa-ban me-1"></i>Suppression impossible';
                confirmDeleteBtn.classList.remove('btn-danger');
                confirmDeleteBtn.classList.add('btn-secondary');
            } else {
                warningPosts.style.display = 'none';
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Supprimer';
                confirmDeleteBtn.classList.remove('btn-secondary');
                confirmDeleteBtn.classList.add('btn-danger');
            }
            
            deleteModal.show();
        });
    });
});
</script>
@endpush