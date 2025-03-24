<?php

require_once (__DIR__ .'/../Condig/database.php'); 
require_once(__DIR__ .'/../controller/ControllerInscription.php');
require_once(__DIR__ .'/../controller/ControllerConnexion.php');

$database = database::getConnection();
$action = $_GET['action'] ?? '';

// Instantiation des deux contrôleurs
$controllerInscription = new ControllerInscription($database);
$controllerConnexion = new ControllerConnexion($database);

switch ($action) {
    case 'home':
        require '../views/Home.php';
       break;
    case 'inscription':
        $controllerInscription->Save(); 
        // require '../views/Views_connection.php';
        break;
    case 'login':
        $controllerConnexion->login();
        break;
    case 'logout':
        $controllerConnexion->logout();
        break;
    case 'history':
        $controllerConnexion->viewHistory();
        break;
    default:
        require '../views/Home.php'; // Page par défaut
        break;
}

?>