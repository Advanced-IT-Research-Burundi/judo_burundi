@extends('layouts.admin')

@section('title', 'Modifier le Type de Post')
@section('page-title', 'Modifier le Type de Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>Modifier : {{ $typePost->nom }}
                    </h5>
                    <div>
                        <a href="{{ route('admin.type-posts.show', $typePost) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-2"></i>Voir les détails
                        </a>
                        <a href="{{ route('admin.type-posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informations actuelles -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Articles utilisant ce type :</strong> 
                                <span class="badge bg-primary">{{ $typePost->posts_count }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Créé le :</strong> {{ $typePost->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                        @if($typePost->posts_count > 0)
                            <hr class="my-2">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Attention : La modification affectera tous les articles existants de ce type.
                            </small>
                        @endif
                    </div>

                    <form action="{{ route('admin.type-posts.update', $typePost) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-4">
                            <label for="nom" class="form-label">
                                Nom du Type <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $typePost->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($typePost->posts_count > 0)
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $typePost->posts_count }} article(s) utilisent actuellement ce nom
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $typePost->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Décrivez l'usage recommandé pour ce type d'article
                            </div>
                        </div>

                        <!-- Aperçu des changements -->
                        <div class="card bg-light mb-4" id="previewChanges" style="display: none;">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-eye me-2"></i>Aperçu des modifications
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Avant :</strong>
                                        <div class="p-2 bg-white rounded border">
                                            <strong>{{ $typePost->nom }}</strong><br>
                                            <small class="text-muted">{{ $typePost->description ?: 'Aucune description' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Après :</strong>
                                        <div class="p-2 bg-white rounded border">
                                            <strong id="previewNom">{{ $typePost->nom }}</strong><br>
                                            <small class="text-muted" id="previewDescription">{{ $typePost->description ?: 'Aucune description' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Articles liés -->
                        @if($typePost->posts_count > 0)
                            <div class="card border-warning mb-4">
                                <div class="card-header bg-warning bg-opacity-10">
                                    <h6 class="mb-0">
                                        <i class="fas fa-link me-2"></i>Articles utilisant ce type ({{ $typePost->posts_count }})
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">Derniers articles publiés avec ce type :</p>
                                    <div class="list-group list-group-flush">
                                        @foreach($typePost->posts()->latest()->limit(5)->get() as $post)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $post->titre }}</strong><br>
                                                    <small class="text-muted">{{ $post->date_post->format('d/m/Y') }}</small>
                                                </div>
                                                <a href="{{ route('admin.posts.show', $post) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    Voir
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($typePost->posts_count > 5)
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                ... et {{ $typePost->posts_count - 5 }} autre(s) article(s)
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.type-posts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
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
    // Aperçu en temps réel des modifications
    function updatePreview() {
        const nom = document.getElementById('nom').value;
        const description = document.getElementById('description').value;
        
        document.getElementById('previewNom').textContent = nom || '{{ $typePost->nom }}';
        document.getElementById('previewDescription').textContent = description || 'Aucune description';
        
        // Afficher l'aperçu si des changements sont détectés
        const hasChanges = nom !== '{{ $typePost->nom }}' || description !== '{{ $typePost->description ?? '' }}';
        document.getElementById('previewChanges').style.display = hasChanges ? 'block' : 'none';
    }

    document.getElementById('nom').addEventListener('input', updatePreview);
    document.getElementById('description').addEventListener('input', updatePreview);

    // Confirmation avant modification si beaucoup d'articles
    @if($typePost->posts_count > 10)
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm('Ce type est utilisé par {{ $typePost->posts_count }} articles. Êtes-vous sûr de vouloir le modifier ?')) {
            e.preventDefault();
        }
    });
    @endif
</script>
@endpush