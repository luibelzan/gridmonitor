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
        /* Encabezado de las tablas fijo */
        thead th {
            position: sticky;
            top: -24px;
            background-color: rgb(27, 32, 38);
            z-index: 1;

        }

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












    <title>Inicio PF</title>
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




                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14 ">
                    {{-- CUERPO AQUI --}}
                    <h1 class="text-center text-3xl w-full" style="color: white;">DASHBOARD</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                       border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>


                    <div class="container ">
                        {{-- PRIMERA FILA --}}
                        {{-- 3 columnas --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
                            {{-- Cuadro 1 --}}
                            <div class="card text-white mb-2 col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-xl" style="color: white;">CONTADORES</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                        @if (isset($resultadosQ13dashboard) &&
                                                count($resultadosQ13dashboard) > 0 &&
                                                isset($resultadosQ13dashboard[0]->num_contadores))
                                            <p class="mt-2  mb-2 text-5xl text-center" style="color:rgb(26, 172, 10);">
                                                {{ $resultadosQ13dashboard[0]->num_contadores }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-sm text-center" style="color:rgb(88,226,194);">No hay
                                                datos
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            {{-- Cuadro 2 --}}
                            <div class="card text-white mb-2 col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-xl" style="color: white;">INTERRUPCIONES DE SERVICIO</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                        @if (isset($resultadosQ14dashboard) && count($resultadosQ14dashboard) > 0 && isset($resultadosQ14dashboard[0]->cortes))
                                            <p class="mt-2  mb-2 text-5xl text-center" style="color:rgb(214, 34, 24);">
                                                {{ number_format($resultadosQ14dashboard[0]->cortes, 0, '.', '.') }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-sm text-center" style="color:rgb(88,226,194);">No hay
                                                datos
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            {{-- Cuadro 3 --}}
                            <div class="card text-white mb-2 col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-xl" style="color: white;">CURVAS HORARIAS LEÍDAS</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl ">
                                        @if (isset($resultadosQ15dashboard) && count($resultadosQ15dashboard) > 0 && isset($resultadosQ15dashboard[0]->leidas))
                                            <p class="mt-2  mb-2 text-5xl text-center" style="color:rgb(88,226,194);">
                                                {{ number_format($resultadosQ15dashboard[0]->leidas, 0, '.', '.') }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-sm text-center" style="color:rgb(88,226,194);">No hay
                                                datos
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            {{-- Cuadro 4 --}}
                            <div class="card text-white mb-2 col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-xl" style="color: white;">CURVAS HORARIAS INVÁLIDAS</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl ">
                                        @if (isset($resultadosQ16dashboard) &&
                                                count($resultadosQ16dashboard) > 0 &&
                                                isset($resultadosQ16dashboard[0]->invalidas))
                                            <p class="mt-2  mb-2 text-5xl text-center" style="color:rgb(237, 233, 0);">
                                                {{ number_format($resultadosQ16dashboard[0]->invalidas, 0, '.', '.') }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-sm text-center" style="color:rgb(88,226,194);">No hay
                                                datos
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            {{-- Cuadro 5 --}}
                            <div class="card text-white mb-2 col-span-1"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-xl" style="color: white;">EXCESOS DE POTENCIA</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="p-2  #205E86 text-white rounded-lg shadow-xl ">
                                        @if (isset($resultadosQ17dashboard) &&
                                                count($resultadosQ17dashboard) > 0 &&
                                                isset($resultadosQ17dashboard[0]->excesos_potencia))
                                            <p class="mt-2 mb-4 text-5xl text-center" style="color:rgb(88,226,194);">
                                                {{ number_format($resultadosQ17dashboard[0]->excesos_potencia, 0, '.', '.') }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-sm text-center" style="color:rgb(88,226,194);">No hay
                                                datos
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SEGUNDA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">


                            <div class="card text-white  mb-2 col-span-1"
                                style="
                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl w-full" style="color: white;">
                                    PUNTOS DE MEDIDA</h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                     border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <!-- Cuadrado para Contadores no leídos -->
                                @if (is_array($resultadosQ18dashboard) && count($resultadosQ18dashboard) > 0)
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                        <table id="testTableDashboardPf" class="w-full text-white text-center">
                                            <thead style="border-bottom: 1px solid #ffffff;">
                                                <tr>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">#</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Contador</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">CUPS</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Descripción</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Clave</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Intensidad <br> trafos</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Tensión <br> trafos</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Tipo punto <br> de medida</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Tipo de <br> conexión</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Último Cierre</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Última Curva</th>
                                                    <th class="mt-0 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">Último Evento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resultadosQ18dashboard as $index => $resultado)
                                                    <tr class="highlight-row">
                                                        <td class="py-2">{{ $loop->iteration }}</td>
                                                        <td class="py-2">
                                                            @if (!empty($resultado->Contador))
                                                                <a href="informacionpf?id_cnt={{ $resultado->Contador }}"
                                                                    target="_blank"
                                                                    style="color:rgb(0, 0, 238)">{{ $resultado->Contador }}</a>
                                                            @else
                                                                No hay datos
                                                            @endif
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->CUPS) ? $resultado->CUPS : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->Descripcion) ? $resultado->Descripcion : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->Clave) ? $resultado->Clave : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->Trafos_Intensidad) ? $resultado->Trafos_Intensidad : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->Trafos_Tension) ? $resultado->Trafos_Tension : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->Tipo_Punto_Medida) ? $resultado->Tipo_Punto_Medida : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->Tipo_Conexion) ? $resultado->Tipo_Conexion : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->fecha_ultima_cierre) ? $resultado->fecha_ultima_cierre : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->fecha_ultima_curva) ? $resultado->fecha_ultima_curva : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2">
                                                            {{ !empty($resultado->fecha_ultimo_evento) ? $resultado->fecha_ultimo_evento : 'No hay datos' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                        <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">No hay
                                            datos</p>
                                    </div>
                                @endif
                                <!-- Contenedor del botón de descarga -->
                                <div class="text-right mt-4">
                                    <input type="button"
                                        onclick="tableToExcel('testTableDashboardPf', 'W3C Example Table')"
                                        style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
