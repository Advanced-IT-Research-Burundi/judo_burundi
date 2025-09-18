@extends('layouts.admin')

@section('title', 'Modifier le Joueur')
@section('page-title', 'Modifier le Joueur')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Modifier : {{ $joueur->nom_complet }}</h5>
                        <small class="text-muted">Joueur #{{ $joueur->id }} • Inscrit le {{ $joueur->created_at->format('d/m/Y') }}</small>
                    </div>
                    <div>
                        <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-2"></i>Voir
                        </a>
                        <a href="{{ route('admin.joueurs.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Messages de session -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Messages d'erreur généraux -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Erreurs de validation :</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.joueurs.update', $joueur) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informations personnelles -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-user me-2"></i>Informations Personnelles
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nom" class="form-label">
                                        Nom <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" 
                                           name="nom" 
                                           value="{{ old('nom', $joueur->nom) }}" 
                                           required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="prenom" class="form-label">
                                        Prénom <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" 
                                           name="prenom" 
                                           value="{{ old('prenom', $joueur->prenom) }}" 
                                           required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="date_naissance" class="form-label">Date de Naissance</label>
                                    <input type="date" 
                                           class="form-control @error('date_naissance') is-invalid @enderror" 
                                           id="date_naissance" 
                                           name="date_naissance" 
                                           value="{{ old('date_naissance', $joueur->date_naissance?->format('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}">
                                    @if($joueur->age)
                                        <div class="form-text">Âge actuel : {{ $joueur->age }} ans</div>
                                    @endif
                                    @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="sexe" class="form-label">Sexe</label>
                                    <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe">
                                        <option value="">Choisir...</option>
                                        <option value="M" {{ old('sexe', $joueur->sexe) === 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe', $joueur->sexe) === 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="lieu_naissance" class="form-label">Lieu de Naissance</label>
                                    <input type="text" 
                                           class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                           id="lieu_naissance" 
                                           name="lieu_naissance" 
                                           value="{{ old('lieu_naissance', $joueur->lieu_naissance) }}"
                                           placeholder="Ex: Bujumbura, Burundi">
                                    @error('lieu_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-phone me-2"></i>Informations de Contact
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" 
                                           class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" 
                                           name="telephone" 
                                           value="{{ old('telephone', $joueur->telephone) }}"
                                           placeholder="Ex: +257 79 000 000">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $joueur->email) }}"
                                           placeholder="exemple@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations sportives -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-medal me-2"></i>Informations Sportives
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
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
                                                    {{ old('colline_id', $joueur->colline_id) == $colline->id ? 'selected' : '' }}>
                                                {{ $colline->nom }}
                                                @if($colline->zone)
                                                    ({{ $colline->zone->nom }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($joueur->colline)
                                        <div class="form-text">Colline actuelle : {{ $joueur->colline->nom }}</div>
                                    @endif
                                    @error('colline_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
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
                                                    {{ old('categorie_id', $joueur->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                                @if($categorie->description)
                                                    - {{ $categorie->description }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($joueur->categorie)
                                        <div class="form-text">Catégorie actuelle : {{ $joueur->categorie->nom }}</div>
                                    @endif
                                    @error('categorie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations complémentaires -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Informations Complémentaires
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="poids" class="form-label">Poids (kg)</label>
                                    <input type="number" 
                                           class="form-control @error('poids') is-invalid @enderror" 
                                           id="poids" 
                                           name="poids" 
                                           value="{{ old('poids', $joueur->poids) }}"
                                           min="1"
                                           step="0.1"
                                           placeholder="Ex: 65.5">
                                    @error('poids')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="taille" class="form-label">Taille (cm)</label>
                                    <input type="number" 
                                           class="form-control @error('taille') is-invalid @enderror" 
                                           id="taille" 
                                           name="taille" 
                                           value="{{ old('taille', $joueur->taille) }}"
                                           min="1"
                                           max="250"
                                           placeholder="Ex: 175">
                                    @error('taille')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="3"
                                              placeholder="Ajoutez des notes ou remarques particulières...">{{ old('notes', $joueur->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Historique des modifications -->
                        @if($joueur->updated_at != $joueur->created_at)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-history me-2"></i>
                                        <strong>Dernière modification :</strong> 
                                        {{ $joueur->updated_at->format('d/m/Y à H:i') }} 
                                        ({{ $joueur->updated_at->diffForHumans() }})
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Les champs marqués d'un * sont obligatoires
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="button" class="btn btn-outline-warning" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>Restaurer
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions supplémentaires -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-eye fa-2x text-info mb-3"></i>
                    <h6>Voir le profil complet</h6>
                    <p class="text-muted small">Consultez toutes les informations du joueur</p>
                    <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-outline-info btn-sm">
                        Voir le profil
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-copy fa-2x text-success mb-3"></i>
                    <h6>Dupliquer ce joueur</h6>
                    <p class="text-muted small">Créer un nouveau joueur avec les mêmes informations</p>
                    <form method="POST" action="{{ route('admin.joueurs.duplicate', $joueur) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-success btn-sm" 
                                onclick="return confirm('Créer une copie de ce joueur ?')">
                            Dupliquer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-trash fa-2x text-danger mb-3"></i>
                    <h6>Zone de danger</h6>
                    <p class="text-muted small">Suppression définitive du joueur</p>
                    <form method="POST" action="{{ route('admin.joueurs.destroy', $joueur) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                onclick="return confirm('ATTENTION : Cette action supprimera définitivement {{ $joueur->nom_complet }} et toutes ses données. Cette action est irréversible. Êtes-vous absolument certain ?')">
                            Supprimer
                        </button>
                    </form>
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

.card.border-danger {
    border-color: #dc3545 !important;
}

.alert {
    border-radius: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
// Sauvegarder les valeurs originales
const originalValues = {
    nom: '{{ $joueur->nom }}',
    prenom: '{{ $joueur->prenom }}',
    date_naissance: '{{ $joueur->date_naissance?->format("Y-m-d") ?? "" }}',
    sexe: '{{ $joueur->sexe ?? "" }}',
    lieu_naissance: '{{ $joueur->lieu_naissance ?? "" }}',
    telephone: '{{ $joueur->telephone ?? "" }}',
    email: '{{ $joueur->email ?? "" }}',
    colline_id: '{{ $joueur->colline_id }}',
    categorie_id: '{{ $joueur->categorie_id }}',
    poids: '{{ $joueur->poids ?? "" }}',
    taille: '{{ $joueur->taille ?? "" }}',
    notes: '{{ $joueur->notes ?? "" }}'
};

function resetForm() {
    if (confirm('Restaurer toutes les valeurs d\'origine ? Toutes les modifications seront perdues.')) {
        Object.keys(originalValues).forEach(key => {
            const field = document.getElementById(key);
            if (field) {
                field.value = originalValues[key];
                field.classList.remove('is-invalid', 'is-valid');
            }
        });
    }
}

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
                
                console.log('Âge calculé:', age + ' ans');
            }
        });
    }

    // Validation en temps réel
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

    // Détecter les modifications non sauvegardées
    let isModified = false;
    const formElements = form.querySelectorAll('input, select, textarea');
    
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            isModified = true;
        });
    });

    // Avertir avant de quitter si des modifications non sauvegardées
    window.addEventListener('beforeunload', function(e) {
        if (isModified) {
            e.preventDefault();
            e.returnValue = 'Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter ?';
        }
    });

    // Désactiver l'avertissement lors de la soumission
    form.addEventListener('submit', function() {
        isModified = false;
    });
});
</script>
@endpush