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
    public function Saveusers($id,$email, $password, $username,$role_id) {

        $hashed_Password = password_hash($password, PASSWORD_DEFAULT);
        $query = $this->database->prepare("INSERT INTO users (id, email, hashed_Password, username, role_id) VALUES (?, ?, ?, ?,?)");
        // Utilisation de bindParam pour chaque paramètre
        // $query->bindParam(':id', $id);
        // $query->bindParam(':email', $email);
        // $query->bindParam(':password', $hashedPassword);
        // $query->bindParam(':username', $username);
        // $query->bindParam(':role_id', $role_id);
       
        $query->execute([1, $username, $email, $hashed_Password, 2]);
        // return $query->execute();
           // Exécuton La requête
        // if ($query->execute([
        //     'id' => $password,
        //     'username' => $username,
        //     'email' => $email,
        //     'password' => $password,
        //     'role_id' => $role_id,
        // ])) {
        //     echo "Inscription réussie!";
        // } else {
        //     echo "Erreur lors de l'inscription.";
        // }
        
    }
    // Vérifier si l'email existe déjà
    public function emailExists($email) {
        $query = $this->database->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchColumn() > 0;
    }
}

?>    