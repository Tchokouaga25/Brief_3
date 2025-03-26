<?php 

require_once(__DIR__ .'/../controller/ControllerUsers.php');
require_once (__DIR__ .'/../model/ModelUsers.php'); // Assurez-vous que le modèle utilisateur est inclus
 // Assurez-vous que le contrôleur est inclus

// Initialisation du modèle utilisateur
$userModel = new ModelUsers();
$userController = new ControllerUsers($userModel);

// Appel de la méthode pour obtenir les utilisateurs
$users = $userController->listUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Utilisateurs</title>
</head>
<body>

<h1>Gestion des Utilisateurs</h1>
<p>Nombre de clients connectés : <a href="../Router/Router.php?action=list_users">c</a></p>
<p>Nombre Dùtilisateur connectés : <a href="../Router/Router.php?action=list_users"></a></p>
<p>Nombre d'administrateurs connectés : <?= htmlspecialchars($users) ?></p>

<h2>Liste des utilisateurs</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom d'utilisateur</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>stqtu</th>
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