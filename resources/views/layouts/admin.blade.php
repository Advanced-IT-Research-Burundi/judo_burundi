<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Fédération de Judo</title>
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
        .stat-icon.green { background: linear-gradient(135deg, var(--bs-success) 0%, #689f3a 100%) !important; }
    </style>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-body-secondary min-vh-100">
    {{-- Barre mobile --}}
    <div class="d-lg-none sticky-top shadow-sm bg-primary border-bottom border-light border-opacity-25" style="z-index: 1030;">
        <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between">
            <span class="text-white fw-semibold">Judo Admin</span>
            <button type="button" class="btn btn-outline-light btn-sm border-light" data-bs-toggle="offcanvas" data-bs-target="#adminNavOffcanvas" aria-controls="adminNavOffcanvas" aria-label="Ouvrir le menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-start text-bg-primary" tabindex="-1" id="adminNavOffcanvas" aria-labelledby="adminNavLabel">
        <div class="offcanvas-header border-bottom border-light border-opacity-25">
            <h5 class="offcanvas-title text-white fw-semibold" id="adminNavLabel">Navigation</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body p-3">
            @include('layouts.partials.admin-sidebar-nav')
        </div>
    </div>

    <div class="container-fluid g-0">
        <div class="row g-0 flex-lg-nowrap min-vh-100">
            <aside class="col-auto d-none d-lg-flex flex-column bg-primary flex-shrink-0 shadow-sm pt-4 pb-3 px-0 border-end border-light border-opacity-10 sidebar-desktop" style="width:280px;">
                <div class="text-white fw-bold px-4 mb-3 lh-sm fs-6">Judo Admin</div>
                <div class="px-2 flex-grow-1 overflow-auto sidebar-nav-wrap">
                    @include('layouts.partials.admin-sidebar-nav')
                </div>
            </aside>

            <div id="mainContent" class="col min-vw-0 d-flex flex-column flex-grow-1">
                <header class="navbar navbar-expand bg-white px-4 py-3 border-bottom shadow-sm sticky-top">
                    <div class="container-fluid px-0 d-flex justify-content-between align-items-center gap-3">
                        <h1 class="h4 fw-semibold text-primary mb-0 text-truncate">@yield('page-title', 'Dashboard')</h1>
                        <div class="dropdown">
                            <div class="d-flex align-items-center gap-2 bg-body-secondary rounded-pill px-3 py-1">
                                <div class="rounded-circle bg-success text-white fw-semibold d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:0.9rem;">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="d-none d-md-inline small text-muted text-truncate" style="max-width:140px">{{ auth()->user()->name ?? 'Administrateur' }}</span>
                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu compte"><i class="fas fa-chevron-down small"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="flex-grow-1 p-4 content-area">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Erreurs de validation :</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
