<?php 
require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ . '/../Model/ModelConnection.php'; // Include the ModelConnection class

// require_once __DIR__.'/../Config/database.php';
class ModelInscription 
{
    public $database;

    public function __construct($database) {
        $this->database = $database;
       
    }
    //insertion dans la base de donner
    

        public function Saveusers($username, $email, $password,$role_id) {
            // Vérifiez d'abord si le username existe déjà
            $stmt = $this->database->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $exists = $stmt->fetchColumn();
        
            if ($exists > 0) {
                throw new Exception("Ce nom d'utilisateur est déjà pris.");
            }
        
            // Si le nom d'utilisateur n'existe pas, procédez à l'insertion
            try {
                $stmt = $this->database->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)");
                $stmt->execute([
                    ':username' => $username,
                    ':email'    => $email,
                    ':password' => $password,
                    ':role_id'  => $role_id
                ]);
                header("Location: ../views/Views_connection.php");
                return true;
            } catch (PDOException $e) {
                error_log("Erreur lors de l'insertion de l'utilisateur : " . $e->getMessage());
                // Pour débogage, vous pouvez utiliser : echo "Erreur: " . $e->getMessage();
                return false;
            }
            // $stmt = $this->database->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)");
            // $stmt->execute([
            //     ':username' => $username,
            //     ':email' => $email,
            //     ':password' => $password,
            //     ':role_id' => $role_id
            // ]);
        }
        
    
        // Vérifier si l'email existe déjà
        public function emailExists($email) {
            $query = $this->database->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            return $query->fetchColumn() > 0;
        }


    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->database->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    // Récupérer un utilisateur par son ID
    public function getUserById($id) {
        $stmt = $this->database->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un utilisateur $username, $email, $password,$role_id
    public function addUser( $username, $email, $role_id) {
        $stmt = $this->database->prepare("INSERT INTO users ( username, email, role_id) VALUES (?, ?, ?)");
        return $stmt->execute([ $username, $email, $role_id]);
    }

    // Mettre à jour un utilisateur
    public function updateUser($id, $username, $email, $role_id ) {
        try {
            // Vérifier si le nom d'utilisateur existe déjà (sauf pour l'utilisateur actuel)
            $stmt = $this->database->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $id]);
            if ($stmt->fetchColumn() > 0) {
                $_SESSION["error"] = "Ce nom d'utilisateur est déjà utilisé.";
                return false;
            }

            $stmt = $this->database->prepare("UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $role_id, $id]);
        } catch (PDOException $e) {
            $_SESSION["error"] = "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }

    // Supprimer un utilisateur
    public function deleteUser($id) {
        $stmt = $this->database->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }


    public function getActif($status){
        $stmt = $this->database->prepare("SELECT COUNT(*) AS total FROM users WHERE status = :active");
        $stmt ->execute([':active' => $status]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];  
    }

    public function getinactif($status){
        $stmt = $this->database->prepare("SELECT COUNT(*) AS total FROM users WHERE status = :inactive");
        $stmt ->execute([':inactive' => $status]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];  
    }

    
    /**
     * Compte le nombre d'utilisateurs inscrits aujourd'hui
     * 
     * @return array Tableau contenant le nombre d'inscriptions et la date
     */
    public function compterInscriptionsAujourdhui() {
        $currentDate = date('Y-m-d', strtotime('2025-04-05')); // Using system-provided current date
        
        // D'abord, vérifions toutes les dates de création
        $debugStmt = $this->database->query("
            SELECT id, username, email, created_at 
            FROM users 
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        $recentUsers = $debugStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Ensuite, comptons pour aujourd'hui
        $stmt = $this->database->prepare("
            SELECT COUNT(*) as count
            FROM users 
            WHERE DATE(created_at) = :date
        ");
        
        $stmt->execute([':date' => $currentDate]);
        return [
            'count' => (int) $stmt->fetchColumn(),
            'date' => $currentDate,
            'debug_users' => $recentUsers // Pour voir les utilisateurs récents
        ];
    }
    

    public function afficherStatut($status) {
        $status = (string)$status; // Convert to string to avoid null
        return ($status == '1' || strtolower($status) == 'active') ? 'active' : 'inactive';
    }



    public function showSessionHistory() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        $model = new ModelConnection($this->database);
        $model->getConnectionHistory();

        $history = $model->getSessionHistory($_SESSION['user_id']);

        include '../View/historique-sessions.php';
    }




}

?>    