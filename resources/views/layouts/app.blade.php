<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kaon Ta! Davao – Genilla's Food Guide</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-orange-50 text-gray-800">

    @include('partials.nav')

    <main class="mx-auto max-w-7xl px-4 py-8">
        @include('partials.flash')

        @yield('content')
    </main>

    <footer class="mt-12 border-t border-orange-200 py-6 text-center text-sm text-gray-600">
        Kaon Ta! Davao – Genilla's Food Guide
    </footer>

</body>
</html>
