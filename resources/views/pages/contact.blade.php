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
<section class="contact" id="contact">
    <div class="container">
        <div class="section-title">
            <h2 style="color: white;">Contactez-Nous</h2>
            <p style="color: #ccc;">N'hésitez pas à nous contacter pour toute information</p>
        </div>
        
        <!-- Messages de succès/erreur -->
        @if(session('contact_success'))
            <div class="contact-alert contact-success">
                ✅ {{ session('contact_success') }}
            </div>
        @endif

        @if(session('contact_error'))
            <div class="contact-alert contact-error">
                ❌ {{ session('contact_error') }}
            </div>
        @endif

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="contact-alert contact-error">
                <strong>❌ Erreurs détectées :</strong>
                <ul style="margin: 10px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
            
            <!-- Formulaire de contact avec gestion d'erreurs -->
            <form class="contact-form" method="POST" action="{{ route('contact.submit') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="nom">Nom Complet <span style="color: red;">*</span></label>
                    <input type="text" 
                           id="nom" 
                           name="name" 
                           value="{{ old('name') }}" 
                           class="@error('name') error-input @enderror"
                           required>
                    @error('name')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="@error('email') error-input @enderror"
                           required>
                    @error('email')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="sujet">Sujet <span style="color: red;">*</span></label>
                    <input type="text" 
                           id="sujet" 
                           name="sujet" 
                           value="{{ old('sujet') }}"
                           class="@error('sujet') error-input @enderror"
                           required>
                    @error('sujet')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="message">Message <span style="color: red;">*</span></label>
                    <textarea id="message" 
                              name="message" 
                              rows="5" 
                              class="@error('message') error-input @enderror"
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary" id="contact-submit-btn">
                    <span class="btn-text">Envoyer</span>
                    <span class="btn-loading" style="display: none;">Envoi en cours...</span>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection