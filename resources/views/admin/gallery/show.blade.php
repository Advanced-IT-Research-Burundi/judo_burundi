@extends('admin.layout')

@section('title', $galleryImage->titre)
@section('page-title', 'Détail de l\'Image')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-image me-2"></i>
        {{ Str::limit($galleryImage->titre, 50) }}
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.gallery.edit', $galleryImage) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            Modifier
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Retour à la galerie
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body text-center">
                @if($galleryImage->hasImage())
                    <img src="{{ $galleryImage->image_url }}" 
                         alt="{{ $galleryImage->alt_text }}" 
                         class="img-fluid rounded shadow mb-3"
                         style="max-height: 600px;">
                    
                    <div class="image-actions mt-3">
                        <a href="{{ $galleryImage->image_url }}" 
                           target="_blank" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>
                            Voir en taille réelle
                        </a>
                        <button class="btn btn-outline-secondary" onclick="copyImageUrl()">
                            <i class="fas fa-copy me-1"></i>
                            Copier l'URL
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Image manquante ou non trouvée sur le serveur.
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations détaillées
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Titre :</strong>
                    </div>
                    <div class="col-md-9 mb-3">
                        <h5 class="text-primary mb-0">{{ $galleryImage->titre }}</h5>
                    </div>
                </div>

                @if($galleryImage->description)
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Description :</strong>
                        </div>
                        <div class="col-md-9 mb-3">
                            <p class="mb-0">{{ $galleryImage->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-3">
                        <strong>Statut :</strong>
                    </div>
                    <div class="col-md-9 mb-3">
                        <span class="badge bg-{{ $galleryImage->statut == 'actif' ? 'success' : 'secondary' }} fs-6">
                            {{ ucfirst($galleryImage->statut) }}
                        </span>
                    </div>
                </div>

                @if($galleryImage->categorie)
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Catégorie :</strong>
                        </div>
                        <div class="col-md-9 mb-3">
                            <span class="badge bg-primary fs-6">
                                {{ \App\Models\GalleryImage::getCategories()[$galleryImage->categorie] ?? $galleryImage->categorie }}
                            </span>
                        </div>
                    </div>
                @endif

                @if($galleryImage->date_prise)
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Date de prise :</strong>
                        </div>
                        <div class="col-md-9 mb-3">
                            {{ $galleryImage->formatted_date_prise }}
                            <small class="text-muted">
                                ({{ $galleryImage->date_prise->diffForHumans() }})
                            </small>
                        </div>
                    </div>
                @endif

                @if($galleryImage->lieu)
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Lieu :</strong>
                        </div>
                        <div class="col-md-9 mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                            {{ $galleryImage->lieu }}
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-3">
                        <strong>Ordre d'affichage :</strong>
                    </div>
                    <div class="col-md-9 mb-3">
                        <span class="badge bg-info">{{ $galleryImage->ordre }}</span>
                    </div>
                </div>

                @if($galleryImage->alt_text)
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Texte alternatif :</strong>
                        </div>
                        <div class="col-md-9 mb-0">
                            <code>{{ $galleryImage->alt_text }}</code>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Informations techniques
                </h6>
            </div>
            <div class="card-body">
                @if($galleryImage->hasImage())
                    @php
                        $imageSize = $galleryImage->getImageSize();
                        $dimensions = $galleryImage->getImageDimensions();
                        $fileSizeFormatted = number_format($imageSize / 1024 / 1024, 2);
                    @endphp
                    
                    <div class="mb-3">
                        <strong>Dimensions :</strong><br>
                        <span class="text-primary">{{ $dimensions['width'] }} x {{ $dimensions['height'] }} px</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Taille du fichier :</strong><br>
                        <span class="text-info">{{ $fileSizeFormatted }} MB</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Type MIME :</strong><br>
                        <code>{{ mime_content_type(storage_path('app/public/' . $galleryImage->image)) ?? 'Non détecté' }}</code>
                    </div>
                @endif
                
                <div class="mb-3">
                    <strong>Chemin du fichier :</strong><br>
                    <small class="text-muted font-monospace">{{ $galleryImage->image }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>URL publique :</strong><br>
                    <div class="input-group input-group-sm">
                        <input type="text" 
                               class="form-control" 
                               id="imageUrl" 
                               value="{{ $galleryImage->image_url }}" 
                               readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyImageUrl()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Historique
                </h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <div class="mb-2">
                        <strong>ID :</strong> #{{ $galleryImage->id }}
                    </div>
                    <div class="mb-2">
                        <strong>Créée le :</strong><br>
                        {{ $galleryImage->created_at->format('d/m/Y à H:i') }}
                        <small class="text-muted d-block">{{ $galleryImage->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="mb-0">
                        <strong>Modifiée le :</strong><br>
                        {{ $galleryImage->updated_at->format('d/m/Y à H:i') }}
                        <small class="text-muted d-block">{{ $galleryImage->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Actions rapides
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.gallery.edit', $galleryImage) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Modifier cette image
                    </a>
                    
                    <form action="{{ route('admin.gallery.toggle-status', $galleryImage) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ $galleryImage->statut == 'actif' ? 'btn-secondary' : 'btn-success' }} w-100">
                            <i class="fas {{ $galleryImage->statut == 'actif' ? 'fa-eye-slash' : 'fa-eye' }} me-2"></i>
                            {{ $galleryImage->statut == 'actif' ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        Ajouter une nouvelle image
                    </a>
                    
                    <hr class="my-2">
                    
                    <form action="{{ route('admin.gallery.destroy', $galleryImage) }}" 
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyImageUrl() {
    const imageUrl = document.getElementById('imageUrl');
    imageUrl.select();
    imageUrl.setSelectionRange(0, 99999); // Pour mobile
    
    try {
        document.execCommand('copy');
        
        // Feedback visuel
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
        
    } catch (err) {
        alert('Erreur lors de la copie. Sélectionnez manuellement l\'URL.');
    }
}

// Raccourcis clavier
document.addEventListener('keydown', function(e) {
    // Ctrl+E pour éditer
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        window.location.href = '{{ route('admin.gallery.edit', $galleryImage) }}';
    }
    
    // Ctrl+Backspace pour supprimer
    if (e.ctrlKey && e.key === 'Backspace') {
        e.preventDefault();
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            document.querySelector('form[action*="destroy"]').submit();
        }
    }
});
</script>
@endpush
@endsection