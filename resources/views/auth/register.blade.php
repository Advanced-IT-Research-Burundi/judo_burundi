<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - Fédération de Judo du Burundi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
            position: relative;
        }

        .auth-visual {
            background: linear-gradient(45deg, #7CB342, #689F3A);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/images/judoimage1.jpg') center/cover;
            opacity: 0.15;
        }

        .visual-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 3rem;
        }

        .logo {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .tagline {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .features {
            text-align: left;
            max-width: 300px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .auth-form-section {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-title {
            font-size: 1.8rem;
            color: #1a365d;
            margin-bottom: 0.3rem;
            font-weight: 600;
        }

        .form-subtitle {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #7CB342;
            box-shadow: 0 0 0 3px rgba(124, 179, 66, 0.1);
            transform: translateY(-1px);
        }

        .input-icon {
            position: absolute;
            left: 0.8rem;
            top: 2.2rem;
            color: #666;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.3s;
        }

        .form-group input:focus + .input-icon {
            color: #7CB342;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .error-message:not(:empty) {
            opacity: 1;
            transform: translateY(0);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin: 0;
            accent-color: #7CB342;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7CB342, #689F3A);
            color: white;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin: 1rem 0;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 179, 66, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary.loading {
            color: transparent;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .auth-switch {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            color: #666;
            font-size: 0.9rem;
        }

        .auth-switch a {
            color: #7CB342;
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        .status-message {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 0.5rem;
            }

            .auth-container {
                grid-template-columns: 1fr;
                max-width: 400px;
                min-height: auto;
            }

            .auth-visual {
                display: none;
            }

            .auth-form-section {
                padding: 2rem;
            }

            .form-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 480px) {
            .auth-form-section {
                padding: 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="auth-container fade-in">
        <!-- Visual Side -->
        <div class="auth-visual">
            <div class="visual-content">
                <div class="logo">JUDO</div>
                <div class="tagline">Fédération du Burundi</div>
                
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-fist-raised"></i>
                        </div>
                        <span>Formation d'excellence</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span>Communauté unie</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <span>Esprit de compétition</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <span>Tradition & Honneur</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-form-section slide-in-right">
            <div class="form-header">
                <h1 class="form-title">Inscription</h1>
                <p class="form-subtitle">Rejoignez la famille du judo burundais</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                {{-- Nom complet --}}
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autocomplete="name"
                        autofocus
                        placeholder="Votre nom complet"
                    >
                    <i class="fas fa-user input-icon"></i>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message"></span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email"
                        placeholder="votre.email@example.com"
                    >
                    <i class="fas fa-envelope input-icon"></i>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message"></span>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Minimum 8 caractères"
                    >
                    <i class="fas fa-lock input-icon"></i>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message"></span>
                    @enderror
                </div>

                {{-- Confirmation du mot de passe --}}
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Confirmez votre mot de passe"
                    >
                    <i class="fas fa-lock input-icon"></i>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message"></span>
                    @enderror
                </div>

                {{-- Conditions d'utilisation --}}
                <div class="form-group">
                    <label class="remember-me">
                        <input type="checkbox" name="terms" required {{ old('terms') ? 'checked' : '' }}>
                        <span>J'accepte les <a href="#" style="color: #7CB342; text-decoration: underline;">conditions d'utilisation</a> et la <a href="#" style="color: #7CB342; text-decoration: underline;">politique de confidentialité</a></span>
                    </label>
                    @error('terms')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message"></span>
                    @enderror
                </div>

                {{-- Bouton d'inscription --}}
                <button type="submit" class="btn-primary">
                    Créer mon compte
                </button>
            </form>

            {{-- Lien vers la connexion --}}
            <div class="auth-switch">
                Déjà un compte ?
                <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </div>
    </div>

    <script>
        // Enhanced form handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const termsCheckbox = document.querySelector('input[name="terms"]');

            // Auto-focus on first input
            setTimeout(() => nameInput.focus(), 100);

            // Real-time form validation
            const inputs = document.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', clearError);
            });

            // Validation du nom
            nameInput.addEventListener('blur', function() {
                const value = this.value.trim();
                if (value && value.length < 2) {
                    showFieldError(this, 'Le nom doit contenir au moins 2 caractères');
                } else if (value && !/^[a-zA-ZÀ-ÿ\s-']+$/.test(value)) {
                    showFieldError(this, 'Seules les lettres, espaces et tirets sont autorisés');
                }
            });

            // Validation de l'email
            emailInput.addEventListener('blur', function() {
                const email = this.value.trim();
                if (email && !isValidEmail(email)) {
                    showFieldError(this, 'Veuillez entrer une adresse email valide');
                }
            });

            // Validation du mot de passe
            passwordInput.addEventListener('blur', function() {
                const password = this.value;
                if (password && password.length < 8) {
                    showFieldError(this, 'Le mot de passe doit contenir au moins 8 caractères');
                } else if (password && !/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)) {
                    showFieldError(this, 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre');
                }
            });

            // Validation de la confirmation du mot de passe
            passwordConfirmationInput.addEventListener('blur', function() {
                if (this.value && this.value !== passwordInput.value) {
                    showFieldError(this, 'Les mots de passe ne correspondent pas');
                }
            });

            // Revalidation lors de la modification du mot de passe principal
            passwordInput.addEventListener('input', function() {
                if (passwordConfirmationInput.value && passwordConfirmationInput.value !== this.value) {
                    showFieldError(passwordConfirmationInput, 'Les mots de passe ne correspondent pas');
                } else if (passwordConfirmationInput.value && passwordConfirmationInput.value === this.value) {
                    showFieldError(passwordConfirmationInput, '');
                }
            });

            // Form submission handling
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.btn-primary');
                let hasErrors = false;

                // Validation finale de tous les champs
                const requiredFields = [
                    { input: nameInput, message: 'Le nom est requis' },
                    { input: emailInput, message: 'L\'adresse email est requise' },
                    { input: passwordInput, message: 'Le mot de passe est requis' },
                    { input: passwordConfirmationInput, message: 'La confirmation du mot de passe est requise' }
                ];

                requiredFields.forEach(field => {
                    if (!field.input.value.trim()) {
                        showFieldError(field.input, field.message);
                        hasErrors = true;
                    }
                });

                // Vérification de l'email
                if (emailInput.value && !isValidEmail(emailInput.value)) {
                    showFieldError(emailInput, 'Adresse email invalide');
                    hasErrors = true;
                }

                // Vérification des mots de passe
                if (passwordInput.value && passwordInput.value.length < 8) {
                    showFieldError(passwordInput, 'Le mot de passe doit contenir au moins 8 caractères');
                    hasErrors = true;
                }

                if (passwordInput.value !== passwordConfirmationInput.value) {
                    showFieldError(passwordConfirmationInput, 'Les mots de passe ne correspondent pas');
                    hasErrors = true;
                }

                // Vérification des conditions
                if (!termsCheckbox.checked) {
                    showFieldError(termsCheckbox, 'Vous devez accepter les conditions d\'utilisation');
                    hasErrors = true;
                }

                if (hasErrors) {
                    e.preventDefault();
                    const firstError = form.querySelector('.error-message:not(:empty)');
                    if (firstError) {
                        const input = firstError.parentNode.querySelector('input');
                        if (input) input.focus();
                    }
                } else if (submitBtn && !submitBtn.disabled) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });

        function validateField(e) {
            const field = e.target;
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';

            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Ce champ est requis';
            } else if (field.type === 'email' && value && !isValidEmail(value)) {
                isValid = false;
                errorMessage = 'Adresse email invalide';
            } else if (field.name === 'password' && value && value.length < 8) {
                isValid = false;
                errorMessage = 'Le mot de passe doit contenir au moins 8 caractères';
            }

            showFieldError(field, isValid ? '' : errorMessage);
        }

        function clearError(e) {
            showFieldError(e.target, '');
        }

        function showFieldError(field, message) {
            const errorElement = field.parentNode.querySelector('.error-message');
            if (errorElement) {
                errorElement.textContent = message;
                
                if (message) {
                    field.style.borderColor = '#dc3545';
                    field.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
                } else {
                    field.style.borderColor = '#e2e8f0';
                    field.style.boxShadow = 'none';
                }
            }
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Show notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                color: white;
                font-weight: 500;
                z-index: 9999;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                ${type === 'success' ? 'background: #28a745;' : 'background: #dc3545;'}
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        // Messages de session
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showNotification(@json(session('success')), 'success');
            });
        @endif

        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                showNotification(@json(session('error')), 'error');
            });
            
        @endif
    </script>
</body>
</html>