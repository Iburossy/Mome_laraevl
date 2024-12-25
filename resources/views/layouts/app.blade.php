<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOMEL - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Vous pouvez ajouter des styles supplémentaires ici -->
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-4">
        @include('partials.alerts')
        @yield('content')
    </div>

    
    <!-- Vous pouvez ajouter des scripts supplémentaires ici -->
</body>
</html>
