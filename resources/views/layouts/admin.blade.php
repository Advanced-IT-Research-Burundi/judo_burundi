<!-- resources/views/admin/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Judo Burundi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: #34495e;
            border-radius: 8px;
            margin: 0 10px;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: #3498db;
            border-radius: 8px;
            margin: 0 10px;
        }
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        .nav-section {
            padding: 0.5rem 1.5rem;
            color: #95a5a6;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1rem;
        }
        .nav-section:first-child {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center pb-3 border-bottom border-secondary">
                        <h5 class="text-white">
                            <i class="fas fa-fist-raised"></i> Judo Admin
                        </h5>
                    </div>
                    <ul class="nav flex-column">
                        <!-- Section Tableau de bord -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.joueurs.*') ? 'active' : '' }}" 
                               href="{{ route('admin.joueurs.index') }}">
                                <i class="fas fa-users me-2"></i>
                                Joueurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" 
                               href="{{ route('admin.posts.index') }}">
                                <i class="fas fa-newspaper me-2"></i>
                                Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                               href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags me-2"></i>
                                Catégories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.typeposts.*') ? 'active' : '' }}" 
                               href="{{ route('admin.typeposts.index') }}">
                                <i class="fas fa-list me-2"></i>
                                Types de Posts
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Administration')</h1>
                    @yield('page-actions')
                </div>

                <!-- Messages Flash -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>