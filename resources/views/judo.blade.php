<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martial Arts Academy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #7CB342;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #7CB342;
        }

        .cta-button {
            background: #7CB342;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
        }

        .cta-button:hover {
            background: #689F3A;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #1a365d 0%, #2d5a87 100%);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #7CB342;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #689F3A;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 1rem 2rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: white;
            color: #1a365d;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #7CB342;
            color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Welcome Section */
        .welcome {
            padding: 80px 0;
        }

        .welcome-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .welcome-text h2 {
            font-size: 2.5rem;
            color: #1a365d;
            margin-bottom: 1rem;
        }

        .welcome-text p {
            margin-bottom: 1rem;
            color: #666;
        }

        .welcome-image {
            position: relative;
        }

        .welcome-image img {
            width: 100%;
            border-radius: 10px;
        }

        /* Instructors Section */
        .instructors {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #1a365d;
            margin-bottom: 1rem;
        }

        .instructors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .instructor-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .instructor-card:hover {
            transform: translateY(-5px);
        }

        .instructor-image {
            height: 300px;
            background: #ddd;
            position: relative;
        }

        .instructor-info {
            padding: 1.5rem;
            text-align: center;
        }

        .instructor-info h3 {
            color: #1a365d;
            margin-bottom: 0.5rem;
        }

        .instructor-info p {
            color: #7CB342;
            font-weight: 500;
        }

        /* Stats Section */
        .stats {
            padding: 80px 0;
            background: #7CB342;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        /* Gallery Section */
        .gallery {
            padding: 80px 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            height: 250px;
            background: #ddd;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .gallery-item:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(124, 179, 66, 0.8);
        }

        /* News Section */
        .news {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .news-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .news-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .news-image {
            height: 200px;
            background: linear-gradient(135deg, #7CB342, #689F3A);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .news-image i {
            font-size: 3rem;
            color: white;
            opacity: 0.7;
        }

        .news-content {
            padding: 1.5rem;
        }

        .news-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
        }

        .news-date {
            background: #7CB342;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .news-category {
            color: #7CB342;
            font-weight: 500;
        }

        .news-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a365d;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .news-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .news-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #888;
        }

        .read-more {
            background: none;
            border: 2px solid #7CB342;
            color: #7CB342;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .read-more:hover {
            background: #7CB342;
            color: white;
        }

        /* Add Post Form */
        .add-post-form {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
            display: none;
        }

        .add-post-form.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .add-post-form h3 {
            color: #1a365d;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
            resize: vertical;
            min-height: 100px;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #7CB342;
        }

        .btn-add-post {
            background: #7CB342;
            color: white;
            border: 2px solid #7CB342;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-add-post:hover {
            background: #689F3A;
            border-color: #689F3A;
        }

        .btn-toggle-form {
            background: #1a365d;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-toggle-form:hover {
            background: #2d5a87;
        }

        /* Registration Section */
        .registration {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .registration-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .registration-info h2 {
            font-size: 2.5rem;
            color: #1a365d;
            margin-bottom: 1rem;
        }

        .registration-form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #7CB342;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Footer */
        .footer {
            background: #1a365d;
            color: white;
            padding: 60px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #7CB342;
        }

        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .footer-section a:hover {
            color: #7CB342;
        }

        .footer-bottom {
            border-top: 1px solid #2d5a87;
            padding-top: 1rem;
            text-align: center;
            color: #ccc;
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
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }

        .close:hover {
            color: #333;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .welcome-content {
                grid-template-columns: 1fr;
            }

            .registration-container {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .news-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .news-grid {
                grid-template-columns: 1fr;
            }

            .add-post-form {
                padding: 1rem;
            }

            .btn-toggle-form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">Martial Arts</div>
                <ul class="nav-links">
                    <li><a href="#home">Accueil</a></li>
                    <li><a href="#about">À propos</a></li>
                    <li><a href="#instructors">Instructeurs</a></li>
                    <li><a href="#gallery">Galerie</a></li>
                    <li><a href="#news">Actualités</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <button class="cta-button" onclick="openModal()">S'inscrire</button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>ENTRAÎNEZ-VOUS AVEC LES MEILLEURS</h1>
            <p>Découvrez l'art martial traditionnel avec nos instructeurs légendaires</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <button class="btn-secondary">En savoir plus</button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-fist-raised"></i>
                    <h3>Techniques Expertes</h3>
                    <p>Apprenez les techniques authentiques avec nos maîtres expérimentés</p>
                    <button class="btn-secondary">Découvrir</button>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h3>Communauté</h3>
                    <p>Rejoignez une communauté passionnée et bienveillante</p>
                    <button class="btn-secondary">Rejoindre</button>
                </div>
                <div class="feature-card">
                    <i class="fas fa-trophy"></i>
                    <h3>Compétitions</h3>
                    <p>Participez à des compétitions locales et nationales</p>
                    <button class="btn-secondary">Participer</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome" id="about">
        <div class="container">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h2>Bienvenue dans notre Académie</h2>
                    <p>Notre académie d'arts martiaux offre un enseignement de qualité supérieure dans un environnement respectueux et discipliné. Nous accueillons tous les niveaux, des débutants aux avancés.</p>
                    <p>Avec plus de 20 ans d'expérience, nos instructeurs vous guideront dans votre parcours martial, que ce soit pour la self-défense, la compétition ou le développement personnel.</p>
                    <button class="btn-primary" onclick="openModal()">Rejoignez-nous</button>
                </div>
                <div class="welcome-image">
                    <div style="height: 400px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 4rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instructors Section -->
    <section class="instructors" id="instructors">
        <div class="container">
            <div class="section-title">
                <h2>Nos Instructeurs</h2>
                <p>Rencontrez nos maîtres expérimentés</p>
            </div>
            <div class="instructors-grid">
                <div class="instructor-card">
                    <div class="instructor-image">
                        <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                            <i class="fas fa-user" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <div class="instructor-info">
                        <h3>Maître Karim</h3>
                        <p>Expert en Karaté</p>
                    </div>
                </div>
                <div class="instructor-card">
                    <div class="instructor-image">
                        <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                            <i class="fas fa-user" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <div class="instructor-info">
                        <h3>Maître Sarah</h3>
                        <p>Experte en Taekwondo</p>
                    </div>
                </div>
                <div class="instructor-card">
                    <div class="instructor-image">
                        <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                            <i class="fas fa-user" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <div class="instructor-info">
                        <h3>Maître Jean</h3>
                        <p>Expert en Judo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Élèves formés</p>
                </div>
                <div class="stat-item">
                    <h3>15+</h3>
                    <p>Années d'expérience</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Compétitions gagnées</p>
                </div>
                <div class="stat-item">
                    <h3>10+</h3>
                    <p>Instructeurs certifiés</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-title">
                <h2>Galerie Photos</h2>
                <p>Découvrez notre académie en images</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- News Section -->
    <section class="news" id="news">
        <div class="container">
            <div class="news-header">
                <div class="section-title" style="text-align: left; margin-bottom: 0;">
                    <h2>Actualités</h2>
                    <p>Restez informés de toutes nos actualités</p>
                </div>
                <button class="btn-toggle-form" onclick="toggleAddPostForm()">
                    <i class="fas fa-plus"></i> Ajouter un article
                </button>
            </div>

            <!-- Add Post Form -->
            <div id="addPostForm" class="add-post-form">
                <h3><i class="fas fa-edit"></i> Publier un nouvel article</h3>
                <form id="postForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="postTitle">Titre de l'article *</label>
                            <input type="text" id="postTitle" name="postTitle" required placeholder="Entrez le titre...">
                        </div>
                        <div class="form-group">
                            <label for="postCategory">Catégorie *</label>
                            <select id="postCategory" name="postCategory" required>
                                <option value="">Choisir...</option>
                                <option value="Compétition">Compétition</option>
                                <option value="Événement">Événement</option>
                                <option value="Formation">Formation</option>
                                <option value="Résultats">Résultats</option>
                                <option value="Annonce">Annonce</option>
                                <option value="Actualités">Actualités</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="postExcerpt">Résumé *</label>
                        <textarea id="postExcerpt" name="postExcerpt" required placeholder="Écrivez un bref résumé de l'article..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="postContent">Contenu complet *</label>
                        <textarea id="postContent" name="postContent" required placeholder="Rédigez le contenu complet de l'article..." style="min-height: 120px;"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="postAuthor">Auteur *</label>
                            <input type="text" id="postAuthor" name="postAuthor" required placeholder="Nom de l'auteur">
                        </div>
                        <div class="form-group">
                            <label for="postDate">Date de publication</label>
                            <input type="date" id="postDate" name="postDate">
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <button type="submit" class="btn-add-post">
                            <i class="fas fa-paper-plane"></i> Publier l'article
                        </button>
                        <button type="button" class="btn-secondary" onclick="toggleAddPostForm()" style="margin-left: 1rem;">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>

            <!-- News Grid -->
            <div id="newsGrid" class="news-grid">
                <div class="news-card">
                    <div class="news-image">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">15 Sep 2025</span>
                            <span class="news-category">Compétition</span>
                        </div>
                        <h3 class="news-title">Championnat National de Karaté 2025</h3>
                        <p class="news-excerpt">Nos élèves ont brillé lors du championnat national avec 15 médailles remportées. Une performance exceptionnelle qui témoigne de la qualité de notre formation.</p>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <span>Maître Karim</span>
                        </div>
                        <button class="read-more" onclick="readMore(this)">Lire plus</button>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-image">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">10 Sep 2025</span>
                            <span class="news-category">Événement</span>
                        </div>
                        <h3 class="news-title">Journée Portes Ouvertes</h3>
                        <p class="news-excerpt">Venez découvrir notre académie lors de notre journée portes ouvertes le 25 septembre. Démonstrations, cours d'essai gratuits et rencontre avec nos instructeurs.</p>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <span>Équipe Martial Arts</span>
                        </div>
                        <button class="read-more" onclick="readMore(this)">Lire plus</button>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-image">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">5 Sep 2025</span>
                            <span class="news-category">Formation</span>
                        </div>
                        <h3 class="news-title">Nouveau Programme pour Enfants</h3>
                        <p class="news-excerpt">Lancement de notre nouveau programme spécialement conçu pour les enfants de 6 à 12 ans. Apprentissage ludique et sécuritaire des arts martiaux.</p>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <span>Maître Sarah</span>
                        </div>
                        <button class="read-more" onclick="readMore(this)">Lire plus</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Section -->
    <section class="registration">
        <div class="container">
            <div class="registration-container">
                <div class="registration-info">
                    <h2>Rejoignez Notre Académie</h2>
                    <p>Inscrivez-vous dès aujourd'hui pour commencer votre parcours martial. Nos programmes sont adaptés à tous les âges et tous les niveaux.</p>
                    
                    <div style="margin: 2rem 0;">
                        <h3 style="color: #7CB342; margin-bottom: 1rem;">Avantages de l'inscription :</h3>
                        <ul style="color: #666; line-height: 2;">
                            <li>Accès illimité aux cours</li>
                            <li>Suivi personnalisé</li>
                            <li>Équipement fourni</li>
                            <li>Participation aux compétitions</li>
                            <li>Certificats officiels</li>
                        </ul>
                    </div>
                    
                    <div style="background: #7CB342; color: white; padding: 1rem; border-radius: 10px; text-align: center;">
                        <h3>Offre spéciale !</h3>
                        <p>Premier mois gratuit pour toute nouvelle inscription</p>
                    </div>
                </div>
                
                <div class="registration-form">
                    <h3 style="margin-bottom: 1.5rem; color: #1a365d;">Formulaire d'inscription</h3>
                    <form id="registrationForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nom">Nom *</label>
                                <input type="text" id="nom" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom *</label>
                                <input type="text" id="prenom" name="prenom" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="date_naissance">Date de naissance</label>
                                <input type="date" id="date_naissance" name="date_naissance">
                            </div>
                            <div class="form-group">
                                <label for="sexe">Sexe</label>
                                <select id="sexe" name="sexe">
                                    <option value="">Choisir...</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="lieu_naissance">Lieu de naissance</label>
                            <input type="text" id="lieu_naissance" name="lieu_naissance">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="telephone">Téléphone</label>
                                <input type="tel" id="telephone" name="telephone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="colline_id">Colline/Quartier *</label>
                                <select id="colline_id" name="colline_id" required>
                                    <option value="">Choisir...</option>
                                    <option value="1">Bujumbura Mairie</option>
                                    <option value="2">Mukaza</option>
                                    <option value="3">Muha</option>
                                    <option value="4">Ntahangwa</option>
                                    <option value="5">Rohero</option>
                                    <option value="6">Nyakabiga</option>
                                    <option value="7">Kinama</option>
                                    <option value="8">Kamenge</option>
                                    <option value="9">Ngagara</option>
                                    <option value="10">Cibitoke</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categorie_id">Catégorie/Discipline *</label>
                                <select id="categorie_id" name="categorie_id" required>
                                    <option value="">Choisir...</option>
                                    <option value="1">Karaté - Débutant</option>
                                    <option value="2">Karaté - Intermédiaire</option>
                                    <option value="3">Karaté - Avancé</option>
                                    <option value="4">Taekwondo - Débutant</option>
                                    <option value="5">Taekwondo - Intermédiaire</option>
                                    <option value="6">Taekwondo - Avancé</option>
                                    <option value="7">Judo - Débutant</option>
                                    <option value="8">Judo - Intermédiaire</option>
                                    <option value="9">Judo - Avancé</option>
                                    <option value="10">Kung Fu - Débutant</option>
                                    <option value="11">Kung Fu - Intermédiaire</option>
                                    <option value="12">Self-Défense</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">
                            <i class="fas fa-user-plus"></i> S'inscrire maintenant
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Martial Arts Academy</h3>
                    <p>Votre partenaire pour un parcours martial d'excellence. Nous formons les champions de demain avec passion et dévouement.</p>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Avenue de l'Indépendance, Bujumbura</p>
                    <p><i class="fas fa-phone"></i> +257 22 123 456</p>
                    <p><i class="fas fa-envelope"></i> info@martialarts-bi.com</p>
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
                    <p><a href="#"><i class="fab fa-youtube"></i> YouTube</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Martial Arts Academy. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="color: #1a365d; margin-bottom: 1rem;">Inscription rapide</h2>
            <p>Remplissez ce formulaire pour commencer votre parcours martial avec nous !</p>
            <button class="btn-primary" onclick="scrollToRegistration()" style="width: 100%; margin-top: 1rem;">
                Aller au formulaire complet
            </button>
        </div>
    </div>

    <script>
        // Modal functionality
        function openModal() {
            document.getElementById('registrationModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('registrationModal').style.display = 'none';
        }

        function scrollToRegistration() {
            closeModal();
            document.querySelector('.registration').scrollIntoView({ behavior: 'smooth' });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('registrationModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // News functionality
        function toggleAddPostForm() {
            const form = document.getElementById('addPostForm');
            form.classList.toggle('active');
            
            // Auto-fill current date
            if (form.classList.contains('active')) {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('postDate').value = today;
            }
        }

        function readMore(button) {
            const card = button.closest('.news-card');
            const title = card.querySelector('.news-title').textContent;
            const content = card.querySelector('.news-excerpt').textContent;
            const author = card.querySelector('.news-author span').textContent;
            const date = card.querySelector('.news-date').textContent;
            
            alert(`Article complet:\n\nTitre: ${title}\nAuteur: ${author}\nDate: ${date}\n\nContenu:\n${content}\n\n(Dans une vraie application, ceci ouvrirait une page détaillée)`);
        }

        // Add new post functionality
        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const postData = {
                title: formData.get('postTitle'),
                category: formData.get('postCategory'),
                excerpt: formData.get('postExcerpt'),
                content: formData.get('postContent'),
                author: formData.get('postAuthor'),
                date: formData.get('postDate') || new Date().toISOString().split('T')[0]
            };
            
            // Create new post card
            const newsGrid = document.getElementById('newsGrid');
            const newCard = document.createElement('div');
            newCard.className = 'news-card';
            
            // Format date
            const dateObj = new Date(postData.date);
            const formattedDate = dateObj.toLocaleDateString('fr-FR', { 
                day: 'numeric', 
                month: 'short', 
                year: 'numeric' 
            });
            
            // Select icon based on category
            const categoryIcons = {
                'Compétition': 'fas fa-trophy',
                'Événement': 'fas fa-calendar-alt',
                'Formation': 'fas fa-graduation-cap',
                'Résultats': 'fas fa-chart-line',
                'Annonce': 'fas fa-bullhorn',
                'Actualités': 'fas fa-newspaper'
            };
            
            const icon = categoryIcons[postData.category] || 'fas fa-newspaper';
            
            newCard.innerHTML = `
                <div class="news-image">
                    <i class="${icon}"></i>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">${formattedDate}</span>
                        <span class="news-category">${postData.category}</span>
                    </div>
                    <h3 class="news-title">${postData.title}</h3>
                    <p class="news-excerpt">${postData.excerpt}</p>
                    <div class="news-author">
                        <i class="fas fa-user"></i>
                        <span>${postData.author}</span>
                    </div>
                    <button class="read-more" onclick="readMore(this)">Lire plus</button>
                </div>
            `;
            
            // Add animation for new post
            newCard.style.opacity = '0';
            newCard.style.transform = 'translateY(20px)';
            
            // Insert at the beginning
            newsGrid.insertBefore(newCard, newsGrid.firstChild);
            
            // Animate in
            setTimeout(() => {
                newCard.style.transition = 'all 0.5s ease';
                newCard.style.opacity = '1';
                newCard.style.transform = 'translateY(0)';
            }, 100);
            
            // Store the full content in a data attribute for the read more function
            newCard.querySelector('.news-excerpt').setAttribute('data-full-content', postData.content);
            
            // Show success message
            alert('Article publié avec succès !');
            
            // Reset form and hide it
            this.reset();
            toggleAddPostForm();
            
            // Scroll to the new post
            setTimeout(() => {
                newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 600);
        });

        // Enhanced read more function to show full content
        function readMore(button) {
            const card = button.closest('.news-card');
            const title = card.querySelector('.news-title').textContent;
            const excerpt = card.querySelector('.news-excerpt');
            const fullContent = excerpt.getAttribute('data-full-content') || excerpt.textContent;
            const author = card.querySelector('.news-author span').textContent;
            const date = card.querySelector('.news-date').textContent;
            const category = card.querySelector('.news-category').textContent;
            
            // Create a modal-like display for the full article
            const articleModal = document.createElement('div');
            articleModal.className = 'modal';
            articleModal.style.display = 'block';
            articleModal.innerHTML = `
                <div class="modal-content" style="max-width: 600px; max-height: 80vh; overflow-y: auto;">
                    <span class="close" onclick="this.closest('.modal').remove()">&times;</span>
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <span style="background: #7CB342; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">${date}</span>
                        <span style="color: #7CB342; font-weight: 500; margin-left: 1rem;">${category}</span>
                    </div>
                    <h2 style="color: #1a365d; margin-bottom: 1rem; text-align: center;">${title}</h2>
                    <div style="text-align: center; margin-bottom: 1.5rem; color: #666;">
                        <i class="fas fa-user"></i> Par ${author}
                    </div>
                    <div style="line-height: 1.8; color: #333; text-align: justify;">
                        ${fullContent.split('\n').map(p => `<p style="margin-bottom: 1rem;">${p}</p>`).join('')}
                    </div>
                </div>
            `;
            
            document.body.appendChild(articleModal);
            
            // Close modal when clicking outside
            articleModal.addEventListener('click', function(e) {
                if (e.target === articleModal) {
                    articleModal.remove();
                }
            });
        }

        // Form submission
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simulate form submission
            console.log('Données d\'inscription:', data);
            
            // Show success message
            alert('Inscription envoyée avec succès ! Nous vous contacterons bientôt.');
            
            // Reset form
            this.reset();
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = '#fff';
                header.style.backdropFilter = 'none';
            }
        });
    </script>
</body>
</html>