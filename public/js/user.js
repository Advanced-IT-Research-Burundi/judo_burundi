// ===== CONFIGURATION =====
const CONFIG = {
    scrollThreshold: 100,
    backToTopThreshold: 300,
    slideInterval: 5000,
    messageTimeout: 5000
};

// ===== DOM ELEMENTS CACHE =====
const DOM = {
    header: null,
    mobileToggle: null,
    drawerMenu: null,
    drawerOverlay: null,
    drawerClose: null,
    drawerDropdowns: null,
    backToTop: null,
    heroSlider: null,
    modal: null,
    form: null
};

// ===== STATE =====
const state = {
    lastScroll: 0,
    ticking: false,
    currentSlide: 0,
    slideInterval: null,
    scrollPosition: 0
};

// ===== DESKTOP NAVIGATION =====
function initDesktopNav() {
    const dropdowns = document.querySelectorAll('.desktop-nav .dropdown');

    if (!dropdowns.length) return;

    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const menu = dropdown.querySelector('.dropdown-menu');

        if (!button || !menu) return;

        // Hover effect (desktop)
        if (window.innerWidth > 768) {
            dropdown.addEventListener('mouseenter', () => {
                dropdown.classList.add('active');
            });

            dropdown.addEventListener('mouseleave', () => {
                dropdown.classList.remove('active');
            });
        }

        // Click effect (pour les écrans tactiles)
        button.addEventListener('click', (e) => {
            e.stopPropagation();

            // Fermer les autres dropdowns
            dropdowns.forEach(other => {
                if (other !== dropdown) {
                    other.classList.remove('active');
                }
            });

            // Toggle le dropdown actuel
            dropdown.classList.toggle('active');
        });
    });

    // Fermer les dropdowns en cliquant ailleurs
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown')) {
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', () => {
    cacheDOMElements();
    initHeader();
    initDesktopNav();
    initMobileDrawer();
    initHeroSlider();
    initScrollEffects();
    initBackToTop();
    initModal();
    initForm();
    initAnimations();
    setActiveMenuItem();
});

// ===== CACHE DOM ELEMENTS =====
function cacheDOMElements() {
    DOM.header = document.querySelector('.header');
    DOM.mobileToggle = document.querySelector('.mobile-toggle');
    DOM.drawerMenu = document.querySelector('.drawer-menu');
    DOM.drawerOverlay = document.querySelector('.drawer-overlay');
    DOM.drawerClose = document.querySelector('.drawer-close');
    DOM.drawerDropdowns = document.querySelectorAll('.drawer-dropdown-btn');
    DOM.backToTop = document.getElementById('backToTop');
    DOM.heroSlider = document.querySelector('.hero-slider');
    DOM.modal = document.getElementById('registrationModal');
    DOM.form = document.getElementById('myForm');
}

// ===== HEADER SCROLL EFFECTS =====
function initHeader() {
    if (!DOM.header) return;

    window.addEventListener('scroll', () => {
        if (!state.ticking) {
            requestAnimationFrame(handleScroll);
            state.ticking = true;
        }
    }, { passive: true });
}

function handleScroll() {
    const currentScroll = window.pageYOffset;

    // Header scroll effect
    if (currentScroll > CONFIG.scrollThreshold) {
        DOM.header?.classList.add('scrolled');
    } else {
        DOM.header?.classList.remove('scrolled');
    }

    // Back to top button
    if (DOM.backToTop) {
        if (currentScroll > CONFIG.backToTopThreshold) {
            DOM.backToTop.classList.add('show');
        } else {
            DOM.backToTop.classList.remove('show');
        }
    }

    state.lastScroll = currentScroll;
    state.ticking = false;
}

// ===== MOBILE DRAWER MENU =====
function initMobileDrawer() {
    if (!DOM.drawerMenu) return;

    // Toggle drawer
    DOM.mobileToggle?.addEventListener('click', toggleDrawer);
    DOM.drawerClose?.addEventListener('click', closeDrawer);
    DOM.drawerOverlay?.addEventListener('click', closeDrawer);

    // Close drawer on link click
    document.querySelectorAll('.drawer-links a').forEach(link => {
        link.addEventListener('click', closeDrawer);
    });

    // Handle drawer dropdowns
    DOM.drawerDropdowns?.forEach(btn => {
        btn.addEventListener('click', handleDrawerDropdown);
    });

    // Close on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && DOM.drawerMenu?.classList.contains('active')) {
            closeDrawer();
        }
    });

    // Handle resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 768 && DOM.drawerMenu?.classList.contains('active')) {
                closeDrawer();
            }
        }, 250);
    });
}

function toggleDrawer() {
    if (DOM.drawerMenu?.classList.contains('active')) {
        closeDrawer();
    } else {
        openDrawer();
    }
}

function openDrawer() {
    if (!DOM.drawerMenu) return;

    state.scrollPosition = window.pageYOffset;

    DOM.drawerMenu.classList.add('active');
    DOM.drawerOverlay?.classList.add('active');
    DOM.mobileToggle?.classList.add('active');

    document.body.style.position = 'fixed';
    document.body.style.top = `-${state.scrollPosition}px`;
    document.body.style.width = '100%';
}

function closeDrawer() {
    if (!DOM.drawerMenu) return;

    DOM.drawerMenu.classList.remove('active');
    DOM.drawerOverlay?.classList.remove('active');
    DOM.mobileToggle?.classList.remove('active');

    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';
    window.scrollTo(0, state.scrollPosition);
}

