/* ===========================
   JAVASCRIPT PAGE D'ACCUEIL
   (Hero Slider)
   ========================== */

document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si nous sommes sur la page d'accueil
    if (!document.querySelector('.hero-slider')) {
        console.log('Pas de slider sur cette page');
        return;
    }

    // ========== HERO SLIDER ==========
    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slider-dots');
    const prevBtn = document.querySelector('.slider-arrows .prev');
    const nextBtn = document.querySelector('.slider-arrows .next');
    
    let currentSlide = 0;
    let slideInterval;

    // Créer les dots
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.className = 'dot';
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    // Fonction pour aller à un slide spécifique
    function goToSlide(n) {
        // Retirer la classe active de tous les slides et dots
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');

        // Calculer le nouveau slide
        currentSlide = n;
        if (currentSlide >= slides.length) currentSlide = 0;
        if (currentSlide < 0) currentSlide = slides.length - 1;

        // Ajouter la classe active au nouveau slide et dot
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    // Fonction pour passer au slide suivant
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    // Fonction pour passer au slide précédent
    function prevSlide() {
        goToSlide(currentSlide - 1);
    }

    // Event listeners pour les flèches
    if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        resetInterval();
    });

    if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        resetInterval();
    });

    // Navigation au clavier
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
            resetInterval();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            resetInterval();
        }
    });

    // Démarrer le slider automatique
    function startSlideShow() {
        slideInterval = setInterval(nextSlide, 5000); // Change toutes les 5 secondes
    }

    // Réinitialiser l'intervalle
    function resetInterval() {
        clearInterval(slideInterval);
        startSlideShow();
    }

    // Pause au survol
    const heroSlider = document.querySelector('.hero-slider');
    if (heroSlider) {
        heroSlider.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        heroSlider.addEventListener('mouseleave', () => {
            startSlideShow();
        });
    }

    // Démarrer le slideshow
    startSlideShow();

    // ========== ANIMATION DES CARTES AU SCROLL ==========
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const fadeInObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                fadeInObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer les éléments
    document.querySelectorAll('.feature-card, .gallery-item, .news-card').forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(50px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        fadeInObserver.observe(el);
    });

    // ========== COMPTEUR ANIMÉ (si présent) ==========
    const counters = document.querySelectorAll('.counter');
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    animateCounter(entry.target, target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));
    }

    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 30);
    }

    // ========== GESTION DU FORMULAIRE D'INSCRIPTION ==========
    const form = document.getElementById('myForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('loadingSpinner');
            const formData = new FormData(this);
            
            // Désactiver le bouton
            submitBtn.disabled = true;
            if (spinner) spinner.style.display = 'inline';
            
            // Simuler l'envoi (à remplacer par votre vraie logique)
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', 'Inscription réussie ! Nous vous contacterons bientôt.');
                    form.reset();
                } else {
                    showMessage('error', data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showMessage('error', 'Erreur de connexion. Veuillez réessayer.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                if (spinner) spinner.style.display = 'none';
            });
        });
    }

    function showMessage(type, message) {
        const messageZone = document.getElementById('messageZone');
        if (!messageZone) return;
        
        messageZone.innerHTML = `
            <div class="alert alert-${type}" style="
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 8px;
                background: ${type === 'success' ? '#d4edda' : '#f8d7da'};
                color: ${type === 'success' ? '#155724' : '#721c24'};
                border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'};
                animation: slideInDown 0.5s ease;
            ">
                ${message}
            </div>
        `;
        
        setTimeout(() => {
            const alert = messageZone.querySelector('.alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    }

    console.log('✅ Script page d\'accueil chargé');
});