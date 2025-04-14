<?php
// app/controllers/UserController.php
require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ .'/../model/ModelRole.php';

class ControllerRole {
    public $database;
    private $modelRole; // Déclaration de la propriété

    public function __construct($database) {
        $database = new database();

        // 2. Récupérer la connexion PDO
        $database = $database->getPDO();

        // 3. Instancier ModelRole avec la connexion
        $this->modelRole = new ModelRole($database); // Initialisation
       

    }
    public function showRoles() {
        // Récupérer les rôles depuis la base de données
        $database = new database(); // Assuming you have a Database class
        $modelRole = new ModelRole($database);
        $roles = $modelRole->getRoles();
        // Fetch roles from the database
        $query = "SELECT * FROM roles";
        return $this->database->query($query)->fetchAll();
       
    }

    
    public function countRoles() {
        return $this->modelRole->countRoles();
    }
}