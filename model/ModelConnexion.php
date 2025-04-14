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
        $user = $query->fetch(PDO::FETCH_ASSOC);//récupérer la prochaine ligne d'un ensemble de résultats provenant d'une requête SQ

        // Vérifiez si l'utilisateur existe et vérifiez le mot de passe
        if ($user && password_hash($password, PASSWORD_DEFAULT)) {
            return $user;
        }
        return false;
    }

    // Enregistrer l'historique de connexion
    public function recordConnection($userId) {
        $query = $this->database->prepare("INSERT INTO sessions (user_id) VALUES (?)");
        return $query->execute([$userId]);
    }

    // Récupérer l'historique de connexion
    public function getConnectionHistory($userId) {
        $query = $this->database->prepare('SELECT * FROM sessions WHERE user_id = :user_id ORDER BY login_time DESC');
        $query->bindParam(':user_id', $userId);
        try {
            $query->execute();
            // Retournez les résultats sous forme de tableau
            return $query->fetchAll(PDO::FETCH_ASSOC) ?: []; // Retourne un tableau vide si aucun résultat
        } catch (PDOException $e) {
            // Gérer l'erreur ici, éventuellement logger ou retourner un message d'erreur
            echo "Erreur : " . $e->getMessage();
            return []; // Assurez-vous de retourner un tableau vide en cas d'erreur
        }

    }
    

    public function getSessionHistory($userId) {
        try {
            $query = $this->database->prepare(
                "SELECT login_time, logout_time,user_id,
                u.nom AS user_name, 
                DATE_FORMAT(login_time, '%d/%m/%Y %H:%i') as login_formatted,
                DATE_FORMAT(logout_time, '%d/%m/%Y %H:%i') as logout_formatted,
                TIMEDIFF(logout_time, login_time) as duree
                FROM sessions s
                INNER JOIN users u ON s.user_id = u.id 
                WHERE user_id = :user_id 
                ORDER BY login_time DESC"
            );
            $query->execute([':user_id' => $userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'historique des sessions : " . $e->getMessage());
            return [];
        }
    }
    public function getLastLogin($userId) {
        try {
            $query = "SELECT 
                        DATE_FORMAT(login_time, '%d/%m/%Y à %H:%i') AS last_login,
                        TIMESTAMPDIFF(HOUR, login_time, NOW()) AS hours_ago
                      FROM sessions 
                      WHERE user_id = ?
                      ORDER BY login_time DESC 
                      LIMIT 1";
            
            $stmt = $this->database->prepare($query);
            $stmt->execute([$userId]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ?: ['last_login' => 'Première connexion', 'hours_ago' => null];
        } catch(PDOException $e) {
            error_log("Erreur dernière connexion : " . $e->getMessage());
            return ['last_login' => 'Information indisponible', 'hours_ago' => null];
        }
    }

    // Données pour graphique temporel
    public function getLoginTrends() {
        $query = "SELECT 
                    DATE(login_time) AS date,
                    COUNT(*) AS count
                    FROM sessions
                    GROUP BY DATE(login_time)
                    ORDER BY DATE(login_time) DESC
                    LIMIT 30";
        
        return $this->database->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Données pour répartition par heure
    public function getHourlyDistribution() {
        $query = "SELECT 
                    HOUR(login_time) AS hour,
                    COUNT(*) AS count
                    FROM sessions
                    GROUP BY HOUR(login_time)
                    ORDER BY HOUR(login_time)";
        
        return $this->database->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Données pour répartition par navigateur
    public function getBrowserStats() {
        try {
            $query = "SELECT 
                    CASE 
                        WHEN user_agent LIKE '%Chrome%' THEN 'Chrome'
                        WHEN user_agent LIKE '%Firefox%' THEN 'Firefox'
                        WHEN user_agent LIKE '%Safari%' THEN 'Safari'
                        WHEN user_agent LIKE '%Edge%' THEN 'Edge'
                        ELSE 'Autre'
                    END as browser,
                    COUNT(*) as count
                    FROM sessions
                    WHERE user_agent IS NOT NULL AND user_agent != ''
                    GROUP BY browser
                    ORDER BY count DESC";
            
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur stats navigateurs : " . $e->getMessage());
            return [];
        }
    }

    public function getUserSessionStats() {
        try {
            $query = "SELECT 
                        u.username AS user_name,
                        COUNT(s.id) AS session_count
                      FROM sessions s
                      INNER JOIN users u ON s.user_id = u.id
                      WHERE s.user_id IS NOT NULL
                      GROUP BY u.id
                      ORDER BY session_count DESC";
            
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur stats utilisateurs : " . $e->getMessage());
            return [];
        }
    }

    // public function showCharts() {
    //     $data = [
    //         'trends' => $this->getLoginTrends(),
    //         'hours' => $this->getHourlyDistribution(),
    //         'browsers' => $this->getBrowserStats(),
    //         'users' => $this->getUserSessionStats()
    //     ];
    //     return $data;
    // }
}
?>