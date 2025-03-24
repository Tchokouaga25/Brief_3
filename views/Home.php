<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Document</title>
</head>
<body>

<div action="../Router/Router.php?action=Home" class="flex flex-col mt-5 isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="mx-auto max-w-2xl text-center py-5">
        <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">Bienvenue sur ma page</h2>
    </div>
    <div class="grid grid-cols-4 items-center justify-center gap-2">
        
            <button class=" w-40 text-white p-4 rounded bg-indigo-500 shadow-md flex items-center justify-center"><a href="../views/Home.php">Acceuil</a></button>
       
        
            <button class="w-40 p-4 rounded bg-white text-indigo-500 shadow-md flex items-center justify-center"><a href="../views/Views_dashboadClient.php">Mon Profile</a></button>
       
            <button  class="w-40 p-4 rounded bg-white text-indigo-500 shadow-md flex items-center justify-center"><a href="../views/ViewsInscription.php"> s'inscrire</a> </button>
        
            <button class="w-40 p-4 rounded bg-white text-indigo-500 shadow-md flex items-center justify-center"><a href="../views/Views_connection.php"> se connecter</a></button>
        
    </div>
    <div
        class="shadow-xl border border-gray-100 font-light p-8 rounded text-gray-500 bg-white mt-6">  
    </div>
</div>
</body>
</html>
