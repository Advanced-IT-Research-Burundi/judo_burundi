
// Smooth scrolling for navigation links
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

// Header background change on scroll
window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(45, 80, 22, 0.95)';
        header.style.backdropFilter = 'blur(10px)';
    } else {
        header.style.background = 'linear-gradient(135deg, #2d5016 0%, #4a7c59 100%)';
        header.style.backdropFilter = 'none';
    }
});

// Gallery item hover effects
document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('mouseenter', function () {
        this.style.transform = 'scale(1.05) rotate(5deg)';
    });

    item.addEventListener('mouseleave', function () {
        this.style.transform = 'scale(1) rotate(0deg)';
    });
});

// News Management Functions
let isAdminMode = false;
let newsData = [];

function openNewsModal() {
    document.getElementById('newsModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeNewsModal() {
    document.getElementById('newsModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    document.getElementById('newsForm').reset();
}

function toggleAdminMode() {
    isAdminMode = !isAdminMode;
    const adminToggle = document.querySelector('.admin-toggle');
    const addBtn = document.querySelector('.add-news-btn');

    if (isAdminMode) {
        adminToggle.style.background = '#90c695';
        adminToggle.innerHTML = '👤';
        addBtn.style.display = 'flex';
        alert('Mode administrateur activé');
    } else {
        adminToggle.style.background = '#2d5016';
        adminToggle.innerHTML = '⚙️';
        addBtn.style.display = 'none';
        alert('Mode administrateur désactivé');
    }
}

// News filtering
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');

        const category = this.dataset.category;
        const newsCards = document.querySelectorAll('.news-card');

        newsCards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// News form submission
document.getElementById('newsForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const newsItem = {
        id: Date.now(),
        title: formData.get('title'),
        category: formData.get('category'),
        author: formData.get('author'),
        date: formData.get('date'),
        excerpt: formData.get('excerpt'),
        content: formData.get('content'),
        views: 0,
        comments: 0
    };

    // Add to news data
    newsData.push(newsItem);

    // Create and add news card to grid
    addNewsCard(newsItem);

    // Close modal and reset form
    closeNewsModal();

    alert('Article publié avec succès!');
});

function addNewsCard(news) {
    const newsGrid = document.getElementById('newsGrid');

    const categoryEmojis = {
        'competition': '🏆',
        'formation': '🎓',
        'news': '🌟'
    };

    const categoryLabels = {
        'competition': 'Compétition',
        'formation': 'Formation',
        'news': 'Actualités'
    };

    const newsCard = document.createElement('article');
    newsCard.className = 'news-card';
    newsCard.dataset.category = news.category;

    // Format date
    const date = new Date(news.date);
    const formattedDate = date.toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });

    newsCard.innerHTML = `
                <div class="news-image">
                    ${categoryEmojis[news.category] || '📰'}
                    <span class="news-badge">${categoryLabels[news.category] || 'Actualités'}</span>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">📅 ${formattedDate}</span>
                        <span class="news-author">👤 ${news.author}</span>
                    </div>
                    <h3 class="news-title">${news.title}</h3>
                    <p class="news-excerpt">${news.excerpt}</p>
                    <div class="news-actions">
                        <a href="#" class="read-more">Lire plus →</a>
                        <div class="news-stats">
                            <span>👁 ${news.views}</span>
                            <span>💬 ${news.comments}</span>
                        </div>
                    </div>
                </div>
            `;

    // Insert at the beginning of the grid
    newsGrid.insertBefore(newsCard, newsGrid.firstChild);
}

// Initialize admin mode (hidden by default)
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.add-news-btn').style.display = 'none';

    // Set default date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('newsDate').value = today;
});

// Close modal when clicking outside
document.getElementById('newsModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeNewsModal();
    }
});

// Image upload preview
document.getElementById('imageInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const uploadDiv = document.querySelector('.image-upload div');
        uploadDiv.innerHTML = `✅ Image sélectionnée: ${file.name}<br><small>Cliquez pour changer</small>`;
    }
});
// Script amélioré pour le bouton de soumission
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.contact-form');
    const submitBtn = document.getElementById('contact-submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            submitBtn.disabled = true;
        });
    }

    // Auto-hide success message après 5 secondes
    const successAlert = document.querySelector('.contact-success');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 300);
        }, 5000);
    }
});

function toggleContent(postId) {
    const excerpt = document.querySelector(`#content-${postId}`).previousElementSibling;
    const fullContent = document.getElementById(`content-${postId}`);
    const button = fullContent.nextElementSibling;

    if (fullContent.style.display === 'none') {
        excerpt.style.display = 'none';
        fullContent.style.display = 'block';
        button.textContent = 'Réduire';
    } else {
        excerpt.style.display = 'block';
        fullContent.style.display = 'none';
        button.textContent = 'Lire la suite';
    }
}

function sharePost(postId) {
    if (navigator.share) {
        navigator.share({
            title: 'Publication FBJ',
            text: 'Découvrez cette publication de la Fédération Burundaise de Judo',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Lien copié dans le presse-papiers !');
    }
}

// Script pour le bouton de soumission
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.contact-form');
    const submitBtn = document.getElementById('contact-submit-btn');

    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.textContent = 'Envoi en cours...';
            submitBtn.disabled = true;
        });
    }
});
