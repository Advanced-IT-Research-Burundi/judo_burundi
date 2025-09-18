@extends('layouts.user')
@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>ENTRAÎNEZ-VOUS AVEC LES MEILLEURS</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
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
                    <p>Notre académie d'arts martiaux offre un enseignement de qualité supérieure dans un environnement
                        respectueux et discipliné. Nous accueillons tous les niveaux, des débutants aux avancés.</p>
                    <p>Avec plus de 20 ans d'expérience, nos instructeurs vous guideront dans votre parcours martial, que ce
                        soit pour la self-défense, la compétition ou le développement personnel.</p>
                    <button class="btn-primary" onclick="openModal()">Rejoignez-nous</button>
                </div>
                <div class="welcome-image">
                    <div
                        style="height: 400px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 4rem;"></i> --}}
                        <img src="/images/judo2.jpg" alt="Welcome Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Instructors Section -->
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
    </section> --}}

    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-title">
                <h2>Galerie Photos</h2>
                <p>Découvrez notre académie en images</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo3.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo4.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo5.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">

                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judo6.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">

                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judoimage1.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
                <div class="gallery-item">
                    <div
                        style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                        {{-- <i class="fas fa-image" style="font-size: 2rem;"></i> --}}
                        <img src="/images/judoimage1.jpg" alt="Gallery Image"
                            style="height: 100%; width: auto; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news" id="news">
        <div class="container">
            <div class="news-header">
                <div class="section-title" style="text-align: left; margin-bottom: 0;">
                    <h2>Actualités</h2>
                    <p>Restez informés de toutes nos actualités</p>
                </div>
                {{-- <button class="btn-toggle-form" onclick="toggleAddPostForm()">
                    <i class="fas fa-plus"></i> Ajouter un article
                </button> --}}
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
                        <textarea id="postContent" name="postContent" required placeholder="Rédigez le contenu complet de l'article..."
                            style="min-height: 120px;"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="postAuthor">Auteur *</label>
                            <input type="text" id="postAuthor" name="postAuthor" required
                                placeholder="Nom de l'auteur">
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
                        <button type="button" class="btn-secondary" onclick="toggleAddPostForm()"
                            style="margin-left: 1rem;">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>

            <!-- News Grid -->
            <div id="newsGrid" class="news-grid">
                <div class="news-card">
                    <div class="news-image">
                        {{-- <i class="fas fa-trophy"></i> --}}
                        <img src="/images/judo3.jpg" alt="News Image"
                            style="height: 120%; width: auto; border-radius: 10px;">
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">15 Sep 2025</span>
                            <span class="news-category">Compétition</span>
                        </div>
                        <h3 class="news-title">Championnat National de Karaté 2025</h3>
                        <p class="news-excerpt">Nos élèves ont brillé lors du championnat national avec 15 médailles
                            remportées. Une performance exceptionnelle qui témoigne de la qualité de notre formation.</p>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <span>Maître Karim</span>
                        </div>
                        <button class="read-more" onclick="readMore(this)">Lire plus</button>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-image">
                        {{-- <i class="fas fa-calendar-alt"></i> --}}
                        <img src="/images/judo4.jpg" alt="News Image"
                            style="height: 123%; width: auto; border-radius: 10px;">
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">10 Sep 2025</span>
                            <span class="news-category">Événement</span>
                        </div>
                        <h3 class="news-title">Journée Portes Ouvertes</h3>
                        <p class="news-excerpt">Venez découvrir notre académie lors de notre journée portes ouvertes le 25
                            septembre. Démonstrations, cours d'essai gratuits et rencontre avec nos instructeurs.</p>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <span>Équipe JUDO-BURUNDI</span>
                        </div>
                        <button class="read-more" onclick="readMore(this)">Lire plus</button>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-image">
                        {{-- <i class="fas fa-graduation-cap"></i> --}}
                        <img src="/images/judo5.jpg" alt="News Image"
                            style="height: 120%; width: auto; border-radius: 10px;">
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">5 Sep 2025</span>
                            <span class="news-category">Formation</span>
                        </div>
                        <h3 class="news-title">Nouveau Programme pour Enfants</h3>
                        <p class="news-excerpt">Lancement de notre nouveau programme spécialement conçu pour les enfants de
                            6 à 12 ans. Apprentissage ludique et sécuritaire des arts martiaux.</p>
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
                    <p>Inscrivez-vous dès aujourd'hui pour commencer votre parcours martial. Nos programmes sont adaptés à
                        tous les âges et tous les niveaux.</p>

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

                    <div
                        style="background: #7CB342; color: white; padding: 1rem; border-radius: 10px; text-align: center;">
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
@endsection