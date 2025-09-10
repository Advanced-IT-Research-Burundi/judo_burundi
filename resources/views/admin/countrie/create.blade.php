{{-- resources/views/admin/countries/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Nouveau Pays')
@section('page-title', 'Nouveau Pays')

@section('page-actions')
    <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>Ajouter un nouveau pays
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.countries.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nom du pays <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Ex: Burundi"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Le slug sera généré automatiquement à partir du nom
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Description optionnelle du pays...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Maximum 1000 caractères
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                    </div>
                </form>
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
});
</script>
@endsection