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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    {{-- TAILWIND --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.31.1.min.js'></script> <!-- Load plotly.js into the DOM -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script> {{-- ENLACE A JS GENERAL --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

































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
































        /* body {
            text-align: center;
            display: flex;
            height: 100vh;
            width: 100%;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            /* background-image: url("https://www.toptal.com/designers/subtlepatterns/patterns/debut_light.png"); */
        /* } */
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
    <script>
        window.onload = function() {
            updateChartLine48h({
                labels_48h: labels_48h,
                values_48h: values_48h
            });
        };
    </script>
    <title>Señal PLC</title>
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
            </svg> <i class="fas fa-arrow-up"></i>
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
                        <a href="{{ route('señalplc', ['id_ct' => $id_ct]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Lecturas/Señal PLC</a>
                        @foreach ($ct_info as $ct)
                            @if ($ct->id_ct == $id_ct && $ct->ind_balance == true)
                                <a href="{{ route('balances', ['id_ct' => $id_ct]) }}" class="nav-item"
                                    active-color="rgb(88, 226, 194">Balances</a>
                            @endif
                        @endforeach
                        <a href="{{ route('eventosct', ['id_ct' => $id_ct]) }}" class="nav-item"
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
                                action="{{ route('señalplc', ['id_ct' => $id_ct]) }}" method="GET">
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
                    {{-- INICIO BODY DE LA VISTA --}}
                    @if ($id_ct)
                        @php
                            // Filtrar para encontrar el CT seleccionado
                            $selected_ct_info = $ct_info->filter(function ($ct) use ($id_ct) {
                                return $ct->id_ct == $id_ct;
                            });
                        @endphp


                        @if ($selected_ct_info->isEmpty())
                            <div class="flex justify-center">
                                <div class="alert alert-danger text-center max-w-max flex items-center space-x-2"
                                    role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 15 15">
                                        <path fill="#e11d48" fill-rule="evenodd"
                                            d="M0 7.5a7.5 7.5 0 1 1 15 0a7.5 7.5 0 0 1-15 0m10.147 3.354L7.5 8.207l-2.646 2.647l-.708-.707L6.793 7.5L4.146 4.854l.708-.708L7.5 6.793l2.646-2.647l.708.708L8.207 7.5l2.647 2.646z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>No se encontró información para el CT proporcionado.</span>
                                </div>
                            </div>
                        @else
                            <h1 class="text-center text-3xl w-full" style="color: white;">LECTURAS / SEÑAL PLC</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                            {{-- CONTENEDOR CUERPO --}}
                            @foreach ($ct_info as $ct)
                                @if ($ct->id_ct == $id_ct)
                                    <div class="container ">
                                        {{-- PRIMERA FILA --}}
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6 ">
                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white  mb-3 h-full w-full"
                                                    style="
                                                   background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <!-- Contenido de S1 -->
                                                    <div class="table-responsive "
                                                        style="display: flex; justify-content: center;">
                                                        {{-- <div class="overflow-x-auto"> --}}
                                                        <!-- Contenido de S1 -->
                                                        @if (!empty($resultadosQ6) && isset($resultadosQ6[0]))
                                                            <div class="p-0 #205E86 text-white rounded-lg shadow-xl ">
                                                                <?php
                                                                $fecha = $resultadosQ6[0]->fec_lectura;
                                                                
                                                                // Formatear la fecha
                                                                $fecha_formateada = date('d/m/Y', strtotime($fecha));
                                                                
                                                                // Imprimir la fecha formateada
                                                                echo '<h1 class="text-center text-2xl w-full" style="color: white;">LECTURAS AL ' . $fecha_formateada . '</h1>';
                                                                ?>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                                <!-- Cuadrado para Número de Cups -->
                                                                <div
                                                                    class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                    <h2 class="text-2xl text-center font-normal mt-4">Nº de
                                                                        cups
                                                                    </h2>
                                                                    <p class="mt-0 text-2xl  text-center"
                                                                        style="color:rgb(88,226,194);">
                                                                        {{ count($resultadosQ2) > 0 && !empty($resultadosQ2[0]->nro_cups) ? number_format($resultadosQ2[0]->nro_cups, 0, '.', '.') : 'No hay datos' }}
                                                                    </p>
                                                                </div>
                                                                {{-- Cuadrados --}}
                                                                <div
                                                                    class="flex flex-row items-center m-6 lg:mt-22 sm:mt-4 md:mt-4 ">
                                                                    {{-- Primer cuadro --}}
                                                                    <div class="flex flex-col items-center m-2 mb-4 ">
                                                                        <h2
                                                                            class="text-sm text-center font-normal mb-0">
                                                                            S02</h2>
                                                                        <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                                            style="background: linear-gradient(135deg, rgba(88,226,194), rgb(55, 139, 119));">
                                                                            <p class="text-2xl font-bold text-white">
                                                                                {{ !empty($resultadosQ6[0]->lect_s02) ? $resultadosQ6[0]->lect_s02 : '0' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Segundo cuadro --}}
                                                                    <div class="flex flex-col items-center m-2 mb-4">
                                                                        <h3
                                                                            class="text-sm text-center font-normal mb-0">
                                                                            S04</h3>
                                                                        <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                                            style="background: linear-gradient(135deg,rgba(88,226,194), rgb(55, 139, 119));">
                                                                            <p class="text-2xl font-bold text-white">
                                                                                {{ !empty($resultadosQ6[0]->lect_s04) ? $resultadosQ6[0]->lect_s04 : '0' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Tercer cuadro --}}
                                                                    <div class="flex flex-col items-center m-2 mb-4">
                                                                        <h3
                                                                            class="text-sm text-center font-normal mb-0">
                                                                            S05</h3>
                                                                        <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                                            style="background: linear-gradient(135deg, rgba(88,226,194), rgb(55, 139, 119));">
                                                                            <p class="text-2xl font-bold text-white">
                                                                                {{ !empty($resultadosQ6[0]->lect_s05) ? $resultadosQ6[0]->lect_s05 : '0' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

















                                                            </div>
                                                        @else
                                                            <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Lecturas
                                                                    hoy</h2>
                                                                <p class="mt-0 text-xl font-bold text-center"
                                                                    style="color:rgb(88,226,194)">No hay datos</p>
                                                            </div>
                                                        @endif
                                                        {{-- </div> --}}
                                                    </div>
































                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            {{-- S2 GRAFICOS --}}
                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white  mb-3 h-full"
                                                    style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <!-- Contenido de S2 -->
                                                    <div class="p-0 #205E86 text-white rounded-lg shadow-xl ">
                                                        <h1 class="text-center text-2xl w-full" style="color: white;">
                                                            CURVAS HORARIAS
                                                        </h1>
                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                        </div>
                                                        <h2 class="text-center text-1xl mt-2 mb-2"
                                                            style="color: white;">
                                                            Lecturas últimos 7 días</h2>
                                                        <div class="table-responsive w-full"
                                                            style="display: flex; justify-content: center;">
















                                                            @if (count($resultadosQ22) > 0 && !empty($resultadosQ22[0]->lect_s02))
                                                                {{-- GRÁFICO DE lect_s02 --}}
                                                                <div class="grafico-wrapper"
                                                                    style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
















                                                                    <canvas id="graficoBarraslect_s02"
                                                                        class="w-full"></canvas>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                                    <p class="mt-2 text-xl font-bold text-center"
                                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        {{-- SCRIPT PARA EL GRÁFICO DE lect_s02 --}}
                                                        <script>
                                                            var labels_lect_s02 = [];
                                                            var values_lect_s02 = [];

                                                            @foreach ($resultadosQ22 as $resultado)
                                                                // Agregar la fecha en formato dd-mm-yy
                                                                labels_lect_s02.push('{{ date('d-m-y', strtotime($resultado->fec_lectura)) }}');
                                                                // Agregar el valor de energía formateado en kWh
                                                                values_lect_s02.push({{ $resultado->lect_s02 }});
                                                            @endforeach

                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var labels = labels_lect_s02;
                                                                var data = [{
                                                                    label: 'lect_s02',
                                                                    backgroundColor: function(context) {
                                                                        var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                        gradient.addColorStop(0,
                                                                        'rgba(88, 226, 194, 0.9)'); // Color inicial con opacidad 0.9
                                                                        gradient.addColorStop(0.3,
                                                                        'rgba(27,32,38, 0.5)'); // Nuevo color en la mitad del gradiente
                                                                        gradient.addColorStop(1,
                                                                        'rgba(27,32,38, 0)'); // Color final con opacidad 0 (transparente)
                                                                        return gradient;
                                                                    },
                                                                    borderColor: 'rgba(88, 226, 194, 0.9)',
                                                                    borderWidth: 1,
                                                                    data: values_lect_s02
                                                                }];

                                                                var maxValue = Math.max(...values_lect_s02) * 1.1; // Incrementa el valor máximo en un 10%

                                                                var ctx = document.getElementById('graficoBarraslect_s02').getContext('2d');
                                                                var myChart = new Chart(ctx, {
                                                                    type: 'bar',
                                                                    data: {
                                                                        labels: labels_lect_s02,
                                                                        datasets: data
                                                                    },
                                                                    options: {
                                                                        responsive: true,
                                                                        maintainAspectRatio: false,
                                                                        scales: {
                                                                            x: {
                                                                                grid: {
                                                                                    color: 'rgba(0, 0, 0, 0)' // Color transparente para desaparecer la rejilla en el eje x
                                                                                },
                                                                                ticks: {
                                                                                    color: 'white', // Color blanco para las etiquetas del eje x
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
                                                                                    stepSize: 100,
                                                                                    color: 'white', // Color blanco para las etiquetas del eje y
                                                                                    callback: function(value, index, values) {
                                                                                        return value.toFixed(0);
                                                                                    },
                                                                                    font: {
                                                                                        family: 'Didact Gothic', // Tipo de letra
                                                                                        weight: 'normal' // Peso de la fuente
                                                                                    }
                                                                                },
                                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje y
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
                                                                                anchor: 'end',
                                                                                align: 'top',
                                                                                formatter: function(value, context) {
                                                                                    return value;
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    plugins: [ChartDataLabels]
                                                                });
                                                            });
                                                        </script>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white  mb-3 h-full"
                                                    style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        CIERRES
                                                        MENSUALES
                                                    </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    {{-- LECT S04 --}}
                                                    <h2 class="text-center text-1xl mt-2 mb-2" style="color: white;">
                                                        Lecturas últimos 7 días</h2>
                                                    <div class="table-responsive w-full"
                                                        style="display: flex; justify-content: center;">
















                                                        @if (count($resultadosQ22) > 0)
                                                            {{-- GRÁFICO DE lect_s04 --}}
                                                            <div class="grafico-wrapper"
                                                                style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
















                                                                <canvas id="graficoBarraslect_s04"
                                                                    class="w-full"></canvas>
                                                            </div>
                                                        @else
                                                            <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                                <p class="mt-2 text-xl font-bold text-center"
                                                                    style="color:rgb(88,226,194)">No hay datos</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    {{-- SCRIPT PARA EL GRÁFICO DE lect_s04 --}}
                                                    <script>
                                                        var labels_lect_s04 = [];
                                                        var values_lect_s04 = [];
                                                        @foreach ($resultadosQ22 as $resultado)
                                                            // Agregar la fecha en formato dd-mm-yy
                                                            labels_lect_s04.push('{{ date('d-m-y', strtotime($resultado->fec_lectura)) }}');
                                                            // Agregar el valor de energía formateado en kWh
                                                            values_lect_s04.push({{ $resultado->lect_s04 }});
                                                        @endforeach
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            var labels = labels_lect_s04;
                                                            var data = [{
                                                                label: 'lect_s04',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(88, 226, 194, 0.9)'); // Color inicial con opacidad 0.9
                                                                    gradient.addColorStop(0.3,
                                                                        'rgba(27,32,38, 0.5)'); // Nuevo color en la mitad del gradiente
                                                                    gradient.addColorStop(1,
                                                                        'rgba(27,32,38, 0)'); // Color final con opacidad 0 (transparente)
                                                                    return gradient;
                                                                },
                                                                borderColor: 'rgba(88, 226, 194, 0.9)',
                                                                borderWidth: 1,
                                                                data: values_lect_s04
                                                            }];
                                                            var ctx = document.getElementById('graficoBarraslect_s04').getContext('2d');
                                                            var myChart = new Chart(ctx, {
                                                                type: 'bar',
                                                                data: {
                                                                    labels: labels_lect_s04,
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
                                                                                stepSize: 100,
                                                                                color: 'white', // Color blanco para las etiquetas del eje y
                                                                                callback: function(value, index, values) {
                                                                                    return value.toFixed(0);
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
                                                                            anchor: 'end',
                                                                            align: 'top',
                                                                            formatter: function(value, context) {
                                                                                return value;
                                                                            }
                                                                        }
                                                                    }
                                                                },
                                                                plugins: [ChartDataLabels]
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white  mb-3 h-full"
                                                    style="
                                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        CIERRES DIARIOS
                                                    </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <div class="col-span-1 md:col-span-1">
                                                        {{-- LECT S05 --}}
                                                        <h2 class="text-center text-1xl mt-2 mb-2"
                                                            style="color: white;">
                                                            Lecturas últimos 7 días</h2>
                                                        <div class="table-responsive w-full"
                                                            style="display: flex; justify-content: center;">
















                                                            @if (count($resultadosQ22) > 0 && !empty($resultadosQ22[0]->lect_s05))
                                                                {{-- GRÁFICO DE lect_s05 --}}
                                                                <div class="grafico-wrapper"
                                                                    style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
















                                                                    <canvas id="graficoBarraslect_s05"
                                                                        class="w-full"></canvas>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                                    <p class="mt-2 text-xl font-bold text-center"
                                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        {{-- SCRIPT PARA EL GRÁFICO DE lect_s05 --}}
                                                        <script>
                                                            var labels_lect_s05 = [];
                                                            var values_lect_s05 = [];

                                                            @foreach ($resultadosQ22 as $resultado)
                                                                // Agregar la fecha en formato dd-mm-yy
                                                                labels_lect_s05.push('{{ date('d-m-y', strtotime($resultado->fec_lectura)) }}');
                                                                // Agregar el valor de energía formateado en kWh
                                                                values_lect_s05.push({{ $resultado->lect_s05 }});
                                                            @endforeach

                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var labels = labels_lect_s05;
                                                                var data = [{
                                                                    label: 'lect_s05',
                                                                    backgroundColor: function(context) {
                                                                        var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                        gradient.addColorStop(0,
                                                                        'rgba(88, 226, 194, 0.9)'); // Color inicial con opacidad 0.9
                                                                        gradient.addColorStop(0.3,
                                                                        'rgba(27,32,38, 0.5)'); // Nuevo color en la mitad del gradiente
                                                                        gradient.addColorStop(1,
                                                                        'rgba(27,32,38, 0)'); // Color final con opacidad 0 (transparente)
                                                                        return gradient;
                                                                    },
                                                                    borderColor: 'rgba(88, 226, 194, 0.9)',
                                                                    borderWidth: 1,
                                                                    data: values_lect_s05
                                                                }];

                                                                var maxValue = Math.max(...values_lect_s05) * 1.1; // Incrementa el valor máximo en un 10%

                                                                var ctx = document.getElementById('graficoBarraslect_s05').getContext('2d');
                                                                var myChart = new Chart(ctx, {
                                                                    type: 'bar',
                                                                    data: {
                                                                        labels: labels_lect_s05,
                                                                        datasets: data
                                                                    },
                                                                    options: {
                                                                        responsive: true,
                                                                        maintainAspectRatio: false,
                                                                        scales: {
                                                                            x: {
                                                                                grid: {
                                                                                    color: 'rgba(0, 0, 0, 0)' // Color transparente para desaparecer la rejilla en el eje x
                                                                                },
                                                                                ticks: {
                                                                                    color: 'white', // Color blanco para las etiquetas del eje x
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
                                                                                    stepSize: 100,
                                                                                    color: 'white', // Color blanco para las etiquetas del eje y
                                                                                    callback: function(value, index, values) {
                                                                                        return value.toFixed(0);
                                                                                    },
                                                                                    font: {
                                                                                        family: 'Didact Gothic', // Tipo de letra
                                                                                        weight: 'normal' // Peso de la fuente
                                                                                    }
                                                                                },
                                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje y
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
                                                                                anchor: 'end',
                                                                                align: 'top',
                                                                                formatter: function(value, context) {
                                                                                    return value;
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    plugins: [ChartDataLabels]
                                                                });
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- SEGUNDA FILA --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            {{-- Gráfico de 48 horas --}}
                                            <div class="card text-white  mb-3 h-full"
                                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl w-full" style="color: white;">
                                                    CONECTIVIDAD
                                                    ÚLTIMAS 48
                                                    HORAS</h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                @if (count($resultadosQ14) > 0 && !empty($resultadosQ14[0]->por_conta))
                                                    <div class="table-responsive w-full"
                                                        style="display: flex; justify-content: center;">
















                                                        <div class="grafico-wrapper"
                                                            style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
















                                                            <canvas id="graficoLinea48horas" class="w-full"></canvas>
                                                        </div>
                                                    </div>
                                                    {{-- SCRIPTS PARA EL GRÁFICO 48 horas --}}
                                                    <script>
                                                        var datasets = [];
                                                        var colors = ['rgb(247,229,59)', 'rgb(88,226,194)', 'rgb(171,38,194)'];
                                                        var colorIndex = 0;

                                                        @foreach ($resultadosQ14 as $resultado)
                                                            var fechaISO = '{{ $resultado->fec_estadistica }}T{{ substr($resultado->hor_estadistica, 0, 5) }}:00';
                                                            var fecha_formateada = '{{ date('d-m-Y', strtotime($resultado->fec_estadistica)) }}';

                                                            var existingDataset = datasets.find(dataset => dataset.label === fecha_formateada);

                                                            if (existingDataset) {
                                                                existingDataset.data.push({
                                                                    x: fechaISO,
                                                                    y: {{ $resultado->por_conta }}
                                                                });
                                                            } else {
                                                                datasets.push({
                                                                    label: fecha_formateada,
                                                                    data: [{
                                                                        x: fechaISO,
                                                                        y: {{ $resultado->por_conta }}
                                                                    }],
                                                                    borderColor: colors[colorIndex % colors.length],
                                                                    backgroundColor: colors[colorIndex % colors.length],
                                                                    borderWidth: 2,
                                                                    pointRadius: 4,
                                                                    fill: false,
                                                                    tension: 0.5
                                                                });
                                                                colorIndex++;
                                                            }
                                                        @endforeach

                                                        var ctx = document.getElementById('graficoLinea48horas').getContext('2d');
                                                        var myChartLine48horas = new Chart(ctx, {
                                                            type: 'line',
                                                            data: {
                                                                datasets: datasets
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
                                                                                return tooltipItems[0].label;
                                                                            },
                                                                            label: function(context) {
                                                                                return context.parsed.y + ' %';
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
                                                                        type: 'time',
                                                                        time: {
                                                                            unit: 'hour',
                                                                            displayFormats: {
                                                                                hour: 'dd-MM HH:mm'
                                                                            },
                                                                            tooltipFormat: 'dd-MM-yyyy HH:mm'
                                                                        },
                                                                        grid: {
                                                                            color: '#666'
                                                                        },
                                                                        ticks: {
                                                                            color: '#FFFFFF',
                                                                            font: {
                                                                                family: 'Didact Gothic'
                                                                            }
                                                                        }
                                                                    },
                                                                    y: {
                                                                        beginAtZero: true,
                                                                        min: 0,
                                                                        max: 100,
                                                                        grid: {
                                                                            color: '#666'
                                                                        },
                                                                        ticks: {
                                                                            color: '#FFFFFF',
                                                                            font: {
                                                                                family: 'Didact Gothic'
                                                                            },
                                                                            callback: function(value) {
                                                                                return value + ' %';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        });
                                                    </script>

                                                    <div id="fechaGrafico2" style="color: white; text-align: center;">
                                                    </div>
                                                @else
                                                    <div class="p-4 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-lg text-center font-normal">
                                                            Conectividad últimas 48 horas
                                                        </h2>
                                                        <p class="mt-2 text-xl  text-center"
                                                            style="color:rgb(88,226,194)">No
                                                            hay datos</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- TERCERA FILA --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
































                                            {{-- S3-1 --}}
                                            {{-- <div class="col-span-1 md:col-span-4 lg:col-span-1"> --}}
                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white mb-3 h-full"
                                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        CONTADORES NO LEÍDOS
                                                    </h1>
                                                    <h2 class="text-center text-1xl w-full mb-2"
                                                        style="color: white;">
                                                        (Últimos 7 días)
                                                    </h2>
                                                    <div
                                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62), rgb(27,32,38)) 1;">
                                                    </div>
                                                    <!-- Cuadrado para Contadores sin Lecturas últimos 7 días -->
                                                    <div class="flex items-center justify-center p-0 #205E86 text-white rounded-lg shadow-xl"
                                                        style="height: 100%;">
                                                        <p class="text-5xl text-center" style="color:rgb(248,73,90);">
                                                            @if (!empty($resultadosQ3[0]->contadores_sin_lectura_7_dias))
                                                                {{ $resultadosQ3[0]->contadores_sin_lectura_7_dias }}
                                                            @else
                                                                <span class="text-5xl">0</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- </div> S3-2 --}}
                                            <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                                <div class="card text-white  mb-3 h-full"
                                                    style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        CONTADORES NO LEÍDOS </h1>
                                                    <h2 class="text-center text-1xl w-full mb-2"
                                                        style="color: white;">
                                                        (Últimos 7 días)</h2>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                             border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <!-- Cuadrado para Contadores no leídos -->
                                                    @if (is_array($resultadosQ21) && count($resultadosQ21) > 0)
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableContNoleido"
                                                                class="w-full text-white text-center">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">#</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">CUPS</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">Nombre</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">Dirección
                                                                            CUPS
                                                                        </th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">CT</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($resultadosQ21 as $resultado)
                                                                        <tr class="highlight-row ">
                                                                            <td class="py-2">{{ $loop->iteration }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->nom_cups) ? $resultado->nom_cups : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->id_ct) ? $resultado->id_ct : 'No hay datos' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl  text-center"
                                                                style="color:rgb(88,226,194)">No hay datos</p>
                                                        </div>
                                                    @endif
                                                    <!-- Contenedor del botón de descarga -->
                                                    <div class="text-right mt-4">
                                                        <input type="button"
                                                            onclick="tableToExcel('testTableContNoleido', 'W3C Example Table')"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- CUARTA FILA --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
































                                            {{-- S4-1 --}}
















                                            <div class="col-span-3 md:col-span-1">
                                                <div class="card text-white mb-3 h-full"
                                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        CONTADORES BAJA DISPONIBILIDAD
                                                    </h1>
                                                    <h2 class="text-center text-1xl w-full mb-2"
                                                        style="color: white;">
                                                        (Últimos 7 días)
                                                    </h2>
                                                    <div
                                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62), rgb(27,32,38)) 1;">
                                                    </div>
                                                    <!-- Cuadrado para Contadores sin Lecturas últimos 7 días -->
                                                    <div class="p-0 #205E86 text-white rounded-lg shadow-xl flex items-center justify-center"
                                                        style="height: 100%;">
                                                        <p class="text-5xl text-center" style="color:rgb(248,73,90);">
                                                            @if (!empty($resultadosQ7[0]->disponibilidad_menos_30))
                                                                {{ $resultadosQ7[0]->disponibilidad_menos_30 }}
                                                            @else
                                                                <span class="text-5xl">0</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>


                                            {{-- S4-2 --}}
                                            <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                                <div class="card text-white mb-3 h-full"
                                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                                        CONTADORES CON BAJA DISPONIBILIDAD </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <!-- Cuadrado para Contadores con baja disponibilidad -->
                                                    @php
                                                        $hasData = false;
                                                        foreach ($resultadosQ20 as $resultado) {
                                                            if (
                                                                !empty($resultado->id_cups) ||
                                                                !empty($resultado->nom_cups) ||
                                                                !empty($resultado->dir_cups) ||
                                                                !empty($resultado->id_ct) ||
                                                                !empty($resultado->por_minutos_contador)
                                                            ) {
                                                                $hasData = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @if ($hasData)
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableBajaDisponibilidad"
                                                                class="w-full text-white text-center">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">#
                                                                        </th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">CUPS
                                                                        </th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">Nombre
                                                                        </th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">Dirección
                                                                            CUPS
                                                                        </th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">CT
                                                                        </th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">%
                                                                            Disponibilidad
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($resultadosQ20 as $resultado)
                                                                        <tr class="highlight-row">
                                                                            <td class="py-2">{{ $loop->iteration }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->nom_cups) ? $resultado->nom_cups : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->id_ct) ? $resultado->id_ct : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->por_minutos_contador) ? $resultado->por_minutos_contador : '0' }}%
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl text-center"
                                                                style="color:rgb(88,226,194)">No hay datos</p>
                                                        </div>
                                                    @endif

                                                    <!-- Contenedor del botón de descarga -->
                                                    <div class="text-right mt-4">
                                                        <input type="button"
                                                            onclick="tableToExcel('testTableBajaDisponibilidad', 'W3C Example Table')"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
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
