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
    </style>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    function exportarArchivo(formato) {
        var fecInicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecFin = document.querySelector('input[name="fecha_fin"]').value;
        var idCups = document.querySelector('input[name="id_cups"]').value;

        var url = "{{ route('exportar.curvas.cups') }}?";

        if (idCups) {
            url += "id_cups=" + encodeURIComponent(idCups) + "&";
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

    <title>Curvas Horarias CUPS</title>
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
                        <a href="{{ route('dashboardct') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('detallesinformacioncups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}"
                            class="nav-item" active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('detallescurvashorariascups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}"
                            class="nav-item is-active" active-color="rgb(88, 226, 194">Curvas Horarias</a>
                        <a href="{{ route('detallesconsumodiariocups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Consumos Diarios</a>
                        <a href="{{ route('detallesenergiacups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}"
                            class="nav-item" active-color="rgb(88, 226, 194">Calidad Energía</a>
                        <a href="{{ route('detalleseventoscups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}"
                            class="nav-item" active-color="rgb(88, 226, 194">Eventos</a> <span
                            class="nav-indicator"></span>
                    </nav>
                    {{-- Obtener el id_cups almacenado en la sesión --}}
                    @php
                        $id_cups = session()->get('id_cups');
                    @endphp
                    {{-- BUSCADOR --}}
                    <div class="container ">
                        <div class="form-group ">
                            <form action="{{ route('curvashorariascups') }}" method="GET">
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
                    @if ($id_cups || isset($id_cnt))
                        @if (!$id_cups)
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">CURVAS HORARIAS CUPS</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
















                            {{-- PRIMERA FILA --}}
                            <div class="container">
                                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2 mb-0">
                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-2 mb-0">
                                        {{-- FILTRO FECHAS --}}
                                        <div class="card text-white  mb-0"
                                            style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div
                                                class="container flex flex-col md:flex-row md:items-center md:justify-center">
                                                <form
                                                    action="{{ route('detallescurvashorariascups', ['id_cups' => $id_cups]) }}"
                                                    method="GET"
                                                    class="flex flex-wrap items-center justify-start gap-2 mt-6">
                                                    {{-- FILTRO FECHAS --}}
                                                    <input type="hidden" name="id_cups"
                                                        value="{{ $id_cups }}">
                                                    <div class="form-group flex items-center">
                                                        <label for="fecha_inicio" class="text-white mr-2">Fecha de
                                                            inicio:</label>
                                                        <input type="date" id="fecha_inicio" name="fecha_inicio"
                                                            class="border border-gray-400 p-2 rounded-lg text-white"
                                                            @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                            max="{{ date('Y-m-d') }}"
                                                            style="background-color: transparent;">
                                                    </div>
                                                    <div class="form-group flex items-center">
                                                        <label for="fecha_fin" class="text-white mr-2">Fecha de
                                                            fin:</label>
                                                        <input type="date" id="fecha_fin" name="fecha_fin"
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-2 mb-0">
                                        {{-- CAJA 2 --}}
                                        <div class="card text-white  mb-0"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="container">
                                                <div class="row">
                                                    @foreach ($resultadosQ8cups as $resultado)
                                                        <div class="col">
                                                            <!-- Cuadrado para KPI Energia Importada (Kwh +) -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Energía
                                                                    Importada<br> (Kwh +)</h2>
                                                                <p class="mt-2 text-2xl  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->total_curva_imp) ? $resultado->total_curva_imp : '0' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para KPI Energia Exportada (Kwh –)  -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Energía
                                                                    Exportada<br> (Kwh –) </h2>
                                                                <p class="mt-2 text-2xl  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->total_curva_exp) ? $resultado->total_curva_exp : '0' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach ($resultadosQ9cups as $resultado)
                                                        <div class="col">
                                                            <!-- Cuadrado para KPI Nro de Horas Leidas -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Nº de
                                                                    Horas<br>
                                                                    Leídas</h2>
                                                                <p class="mt-2 text-2xl  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->curvas_leidas) ? $resultado->curvas_leidas : '0' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach ($resultadosQ10cups as $resultado)
                                                        <div class="col ">
                                                            <!-- Cuadrado para KPI Horas sin consumo -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Nº de Horas
                                                                    Sin<br>
                                                                    Consumo</h2>
                                                                <p class="mt-2 text-2xl  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->curvas_sin_consumo) ? $resultado->curvas_sin_consumo : '0' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- SEGUNDA FILA --}}
                            <div class="container">
                                <div class="card text-white mb-2"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    <h1 class="text-center text-2xl" style="color: white;">CURVAS
                                        HORARIAS
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
                                    <div class="table-responsive w-full"
                                        style="display: flex; justify-content: center;">
                                        @if (count($resultadosQ11cups) > 0)
                                            <div class="chart-container"
                                                style="position: relative; height: 40vh; width: 80vw;  overflow: hidden;">
                                                <canvas id="graficoCurvasHorarias" class="w-full"></canvas>
                                            </div>








                                            {{-- SCRIPTS PARA EL GRÁFICO CURVAS HORARIAS --}}
                                            <script>
                                                var labels_curvashorarias = [];
                                                var values_curvashorarias_ai_h = [];
                                                var values_curvashorarias_ae_h = [];
                                            
                                                @foreach ($resultadosQ11cups as $resultado)
                                                    var dateTime = '{{ $resultado->fec_inicio }} {{ $resultado->hor_inicio }}';
                                                    labels_curvashorarias.push(dateTime);
                                                    values_curvashorarias_ai_h.push({{ $resultado->val_ai_h }});
                                                    values_curvashorarias_ae_h.push({{ $resultado->val_ae_h }});
                                                @endforeach
                                            
                                                // Convertir fechas y horas en objetos Date y ordenar
                                                var sortedData = labels_curvashorarias
                                                    .map((label, index) => {
                                                        const [date, time] = label.split(" ");
                                                        const [day, month, year] = date.split("/");
                                                        const [hours, minutes, seconds] = time.split(":");
                                                        return {
                                                            label,
                                                            date: new Date(year, month - 1, day, hours, minutes, seconds),
                                                            ai_h: values_curvashorarias_ai_h[index],
                                                            ae_h: values_curvashorarias_ae_h[index]
                                                        };
                                                    })
                                                    .sort((a, b) => a.date - b.date); // Ordenar cronológicamente
                                            
                                                // Obtener etiquetas y valores ordenados
                                                var filteredLabels = sortedData.map(item => item.label);
                                                var sortedValuesAI = sortedData.map(item => item.ai_h);
                                                var sortedValuesAE = sortedData.map(item => item.ae_h);
                                            
                                                var myChartLineCurvasHorarias;
                                            
                                                function updateChartLineCurvasHorarias(data) {
                                                    if (myChartLineCurvasHorarias) {
                                                        myChartLineCurvasHorarias.data.labels = data.labels_curvashorarias;
                                                        myChartLineCurvasHorarias.data.datasets[0].data = data.values_curvashorarias_ai_h;
                                                        myChartLineCurvasHorarias.data.datasets[1].data = data.values_curvashorarias_ae_h;
                                                        myChartLineCurvasHorarias.update();
                                                    } else {
                                                        var ctx = document.getElementById('graficoCurvasHorarias').getContext('2d');
                                                        myChartLineCurvasHorarias = new Chart(ctx, {
                                                            type: 'line',
                                                            data: {
                                                                labels: data.labels_curvashorarias,
                                                                datasets: [{
                                                                        label: 'Energía importada',
                                                                        data: data.values_curvashorarias_ai_h,
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
                                                                        label: 'Energía exportada',
                                                                        data: data.values_curvashorarias_ae_h,
                                                                        borderColor: 'rgba(171,38,194, 0.8)',
                                                                        backgroundColor: 'rgba(171,38,194, 0.3)',
                                                                        borderWidth: 2,
                                                                        pointBackgroundColor: 'rgba(147, 38, 191, 0.8)',
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
                                                                        labels: data.labels_curvashorarias.map(label => {
                                                                            const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                            return timeWithoutSeconds;
                                                                        }),
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
                                            
                                                // Actualizar gráfico con los datos ordenados
                                                updateChartLineCurvasHorarias({
                                                    labels_curvashorarias: filteredLabels,
                                                    values_curvashorarias_ai_h: sortedValuesAI,
                                                    values_curvashorarias_ae_h: sortedValuesAE
                                                });
                                            
                                                // Redimensionar el gráfico en caso de cambiar la orientación del dispositivo
                                                window.addEventListener('resize', () => {
                                                    if (myChartLineCurvasHorarias) {
                                                        myChartLineCurvasHorarias.resize();
                                                    }
                                                });
                                            </script>
                                            
                                        @else
                                            <div class="p-4 text-white rounded-lg shadow-xl">
                                                <p class="mt-2 text-xl text-center" style="color:rgb(88,226,194)">No
                                                    hay datos</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>








                            {{-- TERCERA FILA --}}
                            <div class="container">
                                <div class="card text-white  mb-2"
                                    style="
                                  background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                  <h1 class="text-center text-2xl" style="color: white;">
                                                        CURVAS HORARIAS </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                    <div class="container">
                                    @if ($resultadosQ11cupsPaginated instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableCurvasHorarias"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Cups</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Contador</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Fecha Inicio</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Hora Inicio</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Fecha Fin</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Hora Fin</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Val AI H</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                Val AE H</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                VAL R1 H</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                VAL R2 H
                                                            </th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                VAL R3 H</th>
                                                            <th class="m-6 text-center" style="color:rgb(88,226,194)">
                                                                VAL R4 H</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($resultadosQ11cupsPaginated as $resultado)
                                                            <tr class="highlight-row ">
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->fec_inicio) ? $resultado->fec_inicio : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->hor_inicio) ? $resultado->hor_inicio : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->fec_fin) ? $resultado->fec_fin : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->hor_fin) ? $resultado->hor_fin : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->val_ai_h) ? $resultado->val_ai_h : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->val_ae_h) ? $resultado->val_ae_h : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->val_r1_h) ? $resultado->val_r1_h : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->val_r2_h) ? $resultado->val_r2_h : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->val_r3_h) ? $resultado->val_r3_h : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->val_r4_h) ? $resultado->val_r4_h : '0' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="pagination-container mt-4 flex justify-center items-center">
                                                <div class="pagination">
                                                    {{ $resultadosQ11cupsPaginated->links() }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No
                                                    hay
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
                            {{-- CUARTA FILA FILA --}}
                            <div class="container">
                                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-2 mb-6">
                                    {{-- CAJA IZQUIERDA --}}
                                    <div class="card text-white mb-2 col-span-2"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <div class="container">
                                            <h1 class="text-center text-2xl" style="color: white;">CONSUMO PROMEDIO
                                                POR HORA </h1>
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
                                            <div class="table-responsive w-full"
                                                style="display: flex; justify-content: center;">








                                                @php
                                                    // Comprobamos si todos los valores de 'round' son 0
                                                    $todosCeros =
                                                        count($resultadosQ12cups) > 0 &&
                                                        collect($resultadosQ12cups)->every(function ($resultado) {
                                                            return $resultado->round == 0;
                                                        });
                                                @endphp




                                                @if ($todosCeros)
                                                    <div id="chart-container"
                                                        style="position: relative; height: 40vh; width: 100%; overflow: hidden; box-sizing: border-box; display: flex; align-items: center; justify-content: center;">
                                                        <div id="chart-message"
                                                            style="padding: 20px; text-align: left; color: rgb(88,226,194); font-size: 1rem; background-color: rgba(0, 0, 0, 0.8); border: 2px solid rgb(88,226,194); border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); position: relative; width: 100%; max-width: 600px; box-sizing: border-box; word-wrap: break-word; display: flex; align-items: center;">
                                                            <div style="margin-right: 12px;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-info"
                                                                    style="color: rgb(88,226,194);">
                                                                    <circle cx="12" cy="12" r="10">
                                                                    </circle>
                                                                    <line x1="12" y1="16"
                                                                        x2="12" y2="12"></line>
                                                                    <line x1="12" y1="8"
                                                                        x2="12" y2="8"></line>
                                                                </svg>
                                                            </div>
                                                            <p
                                                                style="margin: 0; white-space: normal; word-wrap: break-word; text-align: center;">
                                                                @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                                                    En el rango de fechas seleccionado del
                                                                    {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                                    al
                                                                    {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                                                    el consumo promedio por hora es 0.
                                                                @elseif (request()->query('fecha_inicio'))
                                                                    En el rango de fechas seleccionado del
                                                                    {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                                    al
                                                                    {{ \Carbon\Carbon::now()->format('d/m/Y') }} el
                                                                    consumo
                                                                    promedio por hora es 0.
                                                                @else
                                                                    En los últimos 30 días el consumo promedio por hora
                                                                    es
                                                                    0.
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                @else
                                                    @if (count($resultadosQ12cups) > 0)
                                                        <div class="chart-container"
                                                            style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                            {{-- GRÁFICO DE CONSUMO PROMEDIO --}}
                                                            <canvas id="graficoBarrasConsumoPromedio"
                                                                class="w-full"></canvas>
                                                        </div>
                                                    @else
                                                        <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                            <p class="mt-2 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">No hay datos</p>
                                                        </div>
                                                    @endif
                                                @endif
















                                            </div>
                                            {{-- SCRIPT PARA EL GRÁFICO DE CONSUMO PROMEDIO --}}
                                            <script>
                                                var labels_hor_inicio = [];
                                                var values_round = [];
                                                @foreach ($resultadosQ12cups as $resultado)
                                                    labels_hor_inicio.push('{{ $resultado->hor_inicio }}');
                                                    values_round.push({{ $resultado->round }});
                                                @endforeach








                                                document.addEventListener("DOMContentLoaded", function() {
                                                    // Formatear las horas eliminando los segundos y añadiendo "h"
                                                    var formatted_labels = labels_hor_inicio.map(label => {
                                                        const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                        return timeWithoutSeconds;
                                                    }).sort();








                                                    var data = [{
                                                        label: 'Consumo promedio 24 horas',
                                                        backgroundColor: function(context) {
                                                            var gradient = context.chart.ctx.createLinearGradient(0, 0, 400, 0);
                                                            gradient.addColorStop(0, 'rgba(88, 226, 194, 0.9)');
                                                            gradient.addColorStop(0.8, 'rgba(27,32,38, 0.8)');
                                                            gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                            return gradient;
                                                        },
                                                        borderColor: 'rgba(88, 226, 194, 0.9)',
                                                        borderWidth: 1,
                                                        barThickness: 11, // Ancho de las barras en píxeles








                                                        data: values_round
                                                    }];








                                                    var ctx = document.getElementById('graficoBarrasConsumoPromedio').getContext('2d');
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
                                                                    display: false
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
                                        </div>
                                    </div>
                                    {{-- CAJA DERECHA --}}
                                    <div class="card text-white  mb-2 col-span-1"
                                        style="
                                              background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <div class="container">
                                            <h1 class="text-center text-2xl" style="color: white;">
                                                CONSUMO POR DÍA </h1>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <h2 class="text-center text-1xl w-full mb-2" style="color: white; ">
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
                                            <div class="table-responsive w-full"
                                                style="display: flex; justify-content: center;">








                                                @php
                                                    // Comprobamos si todos los valores de 'round' en $resultadosQ13cups son 0
                                                    $todosCerosQ13 =
                                                        count($resultadosQ13cups) > 0 &&
                                                        collect($resultadosQ13cups)->every(function ($resultado) {
                                                            return $resultado->round == 0;
                                                        });
                                                @endphp


                                                @if ($todosCerosQ13)
                                                    <div id="chart-container"
                                                        style="position: relative; height: 40vh; width: 100%; overflow: hidden; box-sizing: border-box; display: flex; align-items: center; justify-content: center;">
                                                        <div id="chart-message"
                                                            style="display: flex; align-items: center; justify-content: center; padding: 20px; color: rgb(88,226,194); font-size: 1rem; background-color: rgba(0, 0, 0, 0.8); border: 2px solid rgb(88,226,194); border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); position: relative; width: 100%; max-width: 600px; box-sizing: border-box; word-wrap: break-word; text-align: center;">
                                                            <div style="margin-right: 12px;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-info"
                                                                    style="color: rgb(88,226,194);">
                                                                    <circle cx="12" cy="12" r="10">
                                                                    </circle>
                                                                    <line x1="12" y1="16"
                                                                        x2="12" y2="12"></line>
                                                                    <line x1="12" y1="8"
                                                                        x2="12" y2="8"></line>
                                                                </svg>
                                                            </div>
                                                            <p style="margin: 0; flex: 1; text-align: center;">
                                                                @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
                                                                    En el rango de fechas seleccionado del
                                                                    {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                                    al
                                                                    {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
                                                                    el consumo por día es 0.
                                                                @elseif (request()->query('fecha_inicio'))
                                                                    En el rango de fechas seleccionado del
                                                                    {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
                                                                    al
                                                                    {{ \Carbon\Carbon::now()->format('d/m/Y') }} el
                                                                    consumo
                                                                    por día es 0.
                                                                @else
                                                                    En los últimos 30 días el consumo por día es 0.
                                                                @endif
                                                            </p>
                                                        </div>


                                                    </div>
                                                @else
                                                    @if (count($resultadosQ13cups) > 0)
                                                        <div class="p-4 #205E86 text-white rounded-lg shadow-xl mt-10"
                                                            style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                            {{-- GRÁFICO DE Consumo Por Día --}}
                                                            <canvas id="graficoCircularConsumoDia"
                                                                class="w-full"></canvas>
                                                        </div>
                                                    @else
                                                        <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                            <p class="mt-2 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">No hay datos</p>
                                                        </div>
                                                    @endif
                                                @endif


                                            </div>
                                            {{-- SCRIPT PARA EL GRÁFICO DE Consumo Por Día --}}
                                            <script>
                                                var diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                                var data = [];
                                                var total = 0;
                                                @foreach ($resultadosQ13cups as $resultado)
                                                    total += {{ $resultado->round }};
                                                @endforeach
                                                @foreach ($resultadosQ13cups as $resultado)
                                                    @if ($resultado->round != 0)
                                                        var porcentaje = ({{ $resultado->round }} / total) * 100;
                                                        data.push({
                                                            label: ' {{ $resultado->round }} kWh',
                                                            value: {{ $resultado->round }},
                                                            percentage: porcentaje.toFixed(2)
                                                        });
                                                    @endif
                                                @endforeach
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    var ctx = document.getElementById('graficoCircularConsumoDia').getContext('2d');
                                                    var myChart = new Chart(ctx, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: data.map((item, index) => diasSemana[index] + ': ' + item.label),
                                                            datasets: [{
                                                                label: 'Consumo Periodo Tarifario',
                                                                data: data.map(item => item.value),
                                                                backgroundColor: [
                                                                    'rgb(248,73,90)', // Rojo
                                                                    'rgb(88,226,194)', // Azul
                                                                    'RGB(247 229 59)', // Amarillo
                                                                    'rgb(147,195,96)', // Verde
                                                                    'rgb(171,38,194)', // Morado
                                                                    'rgba(255, 159, 64, 0.9)', // Naranja
                                                                    'rgba(0, 102, 204, 0.9)', // Azul oscuro
                                                                    'rgba(0, 153, 0, 0.9)', // Verde oscuro
                                                                    'rgba(255, 102, 0, 0.9)', // Naranja fuerte
                                                                    'rgba(153, 51, 255, 0.9)', // Púrpura claro
                                                                ],
                                                                borderWidth: 0
                                                            }]
                                                        },
                                                        options: {
                                                            maintainAspectRatio: false,
                                                            responsive: true,
                                                            cutout: '80%',
                                                            plugins: {
                                                                legend: {
                                                                    position: 'bottom',
                                                                    labels: {
                                                                        padding: 10, // Ajusta este valor según tu necesidad
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
                                                                            var label = ' ' + data[context.dataIndex].percentage + '%';
                                                                            return label;
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
                                                                    textStrokeColor: 'black', // Agregar borde negro al texto
                                                                    textStrokeWidth: 2, // Ancho del borde del texto
                                                                    formatter: (value, ctx) => {
                                                                        return data[ctx.dataIndex].percentage + '%';
                                                                    }
                                                                }
                                                            },
                                                            rotation: -0.5 * Math.PI // Rotación de 90 grados en sentido antihorario
                                                        },
                                                        plugins: [ChartDataLabels]
                                                    });
                                                });
                                            </script>
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




