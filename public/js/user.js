// Modal functionality
function openModal() {
    document.getElementById('registrationModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('registrationModal').style.display = 'none';
}

function scrollToRegistration() {
    closeModal();
    document.querySelector('.registration').scrollIntoView({ behavior: 'smooth' });
}

// Close modal when clicking outside
window.onclick = function (event) {
    const modal = document.getElementById('registrationModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// News functionality
function toggleAddPostForm() {
    const form = document.getElementById('addPostForm');
    form.classList.toggle('active');

    // Auto-fill current date
    if (form.classList.contains('active')) {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('postDate').value = today;
    }
}

function readMore(button) {
    const card = button.closest('.news-card');
    const title = card.querySelector('.news-title').textContent;
    const content = card.querySelector('.news-excerpt').textContent;
    const author = card.querySelector('.news-author span').textContent;
    const date = card.querySelector('.news-date').textContent;

    alert(`Article complet:\n\nTitre: ${title}\nAuteur: ${author}\nDate: ${date}\n\nContenu:\n${content}\n\n(Dans une vraie application, ceci ouvrirait une page détaillée)`);
}

// Add new post functionality
document.getElementById('postForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);
    const postData = {
        title: formData.get('postTitle'),
        category: formData.get('postCategory'),
        excerpt: formData.get('postExcerpt'),
        content: formData.get('postContent'),
        author: formData.get('postAuthor'),
        date: formData.get('postDate') || new Date().toISOString().split('T')[0]
    };

    // Create new post card
    const newsGrid = document.getElementById('newsGrid');
    const newCard = document.createElement('div');
    newCard.className = 'news-card';

    // Format date
    const dateObj = new Date(postData.date);
    const formattedDate = dateObj.toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });

    // Select icon based on category
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
                    <i class="${icon}"></i>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">${formattedDate}</span>
                        <span class="news-category">${postData.category}</span>
                    </div>
                    <h3 class="news-title">${postData.title}</h3>
                    <p class="news-excerpt">${postData.excerpt}</p>
                    <div class="news-author">
                        <i class="fas fa-user"></i>
                        <span>${postData.author}</span>
                    </div>
                    <button class="read-more" onclick="readMore(this)">Lire plus</button>
                </div>
            `;

    // Add animation for new post
    newCard.style.opacity = '0';
    newCard.style.transform = 'translateY(20px)';

    // Insert at the beginning
    newsGrid.insertBefore(newCard, newsGrid.firstChild);

    // Animate in
    setTimeout(() => {
        newCard.style.transition = 'all 0.5s ease';
        newCard.style.opacity = '1';
        newCard.style.transform = 'translateY(0)';
    }, 100);

    // Store the full content in a data attribute for the read more function
    newCard.querySelector('.news-excerpt').setAttribute('data-full-content', postData.content);

    // Show success message
    alert('Article publié avec succès !');

    // Reset form and hide it
    this.reset();
    toggleAddPostForm();

    // Scroll to the new post
    setTimeout(() => {
        newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 600);
});

// Enhanced read more function to show full content
function readMore(button) {
    const card = button.closest('.news-card');
    const title = card.querySelector('.news-title').textContent;
    const excerpt = card.querySelector('.news-excerpt');
    const fullContent = excerpt.getAttribute('data-full-content') || excerpt.textContent;
    const author = card.querySelector('.news-author span').textContent;
    const date = card.querySelector('.news-date').textContent;
    const category = card.querySelector('.news-category').textContent;

    // Create a modal-like display for the full article
    const articleModal = document.createElement('div');
    articleModal.className = 'modal';
    articleModal.style.display = 'block';
    articleModal.innerHTML = `
                <div class="modal-content" style="max-width: 600px; max-height: 80vh; overflow-y: auto;">
                    <span class="close" onclick="this.closest('.modal').remove()">&times;</span>
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <span style="background: #7CB342; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">${date}</span>
                        <span style="color: #7CB342; font-weight: 500; margin-left: 1rem;">${category}</span>
                    </div>
                    <h2 style="color: #1a365d; margin-bottom: 1rem; text-align: center;">${title}</h2>
                    <div style="text-align: center; margin-bottom: 1.5rem; color: #666;">
                        <i class="fas fa-user"></i> Par ${author}
                    </div>
                    <div style="line-height: 1.8; color: #333; text-align: justify;">
                        ${fullContent.split('\n').map(p => `<p style="margin-bottom: 1rem;">${p}</p>`).join('')}
                    </div>
                </div>
            `;

    document.body.appendChild(articleModal);

    // Close modal when clicking outside
    articleModal.addEventListener('click', function (e) {
        if (e.target === articleModal) {
            articleModal.remove();
        }
    });
}

// Form submission
document.getElementById('registrationForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Collect form data
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    // Simulate form submission
    console.log('Données d\'inscription:', data);

    // Show success message
    alert('Inscription envoyée avec succès ! Nous vous contacterons bientôt.');

    // Reset form
    this.reset();
});

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

// Header scroll effect
window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
        header.style.backdropFilter = 'blur(10px)';
    } else {
        header.style.background = '#fff';
        header.style.backdropFilter = 'none';
    }
});