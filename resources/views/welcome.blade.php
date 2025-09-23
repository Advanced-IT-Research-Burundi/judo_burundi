<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fédération de Judo du Burundi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #8BC34A;
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
            color: #8BC34A;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2C3E50, #34495E);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="judogi" patternUnits="userSpaceOnUse" width="20" height="20"><rect width="20" height="20" fill="rgba(139,195,74,0.1)"/><circle cx="10" cy="10" r="2" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23judogi)"/></svg>') repeat;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-button {
            display: inline-block;
            background: #8BC34A;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s, transform 0.3s;
        }
        
        .cta-button:hover {
            background: #7CB342;
            transform: translateY(-2px);
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: #8BC34A;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        .feature-card h3 {
            color: #2C3E50;
            margin-bottom: 1rem;
        }
        
        /* About Section */
        .about {
            padding: 80px 0;
            background: white;
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-top: 3rem;
        }
        
        .about-image {
            position: relative;
        }
        
        .about-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        /* Gallery Section */
        .gallery {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            height: 200px;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .gallery-item:hover {
            transform: scale(1.05);
        }
        
        /* Stats Section */
        .stats {
            background: #8BC34A;
            color: white;
            padding: 60px 0;
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
        
        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Contact Section */
        .contact {
            padding: 80px 0;
            background: white;
        }
        
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-top: 3rem;
        }
        
        .contact-form {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #2C3E50;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #8BC34A;
        }
        
        .contact-info {
            padding: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: #8BC34A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
        }
        
        /* Footer */
        footer {
            background: #2C3E50;
            color: white;
            padding: 40px 0 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            color: #8BC34A;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section ul li a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section ul li a:hover {
            color: #8BC34A;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #34495E;
            color: #bbb;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #2C3E50;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .about-content,
            .contact-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .features-grid,
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .burundi-colors {
            background: linear-gradient(45deg, #CE1126 0%, #00CF00 33%, #FFFFFF 66%, #CE1126 100%);
            height: 5px;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="burundi-colors"></div>
        <nav class="container">
            <div class="logo">🥋 FJB</div>
            <ul class="nav-links">
                <li><a href="#accueil">Accueil</a></li>
                <li><a href="#apropos">À propos</a></li>
                <li><a href="#programmes">Programmes</a></li>
                <li><a href="#competitions">Compétitions</a></li>
                <li><a href="#galerie">Galerie</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="accueil" class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Fédération de Judo du Burundi</h1>
                <p>Développer l'excellence dans l'art du judo à travers tout le Burundi</p>
                <a href="#programmes" class="cta-button">Découvrir nos programmes</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="programmes" class="features">
        <div class="container">
            <h2 class="section-title">Nos Programmes</h2>
            <p class="section-subtitle">Des programmes adaptés à tous les âges et tous les niveaux pour promouvoir les valeurs du judo</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👶</div>
                    <h3>Judo Enfants</h3>
                    <p>Programme d'initiation au judo pour les enfants de 6 à 12 ans, axé sur le développement moteur et les valeurs morales</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">👨‍🎓</div>
                    <h3>Judo Adultes</h3>
                    <p>Formation complète pour adolescents et adultes, de la ceinture blanche à la ceinture noire</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3>Équipe Nationale</h3>
                    <p>Préparation de nos athlètes d'élite pour les compétitions nationales et internationales</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🎓</div>
                    <h3>Formation d'Instructeurs</h3>
                    <p>Certification et formation continue des instructeurs de judo à travers le pays</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">♿</div>
                    <h3>Judo Adapté</h3>
                    <p>Programme inclusif pour les personnes en situation de handicap</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Développement Communautaire</h3>
                    <p>Initiatives pour promouvoir le judo dans les écoles et communautés rurales</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="apropos" class="about">
        <div class="container">
            <h2 class="section-title">À Propos de Nous</h2>
            
            <div class="about-content">
                <div class="about-text">
                    <h3>Notre Mission</h3>
                    <p>La Fédération de Judo du Burundi s'engage à promouvoir et développer la pratique du judo dans tout le pays. Nous œuvrons pour l'excellence sportive tout en transmettant les valeurs fondamentales du judo : respect, courage, sincérité, honneur, modestie, contrôle de soi, amitié et politesse.</p>
                    
                    <h3>Notre Vision</h3>
                    <p>Faire du Burundi une nation reconnue dans le judo africain et mondial, en formant des athlètes de haut niveau et en démocratisant la pratique du judo à travers toutes les provinces du pays.</p>
                    
                    <h3>Nos Valeurs</h3>
                    <ul style="list-style: none; padding-left: 0;">
                        <li>✓ Excellence sportive et technique</li>
                        <li>✓ Intégrité et fair-play</li>
                        <li>✓ Inclusion et diversité</li>
                        <li>✓ Développement communautaire</li>
                    </ul>
                </div>
                
                <div class="about-image">
                    <div style="width: 100%; height: 300px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #666;">
                        Photo des dirigeants de la FJB
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>2500+</h3>
                    <p>Judokas licenciés</p>
                </div>
                <div class="stat-item">
                    <h3>45</h3>
                    <p>Clubs affiliés</p>
                </div>
                <div class="stat-item">
                    <h3>18</h3>
                    <p>Provinces couvertes</p>
                </div>
                <div class="stat-item">
                    <h3>120</h3>
                    <p>Instructeurs certifiés</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="galerie" class="gallery">
        <div class="container">
            <h2 class="section-title">Galerie</h2>
            <p class="section-subtitle">Découvrez nos moments forts, compétitions et événements</p>
            
            <div class="gallery-grid">
                <div class="gallery-item">Championnat National 2024</div>
                <div class="gallery-item">Formation des Jeunes</div>
                <div class="gallery-item">Compétition Régionale</div>
                <div class="gallery-item">Stage International</div>
                <div class="gallery-item">Cérémonie de Grades</div>
                <div class="gallery-item">Judo en Milieu Scolaire</div>
            </div>
        </div>
    </section>
    

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Contactez-Nous</h2>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <h4>Adresse</h4>
                            <p>Avenue de l'Indépendance<br>Bujumbura, Burundi</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <h4>Téléphone</h4>
                            <p>+257 22 24 XX XX</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <h4>Email</h4>
                            <p>info@judoburundi.bi</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">⏰</div>
                        <div>
                            <h4>Heures d'ouverture</h4>
                            <p>Lun-Ven: 8h00-17h00<br>Sam: 9h00-13h00</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3>Envoyez-nous un message</h3>
                    <form>
                        <div class="form-group">
                            <label for="nom">Nom complet</label>
                            <input type="text" id="nom" name="nom" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone">
                        </div>
                        
                        <div class="form-group">
                            <label for="sujet">Sujet</label>
                            <input type="text" id="sujet" name="sujet" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="cta-button">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Fédération de Judo du Burundi</h3>
                    <p>Promouvoir l'excellence dans l'art  du judo et développer les talents sportifs du Burundi.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Liens Rapides</h3>
                    <ul>
                        <li><a href="#apropos">À propos</a></li>
                        <li><a href="#programmes">Programmes</a></li>
                        <li><a href="#competitions">Compétitions</a></li>
                        <li><a href="#galerie">Galerie</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#">Licences</a></li>
                        <li><a href="#">Formations</a></li>
                        <li><a href="#">Arbitrage</a></li>
                        <li><a href="#">Grades et Dans</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Partenaires</h3>
                    <ul>
                        <li><a href="#">Fédération Internationale de Judo</a></li>
                        <li><a href="#">Union Africaine de Judo</a></li>
                        <li><a href="#">Comité National Olympique</a></li>
                        <li><a href="#">Ministère des Sports</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Fédération de Judo du Burundi. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
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

        // Animate stats on scroll
        const stats = document.querySelectorAll('.stat-item h3');
        const animateStats = () => {
            stats.forEach(stat => {
                const rect = stat.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    const finalNumber = parseInt(stat.textContent);
                    let currentNumber = 0;
                    const increment = finalNumber / 50;
                    const timer = setInterval(() => {
                        currentNumber += increment;
                        if (currentNumber >= finalNumber) {
                            stat.textContent = finalNumber + (stat.textContent.includes('+') ? '+' : '');
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(currentNumber) + (stat.textContent.includes('+') ? '+' : '');
                        }
                    }, 30);
                }
            });
        };

        window.addEventListener('scroll', animateStats);

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Merci pour votre message! Nous vous répondrons dans les plus brefs délais.');
            this.reset();
        });
    </script>
</body>
</html>





