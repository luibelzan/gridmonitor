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
        /* POPUP */
        .custom-popup {
            /* border-radius: 5px;
            padding: 10px; */
            font-family: 'Didact Gothic';
        }








        .custom-popup h3 {
            color: #007bff;
            margin-bottom: 5px;
            font-family: 'Didact Gothic';
        }








        .custom-popup ul {
            list-style: none;
            padding: 0;
            font-family: 'Didact Gothic';
        }








        .custom-popup ul li {
            margin-bottom: 5px;
            font-family: 'Didact Gothic';
        }








        /* Estilo para el enlace cuando el mouse está encima */
        #popup-map .nav-link:hover {
            color: rgb(88, 226, 194);
        }








        /* ESTILO PARA POPUP MAPA */
        #popup-map .popup-content {
            width: 100%;
        }








        #popup-map .nav-tabs {
            display: flex;
            justify-content: space-evenly;
            border-bottom: 1px solid #ddd;
            flex-wrap: nowrap;
        }








        #popup-map .nav-item {
            flex: 1;
        }








        #popup-map .nav-link {
            text-align: center;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 3px 3px 0 0;
            white-space: nowrap;
            display: block;
        }








        #popup-map .nav-link.active {
            border-color: #ddd #ddd transparent;
            background-color: #f8f9fa;
        }








        #popup-map .tab-content .tab-pane {
            padding: 15px;
            border: 1px solid #ddd;
            border-top: none;
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








        #barraNavegacion {
            display: inline-flex;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            background-color: rgb(27, 32, 38);
            padding: 0 20px;
            border-radius: 40px;
            margin: auto;
        }








        #barraNavegacion .nav-item {
            color: #ffffff;
            padding: 12px;
            text-decoration: none;
            transition: .3s;
            margin: 0 6px;
            z-index: 1;
            font-weight: 500;
            position: relative;
        }








        #barraNavegacion .nav-item:before {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: rgb(88, 226, 194);
            border-radius: 8px 8px 0 0;
            opacity: 0;
            transition: .3s;
        }








        #barraNavegacion .nav-item:not(.is-active):hover:before {
            opacity: 1;
            bottom: 0;
        }








        #barraNavegacion .nav-item.is-active:before {
            background-color: rgb(88, 226, 194);
            opacity: 1;
            bottom: 0;
        }








        #barraNavegacion .nav-item:not(.is-active):hover {
            color: rgb(88, 226, 194);
        }








        #barraNavegacion .nav-indicator {
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
            #barraNavegacion .nav {
                flex-wrap: wrap;
                padding: 0;
                border-radius: 2;
                box-shadow: none;
            }








            #barraNavegacion .nav-item {
                flex: 1 0 40%;
                padding: 10px 0;
                text-align: center;
            }








            #barraNavegacion .nav-indicator {
                display: none;
            }
        }
    </style>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    function exportarArchivo(formato) {
        var url = "{{ route('exportar.reportes.actualizaciones') }}?";

        // Añadir el formato (excel o csv)
        url += "format=" + formato;

        // Redirigir al servidor con la URL construida
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


<script>
        document.addEventListener("DOMContentLoaded", function () {
        var exportButton = document.getElementById('exportarExcel2');
        
        if (exportButton) {
            exportButton.addEventListener('click', function () {

                // Construir la URL con todos los parámetros
                var url = "{{ route('exportar.reportes.inventario') }}?";

                // Redirigir al servidor con la URL construida
                window.location.href = url;
            });
        } else {
            console.error("El botón exportarExcel no existe en el DOM.");
        }
    });
    </script>


    <title>Reportes CT</title>
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
            <div class="lg:ml-14 p-2 mt-0 w-full">
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}
                    {{-- Obtener el id_ct almacenado en la sesión --}}
                    @php
                        $id_ct = session()->get('id_ct');
                    @endphp
                    <nav id="barraNavegacion" class="nav mb-12">
                        <a href="{{ route('reportes') }}" class="nav-item " active-color="rgb(88, 226, 194)">Lecturas /
                            Señal PLC</a>
                        <a href="{{ route('reportescalidad') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Calidad</a>
                        <a href="{{ route('reportesinventario') }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194)">Inventario</a>
                        <a href="{{ route('reportescurvashorarias') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Control</a>
                        <a href="{{ route('reporteseventos') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Eventos</a>
                        <span class="nav-indicator"></span>
                    </nav>
                    <h1 class="text-center text-3xl w-full" style="color: white;">REPORTES INVENTARIO</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                                border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>
                    {{-- CONTENEDOR CUERPO --}}
                    <div class="container ">
































                        {{-- PRIMERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-6">












                            {{-- KPI --}}
















                            {{-- TABLA 1 --}}
                            <div class="col-span-3 md:col-span-1 lg:col-span-2">
                                <div class="card text-white  mb-3 h-full"
                                    style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    <h1 class="text-center text-2xl w-full" style="color: white;">
                                        REPORTE DE ACTUALIZACIONES DE FW </h1>




                                    <div
                                        style="border-bottom: 3px solid transparent;
                                             border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                    </div>
                                    <!-- Cuadrado para Contadores no leídos -->
                                    @if (count($resultadosQ52) > 0)
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                            <table id="testTableReporteActualizaciones"
                                                class="w-full text-white text-center">
                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                    <tr>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">#</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">CUPS</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">CONTADOR</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">FECHA</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">HORA</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">TEXTO ADICIONAL 1</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194)">TEXTO ADICIONAL 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($resultadosQ52 as $index => $resultado)
                                                        <tr class="highlight-row">
                                                            <td class="py-2">{{ $loop->iteration }}</td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->fec_evento) ? $resultado->fec_evento : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->hor_evento) ? $resultado->hor_evento : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->txt_adicionales_1) ? $resultado->txt_adicionales_1 : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->txt_adicionales_2) ? $resultado->txt_adicionales_2 : 'No hay datos' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pagination-container mt-4 flex justify-center items-center">
                                            <div class="pagination">
                                                {{ $resultadosQ52->links() }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                            <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">No hay
                                                datos</p>
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




                                    <div class="col-span-3 md:col-span-1 lg:col-span-1">
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                  border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div class="card text-white   h-full"
                                            style="
                                              background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <h1 class="text-center text-2xl w-full" style="color: white;">
                                                ACTUALIZACIONES TOTALES:
                                                <a class="mt-0 text-3xl" style="color:rgb(248,73,90)">
                                                    @if (is_array($resultadosQ53) && count($resultadosQ53) > 0)




                                                        @foreach ($resultadosQ53 as $index => $resultado)
                                                            {{ !empty($resultado->count) ? $resultado->count : 'No hay datos' }}
                                                        @endforeach
                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl text-center"
                                                                style="color:rgb(88,226,194)">No hay
                                                                datos</p>
                                                        </div>
                                                    @endif
                                                </a>
                                            </h1>
















                                        </div>
                                    </div>
                                </div>
                            </div>








                            {{-- GRAFICO DE BARRAS --}}
                            <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">ACTUALIZACIONES POR MES</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <h2 class="text-center text-1xl mt-2" style="color: white;">Últimos 12
                                        meses</h2>
                                    <div class="table-responsive w-full"
                                        style="display: flex; justify-content: center;">












                                        {{-- GRÁFICO DE CONSUMOS MENSUALES --}}
                                        <div class="grafico-wrapper"
                                            style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                            @if (is_array($resultadosQ54) && count($resultadosQ54) > 0)
                                            <canvas id="graficoBarrasActualizaciones" class="w-full"></canvas>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- SCRIPT PARA EL GRÁFICO DE CONSUMOS MENSUALES --}}
                                    <script>
                                        var labels_fecha = [];
                                        var values_actualizaciones = [];
                                        @foreach ($resultadosQ54 as $resultado)
                                            // Agregar la fecha en formato dd-mm-yy
                                            labels_fecha.push('{{ $resultado->mes }}');
                                            // Agregar el valor de energía formateado en kWh
                                            values_actualizaciones.push({{ $resultado->actualizaciones }});
                                        @endforeach
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var labels = labels_fecha;
                                            var data = [{
                                                label: 'Número de actualizaciones',
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
                                                data: values_actualizaciones
                                            }];
                                            var ctx = document.getElementById('graficoBarrasActualizaciones').getContext('2d');
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
                                                                    return value.toFixed(0) ;
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
                                                                return value ;
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
                        {{-- SEGUNDA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">




































                            {{-- TABLA 2 --}}
                            <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl w-full" style="color: white;">
                                    REPORTE DE MODELO DE CONTADOR </h1>




                                <div
                                    style="border-bottom: 3px solid transparent;
                                         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <!-- Cuadrado para Contadores baja disponibilidad -->
                                @if (count($resultadosQ52) > 0)
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                        <table id="testTableReporteModelo" class="w-full text-white text-center">
                                            <thead style="border-bottom: 1px solid #ffffff;">
                                                <tr>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">#</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">CONTADOR</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">MODELO</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">DLMS</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">PRIME
                                                    </th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">AÑO</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">TIPO CONTADOR
                                                    </th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">COMPANION
                                                    </th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">FABRICANTE
                                                    </th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">FASES
                                                    </th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">TIPO
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resultadosQ55 as $resultado)
                                                    <tr class="highlight-row ">
                                                        <td class="py-2">{{ $loop->iteration }}</td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->mod_cnt) ? $resultado->mod_cnt : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->fw_dlms_cnt) ? $resultado->fw_dlms_cnt : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->fw_prime_cnt) ? $resultado->fw_prime_cnt : 'No hay datos' }}
                                                        </td>


                                                        <td class="py-2">
                                                            {{ !empty($resultado->des_cnt_af) ? $resultado->des_cnt_af : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->des_te) ? $resultado->des_te : '0' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->des_companion) ? $resultado->des_companion : '0' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->nom_fabricante) ? $resultado->nom_fabricante : '0' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->num_fases) ? $resultado->num_fases : '0' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->tipo_cnt) ? $resultado->tipo_cnt : '0' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pagination-container mt-4 flex justify-center items-center">
                                        <div class="pagination">
                                            {{ $resultadosQ55->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                        <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No hay
                                            datos</p>
                                    </div>
                                @endif
                                <!-- Contenedor del botón de descarga -->
                                <div class="text-right mt-4">
                                    <button id="exportarExcel2" style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                    </button>
                                </div>
                            </div>




























                        </div>








                        {{-- TERCERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6 mb-6">




                            {{-- GRAFICO CIRCULAR 1 --}}
                            <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    VERSIÓN DLMS
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">




                                    <div class="p-4 #205E86 text-white rounded-lg shadow-xl mt-10">
                                        @if (is_array($resultadosQ56) && count($resultadosQ56) > 0)
                                        {{-- GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                        <canvas id="graficoCircularVersionDLMS"></canvas>
                                        @endif
                                    </div>
                                    {{-- SCRIPT PARA EL GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                    <script>
                                        var data1 = [];
                                        var total1 = 0;
                                        @foreach ($resultadosQ56 as $resultado)
                                            total1 += {{ $resultado->count }};
                                        @endforeach
                                        @foreach ($resultadosQ56 as $resultado)
                                            @if ($resultado->count != 0)
                                                var porcentaje = ({{ $resultado->count }} / total1) * 100;
                                                data1.push({
                                                    label: '{{ $resultado->des_companion }}: {{ $resultado->count }} ',
                                                    value: {{ $resultado->count }},
                                                    percentage: porcentaje.toFixed(2)
                                                });
                                            @endif
                                        @endforeach
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var ctx = document.getElementById('graficoCircularVersionDLMS').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: data1.map(item => item.label),
                                                    datasets: [{
                                                        label: 'Version DLMS',
                                                        data: data1.map(item => item.value),
                                                        backgroundColor: [
                                                            'rgb(248,73,90)', // Rojo
                                                            'rgb(88,226,194)', // Azul
                                                            'RGB(247 229 59)', // Amarillo
                                                            'rgb(147,195,96)', // Verde
                                                            'rgb(171,38,194)', // Morado
                                                            'rgba(255, 159, 64, 0.9)', // Naranja
                                                            'rgba(204, 0, 204, 0.9)', // Violeta
                                                            'rgba(255, 193, 7, 0.9)', // Naranja amarillento
                                                            'rgba(0, 153, 0, 0.9)', // Verde oscuro
                                                            'rgba(255, 102, 0, 0.9)', // Naranja fuerte
                                                            'rgba(0, 102, 204, 0.9)', // Azul oscuro
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
                                                                    var label = ' ' + data1[context.dataIndex].percentage + '%';
                                                                    return label;
                                                                }
                                                            }
                                                        },
                                                        datalabels: {
                                                            anchor: "outside",
                                                            color: "white",
                                                            font: {
                                                                family: 'Didact Gothic',
                                                                size: "20",
                                                                weight: "bold"
                                                            },
                                                            textStrokeColor: 'black', // Agregar borde negro al texto
                                                            textStrokeWidth: 2, // Ancho del borde del texto
                                                            formatter: (value, ctx) => {
                                                                return data1[ctx.dataIndex].percentage + '%';
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








                            {{-- GRAFICO CIRCULAR 2 --}}
                            <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    FABRICANTE
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
     border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">




                                    <div class="p-4 #205E86 text-white rounded-lg shadow-xl mt-10">
                                        {{-- GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                        <canvas id="graficoCircularFabricante"></canvas>
                                    </div>
                                    {{-- SCRIPT PARA EL GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                    <script>
                                        var data = [];
                                        var total = 0;
                                        @foreach ($resultadosQ57 as $resultado)
                                            total += {{ $resultado->count }};
                                        @endforeach
                                        @foreach ($resultadosQ57 as $resultado)
                                            @if ($resultado->count != 0)
                                                var porcentaje = ({{ $resultado->count }} / total) * 100;
                                                data.push({
                                                    label: '{{ $resultado->nom_fabricante }}: {{ $resultado->count }} ',
                                                    value: {{ $resultado->count }},
                                                    percentage: porcentaje.toFixed(2)
                                                });
                                            @endif
                                        @endforeach
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var ctx = document.getElementById('graficoCircularFabricante').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: data.map(item => item.label),
                                                    datasets: [{
                                                        label: 'Version DLMS',
                                                        data: data.map(item => item.value),
                                                        backgroundColor: [
                                                            'rgb(248,73,90)', // Rojo
                                                            'rgb(88,226,194)', // Azul
                                                            'RGB(247 229 59)', // Amarillo
                                                            'rgb(147,195,96)', // Verde
                                                            'rgb(171,38,194)', // Morado
                                                            'rgba(255, 159, 64, 0.9)', // Naranja
                                                            'rgba(204, 0, 204, 0.9)', // Violeta
                                                            'rgba(255, 193, 7, 0.9)', // Naranja amarillento
                                                            'rgba(0, 153, 0, 0.9)', // Verde oscuro
                                                            'rgba(255, 102, 0, 0.9)', // Naranja fuerte
                                                            'rgba(0, 102, 204, 0.9)', // Azul oscuro
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
                                                                size: "20",
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
                </div>
            </div>
        </div>
    </div>
    </div>
</body>












