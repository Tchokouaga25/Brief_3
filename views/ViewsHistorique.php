<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Connexions</title>
</head>
<body>
    <h2>Historique des Connexions</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Date de Connexion</th>
        </tr>
        <?php foreach ($history as $record): ?>
        <tr>
            <td><?php echo $record['id']; ?></td>
            <td><?php echo $record['connection_time']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="../Router.php?action=logout">Déconnexion</a>
</body>
</html>