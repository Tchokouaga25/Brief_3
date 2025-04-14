<?php 

require_once __DIR__ .'/../Condig/database.php';

// require_once __DIR__.'/../Config/database.php';
class ModelRole 
{
        // Stocke l'objet PDO
    public $database;

    public function __construct($database) {
        // Reçoit la connexion PDO via le constructeur
        $this->database=$database;
       
    }
    public function getRoles() {
        $stmt = $this->database->query("SELECT * FROM roles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRoleById($roleId) {
        $stmt = $this->database->prepare("SELECT * FROM roles WHERE id = :id");
        $stmt->bindParam(':id', $roleId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
    ///
    public function getRoless($userId) {
        $stmt = $this->database->prepare("
            SELECT r.name
            FROM roles r
            JOIN users u ON r.id = u.role_id
            WHERE u.id = :userId
        ");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function countRoles(){
        $stmt = $this->database->prepare("SELECT COUNT(*) as total FROM roles");
        $stmt ->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];  
    }
    public function getAllAdmin($role) {
        $stmt = $this->database->prepare("SELECT COUNT(*) AS total FROM users WHERE role_id = :name");
        $stmt->execute([':name' => $role]); // Exécution de la requête
        $result= $stmt->fetch(PDO::FETCH_ASSOC); // Récupère le total des utilisateurs avec ce rôle

        var_dump($result);
        return $result ? $result : ['total' => 0]; // Assurez-vous de retourner toujours un tableau avec 'total
    }
}
?>