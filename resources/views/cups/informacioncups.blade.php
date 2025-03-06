<!DOCTYPE html>
<html lang="en">








<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    {{-- MAPA --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- BOOTSTRAP --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">




    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.31.1.min.js'></script> <!-- Load plotly.js into the DOM -->
    {{-- JAVASCRIPT --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!--icono cargando -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- ENLACE A JS GENERAL --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        /* Estilo para el contenedor con scroll */
        .overflow-auto {
            max-height: calc(100vh - 80px);
        }








        @media (min-width: 1024px) {
            #panel-container {
                margin-left: auto;
                margin-right: auto;
            }
        }








        canvas {
            width: 100% !important;
            height: auto !important;
        }








        /* Define la animación */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }








            to {
                opacity: 1;
                transform: translateY(0);
            }
        }








        /* Aplica la animación a los elementos */
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }








        /* Define una regla de CSS para escalar los elementos al pasar el ratón por encima */
        .table-cell:hover {
            transform: scale(1.1);
            /* Escala del 110% */
            transition: transform 0.2s ease;
            /* Añade una transición suave */
        }








        /* POPUP */
        .custom-popup {
            /* Estilo del contenedor del popup */
            border-radius: 5px;
            padding: 10px;
            font-family: 'Didact Gothic';
        }








        .custom-popup h3 {
            /* Estilo del título */
            color: #007bff;
            margin-bottom: 5px;
            font-family: 'Didact Gothic';
            /* Añade el estilo de letra */
        }








        .custom-popup ul {
            /* Estilo de la lista */
            list-style: none;
            padding: 0;
            font-family: 'Didact Gothic';
            /* Añade el estilo de letra */
        }








        .custom-popup ul li {
            /* Estilo de cada ítem de la lista */
            margin-bottom: 5px;
            font-family: 'Didact Gothic';
            /* Añade el estilo de letra */
        }








        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */
            cursor: pointer;
            /* Cambia el cursor a un ícono de dedito */
        }








        /* Estilo para el enlace cuando el mouse está encima */
        .nav-link:hover {
            color: rgb(88, 226, 194);
        }








        a {
            text-decoration: none !important;
        }








        /* PARA EL NAV */
        * {
            box-sizing: border-box;
        }








        .container {
            max-width: 100%;
        }








        .nav {
            display: inline-flex;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            background-color: rgb(27, 32, 38);
            padding: 0 20px;
            border-radius: 40px;
            /* box-shadow: 0 10px 40px rgba(159, 162, 177, 0.2); */
            margin: auto;
            /* Centra horizontalmente */
        }








        .nav-item {
            color: #ffffff;
            padding: 12px;
            text-decoration: none;
            transition: .3s;
            margin: 0 6px;
            z-index: 1;
            /* font-family: 'DM Sans', sans-serif; */
            font-weight: 500;
            position: relative;
        }








        .nav-item:before {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: rgb(88, 226, 194);
            /* Cambio de color aquí */
            border-radius: 8px 8px 0 0;
            opacity: 0;
            transition: .3s;
        }








        .nav-item:not(.is-active):hover:before {
            opacity: 1;
            bottom: 0;
        }








        .nav-item.is-active:before {
            background-color: rgb(88, 226, 194);
            /* Color cuando está activo */
            opacity: 1;
            bottom: 0;
        }








        .nav-item:not(.is-active):hover {
            color: rgb(88, 226, 194);
            ;
        }








        .nav-indicator {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            transition: .4s;
            height: 5px;
            z-index: 1;
            border-radius: 8px 8px 0 0;
        }








        @media (max-width: 600px) {
            .nav {
                flex-wrap: wrap;
                padding: 0;
                /* Elimina el padding horizontal en dispositivos móviles */
                border-radius: 2;
                /* Elimina el border-radius en dispositivos móviles */
                box-shadow: none;
                /* Elimina el box-shadow en dispositivos móviles */
            }








            .nav-item {
                flex: 1 0 40%;
                /* Mostrar en dos columnas */
                padding: 10px 0;
                /* Ajusta el padding para que se vea mejor en dispositivos móviles */
                text-align: center;
            }








            .nav-indicator {
                display: none;
                /* Oculta la barra indicadora en dispositivos móviles */
            }
        }
    </style>








    <title>Información CUPS</title>
</head>








