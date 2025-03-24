<?php
// require_once __DIR__ .'/../Config/database.php';
require_once (__DIR__ .'/../Condig/database.php');

require_once(__DIR__ .'/../controller/ControllerInscription.php');


$route = new ControllerInscription($database);
$action = $_GET['action'] ?? 'inscription';

switch ($action) {
    case 'inscription':
        $route-> save();
        break;
    
    default:
        require '../views/ViewsInscription.php';
        break;
}

?>