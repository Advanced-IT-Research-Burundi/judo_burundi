<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Fédération de Judo du Burundi</title>
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
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 2rem;
            color: #1a365d;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-subtitle {
            color: #666;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
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

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin: 0;
            accent-color: #7CB342;
        }

        .forgot-password {
            color: #7CB342;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #689F3A;
            text-decoration: underline;
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
            margin-top: 2rem;
            padding-top: 2rem;
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
                font-size: 1.8rem;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
        }

        @media (max-width: 480px) {
            .auth-form-section {
                padding: 1.5rem;
            }

            .form-title {
                font-size: 1.6rem;
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
                <h1 class="form-title">Connexion</h1>
                <p class="form-subtitle">Accédez à votre espace membre</p>
            </div>

            {{-- Messages de statut --}}
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

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
                        autofocus
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
                        autocomplete="current-password"
                        placeholder="Votre mot de passe"
                    >
                    <i class="fas fa-lock input-icon"></i>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span class="error-message"></span>
                    @enderror
                </div>

                {{-- Options du formulaire --}}
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                {{-- Bouton de connexion --}}
                <button type="submit" class="btn-primary">
                    Se connecter
                </button>
            </form>

            {{-- Lien vers l'inscription --}}
            <div class="auth-switch">
                Pas encore de compte ?
                <a href="{{ route('register') }}">Créer un compte</a>
            </div>
        </div>
    </div>

    <script>
        // Enhanced form handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            // Auto-focus on first input
            setTimeout(() => emailInput.focus(), 100);

            // Real-time form validation
            emailInput.addEventListener('blur', validateField);
            emailInput.addEventListener('input', clearError);
            passwordInput.addEventListener('blur', validateField);
            passwordInput.addEventListener('input', clearError);

            // Form submission handling
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.btn-primary');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }

                // Validation finale
                const email = emailInput.value.trim();
                const password = passwordInput.value;
                let hasErrors = false;

                if (!email) {
                    showFieldError(emailInput, 'L\'adresse email est requise');
                    hasErrors = true;
                } else if (!isValidEmail(email)) {
                    showFieldError(emailInput, 'Veuillez entrer une adresse email valide');
                    hasErrors = true;
                }

                if (!password) {
                    showFieldError(passwordInput, 'Le mot de passe est requis');
                    hasErrors = true;
                }

                if (hasErrors) {
                    e.preventDefault();
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                    const firstError = form.querySelector('.error-message:not(:empty)');
                    if (firstError) {
                        const input = firstError.parentNode.querySelector('input');
                        if (input) input.focus();
                    }
                }
            });

            // Validation personnalisée pour l'email
            emailInput.addEventListener('blur', function() {
                const email = this.value.trim();
                if (email && !isValidEmail(email)) {
                    showFieldError(this, 'Veuillez entrer une adresse email valide');
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
            } else if (field.name === 'password' && value && value.length < 6) {
                isValid = false;
                errorMessage = 'Le mot de passe doit contenir au moins 6 caractères';
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    // Validation personnalisée pour l'email
    emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        if (email && !isValidEmail(email)) {
            showFieldError(this, 'Veuillez entrer une adresse email valide');
        }
    });

    // Validation du mot de passe
    passwordInput.addEventListener('blur', function() {
        const password = this.value;
        if (password && password.length < 6) {
            showFieldError(this, 'Le mot de passe doit contenir au moins 6 caractères');
        }
    });

    // Soumission du formulaire
    form.addEventListener('submit', function(e) {
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        let hasErrors = false;

        // Validation finale
        if (!email) {
            showFieldError(emailInput, 'L\'adresse email est requise');
            hasErrors = true;
        } else if (!isValidEmail(email)) {
            showFieldError(emailInput, 'Veuillez entrer une adresse email valide');
            hasErrors = true;
        }

        if (!password) {
            showFieldError(passwordInput, 'Le mot de passe est requis');
            hasErrors = true;
        }

        if (hasErrors) {
            e.preventDefault();
            const firstError = form.querySelector('.error-message:not(:empty)');
            if (firstError) {
                const input = firstError.parentNode.querySelector('input');
                if (input) input.focus();
            }
        }
    });
});
</script>
@endpush