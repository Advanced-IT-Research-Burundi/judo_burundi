@extends('admin.layout')

@section('title', 'Modifier l\'Image')
@section('page-title', 'Modifier l\'Image')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-edit me-2"></i>
        Modifier : {{ Str::limit($galleryImage->titre, 40) }}
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.gallery.show', $galleryImage) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-1"></i>
            Voir
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Retour à la galerie
        </a>
    </div>
</div>

<form action="{{ route('admin.gallery.update', $galleryImage) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations de l'image
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="titre" class="form-label">
                            Titre <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('titre') is-invalid @enderror" 
                               id="titre" 
                               name="titre" 
                               value="{{ old('titre', $galleryImage->titre) }}" 
                               required
                               placeholder="Titre descriptif de l'image">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Description détaillée de l'image (optionnel)">{{ old('description', $galleryImage->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">
                            Changer l'image
                        </label>
                        
                        @if($galleryImage->hasImage())
                            <div class="mb-3">
                                <div class="current-image">
                                    <img src="{{ $galleryImage->image_url }}" 
                                         alt="{{ $galleryImage->alt_text }}" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px;">
                                    <div class="form-text mt-2">Image actuelle</div>
                                </div>
                            </div>
                        @endif
                        
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Laisser vide pour conserver l'image actuelle. Formats acceptés : JPG, PNG, GIF. Taille max : 5 Mo.
                        </div>
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="preview" src="" alt="Aperçu" class="img-thumbnail" style="max-height: 200px;">
                            <div class="form-text">Nouvelle image</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alt_text" class="form-label">
                            Texte alternatif
                        </label>
                        <input type="text" 
                               class="form-control @error('alt_text') is-invalid @enderror" 
                               id="alt_text" 
                               name="alt_text" 
                               value="{{ old('alt_text', $galleryImage->alt_text) }}"
                               placeholder="Texte alternatif pour l'accessibilité">
                        @error('alt_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Utilisé par les lecteurs d'écran pour décrire l'image.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>
                        Classification et métadonnées
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categorie" class="form-label">
                                    Catégorie
                                </label>
                                <select class="form-select @error('categorie') is-invalid @enderror" 
                                        id="categorie" 
                                        name="categorie">
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" 
                                                {{ old('categorie', $galleryImage->categorie) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="statut" class="form-label">
                                    Statut <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('statut') is-invalid @enderror" 
                                        id="statut" 
                                        name="statut" 
                                        required>
                                    @foreach($statuts as $key => $label)
                                        <option value="{{ $key }}" 
                                                {{ old('statut', $galleryImage->statut) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_prise" class="form-label">
                                    Date de prise
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_prise') is-invalid @enderror" 
                                       id="date_prise" 
                                       name="date_prise" 
                                       value="{{ old('date_prise', $galleryImage->date_prise ? $galleryImage->date_prise->format('Y-m-d') : '') }}">
                                @error('date_prise')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lieu" class="form-label">
                                    Lieu
                                </label>
                                <input type="text" 
                                       class="form-control @error('lieu') is-invalid @enderror" 
                                       id="lieu" 
                                       name="lieu" 
                                       value="{{ old('lieu', $galleryImage->lieu) }}"
                                       placeholder="Lieu où la photo a été prise">
                                @error('lieu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ordre" class="form-label">
                            Ordre d'affichage
                        </label>
                        <input type="number" 
                               class="form-control @error('ordre') is-invalid @enderror" 
                               id="ordre" 
                               name="ordre" 
                               value="{{ old('ordre', $galleryImage->ordre) }}"
                               min="0"
                               placeholder="0">
                        @error('ordre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Plus le nombre est petit, plus l'image apparaîtra en premier.
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Mettre à jour
                </button>
                <a href="{{ route('admin.gallery.show', $galleryImage) }}" class="btn btn-outline-info">
                    <i class="fas fa-eye me-1"></i>
                    Voir l'image
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    Annuler
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations de l'image
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-2">
                            <strong>ID :</strong> #{{ $galleryImage->id }}
                        </div>
                        <div class="mb-2">
                            <strong>Statut actuel :</strong>
                            <span class="badge bg-{{ $galleryImage->statut == 'actif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($galleryImage->statut) }}
                            </span>
                        </div>
                        @if($galleryImage->categorie)
                            <div class="mb-2">
                                <strong>Catégorie actuelle :</strong><br>
                                <span class="badge bg-primary">
                                    {{ $categories[$galleryImage->categorie] ?? $galleryImage->categorie }}
                                </span>
                            </div>
                        @endif
                        <div class="mb-2">
                            <strong>Créée le :</strong><br>
                            {{ $galleryImage->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div class="mb-0">
                            <strong>Modifiée le :</strong><br>
                            {{ $galleryImage->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            @if($galleryImage->hasImage())
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>
                            Informations techniques
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $dimensions = $galleryImage->getImageDimensions();
                            $fileSize = $galleryImage->getImageSize();
                        @endphp
                        <div class="small">
                            <div class="mb-2">
                                <strong>Dimensions :</strong><br>
                                {{ $dimensions['width'] }} x {{ $dimensions['height'] }} px
                            </div>
                            <div class="mb-2">
                                <strong>Taille :</strong><br>
                                {{ number_format($fileSize / 1024 / 1024, 2) }} MB
                            </div>
                            <div class="mb-0">
                                <strong>Chemin :</strong><br>
                                <code class="small">{{ $galleryImage->image }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-header bg-danger text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-trash me-2"></i>
                        Zone de danger
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger mb-3">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>Attention :</strong> La suppression d'une image est irréversible.
                    </div>
                    <form action="{{ route('admin.gallery.destroy', $galleryImage) }}" 
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash me-1"></i>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    const titreInput = document.getElementById('titre');
    const altTextInput = document.getElementById('alt_text');

    // Aperçu de la nouvelle image
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Vérifier le type de fichier
            if (!file.type.match('image.*')) {
                alert('Veuillez sélectionner un fichier image.');
                this.value = '';
                preview.style.display = 'none';
                return;
            }

            // Vérifier la taille du fichier (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('Le fichier est trop volumineux. Taille maximum : 5 MB.');
                this.value = '';
                preview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Auto-remplir le texte alternatif basé sur le titre si vide
    titreInput.addEventListener('input', function() {
        if (this.value && !altTextInput.value.trim()) {
            altTextInput.value = this.value;
        }
    });

    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl+S pour sauvegarder
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.querySelector('form').submit();
        }
    });
});
</script>
@endpush
@endsection