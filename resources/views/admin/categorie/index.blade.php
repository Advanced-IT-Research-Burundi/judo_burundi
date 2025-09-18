@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">Gestion des Catégories</h1>
            <p class="text-muted mb-0">Gérez les catégories de joueurs de la fédération</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle Catégorie
            </a>
        </div>
    </div>

    <!-- Messages Flash -->
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
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
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
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Catégories <span class="badge bg-secondary">{{ $categories->total() }}</span>
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Nombre de Joueurs</th>
                        <th>Date de création</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $categorie)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                     style="width: 36px; height: 36px;">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $categorie->nom }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-muted mb-0">
                                {{ $categorie->description ? Str::limit($categorie->description, 60) : 'Aucune description' }}
                            </p>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-2">{{ $categorie->joueurs_count }}</span>
                                @if($categorie->joueurs_count > 0)
                                    <small class="text-muted">joueur{{ $categorie->joueurs_count > 1 ? 's' : '' }}</small>
                                @else
                                    <small class="text-muted">Aucun joueur</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                {{ $categorie->created_at->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">{{ $categorie->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.categories.show', $categorie) }}" 
                                   class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $categorie) }}" 
                                   class="btn btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger delete-btn" 
                                        title="Supprimer" data-categorie-id="{{ $categorie->id }}" 
                                        data-categorie-nom="{{ $categorie->nom }}"
                                        data-joueurs-count="{{ $categorie->joueurs_count }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                <h5>Aucune catégorie trouvée</h5>
                                @if(request('search'))
                                    <p class="mb-3">Aucun résultat pour "{{ request('search') }}"</p>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary me-2">
                                        Voir toutes les catégories
                                    </a>
                                @else
                                    <p class="mb-3">Commencez par créer votre première catégorie !</p>
                                @endif
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer une catégorie
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="card-footer">
            {{ $categories->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie :</p>
                <p class="fw-bold" id="categorieNom"></p>
                <div id="warningJoueurs" class="alert alert-warning" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Attention :</strong> Cette catégorie contient <span id="joueursCount"></span> joueur(s). 
                    Vous devez d'abord déplacer ou supprimer ces joueurs.
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
    const categorieNom = document.getElementById('categorieNom');
    const warningJoueurs = document.getElementById('warningJoueurs');
    const joueursCount = document.getElementById('joueursCount');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Gestion de la suppression
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categorieId = this.dataset.categorieId;
            const nom = this.dataset.categorieNom;
            const joueursCountValue = parseInt(this.dataset.joueursCount);
            
            categorieNom.textContent = nom;
            deleteForm.action = `{{ route('admin.categories.index') }}/${categorieId}`;
            
            if (joueursCountValue > 0) {
                warningJoueurs.style.display = 'block';
                joueursCount.textContent = joueursCountValue;
                confirmDeleteBtn.disabled = true;
                confirmDeleteBtn.innerHTML = '<i class="fas fa-ban me-1"></i>Suppression impossible';
                confirmDeleteBtn.classList.remove('btn-danger');
                confirmDeleteBtn.classList.add('btn-secondary');
            } else {
                warningJoueurs.style.display = 'none';
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Supprimer';
                confirmDeleteBtn.classList.remove('btn-secondary');
                confirmDeleteBtn.classList.add('btn-danger');
            }
            
            deleteModal.show();
        });
    });

    // Animation du formulaire de suppression
    deleteForm.addEventListener('submit', function(e) {
        if (!confirmDeleteBtn.disabled) {
            const originalHtml = confirmDeleteBtn.innerHTML;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Suppression...';
            confirmDeleteBtn.disabled = true;
            
            // Timeout de sécurité
            setTimeout(() => {
                confirmDeleteBtn.innerHTML = originalHtml;
                confirmDeleteBtn.disabled = false;
            }, 10000);
        }
    });

    // Auto-hide des alertes
    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Mise en évidence de la recherche
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && searchInput.value) {
        searchInput.classList.add('bg-warning', 'bg-opacity-25');
    }
});
</script>
@endpush