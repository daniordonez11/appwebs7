<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página con Menú - Laravel Blade</title>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #227301;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin: 0;
        }
        nav ul li a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        nav ul li a:hover {
            background-color: #000;
        }
        main {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <img src="{{ asset('img/jds.png') }}" alt="Logo" style="height: 50px; margin: 10px;">
        </ul>
    </nav>

    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Inicio</a></li>
            <li><a href="{{ url('/order') }}">Ordenes</a></li>
            <li><a href="{{ url('/services') }}">Inventario</a></li>
            <li><a href="{{ url('/personal') }}">Personal</a></li>
            <li><a href="{{ url('/about') }}">Acerca</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>
</html>