<body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center "
    style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(27 32 38));" id="top">
    {{-- CARGANDO --}}
    <div class="loading show">
        <div class="spin"></div>
    </div>
    {{-- BOTON SUBIR --}}
    <div class="boton-subir">
        <a href="#top">
            <svg class="h-8 w-8 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
            </svg>
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white ">
        @include('includes/header') <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full"> <!-- Añadir margen superior -->
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}








                    <nav class="nav mb-12 ">
                        <a href="{{ route('dashboardct') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacioncups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('curvashorariascups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Curvas Horarias</a>
                        <a href="{{ route('energiacups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Calidad Energía</a>
                        <a href="{{ route('eventoscups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Eventos</a>
                        <span class="nav-indicator"></span>
                    </nav>








                    {{-- Obtener el id_cups almacenado en la sesión --}}
                    @php
                        $id_cups = session()->get('id_cups');
                        $id_cnt = session()->get('id_cnt');
                    @endphp








                    {{-- BUSCADOR --}}
                    <div class="container ">
                        <div class="form-group">
                            <form action="{{ route('informacioncups') }}" method="GET">
                                {{-- buscador por ID cups --}}
                                <input type="text" name="id_cups" placeholder="Buscar por ID de CUPS"
                                    class="border p-2 rounded-md w-52 ml-1 text-white "
                                    style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                    @if (isset($_GET['id_cups'])) value="{{ $_GET['id_cups'] }}" @endif>
                                {{-- buscador por contador --}}
                                <input type="text" name="id_cnt" placeholder="Buscar por ID de contador"
                                    class="border p-2 rounded-md w-52 ml-1 text-white "
                                    style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                    @if (isset($_GET['id_cnt'])) value="{{ $_GET['id_cnt'] }}" @endif>

                                {{-- buscador por nombre --}}
                                <input type='text' name='nom_cups' placeholder='Buscar por nombre'
                                    class='border p-2 rounded-md w-52 ml-1 text-white'
                                    style='background-color: transparent; border-color: rgb(255, 255, 255);'
                                    @if (isset($_GET['nom_cups'])) value="{{ $_GET['nom_cups'] }}" @endif>


                                {{-- Boton buscar --}}
                                <button type="submit" class="btn btn-outline-info mb-2 ml-2 text-white"
                                    style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                    onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                    onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Buscar</button>

                                <!-- Agregar el checkbox -->
                                <div class="form-check form-switch ml-2">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" name="autoconsumo" value="S"
                                        {{ isset($_GET['autoconsumo']) && $_GET['autoconsumo'] === 'S' ? 'checked' : '' }}
                                        onchange="this.style.backgroundColor = this.checked ? 'rgb(88,226,194)' : ''; this.style.borderColor = this.checked ? 'rgb(88,226,194)' : '';">
                                    <label class="form-check-label" for="flexSwitchCheckDefault"
                                        style="color:rgb(88,226,194)">Autoconsumo</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (isset($id_cups) || isset($id_cnt) || isset($nom_cups))
                        @if (count($resultadosQ1cups) === 0)
                            <div class="flex justify-center">
                                <div class="alert alert-danger text-center max-w-max flex items-center space-x-2"
                                    role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 15 15">
                                        <path fill="#e11d48" fill-rule="evenodd"
                                            d="M0 7.5a7.5 7.5 0 1 1 15 0a7.5 7.5 0 0 1-15 0m10.147 3.354L7.5 8.207l-2.646 2.647l-.708-.707L6.793 7.5L4.146 4.854l.708-.708L7.5 6.793l2.646-2.647l.708.708L8.207 7.5l2.647 2.646z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>No se encontró información para el CUPS proporcionado.</span>
                                </div>
                            </div>
                        @else
                            <div class="col-span-1 md:col-span-1">
                                <div class="container ">








                                    <div class="card text-white  mb-3"
                                        style="
                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-3xl w-full" style="color: white;">SELECCIONE UN CUPS
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>


                                        {{-- CONTENEDOR CUERPO --}}
                                        <div class="container text-white mt-2 overflow-x-auto">
                                            <table class="w-full">
                                                <tr>
                                                    <th class="text-center" style="color:rgb(88,226,194)">ID CUPS</th>
                                                    <th class="text-center" style="color:rgb(88,226,194)">Contador
                                                    </th>
                                                    <th class="text-center" style="color:rgb(88,226,194)">Nombre CUPS
                                                    </th>
                                                    <th class="text-center" style="color:rgb(88,226,194)">Dirección
                                                        CUPS</th>
                                                    <th class="text-center" style="color:rgb(88,226,194)">Autoconsumo
                                                    </th>
                                                </tr>
                                                <tbody>
                                                    @foreach ($resultadosQ1cups as $resultado)
                                                        <tr class="highlight-row">
                                                            <td class="py-2 px-4 text-center">
                                                                <a href="{{ route('detallesinformacioncups', ['id_cups' => $resultado->id_cups, 'id_cnt' => $resultado->id_cnt, 'nom_cups'=>$resultado->nom_cups]) }}"
                                                                    data-id="{{ $resultado->id_cups }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                    {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                                    <i class="fas fa-arrow-circle-right"></i>
                                                                </a>
                                                            </td>
                                                            <td class="py-2 px-4 text-center">
                                                                <a href="{{ route('detallesinformacioncups', ['id_cups' => $resultado->id_cups, 'id_cnt' => $resultado->id_cnt, 'nom_cups'=>$resultado->nom_cups]) }}"
                                                                    data-id="{{ $resultado->id_cups }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                    {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                </a>

                                                            </td>
                                                            <td class="py-2 px-4 text-center">
                                                                <a href="{{ route('detallesinformacioncups', ['id_cups' => $resultado->id_cups, 'id_cnt' => $resultado->id_cnt, 'nom_cups'=>$resultado->nom_cups]) }}"
                                                                    data-id="{{ $resultado->id_cups }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                    {{ !empty($resultado->nom_cups) ? $resultado->nom_cups : 'No hay datos' }}
                                                                </a>

                                                            </td>
                                                            <td class="py-2 px-4 text-center">
                                                                <a href="{{ route('detallesinformacioncups', ['id_cups' => $resultado->id_cups, 'id_cnt' => $resultado->id_cnt, 'nom_cups'=>$resultado->nom_cups]) }}"
                                                                    data-id="{{ $resultado->id_cups }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                    {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2 px-4 text-center">
                                                                <a href="{{ route('detallesinformacioncups', ['id_cups' => $resultado->id_cups, 'id_cnt' => $resultado->id_cnt, 'nom_cups'=>$resultado->nom_cups]) }}"
                                                                    data-id="{{ $resultado->id_cups }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                    {{ !empty($resultado->ind_autoconsumo) ? $resultado->ind_autoconsumo : 'No hay datos' }}
                                                                </a>

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- Paginación --}}
                                            <div class="mt-4 flex justify-center">
                                            {{ $resultadosQ1cups->appends(['id_cups' => request()->get('id_cups')])->links() }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
