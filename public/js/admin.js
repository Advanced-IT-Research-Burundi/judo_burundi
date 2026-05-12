/**
 * Administration : compléments légers (Bootstrap gère le reste).
 */

document.addEventListener('DOMContentLoaded', function () {
    // Fermer l’offcanvas mobile après clic sur un lien du menu (sans data-bs-dismiss sur le desktop)
    var offcanvasEl = document.getElementById('adminNavOffcanvas');
    if (offcanvasEl && typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
        offcanvasEl.querySelectorAll('.admin-sidebar-link[href]').forEach(function (anchor) {
            anchor.addEventListener('click', function () {
                var inst = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (inst) {
                    inst.hide();
                }
            });
        });
    }

    // Fermeture auto des alertes
    document.querySelectorAll('.content-area .alert.alert-success, .content-area .alert.alert-info').forEach((alert) => {
        setTimeout(() => {
            try {
                const inst = bootstrap.Alert.getOrCreateInstance(alert);
                inst.close();
            } catch (e) {
                /* ignore */
            }
        }, 5000);
    });

    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
            new bootstrap.Tooltip(el);
        });
    }
});

function confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
    return confirm(message);
}

function previewImage(input, previewId = 'imagePreview') {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
