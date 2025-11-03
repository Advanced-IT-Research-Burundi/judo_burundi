@extends('layouts.user')

@section('content')
<!-- Page Hero Section - Actualités -->
<section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo3.jpg') }}');">
    <div class="page-hero-content">
        <h1>Actualités</h1>
        <p>Restez informés de toutes nos activités et événements</p>
        <div class="page-hero-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <span>Actualités</span>
        </div>
    </div>
</section>

<!-- Section Actualités -->
<section class="news-section" style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        
        <!-- Filtres par catégorie -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <button class="category-filter active" data-category="all"
                    style="background: #7CB342; color: white; border: none; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Toutes
            </button>
            <button class="category-filter" data-category="competition"
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Compétitions
            </button>
            <button class="category-filter" data-category="formation"
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Formations
            </button>
            <button class="category-filter" data-category="evenement"
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Événements
            </button>
            <button class="category-filter" data-category="resultats"
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Résultats
            </button>
        </div>

        <!-- Grille d'actualités -->
        <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
            @forelse($actualites as $actualite)
                <article class="news-card" style="background: white; border-radius: 15px; overflow: hidden; 
                                                  box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <!-- Image de l'actualité -->
                    <div style="height: 250px; overflow: hidden; position: relative;">
                        @if ($actualite->image && file_exists(public_path('storage/' . $actualite->image)))
                            <img src="{{ asset('storage/' . $actualite->image) }}" 
                                 alt="{{ $actualite->titre }}"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #7CB342, #689F3A); 
                                        display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-newspaper" style="font-size: 4rem; color: white; opacity: 0.7;"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Contenu -->
                    <div style="padding: 1.5rem;">
                        <!-- Date et auteur -->
                        <div style="display: flex; justify-content: space-between; align-items: center; 
                                    margin-bottom: 1rem; font-size: 0.9rem; color: #666;">
                            <span><i class="fas fa-calendar-alt"></i> {{ $actualite->date_post->format('d M Y') }}</span>
                            <span><i class="fas fa-user"></i> {{ $actualite->auteur ?? 'Admin' }}</span>
                        </div>

                        <!-- Titre -->
                        <h3 style="color: #1a365d; font-size: 1.4rem; font-weight: 600; margin-bottom: 1rem; 
                                   line-height: 1.4; min-height: 60px;">
                            {{ Str::limit($actualite->titre, 60) }}
                        </h3>

                        <!-- Extrait -->
                        <p style="color: #666; line-height: 1.6; margin-bottom: 1.5rem; min-height: 80px;">
                            {{ $actualite->extrait ?? Str::limit(strip_tags($actualite->contenu), 120) }}
                        </p>

                        <!-- Bouton Lire plus -->
                        <a href="{{ route('actualites', $actualite->id) }}" 
                           style="display: inline-flex; align-items: center; gap: 8px; color: #7CB342; 
                                  font-weight: 600; text-decoration: none; transition: all 0.3s;">
                            Lire plus <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <i class="fas fa-newspaper" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <h3 style="color: #666; margin-bottom: 0.5rem;">Aucune actualité disponible</h3>
                    <p style="color: #999;">Les nouvelles actualités seront bientôt publiées</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($actualites->hasPages())
            <div style="margin-top: 3rem; text-align: center;">
                {{ $actualites->links() }}
            </div>
        @endif
    </div>
</section>

<!-- Section Newsletter (optionnelle) -->
<section style="padding: 60px 0; background: linear-gradient(135deg, #7CB342, #689F3A); color: white;">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Restez Informé</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.95;">
            Inscrivez-vous à notre newsletter pour recevoir les dernières actualités
        </p>
        <form style="max-width: 600px; margin: 0 auto; display: flex; gap: 1rem;">
            <input type="email" placeholder="Votre adresse email" required
                   style="flex: 1; padding: 1rem; border: none; border-radius: 25px; font-size: 1rem;">
            <button type="submit" 
                    style="background: #1a365d; color: white; padding: 1rem 2rem; border: none; 
                           border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                <i class="fas fa-paper-plane"></i> S'inscrire
            </button>
        </form>
    </div>
</section>

<style>
    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .news-card img:hover {
        transform: scale(1.1);
    }
    .news-card a:hover {
        gap: 12px;
        color: #689F3A;
    }
    .category-filter:hover,
    .category-filter.active {
        background: #7CB342 !important;
        color: white !important;
    }
</style>

<script>
    // Filtrage des actualités par catégorie
    document.querySelectorAll('.category-filter').forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.category-filter').forEach(btn => {
                btn.classList.remove('active');
                btn.style.background = '#f8f9fa';
                btn.style.color = '#333';
            });
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            this.style.background = '#7CB342';
            this.style.color = 'white';
            
            // Logique de filtrage à implémenter selon vos besoins
            const category = this.dataset.category;
            console.log('Filtrer par:', category);
        });
    });
</script>
@endsection