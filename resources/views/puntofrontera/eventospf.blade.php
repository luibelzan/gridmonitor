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


        /* Archivo styles.css */
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


        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */


        }
    </style>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    function exportarArchivo(formato) {
        var descripcion = document.querySelector('input[name="descripcion"]').value;
        var fecInicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecFin = document.querySelector('input[name="fecha_fin"]').value;
        var id_cnt = document.querySelector('input[name="id_cnt"]').value;

        var url = "{{ route('exportar.eventos.pf') }}?";

        if (id_cnt) {
            url += "id_cnt=" + encodeURIComponent(id_cnt) + "&";
        }
        if (descripcion) {
            url += "descripcion=" + encodeURIComponent(descripcion) + "&";
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



    <title>Eventos PF</title>
</head>


<body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center"
    style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(27, 32, 38));" id="top">
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
            </svg> <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white ">
        @include('includes/header')
        <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full"> <!-- Añadir margen superior -->
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}
                    <nav class="nav mb-12 ">
                        <a href="{{ route('dashboardpf') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacionpf', ['id_cnt' => $id_cnt]) }}" class="nav-item  "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('curvashorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Curvas horarias</a>
                        @if ($id_cnt && !empty($mostrarcurvascuartihorarias) && $mostrarcurvascuartihorarias[0]->curva_1 == 1)
                            <a href="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                                active-color="rgb(88, 226, 194">Curvas Cuartihorarias</a>
                        @endif
                        <a href="{{ route('eventospf', ['id_cnt' => $id_cnt]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Eventos</a>
                        <a href="{{ route('reportespf') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Reportes</a>
                        <span class="nav-indicator"></span>
                    </nav>
                    {{-- Obtener el id_cnt almacenado en la sesión --}}
                    @php
                        $id_cnt = session()->get('id_cnt');
                    @endphp
                    {{-- Desplegable para seleccionar el CNT --}}
                    <div class="container">


                        <div class="dropdown" style="margin-left: 6px">
                            <form style="color: white; background-color: transparent;"
                                action="{{ route('eventospf', ['id_cnt' => $id_cnt]) }}" method="GET">
                                <select name="id_cnt" class="form-control mt-2" onchange="this.form.submit()"
                                    style="color: white; background-color: rgb(27, 32, 38);  width: 200px; font-size: 14px; text-align: left;">
                                    {{-- Si hay un id_cnt seleccionado en la sesión, mostrarlo seleccionado --}}
                                    @if ($id_cnt)
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un Punto</option>
                                        @foreach ($parametros as $cnt)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $cnt->id_cnt }}"
                                                {{ $selected_cnt == $cnt->id_cnt ? 'selected' : '' }}>
                                                {{ $cnt->cups }}
                                            </option>
                                        @endforeach
                                        {{-- Si no hay un id_cnt seleccionado en la sesión, mostrar la opción "Seleccione un CT" --}}
                                    @else
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un Punto</option>
                                        @foreach ($parametros as $cnt)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $cnt->id_cnt }}">
                                                {{ $cnt->cups }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- INICIO BODY DE LA VISTA --}}
                    @if ($id_cnt)
                        @if (count($resultadosQ1pf) === 0)
                            <div class="flex justify-center">
                                <div class="alert alert-danger text-center max-w-max flex items-center space-x-2"
                                    role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 15 15">
                                        <path fill="#e11d48" fill-rule="evenodd"
                                            d="M0 7.5a7.5 7.5 0 1 1 15 0a7.5 7.5 0 0 1-15 0m10.147 3.354L7.5 8.207l-2.646 2.647l-.708-.707L6.793 7.5L4.146 4.854l.708-.708L7.5 6.793l2.646-2.647l.708.708L8.207 7.5l2.647 2.646z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>No se encontró información para el Contador proporcionado.</span>
                                </div>
                            </div>
                        @else
                            <h1 class="text-center text-3xl w-full" style="color: white;">EVENTOS</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                        border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                            @foreach ($parametros as $cnt)
                                @if ($cnt->id_cnt == $id_cnt)
                                    {{-- CONTENEDOR CUERPO --}}
                                    <div class="container ">
                                        {{-- PRIMERA FILA --}}


                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                                            {{-- PL7 --}}




                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white mb-3 h-full"
                                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        NÚMERO DE CORTES
                                                    </h1>


                                                    <div
                                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62), rgb(27,32,38)) 1;">
                                                    </div>
                                                    <!-- Cuadrado para Contadores sin Lecturas últimos 7 días -->
                                                    <div class="p-0 #205E86 text-white rounded-lg shadow-xl flex items-center justify-center"
                                                        style="height: 100%;">
                                                        <p class="text-5xl text-center" style="color:rgb(248,73,90);">
                                                            {{ !empty($resultadosQ9pf[0]->numero) ? $resultadosQ9pf[0]->numero : '0' }}


                                                        </p>
                                                    </div>
                                                </div>
                                            </div>














                                            {{-- PL8 --}}
                                            <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                                <div class="card text-white mb-3 h-full"
                                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <!-- Contenido de PL8 -->
                                                    <div class="table-responsive w-full h-full"
                                                        style="display: flex; justify-content: center;">
                                                        <div class="overflow-x-auto w-full">
                                                            <h1 class="text-center text-2xl" style="color: white;">
                                                                ESTADÍSTICAS DE CORTES</h1>
                                                            <div
                                                                style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                            </div>
                                                            <div class="container">
                                                                @if (count($resultadosQ10pf) > 0)
                                                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                        <table id="testTableEstadisticasCortes"
                                                                            class="w-full text-white text-center">
                                                                            <thead
                                                                                style="border-bottom: 1px solid #ffffff;">
                                                                                <tr>
                                                                                    <th class="mt-0 text-xl font-bold text-center"
                                                                                        style="color:rgb(88,226,194)">#
                                                                                    </th>
                                                                                    <th class="mt-0 text-xl font-bold text-center"
                                                                                        style="color:rgb(88,226,194)">
                                                                                        CUPS
                                                                                    </th>
                                                                                    <th class="mt-0 text-xl font-bold text-center"
                                                                                        style="color:rgb(88,226,194)">
                                                                                        CONTADOR
                                                                                    </th>
                                                                                    <th class="mt-0 text-xl font-bold text-center"
                                                                                        style="color:rgb(88,226,194)">
                                                                                        FECHA DE CORTE
                                                                                    </th>
                                                                                    <th class="mt-0 text-xl font-bold text-center"
                                                                                        style="color:rgb(88,226,194)">
                                                                                        DURACION (Segundos)
                                                                                    </th>
                                                                                    <th class="mt-0 text-xl font-bold text-center"
                                                                                        style="color:rgb(88,226,194)">
                                                                                        FIN
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($resultadosQ10pf as $resultado)
                                                                                    <tr class="highlight-row">
                                                                                        <td class="py-2">
                                                                                            {{ $loop->iteration }}</td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->CUPS) ? $resultado->CUPS : 'No hay datos' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->Fecha_Corte) ? $resultado->Fecha_Corte : 'No hay datos' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->duracion_segundos) ? $resultado->duracion_segundos : 'No hay datos' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            @if (!empty($resultado->Fecha_Corte) && !empty($resultado->duracion_segundos))
                                                                                                {{ \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $resultado->Fecha_Corte)
                                                                                                    ->addSeconds($resultado->duracion_segundos)
                                                                                                    ->format('d/m/Y H:i:s') }}
                                                                                            @else
                                                                                                No hay datos
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                        <p class="mt-0 text-xl text-center"
                                                                            style="color:rgb(88,226,194)">No hay datos
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>






                                        </div>
                                        {{-- PL6 --}}
                                        <div class="col-span-4 sm:col-span-1 md:col-span-4">
                                            <div class="card text-white  mb-2"
                                                style="
                                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <!-- Contenido de PL6 -->
                                                <div class="container ">
                                                    <div class="table-responsive"
                                                        style="display: flex; justify-content: center;">
                                                        <div class="overflow-x-auto w-full">
                                                            <h1 class="text-center text-2xl" style="color: white;">
                                                                EVENTOS DEL CONTADOR
                                                            </h1>
                                                            <div
                                                                style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                                                {{-- FILTRO FECHAS --}}
                                                                <form
                                                                    action="{{ route('eventospf', ['id_cnt' => $id_cnt]) }}"
                                                                    method="GET"
                                                                    class="flex flex-wrap items-center justify-start gap-2 mt-6">
                                                                    {{-- FILTRO FECHAS --}}
                                                                    <input type="hidden" name="id_cnt"
                                                                        value="{{ $id_cnt }}">
                                                                    <div class="form-group flex items-center">
                                                                        <label for="fecha_inicio"
                                                                            class="text-white mr-2">Fecha de
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
                                                                            class="text-white mr-2">Fecha de
                                                                            fin:</label>
                                                                        <input type="date" id="fecha_fin"
                                                                            name="fecha_fin"
                                                                            class="border border-slate-900 p-2 rounded-lg text-white"
                                                                            @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                                            max="{{ date('Y-m-d') }}"
                                                                            style="background-color: transparent;">
                                                                    </div> {{-- BUSCADOR --}}
                                                                    <div class="form-group">
                                                                        <input type="text" name="descripcion"
                                                                            class="border p-2 rounded-md w-48 text-white"
                                                                            style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                                            placeholder="<?php echo isset($_GET['descripcion']) ? htmlspecialchars($_GET['descripcion']) : 'Buscar por descripción'; ?>">
                                                                    </div> <button type="submit"
                                                                        class="btn btn-outline-info mb-3 text-white"
                                                                        style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                                        onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                                        onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Buscar</button>
                                                                </form>
                                                            </div>


                                                            {{-- <div class="container"> --}}
                                                            @if (count($resultadosQ11pf) > 0)
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                    style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                    <table id="testTableEventos"
                                                                        class="w-full text-white text-center ">
                                                                        <thead
                                                                            style="border-bottom: 1px solid #ffffff;">
                                                                            <tr>
                                                                                <th class="mt-0 text-xl  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    CONTADOR</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    FECHA Y HORA</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    DR</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    SPA</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    SPQ</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    SPI</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    DESCRIPCIÓN</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($resultadosQ11pf as $resultado)
                                                                                <tr class="highlight-row ">
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->DR) ? $resultado->DR : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->SPA) ? $resultado->SPA : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->SPQ) ? $resultado->SPQ : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->SPI) ? $resultado->SPI : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->description) ? $resultado->description : 'No hay datos' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="pagination-container mt-4 flex justify-center items-center">
                                                                    <div class="pagination">
                                                                        {{ $resultadosQ11pf->links() }}
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
                                                            {{-- </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
