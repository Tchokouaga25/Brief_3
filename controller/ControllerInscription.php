<?php

require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ .'/../model/ModelInscription.php';
require_once __DIR__ .'/../model/ModelRole.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// $database = database::getConnection();
class ControllerInscription{
    public $modelInscription;
    public $modelRole;
    public $roles;
    public $database;
    public function __construct($database) {
        $database = new Database();
        $database = $database->getPDO();
        $this->database= $database;
        $this->modelInscription = new ModelInscription($database);
        
        $this->modelRole = new ModelRole($database); // Initialize modelRole
        $this->roles = $this->modelRole->getRoles(); // Fetch roles
    }
   
    
    

    // EnregistreMent dans la BD
    public function Save() {
        // print_r($_POST);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // $id = trim($_POST['id']),
            $email = filter_var(trim(($_POST['email'])), FILTER_VALIDATE_EMAIL);
            $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
            $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8'); // Clean input
            $role_id = $_POST['role_id'];
            

            // Verifions le base de donne (gestion des erreurs)
            if (empty($email) || empty($password) || empty($username)|| empty($role_id)) {
                $_SESSION["error"] = "Tous les champs sont obligatoires.";
                require '../views/ViewsInscription.php';
                return;
            }
            if (!isset($this->modelInscription)) {
                throw new Exception("Le modèle d'inscription n'est pas initialisé.");
            }
            if ($this->modelInscription->emailExists($email)) {
                $_SESSION["error"]= "Cet email est déjà utilisé.";
                header('Location: ../Router/Router.php?action=inscription');
                return;
            }
            // $hashed_Password = password_hash($password, PASSWORD_DEFAULT);
            $userss=$this->modelInscription->Saveusers($username, $email, $password,$role_id);
            if ($userss) {
                header('Location: ../Router/Router.php?action=login!&$id=userss');
                $_SESSION["success"]="Inscription reussie ! Connectez-vous";
                exit();
            } else {
                 // Gestion de l'erreur si l'enregistrement échoue
                 $_SESSION["error"] = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
           
        }
        require '../views/ViewsInscription.php';
    }


    // Afficher tous les utilisateurs
    public function index() {
        $users = $this->modelInscription->getAllUsers();
        return $users; // Retourner les utilisateurs au lieu d'inclure la vue
    }

    // Ajouter un utilisateur
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $role =(int) $_POST['role_id'] ?? null;

            if (!$username || !$email || !$role) {
                $_SESSION["error"] = "Erreur : Tous les champs sont obligatoires !";
                header("Location: ../Router/Router.php?action=inde");
                exit;
            }
            $success = $this->modelInscription->addUser($username, $email, $role);

            if ($success) {
                $_SESSION["success"] = "Utilisateur ajouté avec succès !";
            } else {
                $_SESSION["error"] = "Une erreur s'est produite lors de l'ajout de l'utilisateur.";
            }
    
            header("Location: ../Router/Router.php?action=inde");
            exit;
        } else  {
            echo "<pre>";
            print_r($_POST); // Affiche les données envoyées
            echo "</pre>";
            exit;// Vérification
        }
        

        
    }

    // Modifier un utilisateur
    public function editUser($userId) {
        $user = $this->modelInscription->getUserById($userId);
        if (!$user) {
            $_SESSION["error"] = "Utilisateur non trouvé.";
            header("Location: ../views/ViewsHistoriqueUsers.php");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $role = isset($_POST['role_id']) ? $_POST['role_id'] : '';

            // Validation des données
            if (empty($username) || empty($email) || empty($role)) {
                $_SESSION["error"] = "Tous les champs sont obligatoires.";
                include '../views/ViewsEditUser.php';
                return;
            }

            // Valider l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION["error"] = "L'adresse email n'est pas valide.";
                include '../views/ViewsEditUser.php';
                return;
            }

            if ($this->modelInscription->updateUser($userId, $username, $email, $role)) {
                $_SESSION["success"] = "Utilisateur modifié avec succès !";
                header("Location: ../views/ViewsHistoriqueUsers.php");
                exit;
            } else {
                $_SESSION["error"] = "Erreur lors de la modification de l'utilisateur.";
                include '../views/ViewsEditUser.php';
                return;
            }
        } else {
            include '../views/ViewsEditUser.php';
        }
    }

    // Supprimer un utilisateur
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['user_id'];
            $this->modelInscription->deleteUser($id);
            header("Location: ../views/ViewsHistoriqueUsers.php");
        }
    }

    
    public function getActif($status){
        return $this->modelInscription->getActif($status);
    }

    public function compterInscriptionsAujourdhui(){
        return $this->modelInscription->compterInscriptionsAujourdhui();
    }

    public function getInactif($status){
        return $this->modelInscription->getInactif($status);
    }
    public function afficherStatut($status){
        return $this->modelInscription->afficherStatut($status);
    }

    

    
        // public function getRoles() {
        //     return $this->roles;
        // }
        
        // public function getRoleById($role_id) {
        //     return $this->modelRole->getRoleById($role_id);
        // }
        
        // public function getUserById($id) {
        //     return $this->modelInscription->getUserById($id);
        // }
        
        // public function updateUser($id, $username, $email, $role_id) {
        //     return $this->modelInscription->updateUser($id, $username, $email, $role_id);
        // }
        
        // public function deleteUser($id) {
        //     return $this->modelInscription->deleteUser($id);
        // }

}

?>