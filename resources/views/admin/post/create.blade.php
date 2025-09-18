@extends('layouts.admin')

@section('title', 'Créer un Article')
@section('page-title', 'Créer un Article')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Nouveau Contenu</h5>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Informations principales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-edit me-2"></i>Informations Principales
                                </h6>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                           id="titre" name="titre" value="{{ old('titre') }}" required
                                           placeholder="Saisissez un titre accrocheur...">
                                    @error('titre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="typepost_id" class="form-label">Type d'Article <span class="text-danger">*</span></label>
                                    <select class="form-select @error('typepost_id') is-invalid @enderror" 
                                            id="typepost_id" name="typepost_id" required>
                                        <option value="">Choisir...</option>
                                        @foreach($typePosts as $typePost)
                                            <option value="{{ $typePost->id }}" 
                                                    {{ old('typepost_id') == $typePost->id ? 'selected' : '' }}>
                                                {{ $typePost->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('typepost_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('contenu') is-invalid @enderror" 
                                              id="contenu" name="contenu" rows="8" required
                                              placeholder="Rédigez le contenu de votre article...">{{ old('contenu') }}</textarea>
                                    @error('contenu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Vous pouvez utiliser du texte enrichi et des liens.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Image de Couverture</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Formats acceptés : JPEG, PNG, GIF (max 2MB)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="date_post" class="form-label">Date de Publication</label>
                                    <input type="datetime-local" class="form-control @error('date_post') is-invalid @enderror" 
                                           id="date_post" name="date_post" value="{{ old('date_post', now()->format('Y-m-d\TH:i')) }}">
                                    @error('date_post')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations événement -->
                        <div class="row mb-4" id="evenementSection">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Informations Événement (optionnel)
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="lieu_evenement" class="form-label">Lieu de l'Événement</label>
                                    <input type="text" class="form-control @error('lieu_evenement') is-invalid @enderror" 
                                           id="lieu_evenement" name="lieu_evenement" value="{{ old('lieu_evenement') }}"
                                           placeholder="Ex: Stade Prince Louis Rwagasore">
                                    @error('lieu_evenement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="niveau_competition" class="form-label">Niveau de Compétition</label>
                                    <select class="form-select @error('niveau_competition') is-invalid @enderror" 
                                            id="niveau_competition" name="niveau_competition">
                                        <option value="">Non applicable</option>
                                        <option value="Local" {{ old('niveau_competition') === 'Local' ? 'selected' : '' }}>Local</option>
                                        <option value="Régional" {{ old('niveau_competition') === 'Régional' ? 'selected' : '' }}>Régional</option>
                                        <option value="National" {{ old('niveau_competition') === 'National' ? 'selected' : '' }}>National</option>
                                        <option value="International" {{ old('niveau_competition') === 'International' ? 'selected' : '' }}>International</option>
                                    </select>
                                    @error('niveau_competition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="date_evenement_debut" class="form-label">Date de Début</label>
                                    <input type="datetime-local" class="form-control @error('date_evenement_debut') is-invalid @enderror" 
                                           id="date_evenement_debut" name="date_evenement_debut" 
                                           value="{{ old('date_evenement_debut') }}">
                                    @error('date_evenement_debut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="date_evenement_fin" class="form-label">Date de Fin</label>
                                    <input type="datetime-local" class="form-control @error('date_evenement_fin') is-invalid @enderror" 
                                           id="date_evenement_fin" name="date_evenement_fin" 
                                           value="{{ old('date_evenement_fin') }}">
                                    @error('date_evenement_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="resultats" class="form-label">Résultats</label>
                                    <textarea class="form-control @error('resultats') is-invalid @enderror" 
                                              id="resultats" name="resultats" rows="4"
                                              placeholder="Détails des résultats si applicable...">{{ old('resultats') }}</textarea>
                                    @error('resultats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Options de publication -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-cog me-2"></i>Options de Publication
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publié</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                           {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <strong>Article mis en avant</strong>
                                        <br><small class="text-muted">Cet article apparaîtra en première position</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview if doesn't exist
                let preview = document.getElementById('imagePreview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'imagePreview';
                    preview.className = 'mt-2';
                    e.target.parentElement.appendChild(preview);
                }
                preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Auto-save as draft every 2 minutes
    let autoSaveTimer;
    function startAutoSave() {
        autoSaveTimer = setInterval(function() {
            const formData = new FormData(document.querySelector('form'));
            formData.set('status', 'draft');
            
            // Here you would send an AJAX request to save as draft
            console.log('Auto-saving draft...'); // Placeholder
        }, 120000); // 2 minutes
    }
    
    // Clear auto-save on form submit
    document.querySelector('form').addEventListener('submit', function() {
        if (autoSaveTimer) {
            clearInterval(autoSaveTimer);
        }
    });
    
    // startAutoSave(); // Uncomment when implementing actual auto-save
</script>
@endpush
