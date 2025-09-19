@extends('admin.layout')

@section('title', 'Ajouter une Image')
@section('page-title', 'Ajouter une Image à la Galerie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-plus me-2"></i>
        Ajouter une Image
    </h2>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Retour à la galerie
    </a>
</div>

<form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
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
                               value="{{ old('titre') }}" 
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
                                  placeholder="Description détaillée de l'image (optionnel)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Décrivez le contenu, le contexte ou l'événement représenté dans l'image.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">
                            Image <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Formats acceptés : JPG, PNG, GIF. Taille max : 5 Mo. Dimensions recommandées : 1200x800px.
                        </div>
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="preview" src="" alt="Aperçu" class="img-thumbnail" style="max-height: 300px;">
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
                               value="{{ old('alt_text') }}"
                               placeholder="Texte alternatif pour l'accessibilité">
                        @error('alt_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Utilisé par les lecteurs d'écran. Sera généré automatiquement à partir du titre si non renseigné.
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
                                                {{ old('categorie') == $key ? 'selected' : '' }}>
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
                                                {{ old('statut', 'actif') == $key ? 'selected' : '' }}>
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
                                       value="{{ old('date_prise') }}">
                                @error('date_prise')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Date à laquelle la photo a été prise.
                                </div>
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
                                       value="{{ old('lieu') }}"
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
                               value="{{ old('ordre', 0) }}"
                               min="0"
                               placeholder="0">
                        @error('ordre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Plus le nombre est petit, plus l'image apparaîtra en premier. Laisser 0 pour un ordre automatique.
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Ajouter l'image
                </button>
                <button type="submit" name="add_another" value="1" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>
                    Ajouter et créer une autre
                </button>
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
                        <i class="fas fa-lightbulb me-2"></i>
                        Conseils pour de bonnes images
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Qualité :</strong> Utilisez des images haute résolution (minimum 1200px de largeur).
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Format :</strong> JPG pour les photos, PNG pour les graphiques avec transparence.
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Titre :</strong> Utilisez des titres descriptifs et informatifs.
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Accessibilité :</strong> Remplissez le texte alternatif pour les malvoyants.
                        </div>
                        <div class="mb-0">
                            <i class="fas fa-info-circle text-info me-1"></i>
                            <strong>SEO :</strong> Une bonne description améliore le référencement.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations techniques
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-2">
                            <strong>Taille max :</strong> 5 MB
                        </div>
                        <div class="mb-2">
                            <strong>Formats :</strong> JPG, PNG, GIF
                        </div>
                        <div class="mb-2">
                            <strong>Dimensions recommandées :</strong> 1200x800px
                        </div>
                        <div class="mb-0">
                            <strong>Ratio recommandé :</strong> 3:2 ou 16:9
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-palette me-2"></i>
                        Catégories
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        @foreach($categories as $key => $label)
                            <div class="mb-1">
                                <span class="badge bg-primary me-1">{{ $label }}</span>
                                <small class="text-muted">{{ $key }}</small>
                            </div>
                        @endforeach
                    </div>
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

    // Aperçu de l'image
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Vérifier le type de fichier
            if (!file.type.match('image.*')) {
                alert('Veuillez sélectionner un fichier image.');
                return;
            }

            // Vérifier la taille du fichier (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('Le fichier est trop volumineux. Taille maximum : 5 MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);

            // Suggérer un titre basé sur le nom du fichier
            if (!titreInput.value) {
                const filename = file.name.replace(/\.[^/.]+$/, ""); // Enlever l'extension
                const suggestedTitle = filename.replace(/[_-]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                titreInput.value = suggestedTitle;
            }
        } else {
            preview.style.display = 'none';
        }
    });

    // Auto-remplir le texte alternatif basé sur le titre
    titreInput.addEventListener('blur', function() {
        if (this.value && !altTextInput.value) {
            altTextInput.value = this.value;
        }
    });

    // Validation côté client
    document.querySelector('form').addEventListener('submit', function(e) {
        const titre = titreInput.value.trim();
        const image = imageInput.files[0];
        const statut = document.getElementById('statut').value;

        if (!titre) {
            alert('Le titre est obligatoire.');
            e.preventDefault();
            return;
        }

        if (!image) {
            alert('Veuillez sélectionner une image.');
            e.preventDefault();
            return;
        }

        if (!statut) {
            alert('Veuillez sélectionner un statut.');
            e.preventDefault();
            return;
        }
    });
});
</script>
@endpush
@endsection