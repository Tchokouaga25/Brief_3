<?php 
require_once __DIR__ .'/../Condig/database.php';

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
            $stmt = $this->database->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
                ':role_id' => $role_id
            ]);
        }
        
    
    // Vérifier si l'email existe déjà
    public function emailExists($email) {
        $query = $this->database->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchColumn() > 0;
    }
}

?>    