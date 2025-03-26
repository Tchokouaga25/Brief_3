<?php
require_once __DIR__ .'/../Condig/database.php';
class ModelUsers {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
     // Fonction pour récupérer tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->database->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Fonction pour compter les utilisateurs connectés
    public function countConnectedUsers($role = null) {
        $query = "SELECT COUNT(*) FROM users WHERE is_connected = 1";
        if ($role) {
            $query .= " AND role = :role";
        }
        $stmt = $this->database->prepare($query);
        if ($role) {
            $stmt->bindParam(':role', $role);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
      // Fonction pour obtenir un utilisateur spécifique
    public function getUserById($userId) {
        $stmt = $this->database->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Fonction pour mettre à jour le profil utilisateur
    public function updateUser($userId, $username, $email, $role) {
        $stmt = $this->database->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }
}
?>