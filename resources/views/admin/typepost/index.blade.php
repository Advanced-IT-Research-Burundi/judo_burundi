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
            @if($typePosts->count() > 0)
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
                            @foreach($typePosts as $typePost)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <strong>{{ $typePost->nom }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        @if($typePost->description)
                                            <span class="text-muted">{{ Str::limit($typePost->description, 80) }}</span>
                                        @else
                                            <em class="text-muted">Aucune description</em>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6">
                                            {{ $typePost->posts_count }}
                                            {{ $typePost->posts_count > 1 ? 'articles' : 'article' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $typePost->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.type-posts.show', $typePost) }}" 
                                               class="btn btn-sm btn-outline-info" title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.type-posts.edit', $typePost) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($typePost->posts_count == 0)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="confirmDelete({{ $typePost->id }}, '{{ $typePost->nom }}')" 
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                        title="Impossible de supprimer (contient des articles)" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($typePosts->hasPages())
                    <div class="card-footer">
                        {{ $typePosts->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun type de post trouvé</h5>
                    <p class="text-muted">Créez des types pour organiser vos articles par catégorie</p>
                    <a href="{{ route('admin.type-posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Créer le Premier Type
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Suggestions de types par défaut -->
    @if($typePosts->count() == 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-lightbulb me-2"></i>Suggestions de Types d'Articles
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Voici quelques types d'articles courants pour une fédération de judo :</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-newspaper text-info me-2"></i><strong>Actualité</strong> - News générales</li>
                                    <li><i class="fas fa-trophy text-warning me-2"></i><strong>Compétition</strong> - Tournois et championnats</li>
                                    <li><i class="fas fa-chart-line text-success me-2"></i><strong>Résultats</strong> - Résultats de compétitions</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-graduation-cap text-primary me-2"></i><strong>Formation</strong> - Stages et formations</li>
                                    <li><i class="fas fa-calendar-alt text-info me-2"></i><strong>Événement</strong> - Événements spéciaux</li>
                                    <li><i class="fas fa-bullhorn text-danger me-2"></i><strong>Annonce</strong> - Communications officielles</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Attention ! Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer le type <strong id="typeName"></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .type-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #7CB342 0%, #689F3A 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-group .btn {
        border-radius: 4px;
        margin-right: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, name) {
        document.getElementById('typeName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/type-posts/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush

@php
    // Helper function pour les icônes
    function getTypeIcon($typeName) {
        $icons = [
            'Actualité' => 'newspaper',
            'Compétition' => 'trophy',
            'Événement' => 'calendar-alt',
            'Formation' => 'graduation-cap',
            'Résultats' => 'chart-line',
            'Annonce' => 'bullhorn'
        ];
        return $icons[$typeName] ?? 'file-alt';
    }
@endphp