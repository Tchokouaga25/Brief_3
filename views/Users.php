<?php 
require_once __DIR__ .'/../Condig/database.php';
require_once(__DIR__ .'/../controller/ControllerUsers.php');
require_once (__DIR__ .'/../model/ModelUsers.php'); // Assurez-vous que le modèle utilisateur est inclus
 // Assurez-vous que le contrôleur est inclus

// Initialisation de la base de données et du modèle utilisateur
$database = new database();
$userModel = new ModelUsers($database);
$userController = new ControllerUsers($database);

// Appel des méthodes pour obtenir les données des utilisateurs
$clientsCount = $userModel->countConnectedUsers('client');
$usersCount = $userModel->countConnectedUsers('user');
$adminsCount = $userModel->countConnectedUsers('admin');
$allUsers = $userModel->getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Utilisateurs</title>
</head>
<body>

<h1>Gestion des Utilisateurs</h1>
<?php
$clientsCount = $userModel->countConnectedUsers('client');
$usersCount = $userModel->countConnectedUsers('user');
$adminsCount = $userModel->countConnectedUsers('admin');
$allUsers = $userModel->getAllUsers();
?>
<div class="user-stats">
    <p>Nombre de clients connectés : <?= htmlspecialchars($clientsCount) ?></p>
    <p>Nombre d'utilisateurs connectés : <?= htmlspecialchars($usersCount) ?></p>
    <p>Nombre d'administrateurs connectés : <?= htmlspecialchars($adminsCount) ?></p>
</div>

<h2>Liste des utilisateurs connectés</h2>
<table class="user-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allUsers as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= $user['is_connected'] ? 'Connecté' : 'Déconnecté' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Liste des utilisateurs</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom d'utilisateur</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>status</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
                <a href="../Router/Router.php?action=edit_user&id=<?= $user['id'] ?>">Modifier</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>