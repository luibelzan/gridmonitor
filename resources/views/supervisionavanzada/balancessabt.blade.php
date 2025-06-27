<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    {{-- BOOTSTRAP --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    {{-- TAILWIND --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.31.1.min.js'></script> <!-- Load plotly.js into the DOM -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    {{-- JAVASCRIPT --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!--icono cargando -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


        @media (max-width: 767px) and (min-width: 600px) {
            #circulos {
                width: 50%;
                height: 50%;
            }
        }


        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */
        }


        /* para el popup */
        .popover-trigger {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }


        .popover-content {
            display: none;
            position: absolute;
            background-color: #2f3237;
            border: 1px solid #000000;
            border-radius: 20px;
            padding: 10px;
            /* Ajusta el padding según sea necesario */
            z-index: 1;
            white-space: nowrap;
            bottom: 100%;
            /* Position above the trigger */
            left: 50%;
            transform: translateX(-50%);
            font-size: 16px;
            /* Ajusta el tamaño de la fuente si es necesario */
        }


        .popover-trigger:hover .popover-content {
            display: block;
        }

        
        .popover-content>svg {
            vertical-align: middle;
            /* Alinea verticalmente los íconos con el texto */
            margin-right: 5px;
            /* Espacio entre el ícono y el texto */
            display: inline-block;
            /* Asegura que el ícono se comporte como un elemento en línea */
            line-height: 1;
            /* Ajusta la altura de la línea para evitar desalineación */
        }


        .popover-content span {
            display: flex;
            /* Utiliza flexbox para alinear los íconos y el texto verticalmente */
            align-items: center;
            /* Alinea verticalmente los íconos y el texto */
            margin-bottom: 5px;
            /* Espacio entre las líneas del texto */
        }
    </style>



    <title>Balances</title>
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
        @include('includes/header')
        <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full"> <!-- Añadir margen superior -->
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14 ">
                    <x-nav-sabt/>
                    <h1 class="text-center text-3xl w-full" style="color: white;">BALANCES SABT</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                        border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>

                    {{-- CONTENEDOR CUERPO --}}
                    <div class="container">
                        {{-- FILTRO AQUI --}}
                        <form
                            action="{{ route('balancessabt') }}"
                            method="GET"
                            class="flex flex-wrap items-center justify-start gap-2 mt-6">
                            {{-- FILTRO FECHAS --}}
                                                                    
                            <div class="form-group flex items-center">
                                <label for="fecha_inicio"
                                    class="text-white mr-2">Fecha
                                    de
                                    inicio:</label>
                                <input type="date" id="fecha_inicio"
                                    name="fecha_inicio"
                                    class="border border-gray-400 p-2 rounded-lg text-white"
                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                    max="{{ date('Y-m-d') }}"
                                    style="background-color: transparent;">
                            </div>
                            <div class="form-group flex items-center">
                                <label for="fecha_fin"
                                    class="text-white mr-2">Fecha
                                    de
                                    fin:</label>
                                <input type="date" id="fecha_fin"
                                    name="fecha_fin"
                                    class="border border-slate-900 p-2 rounded-lg text-white"
                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                    max="{{ date('Y-m-d') }}"
                                    style="background-color: transparent;">
                            </div>
                                                    
                            <button type="submit"
                                class="btn btn-outline-info mb-3 text-white"
                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                        </form>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
                            <div class="card text-white  mb-2"
                                style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-3xl w-full" style="color: white;">
                                    @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                        Del
                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                        al
                                        {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                    @else
                                        Ultimos 30 dias
                                    @endif
                                </h1>
                                <div class="mb-2 mt-2"
                                    style="border-bottom: 3px solid transparent;
                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>

                                <div class="overflow-x-auto flex flex-wrap  "
                                    style="display: flex; flex-wrap: nowrap; justify-content: space-around;">
                                    @foreach ($balancesSABT as $resultado)
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
                                            <div style="text-align: center; color: white;">
                                                <div
                                                    style="font-size: 18px; margin-bottom: 10px; margin-right: 30px">
                                                    {{ !empty($resultado->id_linea) ? $resultado->id_linea : 'No hay datos' }}</div>
                                                <div
                                                    style="display: inline-block; position: relative;">
                                                    @php
                                                        $colorBorde = 'green'; // Por defecto
                                                        if (!empty($resultado->porcentaje_perdida) && $resultado->porcentaje_perdida > 6) {
                                                            $colorBorde = 'red';
                                                        }
                                                    @endphp
                                                    <div
                                                        style="border-radius: 50%; border: 2px solid {{ $colorBorde }}; width: 150px; height: 150px; margin: 10px; line-height: 150px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            width="50" height="50"
                                                            viewBox="0 0 20 20"
                                                            style="fill: white; margin: auto; transform: translateY(30px);">
                                                            <path fill="#ffffff"
                                                                d="M17.943 14.537a.8.8 0 0 1-.161.242l-.002.001l-.001.002a.75.75 0 0 1-.529.218h-5.5a.75.75 0 0 1 0-1.5h3.69L10.5 8.56l-1.97 1.97a.75.75 0 0 1-1.06 0L2.22 5.28a.75.75 0 0 1 1.06-1.06L8 8.94l1.97-1.97a.75.75 0 0 1 1.06 0l5.47 5.47V8.75a.75.75 0 0 1 1.5 0v5.5q0 .154-.057.287" />
                                                        </svg>
                                                        <span
                                                            style="margin-top: 15px; font-size:16px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                            {{ !empty($resultado->porcentaje_perdida) ? $resultado->porcentaje_perdida : '0' }}
                                                            %
                                                        </span>
                                                    </div>

                                                    <!-- Círculos por fase -->
                                                    <div style="display: flex; justify-content: center; margin-top: 10px; gap: 10px;">
                                                        @php
                                                            $fasesPorLinea = collect($balancesFasesSABT)->keyBy('id_linea');
                                                            $fases = $fasesPorLinea[$resultado->id_linea] ?? null;
                                                        @endphp

                                                        @foreach (['r', 's', 't'] as $fase)
                                                            @php
                                                                $valor = $fases ? ($fases->{'porcentaje_perdida_' . $fase} ?? 0) : 0;
                                                                $colorFase = ($valor > 6) ? 'red' : 'green';
                                                            @endphp
                                                            <div style="display: flex; flex-direction: column; align-items: center;">
                                                                <div style="border-radius: 50%; border: 2px solid {{ $colorFase }}; width: 3.125rem; height: 3.125rem; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                                                    {{ $valor }}%
                                                                </div>
                                                                <strong style="margin-top: 4px; font-size: 12px;">{{ strtoupper($fase) }}</strong>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                                

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        {{-- SEGUNDA FILA --}}
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            <div class="card text-white  mb-2"
                                style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <div class="overflow-x-auto">

                                    <div class="container">
                                        @if (count($balancesSABT) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableBalancesCt"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                CT ID</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Linea</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Generada</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia (Exceso)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Total generacion</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Consumida</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Autoconsumos</th>
                                                            <th class="mt-0  text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                CUPS Leidos</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Perdida</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Perdida Porcentual</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($balancesSABT as $resultado)
                                                            <tr class="highlight-row ">
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_ct) ? $resultado->id_ct : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_linea) ? $resultado->id_linea : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_lvs) ? intval($resultado->total_ai_lvs/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_lvs) ? intval($resultado->total_ae_lvs/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_lvs) ? intval($resultado->total_lvs/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_cnt) ? intval($resultado->total_ai_cnt/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_cnt) ? intval($resultado->total_ae_cnt/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_cnt) ? intval($resultado->total_cnt) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->perdida_energia) ? intval($resultado->perdida_energia/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->porcentaje_perdida) ? $resultado->porcentaje_perdida : '0' }}%
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl  text-center"
                                                    style="color:rgb(88,226,194)">No hay
                                                    datos
                                                </p>
                                            </div>
                                        @endif
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4">
                                            <input type="button"
                                                onclick="tableToExcel('testTableBalancesCt', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TERCERA FILA --}}
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            <div class="card text-white  mb-2"
                                style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <div class="overflow-x-auto">

                                    <div class="container">
                                        @if (count($balancesFasesSABT) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableBalancesCt"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                CT ID</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Linea</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Generada (R)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Generada (S)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Generada (T)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia (Exceso R)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia (Exceso S)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia (Exceso T)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Total generacion (R)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Total generacion (S)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Total generacion (T)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Consumida (R)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Consumida (S)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Energia Consumida (T)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Autoconsumos (R)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Autoconsumos (S)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Autoconsumos (T)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Perdida (R)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Perdida (S)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                Perdida (T)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($balancesFasesSABT as $resultado)
                                                            <tr class="highlight-row ">
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_ct) ? $resultado->id_ct : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_linea) ? $resultado->id_linea : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_lvs_r) ? intval($resultado->total_ai_lvs_r/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_lvs_s) ? intval($resultado->total_ai_lvs_s/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_lvs_t) ? intval($resultado->total_ai_lvs_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_lvs_r) ? intval($resultado->total_ae_lvs_r/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_lvs_s) ? intval($resultado->total_ae_lvs_s/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_lvs_t) ? intval($resultado->total_ae_lvs_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_lvs_r) ? intval($resultado->total_lvs_r/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_lvs_s) ? intval($resultado->total_lvs_s/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_lvs_t) ? intval($resultado->total_lvs_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_cnt_r) ? intval($resultado->total_ai_cnt_r/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_cnt_s) ? intval($resultado->total_ai_cnt_s/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ai_cnt_t) ? intval($resultado->total_ai_cnt_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_cnt_r) ? intval($resultado->total_ai_cnt_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_cnt_s) ? intval($resultado->total_ai_cnt_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_ae_cnt_t) ? intval($resultado->total_ai_cnt_t/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->perdida_energia_r) ? intval($resultado->perdida_energia_r/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->perdida_energia_s) ? intval($resultado->perdida_energia_s/1000) : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->perdida_energia_t) ? intval($resultado->perdida_energia_t/1000) : '0' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl  text-center"
                                                    style="color:rgb(88,226,194)">No hay
                                                    datos
                                                </p>
                                            </div>
                                        @endif
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4">
                                            <input type="button"
                                                onclick="tableToExcel('testTableBalancesCt', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </div>


</body>






</html>

