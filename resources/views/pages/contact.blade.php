@extends('layouts.user')
@section('title', 'Contactez nous')

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>CONTACTEZ-VOUS</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            {{-- <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <a href="{{ route('contact.store') }}" class="btn-secondary">En savoir Plus</a>
            </div> --}}
        </div>
    </section>

    <!-- Messages de succès et d'erreur -->
    @if (session('success'))
        <div class="alert-success">
            <div class="container">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            <div class="container">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Contact Section -->
    <section class="contact-section" id="contact-form">
        <div class="container">
            <div class="contact-content">
                <!-- Formulaire de contact -->
                <div class="contact-form-wrapper">
                    <h2>Envoyez-nous un message</h2>
                    <p>Remplissez le formulaire ci-dessous et nous vous répondrons rapidement.</p>

                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nom complet *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="Votre nom complet" class="@error('name') error @enderror" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="votre.email@example.com" class="@error('email') error @enderror" required>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sujet">Sujet *</label>
                            <select id="sujet" name="sujet" class="@error('sujet') error @enderror" required>
                                <option value="">Choisissez un sujet</option>
                                <option value="Inscription" {{ old('sujet') == 'Inscription' ? 'selected' : '' }}>
                                    Inscription</option>
                                <option value="Information générale"
                                    {{ old('sujet') == 'Information générale' ? 'selected' : '' }}>Information générale
                                </option>
                                <option value="Cours et formations"
                                    {{ old('sujet') == 'Cours et formations' ? 'selected' : '' }}>Cours et formations
                                </option>
                                <option value="Compétitions" {{ old('sujet') == 'Compétitions' ? 'selected' : '' }}>
                                    Compétitions</option>
                                <option value="Partenariat" {{ old('sujet') == 'Partenariat' ? 'selected' : '' }}>
                                    Partenariat</option>
                                <option value="Autre" {{ old('sujet') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('sujet')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="6" placeholder="Écrivez votre message ici..."
                                class="@error('message') error @enderror" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <small>Maximum 2000 caractères</small>
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Envoyer le message
                        </button>
                    </form>
                </div>

                <!-- Informations de contact -->
                <div class="contact-info-wrapper" id="contact-info">
                    <h2>Nos coordonnées</h2>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Adresse</h4>
                            <p>Avenue de l'Indépendance<br>Bujumbura, Burundi</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Téléphone</h4>
                            <p>+257 22 123 456</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p>info@judoburundi-bi.com</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Horaires d'ouverture</h4>
                            <p>
                                <strong>Lundi - Vendredi:</strong> 6h00 - 21h00<br>
                                <strong>Samedi:</strong> 8h00 - 18h00<br>
                                <strong>Dimanche:</strong> 10h00 - 16h00
                            </p>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="#" class="social-link facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="map-container">
            <div class="map-overlay">
                <div class="map-info">
                    <h3>Fédération de Judo du Burundi</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Avenue de l'Indépendance, Bujumbura</p>
                    <button class="btn-secondary">Obtenir l'itinéraire</button>
                </div>
            </div>
            <div class="map-placeholder">
                <div class="map-background"></div>
            </div>
        </div>
    </section>

    <style>
        /* Messages d'alerte */
        .alert-success,
        .alert-error {
            padding: 15px 0;
            margin: 0;
            text-align: center;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #4CAF50, #7CB342);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #f44336, #e53935);
            color: white;
        }

        .alert-success i,
        .alert-error i {
            margin-right: 10px;
            font-size: 1.1em;
        }

        /* Section Contact */
        .contact-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .contact-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 60px;
            align-items: start;
        }

        /* Formulaire */
        .contact-form-wrapper {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .contact-form-wrapper h2 {
            color: #1a365d;
            margin-bottom: 10px;
            font-size: 2.2em;
            font-weight: 700;
        }

        .contact-form-wrapper p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1em;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4d6434;
            box-shadow: 0 0 0 3px rgba(124, 179, 66, 0.1);
            transform: translateY(-2px);
        }

        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #e53935;
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.1);
        }

        .error-message {
            color: #e53935;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }

        .form-group small {
            color: #999;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Informations de contact */
        .contact-info-wrapper {
            background: linear-gradient(135deg, #7CB342, #8BC34A);
            padding: 40px;
            border-radius: 15px;
            color: white;
            height: fit-content;
        }

        .contact-info-wrapper h2 {
            color: white;
            margin-bottom: 30px;
            font-size: 1.8em;
            font-weight: 700;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .contact-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            font-size: 1.2em;
        }

        .contact-details h4 {
            color: white;
            margin-bottom: 5px;
            font-size: 1.1em;
            font-weight: 600;
        }

        .contact-details p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            line-height: 1.5;
        }

        .social-section {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-section h4 {
            color: white;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            transform: translateY(-3px);
            color: white;
        }

        .social-link.facebook {
            background: rgba(59, 89, 152, 0.8);
        }

        .social-link.instagram {
            background: rgba(228, 64, 95, 0.8);
        }

        .social-link.twitter {
            background: rgba(255, 0, 0, 0.8);
        }

        .social-link.facebook:hover {
            background: #3b5998;
        }

        .social-link.instagram:hover {
            background: #e4405f;
        }

        .social-link.twitter:hover {
            background: #ff0000;
        }

        /* Section Carte */
        .map-section {
            position: relative;
            height: 400px;
            overflow: hidden;
        }

        .map-container {
            position: relative;
            height: 100%;
        }

        .map-background {
            height: 100%;
            background: linear-gradient(45deg, #7CB342, #4CAF50);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .map-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .map-info {
            text-align: center;
            color: white;
        }

        .map-info h3 {
            font-size: 2em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .map-info p {
            font-size: 1.1em;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .map-info i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .contact-form-wrapper,
            .contact-info-wrapper {
                padding: 25px;
            }

            .contact-form-wrapper h2 {
                font-size: 1.8em;
            }

            .hero h1 {
                font-size: 2.5em;
            }
        }
    </style>

    <script>
        function scrollToContact() {
            document.getElementById('contact-form').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function scrollToInfo() {
            document.getElementById('contact-info').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Animation au scroll
        window.addEventListener('scroll', function() {
            const elements = document.querySelectorAll('.contact-item');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.contact-item');
            elements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'all 0.6s ease';
            });
        });
    </script>
@endsection
