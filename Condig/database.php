<?php 
//connexion a la base
class database {
    private static $HOST = 'localhost';
    private static $DbNAME = 'brief_3';
    private static $username = 'root';
    private static $password = '';
    private $pdo = null;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . self::$HOST . ";dbname=" . self::$DbNAME,
                self::$username,
                self::$password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
     // Méthode pour récupérer la connexion
    public function getPDO() {
        return $this->pdo;
    }

    public function disconnect() {
        $this->pdo = null;
    }

}

?>