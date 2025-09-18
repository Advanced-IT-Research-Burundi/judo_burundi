@extends('layouts.admin')

@section('title', 'Créer un Type de Post')
@section('page-title', 'Créer un Type de Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Nouveau Type d'Article
                    </h5>
                    <a href="{{ route('admin.type-posts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.type-posts.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="nom" class="form-label">
                                Nom du Type <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom') }}" required
                                   placeholder="Ex: Actualité, Compétition, Formation...">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Choisissez un nom court et descriptif pour ce type d'article
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4"
                                      placeholder="Décrivez à quoi sert ce type d'article et quand l'utiliser...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Optionnel - Ajoutez une description pour aider les utilisateurs à comprendre l'usage de ce type
                            </div>
                        </div>

                        <!-- Exemples visuels -->
                        <div class="card bg-light mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-lightbulb text-warning me-2"></i>Exemples de Types Courants
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="example-type mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="example-icon me-2">
                                                    <i class="fas fa-newspaper"></i>
                                                </div>
                                                <strong>Actualité</strong>
                                            </div>
                                            <small class="text-muted">Pour les nouvelles générales de la fédération</small>
                                        </div>
                                        <div class="example-type mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="example-icon me-2">
                                                    <i class="fas fa-trophy"></i>
                                                </div>
                                                <strong>Compétition</strong>
                                            </div>
                                            <small class="text-muted">Annonces de tournois et championnats</small>
                                        </div>
                                        <div class="example-type mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="example-icon me-2">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                                <strong>Résultats</strong>
                                            </div>
                                            <small class="text-muted">Publication des résultats de compétitions</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="example-type mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="example-icon me-2">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </div>
                                                <strong>Formation</strong>
                                            </div>
                                            <small class="text-muted">Stages, séminaires et formations</small>
                                        </div>
                                        <div class="example-type mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="example-icon me-2">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                                <strong>Événement</strong>
                                            </div>
                                            <small class="text-muted">Événements spéciaux et cérémonies</small>
                                        </div>
                                        <div class="example-type mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="example-icon me-2">
                                                    <i class="fas fa-bullhorn"></i>
                                                </div>
                                                <strong>Annonce</strong>
                                            </div>
                                            <small class="text-muted">Communications officielles importantes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.type-posts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer le Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .example-icon {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #7CB342 0%, #689F3A 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }
    
    .example-type {
        padding: 0.5rem;
        border-radius: 8px;
        transition: background-color 0.3s;
    }
    
    .example-type:hover {
        background-color: rgba(124, 179, 66, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-suggest description based on name
    document.getElementById('nom').addEventListener('input', function() {
        const nom = this.value.trim();
        const descriptionField = document.getElementById('description');
        
        if (!descriptionField.value && nom) {
            const suggestions = {
                'Actualité': 'Articles d\'actualité générale de la fédération de judo',
                'Compétition': 'Annonces et informations sur les compétitions à venir',
                'Résultats': 'Publication des résultats de tournois et compétitions',
                'Formation': 'Stages, formations techniques et séminaires',
                'Événement': 'Événements spéciaux, cérémonies et manifestations',
                'Annonce': 'Annonces officielles et communications importantes'
            };
            
            if (suggestions[nom]) {
                descriptionField.value = suggestions[nom];
                descriptionField.style.backgroundColor = '#f8f9fa';
                setTimeout(() => {
                    descriptionField.style.backgroundColor = '';
                }, 1000);
            }
        }
    });
</script>
@endpush