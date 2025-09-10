@extends('layouts.user')
@section('content')
@section('title', 'A Propos de nous')

<!-- Hero Section -->
    <section id="accueil" class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Fédération de Judo du Burundi</h1>
                <p>A propos de nous</p>
                <a href="#programmes" class="cta-button">Découvrir nos programmes</a>
            </div>
        </div>
    </section>
<!-- About -->

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
@endsection
