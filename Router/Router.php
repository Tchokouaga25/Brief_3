<?php

require_once (__DIR__ .'/../Condig/database.php'); 
require_once(__DIR__ .'/../controller/ControllerInscription.php');
require_once(__DIR__ .'/../controller/ControllerConnexion.php');
require_once(__DIR__ .'/../controller/ControllerAdmin.php');




$database = new database();

// Récupérer la connexion via getConnection()
$database = $database->getPDO();

$action = $_GET['action'] ?? '';

// Instantiation des deux contrôleurs
$controllerInscription = new ControllerInscription($database);
$controllerConnexion = new ControllerConnexion($database);
$ControllerAdmin = new ControllerAdmin($database);

switch ($action) {
    case 'home':
        require '../views/Home.php';
       break;
    case 'inscription':
        $controllerInscription->Save();
        break;
    case 'login':
        $controllerConnexion->login();
        break;
    case 'logout':
        $controllerConnexion->logout();
        require '../views/Home.php';
        break;
    case 'history':
        $controllerConnexion->viewHistory();
        break;

    case 'list_users':
        $ControllerAdmin->getAllUsers();
        break;
    case 'inde':
        require '../views/ViewsInscription.php';
        $controllerInscription->index();
        break;
    case 'list_Admin':
        require '../views/Views_dashboadClient.php';
        $ControllerAdmin->getAllAdming();
        break;
    case 'list_Client':
        require '../views/Views_dashboadClient.php';
        $ControllerAdmin->getAllClient();
        break;
    case 'list_utilisateur':
        require '../views/Views_dashboadClient.php';
        $ControllerAdmin->ListeUsers();
        break;

    case 'add':
        $controllerInscription->addUser();
        break;
    case 'edit':
        $userId = $_POST['id'] ?? null; // Utiliser POST au lieu de GET et 'id' au lieu de 'userId'
        if ($userId) {
            $controllerInscription->editUser($userId);
        } else {
            echo "Error: Missing user id parameter.";
        }       
        break;
    case 'delete':
        $controllerInscription->deleteUser();
        break;
    // default:
    //     $userController->index();
    default:
        require '../views/Home.php'; // Page par défaut

        // Gestion des routes



}

?>
<?php
// Code PHP ici
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Client</title>
    <!-- Inclusion du fichier JavaScript -->
    <script src="../Script/script.js"></script>
"></script>

    
</head>
<body>
    <!-- Contenu de la page -->
    <script src="../Script/script.js"></script>
</body>
</html>
