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
                    <h3> Judo Enfants</h3>
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
@endsection
