<?php
// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../Condig/database.php';
require_once __DIR__ . '/../model/ModelUsers.php';
require_once __DIR__ . '/../model/ModelRole.php';
require_once __DIR__ . '/../controller/ControllerRole.php';
require_once __DIR__ . '/../model/ModelInscription.php';
require_once __DIR__ . '/../controller/ControllerInscription.php';
require_once(__DIR__ .'/../controller/ControllerAdmin.php');
require_once(__DIR__ .'/../controller/ControllerConnexion.php');


// // Instancier ModelUsers avec la connexion
// $modelUsers = new ModelUsers($db); // Passer $db comme argument

// Initialisation des modèles et contrôleurs
$database = new database();

$database = $database->getPDO();
$userModel = new ModelUsers($database);
$user = $userModel->getUserById($_SESSION['user_id']);



$inscriptionsAujourdhui = new ControllerInscription($database);
$Nombre5 = $inscriptionsAujourdhui->compterInscriptionsAujourdhui();
$dateInscriptions = $Nombre5['date'];
$debugUsers = $Nombre5['debug_users'];
$inscriptionsAu = new ControllerConnexion($database);
$history = $inscriptionsAu->getSessionHistory($_SESSION['user_id']);
$lastLogin = $inscriptionsAu->showLastLogin();
$data = $inscriptionsAu->showCharts();

// Débogage : Afficher les données des graphiques
error_log("Données des graphiques: " . print_r($data, true));

// Débogage : Afficher les 5 derniers utilisateurs et leurs dates
echo "<!-- Informations de débogage -->";
echo "<div style='display:none'>";
echo "Date recherchée : " . $dateInscriptions . "<br>";
echo "Derniers utilisateurs :<br>";
foreach ($debugUsers as $user) {
    echo "ID : " . $user['id'] . ", Nom d'utilisateur : " . $user['username'] . ", Créé le : " . $user['created_at'] . "<br>";
}
echo "</div>";
$status = isset($status) ? $status : ''; // Initialize status if not set
$Nombre6 = $inscriptionsAujourdhui->afficherStatut($status);



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Connexions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        
    <div class="bg-gray-100 p-8">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Graphique linéaire - Tendances -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-4">Connexions sur 30 jours</h2>
                <div class="w-full h-96">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Graphique en barres - Répartition horaire -->
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Activité par heure</h2>
                    <div class="w-full h-96">
                        <canvas id="hourChart"></canvas>
                    </div>
                </div>

                <!-- Camembert - Navigateurs -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Répartition par navigateur</h2>
                    <div class="w-full h-96">
                        <canvas id="browserChart"></canvas>
                    </div>
                </div>

                <!-- Camembert - Utilisateurs -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Répartition par utilisateur</h2>
                    <div class="w-full h-96">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tendances
        document.addEventListener('DOMContentLoaded', function() {
    // Tendances
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: <?= json_encode($data['trends']['labels'] ?? []) ?>,
                    datasets: [{
                        label: 'Connexions quotidiennes',
                        data: <?= json_encode($data['trends']['data'] ?? []) ?>,
                        borderColor: '#3B82F6',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Heures
            new Chart(document.getElementById('hourChart'), {
                type: 'bar',
                data: {
                    labels: <?= json_encode($data['hours']['labels'] ?? []) ?>,
                    datasets: [{
                        label: 'Connexions par heure',
                        data: <?= json_encode($data['hours']['data'] ?? []) ?>,
                        backgroundColor: '#10B981'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Navigateurs
            <?php if (!empty($data['browsers']) && is_array($data['browsers'])): ?>
                new Chart(document.getElementById('browserChart'), {
                    type: 'pie',
                    data: {
                        labels: <?= json_encode(array_column($data['browsers'], 'browser')) ?>,
                        datasets: [{
                            data: <?= json_encode(array_column($data['browsers'], 'count')) ?>,
                            backgroundColor: [
                                '#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            <?php endif; ?>

            // Utilisateurs
            <?php if (!empty($data['users'])): ?>
                new Chart(document.getElementById('userChart'), {
                    type: 'pie',
                    data: {
                        labels: <?= json_encode(array_map(function($item) { 
                            return $item['user_name'] ?? 'Utilisateur inconnu'; 
                        }, $data['users'])) ?>,
                        datasets: [{
                            data: <?= json_encode(array_map(function($item) { 
                                return $item['session_count'] ?? 0; 
                            }, $data['users'])) ?>,
                            backgroundColor: [
                                '#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });
            <?php endif; ?>

        });

    </script>
    
</body>
</html>
