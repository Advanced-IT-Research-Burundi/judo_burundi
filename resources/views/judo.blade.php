@extends('layouts.user')

@section('title', 'Académie de Judo - Fédération Burundaise de Judo et Disciplines Associées')

@section('content')
    <!-- Hero Section avec Slider -->
    <section class="hero" id="home">
        <div class="hero-slider">
            <!-- Slides -->
            <div class="slide active" style="background-image: url('{{ asset('images/judo1.jpeg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/judo2.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/judo3.jpg') }}');"></div>

            <!-- Overlay sombre -->
            <div class="overlay"></div>

            <!-- Contenu du hero -->
            <div class="hero-content">
                <h1>ENTRAÎNEZ-VOUS AVEC LES MEILLEURS</h1>
                <p>Découvrez le JUDO traditionnel avec nos instructeurs légendaires</p>
                <div class="hero-buttons">
                    <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                    <a href="{{ route('contact') }}" class="btn-secondary">En savoir plus</a>
                </div>
            </div>

            <!-- Flèches de navigation -->
            <div class="slider-arrows">
                <span class="prev">&#10094;</span>
                <span class="next">&#10095;</span>
            </div>

            <!-- Indicateurs -->
            <div class="slider-dots"></div>
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
                        @if ($image->images && file_exists(public_path('storage/' . $image->images)))
                            <img src="{{ asset('storage/' . $image->images) }}" alt="Image de la galerie"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #7CB342, #689F3A); 
                                        display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="font-size: 3rem; color: white; opacity: 0.7;"></i>
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                        <i class="fas fa-images" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <p style="color: #999;">Aucune image disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- News Section -->
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
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <!-- Image par défaut selon le type -->
                                @php
                                    $defaultImages = [
                                        'Compétition' => 'judo3.jpg',
                                        'Événement' => 'judo4.jpg',
                                        'Formation' => 'judo5.jpg',
                                        'default' => 'judo6.jpg'
                                    ];
                                    $imageFile = $defaultImages[$actualite->typePost->nom ?? 'default'] ?? $defaultImages['default'];
                                @endphp
                                <img src="{{ asset('images/' . $imageFile) }}" alt="{{ $actualite->typePost->nom ?? 'Actualité' }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">{{ Str::limit($actualite->titre, 60) }}</h3>
                            <p class="news-excerpt">
                                {{ $actualite->extrait ?? Str::limit(strip_tags($actualite->contenu), 120) }}
                            </p>

                            <!-- Bouton Lire plus -->
                            <a href="{{ route('actualites', $actualite->id) }}" class="read-more">
                                <i class="fas fa-arrow-right"></i> Lire plus
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Affichage si aucune actualité -->
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                        <i class="fas fa-newspaper" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <h5 style="color: #666; margin-bottom: 0.5rem;">Aucune actualité pour le moment</h5>
                        <p style="color: #999;">Revenez bientôt pour découvrir nos dernières nouvelles !</p>
                    </div>
                @endforelse
            </div>

            <!-- Voir plus d'actualités -->
            @if ($actualites->count() >= 6)
                <div class="text-center" style="margin-top: 2rem;">
                    <a href="{{ route('blog') }}" class="btn-primary" style="text-decoration: none; display: inline-block;">
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

                    <div class="registration-benefits">
                        <h3>Avantages de l'inscription :</h3>
                        <ul>
                            <li><i class="fas fa-check"></i> Accès illimité aux cours</li>
                            <li><i class="fas fa-check"></i> Suivi personnalisé</li>
                            <li><i class="fas fa-check"></i> Équipement fourni</li>
                            <li><i class="fas fa-check"></i> Participation aux compétitions</li>
                        </ul>
                    </div>
                </div>

                <div class="registration-form">
                    <h3>Formulaire d'inscription</h3>

                    <!-- Zone des messages -->
                    <div id="messageZone"></div>

                    <form id="myForm" action="{{ route('inscription.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="fullname">Nom complet *</label>
                            <input type="text" id="fullname" name="fullname" required>
                            <div class="error-message" id="fullname-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                            <div class="error-message" id="email-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" placeholder="+257 79 123 456">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      placeholder="Parlez-nous de vous et de vos objectifs..."></textarea>
                        </div>

                        <button type="submit" class="btn-primary" id="submitButton">
                            <span id="loadingSpinner" style="display: none;">⏳</span>
                            <i class="fas fa-user-plus"></i> S'inscrire maintenant
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection