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
        <?php  
        if (isset($history) && !empty($history)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Date de Connexion</th></tr>";
        foreach ($history as $entry) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($entry['surname']) . "</td>";
            echo "<td>" . htmlspecialchars($entry['email']) . "</td>";
            echo "<td>" . htmlspecialchars($entry['password']) . "</td>";
            echo "<td>" . htmlspecialchars($entry['id']) . "</td>";
            echo "<td>" . htmlspecialchars($entry['login_time']) . "</td>";
            echo "</tr>";
        }
            echo "</table>";
            echo "ID de l'utilisateur : " . htmlspecialchars($_SESSION['user_id']);
        } else {
            echo "Aucun historique des connexions trouvé.";
        } ?>
        
        
    </table>
    <a href="../Router.php?action=logout">Déconnexion</a>
   
</body>
</html>