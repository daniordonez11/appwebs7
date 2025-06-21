<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página con Menú - Laravel Blade</title>
    @vite('resources/css/app.css')
    <style>
        /* Reset básico */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Navbar principal (logo) */
        nav.logo-bar {
            background-color: #227301;
            display: flex;
            align-items: center;
            padding: 0 20px;
            height: 70px;
            box-shadow: 0 2px 8px rgb(34 119 1 / 0.5);
        }

        nav.logo-bar img {
            height: 50px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        nav.logo-bar img:hover {
            transform: scale(1.1);
        }

        /* Navbar menú */
        nav.menu-bar {
            background-color: #227301;
            box-shadow: 0 3px 6px rgb(34 119 1 / 0.7);
        }

        nav.menu-bar ul {
            display: flex;
            justify-content: center;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 10px 0;
        }

        nav.menu-bar ul li {
            /* Sin margen para mantener espaciado con gap */
        }

        nav.menu-bar ul li a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
        }

        nav.menu-bar ul li a:hover,
        nav.menu-bar ul li a:focus {
            background-color: #185601;
            box-shadow: 0 4px 10px rgb(24 86 1 / 0.6);
            outline: none;
        }

        /* Contenido principal */
        main {
            padding: 40px 20px;
            max-width: 2000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-height: 80vh;
        }

        /* Responsive para pantallas pequeñas */
        @media (max-width: 600px) {
            nav.menu-bar ul {
                flex-direction: column;
                gap: 10px;
                padding: 15px 0;
            }

            nav.menu-bar ul li a {
                font-size: 1rem;
                padding: 12px 20px;
                text-align: center;
            }

            main {
                padding: 20px 15px;
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="logo-bar">
        <img src="{{ asset('img/jds.png') }}" alt="Logo" />
    </nav>

    <nav class="menu-bar">
        <ul>
            <li><a href="{{ url('/') }}">Inicio</a></li>
            <li><a href="{{ url('/order') }}">Órdenes</a></li>
            <li><a href="{{ url('/item') }}">Inventario</a></li>
            <li><a href="{{ url('/users') }}">Usuarios</a></li>
            <li><a href="{{ url('/about') }}">Acerca</a></li>
            li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    style="
                        background: none;
                        border: none;
                        color: white;
                        font-weight: 600;
                        font-size: 1.1rem;
                        padding: 10px 15px;
                        border-radius: 8px;
                        cursor: pointer;
                        transition: background-color 0.3s, box-shadow 0.3s;
                    "
                    onmouseover="this.style.backgroundColor='#185601'; this.style.boxShadow='0 4px 10px rgba(24,86,1,0.6)';"
                    onmouseout="this.style.backgroundColor=''; this.style.boxShadow='';"
                >
                    Cerrar Sesión
                </button>
            </form>
        </li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>
</html>
