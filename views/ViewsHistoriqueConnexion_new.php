<?php
// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../Condig/database.php';
require_once __DIR__ . '/../model/ModelUsers.php';
require_once __DIR__ . '/../model/ModelRole.php';
require_once __DIR__ . '/../controller/ControllerRole.php';
require_once __DIR__ . '/../model/ModelInscription.php';
require_once __DIR__ . '/../controller/ControllerInscription.php';
require_once(__DIR__ .'/../controller/ControllerAdmin.php');
require_once(__DIR__ .'/../controller/ControllerConnexion.php');


// // Instancier ModelUsers avec la connexion
// $modelUsers = new ModelUsers($db); // Passer $db comme argument

// Initialisation des modèles et contrôleurs
$database = new database();

$database = $database->getPDO();
$userModel = new ModelUsers($database);
$user = $userModel->getUserById($_SESSION['user_id']);



$inscriptionsAujourdhui = new ControllerInscription($database);
$Nombre5 = $inscriptionsAujourdhui->compterInscriptionsAujourdhui();
$dateInscriptions = $Nombre5['date'];
$debugUsers = $Nombre5['debug_users'];
$inscriptionsAu = new ControllerConnexion($database);
$history = $inscriptionsAu->getSessionHistory($_SESSION['user_id']);
$lastLogin = $inscriptionsAu->showLastLogin();
$data = $inscriptionsAu->showCharts();

// Débogage : Afficher les données des graphiques
error_log("Données des graphiques: " . print_r($data, true));

// Débogage : Afficher les 5 derniers utilisateurs et leurs dates
echo "<!-- Informations de débogage -->";
echo "<div style='display:none'>";
echo "Date recherchée : " . $dateInscriptions . "<br>";
echo "Derniers utilisateurs :<br>";
foreach ($debugUsers as $user) {
    echo "ID : " . $user['id'] . ", Nom d'utilisateur : " . $user['username'] . ", Créé le : " . $user['created_at'] . "<br>";
}
echo "</div>";
$status = isset($status) ? $status : ''; // Initialize status if not set
$Nombre6 = $inscriptionsAujourdhui->afficherStatut($status);



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Connexions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- En-tête -->
            <div class="bg-blue-600 text-white p-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Historique des Connexions</h1>
            </div>

            <!-- Tableau -->
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Derniere Connexion</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($debugUsers)): ?>
                                <?php foreach ($debugUsers as $debugUser): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($debugUser['username']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($debugUser['email'] ?? 'Email non disponible', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($debugUser['created_at']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                
                                                <div class="flex items-center space-x-4">
                                                    <?php if ($lastLogin['hours_ago'] !== null): ?>
                                                        <div class="text-green-500">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600"><?= htmlspecialchars($lastLogin['last_login']) ?></p>
                                                            <p class="text-sm text-gray-500">
                                                                (Il y a <?= htmlspecialchars($lastLogin['hours_ago']) ?> heure<?= $lastLogin['hours_ago'] > 1 ? 's' : '' ?>)
                                                            </p>
                                                        </div>
                                                    <?php else: ?>
                                                        <p class="text-gray-600"><?= htmlspecialchars($lastLogin['last_login']) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun historique disponible</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
