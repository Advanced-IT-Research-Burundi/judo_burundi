{{-- resources/views/admin/countries/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestion des Pays')
@section('page-title', 'Pays')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex flex-column flex-lg-row justify-content-between align-items-stretch align-items-lg-center gap-3">
        <h5 class="mb-0"><i class="fas fa-globe me-2"></i>Pays ({{ $countries->total() ?? $countries->count() }})</h5>
        <form method="GET" action="{{ route('admin.countries.index') }}" class="d-flex gap-2 flex-grow-1" style="max-width: 28rem;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Rechercher..." value="{{ $search }}">
            <button class="btn btn-light btn-sm text-primary flex-shrink-0" type="submit" title="Rechercher">
                <i class="fas fa-search"></i>
            </button>
            @if($search)
                <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-light btn-sm flex-shrink-0" title="Effacer">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-body">
        @if($countries->count() > 0)
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
                <a href="{{ route('admin.countries.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Nouveau pays
                </a>
            </div>

            <form id="bulk-delete-form" method="POST" action="{{ route('admin.countries.bulk-delete') }}">
                @csrf
                @method('DELETE')

                <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="select-all">
                        <i class="fas fa-check-square me-1"></i>Tout sélectionner
                    </button>
                    <button type="submit" class="btn btn-sm btn-outline-danger" id="bulk-delete-btn" style="display: none;">
                        <i class="fas fa-trash me-1"></i>Supprimer sélectionnés
                    </button>
                    <span id="selected-count" class="text-muted small"></span>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="select-all-checkbox">
                                </th>
                                <th>Nom</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Date de création</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($countries as $country)
                            <tr>
                                <td>
                                    <input type="checkbox" name="countries[]" value="{{ $country->id }}" class="country-checkbox">
                                </td>
                                <td>
                                    <strong>{{ $country->name }}</strong>
                                </td>
                                <td>
                                    <code>{{ $country->slug }}</code>
                                </td>
                                <td>
                                    @if($country->description)
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $country->description }}">
                                            {{ Str::limit($country->description, 50) }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Aucune description</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $country->formatted_created_at }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.countries.show', $country) }}" 
                                           class="btn btn-outline-info"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.countries.edit', $country) }}" 
                                           class="btn btn-outline-warning"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" 
                                              action="{{ route('admin.countries.destroy', $country) }}" 
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce pays ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger"
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Affichage de {{ $countries->firstItem() }} à {{ $countries->lastItem() }} 
                    sur {{ $countries->total() }} résultats
                </div>
                {{ $countries->appends(['search' => $search])->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-globe fa-3x text-muted mb-3"></i>
                <h5>Aucun pays trouvé</h5>
                @if($search)
                    <p class="text-muted">Aucun résultat pour "{{ $search }}"</p>
                    <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-primary">
                        Voir tous les pays
                    </a>
                @else
                    <p class="text-muted">Commencez par ajouter votre premier pays</p>
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouveau Pays
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const countryCheckboxes = document.querySelectorAll('.country-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const selectedCount = document.getElementById('selected-count');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');

    // Fonction pour mettre à jour l'état des boutons
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.country-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
            selectedCount.textContent = `(${count} sélectionné${count > 1 ? 's' : ''})`;
        } else {
            bulkDeleteBtn.style.display = 'none';
            selectedCount.textContent = '';
        }
    }

    // Gérer la sélection globale
    selectAllCheckbox.addEventListener('change', function() {
        countryCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Gérer la sélection individuelle
    countryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(countryCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(countryCheckboxes).every(cb => !cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = !allChecked && !noneChecked;
            
            updateBulkActions();
        });
    });

    // Confirmation de suppression en lot
    bulkDeleteForm.addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.country-checkbox:checked').length;
        if (!confirm(`Êtes-vous sûr de vouloir supprimer ${checkedCount} pays sélectionné${checkedCount > 1 ? 's' : ''} ?`)) {
            e.preventDefault();
        }
    });
});
</script>
@endpush