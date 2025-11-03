// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    initHeroSlider();
    initScrollEffects();
    initBackToTop();
    initModal();
    initForm();
});

// ===== HERO SLIDER (Page d'accueil uniquement) =====
function initHeroSlider() {
    const slider = document.querySelector('.hero-slider');
    if (!slider) return; // Si pas de slider, on sort

    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slider-dots');
    const prevBtn = document.querySelector('.slider-arrows .prev');
    const nextBtn = document.querySelector('.slider-arrows .next');
    
    let currentSlide = 0;
    let slideInterval;

    // Créer les dots
    slides.forEach((_, index) => {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    function goToSlide(n) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        
        currentSlide = (n + slides.length) % slides.length;
        
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    function prevSlide() {
        goToSlide(currentSlide - 1);
    }

    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // Event listeners
    if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoSlide();
        startAutoSlide();
    });

    if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoSlide();
        startAutoSlide();
    });

    // Démarrer le slider automatique
    startAutoSlide();

    // Pause sur hover
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
}

// ===== SCROLL EFFECTS =====
function initScrollEffects() {
    const header = document.querySelector('.header');
    const backToTopBtn = document.getElementById('backToTop');
    
    let lastScroll = 0;
    let ticking = false;

    function updateScrollEffects(scrollY) {
        // Header effect - s'applique sur toutes les pages
        if (scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Back to top button
        if (scrollY > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }

        lastScroll = scrollY;
    }

    window.addEventListener('scroll', function() {
        const scrollY = window.pageYOffset || document.documentElement.scrollTop;
        
        if (!ticking) {
            window.requestAnimationFrame(function() {
                updateScrollEffects(scrollY);
                ticking = false;
            });
            ticking = true;
        }
    });

    // Smooth scroll pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const headerHeight = header.offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ===== BACK TO TOP BUTTON =====
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// ===== MODAL =====
function initModal() {
    const modal = document.getElementById('registrationModal');
    
    if (!modal) return;

    // Fermer le modal en cliquant en dehors
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
}

function openModal() {
    const modal = document.getElementById('registrationModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('registrationModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// ===== FORM VALIDATION & SUBMISSION =====
function initForm() {
    const form = document.getElementById('myForm');
    if (!form) return;

    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const messageZone = document.getElementById('messageZone');

    // Validation en temps réel
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });

    // Soumission du formulaire
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Valider tous les champs
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (!isValid) {
            showMessage('Veuillez corriger les erreurs avant de soumettre.', 'error');
            return;
        }

        // Désactiver le bouton et afficher le spinner
        submitButton.disabled = true;
        loadingSpinner.style.display = 'inline-block';
        submitButton.querySelector('i').style.display = 'none';

        try {
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                showMessage(data.message || 'Inscription réussie ! Nous vous contacterons bientôt.', 'success');
                form.reset();
                
                // Redirection ou fermeture après 2 secondes
                setTimeout(() => {
                    closeModal();
                }, 2000);
            } else {
                if (data.errors) {
                    displayValidationErrors(data.errors);
                } else {
                    showMessage(data.message || 'Une erreur est survenue. Veuillez réessayer.', 'error');
                }
            }
        } catch (error) {
            console.error('Erreur:', error);
            showMessage('Erreur de connexion. Veuillez vérifier votre connexion internet.', 'error');
        } finally {
            submitButton.disabled = false;
            loadingSpinner.style.display = 'none';
            submitButton.querySelector('i').style.display = 'inline';
        }
    });
}

// Validation d'un champ individuel
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    const errorElement = document.getElementById(`${fieldName}-error`);
    
    if (!errorElement) return true;

    let errorMessage = '';

    // Validation selon le type de champ
    if (field.hasAttribute('required') && !value) {
        errorMessage = 'Ce champ est requis.';
    } else if (fieldName === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            errorMessage = 'Veuillez entrer une adresse email valide.';
        }
    } else if (fieldName === 'telephone' && value) {
        const phoneRegex = /^[\d\s\+\-\(\)]+$/;
        if (!phoneRegex.test(value)) {
            errorMessage = 'Veuillez entrer un numéro de téléphone valide.';
        }
    } else if (fieldName === 'fullname' && value) {
        if (value.length < 3) {
            errorMessage = 'Le nom doit contenir au moins 3 caractères.';
        }
    }

    if (errorMessage) {
        errorElement.textContent = errorMessage;
        errorElement.style.display = 'block';
        field.style.borderColor = '#e53e3e';
        return false;
    } else {
        clearFieldError(field);
        return true;
    }
}

// Effacer l'erreur d'un champ
function clearFieldError(field) {
    const errorElement = document.getElementById(`${field.name}-error`);
    if (errorElement) {
        errorElement.style.display = 'none';
        errorElement.textContent = '';
    }
    field.style.borderColor = '#e2e8f0';
}

// Afficher les erreurs de validation du serveur
function displayValidationErrors(errors) {
    Object.keys(errors).forEach(fieldName => {
        const errorElement = document.getElementById(`${fieldName}-error`);
        const field = document.querySelector(`[name="${fieldName}"]`);
        
        if (errorElement && field) {
            errorElement.textContent = errors[fieldName][0];
            errorElement.style.display = 'block';
            field.style.borderColor = '#e53e3e';
        }
    });
}

// Afficher un message global
function showMessage(message, type) {
    const messageZone = document.getElementById('messageZone');
    if (!messageZone) return;

    const messageDiv = document.createElement('div');
    messageDiv.style.cssText = `
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 500;
        animation: slideInDown 0.4s ease;
        ${type === 'success' 
            ? 'background: #C6F6D5; color: #22543D; border-left: 4px solid #38A169;' 
            : 'background: #FED7D7; color: #742A2A; border-left: 4px solid #E53E3E;'}
    `;
    
    const icon = type === 'success' 
        ? '<i class="fas fa-check-circle" style="margin-right: 10px;"></i>' 
        : '<i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>';
    
    messageDiv.innerHTML = icon + message;
    
    messageZone.innerHTML = '';
    messageZone.appendChild(messageDiv);

    // Faire défiler jusqu'au message
    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

    // Supprimer le message après 5 secondes
    setTimeout(() => {
        messageDiv.style.animation = 'fadeOut 0.4s ease';
        setTimeout(() => {
            messageDiv.remove();
        }, 400);
    }, 5000);
}

// Animation fadeOut pour les messages
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }
`;
document.head.appendChild(style);

// ===== UTILITY FUNCTIONS =====

// Débounce pour optimiser les performances
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle pour les événements scroll
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Animation au scroll pour les éléments
function animateOnScroll() {
    const elements = document.querySelectorAll('.feature-card, .news-card, .gallery-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    elements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
}

// Appeler l'animation au chargement
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', animateOnScroll);
} else {
    animateOnScroll();
}