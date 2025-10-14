// ========== MODAL FUNCTIONALITY ==========
function openModal() {
    const modal = document.getElementById('registrationModal');
    if (modal) {
        modal.style.display = 'block';
        console.log('Modal ouvert');
    }
}

function closeModal() {
    const modal = document.getElementById('registrationModal');
    if (modal) {
        modal.style.display = 'none';
        console.log('Modal fermé');
    }
}

function scrollToRegistration() {
    closeModal();
    document.querySelector('.registration').scrollIntoView({ behavior: 'smooth' });
}

// Close modal when clicking outside
window.onclick = function (event) {
    const modal = document.getElementById('registrationModal');
    if (modal && event.target == modal) {
        closeModal();
    }
}

// ========== NEWS FUNCTIONALITY ==========
function toggleAddPostForm() {
    const form = document.getElementById('addPostForm');
    if (form) {
        form.classList.toggle('active');

        if (form.classList.contains('active')) {
            const today = new Date().toISOString().split('T')[0];
            const postDate = document.getElementById('postDate');
            if (postDate) {
                postDate.value = today;
            }
        }
    }
}

function readMore(button) {
    const card = button.closest('.news-card');
    if (!card) return;

    const title = card.querySelector('.news-title')?.textContent || 'Sans titre';
    const excerpt = card.querySelector('.news-excerpt');
    const fullContent = excerpt?.getAttribute('data-full-content') || excerpt?.textContent || 'Contenu non disponible';
    const authorElement = card.querySelector('.news-author span');
    const author = authorElement?.textContent || 'Auteur inconnu';
    const date = card.querySelector('.news-date')?.textContent || 'Date inconnue';
    const category = card.querySelector('.news-category')?.textContent || 'Actualité';

    // Créer modal avec contenu complet
    const articleModal = document.createElement('div');
    articleModal.className = 'modal';
    articleModal.style.display = 'block';
    articleModal.style.position = 'fixed';
    articleModal.style.zIndex = '1000';
    articleModal.innerHTML = `
        <div class="modal-content" style="max-width: 600px; max-height: 80vh; overflow-y: auto; margin: 5% auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <span class="close" onclick="this.closest('.modal').remove()" style="float: right; font-size: 28px; font-weight: bold; cursor: pointer; color: #666;">×</span>
            <div style="text-align: center; margin-bottom: 1.5rem; clear: both;">
                <span style="background: #7CB342; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; display: inline-block;">${date}</span>
                <span style="color: #7CB342; font-weight: 500; margin-left: 1rem; display: inline-block;">${category}</span>
            </div>
            <h2 style="color: #1a365d; margin-bottom: 1rem; text-align: center;">${title}</h2>
            <div style="text-align: center; margin-bottom: 1.5rem; color: #666;">
                <i class="fas fa-user"></i> Par ${author}
            </div>
            <div style="line-height: 1.8; color: #333; text-align: justify;">
                ${fullContent.split('\n').map(p => p.trim()).filter(p => p).map(p => `<p style="margin-bottom: 1rem;">${p}</p>`).join('')}
            </div>
        </div>
    `;

    document.body.appendChild(articleModal);

    // Fermer au clic extérieur
    articleModal.addEventListener('click', function (e) {
        if (e.target === articleModal) {
            articleModal.remove();
        }
    });

    // Fermer avec la touche Echap
    const handleEscape = (e) => {
        if (e.key === 'Escape') {
            articleModal.remove();
            document.removeEventListener('keydown', handleEscape);
        }
    };
    document.addEventListener('keydown', handleEscape);
}

