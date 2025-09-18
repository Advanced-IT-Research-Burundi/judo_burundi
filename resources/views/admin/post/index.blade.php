@extends('layouts.admin')

@section('title', 'Gestion des Posts')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Gestion des Posts</h1>
            <p class="text-muted">Gérez tous les articles de la fédération</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Post
        </a>
    </div>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.posts.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" class="form-control" 
                               value="{{ request('search') }}" placeholder="Titre, contenu...">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="">Tous les types</option>
                            @foreach($typesPosts as $type)
                                <option value="{{ $type->id }}" 
                                        {{ request('type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Date début</label>
                        <input type="date" name="date_from" class="form-control" 
                               value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Date fin</label>
                        <input type="date" name="date_to" class="form-control" 
                               value="{{ request('date_to') }}">
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des Posts -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Posts ({{ $posts->total() }})</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-danger" onclick="deleteSelected()">
                    <i class="fas fa-trash"></i> Supprimer sélection
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th width="80">Image</th>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Auteur</th>
                        <th>Date publication</th>
                        <th>Événement</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input post-checkbox" 
                                   value="{{ $post->id }}">
                        </td>
                        <td>
                            @if($post->image)
                                <img src="{{ $post->image_url }}" alt="Image" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <strong>{{ Str::limit($post->titre, 50) }}</strong>
                                @if($post->isEvent())
                                    <span class="badge bg-info ms-1">
                                        <i class="fas fa-calendar"></i> Événement
                                    </span>
                                @endif
                                @if($post->isEvent())
                                    @if($post->isUpcoming())
                                        <span class="badge bg-warning">À venir</span>
                                    @elseif($post->isOngoing())
                                        <span class="badge bg-primary">En cours</span>
                                    @elseif($post->isPast() && $post->hasResults())
                                        <span class="badge bg-success">Terminé</span>
                                    @elseif($post->isPast())
                                        <span class="badge bg-secondary">Passé</span>
                                    @endif
                                @endif
                            </div>
                            <small class="text-muted">{{ $post->excerpt }}</small>
                        </td>
                        <td>
                            <span class="badge" style="background-color: {{ $post->typePost->couleur ?? '#6c757d' }}">
                                {{ $post->typePost->nom }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <small class="text-muted">{{ $post->user->name }}</small>
                            </div>
                        </td>
                        <td>
                            <div>
                                {{ $post->date_post->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">{{ $post->date_post->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            @if($post->isEvent())
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        {{ Str::limit($post->lieu_evenement, 20) }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        {{ $post->date_evenement_debut->format('d/m/Y H:i') }}
                                    </small>
                                    @if($post->date_evenement_fin && $post->date_evenement_fin != $post->date_evenement_debut)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-arrow-right"></i>
                                            {{ $post->date_evenement_fin->format('d/m/Y H:i') }}
                                        </small>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.posts.show', $post) }}" 
                                   class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                   class="btn btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" 
                                        title="Supprimer" onclick="deletePost({{ $post->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Aucun post trouvé</p>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                    Créer le premier post
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
        <div class="card-footer">
            {{ $posts->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce post ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" id="deleteForm" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sélection multiple des posts
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.post-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Fonction de suppression d'un post individuel
function deletePost(id) {
    console.log('Tentative de suppression du post ID:', id);
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    
    // Construction correcte de l'URL pour la suppression Laravel
    form.action = `{{ url('admin/posts') }}/${id}`;
    
    console.log('URL de suppression:', form.action);
    
    modal.show();
}

// Suppression multiple des posts sélectionnés
function deleteSelected() {
    const selectedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
    
    if (selectedCheckboxes.length === 0) {
        alert('Veuillez sélectionner au moins un post à supprimer.');
        return;
    }
    
    const confirmMessage = `Êtes-vous sûr de vouloir supprimer ${selectedCheckboxes.length} post(s) ? Cette action est irréversible.`;
    
    if (confirm(confirmMessage)) {
        const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
        
        // Création du formulaire de suppression multiple
        const bulkDeleteForm = document.createElement('form');
        bulkDeleteForm.method = 'POST';
        bulkDeleteForm.action = '{{ route("admin.posts.bulkDelete") }}';
        
        // Token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        bulkDeleteForm.appendChild(csrfInput);
        
        // Ajout des IDs sélectionnés
        selectedIds.forEach(id => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'ids[]';
            idInput.value = id;
            bulkDeleteForm.appendChild(idInput);
        });
        
        document.body.appendChild(bulkDeleteForm);
        bulkDeleteForm.submit();
    }
}

// Gestion de la soumission du formulaire de suppression
document.getElementById('deleteForm').addEventListener('submit', function(e) {
    console.log('Soumission du formulaire de suppression');
    console.log('Action:', this.action);
    
    // Interface de chargement
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Suppression...';
    submitButton.disabled = true;
    
    // Restauration du bouton en cas de problème (timeout de sécurité)
    setTimeout(() => {
        if (submitButton.disabled) {
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;
        }
    }, 10000);
});

// Debug des routes (à supprimer en production)
console.log('Route de base admin/posts:', '{{ url("admin/posts") }}');
console.log('Route index:', '{{ route("admin.posts.index") }}');
console.log('Token CSRF:', '{{ csrf_token() }}');
</script>
@endpush
@endsection