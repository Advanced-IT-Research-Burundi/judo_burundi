@extends('layouts.admin')

@section('title', 'Ajouter un Joueur')
@section('page-title', 'Ajouter un Joueur')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informations du Nouveau Joueur</h5>
                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
                <div class="card-body">
                    <!-- Messages d'erreur généraux -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Erreurs de validation :</strong>
                            <ul class="mt-2 mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.joueurs.store') }}">
                        @csrf
                        
                        <!-- Informations personnelles -->
                        <div class="mb-4 row">
                            <div class="col-12">
                                <h6 class="pb-2 mb-3 text-primary border-bottom">
                                    <i class="fas fa-user me-2"></i>Informations Personnelles
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="nom" class="form-label">
                                        Nom <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" 
                                           name="nom" 
                                           value="{{ old('nom') }}" 
                                           required
                                           placeholder="Entrez le nom">
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="prenom" class="form-label">
                                        Prénom <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" 
                                           name="prenom" 
                                           value="{{ old('prenom') }}" 
                                           required
                                           placeholder="Entrez le prénom">
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="date_naissance" class="form-label">Date de Naissance</label>
                                    <input type="date" 
                                           class="form-control @error('date_naissance') is-invalid @enderror" 
                                           id="date_naissance" 
                                           name="date_naissance" 
                                           value="{{ old('date_naissance') }}"
                                           max="{{ date('Y-m-d') }}">
                                    <div class="form-text">Laissez vide si inconnue</div>
                                    @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="sexe" class="form-label">Sexe</label>
                                    <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe">
                                        <option value="">Choisir...</option>
                                        <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label for="lieu_naissance" class="form-label">Lieu de Naissance</label>
                                    <input type="text" 
                                           class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                           id="lieu_naissance" 
                                           name="lieu_naissance" 
                                           value="{{ old('lieu_naissance') }}"
                                           placeholder="Ex: Bujumbura, Burundi">
                                    @error('lieu_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="mb-4 row">
                            <div class="col-12">
                                <h6 class="pb-2 mb-3 text-primary border-bottom">
                                    <i class="fas fa-phone me-2"></i>Informations de Contact
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" 
                                           class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" 
                                           name="telephone" 
                                           value="{{ old('telephone') }}"
                                           placeholder="Ex: +257 79 000 000">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="exemple@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations sportives -->
                        <div class="mb-4 row">
                            <div class="col-12">
                                <h6 class="pb-2 mb-3 text-primary border-bottom">
                                    <i class="fas fa-medal me-2"></i>Informations Sportives
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="colline_id" class="form-label">
                                        Colline/Quartier <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('colline_id') is-invalid @enderror" 
                                            id="colline_id" 
                                            name="colline_id" 
                                            required>
                                        <option value="">Choisir une colline...</option>
                                        @foreach($collines as $colline)
                                            <option value="{{ $colline->id }}" 
                                                    {{ old('colline_id') == $colline->id ? 'selected' : '' }}>
                                                {{ $colline->nom }}
                                                @if($colline->zone)
                                                    ({{ $colline->zone->nom }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('colline_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="categorie_id" class="form-label">
                                        Catégorie <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                            id="categorie_id" 
                                            name="categorie_id" 
                                            required>
                                        <option value="">Choisir une catégorie...</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}" 
                                                    {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                                @if($categorie->description)
                                                    - {{ $categorie->description }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categorie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations complémentaires (optionnel) -->
                        <div class="mb-4 row">
                            <div class="col-12">
                                <h6 class="pb-2 mb-3 text-primary border-bottom">
                                    <i class="fas fa-info-circle me-2"></i>Informations Complémentaires (Optionnel)
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="poids" class="form-label">Poids (kg)</label>
                                    <input type="number" 
                                           class="form-control @error('poids') is-invalid @enderror" 
                                           id="poids" 
                                           name="poids" 
                                           value="{{ old('poids') }}"
                                           min="1"
                                           step="0.1"
                                           placeholder="Ex: 65.5">
                                    @error('poids')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="taille" class="form-label">Taille (cm)</label>
                                    <input type="number" 
                                           class="form-control @error('taille') is-invalid @enderror" 
                                           id="taille" 
                                           name="taille" 
                                           value="{{ old('taille') }}"
                                           min="1"
                                           max="250"
                                           placeholder="Ex: 175">
                                    @error('taille')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="3"
                                              placeholder="Ajoutez des notes ou remarques particulières...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Les champs marqués d'un * sont obligatoires
                                </small>
                            </div>
                            <div class="gap-2 d-flex">
                                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fas fa-undo me-2"></i>Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Enregistrer le joueur
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Aide contextuelle -->
    <div class="mt-4 row">
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>Conseils
                    </h6>
                    <ul class="mb-0 small">
                        <li>Vérifiez l'orthographe des noms et prénoms</li>
                        <li>La date de naissance aide à calculer automatiquement l'âge</li>
                        <li>Choisissez la catégorie selon l'âge du joueur</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-users me-2 text-info"></i>Actions rapides
                    </h6>
                    <div class="gap-2 d-grid">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-plus me-1"></i>Nouvelle catégorie
                        </a>
                        <a href="" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-plus me-1"></i>Nouvelle colline
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-question-circle me-2 text-success"></i>Besoin d'aide ?
                    </h6>
                    <p class="mb-2 small">Contactez l'administrateur si vous rencontrez des difficultés.</p>
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#helpModal">
                        <i class="fas fa-envelope me-1"></i>Contacter le support
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'aide -->
    <div class="modal fade" id="helpModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contacter le Support</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.border-bottom {
    border-color: #dee2e6 !important;
}

.text-danger {
    font-weight: 500;
}

.form-control:focus, .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

.card.bg-light {
    border: 1px solid #e3e6f0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calcul de l'âge basé sur la date de naissance
    const dateNaissance = document.getElementById('date_naissance');
    if (dateNaissance) {
        dateNaissance.addEventListener('change', function() {
            if (this.value) {
                const birthDate = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                
                // Afficher l'âge calculé (optionnel)
                console.log('Âge calculé:', age + ' ans');
            }
        });
    }

    // Validation en temps réel du formulaire
    const form = document.querySelector('form');
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    // Formatage automatique du numéro de téléphone
    const telephone = document.getElementById('telephone');
    if (telephone) {
        telephone.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('257')) {
                value = '+' + value;
            } else if (value.startsWith('79') || value.startsWith('68') || value.startsWith('75')) {
                value = '+257 ' + value;
            }
            this.value = value;
        });
    }
});
</script>
@endpush