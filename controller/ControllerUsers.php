<?php
require_once __DIR__ .'/../Condig/database.php';
require_once '../model/ModelUsers.php';

$database = database::getConnection();
class ControllerUsers {
    private $userModel;
    private static $users;
    private $database;
    public function __construct($database) {
        $this->database= $database;
        $this->userModel = new ModelUsers($database);
    }

    public function listUsers() {
        
        $users = $this->userModel->getAllUsers();
        return  $users;

        // include '../views/Users.php';
    }
    public function listClient() {
        $numClientsConnected = $this->userModel->countConnectedUsers('client');
        return $numClientsConnected;
        // include '../views/Users.php';
    }
    public function listAdmin() {
        $numAdminsConnected = $this->userModel->countConnectedUsers('admin');
        return $numAdminsConnected;
        // include '../views/Users.php';
    }

    public function editUser($userId) {
        // Vérifier si l'ID est passé via l'URL
        $user = $this->userModel->getUserById($userId);
        if (!$user) {
            die("Utilisateur non trouvé.");
        }
        // Traitement du formulaire de mise à jour
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $this->userModel->updateUser($userId, $username, $email, $role);
            header('Location: index.php?action=list_users');
            exit;
        }

        include '../views/UsersEdit.php';
    }
}
?>