<?php

require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ .'/../model/ModelInscription.php';

$database = database::getConnection();
class ControllerInscription{
    public $modelInscription;
    public $database;
    public function __construct($database) {
        $this->database= $database;
        $this->modelInscription = new ModelInscription($database);
    }
    

    // EnregistreMent dans la BD
    public function Save() {
        // print_r($_POST);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // $id = trim($_POST['id']),
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $username = trim($_POST['username']);
            $role_id = $_POST['role_id'];
            

            // Verifions le base de donne (gestion des erreurs)
            if (empty($email) || empty($password) || empty($username)|| empty($role_id)) {
                $error = "Tous les champs sont obligatoires.";
                require '../views/ViewsInscription.php';
                return;
            }
            if (!isset($this->modelInscription)) {
                throw new Exception("Le modèle d'inscription n'est pas initialisé.");
            }
            if ($this->modelInscription->emailExists($email)) {
                $error = "Cet email est déjà utilisé.";
                header('Location: ../Router/Router.php?action=inscription');
                return;
            }
            $hashed_Password = password_hash($password, PASSWORD_DEFAULT);
            if ($this->modelInscription->Saveusers($username, $email, $hashed_Password,$role_id)) {
                header('Location: ../Router/Router.php?action=inscription');
                exit();
            } else {
                 // Gestion de l'erreur si l'enregistrement échoue
                    $error = "Erreur lors de l'inscription. Veuillez réessayer.";
                    require '../views/ViewsInscription.php';
            }
           
        }
        require '../views/Views_connection.php';
    }


}

?>
