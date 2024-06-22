      <!DOCTYPE html>
      <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        {{-- Scripts Vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

      </head>

      <body class="font-sans antialiased dark:bg-black dark:text-white/50  bg-gray-300">
      {{-- Sidebar From FlowBite   /components/sidebar --}}
    <x-sidebar></x-sidebar>
      {{-- Sidebar From FlowBite   /components/dashNav --}}

    <x-dashNav></x-dashNav>

      {{-- FlowBite Container  --}}
            <div class="p-4 sm:ml-64 bg-grey-200">
                <div class="p-4  border-grey-900 border-1 rounded-lg shadow-lg bg-white dark:border-gray-700 mt-14">
                    {{-- Slot Default by laravel --}}
                    <main>
                        {{ $slot }}
                    </main>
                </div>


   
            </div>
 
      </body>

      </html>