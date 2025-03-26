<!DOCTYPE html>
<html>
<head>
    <title>Modifier le Profil Utilisateur</title>
</head>
<body>

<h1>Modifier le Profil Utilisateur</h1>
<form method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($users['username']) ?>" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($users['email']) ?>" required>
    <br>
    <label for="role">Rôle:</label>
    <select name="role">
        <option value="client" <?= $users['role'] === 'client' ? 'selected' : '' ?>>Client</option>
        <option value="admin" <?= $users['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <br>
    <input type="submit" value="Mettre à jour">
</form>

</body>
</html>