function handleDrawerDropdown(e) {
    const parent = e.currentTarget.closest('.drawer-dropdown');
    const isActive = parent.classList.contains('active');

    // Close all dropdowns
    document.querySelectorAll('.drawer-dropdown').forEach(dropdown => {
        dropdown.classList.remove('active');
    });

    // Toggle current dropdown
    if (!isActive) {
        parent.classList.add('active');
    }
}

// ===== HERO SLIDER =====
function initHeroSlider() {
    if (!DOM.heroSlider) return;

    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slider-dots');
    const prevBtn = document.querySelector('.slider-arrows .prev');
    const nextBtn = document.querySelector('.slider-arrows .next');

    if (!slides.length || !dotsContainer) return;

    // Create dots
    slides.forEach((_, index) => {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    function goToSlide(n) {
        slides[state.currentSlide].classList.remove('active');
        dots[state.currentSlide].classList.remove('active');

        state.currentSlide = (n + slides.length) % slides.length;

        slides[state.currentSlide].classList.add('active');
        dots[state.currentSlide].classList.add('active');
    }

    function nextSlide() {
        goToSlide(state.currentSlide + 1);
    }

    function prevSlide() {
        goToSlide(state.currentSlide - 1);
    }

    function startAutoSlide() {
        state.slideInterval = setInterval(nextSlide, CONFIG.slideInterval);
    }

    function stopAutoSlide() {
        clearInterval(state.slideInterval);
    }

    // Event listeners
    prevBtn?.addEventListener('click', () => {
        prevSlide();
        stopAutoSlide();
        startAutoSlide();
    });

    nextBtn?.addEventListener('click', () => {
        nextSlide();
        stopAutoSlide();
        startAutoSlide();
    });

    // Auto slide
    startAutoSlide();

    // Pause on hover
    DOM.heroSlider.addEventListener('mouseenter', stopAutoSlide);
    DOM.heroSlider.addEventListener('mouseleave', startAutoSlide);
}

// ===== SCROLL EFFECTS =====
function initScrollEffects() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;

            e.preventDefault();
            const target = document.querySelector(href);

            if (target) {
                const headerHeight = DOM.header?.offsetHeight || 0;
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
    DOM.backToTop?.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ===== MODAL =====
function initModal() {
    if (!DOM.modal) return;

    // Close on outside click
    window.addEventListener('click', (event) => {
        if (event.target === DOM.modal) {
            closeModal();
        }
    });

    // Close on ESC key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && DOM.modal.style.display === 'block') {
            closeModal();
        }
    });
}

function openModal() {
    if (!DOM.modal) return;

    DOM.modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    if (!DOM.modal) return;

    DOM.modal.style.display = 'none';
    document.body.style.overflow = '';
}

// ===== FORM VALIDATION & SUBMISSION =====
function initForm() {
    if (!DOM.form) return;

    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const inputs = DOM.form.querySelectorAll('input[required], textarea[required]');

    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => clearFieldError(input));
    });

    // Form submission
    DOM.form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Validate all fields
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) isValid = false;
        });

        if (!isValid) {
            showMessage('Veuillez corriger les erreurs avant de soumettre.', 'error');
            return;
        }

        // Disable button and show spinner
        if (submitButton) {
            submitButton.disabled = true;
            const icon = submitButton.querySelector('i');
            if (icon) icon.style.display = 'none';
        }

        if (loadingSpinner) {
            loadingSpinner.style.display = 'inline-block';
        }

        try {
            const formData = new FormData(DOM.form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const response = await fetch(DOM.form.action, {
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
                DOM.form.reset();

                setTimeout(() => closeModal(), 2000);
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
            if (submitButton) {
                submitButton.disabled = false;
                const icon = submitButton.querySelector('i');
                if (icon) icon.style.display = 'inline';
            }
            if (loadingSpinner) {
                loadingSpinner.style.display = 'none';
            }
        }
    });
}

// ===== FIELD VALIDATION =====
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    const errorElement = document.getElementById(`${fieldName}-error`);

    if (!errorElement) return true;

    let errorMessage = '';

    // Validation rules
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

function clearFieldError(field) {
    const errorElement = document.getElementById(`${field.name}-error`);
    if (errorElement) {
        errorElement.style.display = 'none';
        errorElement.textContent = '';
    }
    field.style.borderColor = '#e2e8f0';
}

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

// ===== MESSAGE DISPLAY =====
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
    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

    setTimeout(() => {
        messageDiv.style.animation = 'fadeOut 0.4s ease';
        setTimeout(() => messageDiv.remove(), 400);
    }, CONFIG.messageTimeout);
}

// ===== ANIMATIONS =====
function initAnimations() {
    const elements = document.querySelectorAll('.feature-card, .news-card, .gallery-item');

    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
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

// ===== ACTIVE MENU ITEM =====
function setActiveMenuItem() {
    const currentPath = window.location.pathname;

    // Desktop menu
    document.querySelectorAll('.nav-links a').forEach(link => {
        const linkPath = new URL(link.href).pathname;
        if (linkPath === currentPath) {
            link.classList.add('active');
        }
    });

    // Drawer menu
    document.querySelectorAll('.drawer-links a').forEach(link => {
        const linkPath = new URL(link.href).pathname;
        if (linkPath === currentPath) {
            link.classList.add('active');
        }
    });
}

// ===== UTILITY FUNCTIONS =====
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ===== ADD ANIMATIONS STYLES =====
if (!document.getElementById('judo-animations')) {
    const style = document.createElement('style');
    style.id = 'judo-animations';
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
}

// ===== EXPOSE PUBLIC API =====
window.JudoApp = {
    openDrawer,
    closeDrawer,
    openModal,
    closeModal,
    showMessage,
    scrollToTop: () => DOM.backToTop?.click()
};
