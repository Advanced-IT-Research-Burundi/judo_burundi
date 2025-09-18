{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Interface d'administration - Système de gestion de la fédération">

    <title>@yield('title', 'Administration') - {{ config('app.name', 'Fédération') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Admin Styles -->
    <style>
        :root {
            --admin-primary: #0d6efd;
            --admin-secondary: #6c757d;
            --admin-success: #198754;
            --admin-danger: #dc3545;
            --admin-warning: #ffc107;
            --admin-info: #0dcaf0;
            --admin-sidebar-bg: #212529;
            --admin-sidebar-width: 280px;
            --admin-header-height: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Header fixe */
        .admin-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--admin-header-height);
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            z-index: 1030;
            transition: left 0.3s ease;
        }

        .admin-header.sidebar-open {
            left: var(--admin-sidebar-width);
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--admin-sidebar-width);
            background: var(--admin-sidebar-bg);
            z-index: 1040;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
            padding-top: var(--admin-header-height);
        }

        .admin-sidebar.show {
            transform: translateX(0);
        }

        .admin-sidebar .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid #495057;
            background: #1a1e21;
        }

        .admin-sidebar .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .admin-sidebar .nav-section {
            padding: 1rem 0;
            border-bottom: 1px solid #495057;
        }

        .admin-sidebar .nav-section-title {
            color: #adb5bd;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1rem;
            margin-bottom: 0.5rem;
        }

        .admin-sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            border-radius: 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: white;
            background-color: var(--admin-primary);
            transform: translateX(5px);
        }

        .admin-sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 1rem;
        }

        .admin-sidebar .nav-link .badge {
            margin-left: auto;
            font-size: 0.7rem;
        }

        /* Main content */
        .admin-main {
            margin-left: 0;
            margin-top: var(--admin-header-height);
            min-height: calc(100vh - var(--admin-header-height));
            transition: margin-left 0.3s ease;
            padding: 0;
        }

        .admin-main.sidebar-open {
            margin-left: var(--admin-sidebar-width);
        }

        /* Content area */
        .admin-content {
            padding: 2rem;
            min-height: calc(100vh - var(--admin-header-height));
        }

        /* Cards améliorées */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        /* Tables améliorées */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Boutons améliorés */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Alertes */
        .alert {
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            border-left: 4px solid;
        }

        .alert-success {
            border-left-color: var(--admin-success);
        }

        .alert-danger {
            border-left-color: var(--admin-danger);
        }

        .alert-warning {
            border-left-color: var(--admin-warning);
        }

        .alert-info {
            border-left-color: var(--admin-info);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            font-size: 0.75em;
            padding: 0.35em 0.65em;
        }

        /* Stats cards */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-card.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stats-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stats-card.info {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .stats-card.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-header.sidebar-open {
                left: 0;
            }

            .admin-main.sidebar-open {
                margin-left: 0;
            }

            .admin-sidebar.show {
                width: 100%;
            }

            .admin-content {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loader */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Navigation breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: #6c757d;
        }

        /* Footer */
        .admin-footer {
            background: #f8f9fa;
            padding: 1rem 2rem;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 0.875rem;
        }

        /* Overlay pour mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            display: none;
        }

        /* Status indicators */
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-online {
            background-color: var(--admin-success);
        }

        .status-offline {
            background-color: var(--admin-secondary);
        }

        .status-away {
            background-color: var(--admin-warning);
        }

        /* Dark mode toggle (optionnel) */
        .theme-toggle {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.1rem;
            transition: color 0.2s ease;
        }

        .theme-toggle:hover {
            color: var(--admin-primary);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg admin-header" id="adminHeader">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary me-3" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                @yield('title', 'Administration')
            </a>

            <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <!-- Notifications -->
                <div class="nav-item dropdown me-3">
                    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6em;">
                            3
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <h6 class="dropdown-header">Notifications récentes</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">
                                <small class="text-muted">Nouveau joueur inscrit</small>
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <small class="text-muted">Événement à venir</small>
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <small class="text-muted">Post publié</small>
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-center" href="#">Voir toutes</a></li>
                    </ul>
                </div>

                <!-- User menu -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="status-indicator status-online"></div>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>Mon profil
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-shield-alt me-2"></i>Admin Panel</h4>
        </div>

        <!-- Navigation principale -->
        <div class="nav-section">
            <div class="nav-section-title">Principal</div>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
        </div>

        <!-- Gestion des membres -->
        <div class="nav-section">
            <div class="nav-section-title">Gestion</div>
            <a class="nav-link {{ request()->routeIs('admin.joueurs.*') ? 'active' : '' }}"
                href="{{ route('admin.joueurs.index') }}">
                <i class="fas fa-users me-2"></i>
                Joueurs
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags me-2"></i>
                Catégories
            </a>
        </div>

        <!-- Gestion du contenu -->
        <div class="nav-section">
            <div class="nav-section-title">Contenu</div>
            <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                href="{{ route('admin.posts.index') }}">
                <i class="fas fa-newspaper me-2"></i>
                Posts
            </a>
            {{-- <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
                href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-envelope me-2"></i>
                Messages
            </a> --}}
        </div>

        <!-- Configuration -->
        <div class="nav-section">
            <div class="nav-section-title">Configuration</div>
            <a class="nav-link" href="#" onclick="showComingSoon('Zones & Collines')">
                <i class="fas fa-map-marker-alt"></i>Zones & Collines
            </a>
            <a class="nav-link" href="#" onclick="showComingSoon('Types de Posts')">
                <i class="fas fa-list"></i>Types de Posts
            </a>
            <a class="nav-link" href="#" onclick="showComingSoon('Utilisateurs')">
                <i class="fas fa-users-cog"></i>Utilisateurs
            </a>
            <a class="nav-link" href="#" onclick="showComingSoon('Paramètres')">
                <i class="fas fa-cogs"></i>Paramètres
            </a>
        </div>

        <!-- Outils -->
        <div class="nav-section">
            <div class="nav-section-title">Outils</div>
            <a class="nav-link" href="#" onclick="showComingSoon('Export Joueurs')">
                <i class="fas fa-download"></i>Export Joueurs
            </a>
            <a class="nav-link" href="#" onclick="showComingSoon('Statistiques')">
                <i class="fas fa-chart-bar"></i>Statistiques
            </a>
            <a class="nav-link" href="#" onclick="showComingSoon('Rapports')">
                <i class="fas fa-file-alt"></i>Rapports
            </a>
        </div>

        <!-- Liens externes -->
        <div class="nav-section">
            <div class="nav-section-title">Externe</div>
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>Voir le site public
            </a>
        </div>
    </nav>

    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main content -->
    <div class="admin-main" id="adminMain">
        <!-- Breadcrumb (optionnel) -->
        @if (isset($breadcrumbs))
            <nav class="breadcrumb-container p-3">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($loop->last)
                            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif

        <!-- Page content -->
        <main class="admin-content fade-in">
            {{-- Messages flash --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Erreurs de validation :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span>&copy; {{ date('Y') }} Système de Gestion Fédération</span>
                    <span class="mx-2">•</span>
                    <span>Version 1.0</span>
                </div>
                <div>
                    <span class="me-3">Connecté en tant que : <strong>{{ Auth::user()->name }}</strong></span>
                    <span>{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (optionnel) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <!-- Admin JS -->
    <script>
        // Fonction pour afficher les messages "à venir"
        function showComingSoon(feature) {
            AdminUtils.showNotification(`${feature} - Fonctionnalité à venir`, 'info');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const header = document.getElementById('adminHeader');
            const mainContent = document.getElementById('adminMain');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                header.classList.toggle('sidebar-open');
                mainContent.classList.toggle('sidebar-open');

                // Show overlay on mobile
                if (window.innerWidth <= 768) {
                    sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
                }

                // Sauvegarder l'état
                localStorage.setItem('sidebar-open', sidebar.classList.contains('show'));
            });

            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                header.classList.remove('sidebar-open');
                mainContent.classList.remove('sidebar-open');
                this.style.display = 'none';
                localStorage.setItem('sidebar-open', 'false');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebarOverlay.style.display = 'none';
                }
            });

            // Restaurer l'état de la sidebar
            const sidebarOpen = localStorage.getItem('sidebar-open') === 'true';
            if (window.innerWidth > 768 && sidebarOpen) {
                sidebar.classList.add('show');
                header.classList.add('sidebar-open');
                mainContent.classList.add('sidebar-open');
            }

            // Auto-hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function(alert) {
                    try {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    } catch (e) {
                        // Alert already closed
                    }
                });
            }, 5000);

            // Add loading state to forms
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2"></span>Traitement...';
                        submitBtn.disabled = true;

                        // Timeout de sécurité
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }, 30000);
                    }
                });
            });

            // Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });

        // Utilitaires globaux
        window.AdminUtils = {
            showNotification: function(message, type = 'info') {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                alertDiv.style.top = '90px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.parentNode.removeChild(alertDiv);
                    }
                }, 5000);
            },

            confirmDelete: function(title = 'Confirmer la suppression') {
                return confirm(title + '\n\nCette action est irréversible.');
            }
        };
    </script>

    @stack('scripts')
</body>

</html>