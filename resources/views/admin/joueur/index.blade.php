@extends('layouts.admin')

@section('title', 'Gestion des Joueurs')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-1">Gestion des Joueurs</h1>
            <p class="text-muted mb-0">Gérez tous les joueurs inscrits à la fédération</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouveau Joueur
                </a>
                <a href="{{ route('admin.joueurs.export') }}" class="btn btn-outline-success">
                    <i class="fas fa-download me-2"></i>Export CSV
                </a>
            </div>
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
                <i class="fas fa-filter me-2"></i>Filtres et Recherche
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.joueurs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Recherche</label>
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Nom, prénom, email...">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie" class="form-select">
                        <option value="">Toutes</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" 
                                    {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Sexe</label>
                    <select name="sexe" class="form-select">
                        <option value="">Tous</option>
                        <option value="M" {{ request('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ request('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Âge min</label>
                    <input type="number" name="age_min" class="form-control" 
                           value="{{ request('age_min') }}" min="0" max="100" placeholder="15">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Âge max</label>
                    <input type="number" name="age_max" class="form-control" 
                           value="{{ request('age_max') }}" min="0" max="100" placeholder="65">
                </div>
                
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            @if(request()->hasAny(['search', 'categorie', 'sexe', 'age_min', 'age_max']))
                <div class="mt-3">
                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i>Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des joueurs -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Joueurs <span class="badge bg-secondary">{{ $joueurs->total() }}</span>
            </h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-danger" id="bulkDeleteBtn" style="display: none;">
                    <i class="fas fa-trash me-1"></i>Supprimer la sélection
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
                        <th>Joueur</th>
                        <th>Contact</th>
                        <th>Âge</th>
                        <th>Catégorie</th>
                        <th>Colline</th>
                        <th>Inscription</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($joueurs as $joueur)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input joueur-checkbox" 
                                   value="{{ $joueur->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    {{ $joueur->initiales }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $joueur->nom_complet }}</h6>
                                    @if($joueur->lieu_naissance)
                                        <small class="text-muted">
                                            <i class="fas fa-map-pin me-1"></i>{{ $joueur->lieu_naissance }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                @if($joueur->email)
                                    <div class="mb-1">
                                        <i class="fas fa-envelope me-1 text-muted"></i>
                                        <a href="mailto:{{ $joueur->email }}" class="text-decoration-none">
                                            {{ $joueur->email }}
                                        </a>
                                    </div>
                                @endif
                                @if($joueur->telephone)
                                    <div>
                                        <i class="fas fa-phone me-1 text-muted"></i>
                                        <a href="tel:{{ $joueur->telephone }}" class="text-decoration-none">
                                            {{ $joueur->telephone }}
                                        </a>
                                    </div>
                                @endif
                                @if(!$joueur->email && !$joueur->telephone)
                                    <small class="text-muted">Pas de contact</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                @if($joueur->age)
                                    <span class="badge bg-info">{{ $joueur->age }} ans</span>
                                    @if($joueur->sexe)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-{{ $joueur->sexe == 'M' ? 'mars' : 'venus' }} me-1"></i>
                                            {{ $joueur->sexe == 'M' ? 'H' : 'F' }}
                                        </small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $joueur->categorie->nom }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $joueur->colline->nom }}</strong>
                                @if($joueur->colline->zone)
                                    <br>
                                    <small class="text-muted">{{ $joueur->colline->zone->nom }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                {{ $joueur->created_at->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">{{ $joueur->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.joueurs.show', $joueur) }}" 
                                   class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.joueurs.edit', $joueur) }}" 
                                   class="btn btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger delete-btn" 
                                        title="Supprimer" data-joueur-id="{{ $joueur->id }}" 
                                        data-joueur-nom="{{ $joueur->nom_complet }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                @if(request()->hasAny(['search', 'categorie', 'sexe', 'age_min', 'age_max']))
                                    <h5>Aucun joueur trouvé</h5>
                                    <p class="mb-3">Aucun résultat pour les critères sélectionnés</p>
                                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary me-2">
                                        Voir tous les joueurs
                                    </a>
                                @else
                                    <h5>Aucun joueur inscrit</h5>
                                    <p class="mb-3">Commencez par inscrire votre premier joueur !</p>
                                @endif
                                <a href="{{ route('admin.joueurs.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Inscrire un joueur
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($joueurs->hasPages())
        <div class="card-footer">
            {{ $joueurs->withQueryString()->links() }}
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
                <p>Êtes-vous sûr de vouloir supprimer le joueur :</p>
                <p class="fw-bold" id="joueurNom"></p>
                <p class="text-danger small mb-0">Cette action supprimera définitivement toutes les données du joueur.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" id="deleteForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const joueurCheckboxes = document.querySelectorAll('.joueur-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const joueurNom = document.getElementById('joueurNom');

    // Gestion de la sélection multiple
    selectAllCheckbox.addEventListener('change', function() {
        joueurCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkDeleteButton();
    });

    joueurCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.joueur-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === joueurCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < joueurCheckboxes.length;
            toggleBulkDeleteButton();
        });
    });

    function toggleBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.joueur-checkbox:checked');
        bulkDeleteBtn.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
    }

    // Gestion de la suppression individuelle
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const joueurId = this.dataset.joueurId;
            const nom = this.dataset.joueurNom;
            
            joueurNom.textContent = nom;
            deleteForm.action = `{{ route('admin.joueurs.index') }}/${joueurId}`;
            deleteModal.show();
        });
    });

    // Gestion de la suppression multiple
    bulkDeleteBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.joueur-checkbox:checked');
        const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
        
        if (selectedIds.length === 0) {
            alert('Veuillez sélectionner au moins un joueur à supprimer.');
            return;
        }

        if (confirm(`Êtes-vous sûr de vouloir supprimer ${selectedIds.length} joueur(s) ? Cette action est irréversible.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.joueurs.bulkDelete") }}';

            // Token CSRF
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // IDs sélectionnés
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }
    });

    // Animation du formulaire de suppression
    deleteForm.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalHtml = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Suppression...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
        }, 10000);
    });

    // Auto-hide des alertes
    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Mise en évidence des filtres actifs
    const inputs = document.querySelectorAll('input[name], select[name]');
    inputs.forEach(input => {
        if (input.value && input.name !== '_token') {
            input.classList.add('bg-warning', 'bg-opacity-25');
        }
    });
});
</script>
@endpush --}}