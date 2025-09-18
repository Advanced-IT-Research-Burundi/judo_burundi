@extends('layouts.admin')

@section('title', 'Gestion des Catégories')
@section('page-title', 'Gestion des Catégories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Catégories de Judo ({{ $categories->total() }})</h4>
            <p class="text-muted">Organisez les joueurs par catégories de poids et d'âge</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Catégorie
        </a>
    </div>

    <div class="row">
        @foreach($categories as $categorie)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-primary">{{ $categorie->nom }}</h6>
                        <span class="badge bg-info">{{ $categorie->joueurs_count }} joueurs</span>
                    </div>
                    <div class="card-body">
                        @if($categorie->description)
                            <p class="text-muted mb-3">{{ Str::limit($categorie->description, 100) }}</p>
                        @else
                            <p class="text-muted mb-3 fst-italic">Aucune description</p>
                        @endif
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Créée le {{ $categorie->created_at->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.categories.show', $categorie) }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                            <a href="{{ route('admin.categories.edit', $categorie) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </a>
                            @if($categorie->joueurs_count == 0)
                                <button class="btn btn-outline-danger btn-sm" 
                                        onclick="confirmDelete({{ $categorie->id }}, '{{ $categorie->nom }}')">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if($categories->count() == 0)
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune catégorie trouvée</h5>
                    <p class="text-muted">Commencez par créer votre première catégorie</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Créer une Catégorie
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
        </div>
    @endif

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong id="categoryName"></strong> ?</p>
                    <p class="text-danger"><small>Cette action est irréversible.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        document.getElementById('categoryName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/categories/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush
