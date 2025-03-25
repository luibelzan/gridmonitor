<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    {{-- MAPA --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- BOOTSTRAP --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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
                        <a href="{{ route('reportesinventario') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Inventario</a>
                        <a href="{{ route('reportescurvashorarias') }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194)">Control</a>
                        <a href="{{ route('reporteseventos') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Eventos</a>
                        <span class="nav-indicator"></span>
                    </nav>
                    <h1 class="text-center text-3xl w-full" style="color: white;">REPORTES DE CONTROL</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                                border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>
                    {{-- CONTENEDOR CUERPO --}}
                    <div class="container ">














                        {{-- PRIMERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">


                            <div class="col-span-3 md:col-span-1 lg:col-span-1">
                                <div class="card text-white  mb-3 h-full"
                                    style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">



                                    <h1 class="text-center text-2xl w-full" style="color: white;">


                                        REPORTES CONSUMO POR HORA </h1>
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
                                        @endif</h2>


                                    <div
                                        style="border-bottom: 3px solid transparent;
                                             border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-2">
                                        {{-- FILTRO FECHAS --}}
                                        <form action="{{ route('reportescurvashorarias') }}"
                                            method="GET" class="flex flex-wrap items-center justify-start gap-2 mt-6 ml-6">
                                            {{-- FILTRO FECHAS --}}
                                            <div class="form-group flex items-center">
                                                <label for="fecha_inicio" class="text-white mr-2">Fecha de
                                                    inicio:</label>
                                                <input type="date" id="fecha_inicio" name="fecha_inicio"
                                                    class="border border-gray-400 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                            </div>
                                            <div class="form-group flex items-center">
                                                <label for="fecha_fin" class="text-white mr-2">Fecha de
                                                    fin:</label>
                                                <input type="date" id="fecha_fin" name="fecha_fin"
                                                    class="border border-slate-900 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                            </div> {{-- BUSCADOR --}}
                                            <div class="form-group">
                                                
                                            </div> <button type="submit" class="btn btn-outline-info mb-3 text-white"
                                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Buscar</button>
                                        </form>
                                    </div>


                                    <!-- Cuadrado para Contadores no leídos -->
                                    @if (is_array($resultadosQ58) && count($resultadosQ58) > 0)
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                            <table id="testTableCurvashorarias" class="w-full text-white text-center">
                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                    <tr>
                                                        <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">#</th>
                                                        <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">CUPS</th>
                                                        <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Contador</th>
                                                        <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Nombre</th>
                                                        <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Dirección CUPS</th>
                                                        <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">CT</th>
                                                             <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Energía Importada (kwh+)</th>
                                                             <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Energía Exportada (kwh-)</th>
                                                             <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Nº de horas leídas</th>
                                                             <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Nº de horas sin consumo</th>
                                                            <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Fecha Inicio</th>
                                                            <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Fecha Fin</th>
                                                            <th class="mt-0 text-lg font-bold text-center"
                                                            style="color:rgb(88,226,194)">Autoconsumo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($resultadosQ58 as $index => $resultado)
                                                        <tr class="highlight-row">
                                                            <td class="py-2">{{ $loop->iteration }}</td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->nom_cups) ? $resultado->nom_cups : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                            </td>
                                                             <td class="py-2">
                                                                {{ !empty($resultado->total_curva_imp) ? $resultado->total_curva_imp : '0' }}
                                                            </td>
                                                             <td class="py-2">
                                                                {{ !empty($resultado->total_curva_exp) ? $resultado->total_curva_exp : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->curvas_leidas) ? $resultado->curvas_leidas : '0' }}
                                                            </td>
                                                             <td class="py-2">
                                                                {{ !empty($resultado->curvas_sin_consumo) ? $resultado->curvas_sin_consumo : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->fec_inicio) ? $resultado->fec_inicio : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->fec_fin) ? $resultado->fec_fin : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->ind_autoconsumo) ? $resultado->ind_autoconsumo : 'No hay datos' }}
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
                                            onclick="tableToExcel('testTableCurvashorarias', 'W3C Example Table')"
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
</body>




