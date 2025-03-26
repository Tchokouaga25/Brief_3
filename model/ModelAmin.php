<?php 
require_once __DIR__ .'/../Condig/database.php';

class ModelAmin {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
     // Fonction pour compter tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->database->query("SELECT COUNT(*) As total FROM users ");
        return $stmt->fetch();
    }
    
    public function getAllAdmin($role) {
        $stmt = $this->database->prepare("SELECT COUNT(*) AS total FROM users WHERE role_id = :role");
        $stmt->execute([':role' => $role]); // Exécution de la requête
        $result= $stmt->fetch(PDO::FETCH_ASSOC); // Récupère le total des utilisateurs avec ce rôle

        var_dump($result);
        return $result ? $result : ['total' => 0]; // Assurez-vous de retourner toujours un tableau avec 'total
    }

    public function getAllListUser(){
        $stmt = $this->database->query("SELECT * FROM users");
        return $stmt ->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>