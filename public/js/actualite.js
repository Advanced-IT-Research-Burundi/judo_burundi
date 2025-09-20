document.addEventListener('DOMContentLoaded', function() {
    
    // Share functionality
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = window.location.href;
            const title = document.querySelector('.article-title').textContent;
            
            if (this.classList.contains('share-facebook')) {
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
            } else if (this.classList.contains('share-twitter')) {
                window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank', 'width=600,height=400');
            } else if (this.classList.contains('share-linkedin')) {
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank', 'width=600,height=400');
            } else if (this.classList.contains('share-whatsapp')) {
                if (window.innerWidth <= 768) {
                    // Mobile - ouvre l'app WhatsApp
                    window.open(`whatsapp://send?text=${encodeURIComponent(title + ' ' + url)}`, '_blank');
                } else {
                    // Desktop - ouvre WhatsApp Web
                    window.open(`https://web.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + url)}`, '_blank');
                }
            }
        });
    });

    // Smooth scrolling pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animation d'entrée pour les éléments
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer pour les widgets de sidebar
    document.querySelectorAll('.sidebar-widget').forEach(widget => {
        widget.style.opacity = '0';
        widget.style.transform = 'translateY(30px)';
        widget.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(widget);
    });

    // Copier le lien de l'article dans le presse-papiers
    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            showNotification('Lien copié dans le presse-papiers!', 'success');
        }, function() {
            // Fallback pour les anciens navigateurs
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showNotification('Lien copié dans le presse-papiers!', 'success');
        });
    }

    // Ajouter un bouton de copie de lien si nécessaire
    const shareButtons = document.querySelector('.share-buttons');
    if (shareButtons) {
        const copyBtn = document.createElement('a');
        copyBtn.href = '#';
        copyBtn.className = 'share-btn';
        copyBtn.style.background = '#666';
        copyBtn.style.color = 'white';
        copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copier';
        copyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            copyToClipboard();
        });
        shareButtons.appendChild(copyBtn);
    }

    // Fonction pour afficher les notifications
    function showNotification(message, type = 'info') {
        // Vérifier si une notification existe déjà
        const existingNotification = document.querySelector('.custom-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        const notification = document.createElement('div');
        notification.className = `custom-notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        // Styles pour la notification
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#7CB342' : '#1a365d'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Animation d'entrée
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto-remove après 3 secondes
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 3000);
    }

    // Améliorer la lisibilité avec un bouton de mode sombre (optionnel)
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDark);
    }

    // Récupérer la préférence de mode sombre
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }

    // Progress bar de lecture
    function updateReadingProgress() {
        const article = document.querySelector('.article-body');
        if (!article) return;

        const scrollTop = window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = (scrollTop / docHeight) * 100;

        let progressBar = document.querySelector('.reading-progress');
        if (!progressBar) {
            progressBar = document.createElement('div');
            progressBar.className = 'reading-progress';
            progressBar.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 0%;
                height: 3px;
                background: linear-gradient(90deg, #7CB342, #689F3A);
                z-index: 9999;
                transition: width 0.3s ease;
            `;
            document.body.appendChild(progressBar);
        }

        progressBar.style.width = `${Math.min(progress, 100)}%`;
    }

    // Ajouter l'écouteur pour la barre de progression
    window.addEventListener('scroll', updateReadingProgress);

    // Estimation du temps de lecture
    function calculateReadingTime() {
        const article = document.querySelector('.article-body');
        if (!article) return;

        const text = article.textContent || article.innerText;
        const wordsPerMinute = 200;
        const words = text.trim().split(/\s+/).length;
        const readingTime = Math.ceil(words / wordsPerMinute);

        // Ajouter le temps de lecture aux métadonnées
        const metaContainer = document.querySelector('.article-meta');
        if (metaContainer && !document.querySelector('.reading-time')) {
            const readingTimeElement = document.createElement('div');
            readingTimeElement.className = 'meta-item reading-time';
            readingTimeElement.innerHTML = `
                <i class="fas fa-clock"></i>
                <span>${readingTime} min de lecture</span>
            `;
            metaContainer.appendChild(readingTimeElement);
        }
    }

    // Calculer le temps de lecture au chargement
    calculateReadingTime();

    // Améliorer l'expérience des images
    function setupImageModal() {
        const images = document.querySelectorAll('.article-body img');
        
        images.forEach(img => {
            img.style.cursor = 'pointer';
            img.addEventListener('click', function() {
                openImageModal(this.src, this.alt);
            });
        });
    }

    // Modal pour les images
    function openImageModal(src, alt) {
        const modal = document.createElement('div');
        modal.className = 'image-modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;

        const img = document.createElement('img');
        img.src = src;
        img.alt = alt;
        img.style.cssText = `
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        `;

        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            position: absolute;
            top: 20px;
            right: 30px;
            background: none;
            border: none;
            color: white;
            font-size: 3rem;
            cursor: pointer;
            z-index: 10001;
        `;

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        function closeModal() {
            modal.style.opacity = '0';
            setTimeout(() => {
                if (modal.parentNode) {
                    modal.remove();
                }
            }, 300);
        }

        modal.appendChild(img);
        modal.appendChild(closeBtn);
        document.body.appendChild(modal);

        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);

        // Fermer avec Escape
        const escapeHandler = function(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escapeHandler);
            }
        };
        document.addEventListener('keydown', escapeHandler);
    }

    // Initialiser le modal d'images
    setupImageModal();

    // Bouton retour en haut
    function setupBackToTop() {
        const backToTopBtn = document.createElement('button');
        backToTopBtn.className = 'back-to-top';
        backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        backToTopBtn.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #7CB342;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(124, 179, 66, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            font-size: 1.2rem;
        `;

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.body.appendChild(backToTopBtn);

        // Montrer/cacher le bouton selon le scroll
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.opacity = '1';
                backToTopBtn.style.visibility = 'visible';
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.visibility = 'hidden';
            }
        });
    }

    // Initialiser le bouton retour en haut
    setupBackToTop();

    // Améliorer l'accessibilité
    function setupAccessibility() {
        // Ajouter des attributs ARIA manquants
        const shareButtons = document.querySelectorAll('.share-btn');
        shareButtons.forEach((btn, index) => {
            btn.setAttribute('aria-label', `Partager sur ${btn.textContent.trim()}`);
            btn.setAttribute('role', 'button');
        });

        // Navigation au clavier pour les éléments interactifs
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                if (e.target.classList.contains('share-btn')) {
                    e.preventDefault();
                    e.target.click();
                }
            }
        });
    }

    // Initialiser l'accessibilité
    setupAccessibility();

    // Print functionality
    function setupPrintButton() {
        const sidebarWidget = document.querySelector('.sidebar-widget');
        if (sidebarWidget) {
            const printBtn = document.createElement('button');
            printBtn.className = 'back-btn';
            printBtn.style.cssText = `
                width: 100%;
                margin-top: 1rem;
                background: #1a365d;
                text-align: center;
                border: none;
                cursor: pointer;
            `;
            printBtn.innerHTML = '<i class="fas fa-print"></i> Imprimer';
            printBtn.addEventListener('click', function() {
                window.print();
            });

            const infoWidget = document.querySelector('.sidebar-widget:last-child .back-btn');
            if (infoWidget && infoWidget.parentNode) {
                infoWidget.parentNode.appendChild(printBtn);
            }
        }
    }

    // Initialiser le bouton d'impression
    setupPrintButton();

    // Console log pour déboguer (à supprimer en production)
    console.log('Actualité detail JS chargé avec succès');
});