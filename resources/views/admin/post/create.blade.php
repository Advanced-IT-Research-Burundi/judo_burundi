@extends('layouts.admin')

@section('title', 'Nouvelle Actualité')
@section('page-title', 'Créer une Actualité')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="fas fa-plus-circle me-2"></i>
        Nouvelle Actualité
    </h2>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Retour à la liste
    </a>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            {{-- Informations principales --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Contenu principal
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
                               placeholder="Titre de l'actualité">
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contenu" class="form-label">
                            Contenu <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('contenu') is-invalid @enderror" 
                                  id="contenu" 
                                  name="contenu" 
                                  rows="8" 
                                  required
                                  placeholder="Contenu détaillé de l'actualité...">{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="typepost_id" class="form-label">
                                    Type de post <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('typepost_id') is-invalid @enderror" 
                                        id="typepost_id" 
                                        name="typepost_id" 
                                        required onchange="toggleConditionalFields()">
                                    <option value="">Sélectionner un type</option>
                                    @if(isset($typePosts))
                                        @foreach($typePosts as $type)
                                            <option value="{{ $type->id }}" 
                                                    data-slug="{{ $type->slug ?? Str::slug($type->nom) }}"
                                                    {{ old('typepost_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->nom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('typepost_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_post" class="form-label">
                                    Date de publication <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('date_post') is-invalid @enderror" 
                                       id="date_post" 
                                       name="date_post" 
                                       value="{{ old('date_post', now()->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('date_post')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">
                            Image de l'actualité
                        </label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Formats acceptés : JPG, PNG, GIF. Taille max : 2 Mo
                        </div>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="preview" src="" alt="Aperçu" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Événement (conditionnelle) --}}
            <div class="card mt-4" id="eventSection" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Informations de l'événement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="lieu_evenement" class="form-label">
                            Lieu de l'événement
                        </label>
                        <input type="text" 
                               class="form-control @error('lieu_evenement') is-invalid @enderror" 
                               id="lieu_evenement" 
                               name="lieu_evenement" 
                               value="{{ old('lieu_evenement') }}"
                               placeholder="Lieu où se déroule l'événement">
                        @error('lieu_evenement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_evenement_debut" class="form-label">
                                    Date et heure de début
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('date_evenement_debut') is-invalid @enderror" 
                                       id="date_evenement_debut" 
                                       name="date_evenement_debut" 
                                       value="{{ old('date_evenement_debut') }}">
                                @error('date_evenement_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_evenement_fin" class="form-label">
                                    Date et heure de fin
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('date_evenement_fin') is-invalid @enderror" 
                                       id="date_evenement_fin" 
                                       name="date_evenement_fin" 
                                       value="{{ old('date_evenement_fin') }}">
                                @error('date_evenement_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Compétition (conditionnelle) --}}
            <div class="card mt-4" id="competitionSection" style="display: none;">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-trophy me-2"></i>
                        Informations de compétition
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="niveau_competition" class="form-label">
                            Niveau de compétition
                        </label>
                        <select class="form-select @error('niveau_competition') is-invalid @enderror" 
                                id="niveau_competition" 
                                name="niveau_competition">
                            <option value="">Sélectionner le niveau</option>
                            <option value="Local" {{ old('niveau_competition') == 'Local' ? 'selected' : '' }}>Local</option>
                            <option value="Régional" {{ old('niveau_competition') == 'Régional' ? 'selected' : '' }}>Régional</option>
                            <option value="National" {{ old('niveau_competition') == 'National' ? 'selected' : '' }}>National</option>
                            <option value="International" {{ old('niveau_competition') == 'International' ? 'selected' : '' }}>International</option>
                        </select>
                        @error('niveau_competition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="resultats" class="form-label">
                            Résultats
                        </label>
                        <textarea class="form-control @error('resultats') is-invalid @enderror" 
                                  id="resultats" 
                                  name="resultats" 
                                  rows="4"
                                  placeholder="Détails des résultats de la compétition...">{{ old('resultats') }}</textarea>
                        @error('resultats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Publier l'actualité
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
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
                        Informations de publication
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-3">
                            <strong>Auteur :</strong><br>
                            {{ auth()->user()->name }}
                        </div>
                        <div class="mb-3">
                            <strong>Statut :</strong><br>
                            <span class="badge bg-success">Publié</span>
                        </div>
                        <div class="mb-3">
                            <strong>Visibilité :</strong><br>
                            <span class="badge bg-info">Public</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Conseils de rédaction
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Titre accrocheur :</strong> Utilisez un titre clair et informatif.
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Image attractive :</strong> Une bonne image améliore l'engagement.
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <strong>Contenu structuré :</strong> Organisez votre contenu avec des paragraphes.
                        </div>
                        <div class="mb-0">
                            <i class="fas fa-info-circle text-info me-1"></i>
                            <strong>Type adapté :</strong> Choisissez le bon type pour afficher les champs appropriés.
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
                        @if(Route::has('admin.type-posts.create'))
                            <a href="{{ route('admin.type-posts.create') }}" 
                               class="btn btn-sm btn-outline-success" 
                               target="_blank">
                                <i class="fas fa-plus me-1"></i>
                                Nouveau type de post
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// Affichage conditionnel des sections selon le type de post
function toggleConditionalFields() {
    const typeSelect = document.getElementById('typepost_id');
    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
    const typeSlug = selectedOption.dataset.slug || '';
    
    const eventSection = document.getElementById('eventSection');
    const competitionSection = document.getElementById('competitionSection');
    
    // Masquer toutes les sections par défaut
    eventSection.style.display = 'none';
    competitionSection.style.display = 'none';
    
    // Afficher les sections selon le type
    if (typeSlug.includes('evenement') || typeSlug.includes('event')) {
        eventSection.style.display = 'block';
    }
    
    if (typeSlug.includes('competition') || typeSlug.includes('match') || typeSlug.includes('tournoi')) {
        competitionSection.style.display = 'block';
        eventSection.style.display = 'block'; // Une compétition est aussi un événement
    }
}

// Aperçu de l'image
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Appeler la fonction au chargement si une valeur est déjà sélectionnée
document.addEventListener('DOMContentLoaded', function() {
    toggleConditionalFields();
});
</script>
@endpush
@endsection