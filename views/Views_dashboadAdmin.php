<?php 

require_once __DIR__ . '/../Condig/database.php';
require_once __DIR__ . '/../model/ModelUsers.php';
require_once __DIR__ . '/../model/ModelRole.php';
require_once __DIR__ . '/../controller/ControllerRole.php';
require_once __DIR__ . '/../model/ModelInscription.php';
require_once __DIR__ . '/../controller/ControllerInscription.php';
require_once(__DIR__ .'/../controller/ControllerAdmin.php');


// // Instancier ModelUsers avec la connexion
// $modelUsers = new ModelUsers($db); // Passer $db comme argument

// Initialisation des modèles et contrôleurs
$database = new database();

$database = $database->getPDO();
$userModel = new ModelUsers($database);
$user = $userModel->getUserById($_SESSION['user_id']);


$modelRole = new ModelRole($database);
$controllerRole = new ControllerRole($modelRole);
$roles = $modelRole->getRoles();
$rolesss = $modelRole->getRoless($user['id']);

$modelInscription = new ModelInscription($database);
$controllerInscription = new ControllerInscription($database);
$users = $controllerInscription->modelInscription->getAllUsers();

$nombre = new ControllerAdmin($database);
$Nombre= $nombre->getAllUsers();
$Nombre2= $modelRole->countRoles();
// Récupérer le statut "actif" depuis une configuration
$status = "active"; 

// Afficher le résultat
$Nombre3= $modelInscription ->getActif($status);

$status2 = "inactive"; 

// Afficher le résultat
$Nombre4= $modelInscription ->getinactif($status2);
$inscriptionsAujourdhui = $modelInscription->compterInscriptionsAujourdhui();
$Nombre5 = $inscriptionsAujourdhui['count'];
$dateInscriptions = $inscriptionsAujourdhui['date'];
$debugUsers = $inscriptionsAujourdhui['debug_users'];

// Debug: Afficher les 5 derniers utilisateurs et leurs dates
echo "<!-- Debug Info -->";
echo "<div style='display:none'>";
echo "Date recherchée: " . $dateInscriptions . "<br>";
echo "Derniers utilisateurs:<br>";
foreach ($debugUsers as $user) {
    echo "ID: " . $user['id'] . ", Username: " . $user['username'] . ", Created: " . $user['created_at'] . "<br>";
}
echo "</div>";
$Nombre6= $controllerInscription->afficherStatut($status);



// Instancier ModelUsers avec la connexion
// $modelUsers = new ModelUsers($db); // Passer $db comme argument
// Gestion de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Démarrage de la session avant tout output

// Vérification si l'utilisateur est connecté, Redirection si non connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/Views_connection.php');
    exit();
}
// Views_dashboadClient.php
if (!isset($modelUsers)) {
    require_once __DIR__ . '/../model/ModelUsers.php';
    $modelUsers = new ModelUsers($database); // Définir la variable si elle n'existe pas
}


// Vérifier que le modèle est bien passé
if (!isset($modelUsers)) {
    die("Erreur : Modèle non initialisé.");
}

// Dans Views_dashboadClient.php
// Récupérer les données de l'utilisateur

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $user = $modelUsers->getUserById($userId);
} else {
    // Gérer le cas où l'utilisateur n'est pas connecté
    die("Utilisateur non connecté !");
}
// Créer une instance de la base de données

$database = new database();

$database = $database->getPDO();

// Instantiation des deux contrôleurs

$nombre = new ControllerAdmin($database);
$Nombre= $nombre->getAllUsers();
$Adminne= $nombre->getAllAdming();
$Client= $nombre->getAllClient();

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- Inclusion de la bibliothèque Chart.js -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Votre script personnalisé -->
    <script src="path/to/your/script.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-white w-64 space-y-6 px-2 py-7 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
            <!-- Logo -->
            <div class="text-blue-600 flex items-center space-x-2 px-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="text-xl font-bold">Dashboard Admin</span>
            </div>

            <!-- Navigation -->
            <nav>
                <div id="demo">
                    <button type="button" onclick="loadDoc4()" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Dashboard
                        </button>
                </div>
                <div id="demo">
                    <button type="button" onclick="loadDoc3()" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Gestion Utilisateurs
                    </button>
                </div>
                <div id="demo" >
                    <button type="button" onclick="loadDoc2()" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Gestion des roles
                    </button>
                </div>
                <div id="demo">
                    <button type="button" onclick="loadDoc5()" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Gestion Sessions
                    </button>
                </div>
                <div id="demo">
                    <button type="button" onclick="loadDoc()" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        statistique
                    </button>
                </div>
                <a href="../Router/Router.php?action=logout" type="button"  class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                    Deconnexion
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 py-4">
                    <div class="flex items-center">
                        <button class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </button>
                        <div class="h-8 w-8 rounded-full bg-blue-500"></div>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Nombres d'Utilisateurs</h3>
                    <p class="text-2xl font-bold mt-2 text-green-600"><?= htmlspecialchars($Nombre['total'] ?? 0) ?></p>
                    
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Nombres de Roles</h3>
                    <p class="text-2xl font-bold mt-2 text-green-600"><?= htmlspecialchars($Nombre2 ?? 0) ?></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Nombres de Sessions</h3>
                    <p class="text-2xl font-bold mt-2">1,234</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Utilisateurs Actifs</h3>
                    <p class="text-2xl font-bold mt-2 text-green-600"><?= htmlspecialchars($Nombre3 ?? 0) ?></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Utilisateurs Inactifs</h3>
                    <p class="text-2xl font-bold mt-2 text-green-600"><?= htmlspecialchars($Nombre4 ?? 0) ?></p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Connection reussies</h3>
                    <p class="text-2xl font-bold mt-2">245</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-gray-500 text-sm">Connection Echoues</h3>
                    <p class="text-2xl font-bold mt-2">245</p>
                </div>
            </div>
            
            <section class="dashboard-content">
                <div id="result-container"></div>
            </section>
            <!-- Chart Section -->
            
        </div>
    </div>

    <script src="Script/script.js"></script>
</body>
</html>






