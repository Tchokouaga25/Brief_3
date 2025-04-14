<?php 

// require_once __DIR__ . '/../Condig/database.php';
// require_once __DIR__ . '/../model/ModelUsers.php';
// require_once __DIR__ . '/../model/ModelRole.php';
// require_once __DIR__ . '/../controller/ControllerRole.php';
// require_once __DIR__ . '/../model/ModelInscription.php';
// require_once __DIR__ . '/../controller/ControllerInscription.php';
// require_once(__DIR__ .'/../controller/ControllerAdmin.php');

// $database = new database();

// $database = $database->getPDO();

// // Instantiation des deux contrôleurs

// $nombre = new ControllerAdmin($database);
// $Nombre= $nombre->getAllUsers();
// $Adminne= $nombre->getAllAdming();
// $Client= $nombre->getAllClient();

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- Inclusion de la bibliothèque Chart.js -->
    
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            
            </section>
            <!-- Chart Section -->
            <div class="p-4">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Activité récente</h2>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">Graphique ici</span>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders Table -->
            <div class="p-4">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">John Doe</td>
                                <td class="px-6 py-4">2023-10-15</td>
                                <td class="px-6 py-4">$120</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Payé
                                    </span>
                                </td>
                            </tr>
                            <!-- Ajouter plus de lignes ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
</body>
</html>






