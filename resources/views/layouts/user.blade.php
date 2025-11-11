<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fédération de Judo du Burundi')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/direction.css') }}">
     @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="top-header">
            <div class="container top-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Judo Burundi">
                    </a>
                </div>
                <div class="federation-info">
                    <h1>Fédération Burundaise de Judo et Disciplines Associées</h1>
                    <p>Courtoisie, courage, honnêteté, honneur, modestie, respect, maîtrise de soi, amitié</p>
                </div>
                <button class="mobile-toggle" aria-label="Menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <nav class="main-nav desktop-nav">
            <ul class="nav-links">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                </li>
                <li>
                <a href="{{ route('about') }}">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
            </li>
            <li>
                <a href="{{route('direction')}}">
                    <i class="fas fa-users"></i>
                    <span>Direction</span>
                </a>
            </li>
             <li>
                <a href="{{route('competitions.index')}}">
                    <i class="fas fa-medal"></i>
                    <span>Compétitions</span>
                </a>
            </li>
                {{-- <li class="dropdown">
                    <button type="button">
                        <i class="fas fa-building"></i> Fédération
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('about') }}">
                                <i class="fas fa-history"></i> Historique
                            </a>
                        </li>
                        <li>
                            <a href="{{route('direction')}}">
                                <i class="fas fa-users"></i> Direction
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <button type="button">
                        <i class="fas fa-trophy"></i> Activités
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('competitions.index')}}">
                                <i class="fas fa-medal"></i> Compétitions
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-calendar-alt"></i> Calendrier
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li>
                    <a href="{{ route('galerie') }}" class="{{ request()->routeIs('galerie') ? 'active' : '' }}">
                        <i class="fas fa-images"></i> Galerie
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i> Contact
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Mobile Drawer Menu -->
    <div class="drawer-overlay"></div>
    <nav class="drawer-menu">
        <div class="drawer-header">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            <button class="drawer-close" aria-label="Fermer menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="drawer-links">
            <li>
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
            </li>
            <li>
                <a href="{{route('direction')}}">
                    <i class="fas fa-users"></i>
                    <span>Direction</span>
                </a>
            </li>
             <li>
                <a href="{{route('competitions.index')}}">
                    <i class="fas fa-medal"></i>
                    <span>Compétitions</span>
                </a>
            </li>
            {{-- <li class="drawer-dropdown">
                <button type="button" class="drawer-dropdown-btn">
                    <div>
                        <i class="fas fa-building"></i>
                        <span>Fédération</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="drawer-submenu">
                    <li>
                        <a href="{{ route('about') }}">
                            <i class="fas fa-history"></i>
                            <span>Historique</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('direction')}}">
                            <i class="fas fa-users"></i>
                            <span>Direction</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="drawer-dropdown">
                <button type="button" class="drawer-dropdown-btn">
                    <div>
                        <i class="fas fa-trophy"></i>
                        <span>Activités</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="drawer-submenu">
                    <li>
                        <a href="{{route('competitions.index')}}">
                            <i class="fas fa-medal"></i>
                            <span>Compétitions</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Calendrier</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            <li>
                <a href="{{ route('galerie') }}">
                    <i class="fas fa-images"></i>
                    <span>Galerie</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>JUDO-BURUNDI</h3>
                    <p>Votre partenaire pour un parcours d'excellence. Nous formons les champions de demain avec passion et dévouement.</p>
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
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 JUDO-BURUNDI. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="backToTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="{{ asset('js/user.js') }}"></script>
</body>

</html>
