@extends('layouts.user')

@section('content')
<!-- Page Hero Section - Contact -->
<section class="page-hero dark-overlay" style="background-image: url('{{ asset('images/judo5.jpg') }}');">
    <div class="page-hero-content">
        <h1>Contactez-nous</h1>
        <p>Nous sommes là pour répondre à toutes vos questions</p>
        <div class="page-hero-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <span>Contact</span>
        </div>
    </div>
</section>

<!-- Section Contact -->
<section class="contact-section" style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            
            <!-- Informations de contact -->
            <div>
                <h2 style="color: #1a365d; font-size: 2.5rem; margin-bottom: 2rem;">Nos Coordonnées</h2>
                
                <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: #7CB342; color: white; width: 50px; height: 50px; border-radius: 50%; 
                                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 style="color: #1a365d; margin-bottom: 0.5rem;">Adresse</h4>
                            <p style="color: #666;">Avenue de l'Indépendance<br>Bujumbura, Burundi</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: #7CB342; color: white; width: 50px; height: 50px; border-radius: 50%; 
                                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h4 style="color: #1a365d; margin-bottom: 0.5rem;">Téléphone</h4>
                            <p style="color: #666;">+257 22 123 456<br>+257 79 123 456</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="background: #7CB342; color: white; width: 50px; height: 50px; border-radius: 50%; 
                                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 style="color: #1a365d; margin-bottom: 0.5rem;">Email</h4>
                            <p style="color: #666;">info@judoburundi-bi.com<br>contact@judoburundi-bi.com</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: start; gap: 1rem;">
                        <div style="background: #7CB342; color: white; width: 50px; height: 50px; border-radius: 50%; 
                                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 style="color: #1a365d; margin-bottom: 0.5rem;">Horaires</h4>
                            <p style="color: #666;">
                                Lun - Ven: 6h00 - 21h00<br>
                                Samedi: 8h00 - 18h00<br>
                                Dimanche: 10h00 - 16h00
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Réseaux sociaux -->
                <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <h4 style="color: #1a365d; margin-bottom: 1.5rem;">Suivez-nous</h4>
                    <div style="display: flex; gap: 1rem;">
                        <a href="#" style="background: #7CB342; color: white; width: 45px; height: 45px; border-radius: 50%; 
                                          display: flex; align-items: center; justify-content: center; text-decoration: none; 
                                          transition: transform 0.3s;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" style="background: #7CB342; color: white; width: 45px; height: 45px; border-radius: 50%; 
                                          display: flex; align-items: center; justify-content: center; text-decoration: none; 
                                          transition: transform 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" style="background: #7CB342; color: white; width: 45px; height: 45px; border-radius: 50%; 
                                          display: flex; align-items: center; justify-content: center; text-decoration: none; 
                                          transition: transform 0.3s;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="background: #7CB342; color: white; width: 45px; height: 45px; border-radius: 50%; 
                                          display: flex; align-items: center; justify-content: center; text-decoration: none; 
                                          transition: transform 0.3s;">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulaire de contact -->
            <div>
                <div style="background: white; padding: 2.5rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <h3 style="color: #1a365d; font-size: 1.8rem; margin-bottom: 1.5rem;">Envoyez-nous un message</h3>
                    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nom complet *</label>
                            <input type="text" name="name" required
                                   style="width: 100%; padding: 0.8rem; border: 2px solid #ddd; border-radius: 5px; 
                                          font-size: 1rem; transition: border-color 0.3s;">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Email *</label>
                            <input type="email" name="email" required
                                   style="width: 100%; padding: 0.8rem; border: 2px solid #ddd; border-radius: 5px; 
                                          font-size: 1rem; transition: border-color 0.3s;">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Téléphone</label>
                            <input type="tel" name="phone"
                                   style="width: 100%; padding: 0.8rem; border: 2px solid #ddd; border-radius: 5px; 
                                          font-size: 1rem; transition: border-color 0.3s;">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Sujet *</label>
                            <input type="text" name="subject" required
                                   style="width: 100%; padding: 0.8rem; border: 2px solid #ddd; border-radius: 5px; 
                                          font-size: 1rem; transition: border-color 0.3s;">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Message *</label>
                            <textarea name="message" rows="5" required
                                      style="width: 100%; padding: 0.8rem; border: 2px solid #ddd; border-radius: 5px; 
                                             font-size: 1rem; transition: border-color 0.3s; resize: vertical;"></textarea>
                        </div>

                        <button type="submit" class="btn-primary" 
                                style="width: 100%; background: #7CB342; color: white; padding: 1rem; border: none; 
                                       border-radius: 5px; font-size: 1.1rem; font-weight: 600; cursor: pointer; 
                                       transition: background 0.3s;">
                            <i class="fas fa-paper-plane"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Carte Google Maps (optionnel) -->
        <div style="margin-top: 4rem; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h3 style="color: #1a365d; margin-bottom: 1.5rem; text-align: center;">Notre Localisation</h3>
            <div style="width: 100%; height: 400px; background: #ddd; border-radius: 10px; 
                        display: flex; align-items: center; justify-content: center;">
                <p style="color: #666;"><i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-bottom: 1rem;"></i><br>
                Carte interactive à intégrer</p>
            </div>
        </div>
    </div>
</section>

<style>
    input:focus, textarea:focus {
        outline: none;
        border-color: #7CB342 !important;
    }
    .btn-primary:hover {
        background: #689F3A !important;
        transform: translateY(-2px);
    }
    a:hover {
        transform: scale(1.1) !important;
    }
</style>
@endsection