// Ajouter une nouvelle actualité
const postForm = document.getElementById('postForm');
if (postForm) {
    postForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const postData = {
            title: formData.get('postTitle') || 'Sans titre',
            category: formData.get('postCategory') || 'Actualité',
            excerpt: formData.get('postExcerpt') || 'Pas de résumé',
            content: formData.get('postContent') || 'Contenu vide',
            author: formData.get('postAuthor') || 'Anonyme',
            date: formData.get('postDate') || new Date().toISOString().split('T')[0]
        };

        const newsGrid = document.getElementById('newsGrid');
        if (!newsGrid) return;

        const newCard = document.createElement('div');
        newCard.className = 'news-card';

        const dateObj = new Date(postData.date);
        const formattedDate = dateObj.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });

        const categoryIcons = {
            'Compétition': 'fas fa-trophy',
            'Événement': 'fas fa-calendar-alt',
            'Formation': 'fas fa-graduation-cap',
            'Résultats': 'fas fa-chart-line',
            'Annonce': 'fas fa-bullhorn',
            'Actualités': 'fas fa-newspaper'
        };

        const icon = categoryIcons[postData.category] || 'fas fa-newspaper';

        newCard.innerHTML = `
            <div class="news-image">
                <i class="${icon}" style="font-size: 3rem; color: #7CB342;"></i>
            </div>
            <div class="news-content">
                <div class="news-meta">
                    <span class="news-date">${formattedDate}</span>
                    <span class="news-category">${postData.category}</span>
                </div>
                <h3 class="news-title">${postData.title}</h3>
                <p class="news-excerpt" data-full-content="${postData.content}">${postData.excerpt}</p>
                <div class="news-author">
                    <i class="fas fa-user"></i>
                    <span>${postData.author}</span>
                </div>
                <a href="javascript:void(0)" class="read-more" onclick="readMore(this)" style="text-decoration: none; cursor: pointer;">
                    <i class="fas fa-arrow-right"></i> Lire plus
                </a>
            </div>
        `;

        newCard.style.opacity = '0';
        newCard.style.transform = 'translateY(20px)';

        newsGrid.insertBefore(newCard, newsGrid.firstChild);

        setTimeout(() => {
            newCard.style.transition = 'all 0.5s ease';
            newCard.style.opacity = '1';
            newCard.style.transform = 'translateY(0)';
        }, 100);

        alert('Article publié avec succès !');

        this.reset();
        toggleAddPostForm();

        setTimeout(() => {
            newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 600);
    });
}

// ========== SMOOTH SCROLLING ==========
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        const target = document.querySelector(href);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ========== HEADER SCROLL EFFECT ==========
window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (header) {
        if (window.scrollY > 100) {
            header.style.background = 'rgba(255, 255, 255, 0.95)';
            header.style.backdropFilter = 'blur(10px)';
        } else {
            header.style.background = '#fff';
            header.style.backdropFilter = 'none';
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".slide");
    const dotsContainer = document.querySelector(".slider-dots");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    let index = 0;
    let timer;
    let animationIndex = 0;

    // Liste des effets à alterner
    const animations = ["slide-left", "slide-up", "slide-fade"];

    // Créer les indicateurs
    slides.forEach((_, i) => {
        const dot = document.createElement("div");
        dot.classList.add("dot");
        if (i === 0) dot.classList.add("active");
        dot.addEventListener("click", () => showSlide(i, true));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll(".dot");

    function showSlide(i, manual = false) {
        slides.forEach(s => {
            s.classList.remove("active", "slide-left", "slide-up", "slide-fade");
        });
        dots.forEach(d => d.classList.remove("active"));

        const currentSlide = slides[i];
        const animClass = animations[animationIndex];

        currentSlide.classList.add("active", animClass);
        dots[i].classList.add("active");

        index = i;
        animationIndex = (animationIndex + 1) % animations.length;

        if (!manual) resetTimer();
    }

    function nextSlide() {
        index = (index + 1) % slides.length;
        showSlide(index);
    }

    function prevSlide() {
        index = (index - 1 + slides.length) % slides.length;
        showSlide(index);
    }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(nextSlide, 2000);
    }

    prevBtn.addEventListener("click", () => { prevSlide(); resetTimer(); });
    nextBtn.addEventListener("click", () => { nextSlide(); resetTimer(); });

    // Lancer le slider auto
    timer = setInterval(nextSlide, 5000);

    const backToTopButton = document.getElementById("backToTop");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            backToTopButton.style.display = "flex";
        } else {
            backToTopButton.style.display = "none";
        }
    });

    backToTopButton.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});