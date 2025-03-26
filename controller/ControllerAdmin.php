<?php
require_once __DIR__ .'/../Condig/database.php';
require_once __DIR__ .'/../model/ModelAmin.php';
require_once __DIR__ .'/../model/ModelInscription.php';

$database = database::getConnection();
class ControllerAdmin{
    public $database ;
    public $modeladmin ;

    public function __construct($database) {
       
        $this->modeladmin = new ModelAmin($database);
    }

    public function getAllUsers(){
        $nombre= $this->modeladmin->getAllUsers();
        return $nombre;
    }
    
    public function getAllAdming() {
        $role = "Admin";
        $result = $this->modeladmin->getAllAdmin($role);
    
        // Ajouter un var_dump pour examiner le type et la valeur // Affiche ce que renvoie la méthode
    
        if (is_array($result) && isset($result['total'])) {
            return (int)$result['total']; // Conversion pour s'assurer que c'est un entier
        }
    
        return 0; // Valeur par défaut si le résultat n'est pas un tableau
    }
    public function getAllClient() {
        $role = "client";
        $result = $this->modeladmin->getAllAdmin($role);
    
        // Ajouter un var_dump pour examiner le type et la valeur // Affiche ce que renvoie la méthode
    
        if (is_array($result) && isset($result['total'])) {
            return (int)$result['total']; // Conversion pour s'assurer que c'est un entier
        }
    
        return 0; // Valeur par défaut si le résultat n'est pas un tableau
    }
    public function ListeUsers() {
        global $list;
        $modeladmin = new ModelInscription($list);
        $users = $this->$modeladmin->getAllListUser();
        // Ajoutez un retour rapide si $users n'est pas défini
        if (!isset($users)) {
            $users = []; // Ou vous pouvez gérer cela différemment
        }
        require __DIR__ .'/../views/Views_dashboadClient.php' ;

    }
    
}

?>