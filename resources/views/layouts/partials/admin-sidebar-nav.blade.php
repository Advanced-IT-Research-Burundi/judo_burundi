{{--
    Navigation admin (sidebar desktop + offcanvas mobile).
    Ne pas utiliser data-bs-dismiss="offcanvas" sur les liens : le même partial est inclus hors offcanvas ;
    la fermeture mobile est gérée dans public/js/admin.js (.admin-sidebar-link).
--}}
@php
    $isDashboard = request()->routeIs('admin.dashboard', 'dashboard');
@endphp
<nav class="nav flex-column gap-1 small" aria-label="Menu administration">
    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ $isDashboard ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
    </a>
    <a href="{{ route('admin.joueurs.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.joueurs.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-users fa-fw me-2"></i> Joueurs
    </a>
    <a href="{{ route('admin.clubs.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.clubs.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-building fa-fw me-2"></i> Clubs
    </a>
    <a href="{{ route('admin.competitions.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.competitions.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-trophy fa-fw me-2"></i> Compétitions
    </a>
    <a href="{{ route('admin.posts.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.posts.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-newspaper fa-fw me-2"></i> Actualités
    </a>
    <a href="{{ route('admin.membres.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.membres.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-id-card fa-fw me-2"></i> Membres
    </a>
    <a href="{{ route('admin.gallery.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.gallery.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-images fa-fw me-2"></i> Galerie
    </a>
    <a href="{{ route('admin.users.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.users.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-cloud fa-fw me-2"></i> Utilisateurs
    </a>
    <a href="{{ route('admin.equipes.index') }}" class="admin-sidebar-link nav-link text-white px-3 py-2 rounded text-decoration-none {{ request()->routeIs('admin.equipes.*') ? 'active bg-white bg-opacity-25' : '' }}">
        <i class="fas fa-users-cog fa-fw me-2"></i> Équipes
    </a>
    <hr class="border-light border-opacity-25 my-2 mx-2">
    <a href="{{ route('home') }}" class="admin-sidebar-link nav-link text-white-50 px-3 py-2 rounded text-decoration-none small" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-external-link-alt fa-fw me-2"></i> Voir le site public
    </a>
</nav>
