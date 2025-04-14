<?php

    require_once __DIR__ .'/../controller/ControllerInscription.php';
    require_once __DIR__ .'/../Condig/database.php';
    require_once __DIR__ .'/../model/ModelRole.php';
    
    require_once __DIR__ . '/../model/ModelUsers.php';

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    $database = new database();
    $database = $database->getPDO();

    $modelRole = new ModelRole($database);
    $roles = $modelRole->getRoles();

    $modelUsers = new ModelUsers($database);
    $user = $modelUsers->getUserById($userId);

    
    
    // if (isset($_SESSION['user_id'])) {
    //     $userId = $_SESSION['user_id'];
    //     $user = $modelUsers->getUserById($userId);
    // } else {
    //     // Gérer le cas où l'utilisateur n'est pas connecté
    //     die("Utilisateur non connecté !");
    // }
    // Créer une instance de la base de données

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Modifier l'utilisateur</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?= $_SESSION['error']; ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="../Router/Router.php?action=edit" method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select id="role_id" name="role_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= htmlspecialchars($role['id']) ?>" 
                                    <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-between">
                    <a href="../Router/Router.php?action=list_users" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
