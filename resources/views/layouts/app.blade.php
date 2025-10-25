<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <header class="bg-blue-600 text-white p-4">
        <h1 class="text-xl font-bold text-center">Panel de Administración</h1>
    </header>

    <main class="p-6">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
