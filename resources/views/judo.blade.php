@extends('layouts.user')
@section('content')
<!-- Hero Section -->
    <section id="accueil" class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Fédération de Judo du Burundi</h1>
                <p>Développer l'excellence dans l'art martial du judo à travers tout le Burundi</p>
                <a href="#programmes" class="cta-button">Découvrir nos programmes</a>
            </div>
        </div>
    </section>

    <!-- Publications Section -->
    <section class="posts-section" id="actualites">
        <div class="container">
            <div class="section-title">
                <h2>Dernières Publications</h2>
                <p>Suivez toute l'actualité de la Fédération Burundaise de Judo</p>
            </div>
            
            @if(isset($posts) && $posts->count() > 0)
                <div class="posts-grid">
                    @foreach($posts as $post)
                        <article class="post-card">
                            <div class="post-header">
                                <div class="post-type">
                                    <span class="type-icon">
                                        @if($post->typePost)
                                            @switch($post->typePost->nom)
                                                @case('Actualité') 📰 @break
                                                @case('Événement') 📅 @break
                                                @case('Formation') 🎓 @break
                                                @case('Résultat') 🏆 @break
                                                @case('Annonce') 📢 @break
                                                @default 📝
                                            @endswitch
                                        @else
                                            📝
                                        @endif
                                    </span>
                                    <span class="type-name">
                                        {{ $post->typePost->nom ?? 'Publication' }}
                                    </span>
                                </div>
                                <div class="post-meta">
                                    <span class="post-author">
                                        👤 {{ $post->user->name ?? 'Administrateur' }}
                                    </span>
                                    <span class="post-date">
                                        🕒 {{ \Carbon\Carbon::parse($post->date_post)->locale('fr')->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="post-content">
                                @if(strlen($post->contenu) > 200)
                                    <p class="post-excerpt">{{ Str::limit(strip_tags($post->contenu), 200) }}</p>
                                    <div class="full-content" id="content-{{ $post->id }}" style="display: none;">
                                        <p>{!! nl2br(e($post->contenu)) !!}</p>
                                    </div>
                                    <button class="read-more-btn" onclick="toggleContent({{ $post->id }})">
                                        Lire la suite
                                    </button>
                                @else
                                    <p>{!! nl2br(e($post->contenu)) !!}</p>
                                @endif
                            </div>
                            
                            <div class="post-footer">
                                <div class="post-timestamp">
                                    Publié le {{ \Carbon\Carbon::parse($post->date_post)->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}
                                </div>
                                <div class="post-actions">
                                    <button class="action-btn" onclick="sharePost('{{ $post->id }}')">
                                        📤 Partager
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="no-posts">
                    <div class="no-posts-icon">📝</div>
                    <h3>Aucune publication disponible</h3>
                    <p>Les publications apparaîtront ici une fois ajoutées par l'administrateur.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Nos Programmes</h2>
                <p>Des programmes adaptés à tous les âges et tous les niveaux pour promouvoir les valeurs du judo</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🏆</div>
                    <h3>Judo Enfants</h3>
                    <p>Programme d'initiation au judo pour les enfants de 6 à 12 ans, axé sur le développement moteur et les valeurs morales</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">👨‍🏫</div>
                    <h3>Judo Adultes</h3>
                    <p>Formation complète pour adolescents et adultes, de la ceinture blanche à la ceinture noire</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🎓</div>
                    <h3>Formation d'Instructeurs</h3>
                    <p>Cours pour débutants, intermédiaires et avancés dans nos centres affiliés</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🏅</div>
                    <h3>Grades et Ceintures</h3>
                    <p>Évaluation et attribution des grades selon les standards internationaux</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🌍</div>
                    <h3>Compétitions Internationales</h3>
                    <p>Participation aux tournois régionaux et mondiaux</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🏥</div>
                    <h3>Médecine Sportive</h3>
                    <p>Suivi médical et prévention des blessures pour nos athlètes</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="apropos">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>À Propos de la FBJ</h2>
                    <p>La Fédération Burundaise de Judo (FBJ) est l'organisme officiel qui régit la pratique du judo au Burundi. Fondée pour promouvoir les valeurs du judo et développer ce sport noble dans tout le pays.</p>
                    <p>Nous nous engageons à former des champions tout en inculquant les valeurs fondamentales du judo : respect, courage, sincérité, honneur, modestie, contrôle de soi, amitié et politesse.</p>
                    <p>Avec plus de 20 clubs affiliés à travers le pays, nous touchons des milliers de pratiquants de tous âges et niveaux.</p>
                    <a href="#contact" class="btn btn-primary">En Savoir Plus</a>
                </div>
                <div class="about-image">
                    <div style="width: 100%; height: 400px; background: linear-gradient(45deg, #4a7c59, #2d5016); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">🥋</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery" id="galerie">
        <div class="container">
            <div class="section-title">
                <h2>Galerie</h2>
                <p>Découvrez les moments forts de nos compétitions et entraînements</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">🏆</div>
                <div class="gallery-item">🥋</div>
                <div class="gallery-item">👥</div>
                <div class="gallery-item">🏅</div>
                <div class="gallery-item">📸</div>
                <div class="gallery-item">🎯</div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team" id="equipe">
        <div class="container">
            <div class="section-title">
                <h2>Notre Équipe</h2>
                <p>Rencontrez les dirigeants et entraîneurs qui font la force de notre fédération</p>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-photo">👨</div>
                    <h3>Jean-Claude NIYONZIMA</h3>
                    <p>Président de la Fédération</p>
                    <p>Ceinture Noire 6ème Dan</p>
                </div>
                <div class="team-member">
                    <div class="member-photo">👩</div>
                    <h3>Marie UWIMANA</h3>
                    <p>Directrice Technique</p>
                    <p>Ceinture Noire 5ème Dan</p>
                </div>
                <div class="team-member">
                    <div class="member-photo">👨</div>
                    <h3>Pierre HABONIMANA</h3>
                    <p>Entraîneur National</p>
                    <p>Ceinture Noire 4ème Dan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">Contactez-Nous</h2>
                <p style="color: #ccc;">N'hésitez pas à nous contacter pour toute information</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Informations de Contact</h3>
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <strong>Adresse</strong><br>
                            Avenue de l'Université, Bujumbura<br>
                            Burundi
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <strong>Téléphone</strong><br>
                            +257 22 24 35 67
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <strong>Email</strong><br>
                            info@fbjudo.bi
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">🌐</div>
                        <div>
                            <strong>Site Web</strong><br>
                            www.fbjudo.bi
                        </div>
                    </div>
                </div>
                <form class="contact-form">
                    <div class="form-group">
                        <label for="nom">Nom Complet</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="sujet">Sujet</label>
                        <input type="text" id="sujet" name="sujet" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer le Message</button>
                </form>
            </div>
        </div>
    </section>

    <style>
    /* Styles pour la section posts */
    .posts-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .post-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border-left: 4px solid #4a7c59;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .post-header {
        margin-bottom: 20px;
    }

    .post-type {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: #4a7c59;
        color: white;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .post-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85em;
        color: #666;
        flex-wrap: wrap;
        gap: 10px;
    }

    .post-author,
    .post-date {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .post-content {
        margin: 20px 0;
        line-height: 1.6;
        color: #333;
    }

    .post-excerpt {
        margin-bottom: 15px;
    }

    .read-more-btn {
        background: none;
        border: none;
        color: #4a7c59;
        font-weight: 600;
        cursor: pointer;
        text-decoration: underline;
        padding: 0;
    }

    .read-more-btn:hover {
        color: #2d5016;
    }

    .full-content {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .post-footer {
        border-top: 1px solid #eee;
        padding-top: 20px;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .post-timestamp {
        font-size: 0.8em;
        color: #999;
    }

    .post-actions {
        display: flex;
        gap: 15px;
    }

    .action-btn {
        background: none;
        border: 1px solid #ddd;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85em;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #666;
    }

    .action-btn:hover {
        background: #4a7c59;
        color: white;
        border-color: #4a7c59;
    }

    .no-posts {
        text-align: center;
        padding: 80px 20px;
        color: #666;
    }

    .no-posts-icon {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .posts-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .post-meta {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .post-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    </style>

    <script>
    function toggleContent(postId) {
        const excerpt = document.querySelector(`#content-${postId}`).previousElementSibling;
        const fullContent = document.getElementById(`content-${postId}`);
        const button = fullContent.nextElementSibling;
        
        if (fullContent.style.display === 'none') {
            excerpt.style.display = 'none';
            fullContent.style.display = 'block';
            button.textContent = 'Réduire';
        } else {
            excerpt.style.display = 'block';
            fullContent.style.display = 'none';
            button.textContent = 'Lire la suite';
        }
    }

    function sharePost(postId) {
        if (navigator.share) {
            navigator.share({
                title: 'Publication FBJ',
                text: 'Découvrez cette publication de la Fédération Burundaise de Judo',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Lien copié dans le presse-papiers !');
        }
    }
    </script>
@endsection