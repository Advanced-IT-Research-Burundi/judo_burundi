@extends('layouts.user')

@section('title', 'Toutes les Actualités')

@section('content')
    <!-- Header -->
    <div class="bg-primary text-white py-5">
        <div class="container">
            <h1 class="display-4 mb-3">Actualités</h1>
            <p class="lead">Découvrez toutes les actualités de la Fédération de Judo du Burundi</p>
        </div>
    </div>

    <div class="container py-5">
        <!-- Filtres et recherche -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Rechercher dans les actualités...">
                    </div>
                    <div class="col-md-4">
                        <select name="type" class="form-select">
                            <option value="">Tous les types</option>
                            @foreach($typePosts as $typePost)
                                <option value="{{ $typePost->nom }}" {{ request('type') === $typePost->nom ? 'selected' : '' }}>
                                    {{ $typePost->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actualités -->
        <div class="news-grid">
            @foreach($actualites as $actualite)
                <div class="news-card">
                    <div class="news-image">
                        @if($actualite->image)
                            <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}"
                                style="height: 100%; width: 100%; object-fit: cover;">
                        @else
                            <img src="/images/judo{{ rand(3,6) }}.jpg" alt="{{ $actualite->titre }}"
                                style="height: 100%; width: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">{{ $actualite->date_post->format('d M Y') }}</span>
                            <span class="news-category">{{ $actualite->typePost->nom }}</span>
                        </div>
                        <h3 class="news-title">{{ $actualite->titre }}</h3>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($actualite->contenu), 150) }}</p>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <span>{{ $actualite->user->name ?? 'Fédération de Judo' }}</span>
                        </div>
                        <a href="{{ route('actualites.show', $actualite) }}" class="read-more">Lire l'article</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($actualites->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $actualites->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

<script>
// JavaScript pour la page d'accueil - Fonction readMoreActualite améliorée
function readMoreActualite(id, titre, contenu, date, auteur, type) {
    // Créer une modal pour afficher l'article complet
    const modalHTML = `
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; display: flex; align-items: center; justify-content: center;" onclick="this.remove()">
            <div class="modal-article" style="background: white; max-width: 800px; max-height: 90vh; overflow-y: auto; border-radius: 15px; margin: 20px;" onclick="event.stopPropagation()">
                <div class="modal-header" style="padding: 2rem; border-bottom: 1px solid #eee; position: relative;">
                    <button onclick="document.querySelector('.modal-overlay').remove()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
                    <div class="article-meta" style="margin-bottom: 1rem;">
                        <span style="background: #7CB342; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">${date}</span>
                        <span style="color: #7CB342; font-weight: 500; margin-left: 1rem;">${type}</span>
                    </div>
                    <h2 style="color: #1a365d; margin-bottom: 0.5rem;">${titre}</h2>
                    <div style="color: #666;">
                        <i class="fas fa-user"></i> Par ${auteur}
                    </div>
                </div>
                <div class="modal-body" style="padding: 2rem; line-height: 1.8;">
                    ${contenu.split('\\n').map(p => `<p style="margin-bottom: 1rem;">${p}</p>`).join('')}
                </div>
                <div class="modal-footer" style="padding: 1rem 2rem; text-align: center; border-top: 1px solid #eee;">
                    <a href="/actualites" style="color: #7CB342; text-decoration: none;">Voir toutes les actualités →</a>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

// Améliorer le formulaire d'inscription
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Désactiver le bouton et afficher loading
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inscription en cours...';
    
    // Envoyer les données
    fetch('/inscription', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Inscription réussie ! Nous vous contacterons bientôt.');
            this.reset();
        } else {
            alert(data.message || 'Erreur lors de l\'inscription.');
        }
    })
    .catch(error => {
        alert('Erreur lors de l\'inscription. Veuillez réessayer.');
    })
    .finally(() => {
        // Réactiver le bouton
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
});
</script>