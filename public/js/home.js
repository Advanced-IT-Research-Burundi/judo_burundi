/* ===========================
   SCRIPT PAGE D'ACCUEIL
   ========================== */

(() => {
    'use strict';

    // Vérifier si nous sommes sur la page d'accueil
    if (!document.querySelector('.hero-slider')) {
        return;
    }

    // ===== HERO SLIDER =====
    const initHeroSlider = () => {
        const slides = document.querySelectorAll('.slide');
        const dotsContainer = document.querySelector('.slider-dots');
        const prevBtn = document.querySelector('.slider-arrows .prev');
        const nextBtn = document.querySelector('.slider-arrows .next');
        const heroSlider = document.querySelector('.hero-slider');

        if (!slides.length || !dotsContainer) return;

        let currentSlide = 0;
        let slideInterval;

        // Créer les dots
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = 'dot';
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => {
                goToSlide(index);
                resetInterval();
            });
            dotsContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('.dot');

        // Aller à un slide spécifique
        const goToSlide = (n) => {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');

            currentSlide = n;
            if (currentSlide >= slides.length) currentSlide = 0;
            if (currentSlide < 0) currentSlide = slides.length - 1;

            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        };

        // Navigation
        const nextSlide = () => goToSlide(currentSlide + 1);
        const prevSlide = () => goToSlide(currentSlide - 1);

        // Event listeners
        prevBtn?.addEventListener('click', () => {
            prevSlide();
            resetInterval();
        });

        nextBtn?.addEventListener('click', () => {
            nextSlide();
            resetInterval();
        });

        // Clavier
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
                resetInterval();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
                resetInterval();
            }
        });

        // Auto-slide
        const startSlideShow = () => {
            slideInterval = setInterval(nextSlide, 5000);
        };

        const resetInterval = () => {
            clearInterval(slideInterval);
            startSlideShow();
        };

        // Pause au survol
        heroSlider?.addEventListener('mouseenter', () => clearInterval(slideInterval));
        heroSlider?.addEventListener('mouseleave', startSlideShow);

        // Touch swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        heroSlider?.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        heroSlider?.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        const handleSwipe = () => {
            if (touchEndX < touchStartX - 50) {
                nextSlide();
                resetInterval();
            }
            if (touchEndX > touchStartX + 50) {
                prevSlide();
                resetInterval();
            }
        };

        // Démarrer
        startSlideShow();
    };

    // ===== ANIMATIONS AU SCROLL =====
    const initScrollAnimations = () => {
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
    };

    // ===== INITIALISATION =====
    const init = () => {
        initHeroSlider();
        initScrollAnimations();
        console.log('✅ Script page d\'accueil chargé');
    };

    // Démarrer quand le DOM est prêt
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
