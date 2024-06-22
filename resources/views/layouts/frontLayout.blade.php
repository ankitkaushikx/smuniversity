<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- SEO Meta Tags -->
  <meta name="description" content="Your site description here">
  <meta name="keywords" content="Laravel, SEO, Web Development">
  <meta property="og:title" content="Laravel">
  <meta property="og:description" content="Your site description here">
  <meta property="og:type" content="website">
  <meta property="og:url" content="http://yourwebsite.com">
  <meta property="og:image" content="http://yourwebsite.com/image.jpg">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  {{-- Scripts Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
  <header class="p-1 bg-gray-100 dark:bg-gray-900">
    {{-- Nav Bar For Front --}}
    <x-FrontNav></x-FrontNav>
  </header>

  {{-- Main Content --}}
  <main class="container mx-auto py-1 px-1 min-h-screen">
    {{$slot}}
  </main>

  {{-- Footer  --}}
  <footer class="bg-blue-300 dark:bg-gray-900 text-center p-4">
    <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
  </footer>
</body>

</html>
