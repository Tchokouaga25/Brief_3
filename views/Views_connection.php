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
                <h2 class="mt-6 text-3xl font-extrabold text-gray-600">Se Connecter.</h2>
                </div>
                <button  type="submit"
                        class="w-47  mt-3 items-center block px-1 py-1 text-sm font-medium text-center text-blue-600 transition duration-500 ease-in-out transform border-2 border-white shadow-md rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-4 h-4"
                            viewBox="0 0 48 48">
                            <defs>
                                <path id="a"
                                d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                            </defs>
                            <clipPath id="b">
                                <use xlink:href="#a" overflow="visible" />
                            </clipPath>
                            <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                            <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                            <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                            <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                            </svg>
                            <span class="ml-2"> Continue avec Google</span>
                        </div>
                </button>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-gray-600 bg-white"> Or continue with </span>
                    </div>
                </div>
                <div class="mt-8">
                <div class="mt-6">
                    <form class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600"> Email address </label>
                            <div class="mt-3">
                            <input id="email" name="email" type="email" autocomplete="email" required placeholder="Your Email"
                                class="block w-full px-5 py-3 text-base text-gray-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300" />
                            </div>
                        </div>

                        <div class="space-y-1 mt-3">
                            <label for="password" class="block text-sm font-medium text-gray-600"> Password </label>
                            <div class="mt-3">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                placeholder="Your Password"
                                class="block w-full px-4 py-3 text-base text-gray-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between my-5">
                            <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" placeholder="Your password"
                                class="w-4 h-4 text-blue-600 border-gray-200 rounded focus:ring-blue-500" />
                            <label for="remember-me" class="block ml-2 text-sm text-gray-600"> Remember me </label>
                            </div>

                            <div class="text-sm ">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500"> Forgot your password? </a>
                            </div>
                        </div>

                        <div class="my-5">
                            <button  type="submit"
                            class="flex items-center justify-center w-full  py-2 text-base font-medium text-center text-white transition duration-500 ease-in-out transform bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign in</button>
                        </div>

                        <div class="flex items-center justify-center bg-gray-100 p-4">
                            <p class="text-center text-sm text-gray-500">Don't have an account? <a href="../Router/Router.php?action=inscription" class="text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700">Register</a></p>
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