document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    window.toggleSidebar = function() {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        
        // Save state to localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    };
    
    // Restore sidebar state
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    }
    
    // Mobile sidebar functionality
    if (window.innerWidth <= 768) {
        window.toggleSidebar = function() {
            sidebar.classList.toggle('open');
        };
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !e.target.closest('.sidebar-toggle')) {
                sidebar.classList.remove('open');
            }
        });
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });
    
    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement...';
            }
        });
    });
    
    // Search functionality
    const searchInputs = document.querySelectorAll('input[type="search"], input[name="search"]');
    searchInputs.forEach(function(input) {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                // Auto-submit search form after 500ms of inactivity
                const form = input.closest('form');
                if (form) {
                    form.submit();
                }
            }, 500);
        });
    });
    
    // Tooltips initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Confirm delete functionality
    window.confirmDelete = function(id, name, route) {
        if (confirm(`Êtes-vous sûr de vouloir supprimer "${name}" ?`)) {
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = route;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    };
    
    // AJAX search functionality
    const searchBoxes = document.querySelectorAll('.ajax-search');
    searchBoxes.forEach(function(searchBox) {
        const input = searchBox.querySelector('input');
        const resultsContainer = searchBox.querySelector('.search-results');
        
        if (input && resultsContainer) {
            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value;
                
                if (query.length < 2) {
                    resultsContainer.innerHTML = '';
                    resultsContainer.style.display = 'none';
                    return;
                }
                
                timeout = setTimeout(function() {
                    const url = input.dataset.url;
                    if (url) {
                        fetch(`${url}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                displaySearchResults(data.data, resultsContainer);
                            })
                            .catch(error => {
                                console.error('Erreur de recherche:', error);
                            });
                    }
                }, 300);
            });
        }
    });
    
    function displaySearchResults(results, container) {
        if (results.length === 0) {
            container.innerHTML = '<div class="p-3 text-muted">Aucun résultat trouvé</div>';
        } else {
            const html = results.map(result => `
                <div class="search-result-item p-3 border-bottom">
                    <strong>${result.nom_complet || result.titre}</strong>
                    <div class="small text-muted">${result.email || result.extrait || ''}</div>
                </div>
            `).join('');
            container.innerHTML = html;
        }
        container.style.display = 'block';
    }
    
    // Chart initialization (placeholder for Chart.js integration)
    window.initializeCharts = function() {
        // This function can be called to initialize charts
        console.log('Charts initialization placeholder');
    };
    
    // Export functionality
    window.exportData = function(format, url) {
        window.open(`${url}?format=${format}`, '_blank');
    };
    
    // Dynamic form fields
    const addFieldButtons = document.querySelectorAll('.add-field');
    addFieldButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const template = this.dataset.template;
            const container = document.querySelector(this.dataset.container);
            if (template && container) {
                const newField = document.createElement('div');
                newField.innerHTML = template;
                container.appendChild(newField);
            }
        });
    });
    
    // Status toggle for posts
    window.toggleStatus = function(postId, currentStatus) {
        const newStatus = currentStatus === 'published' ? 'draft' : 'published';
        const confirmMessage = newStatus === 'published' ? 
            'Publier cet article ?' : 
            'Mettre cet article en brouillon ?';
            
        if (confirm(confirmMessage)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/posts/${postId}/toggle-status`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    };
});