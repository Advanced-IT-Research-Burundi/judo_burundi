<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Fédération de Judo</title>
    
    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h2>Judo Admin</h2>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.joueurs.index') }}" class="menu-link {{ request()->routeIs('admin.joueurs.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Joueurs</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Catégories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posts.index') }}" class="menu-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Actualités</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.type-posts.index') }}" class="menu-link {{ request()->routeIs('admin.type-posts.*') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Types de Posts</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
            <div class="header-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="header-actions">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span>{{ auth()->user()->name ?? 'Administrateur' }}</span>
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Erreurs de validation :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>