{{-- resources/views/admin/countries/show.blade.php --}}
@extends('layouts.admin')

@section('title', $country->name)
@section('page-title', 'Détails du pays')

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Modifier
        </a>
        <form method="POST" 
              action="{{ route('admin.countries.destroy', $country) }}" 
              class="d-inline"
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce pays ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>Supprimer
            </button>
        </form>
        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Informations principales -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-globe me-2"></i>{{ $country->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <strong>Nom:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $country->name }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <strong>Slug:</strong>
                    </div>
                    <div class="col-md-9">
                        <code>{{ $country->slug }}</code>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-md-9">
                        @if($country->description)
                            <div class="border-start border-primary border-3 ps-3">
                                {!! nl2br(e($country->description)) !!}
                            </div>
                        @else
                            <span class="text-muted fst-italic">Aucune description</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Métadonnées -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Métadonnées
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">ID</small>
                    <strong>{{ $country->id }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Date de création</small>
                    <strong>{{ $country->formatted_created_at }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Dernière modification</small>
                    <strong>{{ $country->formatted_updated_at }}</strong>
                </div>

                @if($country->created_at != $country->updated_at)
                <div class="mb-0">
                    <small class="text-muted d-block">Modifié il y a</small>
                    <strong>{{ $country->updated_at->diffForHumans() }}</strong>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Actions rapides
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.countries.edit', $country) }}" 
                       class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-2"></i>Modifier ce pays
                    </a>
                    
                    <a href="{{ route('admin.countries.create') }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Nouveau pays
                    </a>
                    
                    <button type="button" 
                            class="btn btn-outline-secondary btn-sm"
                            onclick="copyToClipboard('{{ $country->slug }}')">
                        <i class="fas fa-copy me-2"></i>Copier le slug
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistiques (si applicable) -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statistiques
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-chart-pie fa-2x text-muted mb-2"></i>
                    <p class="text-muted small">
                        Les statistiques d'utilisation seront disponibles prochainement
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Afficher une notification de succès
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
        toast.style.zIndex = '1050';
        toast.innerHTML = `
            <div class="toast show" role="alert">
                <div class="toast-header">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <strong class="me-auto">Copié!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    Le slug a été copié dans le presse-papiers
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        
        // Supprimer le toast après 3 secondes
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 3000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie: ', err);
        alert('Erreur lors de la copie du slug');
    });
}
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
