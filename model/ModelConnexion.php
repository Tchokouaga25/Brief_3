<?php 
require_once __DIR__ .'/../Condig/database.php';

class ModelConnexion {
    public $database;

    public function __construct($database) {
        $this->database = $database;
    }

    // Vérifier les informations de connexion
    public function login($email, $password) {
        $query = $this->database->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Vérifiez si l'utilisateur existe et vérifiez le mot de passe
        if ($user && password_hash($password, PASSWORD_DEFAULT)) {
            return $user;
        }
        return false;
    }

    // Enregistrer l'historique de connexion
    public function recordConnection($userId) {
        $query = $this->database->prepare("INSERT INTO login_history (user_id) VALUES (?)");
        return $query->execute([$userId]);
    }

    // Récupérer l'historique de connexion
    public function getConnectionHistory($userId) {
        $query = $this->database->prepare('SELECT * FROM connection_history WHERE user_id = :user_id ORDER BY connection_time DESC');
        $query->bindParam(':user_id', $userId);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>