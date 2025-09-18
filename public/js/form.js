document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('submitBtn');
    const messageZone = document.getElementById('messageZone');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Début de soumission du formulaire');
        
        // Nettoyer les erreurs précédentes
        clearErrors();
        
        // Préparation des données
        const formData = new FormData(form);
        
        // Debug: Afficher les données envoyées
        console.log('Données du formulaire:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Désactiver le bouton
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inscription en cours...';
        
        // Envoi AJAX vers Laravel
    });

    function showMessage(type, message) {
        let alertClass, icon;
        
        switch(type) {
            case 'success':
                alertClass = 'alert-success';
                icon = 'fas fa-check-circle';
                break;
            case 'error':
                alertClass = 'alert-danger';
                icon = 'fas fa-exclamation-triangle';
                break;
            default:
                alertClass = 'alert-info';
                icon = 'fas fa-info-circle';
        }
        
        messageZone.innerHTML = `
            <div class="alert ${alertClass}">
                <i class="${icon} me-2"></i>${message}
            </div>
        `;
        
        // Scroll vers le message
        messageZone.scrollIntoView({ behavior: 'smooth', block: 'center' });


    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const errorDiv = document.getElementById(field + '-error');
            const inputField = document.getElementById(field);
            
            if (errorDiv && inputField) {
                errorDiv.textContent = messages[0];
                errorDiv.style.display = 'block';
                inputField.classList.add('error');
            }
        }
    }

    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
        
        document.querySelectorAll('.error').forEach(el => {
            el.classList.remove('error');
        });
        
        messageZone.innerHTML = '';
    }

    // Validation en temps réel
    form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                this.classList.remove('error');
                const errorDiv = document.getElementById(this.name + '-error');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }
        });
    });
});