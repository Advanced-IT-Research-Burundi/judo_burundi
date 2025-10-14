<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fédération de Judo du Burundi')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">

    {{-- Section pour les styles personnalisés --}}
    @stack('styles')
</head>

<body>
    <header class="header">
        <!-- Bandeau supérieur -->
        <div class="top-header">
            <div class="container top-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="height: 80px;">
                    </a>
                </div>
                <div class="federation-info">
                    <h1>Fédération Burundaise de Judo et Disciplines Associées</h1>
                    <p>Courtoisie, courage, honnêteté, honneur, modestie, respect, maîtrise de soi, amitié</p>
                </div>
            </div>
        </div>

        <!-- Barre de navigation -->
<nav class="main-nav">
    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="active">Accueil</a></li>

        <!-- Menu Fédération -->
        <li class="dropdown">
            <a href="{{ route('about') }}">La Fédération</a>
            <ul class="dropdown-menu">
                <li><a href="#">Historique</a></li>
                <li><a href="#">Direction</a></li>
                <li><a href="#">Judo Burundi</a></li>
                <li><a href="#">Statuts et Règlements</a></li>
            </ul>
        </li>

        <!-- Menu Activités -->
        <li class="dropdown">
            <a href="#">Activités</a>
            <ul class="dropdown-menu">
                <li><a href="#">Compétitions</a></li>
                <li><a href="#">Formations</a></li>
                <li><a href="#">Resultats</a></li>
                <li><a href="#">Calendrier</a></li>
            </ul>
        </li>

        <li><a href="{{ route('galerie') }}">Ligues et Clubs</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>
</nav>
    </header>

    <!-- Content -->
    <main>
        @yield('content')
    </main>
    <!-- Modal de démarrage rapide -->
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="color: #1a365d; margin-bottom: 1rem;">Inscription rapide</h2>
            <p>Remplissez ce formulaire pour commencer votre parcours avec nous !</p>
            <form action="{{ route('home') }}#registration" method="get">
                <button class="btn-primary" type="submit" style="width: 100%; margin-top: 1rem;">
                    Aller au formulaire complet
                </button>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>JUDO-BURUNDI</h3>
                    <p>Votre partenaire pour un parcours d'excellence. Nous formons les champions de demain avec passion
                        et dévouement.</p>
                    <p><a href="#">sitemap</a></p>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Avenue de l'Indépendance, Bujumbura</p>
                    <p><i class="fas fa-phone"></i> +257 22 123 456</p>
                    <p><i class="fas fa-envelope"></i> info@judoburundi-bi.com</p>
                </div>
                <div class="footer-section">
                    <h3>Horaires</h3>
                    <p>Lundi - Vendredi: 6h00 - 21h00</p>
                    <p>Samedi: 8h00 - 18h00</p>
                    <p>Dimanche: 10h00 - 16h00</p>
                </div>
                <div class="footer-section">
                    <h3>Suivez-nous</h3>
                    <p><a href="#"><i class="fab fa-facebook"></i> Facebook</a></p>
                    <p><a href="#"><i class="fab fa-instagram"></i> Instagram</a></p>
                    <p><a href="#"><i class="fab fa-twitter"></i> Twitter</a></p>
                    <p><a href="#"><i class=""></i>Email: judoburundi@gmail.com</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 JUDO-BURUNDI. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    {{-- Scripts de base --}}
    <script src="{{ asset('js/user.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>

    {{-- Section pour les scripts personnalisés --}}
    @stack('scripts')
    <button id="backToTop" title="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>

</html>
