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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@latest"></script>


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

        var url = "{{ route('exportar.registros.diarios') }}?";

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

    <title>Consumo Diario CUPS</title>
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
                        <a href="{{ route('detallescurvashorariascups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Curvas Horarias</a>
                        <a href="{{ route('detallesconsumodiariocups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Consumos Diarios</a>
                        <a href="{{ route('detallesenergiacups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Calidad Energía</a>
                        <a href="{{ route('detalleseventoscups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Eventos</a> <span class="nav-indicator"></span>
                    </nav>
                    {{-- Obtener el id_cups almacenado en la sesión --}}
                    @php
                    $id_cups = session()->get('id_cups');
                    $id_cnt = session()->get('id_cnt');
                    $nom_cups = session()->get('nom_cups');
                    @endphp
                    {{-- BUSCADOR --}}
                    <div class="container ">
                        <div class="form-group ">
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
                    @if (!isset($id_cups))
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">INFORMACIÓN CUPS</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                    <div class="container">
                        {{-- GRÁFICO CONSUMOS MENSUALES - GRAFICO DE BARRAS --}}
                        <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2"
                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                            <h1 class="text-center text-2xl" style="color: white;">CONSUMOS</h1>
                            <div
                                style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                            </div>
                            <div class="container">
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
                                        (Último mes)
                                    @endif
                                </h2>
                                <div class="table-responsive w-full"
                                    style="display: flex; justify-content: center;">

                                    {{-- GRÁFICO DE CONSUMOS MENSUALES --}}
                                    <div class="grafico-wrapper"
                                        style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                        <canvas id="graficoBarrasConsumoCups" class="w-full"></canvas>
                                    </div>
                                </div>
                                {{-- SCRIPT PARA EL GRÁFICO DE CONSUMOS DIARIOS --}}
                                <script>
                                    var labels_fecha = [];
                                    var values_ai_d = [];
                                    
                                    @foreach($consumoDiario as $resultado)
                                    console.log(@json($resultado));
                                        // Agregar la fecha en formato dd-mm-yy
                                        labels_fecha.push('{{ $resultado->fec_inicio }}');
                                        // Agregar el valor de energía formateado en kWh
                                        values_ai_d.push({{ $resultado->val_ai_d }});
                                    @endforeach
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var labels = labels_fecha;
                                        var data = [{
                                            label: 'Consumo último mes',
                                            backgroundColor: function(context) {
                                                var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                gradient.addColorStop(0,
                                                    'rgba(88, 226, 194, 1)'); // Color inicial con opacidad 0.9
                                                gradient.addColorStop(0.9,
                                                    'rgba(27,32,38, 0.2)'); // Nuevo color en la mitad del gradiente
                                                gradient.addColorStop(1,
                                                    'rgba(27,32,38, 0)'); // Color final con opacidad 0 (transparente)
                                                return gradient;
                                            },
                                            borderColor: 'rgba(88, 226, 194, 0.9)',
                                            borderWidth: 1,
                                            data: values_ai_d
                                        }];
                                        var ctx = document.getElementById('graficoBarrasConsumoCups').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: labels_fecha,
                                                datasets: data
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    x: {
                                                        grid: {
                                                            color: 'rgba(0, 0, 0, 0)' // Color transparente para desaparecer la rejilla en el eje y
                                                        },
                                                        ticks: {
                                                            color: 'white' // Color blanco para las etiquetas del eje x
                                                                ,
                                                            font: {
                                                                family: 'Didact Gothic', // Tipo de letra
                                                                weight: 'normal' // Peso de la fuente
                                                            }
                                                        }
                                                    },
                                                    y: {
                                                        grid: {
                                                            color: 'rgba(0, 0, 0, 0)' // Color transparente para desaparecer la rejilla en el eje y
                                                        },
                                                        ticks: {
                                                            color: 'white', // Color blanco para las etiquetas del eje y
                                                            callback: function(value, index, values) {
                                                                return value.toFixed(0) + " kWh";
                                                            },
                                                            font: {
                                                                family: 'Didact Gothic', // Tipo de letra
                                                                weight: 'normal' // Peso de la fuente
                                                            }
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: false // Configurar display como false para ocultar la leyenda
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
                                                        color: 'white', // Color blanco para los valores encima de las barras
                                                        font: {
                                                            family: 'Didact Gothic',
                                                            weight: 'normal'
                                                        },
                                                        anchor: 'center', // Alinear el valor al centro de la barra
                                                        align: 'end', // Alinear el valor al centro de la barra
                                                        formatter: function(value, context) {
                                                            return value + " \nkWh";
                                                        }
                                                    }
                                                }
                                            },
                                            plugins: [ChartDataLabels]
                                        });
                                    });
                                </script>
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>


                    {{-- CUARTA FILA --}}
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                                    <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <!-- Contenido de PL6 -->
                                        <div class="container ">
                                            <div class="table-responsive"
                                                style="display: flex; justify-content: center;">
                                                <div class="overflow-x-auto w-full">
                                                    <h1 class="text-center text-2xl" style="color: white;">
                                                        REGISTROS DIARIOS </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                                        {{-- FILTRO FECHAS --}}
                                                        <form
                                                            action="{{ route('detallesconsumodiariocups', ['id_cups' => $id_cups]) }}"
                                                            method="GET"
                                                            class="flex flex-wrap items-center justify-start gap-2 mt-6">
                                                            {{-- FILTRO FECHAS --}}
                                                            <input type="hidden" name="id_cups"
                                                                value="{{ $id_cups }}">
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
                                                                <label for="fecha_fin" class="text-white mr-2">Fecha
                                                                    de
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
                                                    <div class="container">
                                                        @if (count($consumosTotalesDiarios) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableEventos"
                                                                    class="w-full text-white text-center  ">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                CUPS</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                PERIODO</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL AI D</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL AE D</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R1 D</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R2 D</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R3 D</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R4 D</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($consumosTotalesDiarios as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fec_consumo) ? $resultado->fec_consumo : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->cod_periodotarifa) ? $resultado->cod_periodotarifa : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_ai_d) ? $resultado->val_ai_d : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_ae_d) ? $resultado->val_ae_d : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r1_d) ? $resultado->val_r1_d : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r2_d) ? $resultado->val_r2_d : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r3_d) ? $resultado->val_r3_d : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r4_d) ? $resultado->val_r4_d : '0' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="pagination-container mt-4 flex justify-center items-center">
                                                                <div class="pagination">
                                                                    {{ $consumosTotalesDiarios->links() }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                <p class="mt-0 text-xl  text-center"
                                                                    style="color:rgb(88,226,194)">No
                                                                    hay datos
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
                                </div>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</body>