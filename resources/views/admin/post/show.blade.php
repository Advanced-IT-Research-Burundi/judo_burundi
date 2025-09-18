@extends('layouts.admin')

@section('title', 'Aperçu du Post')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Aperçu du Post</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                    <li class="breadcrumb-item active">Aperçu</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            {{-- <a href="{{ route('admin.posts.duplicate', $post) }}" class="btn btn-outline-secondary">
                <i class="fas fa-copy"></i> Dupliquer
            </a> --}}
            <button type="button" class="btn btn-outline-danger" onclick="deletePost({{ $post->id }})">
                <i class="fas fa-trash"></i> Supprimer
            </button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <!-- Article -->
            <article class="card mb-4">
                <div class="card-body">
                    <!-- En-tête de l'article -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="badge fs-6" style="background-color: {{ $post->typePost->couleur ?? '#6c757d' }}">
                                {{ $post->typePost->nom }}
                            </span>
                            @if($post->isEvent())
                                <span class="badge bg-info">
                                    <i class="fas fa-calendar"></i> Événement
                                </span>
                            @endif
                            {{-- @if($post->isUpcoming())
                                <span class="badge bg-warning text-dark">À venir</span>
                            @elseif($post->isPast() && $post->hasResults())
                                <span class="badge bg-success">Terminé</span>
                            @endif --}}
                        </div>
                        
                        <h1 class="display-6 mb-3">{{ $post->titre }}</h1>
                        
                        <div class="d-flex flex-wrap align-items-center text-muted small gap-3">
                            <div>
                                <i class="fas fa-user"></i>
                                Par <strong>{{ $post->user->name }}</strong>
                            </div>
                            <div>
                                <i class="fas fa-clock"></i>
                                {{ $post->formatted_date_post }}
                            </div>
                            @if($post->updated_at != $post->created_at)
                                <div>
                                    <i class="fas fa-edit"></i>
                                    Modifié le {{ $post->updated_at->locale('fr')->isoFormat('D MMMM YYYY') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Image d'illustration -->
                    @if($post->image)
                        <div class="mb-4">
                            <img src="{{ $post->image_url }}" alt="{{ $post->titre }}" 
                                 class="img-fluid rounded shadow-sm">
                        </div>
                    @endif

                    <!-- Contenu de l'article -->
                    <div class="article-content" style="line-height: 1.6;">
                        {!! nl2br(e($post->contenu)) !!}
                    </div>
                </div>
            </article>

            <!-- Informations d'événement -->
            @if($post->isEvent())
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt"></i> Détails de l'événement
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($post->lieu_evenement)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <div>
                                            <strong>Lieu</strong><br>
                                            {{ $post->lieu_evenement }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($post->date_evenement_debut)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-play-circle text-success me-2"></i>
                                        <div>
                                            <strong>Date de début</strong><br>
                                            {{ $post->formatted_date_evenement_debut }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($post->date_evenement_fin)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-stop-circle text-warning me-2"></i>
                                        <div>
                                            <strong>Date de fin</strong><br>
                                            {{ $post->formatted_date_evenement_fin }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($post->niveau_competition)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-trophy text-primary me-2"></i>
                                        <div>
                                            <strong>Niveau</strong><br>
                                            <span class="badge 
                                                @if($post->niveau_competition == 'Local') bg-secondary
                                                @elseif($post->niveau_competition == 'National') bg-primary
                                                @else bg-warning text-dark
                                                @endif">
                                                {{ $post->niveau_competition }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- <!-- Résultats -->
            @if($post->hasResults())
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-medal"></i> Résultats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-light border-start border-4 border-success">
                            {!! nl2br(e($post->resultats)) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div> --}}

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informations du post -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>#{{ $post->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $post->typePost->couleur ?? '#6c757d' }}">
                                        {{ $post->typePost->nom }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Auteur:</strong></td>
                                <td>{{ $post->user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date création:</strong></td>
                                <td>{{ $post->created_at->locale('fr')->isoFormat('D MMM YYYY [à] HH:mm') }}</td>
                            </tr>
                            @if($post->updated_at != $post->created_at)
                                <tr>
                                    <td><strong>Dernière modification:</strong></td>
                                    <td>{{ $post->updated_at->locale('fr')->isoFormat('D MMM YYYY [à] HH:mm') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Date publication:</strong></td>
                                <td>{{ $post->date_post->locale('fr')->isoFormat('D MMM YYYY [à] HH:mm') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Modifier ce post
                        </a>
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-plus"></i> Créer un nouveau post
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="copyUrl()">
                            <i class="fas fa-link"></i> Copier le lien
                        </button>
                        <hr>
                        <button type="button" class="btn btn-outline-warning" 
                                onclick="duplicatePost({{ $post->id }})">
                            <i class="fas fa-copy"></i> Dupliquer
                        </button>
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="deletePost({{ $post->id }})">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques (si vous les implémentez plus tard) -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <div class="fs-4 text-primary">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="small text-muted">Vues</div>
                                <div class="fw-bold">0</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <div class="fs-4 text-success">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="small text-muted">Likes</div>
                                <div class="fw-bold">0</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <div class="fs-4 text-warning">
                                    <i class="fas fa-share"></i>
                                </div>
                                <div class="small text-muted">Partages</div>
                                <div class="fw-bold">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
// Fonction de suppression
function deletePost(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/posts/${id}`;
    modal.show();
}

// Duplication du post
function duplicatePost(id) {
    if (confirm('Voulez-vous dupliquer ce post ?')) {
        window.location.href = `/admin/posts/${id}/duplicate`;
    }
}

// Copier l'URL
function copyUrl() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        // Créer une notification temporaire
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; width: auto;';
        alert.innerHTML = `
            <i class="fas fa-check-circle"></i> Lien copié dans le presse-papiers !
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
        document.body.appendChild(alert);
        
        // Supprimer automatiquement après 3 secondes
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 3000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie:', err);
        alert('Impossible de copier le lien automatiquement');
    });
}

// Impression du post
function printPost() {
    const printContent = document.querySelector('.article-content').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>${document.title}</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
                    h1 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }
                    .meta { color: #666; font-size: 14px; margin-bottom: 20px; }
                </style>
            </head>
            <body>
                <h1>{{ $post->titre }}</h1>
                <div class="meta">
                    Par {{ $post->user->name }} - {{ $post->formatted_date_post }}
                </div>
                <div>${printContent}</div>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Raccourcis clavier
document.addEventListener('keydown', function(e) {
    // Ctrl+E pour modifier
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        window.location.href = '{{ route("admin.posts.edit", $post) }}';
    }
    
    // Ctrl+D pour dupliquer
    if (e.ctrlKey && e.key === 'd') {
        e.preventDefault();
        duplicatePost({{ $post->id }});
    }
});
</script>
@endpush

@push('styles')
<style>
.article-content {
    font-size: 1.1rem;
    color: #333;
}

.article-content h1, .article-content h2, .article-content h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.article-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0 8px 8px 0;
}
</style>
@endpush
@endsection