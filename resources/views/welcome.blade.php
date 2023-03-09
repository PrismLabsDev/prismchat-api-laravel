<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Prism Chat API - Welcome</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('storage/favicon.ico') }}" />
        <link rel="apple-touch-icon" href="{{ asset('storage/favicon.ico') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
        <!-- TailwindCSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
          tailwind.config = {
            theme: {
              extend: {
                colors: {
                  'custom-pink-light': '#ff338b',
                  'custom-pink': '#FF006E',
                  'custom-pink-dark': '#cc0058',
                  'custom-pink-darker': '#990042',
                  'custom-blue-light': '#66a1ff',
                  'custom-blue': '#3A86FF',
                  'custom-blue-dark': '#1a71ff',
                  'custom-blue-darker': '#0058e6',
                },
                fontFamily: {
                  poppins: ['Poppins', 'sans-serif'],
                  lato: ['Lato', 'sans-serif'],
                },
              }
            }
          }
        </script>

        <!-- Styles -->
        <style>

        </style>
    </head>
    <body>
      <div class="bg-gradient-to-tr from-custom-pink to-custom-blue font-poppins">
        <div class="min-h-screen bg-black/[.7] text-white flex justify-center items-center">
            <div class="bg-neutral-900 w-4/5 px-10 py-20 rounded-3xl">

              <div class="text-center flex flex-col space-y-20">
                <h1 class="text-5xl font-semibold">Welcome to Prism Chat API!</h1>

                <!-- <div>
                  <p>
                    This is the Prism Chat API.
                  </p>
                </div> -->

                <div class="flex justify-around">
                  <div><a class="py-2 px-4 bg-custom-blue hover:bg-custom-blue-dark active:bg-custom-blue-darker rounded-full" href="https://prism.chat/">Prism.chat</a></div>
                  <div><a class="py-2 px-4 bg-custom-blue hover:bg-custom-blue-dark active:bg-custom-blue-darker rounded-full" href="https://app-demo.prism.chat/">Web App</a></div>
                  <div><a class="py-2 px-4 bg-custom-blue hover:bg-custom-blue-dark active:bg-custom-blue-darker rounded-full" href="https://github.com/PrismChatLabs/prismchat-server-laravel">API Repo</a></div>
                  <div><a class="py-2 px-4 bg-custom-blue hover:bg-custom-blue-dark active:bg-custom-blue-darker rounded-full" href="https://github.com/jwoodrow99/prismchat-web">Web Repo</a></div>
                  <div><a class="py-2 px-4 bg-custom-blue hover:bg-custom-blue-dark active:bg-custom-blue-darker rounded-full" href="https://www.npmjs.com/package/prismchat-lib">Prism Lib</a></div>
                </div>
              </div>
              
            </div>
        </div>
      </div>
    </body>
</html>
