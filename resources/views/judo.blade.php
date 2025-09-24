@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/actualites.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>ENTRAÎNEZ-VOUS AVEC LES MEILLEURS</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <a href="{{ route('contact.store') }}" class="btn-secondary" style="text-decoration:none">En savoir Plus</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-fist-raised"></i>
                    <h3>Techniques Expertes</h3>
                    <p>Apprenez les techniques authentiques avec nos maîtres expérimentés</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h3>Communauté</h3>
                    <p>Rejoignez une communauté passionnée et bienveillante</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-trophy"></i>
                    <h3>Compétitions</h3>
                    <p>Participez à des compétitions locales et nationales</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome" id="about">
        <div class="container">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h2>Bienvenue dans notre Académie</h2>
                    <p>Notre académie d'arts martiaux offre un enseignement de qualité supérieure dans un environnement
                        respectueux et discipliné. Nous accueillons tous les niveaux, des débutants aux avancés.</p>
                    <p>Avec plus de 20 ans d'expérience, nos instructeurs vous guideront dans votre parcours, que ce
                        soit pour la self-défense, la compétition ou le développement personnel.</p>
                    <button class="btn-primary" onclick="openModal()">Rejoignez-nous</button>
                </div>
                <div class="welcome-image">
                    <div
                        style="height: 400px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #666;">
                        <img src="/images/judo2.jpg" alt="Welcome Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-title">
                <h2>Galerie Photos</h2>
                <p>Découvrez notre académie en images</p>
            </div>
            <div class="gallery-grid">
                @forelse($galleryImages as $image)
                    <div class="gallery-item">
                        <div
                            style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                            @if ($image->images && file_exists(public_path('storage/' . $image->images)))
                                <img src="{{ asset('storage/' . $image->images) }}" alt="Image de la galerie"
                                    style="height: 100%; width: auto; border-radius: 10px;">
                            @else
                                <i class="fas fa-image" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Aucune image disponible pour le moment.</p>
                @endforelse
            </div>
        </div>
    </section>


    <!-- News Section AMÉLIORÉE -->
    <section class="news" id="news">
        <div class="container">
            <div class="news-header">
                <div class="section-title" style="text-align: left; margin-bottom: 0;">
                    <h2>Actualités</h2>
                    <p>Restez informés de toutes nos actualités</p>
                </div>
            </div>

            <!-- News Grid -->
            <div id="newsGrid" class="news-grid">
                @forelse($actualites as $actualite)
                    <div class="news-card">
                        <div class="news-image">
                            @if ($actualite->image && file_exists(public_path('storage/' . $actualite->image)))
                                <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}"
                                    style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                            @else
                                <!-- Image par défaut selon le type -->
                                @switch($actualite->typePost->nom ?? 'default')
                                    @case('Compétition')
                                        <img src="/images/judo3.jpg" alt="Compétition"
                                            style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                    @break

                                    @case('Événement')
                                        <img src="/images/judo4.jpg" alt="Événement"
                                            style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                    @break

                                    @case('Formation')
                                        <img src="/images/judo5.jpg" alt="Formation"
                                            style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                    @break

                                    @default
                                        <img src="/images/judo6.jpg" alt="Actualité"
                                            style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                @endswitch
                            @endif
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-date">{{ $actualite->date_post->format('d M Y') }}</span>
                                <span class="news-category">{{ $actualite->typePost->nom ?? 'Actualité' }}</span>
                            </div>
                            <h3 class="news-title">{{ Str::limit($actualite->titre, 60) }}</h3>
                            <p class="news-excerpt">
                                {{ $actualite->extrait ?? Str::limit(strip_tags($actualite->contenu), 120) }}</p>

                            <!-- BOUTON LIRE PLUS AMÉLIORÉ -->
                            <a href="{{ route('actualites', $actualite->id) }}" class="read-more" style="text-decoration: none">
                                <i class="fas fa-arrow-right"></i> Lire plus
                            </a>
                        </div>
                    </div>
                    @empty
                        <!-- Affichage si aucune actualité -->
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune actualité pour le moment</h5>
                            <p class="text-muted">Revenez bientôt pour découvrir nos dernières nouvelles !</p>
                        </div>
                    @endforelse
                </div>

                <!-- Voir plus d'actualités -->
                @if ($actualites->count() >= 6)
                    <div class="text-center mt-4">
                        <a href="{{ route('blog') }}" class="btn-primary" style="text-decoration: none">
                            <i class="fas fa-plus-circle"></i> Voir toutes les actualités
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Registration Section -->
        <section class="registration" id="registration">
            <div class="container">
                <div class="registration-container">
                    <div class="registration-info">
                        <h2>Rejoignez Notre Académie</h2>
                        <p>Inscrivez-vous dès aujourd'hui pour commencer votre parcours. Nos programmes sont adaptés à
                            tous les âges et tous les niveaux.</p>

                        <div style="margin: 2rem 0;">
                            <h3 style="color: #7CB342; margin-bottom: 1rem;">Avantages de l'inscription :</h3>
                            <ul style="color: #666; line-height: 2;">
                                <li>Accès illimité aux cours</li>
                                <li>Suivi personnalisé</li>
                                <li>Équipement fourni</li>
                                <li>Participation aux compétitions</li>
                            </ul>
                        </div>
                    </div>

                    <div class="registration-form">
                        <h3 style="margin-bottom: 1.5rem; color: #1a365d;">Formulaire d'inscription</h3>

                        <!-- Zone des messages -->
                        <div id="messageZone" style="margin-bottom: 1rem;"></div>

                        <form id="" action="{{ route('inscription.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nom">Nom *</label>
                                    <input type="text" id="nom" name="nom" required>
                                    <div class="error-message" id="nom-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="prenom">Prénom *</label>
                                    <input type="text" id="prenom" name="prenom" required>
                                    <div class="error-message" id="prenom-error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="date_naissance">Date de naissance</label>
                                    <input type="date" id="date_naissance" name="date_naissance">
                                    <div class="error-message" id="date_naissance-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="sexe">Sexe</label>
                                    <select id="sexe" name="sexe">
                                        <option value="">Choisir...</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                    <div class="error-message" id="sexe-error"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lieu_naissance">Lieu de naissance</label>
                                <input type="text" id="lieu_naissance" name="lieu_naissance">
                                <div class="error-message" id="lieu_naissance-error"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="telephone">Téléphone</label>
                                    <input type="tel" id="telephone" name="telephone" placeholder="+257 79 123 456">
                                    <div class="error-message" id="telephone-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email">
                                    <div class="error-message" id="email-error"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- <div class="form-group">
                                    <label for="colline_id">Colline/Quartier *</label>
                                    <select id="colline_id" name="colline_id" required>
                                        <option value="">Choisir...</option>
                                        @foreach ($collines as $colline)
                                            <option value="{{ $colline->id }}">{{ $colline->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" id="colline_id-error"></div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="categorie_id">Catégorie/Discipline *</label>
                                    <select id="categorie_id" name="categorie_id" required>
                                        <option value="">Choisir...</option>
                                        @foreach ($categories as $categorie)
                                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" id="categorie_id-error"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary" id="submitBtn"
                                style="width: 100%; margin-top: 1rem;">
                                <i class="fas fa-user-plus"></i> S'inscrire maintenant
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    @endsection
