// Animation simple à l’apparition des cartes
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".card");
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate-card");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.2 }
    );

    cards.forEach((card) => {
        observer.observe(card);
    });
});

// Effet d’apparition (fade + slide)
const style = document.createElement("style");
style.textContent = `
.animate-card {
    opacity: 1 !important;
    transform: translateY(0) !important;
    transition: all 0.8s ease;
}
.card {
    opacity: 0;
    transform: translateY(50px);
}
`;
document.head.appendChild(style);
