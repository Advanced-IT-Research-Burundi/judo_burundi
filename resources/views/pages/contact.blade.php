@extends('layouts.user')
@section('content')
@section('title', 'Contactez nous')
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
	 <!-- Contact Section -->
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
@endsection	