@extends('layouts.admin')

@section('title', 'Modifier un Post')
@section('page-title', 'Modifier le post')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Modifier le post
                </h3>
                <div class="card-subtitle">
                    Publié le {{ $post->date_post_formattee }} par {{ $post->user->name ?? 'Utilisateur supprimé' }}
                </div>
            </div>

            <form action="{{ route('admin.posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT')
                
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
                                                {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
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
                                                {{ old('typepost_id', $post->typepost_id) == $typepost->id ? 'selected' : '' }}>
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
                        <label for="date_post" class="form-label">Date de publication <span class="text-danger">*</span></label>
                        <input type="datetime-local" 
                               class="form-control @error('date_post') is-invalid @enderror" 
                               id="date_post" 
                               name="date_post" 
                               value="{{ old('date_post', $post->date_post->format('Y-m-d\TH:i')) }}"
                               required>
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
                                  placeholder="Écrivez le contenu de votre post...">{{ old('contenu', $post->contenu) }}</textarea>
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
                            <div id="apercu-contenu">
                                {{ $post->contenu }}
                            </div>
                            <small class="text-muted">
                                <span id="compteur-caracteres">{{ strlen($post->contenu) }}</span> caractères
                            </small>
                        </div>
                    </div>

                    <!-- Informations système -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">Informations système</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Créé le :</strong> {{ $post->created_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Modifié le :</strong> {{ $post->updated_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Modifier
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