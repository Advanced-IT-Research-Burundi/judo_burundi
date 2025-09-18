<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Fédération de Judo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #1a365d 0%, #2d5a87 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-header h2 {
            font-size: 1.4rem;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .sidebar-header h2 {
            opacity: 0;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            margin: 0.2rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: #7CB342;
        }

        .sidebar-menu a.active {
            color: white;
            background: rgba(124, 179, 66, 0.2);
            border-left-color: #7CB342;
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }

        .sidebar.collapsed .sidebar-menu span {
            opacity: 0;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Header */
        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            color: #1a365d;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: #7CB342;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content {
            padding: 2rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.green { background: linear-gradient(135deg, #7CB342 0%, #689F3A 100%); }
        .stat-icon.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-icon.purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .stat-info h3 {
            font-size: 2rem;
            color: #1a365d;
            margin-bottom: 0.2rem;
        }

        .stat-info p {
            color: #666;
            font-weight: 500;
        }

        /* Content Sections */
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-header h3 {
            color: #1a365d;
            font-size: 1.3rem;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn {
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #7CB342;
            color: white;
        }

        .btn-primary:hover {
            background: #689F3A;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: #000;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.7rem 1rem 0.7rem 2.5rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            width: 300px;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #7CB342;
        }

        .search-box i {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            color: #1a365d;
            font-weight: 600;
        }

        tr:hover {
            background: #f8f9fa;
        }

        /* Forms */
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-top: 1.5rem;
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #7CB342;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 0;
            width: 90%;
            max-width: 600px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            background: #1a365d;
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .modal-close:hover {
            background: rgba(255,255,255,0.1);
        }

        .modal-body {
            padding: 2rem;
        }

        /* Charts Container */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .chart-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .chart-card h4 {
            color: #1a365d;
            margin-bottom: 1rem;
        }

        /* Badge */
        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-danger { background: #f8d7da; color: #721c24; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                padding: 1rem;
            }

            .content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-box input {
                width: 100%;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .table-actions {
                justify-content: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .charts-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
            <li><a href="#" class="menu-link active" data-section="dashboard"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li><a href="#" class="menu-link" data-section="joueurs"><i class="fas fa-users"></i><span>Joueurs</span></a></li>
            <li><a href="#" class="menu-link" data-section="categories"><i class="fas fa-tags"></i><span>Catégories</span></a></li>
            <li><a href="#" class="menu-link" data-section="posts"><i class="fas fa-newspaper"></i><span>Actualités</span></a></li>
            <li><a href="#" class="menu-link" data-section="type-posts"><i class="fas fa-list"></i><span>Types de Posts</span></a></li>
            <li><a href="#" class="menu-link" data-section="competitions"><i class="fas fa-trophy"></i><span>Compétitions</span></a></li>
            <li><a href="#" class="menu-link" data-section="statistiques"><i class="fas fa-chart-bar"></i><span>Statistiques</span></a></li>
            <li><a href="#" class="menu-link" data-section="settings"><i class="fas fa-cog"></i><span>Paramètres</span></a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
            <div class="header-title">
                <h1 id="pageTitle">Dashboard</h1>
            </div>
            <div class="header-actions">
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span>Administrateur</span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <!-- Dashboard Section -->
            <section class="content-section active" id="dashboard">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalJoueurs">125</h3>
                            <p>Total Joueurs</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalCategories">8</h3>
                            <p>Catégories</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalPosts">24</h3>
                            <p>Articles Publiés</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="totalCompetitions">15</h3>
                            <p>Compétitions</p>
                        </div>
                    </div>
                </div>

                <div class="charts-container">
                    <div class="chart-card">
                        <h4>Évolution des inscriptions</h4>
                        <div style="height: 200px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #666;">
                            <i class="fas fa-chart-line" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <div class="chart-card">
                        <h4>Répartition par catégorie</h4>
                        <div style="height: 200px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #666;">
                            <i class="fas fa-chart-pie" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Joueurs Section -->
            <section class="content-section" id="joueurs">
                <div class="table-container">
                    <div class="table-header">
                        <h3>Gestion des Joueurs</h3>
                        <div class="table-actions">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Rechercher un joueur..." id="searchJoueurs">
                            </div>
                            <button class="btn btn-primary" onclick="showAddJoueurForm()">
                                <i class="fas fa-plus"></i> Ajouter Joueur
                            </button>
                        </div>
                    </div>
                    <div style="overflow-x: auto;">
                        <table id="joueursTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom Complet</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Catégorie</th>
                                    <th>Date Inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="joueursTableBody">
                                <!-- Les données seront ajoutées dynamiquement -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Form Add/Edit Joueur -->
                <div class="form-container" id="joueurForm">
                    <h3 id="joueurFormTitle">Ajouter un Joueur</h3>
                    <form id="joueurFormElement">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="joueurNom">Nom *</label>
                                <input type="text" id="joueurNom" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="joueurPrenom">Prénom *</label>
                                <input type="text" id="joueurPrenom" name="prenom" required>
                            </div>
                            <div class="form-group">
                                <label for="joueurEmail">Email</label>
                                <input type="email" id="joueurEmail" name="email">
                            </div>
                            <div class="form-group">
                                <label for="joueurTelephone">Téléphone</label>
                                <input type="tel" id="joueurTelephone" name="telephone">
                            </div>
                            <div class="form-group">
                                <label for="joueurDateNaissance">Date de Naissance</label>
                                <input type="date" id="joueurDateNaissance" name="date_naissance">
                            </div>
                            <div class="form-group">
                                <label for="joueurSexe">Sexe</label>
                                <select id="joueurSexe" name="sexe">
                                    <option value="">Choisir...</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="joueurLieuNaissance">Lieu de Naissance</label>
                                <input type="text" id="joueurLieuNaissance" name="lieu_naissance">
                            </div>
                            <div class="form-group">
                                <label for="joueurColline">Colline/Quartier *</label>
                                <select id="joueurColline" name="colline_id" required>
                                    <option value="">Choisir...</option>
                                    <option value="1">Bujumbura Mairie</option>
                                    <option value="2">Mukaza</option>
                                    <option value="3">Muha</option>
                                    <option value="4">Ntahangwa</option>
                                    <option value="5">Rohero</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="joueurCategorie">Catégorie *</label>
                                <select id="joueurCategorie" name="categorie_id" required>
                                    <option value="">Choisir...</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hideJoueurForm()">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Categories Section -->
            <section class="content-section" id="categories">
                <div class="table-container">
                    <div class="table-header">
                        <h3>Gestion des Catégories</h3>
                        <div class="table-actions">
                            <button class="btn btn-primary" onclick="showAddCategoryForm()">
                                <i class="fas fa-plus"></i> Ajouter Catégorie
                            </button>
                        </div>
                    </div>
                    <table id="categoriesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Date Création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody">
                            <!-- Les données seront ajoutées dynamiquement -->
                        </tbody>
                    </table>
                </div>

                <!-- Form Add/Edit Category -->
                <div class="form-container" id="categoryForm">
                    <h3 id="categoryFormTitle">Ajouter une Catégorie</h3>
                    <form id="categoryFormElement">
                        <div class="form-group">
                            <label for="categoryNom">Nom *</label>
                            <input type="text" id="categoryNom" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Description</label>
                            <textarea id="categoryDescription" name="description"></textarea>
                        </div>
                        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hideCategoryForm()">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Posts Section -->
            <section class="content-section" id="posts">
                <div class="table-container">
                    <div class="table-header">
                        <h3>Gestion des Actualités</h3>
                        <div class="table-actions">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Rechercher un article..." id="searchPosts">
                            </div>
                            <button class="btn btn-primary" onclick="showAddPostForm()">
                                <i class="fas fa-plus"></i> Nouvel Article
                            </button>
                        </div>
                    </div>
                    <table id="postsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Type</th>
                                <th>Auteur</th>
                                <th>Date Publication</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="postsTableBody">
                            <!-- Les données seront ajoutées dynamiquement -->
                        </tbody>
                    </table>
                </div>

                <!-- Form Add/Edit Post -->
                <div class="form-container" id="postForm">
                    <h3 id="postFormTitle">Créer un Article</h3>
                    <form id="postFormElement">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="postTitre">Titre *</label>
                                <input type="text" id="postTitre" name="titre" required>
                            </div>
                            <div class="form-group">
                                <label for="postType">Type de Post *</label>
                                <select id="postType" name="typepost_id" required>
                                    <option value="">Choisir...</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postContenu">Contenu *</label>
                            <textarea id="postContenu" name="contenu" required style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="postLieuEvenement">Lieu de l'Événement</label>
                                <input type="text" id="postLieuEvenement" name="lieu_evenement">
                            </div>
                            <div class="form-group">
                                <label for="postNiveauCompetition">Niveau de Compétition</label>
                                <select id="postNiveauCompetition" name="niveau_competition">
                                    <option value="">Choisir...</option>
                                    <option value="Local">Local</option>
                                    <option value="Régional">Régional</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="postDateDebutEvenement">Date Début Événement</label>
                                <input type="datetime-local" id="postDateDebutEvenement" name="date_evenement_debut">
                            </div>
                            <div class="form-group">
                                <label for="postDateFinEvenement">Date Fin Événement</label>
                                <input type="datetime-local" id="postDateFinEvenement" name="date_evenement_fin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postResultats">Résultats</label>
                            <textarea id="postResultats" name="resultats"></textarea>
                        </div>
                        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Publier
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hidePostForm()">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Type Posts Section -->
            <section class="content-section" id="type-posts">
                <div class="table-container">
                    <div class="table-header">
                        <h3>Types de Posts</h3>
                        <div class="table-actions">
                            <button class="btn btn-primary" onclick="showAddTypePostForm()">
                                <i class="fas fa-plus"></i> Nouveau Type
                            </button>
                        </div>
                    </div>
                    <table id="typePostsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Date Création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="typePostsTableBody">
                            <!-- Les données seront ajoutées dynamiquement -->
                        </tbody>
                    </table>
                </div>

                <!-- Form Add/Edit Type Post -->
                <div class="form-container" id="typePostForm">
                    <h3 id="typePostFormTitle">Ajouter un Type de Post</h3>
                    <form id="typePostFormElement">
                        <div class="form-group">
                            <label for="typePostNom">Nom *</label>
                            <input type="text" id="typePostNom" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label for="typePostDescription">Description</label>
                            <textarea id="typePostDescription" name="description"></textarea>
                        </div>
                        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hideTypePostForm()">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirmation</h3>
                <button class="modal-close" onclick="closeModal('confirmModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem;">
                    <button class="btn btn-danger" id="confirmButton">Confirmer</button>
                    <button class="btn btn-secondary" onclick="closeModal('confirmModal')">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global Data Storage
        let joueurs = [];
        let categories = [];
        let posts = [];
        let typePosts = [];
        let editingId = null;
        let editingType = null;

        // Initialize Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeData();
            setupEventListeners();
            loadDashboard();
        });

        // Initialize Sample Data
        function initializeData() {
            // Sample Categories
            categories = [
                { id: 1, nom: 'Minimes -60kg', description: 'Catégorie minimes poids légers', created_at: '2025-01-01' },
                { id: 2, nom: 'Minimes -66kg', description: 'Catégorie minimes poids moyens', created_at: '2025-01-02' },
                { id: 3, nom: 'Cadets -73kg', description: 'Catégorie cadets poids moyens', created_at: '2025-01-03' },
                { id: 4, nom: 'Juniors -81kg', description: 'Catégorie juniors poids lourds', created_at: '2025-01-04' }
            ];

            // Sample Type Posts
            typePosts = [
                { id: 1, nom: 'Actualité', description: 'Actualités générales', created_at: '2025-01-01' },
                { id: 2, nom: 'Compétition', description: 'Annonces de compétitions', created_at: '2025-01-02' },
                { id: 3, nom: 'Résultats', description: 'Résultats de compétitions', created_at: '2025-01-03' },
                { id: 4, nom: 'Formation', description: 'Formations et stages', created_at: '2025-01-04' }
            ];

            // Sample Joueurs
            joueurs = [
                { id: 1, nom: 'Ndayisenga', prenom: 'Jean', email: 'jean@example.com', telephone: '+257 79 123 456', categorie_id: 1, colline_id: 1, date_naissance: '2005-05-15', sexe: 'M', lieu_naissance: 'Bujumbura', created_at: '2025-01-15' },
                { id: 2, nom: 'Uwimana', prenom: 'Marie', email: 'marie@example.com', telephone: '+257 79 234 567', categorie_id: 2, colline_id: 2, date_naissance: '2004-08-22', sexe: 'F', lieu_naissance: 'Gitega', created_at: '2025-01-16' },
                { id: 3, nom: 'Niyongabo', prenom: 'Paul', email: 'paul@example.com', telephone: '+257 79 345 678', categorie_id: 3, colline_id: 3, date_naissance: '2003-03-10', sexe: 'M', lieu_naissance: 'Ngozi', created_at: '2025-01-17' }
            ];

            // Sample Posts
            posts = [
                { id: 1, titre: 'Championnat National de Judo 2025', contenu: 'Annonce du championnat national qui aura lieu le mois prochain...', typepost_id: 2, user_id: 1, date_post: '2025-01-15', lieu_evenement: 'Stade Prince Louis Rwagasore', niveau_competition: 'National', date_evenement_debut: '2025-02-15 09:00', date_evenement_fin: '2025-02-16 18:00', resultats: null },
                { id: 2, titre: 'Stage de Formation avec Maître Tanaka', contenu: 'Un stage exceptionnel avec le maître japonais Hiroshi Tanaka...', typepost_id: 4, user_id: 1, date_post: '2025-01-10', lieu_evenement: 'Dojo Central Bujumbura', niveau_competition: null, date_evenement_debut: '2025-02-01 08:00', date_evenement_fin: '2025-02-03 17:00', resultats: null }
            ];

            updateStats();
        }

        // Setup Event Listeners
        function setupEventListeners() {
            // Menu navigation
            document.querySelectorAll('.menu-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const section = this.dataset.section;
                    showSection(section);
                    
                    // Update active menu item
                    document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update page title
                    const titles = {
                        'dashboard': 'Dashboard',
                        'joueurs': 'Gestion des Joueurs',
                        'categories': 'Gestion des Catégories',
                        'posts': 'Gestion des Actualités',
                        'type-posts': 'Types de Posts',
                        'competitions': 'Compétitions',
                        'statistiques': 'Statistiques',
                        'settings': 'Paramètres'
                    };
                    document.getElementById('pageTitle').textContent = titles[section] || 'Dashboard';
                });
            });

            // Form submissions
            document.getElementById('joueurFormElement').addEventListener('submit', handleJoueurSubmit);
            document.getElementById('categoryFormElement').addEventListener('submit', handleCategorySubmit);
            document.getElementById('postFormElement').addEventListener('submit', handlePostSubmit);
            document.getElementById('typePostFormElement').addEventListener('submit', handleTypePostSubmit);

            // Search functionality
            document.getElementById('searchJoueurs')?.addEventListener('input', function() {
                filterTable('joueursTableBody', this.value, ['nom', 'prenom', 'email']);
            });
            
            document.getElementById('searchPosts')?.addEventListener('input', function() {
                filterTable('postsTableBody', this.value, ['titre', 'contenu']);
            });
        }

        // Show Section
        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            
            // Show target section
            document.getElementById(section)?.classList.add('active');

            // Load section data
            switch(section) {
                case 'joueurs':
                    loadJoueurs();
                    break;
                case 'categories':
                    loadCategories();
                    break;
                case 'posts':
                    loadPosts();
                    break;
                case 'type-posts':
                    loadTypePosts();
                    break;
            }
        }

        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Update Statistics
        function updateStats() {
            document.getElementById('totalJoueurs').textContent = joueurs.length;
            document.getElementById('totalCategories').textContent = categories.length;
            document.getElementById('totalPosts').textContent = posts.length;
            document.getElementById('totalCompetitions').textContent = posts.filter(p => typePosts.find(tp => tp.id === p.typepost_id)?.nom === 'Compétition').length;
        }

        // Load Dashboard
        function loadDashboard() {
            updateStats();
        }

        // JOUEURS MANAGEMENT
        function loadJoueurs() {
            const tbody = document.getElementById('joueursTableBody');
            tbody.innerHTML = '';

            // Populate category select
            const categorySelect = document.getElementById('joueurCategorie');
            categorySelect.innerHTML = '<option value="">Choisir...</option>';
            categories.forEach(cat => {
                categorySelect.innerHTML += `<option value="${cat.id}">${cat.nom}</option>`;
            });

            joueurs.forEach(joueur => {
                const category = categories.find(c => c.id === joueur.categorie_id);
                const row = `
                    <tr>
                        <td>${joueur.id}</td>
                        <td>${joueur.prenom} ${joueur.nom}</td>
                        <td>${joueur.email || '-'}</td>
                        <td>${joueur.telephone || '-'}</td>
                        <td><span class="badge badge-info">${category ? category.nom : '-'}</span></td>
                        <td>${new Date(joueur.created_at).toLocaleDateString('fr-FR')}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editJoueur(${joueur.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteJoueur(${joueur.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function showAddJoueurForm() {
            editingId = null;
            editingType = 'joueur';
            document.getElementById('joueurFormTitle').textContent = 'Ajouter un Joueur';
            document.getElementById('joueurFormElement').reset();
            document.getElementById('joueurForm').classList.add('active');
        }

        function hideJoueurForm() {
            document.getElementById('joueurForm').classList.remove('active');
        }

        function editJoueur(id) {
            const joueur = joueurs.find(j => j.id === id);
            if (!joueur) return;

            editingId = id;
            editingType = 'joueur';
            
            document.getElementById('joueurFormTitle').textContent = 'Modifier le Joueur';
            document.getElementById('joueurNom').value = joueur.nom;
            document.getElementById('joueurPrenom').value = joueur.prenom;
            document.getElementById('joueurEmail').value = joueur.email || '';
            document.getElementById('joueurTelephone').value = joueur.telephone || '';
            document.getElementById('joueurDateNaissance').value = joueur.date_naissance || '';
            document.getElementById('joueurSexe').value = joueur.sexe || '';
            document.getElementById('joueurLieuNaissance').value = joueur.lieu_naissance || '';
            document.getElementById('joueurColline').value = joueur.colline_id || '';
            document.getElementById('joueurCategorie').value = joueur.categorie_id || '';
            
            document.getElementById('joueurForm').classList.add('active');
        }

        function deleteJoueur(id) {
            showConfirmModal('Êtes-vous sûr de vouloir supprimer ce joueur ?', () => {
                joueurs = joueurs.filter(j => j.id !== id);
                loadJoueurs();
                updateStats();
                closeModal('confirmModal');
            });
        }

        function handleJoueurSubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            if (editingId) {
                // Update existing joueur
                const index = joueurs.findIndex(j => j.id === editingId);
                if (index !== -1) {
                    joueurs[index] = { ...joueurs[index], ...data, id: editingId };
                }
            } else {
                // Add new joueur
                const newJoueur = {
                    ...data,
                    id: Math.max(...joueurs.map(j => j.id), 0) + 1,
                    created_at: new Date().toISOString().split('T')[0],
                    colline_id: parseInt(data.colline_id),
                    categorie_id: parseInt(data.categorie_id)
                };
                joueurs.push(newJoueur);
            }
            
            hideJoueurForm();
            loadJoueurs();
            updateStats();
        }

        // CATEGORIES MANAGEMENT
        function loadCategories() {
            const tbody = document.getElementById('categoriesTableBody');
            tbody.innerHTML = '';

            categories.forEach(category => {
                const row = `
                    <tr>
                        <td>${category.id}</td>
                        <td>${category.nom}</td>
                        <td>${category.description || '-'}</td>
                        <td>${new Date(category.created_at).toLocaleDateString('fr-FR')}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editCategory(${category.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteCategory(${category.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function showAddCategoryForm() {
            editingId = null;
            editingType = 'category';
            document.getElementById('categoryFormTitle').textContent = 'Ajouter une Catégorie';
            document.getElementById('categoryFormElement').reset();
            document.getElementById('categoryForm').classList.add('active');
        }

        function hideCategoryForm() {
            document.getElementById('categoryForm').classList.remove('active');
        }

        function editCategory(id) {
            const category = categories.find(c => c.id === id);
            if (!category) return;

            editingId = id;
            editingType = 'category';
            
            document.getElementById('categoryFormTitle').textContent = 'Modifier la Catégorie';
            document.getElementById('categoryNom').value = category.nom;
            document.getElementById('categoryDescription').value = category.description || '';
            
            document.getElementById('categoryForm').classList.add('active');
        }

        function deleteCategory(id) {
            showConfirmModal('Êtes-vous sûr de vouloir supprimer cette catégorie ?', () => {
                categories = categories.filter(c => c.id !== id);
                loadCategories();
                updateStats();
                closeModal('confirmModal');
            });
        }

        function handleCategorySubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            if (editingId) {
                // Update existing category
                const index = categories.findIndex(c => c.id === editingId);
                if (index !== -1) {
                    categories[index] = { ...categories[index], ...data, id: editingId };
                }
            } else {
                // Add new category
                const newCategory = {
                    ...data,
                    id: Math.max(...categories.map(c => c.id), 0) + 1,
                    created_at: new Date().toISOString().split('T')[0]
                };
                categories.push(newCategory);
            }
            
            hideCategoryForm();
            loadCategories();
            updateStats();
        }

        // POSTS MANAGEMENT
        function loadPosts() {
            const tbody = document.getElementById('postsTableBody');
            tbody.innerHTML = '';

            // Populate type post select
            const typeSelect = document.getElementById('postType');
            typeSelect.innerHTML = '<option value="">Choisir...</option>';
            typePosts.forEach(type => {
                typeSelect.innerHTML += `<option value="${type.id}">${type.nom}</option>`;
            });

            posts.forEach(post => {
                const typePost = typePosts.find(tp => tp.id === post.typepost_id);
                const row = `
                    <tr>
                        <td>${post.id}</td>
                        <td>${post.titre}</td>
                        <td><span class="badge badge-info">${typePost ? typePost.nom : '-'}</span></td>
                        <td>Admin</td>
                        <td>${new Date(post.date_post).toLocaleDateString('fr-FR')}</td>
                        <td><span class="badge badge-success">Publié</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editPost(${post.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deletePost(${post.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function showAddPostForm() {
            editingId = null;
            editingType = 'post';
            document.getElementById('postFormTitle').textContent = 'Créer un Article';
            document.getElementById('postFormElement').reset();
            document.getElementById('postForm').classList.add('active');
        }

        function hidePostForm() {
            document.getElementById('postForm').classList.remove('active');
        }

        function editPost(id) {
            const post = posts.find(p => p.id === id);
            if (!post) return;

            editingId = id;
            editingType = 'post';
            
            document.getElementById('postFormTitle').textContent = 'Modifier l\'Article';
            document.getElementById('postTitre').value = post.titre;
            document.getElementById('postType').value = post.typepost_id;
            document.getElementById('postContenu').value = post.contenu;
            document.getElementById('postLieuEvenement').value = post.lieu_evenement || '';
            document.getElementById('postNiveauCompetition').value = post.niveau_competition || '';
            document.getElementById('postDateDebutEvenement').value = post.date_evenement_debut || '';
            document.getElementById('postDateFinEvenement').value = post.date_evenement_fin || '';
            document.getElementById('postResultats').value = post.resultats || '';
            
            document.getElementById('postForm').classList.add('active');
        }

        function deletePost(id) {
            showConfirmModal('Êtes-vous sûr de vouloir supprimer cet article ?', () => {
                posts = posts.filter(p => p.id !== id);
                loadPosts();
                updateStats();
                closeModal('confirmModal');
            });
        }

        function handlePostSubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            if (editingId) {
                // Update existing post
                const index = posts.findIndex(p => p.id === editingId);
                if (index !== -1) {
                    posts[index] = { ...posts[index], ...data, id: editingId };
                }
            } else {
                // Add new post
                const newPost = {
                    ...data,
                    id: Math.max(...posts.map(p => p.id), 0) + 1,
                    date_post: new Date().toISOString().split('T')[0],
                    user_id: 1,
                    typepost_id: parseInt(data.typepost_id)
                };
                posts.push(newPost);
            }
            
            hidePostForm();
            loadPosts();
            updateStats();
        }

        // TYPE POSTS MANAGEMENT
        function loadTypePosts() {
            const tbody = document.getElementById('typePostsTableBody');
            tbody.innerHTML = '';

            typePosts.forEach(typePost => {
                const row = `
                    <tr>
                        <td>${typePost.id}</td>
                        <td>${typePost.nom}</td>
                        <td>${typePost.description || '-'}</td>
                        <td>${new Date(typePost.created_at).toLocaleDateString('fr-FR')}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editTypePost(${typePost.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteTypePost(${typePost.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function showAddTypePostForm() {
            editingId = null;
            editingType = 'typePost';
            document.getElementById('typePostFormTitle').textContent = 'Ajouter un Type de Post';
            document.getElementById('typePostFormElement').reset();
            document.getElementById('typePostForm').classList.add('active');
        }

        function hideTypePostForm() {
            document.getElementById('typePostForm').classList.remove('active');
        }

        function editTypePost(id) {
            const typePost = typePosts.find(tp => tp.id === id);
            if (!typePost) return;

            editingId = id;
            editingType = 'typePost';
            
            document.getElementById('typePostFormTitle').textContent = 'Modifier le Type de Post';
            document.getElementById('typePostNom').value = typePost.nom;
            document.getElementById('typePostDescription').value = typePost.description || '';
            
            document.getElementById('typePostForm').classList.add('active');
        }

        function deleteTypePost(id) {
            showConfirmModal('Êtes-vous sûr de vouloir supprimer ce type de post ?', () => {
                typePosts = typePosts.filter(tp => tp.id !== id);
                loadTypePosts();
                closeModal('confirmModal');
            });
        }

        function handleTypePostSubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            if (editingId) {
                // Update existing type post
                const index = typePosts.findIndex(tp => tp.id === editingId);
                if (index !== -1) {
                    typePosts[index] = { ...typePosts[index], ...data, id: editingId };
                }
            } else {
                // Add new type post
                const newTypePost = {
                    ...data,
                    id: Math.max(...typePosts.map(tp => tp.id), 0) + 1,
                    created_at: new Date().toISOString().split('T')[0]
                };
                typePosts.push(newTypePost);
            }
            
            hideTypePostForm();
            loadTypePosts();
        }

        // UTILITY FUNCTIONS
        function showConfirmModal(message, onConfirm) {
            document.getElementById('confirmMessage').textContent = message;
            document.getElementById('confirmButton').onclick = onConfirm;
            document.getElementById('confirmModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function filterTable(tableBodyId, searchTerm, columns) {
            const rows = document.querySelectorAll(`#${tableBodyId} tr`);
            const term = searchTerm.toLowerCase();
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => 
                    cell.textContent.toLowerCase().includes(term)
                );
                row.style.display = match ? '' : 'none';
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>