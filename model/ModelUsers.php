<?php
require_once __DIR__ .'/../Condig/database.php';

class ModelUsers {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
     // Fonction pour récupérer tous les utilisateurs
    public function getAllUsers() {
        try {
            $stmt = $this->database->getPDO()->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllUsers: " . $e->getMessage());
            return [];
        }
    }
    // Fonction pour compter les utilisateurs connectés
    public function countConnectedUsers($role = null) {
        try {
            $query = "SELECT COUNT(*) FROM users WHERE is_connected = 1";
            if ($role) {
                $query .= " AND role = :role";
            }
            $stmt = $this->database->getPDO()->prepare($query);
            if ($role) {
                $stmt->bindParam(':role', $role);
            }
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error in countConnectedUsers: " . $e->getMessage());
            return 0;
        }
    }
      // Fonction pour obtenir un utilisateur spécifique
    public function getUserById($Id) {
        $stmt = $this->database->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $Id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Fonction pour mettre à jour le profil utilisateur
    public function updateUser($Id, $username, $email, $role) {
        $stmt = $this->database->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
        $stmt->bindParam(':id', $Id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }
}
?>