<header class="header-main">
    <div class="container">
        <div class="header-top">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="FBJDA">
                <div class="logo-text">
                    <h1>FBJDA</h1>
                    <p>Fédération Burundaise de Judo</p>
                </div>
            </a>
            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <nav class="nav-desktop">
        <div class="container">
            <ul class="nav-list">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Fédération <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('about') }}">Historique</a></li>
                        <li><a href="{{ route('direction') }}">Direction</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Activités <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('competitions.index') }}">Compétitions</a></li>
                        <li><a href="#">Calendrier</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('galerie') }}" class="{{ request()->routeIs('galerie') ? 'active' : '' }}">Galerie</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    <div class="drawer" id="drawer">
        <div class="drawer-header">
            <h2>Menu</h2>
            <button class="drawer-close" id="drawerClose" aria-label="Fermer">&times;</button>
        </div>
        <nav class="drawer-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Accueil
            </a>
            <div class="drawer-group">
                <button class="drawer-toggle">
                    <span><i class="fas fa-building"></i> Fédération</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="drawer-submenu">
                    <a href="{{ route('about') }}">Historique</a>
                    <a href="{{ route('direction') }}">Direction</a>
                </div>
            </div>
            <div class="drawer-group">
                <button class="drawer-toggle">
                    <span><i class="fas fa-calendar-alt"></i> Activités</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="drawer-submenu">
                    <a href="{{ route('competitions.index') }}">Compétitions</a>
                    <a href="#">Calendrier</a>
                </div>
            </div>
            <a href="{{ route('galerie') }}" class="{{ request()->routeIs('galerie') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Galerie
            </a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Contact
            </a>
        </nav>
        <div class="drawer-footer">
            <p>Courtoisie • Courage • Respect</p>
        </div>
    </div>
    <div class="drawer-overlay" id="drawerOverlay"></div>
</header>

<style>
.header-main {
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
}

.logo {
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
}

.logo img {
    height: 50px;
    width: auto;
}

.logo-text h1 {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    color: #0d6efd;
}

.logo-text p {
    font-size: .75rem;
    margin: 0;
    color: #6c757d;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
}

.menu-toggle span {
    width: 25px;
    height: 3px;
    background: #0d6efd;
    transition: all .3s;
}

.nav-desktop {
    background: #0d6efd;
}

.nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: .5rem;
}

.nav-list > li > a {
    display: block;
    padding: 1rem 1.25rem;
    color: #fff;
    text-decoration: none;
    transition: background .3s;
}

.nav-list > li > a:hover,
.nav-list > li > a.active {
    background: rgba(255,255,255,.1);
}

.dropdown {
    position: relative;
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    gap: .5rem;
}

.dropdown-toggle i {
    font-size: .75rem;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    min-width: 200px;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
    list-style: none;
    margin: 0;
    padding: .5rem 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all .3s;
}

.dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu a {
    display: block;
    padding: .75rem 1.25rem;
    color: #333;
    text-decoration: none;
    transition: background .3s;
}

.dropdown-menu a:hover {
    background: #f8f9fa;
}

.drawer {
    position: fixed;
    top: 0;
    right: -320px;
    width: 320px;
    height: 100vh;
    background: #fff;
    box-shadow: -4px 0 12px rgba(0,0,0,.15);
    transition: right .3s;
    z-index: 1100;
    overflow-y: auto;
}

.drawer.active {
    right: 0;
}

.drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.drawer-header h2 {
    font-size: 1.25rem;
    margin: 0;
}

.drawer-close {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #6c757d;
    line-height: 1;
}

.drawer-nav {
    padding: 1rem 0;
}

.drawer-nav > a,
.drawer-group {
    display: block;
    border-bottom: 1px solid #f1f3f5;
}

.drawer-nav > a {
    padding: 1rem 1.5rem;
    color: #333;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: background .3s;
}

.drawer-nav > a:hover,
.drawer-nav > a.active {
    background: #f8f9fa;
    color: #0d6efd;
}

.drawer-toggle {
    width: 100%;
    padding: 1rem 1.5rem;
    background: none;
    border: none;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-size: 1rem;
}

.drawer-toggle span {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.drawer-toggle i:last-child {
    transition: transform .3s;
}

.drawer-group.open .drawer-toggle i:last-child {
    transform: rotate(180deg);
}

.drawer-submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height .3s;
    background: #f8f9fa;
}

.drawer-group.open .drawer-submenu {
    max-height: 200px;
}

.drawer-submenu a {
    display: block;
    padding: .75rem 1.5rem .75rem 3.5rem;
    color: #666;
    text-decoration: none;
    transition: background .3s;
}

.drawer-submenu a:hover {
    background: #e9ecef;
}

.drawer-footer {
    padding: 1.5rem;
    text-align: center;
    border-top: 1px solid #e9ecef;
    margin-top: auto;
}

.drawer-footer p {
    font-size: .875rem;
    color: #6c757d;
    margin: 0;
}

.drawer-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    opacity: 0;
    visibility: hidden;
    transition: all .3s;
    z-index: 1050;
}

.drawer-overlay.active {
    opacity: 1;
    visibility: visible;
}

@media (max-width: 991px) {
    .logo-text p {
        display: none;
    }

    .nav-desktop {
        display: none;
    }

    .menu-toggle {
        display: flex;
    }
}

@media (min-width: 992px) {
    .logo img {
        height: 60px;
    }

    .logo-text h1 {
        font-size: 1.5rem;
    }

    .logo-text p {
        font-size: .875rem;
    }
}
</style>

<script>
const menuToggle = document.getElementById('menuToggle');
const drawer = document.getElementById('drawer');
const drawerClose = document.getElementById('drawerClose');
const drawerOverlay = document.getElementById('drawerOverlay');

const openDrawer = () => {
    drawer.classList.add('active');
    drawerOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
};

const closeDrawer = () => {
    drawer.classList.remove('active');
    drawerOverlay.classList.remove('active');
    document.body.style.overflow = '';
};

menuToggle?.addEventListener('click', openDrawer);
drawerClose?.addEventListener('click', closeDrawer);
drawerOverlay?.addEventListener('click', closeDrawer);

document.querySelectorAll('.drawer-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        toggle.parentElement.classList.toggle('open');
    });
});
</script>
