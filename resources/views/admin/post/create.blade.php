@extends('layouts.admin')

@section('title', 'Créer un Post')
@section('page-title', 'Créer un nouveau post')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus"></i> Nouveau Post
                </h3>
            </div>

            <form action="{{ route('admin.posts.store') }}" method="POST">
                @csrf
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Auteur <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" 
                                        id="user_id" 
                                        name="user_id" 
                                        required>
                                    <option value="">Sélectionner un auteur...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="typepost_id" class="form-label">Type de post <span class="text-danger">*</span></label>
                                <select class="form-select @error('typepost_id') is-invalid @enderror" 
                                        id="typepost_id" 
                                        name="typepost_id" 
                                        required>
                                    <option value="">Sélectionner un type...</option>
                                    @foreach($typeposts as $typepost)
                                        <option value="{{ $typepost->id }}" 
                                                {{ old('typepost_id') == $typepost->id ? 'selected' : '' }}>
                                            {{ $typepost->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('typepost_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="date_post" class="form-label">Date de publication</label>
                        <input type="datetime-local" 
                               class="form-control @error('date_post') is-invalid @enderror" 
                               id="date_post" 
                               name="date_post" 
                               value="{{ old('date_post', now()->format('Y-m-d\TH:i')) }}">
                        <div class="form-text">
                            Laissez vide pour utiliser la date et heure actuelles
                        </div>
                        @error('date_post')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('contenu') is-invalid @enderror" 
                                  id="contenu" 
                                  name="contenu" 
                                  rows="8" 
                                  required
                                  placeholder="Écrivez le contenu de votre post...">{{ old('contenu') }}</textarea>
                        <div class="form-text">
                            Minimum 10 caractères
                        </div>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Aperçu en temps réel -->
                    <div class="mb-3">
                        <label class="form-label">Aperçu</label>
                        <div class="border rounded p-3 bg-light">
                            <div id="apercu-contenu" class="text-muted fst-italic">
                                L'aperçu apparaîtra ici...
                            </div>
                            <small class="text-muted">
                                <span id="compteur-caracteres">0</span> caractères
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Publier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contenuTextarea = document.getElementById('contenu');
    const apercuDiv = document.getElementById('apercu-contenu');
    const compteurSpan = document.getElementById('compteur-caracteres');

    function mettreAJourApercu() {
        const contenu = contenuTextarea.value;
        const nombreCaracteres = contenu.length;
        
        compteurSpan.textContent = nombreCaracteres;
        
        if (contenu.trim()) {
            apercuDiv.textContent = contenu;
            apercuDiv.classList.remove('text-muted', 'fst-italic');
        } else {
            apercuDiv.textContent = 'L\'aperçu apparaîtra ici...';
            apercuDiv.classList.add('text-muted', 'fst-italic');
        }
    }

    contenuTextarea.addEventListener('input', mettreAJourApercu);
    mettreAJourApercu(); // Initialisation
});
</script>
@endsection