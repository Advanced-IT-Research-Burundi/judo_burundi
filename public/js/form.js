document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('myForm');
    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        submitButton.disabled = true;
        loadingSpinner.style.display = 'inline-block';

        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('inscription.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                alert("✅ Inscription réussie !");
                form.reset();
            } else {
                alert("❌ Erreur : " + (data.message || "Impossible d’enregistrer."));
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("⚠️ Une erreur est survenue lors de l’envoi du formulaire.");
        } finally {
            submitButton.disabled = false;
            loadingSpinner.style.display = 'none';
        }
    });
});