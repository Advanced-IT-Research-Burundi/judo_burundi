@extends('layouts.user')

@section('title', 'À propos - Fédération de Judo du Burundi')

@section('content')
    <!-- Page Hero Section -->
    <section class="page-hero" style="background-image: url('{{ asset('images/judo1.jpeg') }}');">
        <div class="page-hero-content">
            <h1>À Propos de Nous</h1>
            <p>Découvrez l'histoire et les valeurs de notre fédération</p>
            
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <span>›</span>
                <span>À propos</span>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">
                <h2 style="color: var(--primary-color); margin-bottom: 30px; font-size: 2.5rem;">
                    Notre Histoire
                </h2>
                
                <p style="color: var(--text-light); font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px;">
                    La Fédération Burundaise de Judo et Disciplines Associées a été fondée en 1980 avec pour mission 
                    de promouvoir et développer la pratique du judo au Burundi. Depuis plus de 40 ans, nous œuvrons 
                    pour former des judokas de haut niveau tout en transmettant les valeurs fondamentales de cet art martial.
                </p>
                
                <p style="color: var(--text-light); font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px;">
                    Notre fédération est affiliée à la Fédération Internationale de Judo (IJF) et à l'Union Africaine 
                    de Judo (UAJ). Nous organisons régulièrement des compétitions nationales et participons activement 
                    aux championnats internationaux.
                </p>

                <div style="background: var(--bg-light); padding: 40px; border-radius: 15px; margin: 40px 0;">
                    <h3 style="color: var(--primary-color); margin-bottom: 25px; font-size: 2rem;">
                        Nos Valeurs
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        <div style="padding: 20px;">
                            <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                                <i class="fas fa-handshake"></i> Courtoisie
                            </h4>
                            <p style="color: var(--text-light);">Le respect et la politesse envers tous</p>
                        </div>
                        
                        <div style="padding: 20px;">
                            <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                                <i class="fas fa-heart"></i> Courage
                            </h4>
                            <p style="color: var(--text-light);">Faire face aux défis avec bravoure</p>
                        </div>
                        
                        <div style="padding: 20px;">
                            <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                                <i class="fas fa-balance-scale"></i> Honnêteté
                            </h4>
                            <p style="color: var(--text-light);">Agir avec sincérité et intégrité</p>
                        </div>
                        
                        <div style="padding: 20px;">
                            <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                                <i class="fas fa-medal"></i> Honneur
                            </h4>
                            <p style="color: var(--text-light);">Préserver sa dignité et celle des autres</p>
                        </div>
                        
                        <div style="padding: 20px;">
                            <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                                <i class="fas fa-user"></i> Modestie
                            </h4>
                            <p style="color: var(--text-light);">Rester humble dans la victoire</p>
                        </div>
                        
                        <div style="padding: 20px;">
                            <h4 style="color: var(--secondary-color); margin-bottom: 10px;">
                                <i class="fas fa-hands-helping"></i> Respect
                            </h4>
                            <p style="color: var(--text-light);">Honorer les traditions et les personnes</p>
                        </div>
                    </div>
                </div>

                <h3 style="color: var(--primary-color); margin-bottom: 25px; font-size: 2rem;">
                    Notre Mission
                </h3>
                
                <p style="color: var(--text-light); font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px;">
                    Nous nous engageons à :
                </p>
                
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <i class="fas fa-check" style="color: var(--secondary-color); margin-right: 15px;"></i>
                        Promouvoir la pratique du judo auprès de tous les publics
                    </li>
                    <li style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <i class="fas fa-check" style="color: var(--secondary-color); margin-right: 15px;"></i>
                        Former des athlètes de haut niveau pour les compétitions internationales
                    </li>
                    <li style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <i class="fas fa-check" style="color: var(--secondary-color); margin-right: 15px;"></i>
                        Développer des programmes de formation pour les entraîneurs et arbitres
                    </li>
                    <li style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <i class="fas fa-check" style="color: var(--secondary-color); margin-right: 15px;"></i>
                        Organiser des compétitions nationales et régionales
                    </li>
                    <li style="padding: 15px 0;">
                        <i class="fas fa-check" style="color: var(--secondary-color); margin-right: 15px;"></i>
                        Transmettre les valeurs morales et éthiques du judo
                    </li>
                </ul>

                <div style="margin-top: 50px; text-align: center;">
                    <h3 style="color: var(--primary-color); margin-bottom: 20px;">
                        Rejoignez-nous !
                    </h3>
                    <p style="color: var(--text-light); margin-bottom: 30px;">
                        Découvrez le judo et faites partie de notre grande famille
                    </p>
                    <a href="{{ route('contact') }}" class="btn-primary" style="text-decoration: none;">
                        <i class="fas fa-envelope"></i> Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection