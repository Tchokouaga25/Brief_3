<?php
require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ .'/../model/ModelConnexion.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}


class ControllerConnexion {
    public $modelConnexion;
    public $database;

    public function __construct($database) {
        $this->database = $database;
        $this->modelConnexion = new ModelConnexion($database);
    }


    // Gérer la connexion
    public function login() {
        // ControllerConnexion.php

        global $modelUsers;
        // Démarrer la session une seule fois
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Créer la connexion à la base de données
            require_once __DIR__ . '/../Condig/database.php';
            $database = new database();
            $database= $database->getPDO();
    
            // 2. Instancier ModelUsers avec la connexion
            require_once __DIR__ . '/../model/ModelUsers.php';
            $modelUsers = new ModelUsers($database); // Passer $$database au constructeur
        
         // Traitement du formulaire
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                

                $user = $this->modelConnexion->login($email, $password);

                if ($user) {
                    // Enregistrer la session
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    // Enregistrer l'historique de connexion
                    $this->modelConnexion->recordConnection($user['id']);
                    $_SESSION["success"]="Inscription reussie ! Connectez-vous";
                    header('Location: ../Router/Router.php?action=login');
                    exit();
                } else {
                    $_SESSION["error"] = "Erreur lors de l'inscription. Veuillez réessayer.";
                    require '../views/Views_connection.php';
                    return;
                }
            }
        }

        require "../views/Views_dashboadClient.php";
    }

    // Gérer la déconnexion
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ../Router/Router.php?action=home');
        exit();
    }

    // Afficher l'historique des connexions
    public function viewHistory() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../Router/Router.php?action=history');
            exit();
        }

        $history = $this->modelConnexion->getConnectionHistory($_SESSION['user_id']);
        require '../views/ViewsHistorique.php';
    }
    public function getSessionHistory($userId) {
        try {
            $query = $this->database->prepare(
                "SELECT s.login_time, s.logout_time, u.username as user_name,
                DATE_FORMAT(s.login_time, '%d/%m/%Y %H:%i') as login_formatted,
                CASE 
                    WHEN s.logout_time IS NULL THEN NULL
                    ELSE DATE_FORMAT(s.logout_time, '%d/%m/%Y %H:%i')
                END as logout_formatted,
                CASE 
                    WHEN s.logout_time IS NULL THEN TIMEDIFF(NOW(), s.login_time)
                    ELSE TIMEDIFF(s.logout_time, s.login_time)
                END as duree
                FROM sessions s
                INNER JOIN users u ON s.user_id = u.id
                WHERE s.user_id = :user_id 
                ORDER BY s.login_time DESC"
            );
            $query->execute([':user_id' => $userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'historique des sessions : " . $e->getMessage());
            return [];
        }
    }
    public function showLastLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }
    
        $lastLogin = $this->modelConnexion->getLastLogin($_SESSION['user_id']);
    
        return $lastLogin;
    }

    public function showCharts() {
        $chartModel = new ModelConnexion($this->database);
        
        $data = [
            'trends' => $this->formatTrendData($chartModel->getLoginTrends()),
            'hours' => $this->formatHourlyData($chartModel->getHourlyDistribution()),
            'browsers' => $chartModel->getBrowserStats(),
            'users' => $chartModel->getUserSessionStats()
        ];

        // Débogage : Afficher les données des navigateurs
        error_log("Données navigateurs: " . print_r($data['browsers'], true));

        return $data;
    }

    public function showUserSessionStats() {
        $chartModel = new ModelConnexion($this->database);
        return $chartModel->getUserSessionStats();
    }

    private function formatTrendData($data) {
        $labels = [];
        $values = [];
        
        foreach($data as $row) {
            if (isset($row['date']) && isset($row['count'])) {
                $labels[] = $row['date'];
                $values[] = $row['count'];
            }
        }
        
        return [
            'labels' => array_reverse($labels),
            'data' => array_reverse($values)
        ];
    }

    private function formatHourlyData($data) {
        $hourly = array_fill(0, 24, 0);
        
        foreach($data as $row) {
            if (isset($row['hour']) && isset($row['count'])) {
                $hour = (int) $row['hour'];
                if ($hour >= 0 && $hour <= 23) {
                    $hourly[$hour] = $row['count'];
                }
            }
        }
        
        return [
            'labels' => range(0, 23),
            'data' => $hourly
        ];
    }
}
?>