{{-- resources/views/admin/countries/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Modifier ' . $country->name)
@section('page-title', 'Modifier le pays')

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.countries.show', $country) }}" class="btn btn-info">
            <i class="fas fa-eye me-2"></i>Voir
        </a>
        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Modifier "{{ $country->name }}"
                </h5>
                <small class="text-muted">
                    Créé le {{ $country->formatted_created_at }}
                </small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.countries.update', $country) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nom du pays <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $country->name) }}"
                               placeholder="Ex: Burundi"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Slug actuel: <code>{{ $country->slug }}</code> 
                            (sera mis à jour automatiquement si le nom change)
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Description optionnelle du pays...">{{ old('description', $country->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Maximum 1000 caractères
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Mettre à jour
                        </button>
                        <a href="{{ route('admin.countries.show', $country) }}" class="btn btn-info">
                            <i class="fas fa-eye me-2"></i>Voir
                        </a>
                        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informations
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">Date de création</small>
                        <div>{{ $country->formatted_created_at }}</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Dernière modification</small>
                        <div>{{ $country->formatted_updated_at }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionTextarea = document.getElementById('description');
    
    // Auto-focus sur le champ nom
    nameInput.focus();
    nameInput.setSelectionRange(nameInput.value.length, nameInput.value.length);
    
    // Compteur de caractères pour la description
    if (descriptionTextarea) {
        const maxLength = 1000;
        const counter = document.createElement('div');
        counter.className = 'form-text text-end mt-1';
        counter.innerHTML = `<span id="char-count">0</span>/${maxLength} caractères`;
        descriptionTextarea.parentNode.insertBefore(counter, descriptionTextarea.nextSibling);
        
        const charCount = document.getElementById('char-count');
        
        function updateCounter() {
            const currentLength = descriptionTextarea.value.length;
            charCount.textContent = currentLength;
            
            if (currentLength > maxLength * 0.9) {
                charCount.className = 'text-warning';
            } else if (currentLength >= maxLength) {
                charCount.className = 'text-danger';
            } else {
                charCount.className = '';
            }
        }
        
        descriptionTextarea.addEventListener('input', updateCounter);
        updateCounter(); // Initial call
    }

    // Détection des changements non sauvegardés
    let formChanged = false;
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            formChanged = true;
        });
    });
    
    // Avertir avant de quitter si des changements non sauvegardés
    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Ne plus avertir après soumission
    form.addEventListener('submit', () => {
        formChanged = false;
    });
});
</script>
@endsection