<?php
require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ .'/../model/ModelConnexion.php';

class ControllerConnexion {
    public $modelConnexion;
    public $database;

    public function __construct($database) {
        $this->database = $database;
        $this->modelConnexion = new ModelConnexion($database);
    }

    // Gérer la connexion
    public function login() {
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

                header('Location: ../Router/Router.php?action=login');
                exit();
            } else {
                $error = "Identifiants non valides.";
                require '../views/Views_connection.php';
                return;
            }
        }

        require "../views/Views_dashboadClient.php";
    }

    // Gérer la déconnexion
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ../Router/Router.php?action=logout');
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
}
?>