<!DOCTYPE html>
<html lang="en">
<head>
    <title>SportFIT</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="SportFIT template project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('css/user.css')}}">
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('css/contact.css')}}"> --}}

</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav-container">
            <div class="logo">
                <div style="width: 40px; height: 40px; background: #90c695; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-weight: bold; color: #2d5016;">🥋</div>
                FBJ
            </div>
            <ul class="nav-menu">
                <li><a href="{{route('home')}}">Accueil</a></li>
                <li><a href="{{route('service')}}">Services</a></li>
                <li><a href="{{route('about')}}">À Propos</a></li>
                {{-- <li><a href="#equipe">Équipe</a></li> --}}
                <li><a href="{{route('contact')}}">Contact</a></li>
            </ul>
            <a href="#" class="login-btn">Connexion</a>
        </nav>
    </header>

    <!-- Content -->
    <main>
        @yield('content')
    </main>
     <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Fédération Burundaise de Judo</h3>
                    <p>Développer l'excellence du judo au Burundi à travers la formation, la compétition et les valeurs traditionnelles.</p>
                </div>
                <div class="footer-section">
                    <h3>Liens Rapides</h3>
                    <a href="#accueil">Accueil</a>
                    <a href="#services">Services</a>
                    <a href="#apropos">À Propos</a>
                    <a href="#equipe">Équipe</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="footer-section">
                    <h3>Services</h3>
                    <a href="#">Formations</a>
                    <a href="#">Compétitions</a>
                    <a href="#">Grades</a>
                    <a href="#">Clubs Affiliés</a>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>📍 Bujumbura, Burundi</p>
                    <p>📞 +257 22 24 35 67</p>
                    <p>✉️ info@fbjudo.bi</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Fédération Burundaise de Judo. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<script src="{{asset('js/user.js')}}"></script>



