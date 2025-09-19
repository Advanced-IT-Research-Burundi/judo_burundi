
@extends('admin.layout')

@section('title', 'Galerie')
@section('page-title', 'Gestion de la Galerie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-images me-2"></i>
        Galerie Photos
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Ajouter une image
        </a>
        <button class="btn btn-secondary" id="bulkActionBtn" style="display: none;">
            <i class="fas fa-cogs me-1"></i>
            Actions groupées
        </button>
    </div>
</div>

{{-- Filtres de recherche --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Rechercher</label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Titre, description, lieu...">
            </div>
            <div class="col-md-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-select" name="categorie" id="categorie">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" 
                                {{ request('categorie') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-select" name="statut" id="statut">
                    <option value="">Tous les statuts</option>
                    @foreach($statuts as $key => $label)
                        <option value="{{ $key }}" 
                                {{ request('statut') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search me-1"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Formulaire pour actions groupées --}}
<form id="bulkForm" method="POST" action="{{ route('admin.gallery.bulk-action') }}" style="display: none;">
    @csrf
    <div class="card mb-4 border-warning">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <strong>Actions groupées :</strong>
                    <span id="selectedCount">0</span> image(s) sélectionnée(s)
                </div>
                <div class="col-md-4">
                    <select name="action" class="form-select" required>
                        <option value="">Choisir une action</option>
                        <option value="activate">Activer</option>
                        <option value="deactivate">Désactiver</option>
                        <option value="delete">Supprimer</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-warning me-2">Exécuter</button>
                    <button type="button" class="btn btn-outline-secondary" id="cancelBulk">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body">
        @if($images->count() > 0)
            <div class="row" id="gallery-grid">
                @foreach($images as $image)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 image-card {{ $image->statut }}">
                        <div class="card-img-container">
                            <input type="checkbox" 
                                   class="image-selector position-absolute top-0 start-0 m-2" 
                                   name="images[]" 
                                   value="{{ $image->id }}"
                                   style="z-index: 10;">
                            
                            @if($image->hasImage())
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $image->alt_text }}" 
                                     class="card-img-top"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="image-overlay">
                                <div class="btn-group">
                                    <a href="{{ route('admin.gallery.show', $image) }}" 
                                       class="btn btn-sm btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.gallery.edit', $image) }}" 
                                       class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.toggle-status', $image) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm {{ $image->statut == 'actif' ? 'btn-secondary' : 'btn-success' }}" 
                                                title="{{ $image->statut == 'actif' ? 'Désactiver' : 'Activer' }}">
                                            <i class="fas {{ $image->statut == 'actif' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.gallery.destroy', $image) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">{{ Str::limit($image->titre, 30) }}</h6>
                                <span class="badge bg-{{ $image->statut == 'actif' ? 'success' : 'secondary' }}">
                                    {{ $image->statut }}
                                </span>
                            </div>
                            
                            @if($image->categorie)
                                <span class="badge bg-primary mb-2">{{ $categories[$image->categorie] ?? $image->categorie }}</span>
                            @endif
                            
                            @if($image->description)
                                <p class="card-text small text-muted mb-2">
                                    {{ Str::limit($image->description, 80) }}
                                </p>
                            @endif
                            
                            <div class="small text-muted">
                                <div class="mb-1">
                                    <i class="fas fa-sort-numeric-up me-1"></i>
                                    Ordre : {{ $image->ordre }}
                                </div>
                                @if($image->date_prise)
                                    <div class="mb-1">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $image->formatted_date_prise }}
                                    </div>
                                @endif
                                @if($image->lieu)
                                    <div>
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ Str::limit($image->lieu, 25) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $images->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune image trouvée</h5>
                <p class="text-muted">Commencez par ajouter votre première image à la galerie.</p>
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Ajouter une image
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.image-card {
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.image-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.image-card.inactif {
    opacity: 0.7;
}

.card-img-container {
    position: relative;
    overflow: hidden;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-img-container:hover .image-overlay {
    opacity: 1;
}

.image-selector {
    background: white;
    border: 2px solid #ddd;
    border-radius: 3px;
    width: 18px;
    height: 18px;
}

.image-selector:checked {
    background: #007bff;
    border-color: #007bff;
}

#gallery-grid.sortable .card {
    cursor: move;
}

.ui-sortable-helper {
    transform: rotate(5deg);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageSelectors = document.querySelectorAll('.image-selector');
    const bulkForm = document.getElementById('bulkForm');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const selectedCount = document.getElementById('selectedCount');
    const cancelBulk = document.getElementById('cancelBulk');

    // Gestion de la sélection multiple
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.image-selector:checked');
        const count = checkedBoxes.length;
        
        selectedCount.textContent = count;
        
        if (count > 0) {
            bulkForm.style.display = 'block';
            bulkActionBtn.style.display = 'inline-block';
        } else {
            bulkForm.style.display = 'none';
            bulkActionBtn.style.display = 'none';
        }

        // Mettre à jour les inputs cachés
        const existingInputs = bulkForm.querySelectorAll('input[name="images[]"]');
        existingInputs.forEach(input => input.remove());
        
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'images[]';
            input.value = checkbox.value;
            bulkForm.appendChild(input);
        });
    }

    imageSelectors.forEach(selector => {
        selector.addEventListener('change', updateBulkActions);
    });

    // Bouton d'annulation des actions groupées
    cancelBulk.addEventListener('click', function() {
        imageSelectors.forEach(selector => {
            selector.checked = false;
        });
        updateBulkActions();
    });

    // Confirmation pour la suppression groupée
    bulkForm.addEventListener('submit', function(e) {
        const action = bulkForm.querySelector('select[name="action"]').value;
        if (action === 'delete') {
            const count = document.querySelectorAll('.image-selector:checked').length;
            if (!confirm(`Êtes-vous sûr de vouloir supprimer ${count} image(s) ? Cette action est irréversible.`)) {
                e.preventDefault();
            }
        }
    });

    // Sélection avec Ctrl+clic
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
            document.body.classList.add('ctrl-pressed');
        }
    });

    document.addEventListener('keyup', function(e) {
        if (!e.ctrlKey) {
            document.body.classList.remove('ctrl-pressed');
        }
    });
});
</script>
@endpush
@endsection