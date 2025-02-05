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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
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
        function tableToExcel(tableID, worksheetName) {
            var table = document.getElementById(tableID); // Crear una tabla con los datos de la tabla HTML
            var data = "<table border='1'>";
            for (var i = 0; i < table.rows.length; i++) {
                var rowData = [];
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    rowData.push(table.rows[i].cells[j].innerText);
                }
                data += "<tr><td>" + rowData.join("</td><td>") + "</td></tr>";
            }
            data += "</table>"; // Convertir a formato Excel y descargar
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!-- ... --></head><body><table>{table}</table></body></html>';
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };
            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };
            var excelData = format(template, {
                worksheet: worksheetName,
                table: data
            }); // Crear un enlace temporal y descargar el archivo Excel
            var link = document.createElement("a");
            link.href = uri + base64(excelData);
            link.download = "exportacion_excel.xls";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    <title>Curvas CuartiHorarias</title>
</head>












<body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center "
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
                        <a href="{{ route('informacionpf', ['id_cnt' => $id_cnt]) }}" class="nav-item  "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('curvashorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Curvas horarias</a>
                        @if ($id_cnt && !empty($mostrarcurvascuartihorarias) && $mostrarcurvascuartihorarias[0]->curva_1 == 1)
                            <a href="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}"
                                class="nav-item is-active" active-color="rgb(88, 226, 194">Curvas Cuartihorarias</a>
                        @endif
                        <a href="{{ route('eventospf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Eventos</a> 
                        <a href="{{ route('reportespf') }}" class="nav-item"
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
                                action="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}" method="GET">
                                <select name="id_cnt" class="form-control mt-2" onchange="this.form.submit()"
                                    style="color: white; background-color: rgb(27, 32, 38);  width: 200px; font-size: 14px; text-align: left;">
                                    {{-- Si hay un id_cnt seleccionado en la sesión, mostrarlo seleccionado --}}
                                    @if ($id_cnt)
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un Punto</option>
                                        @foreach ($parametros as $cnt)
                                            @if ($cnt->curva_1 == 1)
                                                <option class="btn btn-link"
                                                    style="color: white; background-color: rgb(27, 32, 38);"
                                                    value="{{ $cnt->id_cnt }}"
                                                    {{ $selected_cnt == $cnt->id_cnt ? 'selected' : '' }}>
                                                    {{ $cnt->cups }}
                                                </option>
                                            @endif
                                        @endforeach
                                        {{-- Si no hay un id_cnt seleccionado en la sesión, mostrar la opción "Seleccione un CT" --}}
                                    @else
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un Punto</option>
                                        @foreach ($parametros as $cnt)
                                            @if ($cnt->curva_1 == 1)
                                                <option class="btn btn-link"
                                                    style="color: white; background-color: rgb(27, 32, 38);"
                                                    value="{{ $cnt->id_cnt }}">
                                                    {{ $cnt->cups }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </form>




                        </div>
                    </div>
                    {{-- INICIO BODY DE LA VISTA --}}
                    @if ($id_cnt)
                        @if (!empty($mostrarcurvascuartihorarias) && $mostrarcurvascuartihorarias[0]->curva_1 !== 1)
                            <div class="flex justify-center">
                                <div class="alert alert-danger text-center max-w-max flex items-center space-x-2"
                                    role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 15 15">
                                        <path fill="#e11d48" fill-rule="evenodd"
                                            d="M0 7.5a7.5 7.5 0 1 1 15 0a7.5 7.5 0 0 1-15 0m10.147 3.354L7.5 8.207l-2.646 2.647l-.708-.707L6.793 7.5L4.146 4.854l.708-.708L7.5 6.793l2.646-2.647l.708.708L8.207 7.5l2.647 2.646z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>No se encontró información de curvas cuartihorarias para el Contador
                                        proporcionado.</span>
                                </div>
                            </div>
                        @elseif (count($resultadosQ1pf) === 0)
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">CURVAS CUARTIHORARIAS</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                        border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                            @foreach ($parametros as $cnt)
                                @if ($cnt->id_cnt == $id_cnt)
                                    {{-- CONTENEDOR CUERPO --}}
                                    <div class="container ">
                                        {{-- PRIMERA FILA --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-6 mb-4">
    
                                            {{-- SELECTOR DE FECHAS --}}
                                            <div class="card text-white mb-2 lg:col-span-3" style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="container mt-4 justify-center items-center flex flex-col">
                                                    <div class="form-group">
                                                        <form action="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}" method="GET"
                                                            class="flex flex-col md:flex-row items-center justify-start space-y-4 md:space-y-0 md:space-x-4 mb-4 mt-4 mr-2">
                                                            
                                                            <input type="hidden" name="id_cnt" value="{{ $id_cnt }}">
                                                            <div class="form-group">
                                                                <label for="fecha_inicio" class="text-white">Fecha de inicio:</label>
                                                                <input type="date" id="fecha_inicio" name="fecha_inicio"
                                                                    class="border border-gray-400 p-2 rounded-lg text-white w-full md:w-auto"
                                                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                                            </div>
                                        
                                                            <div class="form-group">
                                                                <label for="fecha_fin" class="text-white">Fecha de fin:</label>
                                                                <input type="date" id="fecha_fin" name="fecha_fin"
                                                                    class="border border-slate-900 p-2 rounded-lg text-white w-full md:w-auto"
                                                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                                            </div>
                                        
                                                            <button type="submit" class="btn btn-outline-info mt-2 md:mt-0 md:ml-2 mb-2 text-white"
                                                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            {{-- Nº CURVAS CUARTIHORARIAS SIN CONSUMO --}}
                                            <div class="card text-white mb-2 lg:col-span-1" style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="flex flex-col items-center justify-center text-center m-2 p-2 rounded-lg">
                                                    <h2 class="text-white text-sm">Nº CURVAS CUARTIHORARIAS <br>SIN CONSUMO</h2>
                                                    <div class="#205E86 text-white rounded-lg shadow-xl">
                                                        <p class="mt-2 text-{{ count($resultadosQ17pf) > 0 && !empty($resultadosQ17pf[0]->Energia_Activa_Importada_A) ? '5xl' : '5xl' }}"
                                                            style="color:rgb(248,73,90)">
                                                            {{ count($resultadosQ17pf) > 0 && !empty($resultadosQ17pf[0]->Energia_Activa_Importada_A) ? number_format($resultadosQ17pf[0]->Energia_Activa_Importada_A, 0, '.', '.') : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            {{-- KWH A+ --}}
                                            <div class="card text-white mb-2 lg:col-span-1" style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="flex flex-col items-center justify-center text-center m-2 p-2 rounded-lg">
                                                    <h2 class="text-white">Kwh (A+)</h2>
                                                    <div class="#205E86 text-white rounded-lg shadow-xl">
                                                        <p class="mt-4 text-{{ count($resultadosQ18pf) > 0 && !empty($resultadosQ18pf[0]->suma_importada) ? '5xl' : '5xl' }}"
                                                            style="color:rgb(88,226,194)">
                                                            {{ count($resultadosQ18pf) > 0 && !empty($resultadosQ18pf[0]->suma_importada) ? number_format($resultadosQ18pf[0]->suma_importada, 0, '.', '.') : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            {{-- KWH A- --}}
                                            <div class="card text-white mb-2 lg:col-span-1" style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="flex flex-col items-center justify-center text-center m-2 p-2 rounded-lg">
                                                    <h2 class="text-white">Kwh (A-)</h2>
                                                    <div class="#205E86 text-white rounded-lg shadow-xl">
                                                        <p class="mt-4 text-{{ count($resultadosQ19pf) > 0 && !empty($resultadosQ19pf[0]->suma_exportada) ? '5xl' : '5xl' }}"
                                                            style="color:rgb(88,226,194)">
                                                            {{ count($resultadosQ19pf) > 0 && !empty($resultadosQ19pf[0]->suma_exportada) ? number_format($resultadosQ19pf[0]->suma_exportada, 0, '.', '.') : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        






                                        {{-- SEGUNDA FILA --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white  mb-2"
                                                style=" background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">CURVAS
                                                    CUARTIHORARIAS
                                                </h1>
                                                <h2 class="text-center text-1xl w-full mb-2" style="color: white;">
                                                    @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                                        Del
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                        al
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                                    @elseif (request()->query('fecha_inicio'))
                                                        Del
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                        al
                                                        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                                    @else
                                                        (Últimos 30 días)
                                                    @endif
                                                </h2>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                 border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="table-responsive w-full"
                                                        style="display: flex; justify-content: center;">
                                                        @if (is_array($resultadosQ20pf) && count($resultadosQ20pf) > 0)
                                                            <div class="grafico-wrapper"
                                                                style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
















                                                                <canvas id="graficoCurvasCuartiHorarias"
                                                                    class="w-full"></canvas>
                                                            </div>
                                                            {{-- SCRIPTS PARA EL GRÁFICO CURVAS CUARTIHORARIAS --}}
                                                            <script>
                                                                var labels_curvascuartihorarias = [];
                                                                var values_curvascuartihorarias_A = [];
                                                                var values_curvascuartihorarias_Ri = [];
                                                                var values_curvascuartihorarias_Exportada_A = []; // Nuevo array para Energia_Activa_Exportada_A
                                                            
                                                                @foreach ($resultadosQ20pf as $resultado)
                                                                    var dateTime = '{{ $resultado->Fecha }} {{ $resultado->Hora }}';
                                                                    labels_curvascuartihorarias.push(dateTime);
                                                                    values_curvascuartihorarias_A.push({{ $resultado->Energia_Activa_Importada_A }});
                                                                    values_curvascuartihorarias_Ri.push({{ $resultado->Energia_Reactiva_Inductiva_Importada_Ri }});
                                                                    values_curvascuartihorarias_Exportada_A.push({{ $resultado->Energia_Activa_Exportada_A }}); // Recolectar los datos de Energia_Activa_Exportada_A
                                                                @endforeach
                                                            
                                                                var sortedData = labels_curvascuartihorarias.slice().sort();
                                                                var filteredLabels = [sortedData[0]];
                                                                for (var i = 1; i < sortedData.length; i++) {
                                                                    if (sortedData[i] !== sortedData[i - 1]) {
                                                                        filteredLabels.push(sortedData[i]);
                                                                    }
                                                                }
                                                            
                                                                var myChartLineCurvasHorarias;
                                                            
                                                                function updateChartLineCurvasHorarias(data) {
                                                                    if (myChartLineCurvasHorarias) {
                                                                        myChartLineCurvasHorarias.data.labels = data.labels_curvascuartihorarias;
                                                                        myChartLineCurvasHorarias.data.datasets[0].data = data.values_curvascuartihorarias_Ri;
                                                                        myChartLineCurvasHorarias.data.datasets[1].data = data.values_curvascuartihorarias_A;
                                                                        myChartLineCurvasHorarias.data.datasets[2].data = data.values_curvascuartihorarias_Exportada_A; // Actualizar con los nuevos datos
                                                                        myChartLineCurvasHorarias.update();
                                                                    } else {
                                                                        var ctx = document.getElementById('graficoCurvasCuartiHorarias').getContext('2d');
                                                                        myChartLineCurvasHorarias = new Chart(ctx, {
                                                                            type: 'line',
                                                                            data: {
                                                                                labels: data.labels_curvascuartihorarias,
                                                                                datasets: [{
                                                                                        label: 'Energía Reactiva Inductiva Importada Ri',
                                                                                        data: data.values_curvascuartihorarias_Ri,
                                                                                        borderColor: 'rgba(171,38,194, 0.8)',
                                                                                        backgroundColor: 'rgba(171,38,194, 0.3)',
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: 'rgba(147, 38, 191, 0.8)',
                                                                                        pointBorderColor: 'rgba(255, 255, 255, 0.5)',
                                                                                        pointBorderWidth: 0,
                                                                                        pointRadius: 0,
                                                                                        fill: true,
                                                                                        tension: 0.4
                                                                                    },
                                                                                    {
                                                                                        label: 'Energía Activa Importada A',
                                                                                        data: data.values_curvascuartihorarias_A,
                                                                                        borderColor: 'rgb(88,226,194)',
                                                                                        backgroundColor: function(context) {
                                                                                            var gradient = context.chart.ctx.createLinearGradient(0, 0, 30, 700);
                                                                                            gradient.addColorStop(0.1, 'rgba(88, 226, 194, 0.9)');
                                                                                            gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                                                            return gradient;
                                                                                        },
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: 'rgba(54, 162, 100, 0.8)',
                                                                                        pointBorderColor: 'rgba(255, 255, 255, 0.5)',
                                                                                        pointBorderWidth: 0,
                                                                                        pointRadius: 0,
                                                                                        fill: true,
                                                                                        tension: 0.4
                                                                                    },
                                                                                    {
                                                                                        label: 'Energía Activa Exportada A', // Nuevo dataset para Energia_Activa_Exportada_A
                                                                                        data: data.values_curvascuartihorarias_Exportada_A,
                                                                                        borderColor: 'rgb(255,165,0)', // Color naranja
                                                                                        backgroundColor: function(context) {
                                                                                            var gradient = context.chart.ctx.createLinearGradient(0, 0, 30, 700);
                                                                                            gradient.addColorStop(0.1, 'rgba(255,165,0, 0.9)');
                                                                                            gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                                                            return gradient;
                                                                                        },
                                                                                        borderWidth: 2,
                                                                                        pointBackgroundColor: 'rgba(255,165,0, 0.8)', // Color naranja para los puntos
                                                                                        pointBorderColor: 'rgba(255, 255, 255, 0.5)',
                                                                                        pointBorderWidth: 0,
                                                                                        pointRadius: 0,
                                                                                        fill: true,
                                                                                        tension: 0.4
                                                                                    }
                                                                                ]
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
                                                                                            title: function(tooltipItems, data) {
                                                                                                var tooltipTitle = '';
                                                                                                if (tooltipItems.length > 0) {
                                                                                                    var label = tooltipItems[0].label;
                                                                                                    tooltipTitle = label;
                                                                                                }
                                                                                                return tooltipTitle;
                                                                                            },
                                                                                            label: function(context) {
                                                                                                var label = '';
                                                                                                if (context.parsed.y !== null) {
                                                                                                    label += context.parsed.y;
                                                                                                }
                                                                                                return label;
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
                                                                                        labels: data.labels_curvascuartihorarias.map(label => {
                                                                                            const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                                            return timeWithoutSeconds;
                                                                                        }).sort(),
                                                                                        grid: {
                                                                                            color: '#666'
                                                                                        },
                                                                                        ticks: {
                                                                                            color: '#FFFFFF'
                                                                                        }
                                                                                    },
                                                                                    y: {
                                                                                        beginAtZero: false,
                                                                                        grid: {
                                                                                            color: '#666'
                                                                                        },
                                                                                        ticks: {
                                                                                            color: '#FFFFFF'
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                            
                                                                updateChartLineCurvasHorarias({
                                                                    labels_curvascuartihorarias: filteredLabels,
                                                                    values_curvascuartihorarias_A: values_curvascuartihorarias_A,
                                                                    values_curvascuartihorarias_Ri: values_curvascuartihorarias_Ri,
                                                                    values_curvascuartihorarias_Exportada_A: values_curvascuartihorarias_Exportada_A // Pasar los nuevos datos a la función
                                                                });
                                                            </script>
                                                            
                                                        @else
                                                            <div class="p-4 text-white rounded-lg shadow-xl">
                                                                <p class="mt-2 text-xl  text-center"
                                                                    style="color:rgb(88,226,194)">No
                                                                    hay datos</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- TERCERA FILA --}}
                                        {{-- NUEVA GRAFICA - Media de Consumo por Hora (Grafica) para A+ y A- --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                            <div class="card text-white  mb-2 col-span-2"
                                                style=" background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">ENERGÍA (A+ y
                                                    A-) <br>PROMEDIO POR HORA </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                 border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <h2 class="text-center text-1xl w-full mb-2" style="color: white;">
                                                    @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                                        Del
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                        al
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                                    @elseif (request()->query('fecha_inicio'))
                                                        Del
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                        al
                                                        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                                    @else
                                                        (Últimos 30 días)
                                                    @endif
                                                </h2>
















                                                <div class="container">
                                                    <div class="table-responsive w-full"
                                                        style="display: flex; justify-content: center;">
                                                        @if (is_array($resultadosQ21pf) && count($resultadosQ21pf) > 0)
                                                            <div class="grafico-wrapper"
                                                                style="position: relative; height: 60vh; width: 80vw; overflow: hidden;">
















                                                                <canvas id="graficoConsumoHora"
                                                                    class="w-full"></canvas>
                                                            </div>
                                                            {{-- SCRIPTS PARA EL GRÁFICO CONSUMO POR HORA --}}
                                                            <script>
                                                                var labels_fechahora = [];
                                                                var values_consumohora_Amas = [];
                                                                var values_consumohora_Amenos = [];
                                                                @foreach ($resultadosQ21pf as $resultado)
                                                                    var dateTime = '{{ $resultado->hora }}';
                                                                    labels_fechahora.push(dateTime);
                                                                    values_consumohora_Amas.push({{ $resultado->media_consumo_hora_imp }});
                                                                    values_consumohora_Amenos.push({{ $resultado->media_consumo_hora_exp }});
                                                                @endforeach
















                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    // Formatear las horas eliminando los segundos y añadiendo "h"
                                                                    var formatted_labels = labels_fechahora.map(label => {
                                                                        const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                        return timeWithoutSeconds;
                                                                    }).sort();
















                                                                    var data = [{
                                                                            label: 'Kwh (A+)',
                                                                            backgroundColor: function(context) {
                                                                                var gradient = context.chart.ctx.createLinearGradient(0, 0, 400, 0);
                                                                                gradient.addColorStop(0, 'rgba(88, 226, 194, 0.9)');
                                                                                gradient.addColorStop(0.8, 'rgba(27,32,38, 0.8)');
                                                                                gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                                                return gradient;
                                                                            },
                                                                            borderColor: 'rgba(88, 226, 194, 0.9)',
                                                                            borderWidth: 1,
                                                                            data: values_consumohora_Amas
                                                                        },
                                                                        {
                                                                            label: 'Kwh (A-)',
                                                                            backgroundColor: function(context) {
                                                                                var gradient = context.chart.ctx.createLinearGradient(0, 0, 400, 0);
                                                                                gradient.addColorStop(0,
                                                                                    'rgba(171, 38, 194, 0.9)'
                                                                                ); // Cambié el valor de opacidad a 0.9 para mantener consistencia
                                                                                gradient.addColorStop(0.8, 'rgba(27,32,38, 0.8)');
                                                                                gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                                                return gradient;
                                                                            },
                                                                            borderColor: 'rgba(171, 38, 194, 0.8)',
                                                                            borderWidth: 1,
                                                                            data: values_consumohora_Amenos
                                                                        }
                                                                    ];












                                                                    var ctx = document.getElementById('graficoConsumoHora').getContext('2d');
                                                                    var myChart = new Chart(ctx, {
                                                                        type: 'bar',
                                                                        data: {
                                                                            labels: formatted_labels,
                                                                            datasets: data
                                                                        },
                                                                        options: {
                                                                            responsive: true,
                                                                            maintainAspectRatio: false, // Permitir que el gráfico se adapte al contenedor
                                                                            indexAxis: 'y',
                                                                            scales: {
                                                                                x: {
                                                                                    grid: {
                                                                                        color: 'rgba(0, 0, 0, 0)'
                                                                                    },
                                                                                    ticks: {
                                                                                        color: 'white',
                                                                                        font: {
                                                                                            family: 'Didact Gothic',
                                                                                            weight: 'normal'
                                                                                        },
                                                                                        callback: function(value, index, values) {
                                                                                            return value.toFixed(0) + " kWh";
                                                                                        }
                                                                                    }
                                                                                },
                                                                                y: {
                                                                                    grid: {
                                                                                        color: 'rgba(0, 0, 0, 0)'
                                                                                    },
                                                                                    ticks: {
                                                                                        color: 'white',
                                                                                        font: {
                                                                                            family: 'Didact Gothic',
                                                                                            weight: 'normal'
                                                                                        }
                                                                                    }
                                                                                }
                                                                            },
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
                                                                                    titleFont: {
                                                                                        family: 'Didact Gothic',
                                                                                        weight: 'normal'
                                                                                    },
                                                                                    bodyFont: {
                                                                                        family: 'Didact Gothic',
                                                                                        weight: 'normal'
                                                                                    }
                                                                                },
                                                                                datalabels: {
                                                                                    color: 'white',
                                                                                    font: {
                                                                                        family: 'Didact Gothic',
                                                                                        weight: 'normal'
                                                                                    },
                                                                                    anchor: 'end',
                                                                                    align: 'end',
                                                                                    formatter: function(value, context) {
                                                                                        if (value !== 0) {
                                                                                            return value;
                                                                                        } else {
                                                                                            return '';
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        },
                                                                        plugins: [ChartDataLabels]
                                                                    });
















                                                                    // Manejar redimensionamiento de la ventana
                                                                    window.addEventListener('resize', function() {
                                                                        if (myChart) {
                                                                            myChart.resize();
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                        @else
                                                            <div class="p-4 text-white rounded-lg shadow-xl">
                                                                <p class="mt-2 text-xl  text-center"
                                                                    style="color:rgb(88,226,194)">No
                                                                    hay datos</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>












                                            <div class="card text-white  mb-2 col-span-1 w-full"
                                                style=" background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">ENERGÍA (A+ y
                                                    A-) <br>PROMEDIO POR DÍA DE LA SEMANA</h1>
















                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <h2 class="text-center text-1xl w-full mb-2" style="color: white;">
                                                    @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                                        Del
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                        al
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                                    @elseif (request()->query('fecha_inicio'))
                                                        Del
                                                        {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                        al
                                                        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                                    @else
                                                        (Últimos 30 días)
                                                    @endif
                                                </h2>
                                                <div class="container">
                                                    @if (is_array($resultadosQ22pf) && count($resultadosQ22pf) > 0)
                                                        <!-- Leyenda adicional para alternar visibilidad -->
                                                        <div id="toggleLegend"
                                                            style="text-align: center; margin-bottom: 10px;">
                                                            <button id="toggleAmas"
                                                                style="margin-right: 10px; position: relative; padding-left: 30px; outline: none;">
                                                                <span
                                                                    style="position: absolute; left: 5px; top: 50%; transform: translateY(-50%); width: 30px; height: 12px; border: 1px solid rgba(88, 226, 194, 0.8); background-color: transparent;"></span>
                                                                <p class="ml-2 text-sm legend-text" data-dataset="0">
                                                                    Kwh (A+)</p>
                                                            </button>
                                                            <button id="toggleAmenos"
                                                                style="position: relative; padding-left: 30px; outline: none;">
                                                                <span
                                                                    style="position: absolute; left: 5px; top: 50%; transform: translateY(-50%); width: 30px; height: 12px; border: 1px solid rgba(171, 38, 194, 0.8); background-color: transparent;"></span>
                                                                <p class="ml-2 text-sm legend-text" data-dataset="1">
                                                                    Kwh (A-)</p>
                                                            </button>
                                                        </div>
                                                        <div class="table-responsive w-full"
                                                            style="display: flex; justify-content: center;">








                                                            <div class="grafico-wrapper"
                                                                style="position: relative; height: 50vh; width: 80vw; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                                                <canvas id="graficoConsumoDiaSemana"
                                                                    class="w-full mt-10"></canvas>
                                                            </div>
















                                                            {{-- SCRIPTS PARA EL GRÁFICO CONSUMO DIA DE LA SEMANA  --}}
                                                            <script>
                                                                var labels_diasemana = [];
                                                                var values_consumodia_Amas = [];
                                                                var values_consumodia_Amenos = [];








                                                                // Recopilar datos del servidor
                                                                @foreach ($resultadosQ22pf as $resultado)
                                                                    labels_diasemana.push('{{ $resultado->dia_semana }}');
                                                                    values_consumodia_Amas.push(parseFloat('{{ $resultado->media_consumo_dia_imp }}'));
                                                                    values_consumodia_Amenos.push(parseFloat('{{ $resultado->media_consumo_dia_exp }}'));
                                                                @endforeach








                                                                // Calcular totales y porcentajes
                                                                var total_Amas = values_consumodia_Amas.reduce((acc, value) => acc + value, 0);
                                                                var total_Amenos = values_consumodia_Amenos.reduce((acc, value) => acc + value, 0);








                                                                var data_Amas = labels_diasemana.map((label, index) => {
                                                                    return {
                                                                        label: label + ' (A+)',
                                                                        value: values_consumodia_Amas[index],
                                                                        percentage: ((values_consumodia_Amas[index] / total_Amas) * 100).toFixed(2)
                                                                    };
                                                                });








                                                                var data_Amenos = labels_diasemana.map((label, index) => {
                                                                    return {
                                                                        label: label + ' (A-)',
                                                                        value: values_consumodia_Amenos[index],
                                                                        percentage: total_Amenos > 0 ? ((values_consumodia_Amenos[index] / total_Amenos) * 100).toFixed(2) :
                                                                            0
                                                                    };
                                                                });








                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var ctx = document.getElementById('graficoConsumoDiaSemana').getContext('2d');
                                                                    var myChart = new Chart(ctx, {
                                                                        type: 'doughnut',
                                                                        data: {
                                                                            labels: labels_diasemana,
                                                                            datasets: [{
                                                                                    label: 'Kwh (A+)',
                                                                                    data: data_Amas.map(item => item.value),
                                                                                    backgroundColor: [
                                                                                        'rgb(248, 73, 90 )', // Rojo
                                                                                        'rgb(88, 226, 194 )', // Azul
                                                                                        'rgb(247, 229, 59)', // Amarillo
                                                                                        'rgb(147, 195, 96)', // Verde
                                                                                        'rgb(171, 38, 194)', // Morado
                                                                                        'rgb(255, 159, 64)', // Naranja
                                                                                        'rgb(0, 102, 204)', // Azul oscuro
                                                                                        'rgb(0, 153, 0)', // Verde oscuro
                                                                                        'rgb(255, 102, 0)', // Naranja fuerte
                                                                                        'rgb(153, 51, 255)' // Púrpura claro
                                                                                    ],
                                                                                    borderWidth: 0
                                                                                },
                                                                                {
                                                                                    label: 'Kwh (A-)',
                                                                                    data: data_Amenos.map(item => item.value),
                                                                                    backgroundColor: [
                                                                                        'rgba(248, 73, 90, 0.5)', // Rojo
                                                                                        'rgba(88, 226, 194, 0.5)', // Azul
                                                                                        'rgba(247, 229, 59, 0.5)', // Amarillo
                                                                                        'rgba(147, 195, 96, 0.5)', // Verde
                                                                                        'rgba(171, 38, 194, 0.5)', // Morado
                                                                                        'rgba(255, 159, 64, 0.5)', // Naranja
                                                                                        'rgba(0, 102, 204, 0.5)', // Azul oscuro
                                                                                        'rgba(0, 153, 0, 0.5)', // Verde oscuro
                                                                                        'rgba(255, 102, 0, 0.5)', // Naranja fuerte
                                                                                        'rgba(153, 51, 255, 0.5)' // Púrpura claro
                                                                                    ],
                                                                                    borderWidth: 0
                                                                                }
                                                                            ]
                                                                        },
                                                                        options: {
                                                                            maintainAspectRatio: false,
                                                                            responsive: true,
                                                                            cutout: '60%',
                                                                            plugins: {
                                                                                legend: {
                                                                                    position: 'bottom', // Mantener la leyenda inferior
                                                                                    labels: {
                                                                                        padding: 10,
                                                                                        usePointStyle: true,
                                                                                        color: 'white',
                                                                                        text: {
                                                                                            padding: 5,
                                                                                            lineHeight: 1.6
                                                                                        },
                                                                                        font: {
                                                                                            family: 'Didact Gothic',
                                                                                            weight: "bold"
                                                                                        },
                                                                                    },
                                                                                },
                                                                                tooltip: {
                                                                                    callbacks: {
                                                                                        label: function(context) {
                                                                                            var datasetLabel = context.dataset.label || '';
                                                                                            var value = context.raw.toFixed(
                                                                                                2); // Mostrar el valor real con 2 decimales
                                                                                            return datasetLabel + ': ' + value + ' kWh';
                                                                                        }
                                                                                    }
                                                                                },
                                                                                datalabels: {
                                                                                    anchor: "outside",
                                                                                    color: "white",
                                                                                    font: {
                                                                                        family: 'Didact Gothic',
                                                                                        size: "16",
                                                                                        weight: "bold"
                                                                                    },
                                                                                    textStrokeColor: 'black',
                                                                                    textStrokeWidth: 2,
                                                                                    formatter: (value, ctx) => {
                                                                                        if (ctx.dataset.label === 'Kwh (A+)') {
                                                                                            return data_Amas[ctx.dataIndex].percentage + '%';
                                                                                        } else {
                                                                                            return data_Amenos[ctx.dataIndex].percentage + '%';
                                                                                        }
                                                                                    }
                                                                                }
                                                                            },
                                                                            rotation: -0.5 * Math.PI
                                                                        },
                                                                        plugins: [ChartDataLabels]
                                                                    });








                                                                    // Obtener los elementos de texto para manipular
                                                                    var legendTexts = document.querySelectorAll('.legend-text');








                                                                    // Agregar manejadores de eventos para los botones de alternar
                                                                    document.getElementById('toggleAmas').addEventListener('click', function() {
                                                                        var meta = myChart.getDatasetMeta(0);
                                                                        meta.hidden = meta.hidden === null ? !myChart.data.datasets[0].hidden : null;
                                                                        myChart.update();








                                                                        // Toggle del estilo de tachado del texto
                                                                        toggleStrikeThrough(0);
                                                                    });








                                                                    document.getElementById('toggleAmenos').addEventListener('click', function() {
                                                                        var meta = myChart.getDatasetMeta(1);
                                                                        meta.hidden = meta.hidden === null ? !myChart.data.datasets[1].hidden : null;
                                                                        myChart.update();








                                                                        // Toggle del estilo de tachado del texto
                                                                        toggleStrikeThrough(1);
                                                                    });








                                                                    // Función para aplicar o quitar el tachado al texto según el estado del botón
                                                                    function toggleStrikeThrough(index) {
                                                                        // Obtener el texto correspondiente al índice
                                                                        var textElement = legendTexts[index];








                                                                        // Aplicar el tachado si el botón está activo (hidden !== null)
                                                                        if (myChart.getDatasetMeta(index).hidden !== null) {
                                                                            textElement.style.textDecoration = 'line-through';
                                                                        } else {
                                                                            textElement.style.textDecoration = 'none';
                                                                        }
                                                                    }
                                                                });
                                                            </script>
                                                        @else
                                                            <div class="p-4 text-white rounded-lg shadow-xl">
                                                                <p class="mt-2 text-xl  text-center"
                                                                    style="color:rgb(88,226,194)">No
                                                                    hay datos</p>
                                                            </div>








                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>












                                    {{-- CUARTA FILA --}}
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">












                                        {{-- PL4 --}}
                                        <div class="card text-white  mb-2"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <!-- Contenido de PL4 -->
                                            <div class="container">
                                                <div class="table-responsive"
                                                    style="display: flex; justify-content: center;">
                                                    <div class="overflow-x-auto">
                                                        <h1 class="text-center text-2xl" style="color: white;">
                                                        CURVAS CUARTIHORARIAS </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                        <div class="container">
                                                            @if (count($resultadosQ20pf) > 0)
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                    style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                    <table id="testTableCurvasCuartiHorarias"
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
                                                                            @foreach ($resultadosQ20pf as $resultado)
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
                                                            @else
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                    <p class="mt-0 text-xl  text-center"
                                                                        style="color:rgb(88,226,194)">No
                                                                        hay datos
                                                                    </p>
                                                                </div>
                                                                <!-- Contenedor del botón de descarga -->
                                                                <div class="text-right mt-4">
                                                                    <input type="button"
                                                                        onclick="tableToExcel('testTableCurvasCuartiHorarias', 'W3C Example Table')"
                                                                        style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                                </div>
                                                            @endif




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










