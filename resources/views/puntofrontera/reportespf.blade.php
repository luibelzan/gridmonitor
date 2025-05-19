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
















        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */
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
















        /* color verde de los checkbox */
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 16px;
            height: 16px;
            border: 2px solid #ddd;
            border-radius: 3px;
            position: relative;
        }
















        .custom-checkbox:checked {
            background-color: rgb(88, 226, 194);
            border-color: rgb(88, 226, 194);
        }
















        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 6px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
















        /* Agrega este CSS para manejar la disposición en pantallas pequeñas*/
        @media (max-width: 1024px) {
            .flex-container {
                flex-direction: column;
            }
        }
















        @media (max-width: 768px) {
            .form-check-container {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
















            .form-check-container {
                display: flex;
                flex-direction: column;
            }
        }
















        /* Ajustes específicos para la tarjeta de tipos de reporte */
        @media (max-width: 768px) {
            .card {
                margin-left: 0;
                max-width: 100%;
            }
        }
























        /* Mensaje de carga */
        .loading-message {
            margin-top: 10px;
            color: rgb(88, 226, 194);
            font-size: 16px;
            /* Tamaño del texto, ajusta según sea necesario */
            text-align: center;
            animation: breathing 3s infinite;
            /* Duración ajustada a 3 segundos */
        }




        @keyframes breathing {
            0% {
                opacity: 1;
                transform: scale(1);
            }




            50% {
                opacity: 0.5;
                transform: scale(1.05);
                /* Aumenta un poco el tamaño del texto */
            }




            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>








    <script>
        //Visibilidad de las tablas
        function toggleReportVisibility() {
            var cierreMensualChecked = document.getElementById('reporteCierresMensuales').checked;
            var curvaHorariaChecked = document.getElementById('reporteCurvasHorarias').checked;
            var curvaCuartihorariaChecked = document.getElementById('reporteCurvasCuartihorarias').checked;
            var cierreMensualTable = document.getElementById('cierres_mensuales');
            var curvaHorariaTable = document.getElementById('curvas_horarias');
            var curvaCuartihorariaTable = document.getElementById('curvas_cuartihorarias');
            cierreMensualTable.style.display = cierreMensualChecked ? 'block' : 'none';
            curvaHorariaTable.style.display = curvaHorariaChecked ? 'block' : 'none';
            curvaCuartihorariaTable.style.display = curvaCuartihorariaChecked ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleReportVisibility();
            var checkboxes = document.querySelectorAll('input[name="tipo_reporte[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', toggleReportVisibility);
            });
        });
    </script>
    <script>
        //seleccionar todos
        document.addEventListener('DOMContentLoaded', function() {
            const toggleAllBtn = document.getElementById('toggleAllBtn');
            let allChecked = false;
            toggleAllBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.form-check-input');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
                allChecked = !allChecked;
                toggleAllBtn.textContent = allChecked ? 'Quitar selección' : 'Seleccionar todos';
            });
        });
    </script>

    <title>Reportes</title>
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
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}
                    <nav class="nav mb-12 ">
                        <a href="{{ route('dashboardpf') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacionpf') }}" class="nav-item  "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Curvas Cuartihorarias</a>
                        <a href="{{ route('eventospf') }}" class="nav-item " active-color="rgb(88, 226, 194">Eventos</a>
                        <span class="nav-indicator"></span>
                        <a href="{{ route('reportespf') }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Reportes</a>
                        <span class="nav-indicator"></span>
                    </nav>
                    <h1 class="text-center text-3xl w-full " style="color: white;">REPORTES</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>
                    {{-- Vista modificada para usar checkboxes --}}
                    <div class="container">
                        <div class="card text-white mb-2"
                            style="background: linear-gradient(to bottom, rgb(27, 32, 38), rgb(27, 32, 38));">
                            <form style="color: white; background-color: transparent;"
                                action="{{ route('reportespf') }}" method="GET">
                                <h1 class="text-center text-2xl " style="color: white;">PUNTOS</h1>
                                <div class="m-2"
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <!-- Filtro de fechas -->
                                <div class="flex-container m-4" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                    @foreach (request('id_cnts', []) as $id_cnt)
                                        <input type="hidden" name="id_cnts[]" value="{{ $id_cnt }}">
                                    @endforeach
                                    @foreach (request('tipo_reporte', []) as $tipo_reporte)
                                        <input type="hidden" name="tipo_reporte[]" value="{{ $tipo_reporte }}">
                                    @endforeach
                                    <div class="form-group">
                                        <label for="fecha_inicio" class="text-white">Fecha de inicio:</label>
                                        <input type="date" id="fecha_inicio" name="fecha_inicio"
                                            class="border border-gray-400 p-2 rounded-lg text-white"
                                            value="{{ request('fecha_inicio', '') }}" max="{{ date('Y-m-d') }}"
                                            style="background-color: transparent;">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_fin" class="text-white">Fecha de fin:</label>
                                        <input type="date" id="fecha_fin" name="fecha_fin"
                                            class="border border-slate-900 p-2 rounded-lg text-white"
                                            value="{{ request('fecha_fin', '') }}" max="{{ date('Y-m-d') }}"
                                            style="background-color: transparent;">
                                    </div>
                                </div>
                                <div class="flex-container" style="display: flex; flex-wrap: wrap; ">
                                    <!-- Contenedor de checkboxes -->
                                    <div class="checkbox-container" style="flex: 1;">
                                        <div class="form-check-container m-14"
                                            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 5px; padding-top: 0; padding-bottom: 0;">
                                            @foreach ($parametros as $cnt)
                                                <div class="form-check"
                                                    style="display: flex; align-items: center; gap: 5px; margin-top: 0; margin-bottom: 0;">
                                                    <input class="form-check-input custom-checkbox" type="checkbox"
                                                        name="id_cnts[]" value="{{ $cnt->id_cnt }}"
                                                        id="cnt{{ $cnt->id_cnt }}"
                                                        {{ in_array($cnt->id_cnt, (array) request('id_cnts', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cnt{{ $cnt->id_cnt }}"
                                                        style="word-break: break-word; margin-top: 0; margin-bottom: 0;">{{ $cnt->cups }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- Contenedor de tipos de reporte -->
                                    <div class="card text-white shadow-xl m-1"
                                        style="background: linear-gradient(to bottom, rgb(27, 32, 38), rgb(27, 32, 38)); padding: 20px; box-sizing: border-box; max-width: 300px; flex: 0 0 auto; margin-left: auto;">
                                        <div class="container">
                                            <h1 class="text-center text-1xl" style="color: white;">TIPO DE REPORTE
                                            </h1>
                                            <div class="m-2"
                                                style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="form-check-container"
                                                style="display: flex; flex-direction: column; gap: 10px;">
                                                <div class="form-check form-switch"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="tipo_reporte[]" value="cierres_mensuales"
                                                        id="reporteCierresMensuales"
                                                        {{ in_array('cierres_mensuales', (array) request('tipo_reporte', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="reporteCierresMensuales"
                                                        style="color: rgb(88, 226, 194); word-break: break-word;">Cierres
                                                        Mensuales</label>
                                                </div>
                                                <div class="form-check form-switch"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="tipo_reporte[]" value="curvas_horarias"
                                                        id="reporteCurvasHorarias"
                                                        {{ in_array('curvas_horarias', (array) request('tipo_reporte', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="reporteCurvasHorarias"
                                                        style="color: rgb(88, 226, 194); word-break: break-word;">Curvas
                                                        Horarias</label>
                                                </div>
                                                <div class="form-check form-switch"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="tipo_reporte[]" value="curvas_cuartihorarias"
                                                        id="reporteCurvasCuartihorarias"
                                                        {{ in_array('curvas_cuartihorarias', (array) request('tipo_reporte', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="reporteCurvasCuartihorarias"
                                                        style="color: rgb(88, 226, 194); word-break: break-word;">Curvas
                                                        Cuartihorarias</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botones -->
                                <div class="flex justify-start gap-2 mt-1 px-4 py-2">
                                    <button type="button" class="btn btn-secondary" id="toggleAllBtn">Seleccionar
                                        todos</button>



                                    <button type="submit" class="btn btn-outline-info ml-2 mb-0 text-white"
                                        style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                        onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                        onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
















                    {{-- INICIO BODY DE LA VISTA --}}
                    @if ($id_cnts)
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
                            {{-- CONTENEDOR CUERPO --}}
                            <div class="container ">
                                {{-- SELECTOR DE FECHAS --}}

                                {{-- PRIMERA FILA --}}
                                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6"
                                    id=cierres_mensuales>
                                    <div class="card text-white  mb-2"
                                        style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">
                                            CIERRES MENSUALES </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <!-- Contenido de PL3 -->
                                        <div class="table-responsive" style="display: flex; justify-content: center;">
                                            <div class="overflow-x-auto">
                                                <div class="container">
                                                    @if (count($resultadosQ23pf) > 0)
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableCierresMensuales"
                                                                class="w-full text-white text-center">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="m-4 small  text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Cups</th>
                                                                        <th class="m-4 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Contador</th>
                                                                        <th class="m-4 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Contrato</th>
                                                                        <th class="mt-0 small  text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Periodo Tarifario</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Fecha Inicio</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Fecha<br> Fin</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Energía<br>Activa Absoluta
                                                                        </th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Energía Activa<br>
                                                                            Incremental
                                                                        </th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Bit Calidad Activa</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Energía Reactiva Inductiva
                                                                            Absoluta
                                                                        </th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Energía Reactiva Inductiva
                                                                            Incremental</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Bit Calidad Reactiva
                                                                            Inductiva
                                                                        </th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Energía Reactiva Capacitiva
                                                                            Absoluta
                                                                        </th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Energía Reactiva Capacitiva
                                                                            Incremental</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Bit Calidad Reactiva
                                                                            Capacitiva
                                                                        </th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Excesos de Potencias</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Bit Calidad Excesos</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Maxímetros</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Fecha Maxímetros</th>
                                                                        <th class="mt-0 small text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Bit Calidad Maxímetros</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($resultadosQ23pf as $resultado)
                                                                        <tr class="highlight-row ">
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->CUPS) ? $resultado->CUPS : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Contrato) ? $resultado->Contrato : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Periodo_Tarifario) ? $resultado->Periodo_Tarifario : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Fecha_Inicio) ? $resultado->Fecha_Inicio : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Fecha_Fin) ? $resultado->Fecha_Fin : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Energia_Activa_Absoluta) ? $resultado->Energia_Activa_Absoluta : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Energia_Activa_Incremental) ? $resultado->Energia_Activa_Incremental : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Bit_Calidad_Activa) ? $resultado->Bit_Calidad_Activa : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Energia_Reactiva_Inductiva_Absoluta) ? $resultado->Energia_Reactiva_Inductiva_Absoluta : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Energia_Reactiva_Inductiva_Incremental) ? $resultado->Energia_Reactiva_Inductiva_Incremental : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Bit_Calidad_Reactiva_Inductiva) ? $resultado->Bit_Calidad_Reactiva_Inductiva : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Energia_Reactiva_Capacitiva_Absoluta) ? $resultado->Energia_Reactiva_Capacitiva_Absoluta : '0' }}
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Energia_Reactiva_Capacitiva_Incremental) ? $resultado->Energia_Reactiva_Capacitiva_Incremental : '0' }}
                                                                            </td>
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Bit_Calidad_Reactiva_Capacitiva) ? $resultado->Bit_Calidad_Reactiva_Capacitiva : '0' }}
                                                                            </td>
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Excesos_de_Potencias) ? $resultado->Excesos_de_Potencias : '0' }}
                                                                            </td>
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Bit_Calidad_Excesos) ? $resultado->Bit_Calidad_Excesos : '0' }}
                                                                            </td>
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Maximetros) ? $resultado->Maximetros : '0' }}
                                                                            </td>
                                                                            </td>
                                                                            <td class="py-6 small">
                                                                                {{ !empty($resultado->Fecha_Maximetros) ? $resultado->Fecha_Maximetros : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->Bit_Calidad_Maximetros) ? $resultado->Bit_Calidad_Maximetros : '0' }}
                                                                            </td>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        @if ($resultadosQ23pf->hasPages())
                                                            <div
                                                                class="flex items-center justify-center space-x-3 mt-6">
                                                                {{-- Botón "Anterior" --}}
                                                                @if ($resultadosQ23pf->onFirstPage())
                                                                    <span
                                                                        class="px-3 py-2 text-gray-500 bg-custom-300 rounded-full cursor-not-allowed">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            height="24px" viewBox="0 -960 960 960"
                                                                            width="24px" fill="#e8eaed">
                                                                            <path
                                                                                d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                                                                        </svg>
                                                                    </span>
                                                                @else
                                                                    <a href="{{ $resultadosQ23pf->previousPageUrl() }}"
                                                                        class="px-3 py-2 text-sm font-medium text-white bg-custom-300 border-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            height="24px" viewBox="0 -960 960 960"
                                                                            width="24px" fill="#e8eaed">
                                                                            <path
                                                                                d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                                                                        </svg>
                                                                    </a>
                                                                @endif

                                                                {{-- Números de página --}}
                                                                @php
                                                                    $currentPage = $resultadosQ23pf->currentPage();
                                                                    $lastPage = $resultadosQ23pf->lastPage();
                                                                    $startPage = max(1, $currentPage - 2);
                                                                    $endPage = min($lastPage, $currentPage + 2);
                                                                @endphp

                                                                {{-- Mostrar primera página y "..." si es necesario --}}
                                                                @if ($startPage > 1)
                                                                    <a href="{{ $resultadosQ23pf->url(1) }}"
                                                                        class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                        1
                                                                    </a>
                                                                    @if ($startPage > 2)
                                                                        <span
                                                                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-custom-300 rounded-full">
                                                                            ...
                                                                        </span>
                                                                    @endif
                                                                @endif

                                                                {{-- Mostrar rango de páginas alrededor de la página actual --}}
                                                                @for ($page = $startPage; $page <= $endPage; $page++)
                                                                    @if ($page == $currentPage)
                                                                        <span
                                                                            class="px-3 py-2 text-sm font-medium text-white bg-[rgb(88,226,194)] border-custom-300 rounded-full">
                                                                            {{ $page }}
                                                                        </span>
                                                                    @else
                                                                        <a href="{{ $resultadosQ23pf->url($page) }}"
                                                                            class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                            {{ $page }}
                                                                        </a>
                                                                    @endif
                                                                @endfor

                                                                {{-- Mostrar última página y "..." si es necesario --}}
                                                                @if ($endPage < $lastPage)
                                                                    @if ($endPage < $lastPage - 1)
                                                                        <span
                                                                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-custom-300 rounded-full">
                                                                            ...
                                                                        </span>
                                                                    @endif
                                                                    <a href="{{ $resultadosQ23pf->url($lastPage) }}"
                                                                        class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                        {{ $lastPage }}
                                                                    </a>
                                                                @endif

                                                                {{-- Botón "Siguiente" --}}
                                                                @if ($resultadosQ23pf->hasMorePages())
                                                                    <a href="{{ $resultadosQ23pf->nextPageUrl() }}"
                                                                        class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            height="24px" viewBox="0 -960 960 960"
                                                                            width="24px" fill="#e8eaed">
                                                                            <path
                                                                                d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                                        </svg>
                                                                    </a>
                                                                @else
                                                                    <span
                                                                        class="px-3 py-2 text-gray-500 bg-custom-300 rounded-full cursor-not-allowed">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            height="24px" viewBox="0 -960 960 960"
                                                                            width="24px" fill="#e8eaed">
                                                                            <path
                                                                                d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                                        </svg>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        {{-- Descargar Excel --}}

                                                        <div class="text-right m-4">
                                                            <a href="{{ route('reportespf', array_merge(request()->query(), ['export23' => 'excel23'])) }}"
                                                                class="download-button"
                                                                data-loading-container="loadingBarContainer23"
                                                                data-loading-bar="loadingBar23"
                                                                data-loading-message="loadingMessage23">
                                                            </a>
                                                            <div id="loadingBarContainer23"
                                                                class="loading-bar-container" style="display:none;">
                                                                <div class="progress">
                                                                    <div class="progress-value" id="loadingBar23">
                                                                    </div>
                                                                </div>
                                                                <div id="loadingMessage23" class="loading-message"
                                                                    style="display:none;">
                                                                    Procesando la descarga, por favor espera...
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Contenedor del botón de descarga -->
                                                        {{-- <div class="text-right mt-4">
                                                            <input type="button"
                                                                onclick="tableToExcel('testTableCierresMensuales', 'W3C Example Table')"
                                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                        </div> --}}
                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl  text-center"
                                                                style="color:rgb(88,226,194)">No hay
                                                                datos
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- SEGUNDA FILA --}}
                                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6"
                                    id=curvas_horarias>
                                    <div class="card text-white  mb-2"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">
                                            CURVAS HORARIAS </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <!-- Contenido  -->
                                        <div class="container">
                                            <div class="table-responsive"
                                                style="display: flex; justify-content: center;">
                                                <div class="overflow-x-auto">
                                                    <div class="container">
                                                        <div class="container">
                                                            @if (!empty($resultadosQ24pf))
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                    style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38); margin-bottom: 20px;">
                                                                    <table id="testTableCurvasHorarias"
                                                                        class="w-full text-white text-center">
                                                                        <thead
                                                                            style="border-bottom: 1px solid #ffffff;">
                                                                            <tr>
                                                                                <th class="m-6  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Cups</th>
                                                                                <th class="m-6  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Contador</th>
                                                                                <th class="m-6  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Fecha</th>
                                                                                <th class="mt-0 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Hora</th>
                                                                                <th class="mt-0 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Activa Importada
                                                                                    <br>A+
                                                                                </th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Activa<br> A+
                                                                                </th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Activa
                                                                                    Exportada<br>A-
                                                                                </th>
                                                                                <th class="mt-0 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Activa <br>A-
                                                                                </th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Inductiva
                                                                                    Importada <br>Ri+</th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Reactiva
                                                                                    Importada
                                                                                    Ri+
                                                                                </th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Inductiva
                                                                                    Exportada <br>Ri-</th>
                                                                                <th class="mt-0 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Reactiva
                                                                                    Importada<br>
                                                                                    Ri-</th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Capacitiva
                                                                                    Importada <br>Rc+
                                                                                </th>
                                                                                <th class="mt-0 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Reactiva
                                                                                    Importada<br>
                                                                                    Rc+
                                                                                </th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Capacitiva
                                                                                    Exportada <br>Rc-</th>
                                                                                <th class="mt-0  small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Reactiva
                                                                                    Exportada<br>
                                                                                    Rc-</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($resultadosQ24pf as $resultado)
                                                                                <tr class="highlight-row">
                                                                                    <td class="p-8 small ">
                                                                                        {{ !empty($resultado->CUPS) ? $resultado->CUPS : '0' }}
                                                                                    </td>
                                                                                    <td class="p-8 small">
                                                                                        {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : '0' }}
                                                                                    </td>
                                                                                    <td class="p-8 small ">
                                                                                        {{ !empty($resultado->Fecha) ? $resultado->Fecha : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2 small">
                                                                                        {{ !empty($resultado->Hora) ? $resultado->Hora : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Energia_Activa_Importada_A) ? $resultado->Energia_Activa_Importada_A : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Activa_A) ? $resultado->Bit_Calidad_Activa_A : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Energia_Activa_Exportada_A) ? $resultado->Energia_Activa_Exportada_A : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Activa_A2) ? $resultado->Bit_Calidad_Activa_A2 : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Inductiva_Importada_Ri) ? $resultado->Energia_Reactiva_Inductiva_Importada_Ri : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Reactiva_Imp_Ri) ? $resultado->Bit_Calidad_Reactiva_Imp_Ri : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Inductiva_Exportada_Ri) ? $resultado->Energia_Reactiva_Inductiva_Exportada_Ri : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Reactiva_Imp_Ri2) ? $resultado->Bit_Calidad_Reactiva_Imp_Ri2 : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Capacitiva_Importada_Rc) ? $resultado->Energia_Reactiva_Capacitiva_Importada_Rc : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Reactiva_Imp_Rc) ? $resultado->Bit_Calidad_Reactiva_Imp_Rc : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Capacitiva_Exportada_Rc) ? $resultado->Energia_Reactiva_Capacitiva_Exportada_Rc : '0' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Reactiva_Exp_Rc) ? $resultado->Bit_Calidad_Reactiva_Exp_Rc : '0' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                @if ($resultadosQ24pf->hasPages())
                                                                    <div
                                                                        class="flex items-center justify-center space-x-3 mt-6">
                                                                        {{-- Botón "Anterior" --}}
                                                                        @if ($resultadosQ24pf->onFirstPage())
                                                                            <span
                                                                                class="px-3 py-2 text-gray-500 bg-custom-300 rounded-full cursor-not-allowed">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    height="24px"
                                                                                    viewBox="0 -960 960 960"
                                                                                    width="24px" fill="#e8eaed">
                                                                                    <path
                                                                                        d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                                                                                </svg>
                                                                            </span>
                                                                        @else
                                                                            <a href="{{ $resultadosQ24pf->previousPageUrl() }}"
                                                                                class="px-3 py-2 text-sm font-medium text-white bg-custom-300 border-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    height="24px"
                                                                                    viewBox="0 -960 960 960"
                                                                                    width="24px" fill="#e8eaed">
                                                                                    <path
                                                                                        d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                                                                                </svg>
                                                                            </a>
                                                                        @endif

                                                                        {{-- Números de página --}}
                                                                        @php
                                                                            $currentPage = $resultadosQ24pf->currentPage();
                                                                            $lastPage = $resultadosQ24pf->lastPage();
                                                                            $startPage = max(1, $currentPage - 2);
                                                                            $endPage = min($lastPage, $currentPage + 2);
                                                                        @endphp

                                                                        {{-- Mostrar primera página y "..." si es necesario --}}
                                                                        @if ($startPage > 1)
                                                                            <a href="{{ $resultadosQ24pf->url(1) }}"
                                                                                class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                                1
                                                                            </a>
                                                                            @if ($startPage > 2)
                                                                                <span
                                                                                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-custom-300 rounded-full">
                                                                                    ...
                                                                                </span>
                                                                            @endif
                                                                        @endif

                                                                        {{-- Mostrar rango de páginas alrededor de la página actual --}}
                                                                        @for ($page = $startPage; $page <= $endPage; $page++)
                                                                            @if ($page == $currentPage)
                                                                                <span
                                                                                    class="px-3 py-2 text-sm font-medium text-white bg-[rgb(88,226,194)] border-custom-300 rounded-full">
                                                                                    {{ $page }}
                                                                                </span>
                                                                            @else
                                                                                <a href="{{ $resultadosQ24pf->url($page) }}"
                                                                                    class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                                    {{ $page }}
                                                                                </a>
                                                                            @endif
                                                                        @endfor

                                                                        {{-- Mostrar última página y "..." si es necesario --}}
                                                                        @if ($endPage < $lastPage)
                                                                            @if ($endPage < $lastPage - 1)
                                                                                <span
                                                                                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-custom-300 rounded-full">
                                                                                    ...
                                                                                </span>
                                                                            @endif
                                                                            <a href="{{ $resultadosQ24pf->url($lastPage) }}"
                                                                                class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                                {{ $lastPage }}
                                                                            </a>
                                                                        @endif

                                                                        {{-- Botón "Siguiente" --}}
                                                                        @if ($resultadosQ24pf->hasMorePages())
                                                                            <a href="{{ $resultadosQ24pf->nextPageUrl() }}"
                                                                                class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    height="24px"
                                                                                    viewBox="0 -960 960 960"
                                                                                    width="24px" fill="#e8eaed">
                                                                                    <path
                                                                                        d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                                                </svg>
                                                                            </a>
                                                                        @else
                                                                            <span
                                                                                class="px-3 py-2 text-gray-500 bg-custom-300 rounded-full cursor-not-allowed">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    height="24px"
                                                                                    viewBox="0 -960 960 960"
                                                                                    width="24px" fill="#e8eaed">
                                                                                    <path
                                                                                        d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                                                </svg>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                @endif

                                                                {{-- Descargar Excel --}}

                                                                <div class="text-right m-4">
                                                                    <a href="{{ route('reportespf', array_merge(request()->query(), ['export24' => 'excel24'])) }}"
                                                                        class="download-button"
                                                                        data-loading-container="loadingBarContainer24"
                                                                        data-loading-bar="loadingBar24"
                                                                        data-loading-message="loadingMessage24">
                                                                    </a>
                                                                    <div id="loadingBarContainer24"
                                                                        class="loading-bar-container"
                                                                        style="display:none;">
                                                                        <div class="progress">
                                                                            <div class="progress-value"
                                                                                id="loadingBar24">
                                                                            </div>
                                                                        </div>
                                                                        <div id="loadingMessage24"
                                                                            class="loading-message"
                                                                            style="display:none;">
                                                                            Procesando la descarga, por favor espera...
                                                                        </div>
                                                                    </div>
                                                                </div>




                                                                <!-- Contenedor del botón de descarga -->
                                                                {{-- <div class="text-right mt-4">
                                                                    <input type="button"
                                                                        onclick="tableToExcel('testTableCurvasHorarias', 'W3C Example Table')"
                                                                        >
                                                                </div> --}}
                                                            @else
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                    <p class="mt-0 text-xl  text-center"
                                                                        style="color:rgb(88,226,194)">No
                                                                        hay datos
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TERCERA FILA --}}
                                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6"
                                    id=curvas_cuartihorarias>
                                    <div class="card text-white  mb-2"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">
                                            CURVAS CUARTIHORARIAS </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <!-- Contenido  -->
                                        <div class="container">
                                            <div class="table-responsive"
                                                style="display: flex; justify-content: center;">
                                                <div class="overflow-x-auto">
                                                    <div class="container">
                                                        @if (count($resultadosQ25pf) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableCurvasCuartiHorarias"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="m-6  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Cups</th>
                                                                            <th class="m-6  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Contador</th>
                                                                            <th class="m-6  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Fecha</th>
                                                                            <th class="mt-0 small  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Hora</th>
                                                                            <th class="mt-0 small  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Energia Activa Importada
                                                                                <br>A+
                                                                            </th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Bit Calidad Activa<br> A+
                                                                            </th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Energía Activa
                                                                                Exportada<br>A-
                                                                            </th>
                                                                            <th class="mt-0 small  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Bit Calidad Activa <br>A-
                                                                            </th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Energía Reactiva Inductiva
                                                                                Importada <br>Ri+</th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Bit Calidad Reactiva
                                                                                Importada
                                                                                Ri+
                                                                            </th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Energía Reactiva Inductiva
                                                                                Exportada <br>Ri-</th>
                                                                            <th class="mt-0 small  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Bit Calidad Reactiva
                                                                                Importada<br>
                                                                                Ri-</th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Energía Reactiva Capacitiva
                                                                                Importada <br>Rc+
                                                                            </th>
                                                                            <th class="mt-0 small  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Bit Calidad Reactiva
                                                                                Importada<br>
                                                                                Rc+
                                                                            </th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Energía Reactiva Capacitiva
                                                                                Exportada <br>Rc-</th>
                                                                            <th class="mt-0  small text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                Bit Calidad Reactiva
                                                                                Exportada<br>
                                                                                Rc-</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ25pf as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="p-8 small ">
                                                                                    {{ !empty($resultado->CUPS) ? $resultado->CUPS : '0' }}
                                                                                </td>
                                                                                <td class="p-8 small">
                                                                                    {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : '0' }}
                                                                                </td>
                                                                                <td class="p-8 small ">
                                                                                    {{ !empty($resultado->Fecha) ? $resultado->Fecha : '0' }}
                                                                                </td>
                                                                                <td class="py-2 small">
                                                                                    {{ !empty($resultado->Hora) ? $resultado->Hora : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Energia_Activa_Importada_A) ? $resultado->Energia_Activa_Importada_A : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Bit_Calidad_Activa_A) ? $resultado->Bit_Calidad_Activa_A : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Energia_Activa_Exportada_A) ? $resultado->Energia_Activa_Exportada_A : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Bit_Calidad_Activa_A2) ? $resultado->Bit_Calidad_Activa_A2 : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Energia_Reactiva_Inductiva_Importada_Ri) ? $resultado->Energia_Reactiva_Inductiva_Importada_Ri : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Bit_Calidad_Reactiva_Imp_Ri) ? $resultado->Bit_Calidad_Reactiva_Imp_Ri : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Energia_Reactiva_Inductiva_Exportada_Ri) ? $resultado->Energia_Reactiva_Inductiva_Exportada_Ri : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Bit_Calidad_Reactiva_Imp_Ri2) ? $resultado->Bit_Calidad_Reactiva_Imp_Ri2 : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Energia_Reactiva_Capacitiva_Importada_Rc) ? $resultado->Energia_Reactiva_Capacitiva_Importada_Rc : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Bit_Calidad_Reactiva_Imp_Rc) ? $resultado->Bit_Calidad_Reactiva_Imp_Rc : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Energia_Reactiva_Capacitiva_Exportada_Rc) ? $resultado->Energia_Reactiva_Capacitiva_Exportada_Rc : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->Bit_Calidad_Reactiva_Exp_Rc) ? $resultado->Bit_Calidad_Reactiva_Exp_Rc : '0' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            @if ($resultadosQ25pf->hasPages())
                                                                <div
                                                                    class="flex items-center justify-center space-x-3 mt-6">
                                                                    {{-- Botón "Anterior" --}}
                                                                    @if ($resultadosQ25pf->onFirstPage())
                                                                        <span
                                                                            class="px-3 py-2 text-gray-500 bg-custom-300 rounded-full cursor-not-allowed">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                height="24px"
                                                                                viewBox="0 -960 960 960"
                                                                                width="24px" fill="#e8eaed">
                                                                                <path
                                                                                    d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                                                                            </svg>
                                                                        </span>
                                                                    @else
                                                                        <a href="{{ $resultadosQ25pf->previousPageUrl() }}"
                                                                            class="px-3 py-2 text-sm font-medium text-white bg-custom-300 border-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                height="24px"
                                                                                viewBox="0 -960 960 960"
                                                                                width="24px" fill="#e8eaed">
                                                                                <path
                                                                                    d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                                                                            </svg>
                                                                        </a>
                                                                    @endif

                                                                    {{-- Números de página --}}
                                                                    @php
                                                                        $currentPage = $resultadosQ25pf->currentPage();
                                                                        $lastPage = $resultadosQ25pf->lastPage();
                                                                        $startPage = max(1, $currentPage - 2);
                                                                        $endPage = min($lastPage, $currentPage + 2);
                                                                    @endphp

                                                                    {{-- Mostrar primera página y "..." si es necesario --}}
                                                                    @if ($startPage > 1)
                                                                        <a href="{{ $resultadosQ25pf->url(1) }}"
                                                                            class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                            1
                                                                        </a>
                                                                        @if ($startPage > 2)
                                                                            <span
                                                                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-custom-300 rounded-full">
                                                                                ...
                                                                            </span>
                                                                        @endif
                                                                    @endif

                                                                    {{-- Mostrar rango de páginas alrededor de la página actual --}}
                                                                    @for ($page = $startPage; $page <= $endPage; $page++)
                                                                        @if ($page == $currentPage)
                                                                            <span
                                                                                class="px-3 py-2 text-sm font-medium text-white bg-[rgb(88,226,194)] border-custom-300 rounded-full">
                                                                                {{ $page }}
                                                                            </span>
                                                                        @else
                                                                            <a href="{{ $resultadosQ25pf->url($page) }}"
                                                                                class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                                {{ $page }}
                                                                            </a>
                                                                        @endif
                                                                    @endfor

                                                                    {{-- Mostrar última página y "..." si es necesario --}}
                                                                    @if ($endPage < $lastPage)
                                                                        @if ($endPage < $lastPage - 1)
                                                                            <span
                                                                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-custom-300 rounded-full">
                                                                                ...
                                                                            </span>
                                                                        @endif
                                                                        <a href="{{ $resultadosQ25pf->url($lastPage) }}"
                                                                            class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                            {{ $lastPage }}
                                                                        </a>
                                                                    @endif

                                                                    {{-- Botón "Siguiente" --}}
                                                                    @if ($resultadosQ25pf->hasMorePages())
                                                                        <a href="{{ $resultadosQ25pf->nextPageUrl() }}"
                                                                            class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-full hover:bg-[rgb(88,226,194)] focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-[rgb(88,226,194)] active:text-white transition ease-in-out duration-150">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                height="24px"
                                                                                viewBox="0 -960 960 960"
                                                                                width="24px" fill="#e8eaed">
                                                                                <path
                                                                                    d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                                            </svg>
                                                                        </a>
                                                                    @else
                                                                        <span
                                                                            class="px-3 py-2 text-gray-500 bg-custom-300 rounded-full cursor-not-allowed">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                height="24px"
                                                                                viewBox="0 -960 960 960"
                                                                                width="24px" fill="#e8eaed">
                                                                                <path
                                                                                    d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                                            </svg>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            {{-- Descargar Excel --}}

                                                            <div class="text-right m-4">
                                                                <a href="{{ route('reportespf', array_merge(request()->query(), ['export25' => 'excel25'])) }}"
                                                                    class="download-button"
                                                                    data-loading-container="loadingBarContainer25"
                                                                    data-loading-bar="loadingBar25"
                                                                    data-loading-message="loadingMessage25">
                                                                </a>

                                                                <div id="loadingBarContainer25"
                                                                    class="loading-bar-container"
                                                                    style="display:none;">
                                                                    <div class="progress">
                                                                        <div class="progress-value" id="loadingBar25">
                                                                        </div>
                                                                    </div>
                                                                    <div id="loadingMessage25" class="loading-message"
                                                                        style="display:none;">
                                                                        Procesando la descarga, por favor espera...
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <!-- Contenedor del botón de descarga -->
                                                                <div class="text-right mt-4">
                                                                    <input type="button"
                                                                        onclick="tableToExcel('testTableCurvasCuartiHorarias', 'W3C Example Table')"
                                                                        style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                                </div> --}}
                                                        @else
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                <p class="mt-0 text-xl  text-center"
                                                                    style="color:rgb(88,226,194)">No
                                                                    hay datos
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    /* Botón de descarga */
                                    .download-button {
                                        padding: 10px;
                                        /* Ajusta el padding para dar espacio al icono */
                                        width: 32px;
                                        /* Ajusta según el tamaño del icono */
                                        height: 32px;
                                        /* Ajusta según el tamaño del icono */
                                        border: none;
                                        border-radius: 5px;
                                        cursor: pointer;
                                        background-image: url('/images/excel-icon.png');
                                        /* Ruta absoluta */
                                        background-size: contain;
                                        /* Ajusta el tamaño del icono */
                                        background-repeat: no-repeat;
                                        /* Evita la repetición del icono */
                                        background-position: center;
                                        /* Centra el icono */
                                        display: inline-block;
                                    }

                                    /* Contenedor de la barra de progreso */
                                    .loading-bar-container {
                                        position: relative;
                                        width: 100%;
                                        margin-top: 10px;
                                    }

                                    /* Barra de progreso */
                                    .progress {
                                        border-radius: 60px;
                                        overflow: hidden;
                                        width: 100%;
                                        background: rgba(0, 0, 0, 0.075);
                                        height: 10px;
                                        position: relative;
                                    }

                                    .progress-value {
                                        background: rgb(88, 226, 194);
                                        /* Color de la barra de progreso */
                                        height: 100%;
                                        line-height: 20px;
                                        color: white;
                                        border-radius: 60px;
                                        transition: width 0.1s linear;
                                        /* Cambiado a 0.1s para una transición más suave */
                                    }

                                    /* Mensaje de carga */
                                    .loading-message {
                                        margin-top: 10px;
                                        color: rgb(88, 226, 194);
                                        /* Color del mensaje */
                                    }
                                </style>








                                <script>
                                    document.querySelectorAll('.download-button').forEach(button => {
                                        button.addEventListener('click', function(e) {
                                            e.preventDefault();

                                            const loadingContainer = document.getElementById(this.getAttribute(
                                                'data-loading-container'));
                                            const loadingBar = document.getElementById(this.getAttribute('data-loading-bar'));
                                            const loadingMessage = document.getElementById(this.getAttribute('data-loading-message'));

                                            // Mostrar la barra de progreso y el mensaje
                                            loadingContainer.style.display = 'block';
                                            loadingMessage.style.display = 'block';

                                            // Inicializar la barra de progreso
                                            let progress = 0;

                                            // Función para actualizar la barra de progreso
                                            function updateProgress() {
                                                progress += 1;
                                                loadingBar.style.width = progress + '%';
                                                if (progress >= 100) {
                                                    progress = 0; // Reiniciar el progreso a 0
                                                }

                                                // Continuar la animación
                                                setTimeout(updateProgress, 100); // Actualiza cada 100ms
                                            }

                                            updateProgress();

                                            // Obtener la URL de descarga
                                            const url = button.href;

                                            // Hacer la petición de descarga
                                            fetch(url)
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error('Network response was not ok');
                                                    }
                                                    return response.blob();
                                                })
                                                .then(blob => {
                                                    const downloadUrl = window.URL.createObjectURL(blob);
                                                    const link = document.createElement('a');
                                                    link.href = downloadUrl;
                                                    link.setAttribute('download',
                                                        'reporte.xlsx'); // Puedes usar el nombre del archivo que prefieras
                                                    document.body.appendChild(link);
                                                    link.click();
                                                    link.remove();
                                                })
                                                .catch(error => console.error('Error en la descarga:', error))
                                                .finally(() => {
                                                    // Asegurar que el temporizador se detenga al completar la descarga
                                                    loadingBar.style.width = '100%';
                                                    loadingBar.textContent = '100%';
                                                    setTimeout(() => {
                                                        // Ocultar la barra de progreso y el mensaje después de un breve retraso
                                                        loadingContainer.style.display = 'none';
                                                        loadingMessage.style.display = 'none';
                                                    }, 500);
                                                });
                                        });
                                    });
                                </script>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
