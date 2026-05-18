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
    <style>
        :root {
            --bs-primary: #1a365d;
            --bs-primary-rgb: 26, 54, 93;
            --bs-success: #7cb342;
            --bs-success-rgb: 124, 179, 66;
        }
        .navbar-toggler-icon-light {
            --bs-navbar-toggler-icon-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagehero.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/direction.css') }}">
    @stack('styles')
</head>

@php
    $navFedOpen = request()->routeIs('about') || request()->routeIs('direction');
    $navActOpen = request()->routeIs('competitions.*') || request()->routeIs('clubs.*') || request()->routeIs('judokas.*');
@endphp

<body class="d-flex flex-column min-vh-100 bg-body">
    <header id="siteHeader" class="fixed-top shadow-sm">
        <div class="bg-primary text-white border-bottom border-light border-opacity-25">
            <div class="container py-2 py-lg-3">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <a href="{{ route('home') }}" class="d-inline-block">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Judo Burundi" class="rounded site-logo img-fluid">
                        </a>
                    </div>
                    <div class="col min-w-0">
                        <h1 class="text-white fw-bold mb-0 site-brand-title lh-sm">Fédération Burundaise de Judo et Disciplines Associées</h1>
                        <p class="small text-white-50 mb-0 d-none d-md-block site-brand-tagline mt-1">Courtoisie, courage, honnêteté, honneur, modestie, respect, maîtrise de soi, amitié</p>
                    </div>
                    <div class="col-auto d-lg-none">
                        <button class="navbar-toggler border border-light rounded py-2 px-2 shadow-none site-menu-toggler-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Ouvrir le menu">
                            <span class="navbar-toggler-icon navbar-toggler-icon-light"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-0 d-none d-lg-block navbar-site" aria-label="Navigation principale">
            <div class="container py-1">
                <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="flex-grow-1 d-flex justify-content-center">
                        <ul class="navbar-nav flex-row flex-wrap align-items-center justify-content-center gap-1 mb-0">
                            <li class="nav-item">
                                <a class="nav-link px-3 fw-medium site-nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Accueil</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link px-3 fw-medium dropdown-toggle site-nav-link @if($navFedOpen) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    La Fédération
                                </a>
                                <ul class="dropdown-menu shadow-sm border-0 mt-1">
                                    <li><a class="dropdown-item @if(request()->routeIs('about')) active @endif" href="{{ route('about') }}">Historique</a></li>
                                    <li><a class="dropdown-item @if(request()->routeIs('direction')) active @endif" href="{{ route('direction') }}">Direction</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link px-3 fw-medium dropdown-toggle site-nav-link @if($navActOpen) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Activités
                                </a>
                                <ul class="dropdown-menu shadow-sm border-0 mt-1">
                                    <li><a class="dropdown-item @if(request()->routeIs('competitions.*')) active @endif" href="{{ route('competitions.index') }}">Compétitions &amp; résultats</a></li>
                                    <li><a class="dropdown-item @if(request()->routeIs('clubs.*')) active @endif" href="{{ route('clubs.index') }}">Clubs</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 fw-medium site-nav-link @if(request()->routeIs('galerie')) active @endif" href="{{ route('galerie') }}">Galerie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 fw-medium site-nav-link @if(request()->routeIs('contact')) active @endif" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="navbar-nav flex-row flex-wrap align-items-center mb-0 border-start ps-lg-3 ms-lg-2">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link px-3 fw-medium site-nav-link @if(request()->routeIs('login')) active @endif" href="{{ route('login') }}">Connexion</a>
                            </li>
                        @else
                            @if(auth()->user()->is_admin)
                                <li class="nav-item">
                                    <a class="nav-link px-3 fw-medium site-nav-link @if(request()->routeIs('admin.*')) active @endif" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                            @endif
                            <!-- <li class="nav-item">
                                <a class="nav-link px-3 fw-medium site-nav-link @if(request()->routeIs('profile.*')) active @endif" href="{{ route('profile.edit') }}">Profil</a>
                            </li> -->
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link px-3 fw-medium site-nav-link btn btn-link text-decoration-none">Déconnexion</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title fw-semibold" id="mobileMenuLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body p-0 bg-body-secondary">
            <div class="list-group list-group-flush rounded-0">
                <a class="list-group-item list-group-item-action @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}" data-bs-dismiss="offcanvas"><i class="fas fa-home me-2 text-success"></i>Accueil</a>
                <div class="list-group-item p-0 border-0 bg-transparent">
                    <div class="accordion accordion-flush" id="accordionMenuMobile">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header border-bottom">
                                <button class="accordion-button collapsed bg-body-secondary fw-medium py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFed" aria-expanded="false">
                                    La Fédération
                                </button>
                            </h2>
                            <div id="collapseFed" class="accordion-collapse collapse @if($navFedOpen) show @endif">
                                <div class="accordion-body p-0">
                                    <a class="list-group-item list-group-item-action ps-5 @if(request()->routeIs('about')) active @endif" href="{{ route('about') }}" data-bs-dismiss="offcanvas">Historique</a>
                                    <a class="list-group-item list-group-item-action ps-5 border-bottom @if(request()->routeIs('direction')) active @endif" href="{{ route('direction') }}" data-bs-dismiss="offcanvas">Direction</a>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header border-bottom">
                                <button class="accordion-button collapsed bg-body-secondary fw-medium py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAct">
                                    Activités
                                </button>
                            </h2>
                            <div id="collapseAct" class="accordion-collapse collapse @if($navActOpen) show @endif">
                                <div class="accordion-body p-0 border-bottom">
                                    <a class="list-group-item list-group-item-action ps-5 @if(request()->routeIs('competitions.*')) active @endif" href="{{ route('competitions.index') }}" data-bs-dismiss="offcanvas">Compétitions &amp; résultats</a>
                                    <a class="list-group-item list-group-item-action ps-5 border-bottom @if(request()->routeIs('clubs.*')) active @endif" href="{{ route('clubs.index') }}" data-bs-dismiss="offcanvas">Clubs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="list-group-item list-group-item-action @if(request()->routeIs('galerie')) active @endif" href="{{ route('galerie') }}" data-bs-dismiss="offcanvas"><i class="fas fa-images me-2 text-success"></i>Galerie</a>
                <a class="list-group-item list-group-item-action border-bottom @if(request()->routeIs('contact')) active @endif" href="{{ route('contact') }}" data-bs-dismiss="offcanvas"><i class="fas fa-envelope me-2 text-success"></i>Contact</a>

                @guest
                    <a class="list-group-item list-group-item-action @if(request()->routeIs('login')) active @endif" href="{{ route('login') }}" data-bs-dismiss="offcanvas"><i class="fas fa-sign-in-alt me-2 text-success"></i>Connexion</a>
                @else
                    @if(auth()->user()->is_admin)
                        <a class="list-group-item list-group-item-action" href="{{ route('admin.dashboard') }}" data-bs-dismiss="offcanvas"><i class="fas fa-tachometer-alt me-2 text-success"></i>Dashboard</a>
                    @endif
                    <a class="list-group-item list-group-item-action @if(request()->routeIs('profile.*')) active @endif" href="{{ route('profile.edit') }}" data-bs-dismiss="offcanvas"><i class="fas fa-user-circle me-2 text-success"></i>Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action text-danger w-100 border-0 text-start bg-transparent">
                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    <main id="siteMain" class="site-main-offset flex-grow-1">
        @if (session('success'))
            <div class="container pt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container pt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-primary text-white py-5 mt-auto">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <h3 class="h5 fw-semibold text-white mb-3">JUDO-BURUNDI</h3>
                    <p class="text-white-75 small mb-0">Votre partenaire pour un parcours d'excellence. Nous formons les champions de demain avec passion et dévouement.</p>
                </div>
                <div class="col">
                    <h3 class="h5 fw-semibold text-white mb-3">Contact</h3>
                    <p class="text-white-75 small mb-1"><i class="fas fa-map-marker-alt text-success me-2"></i>Avenue de l'Indépendance, Bujumbura</p>
                    <p class="text-white-75 small mb-1"><i class="fas fa-phone text-success me-2"></i>+257 22 123 456</p>
                    <p class="text-white-75 small mb-0"><i class="fas fa-envelope text-success me-2"></i>info@judoburundi-bi.com</p>
                </div>
                <div class="col">
                    <h3 class="h5 fw-semibold text-white mb-3">Horaires</h3>
                    <p class="text-white-75 small mb-1">Lundi - Vendredi: 6h00 - 21h00</p>
                    <p class="text-white-75 small mb-1">Samedi: 8h00 - 18h00</p>
                    <p class="text-white-75 small mb-0">Dimanche: 10h00 - 16h00</p>
                </div>
                <div class="col">
                    <h3 class="h5 fw-semibold text-white mb-3">Suivez-nous</h3>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="#" class="btn btn-outline-light rounded-circle btn-sm p-2" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle btn-sm p-2" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle btn-sm p-2" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top border-white border-opacity-25 pt-3 mt-5 text-center text-white-50 small">
                <p class="mb-0">&copy; 2026 JUDO-BURUNDI. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <button id="backToTop" type="button" class="btn btn-success position-fixed rounded-circle shadow d-flex align-items-center justify-content-center" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script src="{{ asset('js/user.js') }}"></script>
</body>

</html>
