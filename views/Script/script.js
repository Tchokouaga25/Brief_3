
    
    // Script pour le menu mobile
    document.querySelector('button').addEventListener('click', function() {
        document.querySelector('aside').classList.toggle('-translate-x-full');
    });

    
    function loadDoc() {
        const container = document.getElementById('result-container');
        
        // Feedback visuel pendant le chargement
        container.innerHTML = '<div class="loading">Chargement...</div>';
        
        const xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    container.innerHTML = this.responseText;
                    
                    // Utiliser requestAnimationFrame pour attendre la mise à jour du DOM
                    requestAnimationFrame(() => {
                        initializeCharts(); // Initialiser les graphiques
                    });
                } else {
                    container.innerHTML = '<div class="error">Erreur de chargement (HTTP ' + this.status + ')</div>';
                }
            }
        };
        
        xhttp.onerror = function() {
            container.innerHTML = '<div class="error">Problème de connexion</div>';
        };
        
        xhttp.open("GET", "ViewsStatistique.php");
        xhttp.send();
    }
    function initializeCharts() {
        // Graphique des tendances
        var ctxTrend = document.getElementById('trendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['Janvier', 'Février', 'Mars', 'Avril'],
                datasets: [{
                    label: 'Connexions',
                    data: [12, 19, 3, 5],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false
                }]
            }
        });
    
        // Graphique horaire
        var ctxHour = document.getElementById('hourChart').getContext('2d');
        new Chart(ctxHour, {
            type: 'bar',
            data: {
                labels: ['00:00', '06:00', '12:00', '18:00'],
                datasets: [{
                    label: 'Activité horaire',
                    data: [5, 10, 15, 20],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            }
        });
    
        // Graphique des navigateurs
        var ctxBrowser = document.getElementById('browserChart').getContext('2d');
        new Chart(ctxBrowser, {
            type: 'pie',
            data: {
                labels: ['Chrome', 'Firefox', 'Safari', 'Edge'],
                datasets: [{
                    data: [50, 30, 15, 5],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            }
        });
    
        // Graphique des utilisateurs
        var ctxUser = document.getElementById('userChart').getContext('2d');
        new Chart(ctxUser, {
            type: 'pie',
            data: {
                labels: ['Utilisateur A', 'Utilisateur B', 'Utilisateur C'],
                datasets: [{
                    data: [100, 200, 300],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            }
        });
    }
    
    
    

    function loadDoc1() {
        const container = document.getElementById('result-container');
        
        // Feedback visuel pendant le chargement
        container.innerHTML = '<div class="loading">Chargement...</div>';
        
        const xhttp = new XMLHttpRequest();
        
        // Gestion améliorée de la réponse
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) { // Requête terminée
                if (this.status === 200) { // Statut HTTP OK
                    container.innerHTML = this.responseText;
                } else { // Gestion des erreurs HTTP
                    container.innerHTML = '<div class="error">Erreur de chargement (HTTP ' + this.status + ')</div>';
                }
            }
        };
        
        // Gestion des erreurs réseau
        xhttp.onerror = function() {
            container.innerHTML = '<div class="error">Problème de connexion</div>';
        };
        
        xhttp.open("GET", "ViewsHistoriqueConnexion.php");
        xhttp.send();
    }

    function loadDoc2() {
        const container = document.getElementById('result-container');
        
        // Feedback visuel pendant le chargement
        container.innerHTML = '<div class="loading">Chargement...</div>';
        
        const xhttp = new XMLHttpRequest();
        
        // Gestion améliorée de la réponse
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) { // Requête terminée
                if (this.status === 200) { // Statut HTTP OK
                    container.innerHTML = this.responseText;
                } else { // Gestion des erreurs HTTP
                    container.innerHTML = '<div class="error">Erreur de chargement (HTTP ' + this.status + ')</div>';
                }
            }
        };
        
        // Gestion des erreurs réseau
        xhttp.onerror = function() {
            container.innerHTML = '<div class="error">Problème de connexion</div>';
        };
        
        xhttp.open("GET", "ViewsRole.php");
        xhttp.send();
    }

    function loadDoc3() {
        const container = document.getElementById('result-container');
        
        // Feedback visuel pendant le chargement
        container.innerHTML = '<div class="loading">Chargement...</div>';
        
        const xhttp = new XMLHttpRequest();
        
        // Gestion améliorée de la réponse
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) { // Requête terminée
                if (this.status === 200) { // Statut HTTP OK
                    container.innerHTML = this.responseText;
                } else { // Gestion des erreurs HTTP
                    container.innerHTML = '<div class="error">Erreur de chargement (HTTP ' + this.status + ')</div>';
                }
            }
        };
        
        // Gestion des erreurs réseau
        xhttp.onerror = function() {
            container.innerHTML = '<div class="error">Problème de connexion</div>';
        };
        
        xhttp.open("GET", "ViewsHistoriqueUsers.php");
        xhttp.send();
    } 

    function loadDoc4() {
        const container = document.getElementById('result-container');
        
        // Feedback visuel pendant le chargement
        container.innerHTML = '<div class="loading">Chargement...</div>';
        
        const xhttp = new XMLHttpRequest();
        
        // Gestion améliorée de la réponse
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) { // Requête terminée
                if (this.status === 200) { // Statut HTTP OK
                    container.innerHTML = this.responseText;
                } else { // Gestion des erreurs HTTP
                    container.innerHTML = '<div class="error">Erreur de chargement (HTTP ' + this.status + ')</div>';
                }
            }
        };
        
        // Gestion des erreurs réseau
        xhttp.onerror = function() {
            container.innerHTML = '<div class="error">Problème de connexion</div>';
        };
        
        xhttp.open("GET", "dashboard.php");
        xhttp.send();
    }

    function loadDoc5() {
        const container = document.getElementById('result-container');
        
        // Feedback visuel pendant le chargement
        container.innerHTML = '<div class="loading">Chargement...</div>';
        
        const xhttp = new XMLHttpRequest();
        
        // Gestion améliorée de la réponse
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) { // Requête terminée
                if (this.status === 200) { // Statut HTTP OK
                    container.innerHTML = this.responseText;
                } else { // Gestion des erreurs HTTP
                    container.innerHTML = '<div class="error">Erreur de chargement (HTTP ' + this.status + ')</div>';
                }
            }
        };
        
        // Gestion des erreurs réseau
        xhttp.onerror = function() {
            container.innerHTML = '<div class="error">Problème de connexion</div>';
        };
        
        xhttp.open("GET", "ViewsHistoriqueConnexion_new.php");
        xhttp.send();
    }

   
