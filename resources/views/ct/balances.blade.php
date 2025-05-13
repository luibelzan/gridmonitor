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
































<script>
document.addEventListener("DOMContentLoaded", function () {

    function exportarArchivo(formato) {
        var idCt = document.querySelector('input[name="id_ct"]').value;
        var fecInicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecFin = document.querySelector('input[name="fecha_fin"]').value;

        var url = "{{ route('exportar.balances') }}?";

        if (idCt) {
            url += "id_ct=" + encodeURIComponent(idCt) + "&";
        }
        if (fecInicio) {
            url += "fecha_inicio=" + encodeURIComponent(fecInicio) + "&";
        }
        if (fecFin) {
            url += "fecha_fin=" + encodeURIComponent(fecFin) + "&";
        }

        url += "format=" + formato;

        window.location.href = url;
    }

    var exportExcelBtn = document.getElementById('exportarExcel');
    var exportCsvBtn = document.getElementById('exportarCsv');

    if (exportExcelBtn) {
        exportExcelBtn.addEventListener('click', function () {
            exportarArchivo('excel');
        });
    } else {
        console.error("El botón exportarExcel no existe en el DOM.");
    }

    if (exportCsvBtn) {
        exportCsvBtn.addEventListener('click', function () {
            exportarArchivo('csv');
        });
    }
});
</script>









































































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
                    {{-- Botones de arriba --}}
                    <nav class="nav mb-12 ">
                        <a href="{{ route('dashboardct') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacionct', ['id_ct' => $id_ct]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('energia', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Energía</a>
                        <a href="{{ route('señalplc', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Lecturas/Señal PLC</a>
                        @foreach ($ct_info as $ct)
                            @if ($ct->id_ct == $id_ct && $ct->ind_balance == true)
                                <a href="{{ route('balances', ['id_ct' => $id_ct]) }}" class="nav-item is-active "
                                    active-color="rgb(88, 226, 194">Balances</a>
                            @endif
                        @endforeach
                        <a href="{{ route('eventosct', ['id_ct' => $id_ct]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Eventos</a>
















                        <span class="nav-indicator"></span>
                    </nav>
                    {{-- Obtener el id_ct almacenado en la sesión --}}
                    @php
                        $id_ct = session()->get('id_ct');
                    @endphp
                    {{-- Desplegable para seleccionar el CT --}}
                    <div class="container">
















                        <div class="dropdown" style="margin-left: 6px">
                            <form style="color: white; background-color: transparent;"
                                action="{{ route('balances', ['id_ct' => $id_ct]) }}" method="GET">
                                <select name="id_ct" class="form-control mt-2" onchange="this.form.submit()"
                                    style="color: white; background-color: rgb(27, 32, 38); width: min-content; font-size: 14px; text-align: left;">
                                    {{-- Si hay un id_ct seleccionado en la sesión, mostrarlo seleccionado --}}
                                    @if ($id_ct)
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un
                                            CT</option>
                                        @foreach ($ct_info as $ct_item)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $ct_item->id_ct }}"
                                                {{ $id_ct == $ct_item->id_ct ? 'selected' : '' }}>
                                                {{ $ct_item->nom_ct }}
                                            </option>
                                        @endforeach
                                        {{-- Si no hay un id_ct seleccionado en la sesión, mostrar la opción "Seleccione un CT" --}}
                                    @else
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un
                                            CT</option>
                                        @foreach ($ct_info as $ct_item)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $ct_item->id_ct }}">
                                                {{ $ct_item->nom_ct }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>
                    @if ($id_ct)
                        @php
                            // Filtrar para encontrar el CT seleccionado
                            $selected_ct_info = $ct_info->filter(function ($ct) use ($id_ct) {
                                return $ct->id_ct == $id_ct;
                            });
                        @endphp








                        @if ($selected_ct_info->isEmpty())
                            <div class="flex justify-center">
                                <div class="alert alert-danger text-center max-w-max" role="alert">
                                    No se encontró información para el CT proporcionado.
                                </div>
                            </div>
                        @else
                            <h1 class="text-center text-3xl w-full" style="color: white;">BALANCES</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
















                            {{-- CONTENEDOR CUERPO --}}
                            <div class="container">
                                @foreach ($ct_info as $ct)
                                    @if ($ct->id_ct == $id_ct)
                                        {{-- PRIMERA FILA --}}


                                        {{-- FILTRO AQUI --}}
                                        <form action="{{ route('balances', ['id_ct' => $id_ct]) }}" method="GET"
                                            class="flex flex-col sm:flex-row items-center justify-start space-y-4 sm:space-y-0 space-x-0 sm:space-x-4 mb-4 mt-4 mr-2">
                                            <input type="hidden" name="id_ct" value="{{ $id_ct }}">
                                            <div class="form-group">
                                                <label for="fecha_inicio" class="text-white">Fecha de
                                                    inicio:</label>
                                                <input type="date" id="fecha_inicio" name="fecha_inicio"
                                                    class="border border-gray-400 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_fin" class="text-white">Fecha de
                                                    fin:</label>
                                                <input type="date" id="fecha_fin" name="fecha_fin"
                                                    class="border border-slate-900 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                            </div>
                                            <button type="submit" class="btn btn-outline-info ml-2 mb-0 text-white"
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
                                                        {{ !empty($resultadosQ26[0]->fecha) ? $resultadosQ26[0]->fecha : 'No hay datos' }}
                                                    @endif
                                                </h1>
                                                <div class="mb-2 mt-2"
                                                    style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="overflow-x-auto flex flex-wrap  "
                                                    style="display: flex; flex-wrap: nowrap; justify-content: space-around;">
                                                    @foreach ($resultadosQ26 as $resultado)
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
                                                            <div style="text-align: center; color: white;">
                                                                <div
                                                                    style="font-size: 18px; margin-bottom: 10px; margin-right: 30px">
                                                                    ENERGÍA
                                                                    GENERADA</div>
                                                                <div
                                                                    style="display: inline-block; position: relative;">
                                                                    <div
                                                                        style="border-radius: 50%; border: 2px solid #296fd1; width: 150px; height: 150px; margin: 10px; line-height: 150px;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="50" height="50"
                                                                            viewBox="0 0 24 24"
                                                                            style="fill: white; margin: auto; transform: translateY(30px);">
                                                                            <path
                                                                                d="m8.28 5.45l-1.78-.9L7.76 2h8.47l1.27 2.55l-1.78.89L15 4H9zM18.62 8h-4.53l-.79-3h-2.6l-.79 3H5.38L4.1 10.55l1.79.89l.73-1.44h10.76l.72 1.45l1.79-.89zm-.85 14H15.7l-.24-.9L12 15.9l-3.47 5.2l-.23.9H6.23l2.89-11h2.07l-.36 1.35L12 14.1l1.16-1.75l-.35-1.35h2.07zm-6.37-7l-.9-1.35l-1.18 4.48zm3.28 3.12l-1.18-4.48l-.9 1.36z" />
                                                                        </svg>
                                                                        <span
                                                                            style="margin-top: 15px; font-size:16px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                            {{ !empty($resultado->energia_red) ? $resultado->energia_red : '0' }}
                                                                            kWh
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="color: white; font-size: 50px; margin: 10px; display: inline-block; position: relative; top: -70px; left:40px">
                                                                    +
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
















                                                            <div style="text-align: center; color: white;">
                                                                <div
                                                                    style="font-size: 18px; margin-bottom: 10px; margin-right: 30px">
                                                                    AUTOCONSUMOS
                                                                </div>
                                                                <div
                                                                    style="display: inline-block; position: relative;">
                                                                    <div
                                                                        style="border-radius: 50%; border: 2px solid #ffdd33; width: 150px; height: 150px; margin: 10px; line-height: 150px;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="50" height="50"
                                                                            viewBox="0 0 256 256"
                                                                            style="fill: white; margin: auto; transform: translateY(30px);">
                                                                            <g fill="#ffffff">
                                                                                <path d="M232 216H24l40.7-72h126.6Z"
                                                                                    opacity=".2" />
                                                                                <path
                                                                                    d="M32 104a8 8 0 0 1 8-8h16a8 8 0 0 1 0 16H40a8 8 0 0 1-8-8m39.43-45.25a8 8 0 0 0 11.32-11.32L71.43 36.12a8 8 0 0 0-11.31 11.31ZM128 40a8 8 0 0 0 8-8V16a8 8 0 0 0-16 0v16a8 8 0 0 0 8 8m50.91 21.09a8 8 0 0 0 5.66-2.34l11.31-11.32a8 8 0 0 0-11.31-11.31l-11.32 11.31a8 8 0 0 0 5.66 13.66M192 104a8 8 0 0 0 8 8h16a8 8 0 0 0 0-16h-16a8 8 0 0 0-8 8m-104 8a8 8 0 0 0 8-8a32 32 0 0 1 64 0a8 8 0 0 0 16 0a48 48 0 0 0-96 0a8 8 0 0 0 8 8m150.91 108a8 8 0 0 1-6.91 4H24a8 8 0 0 1-7-11.94l40.69-72a8 8 0 0 1 7-4.06H191.3a8 8 0 0 1 7 4.06l40.69 72a8 8 0 0 1-.08 7.94m-52.27-68h-24.37l3.48 16h29.93Zm-37.26 16l-3.48-16h-35.8l-3.48 16Zm-46.24 16l-5.21 24h60.14l-5.21-24Zm-42.82-16h29.93l3.48-16H69.36Zm-22.61 40h43.84l5.22-24H51.28Zm180.58 0l-13.57-24h-35.49l5.22 24Z" />
                                                                            </g>
                                                                        </svg>
                                                                        <span
                                                                            style="margin-top: 15px; font-size: 16px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                            {{ !empty($resultado->energia_autoconsumos) ? $resultado->energia_autoconsumos : '0' }}
                                                                            kWh</span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="color: white; font-size: 50px; margin: 10px; display: inline-block; position: relative; top: -70px;  left:40px">
                                                                    =
                                                                </div>
                                                            </div>
















                                                        </div>
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
















                                                            <div style="text-align: center; color: white;">
                                                                <div
                                                                    style="font-size: 18px; margin-bottom: 10px; margin-right: 30px">
                                                                    TOTAL
                                                                    GENERACIÓN</div>
                                                                <div
                                                                    style="display: inline-block; position: relative;">
                                                                    <div
                                                                        style="border-radius: 50%; border: 2px solid #FF33FF; width: 150px; height: 150px; margin: 10px; line-height: 150px;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="50" height="50"
                                                                            viewBox="0 0 24 24"
                                                                            style="fill: white; margin: auto; transform: translateY(30px);">
                                                                            <path fill="#ffffff"
                                                                                d="M11 9.47V11h3.76L13 14.53V13H9.24zM13 1L6 15h5v8l7-14h-5z" />
                                                                        </svg>
                                                                        <span
                                                                            style="margin-top: 15px; font-size: 16px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                            {{ !empty($resultado->generacion) ? $resultado->generacion : '0' }}
                                                                            kWh</span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="color: white; font-size: 50px; margin: 10px; display: inline-block; position: relative; top: -70px;  left:40px">
                                                                    -</div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
                                                            <div style="text-align: center; color: white;">
                                                                <div
                                                                    style="font-size: 18px; margin-bottom: 10px; margin-right: 30px">
                                                                    ENERGÍA
                                                                    CONSUMIDA</div>
                                                                <div
                                                                    style="display: inline-block; position: relative;">
                                                                    <div
                                                                        style="border-radius: 50%; border: 2px solid rgb(88,226,194); width: 150px; height: 150px; margin: 10px; line-height: 150px;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="50" height="50"
                                                                            viewBox="0 0 24 24"
                                                                            style="fill: white; margin: auto; transform: translateY(30px);">
                                                                            <path fill="#ffffff"
                                                                                d="M12 3L2 12h3v8h14v-8h3zm-.5 15v-4H9l3.5-7v4H15z" />
                                                                        </svg>
                                                                        <span
                                                                            style="margin-top: 15px; font-size: 16px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                            {{ !empty($resultado->energia_consumida) ? $resultado->energia_consumida : '0' }}
                                                                            kWh</span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="color: white; font-size: 50px; margin: 10px; display: inline-block; position: relative; top: -70px;  left:40px">
                                                                    =
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6 justify-center">
                                                            <div style="text-align: center; color: white;">
                                                                <div
                                                                    style="font-size: 18px; margin-bottom: 10px; margin-right: 30px ">
                                                                    PÉRDIDAS
                                                                </div>
                                                                <div
                                                                    style="display: inline-block; position: relative;">
                                                                    <div
                                                                        style="border-radius: 50%; border: 2px solid rgb(248,73,90); width: 150px; height: 150px; margin: 10px; line-height: 150px;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="50" height="50"
                                                                            viewBox="0 0 20 20"
                                                                            style="fill: white; margin: auto; transform: translateY(30px);">
                                                                            <path fill="#ffffff"
                                                                                d="M17.943 14.537a.8.8 0 0 1-.161.242l-.002.001l-.001.002a.75.75 0 0 1-.529.218h-5.5a.75.75 0 0 1 0-1.5h3.69L10.5 8.56l-1.97 1.97a.75.75 0 0 1-1.06 0L2.22 5.28a.75.75 0 0 1 1.06-1.06L8 8.94l1.97-1.97a.75.75 0 0 1 1.06 0l5.47 5.47V8.75a.75.75 0 0 1 1.5 0v5.5q0 .154-.057.287" />
                                                                        </svg>
                                                                        <span
                                                                            style="margin-top: 15px; font-size: 16px; position: absolute; top: 50%; left: 50%; transform: translate(-35%, -35%); text-align: center;">
                                                                            {{ !empty($resultado->porcentaje_perdida) ? $resultado->porcentaje_perdida : '0' }}%
                                                                        </span>
                                                                        <span
                                                                            style="margin-top: 15px; font-size: 16px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                                                            {{ !empty($resultado->perdida) ? $resultado->perdida : '0' }}
                                                                            kWh
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="color: rgba(255, 255, 255, 0); font-size: 50px; margin: 10px; display: inline-block; position: relative; top: -70px;  left:40px">
                                                                    =
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
                                                        @if (count($resultadosQ25) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableBalancesCt"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                ENERGÍA GENERADA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                ENERGÍA AUTOCONSUMOS</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                TOTAL GENERACIÓN</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                ENERGÍA CONSUMIDA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                TOTAL CUPS</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                TOTAL CUPS LEIDOS</th>
                                                                            <th class="mt-0  text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                PÉRDIDA</th>
                                                                           


                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                PERDIDA PORCENTUAL</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ25 as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fecha) ? $resultado->fecha : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->energia_red) ? $resultado->energia_red : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->energia_autoconsumos) ? $resultado->energia_autoconsumos : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->generacion) ? $resultado->generacion : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->energia_consumida) ? $resultado->energia_consumida : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultadosQ2[0]->nro_cups) ? $resultadosQ2[0]->nro_cups : '0' }}
                                                                                </td>
                                                                                {{-- TOTAL CUPS --}}
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->nro_contadores) ? $resultado->nro_contadores : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->perdida) ? $resultado->perdida : '0' }}
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
                                                        <h1 class="text-center text-3xl w-full" style="color: white;">DETALLES CONSUMOS POR CUPS</h1>
                                                        <h1 class="text-center text-3xl w-full" style="color: white;">
                                                            @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                                                Del
                                                                {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                                al
                                                                {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                                            @else
                                                                {{ !empty($resultadosQ26[0]->fecha) ? $resultadosQ26[0]->fecha : 'No hay datos' }}
                                                            @endif
                                                        </h1>
                                                        @if (count($sumBalances) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableBalancesCt"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                CUPS</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                CONTADOR</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                NOMBRE</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                ENERGIA IMPORTADA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                ENERGIA EXPORTADA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($sumBalances->count() > 0)
                                                                            @foreach ($sumBalances as $resultado)
                                                                                <tr class="highlight-row" 
                                                                                    onclick="window.open('{{ route('detallesconsumodiariocups', ['id_cups' => $resultado->id_cups]) }}', '_blank');" 
                                                                                    style="cursor: pointer;">
                                                                                    <td class="py-2">{{ $resultado->id_cups ?? 'No hay datos' }}</td>
                                                                                    <td class="py-2">{{ $resultado->id_cnt ?? '0' }}</td>
                                                                                    <td class="py-2">{{ $resultado->nom_cups ?? '0' }}</td>
                                                                                    <td class="py-2">{{ $resultado->total_val_ai_d ?? '0' }}</td>
                                                                                    <td class="py-2">{{ $resultado->total_val_ae_d ?? '0' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else 
                                                                            <tr>
                                                                                <td class="py-2" colspan="5" style="text-align: center;">No hay datos disponibles</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="pagination-container mt-4 flex justify-center items-center">
                                                                <div class="pagination">
                                                                    {{ $sumBalances->links() }}
                                                                </div>
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
                                                            <!-- Botón Excel -->
                                                            <button id="exportarExcel" 
                                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;" 
                                                                title="Exportar a Excel">
                                                            </button>

                                                            <!-- Botón CSV -->
                                                            <button id="exportarCsv" 
                                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/csv-icon.png'); background-size: cover; width: 30px; height: 30px;" 
                                                                title="Exportar a CSV">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>








                                        {{-- CUARTA FILA --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white  mb-2"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl m-2">




































                                                    <p class="ml-2">
                                                        <span id="info" class="popover-trigger">
                                                            PÉRDIDAS


                                                            <span class="popover-content">








                                                                <svg class="circle-icon" height="20"
                                                                    width="16" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle r="8" cx="8" cy="8"
                                                                        fill="green" />
                                                                </svg>
                                                                Pérdidas menores al 8%. <br><br>
















                                                                <svg class="circle-icon" height="20"
                                                                    width="16" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle r="8" cx="8" cy="8"
                                                                        fill="orange" />
                                                                </svg>
                                                                Pérdidas entre 8% y 15%.<br><br>
















                                                                <svg class="circle-icon" height="20"
                                                                    width="16" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle r="8" cx="8" cy="8"
                                                                        fill="red" />
                                                                </svg>
                                                                Pérdidas de más del 15%.
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <script src="scripts.js"></script>
                                                </h1>
                                                <div class="overflow-x-auto">
                                                    {{-- CONTENIDO AQUI --}}








                                                    <div class="container">
                                                        <div class="table-responsive w-full"
                                                            style="display: flex; justify-content: center;">








                                                            @if (count($resultadosQ27) > 0)
                                                                <div
                                                                    style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                                    <canvas id="graficoPerdidas"
                                                                        class="w-full"></canvas>
                                                                </div>
                                                            @else
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                    <p class="mt-0 text-xl  text-center"
                                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        {{-- SCRIPT PARA EL GRÁFICO PERDIDAS --}}
                                                        <script>
                                                            // Transformar los datos para el gráfico de línea
                                                            var labels_fecha = [];
                                                            var values_perdidas = [];








                                                            @foreach ($resultadosQ27 as $resultado)
                                                                // Agregar la fecha y hora como etiquetas del eje x
                                                                var dateTime = '{{ $resultado->fecha_inicio }}';
                                                                labels_fecha.push(dateTime);








                                                                // Agregar el valor de 'porcentaje_perdida' como valor del eje y
                                                                values_perdidas.push({{ $resultado->porcentaje_perdida }});
                                                            @endforeach








                                                            var myChartLineVoltaje2;








                                                            // Actualizar el gráfico con las etiquetas filtradas
                                                            function updateChartLinePerdidas(data) {
                                                                if (myChartLineVoltaje2) {
                                                                    myChartLineVoltaje2.data.labels = data.labels_fecha;
                                                                    myChartLineVoltaje2.data.datasets[0].data = data.values_perdidas;
                                                                    myChartLineVoltaje2.update();
                                                                } else {
                                                                    var ctx = document.getElementById('graficoPerdidas').getContext('2d');
                                                                    myChartLineVoltaje2 = new Chart(ctx, {
                                                                        type: 'line',
                                                                        data: {
                                                                            labels: data.labels_fecha,
                                                                            datasets: [{
                                                                                label: 'Pérdidas',
                                                                                data: data.values_perdidas,
                                                                                borderColor: 'rgba(88,226,194)',
                                                                                backgroundColor: function(context) {
                                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                                    gradient.addColorStop(0, 'rgba(88,226,194, 0.9)');
                                                                                    gradient.addColorStop(0.3, 'rgba(88,226,194, 0.5)');
                                                                                    gradient.addColorStop(1, 'rgba(88,226,194, 0)');
                                                                                    return gradient;
                                                                                },
                                                                                borderWidth: 1,
                                                                                pointBackgroundColor: function(context) {
                                                                                    var value = context.dataset.data[context.dataIndex];
                                                                                    if (value < 8) {
                                                                                        return 'rgb(76,218,19)';
                                                                                    } else if (value >= 8 && value <= 15) {
                                                                                        return 'rgb(255,155,0)';
                                                                                    } else {
                                                                                        return 'rgb(222,54,63)';
                                                                                    }
                                                                                },
                                                                                pointBorderColor: function(context) {
                                                                                    var value = context.dataset.data[context.dataIndex];
                                                                                    if (value < 8) {
                                                                                        return 'rgb(76,218,19)';
                                                                                    } else if (value >= 8 && value <= 15) {
                                                                                        return 'rgb(255,155,0)';
                                                                                    } else {
                                                                                        return 'rgb(222,54,63)';
                                                                                    }
                                                                                },
                                                                                pointBorderWidth: 2,
                                                                                fill: true,
                                                                                tension: 0.4,
                                                                                pointRadius: 3,
                                                                            }]
                                                                        },
                                                                        options: {
                                                                            responsive: true,
                                                                            maintainAspectRatio: false,








                                                                            plugins: {
                                                                                legend: {
                                                                                    labels: {
                                                                                        color: 'white',
                                                                                        font: {
                                                                                            family: 'Didact Gothic',
                                                                                            weight: 'normal'
                                                                                        }
                                                                                    }
                                                                                },
                                                                                tooltip: {
                                                                                    callbacks: {
                                                                                        title: function(tooltipItems) {
                                                                                            return tooltipItems.length > 0 ? tooltipItems[0].label : '';
                                                                                        },
                                                                                        label: function(context) {
                                                                                            return context.parsed.y !== null ? context.parsed.y + ' %' : '';
                                                                                        }
                                                                                    },
                                                                                    titleFont: {
                                                                                        family: 'Didact Gothic',
                                                                                        weight: 'normal'
                                                                                    },
                                                                                    bodyFont: {
                                                                                        family: 'Didact Gothic',
                                                                                        weight: 'normal'
                                                                                    }
                                                                                }
                                                                            },
                                                                            scales: {
                                                                                x: {
                                                                                    type: 'category',
                                                                                    labels: data.labels_fecha.map(label => label.replace(/\:\d\d$/, 'h')),
                                                                                    grid: {
                                                                                        color: '#666'
                                                                                    },
                                                                                    ticks: {
                                                                                        color: '#FFFFFF',
                                                                                        stepSize: 2
                                                                                    }
                                                                                },
                                                                                y: {
                                                                                    display: true,
                                                                                    beginAtZero: true,
                                                                                    grid: {
                                                                                        color: '#666'
                                                                                    },
                                                                                    ticks: {
                                                                                        color: '#FFFFFF',
                                                                                        min: -300,
                                                                                        max: 300,
                                                                                        stepSize: 5,
                                                                                        callback: function(value) {
                                                                                            return value + ' %';
                                                                                        }
                                                                                    }
                                                                                }
                                                                            },
                                                                            annotation: {
                                                                                annotations: [{
                                                                                    type: 'line',
                                                                                    mode: 'horizontal',
                                                                                    scaleID: 'y',
                                                                                    value: 0,
                                                                                    borderColor: 'white',
                                                                                    borderWidth: 2,
                                                                                    borderDash: [5, 5]
                                                                                }]
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            }








                                                            updateChartLinePerdidas({
                                                                labels_fecha: labels_fecha,
                                                                values_perdidas: values_perdidas
                                                            });
                                                        </script>








                                                    </div>








                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>{{--  FIN CUERPO --}}
    </div>
</body>




