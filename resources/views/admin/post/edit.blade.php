@extends('layouts.admin')

@section('title', 'Modifier le Post')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier le Post</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info">
                <i class="fas fa-eye"></i> Aperçu
            </a>
            {{-- <a href="{{ route('admin.posts.duplicate', $post) }}" class="btn btn-outline-secondary">
                <i class="fas fa-copy"></i> Dupliquer
            </a> --}}
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulaire -->
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Informations principales -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informations principales</h5>
                    </div>
                    <div class="card-body">
                        <!-- Titre -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre *</label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre', $post->titre) }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contenu -->
                        <div class="mb-3">
                            <label for="contenu" class="form-label">Contenu *</label>
                            <textarea class="form-control @error('contenu') is-invalid @enderror" 
                                      id="contenu" name="contenu" rows="12" required>{{ old('contenu', $post->contenu) }}</textarea>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Vous pouvez utiliser du texte enrichi. Les sauts de ligne seront préservés.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations d'événement -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informations d'événement</h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="isEvent" 
                                   {{ $post->isEvent() ? 'checked' : '' }}>
                            <label class="form-check-label" for="isEvent">C'est un événement</label>
                        </div>
                    </div>
                    <div class="card-body" id="eventFields" 
                         style="{{ $post->isEvent() ? '' : 'display: none;' }}">
                        <div class="row">
                            <!-- Lieu -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lieu_evenement" class="form-label">Lieu de l'événement</label>
                                    <input type="text" class="form-control @error('lieu_evenement') is-invalid @enderror" 
                                           id="lieu_evenement" name="lieu_evenement" 
                                           value="{{ old('lieu_evenement', $post->lieu_evenement) }}">
                                    @error('lieu_evenement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Niveau de compétition -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="niveau_competition" class="form-label">Niveau de compétition</label>
                                    <select class="form-select @error('niveau_competition') is-invalid @enderror" 
                                            id="niveau_competition" name="niveau_competition">
                                        <option value="">Sélectionner un niveau</option>
                                        <option value="Local" 
                                                {{ old('niveau_competition', $post->niveau_competition) == 'Local' ? 'selected' : '' }}>
                                            Local
                                        </option>
                                        <option value="National" 
                                                {{ old('niveau_competition', $post->niveau_competition) == 'National' ? 'selected' : '' }}>
                                            National
                                        </option>
                                        <option value="International" 
                                                {{ old('niveau_competition', $post->niveau_competition) == 'International' ? 'selected' : '' }}>
                                            International
                                        </option>
                                    </select>
                                    @error('niveau_competition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date début -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_evenement_debut" class="form-label">Date et heure de début</label>
                                    <input type="datetime-local" class="form-control @error('date_evenement_debut') is-invalid @enderror" 
                                           id="date_evenement_debut" name="date_evenement_debut" 
                                           value="{{ old('date_evenement_debut', $post->date_evenement_debut?->format('Y-m-d\TH:i')) }}">
                                    @error('date_evenement_debut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date fin -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_evenement_fin" class="form-label">Date et heure de fin</label>
                                    <input type="datetime-local" class="form-control @error('date_evenement_fin') is-invalid @enderror" 
                                           id="date_evenement_fin" name="date_evenement_fin" 
                                           value="{{ old('date_evenement_fin', $post->date_evenement_fin?->format('Y-m-d\TH:i')) }}">
                                    @error('date_evenement_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Résultats -->
                        <div class="mb-3">
                            <label for="resultats" class="form-label">Résultats</label>
                            <textarea class="form-control @error('resultats') is-invalid @enderror" 
                                      id="resultats" name="resultats" rows="4" 
                                      placeholder="Résultats de la compétition (optionnel)">{{ old('resultats', $post->resultats) }}</textarea>
                            @error('resultats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <button type="submit" name="action" value="draft" class="btn btn-outline-secondary">
                                <i class="fas fa-file-alt"></i> Enregistrer comme brouillon
                            </button>
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye"></i> Voir l'aperçu
                            </a>
                            <hr>
                            <button type="button" class="btn btn-outline-danger" 
                                    onclick="deletePost({{ $post->id }})">
                                <i class="fas fa-trash"></i> Supprimer le post
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Métadonnées -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Métadonnées</h5>
                    </div>
                    <div class="card-body">
                        <!-- Type de post -->
                        <div class="mb-3">
                            <label for="typepost_id" class="form-label">Type de post *</label>
                            <select class="form-select @error('typepost_id') is-invalid @enderror" 
                                    id="typepost_id" name="typepost_id" required>
                                <option value="">Sélectionner un type</option>
                                @foreach($typesPosts as $type)
                                    <option value="{{ $type->id }}" 
                                            {{ old('typepost_id', $post->typepost_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('typepost_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date de publication -->
                        <div class="mb-3">
                            <label for="date_post" class="form-label">Date de publication *</label>
                            <input type="datetime-local" class="form-control @error('date_post') is-invalid @enderror" 
                                   id="date_post" name="date_post" 
                                   value="{{ old('date_post', $post->date_post->format('Y-m-d\TH:i')) }}" required>
                            @error('date_post')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informations du post -->
                        <div class="small text-muted">
                            <div class="mb-1">
                                <strong>Créé par:</strong> {{ $post->user->name }}
                            </div>
                            <div class="mb-1">
                                <strong>Créé le:</strong> {{ $post->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}
                            </div>
                            @if($post->updated_at != $post->created_at)
                                <div>
                                    <strong>Modifié le:</strong> {{ $post->updated_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Image</h5>
                    </div>
                    <div class="card-body">
                        @if($post->image)
                            <!-- Image actuelle -->
                            <div class="mb-3" id="currentImage">
                                <label class="form-label">Image actuelle</label>
                                <div class="position-relative">
                                    <img src="{{ $post->image_url }}" alt="Image actuelle" 
                                         class="img-fluid rounded mb-2" style="max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="removeCurrentImage()">
                                        <i class="fas fa-times"></i> Supprimer l'image
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="image" class="form-label">
                                {{ $post->image ? 'Changer l\'image' : 'Ajouter une image' }}
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Formats acceptés : JPEG, PNG, GIF. Taille max : 5MB
                            </div>
                        </div>

                        <!-- Prévisualisation nouvelle image -->
                        <div id="imagePreview" class="d-none">
                            <img id="previewImg" src="" alt="Prévisualisation" 
                                 class="img-fluid rounded mb-2" style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    onclick="removePreview()">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
// Gestion de l'affichage des champs événement
document.getElementById('isEvent').addEventListener('change', function() {
    const eventFields = document.getElementById('eventFields');
    if (this.checked) {
        eventFields.style.display = 'block';
    } else {
        eventFields.style.display = 'none';
        // Ne pas réinitialiser les champs lors de l'édition
    }
});

// Prévisualisation de l'image
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

function removePreview() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').classList.add('d-none');
}

// Supprimer l'image actuelle
function removeCurrentImage() {
    if (confirm('Êtes-vous sûr de vouloir supprimer l\'image actuelle ?')) {
        fetch(`/admin/posts/{{ $post->id }}/remove-image`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('currentImage').remove();
                alert('Image supprimée avec succès');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression de l\'image');
        });
    }
}

// Fonction de suppression du post
function deletePost(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/posts/${id}`;
    modal.show();
}

// Validation des dates d'événement
document.getElementById('date_evenement_debut').addEventListener('change', function() {
    const finField = document.getElementById('date_evenement_fin');
    finField.min = this.value;
    
    if (finField.value && finField.value < this.value) {
        finField.value = this.value;
    }
});

// Auto-resize du textarea
document.getElementById('contenu').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

// Confirmation avant de quitter si le formulaire est modifié
let formChanged = false;
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('change', () => formChanged = true);
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter ?';
    }
});

// Désactiver l'alerte lors de la soumission
document.querySelector('form').addEventListener('submit', function() {
    formChanged = false;
});
</script>
@endpush
@endsection