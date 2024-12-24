<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOMEL - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Vous pouvez ajouter des styles supplémentaires ici -->
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-4">
        @include('partials.alerts')
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Vous pouvez ajouter des scripts supplémentaires ici -->
</body>
</html>
