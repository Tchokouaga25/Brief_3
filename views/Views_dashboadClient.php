<?php
// Inclusion des fichiers nécessaires
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
    <script src="../Script/script.js"></script>

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
                <span class="text-xl font-bold">Dashboard clients</span>
            </div>

            <!-- Navigation -->
            <nav>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    Mon profil
                </a>
                <div id="demo">
                    <button type="button" onclick="loadContent('stats')" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        statistique
                    </button>
                </div>
                <div id="demo">
                    <button type="button" onclick="loadContent('history')" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                    Historique de connexion
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
                       
                        <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Bienvenue, <?= htmlspecialchars($user['username']) ?> !</h2>

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
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class=" text-xl font-bold">Nombres d'Utilisateurs</h3>
                    <p class="text-2xl font-bold mt-2 text-green-600"><?= htmlspecialchars($Nombre['total'] ?? 0) ?></p>
                    
                </div>
                
               <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class=" text-xl font-bold">Connection reussies</h3>
                    <p class="text-2xl font-bold mt-2">245</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class=" text-xl font-bold">Connection echoues</h3>
                    <p class="text-2xl font-bold mt-2">245</p>
                </div>
                
            </div>
           
            <!-- Chart Section -->
            <!-- Chart Section -->
            <div class="p-4">
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Informations de votre profil</h3>
                    
                    <!-- Formulaire pour modifier les informations -->
                    <form action="../Router/Router.php?action=update_profile" method="POST" class="space-y-4">
                        <div>
                            <label for="username" class="block text-gray-700">Nom d'utilisateur</label>
                            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required 
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required 
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700">Mot de passe</label>
                            <input type="password" name="password" id="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="p-4">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($dateInscriptions) ?></td>
                                <td class="px-6 py-4"> <?php
                                    if (is_array($rolesss)) {
                                        echo implode(', ', array_map('htmlspecialchars', $rolesss));
                                    } else {
                                        echo htmlspecialchars($rolesss);
                                    }
                                ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <?= htmlspecialchars($Nombre6 ?? 0) ?>
                                    </span>
                                </td>
                            </tr>
                            <!-- Ajouter plus de lignes ici -->
                        </tbody>
                    </table>
                </div>
            </div>
            <section class="dashboard-content">
                <div id="result-container"></div>
            </section>
        </div>
    </div>

    
            

        <!-- Script pour le menu mobile views/dashboard.php 
     <?php 
    //     if (isset($message)) {
    //         echo "<p class='text-green-500 font-semibold'>$message</p>";
    //     }
    // ?> -->
    <!-- Dans Views_dashboadClient.php -->
    <!-- <button type="button" onclick="loadContent('stats')" class="...">statistique</button>
    <button type="button" onclick="loadContent('history')" class="...">Historique de connexion</button> -->

    <!-- Dans script.js (concept) -->
    <script>
        function loadContent(contentType) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("result-container").innerHTML = this.responseText;
            }
            // Déterminez l'URL en fonction de contentType
            let url = "";
            if (contentType === 'stats') {
                url = "../viewsViewsStatistique.php"; // Exemple d'URrl//
            } else if (contentType === 'history') {
                url = "../views/ViewsHistoriqueConnexion_new.php"; // Exemple d'URL
            }
            // Ajoutez d'autres conditions si nécessaire

            if (url) {
                xhttp.open("GET", url);
                xhttp.send();
            }
        }
    </script>

    
</body>
</html>

