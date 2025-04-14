<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <title>Page connexion</title>
</head>
<body>
<h2>Connexion</h2>
    <?php if (isset($error)): ?>
        <div><?php echo $error; ?></div>
    <?php endif; ?>
<section class=" overflow-hidden">

    <form action="../Router/Router.php?action=login" method="POST" class="flex  overflow-hidden mx-auto my-auto max-w-screen-lg px-4 py-10 md:py-20 md:px-8">
        
            <div class="relative flex-1 hidden w-0 overflow-hidden  lg:block">
                <img class="absolute inset-0 object-cover w-full h-full bg-blue-500" src="/images/placeholders/original/1000x1000.webp"
                alt="" />
            </div>
            <div class="flex flex-col justify-center flex-1 px-4 py-12 overflow-hidden sm:px-6 lg:flex-none lg:px-20 xl:px-24">
                <div class="w-full max-w-xl mx-auto lg:w-96">
                    <div >
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-600">Mot de passe oublier.</h2>
                    
                    <div class="mt-6">
                        <form class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-600"> Nouveau Email address </label>
                                <div class="mt-3">
                                <input id="email" name="email" type="email" autocomplete="email" required placeholder="Your Email"
                                    class="block w-full px-5 py-3 text-base text-gray-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300" />
                                </div>
                            </div>

                            <div class="space-y-1 mt-3">
                                <label for="password" class="block text-sm font-medium text-gray-600"> Nouveau Password </label>
                                <div class="mt-3">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required
                                    placeholder="Your Password"
                                    class="block w-full px-4 py-3 text-base text-gray-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300" />
                                </div>
                            </div>

                        

                            <div class="my-5">
                                <button  type="submit"
                                class="flex items-center justify-center w-full  py-2 text-base font-medium text-center text-white transition duration-500 ease-in-out transform bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign in</button>
                            </div>

                        
                    </form>
                        
                    
                    </div>
                </div>
            </div>
            </div>
            <body>
    

</form>
</section>
</body>
</html>