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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
































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




        #titulogrande {
            position: sticky;
            top: -24px;
            background-color: rgb(27, 32, 38);
            z-index: 1;








        }




        #titulopeque {
            position: sticky;
            top: 5px;
            background-color: rgb(27, 32, 38);
            z-index: 1;








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
document.addEventListener("DOMContentLoaded", function () {

    function exportarArchivo(formato) {
        var fecInicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecFin = document.querySelector('input[name="fecha_fin"]').value;

        var url = "{{ route('exportar.reportes.calidad') }}?";

        // Añadir los parámetros solo si están presentes
        if (fecInicio) {
            url += "fecha_inicio=" + encodeURIComponent(fecInicio) + "&";
        }
        if (fecFin) {
            url += "fecha_fin=" + encodeURIComponent(fecFin) + "&";
        }

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
        function tableToExcel2(tableID, worksheetName) {
            var table = document.getElementById(tableID);
            var data = "<table border='1'>";


            // Obtener y procesar los encabezados de la tabla
            var headers = table.getElementsByTagName("thead")[0].rows;
            for (var i = 0; i < headers.length; i++) {
                data += "<tr>";
                var cells = headers[i].cells;
                for (var j = 0; j < cells.length; j++) {
                    data += "<th colspan='" + cells[j].colSpan + "' rowspan='" + cells[j].rowSpan + "'>" + cells[j]
                        .innerText + "</th>";
                }
                data += "</tr>";
            }


            // Obtener y procesar los datos de la tabla
            var rows = table.getElementsByTagName("tbody")[0].rows;
            for (var i = 0; i < rows.length; i++) {
                data += "<tr>";
                var cells = rows[i].cells;
                for (var j = 0; j < cells.length; j++) {
                    data += "<td>" + cells[j].innerText + "</td>";
                }
                data += "</tr>";
            }
            data += "</table>";


            // Convertir a formato Excel y descargar
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!-- ... --></head><body>{table}</body></html>';
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)));
            };
            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                });
            };


            var excelData = format(template, {
                worksheet: worksheetName,
                table: data
            });
            var link = document.createElement("a");
            link.href = uri + base64(excelData);
            link.download = worksheetName + ".xls";
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
                        <a href="{{ route('reportescalidad') }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194)">Calidad</a>
                        <a href="{{ route('reportesinventario') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Inventario</a>
                            <a href="{{ route('reportescurvashorarias') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Control</a>
                            <a href="{{ route('reporteseventos') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Eventos</a>
                        <span class="nav-indicator"></span>
                    </nav>
                    <h1 class="text-center text-3xl w-full" style="color: white;">REPORTES CALIDAD</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                                border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>
                    {{-- CONTENEDOR CUERPO --}}
                    <div class="container ">


                        {{-- FILTRO AQUI --}}
                        <form action="{{ route('reportescalidad') }}" method="GET"
                            class="flex flex-col sm:flex-row items-center justify-start space-y-4 sm:space-y-0 space-x-0 sm:space-x-4 mb-4 mt-4 mr-2 ml-4">
                            <div
                                class="form-group flex flex-col sm:flex-row items-center justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                                <div class="flex flex-col sm:flex-row items-center">
                                    <label for="fecha_inicio" class="text-white mr-2">Fecha de
                                        inicio:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                                        class="border border-gray-400 p-2 rounded-lg text-white"
                                        @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                        max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                </div>
                                <div class="flex flex-col sm:flex-row items-center">
                                    <label for="fecha_fin" class="text-white mr-2">Fecha de
                                        fin:</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin"
                                        class="border border-slate-900 p-2 rounded-lg text-white"
                                        @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                        max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-info mb-3 sm:mt-0 text-white"
                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                        </form>
                        {{-- PRIMERA FILA --}}
                        <div class="col-span-3 md:col-span-1">
                            <div class="card text-white mb-3 h-full"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                    <div class="card text-white  mb-3 h-full"
                                        style="
                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl w-full" style="color: white;">
                                            RESUMEN DE EVENTOS DE CALIDAD POR CT
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




















                                        <!-- Cuadrado para Reportes Calidad por CT-->
                                        @if (is_array($resultadosQ38) && count($resultadosQ38) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableRepCalidadCT"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">#</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">CT</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Nº CUPS
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Cortes
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Microcortes</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Subtensiones</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Sobretensiones</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Nº Eventos</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Ratio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($resultadosQ38 as $index => $resultado)
                                                            <tr class="highlight-row">
                                                                <td class="py-2">{{ $loop->iteration }}</td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_cups) ? $resultado->total_cups : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->apagones) ? $resultado->apagones : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->micro_cortes) ? $resultado->micro_cortes : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->sub_voltajes) ? $resultado->sub_voltajes : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->sobrevoltajes) ? $resultado->sobrevoltajes : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->total_eventos) ? $resultado->total_eventos : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->ratio) ? $resultado->ratio : '0' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">No
                                                    hay
                                                    datos</p>
                                            </div>
                                        @endif
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4">
                                            <input type="button"
                                                onclick="tableToExcel('testTableRepCalidadCT', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- SEGUNDA FILA --}}
                        <div class="col-span-3 md:col-span-1">
                            <div class="card text-white mb-3 h-full"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                    <div class="card text-white  mb-3 h-full"
                                        style="
                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl w-full" style="color: white;">
                                            RESUMEN DE CALIDAD POR CUPS
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
                                        </div> <!-- Cuadrado para Reportes Calidad por CUPS-->
                                        @if ($resultadosQ37 instanceof \Illuminate\Pagination\LengthAwarePaginator && $resultadosQ37->count() > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableRepCalidadCUPS"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">#</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">CT</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">CUPS
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Nombre
                                                                CUPS</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Dirección CUPS</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Fecha
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Cortes
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Microcortes</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Subtensiones</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Sobretensiones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($resultadosQ37 as $index => $resultado)
                                                            <tr class="highlight-row">
                                                                <td class="py-2">{{ $loop->iteration }}</td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
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
                                                                    {{ !empty($resultado->fecha) ? $resultado->fecha : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->apagones) ? $resultado->apagones : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->micro_cortes) ? $resultado->micro_cortes : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->sub_voltajes) ? $resultado->sub_voltajes : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->sobrevoltajes) ? $resultado->sobrevoltajes : '0' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="pagination-container mt-4 flex justify-center items-center">
                                                <div class="pagination">
                                                    {{ $resultadosQ37->links() }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">No
                                                    hay
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
                                    </div>
                                </div>
                            </div>
                        </div>
































































                        {{-- TERCERA FILA --}}
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6 ">
                            {{-- CORTES --}}
                            <div id="cortes-container" class="col-span-1 md:col-span-1">
                                <div class="card text-white  mb-3 h-full"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    <!-- Contenido de CORTES -->
                                    <div class="p-0 #205E86 text-white rounded-lg shadow-xl relative">
































                                        <h1 id="cortes-title" class="text-center text-2xl w-full"
                                            style="color: white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#e8eaed"
                                                class="cursor-pointer absolute top-0 right-0 mt-1 sombra-icon">
                                                <path fill="#FFFFF"
                                                    d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                            </svg>
                                            CORTES
                                        </h1>
















































                                        <style>
                                            .sombra-icon:hover {
                                                fill: #b3b3b3;
                                                /* Cambia el color del relleno del SVG */
                                            }
                                        </style>
































                                        <div
                                            style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div class="table-responsive w-full"
                                            style="display: flex; justify-content: center;">
                                            @if (isset($resultadosQ39) && count($resultadosQ39) > 0 && isset($resultadosQ39[0]->fec_evento))
                                                {{-- GRÁFICO DE CORTES --}}
                                                <div class="grafico-wrapper"
                                                    style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                    <canvas id="graficoBarrascortes" class="w-full"></canvas>
                                                </div>
                                            @else
                                                <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                    <p class="mt-2 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap justify-center">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Nº Cortes</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(222, 54, 63);">
                                                    {{ count($resultadosQ43) > 0 && !empty($resultadosQ43[0]->total_eventos) ? $resultadosQ43[0]->total_eventos : 'No hay datos' }}
                                                </p>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Ratio</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(222, 54, 63);">
                                                    {{ count($resultadosQ43) > 0 && !empty($resultadosQ43[0]->ratio) ? $resultadosQ43[0]->ratio : 'No hay datos' }}
                                                </p>
                                            </div>
                                        </div>
















                                        <script>
                                            document.getElementById('cortes-title').addEventListener('click', function() {
                                                var cortesContainer = document.getElementById('cortes-container');
                                                var graficoContainer = document.getElementById('grafico-container');




                                                if (cortesContainer.classList.contains('lg:col-span-4')) {
                                                    cortesContainer.classList.remove('lg:col-span-4');
                                                    graficoContainer.style.width = '80vw';
                                                    graficoContainer.style.height = '30vh'; // Ajusta la altura a la original
                                                } else {
                                                    cortesContainer.classList.add('lg:col-span-4');
                                                    graficoContainer.style.width = '100vw';
                                                    graficoContainer.style.height = '60vh'; // Ajusta la altura cuando la clase es añadida
                                                    graficoContainer.scrollIntoView({
                                                        behavior: 'smooth',
                                                        block: 'center'
                                                    });
                                                }
                                            });
                                        </script>
































                                        {{-- SCRIPT PARA EL GRÁFICO DE CORTES --}}
                                        <script>
                                            var labels_cortes = [];
                                            var values_cortes = [];




                                            @if (isset($resultadosQ39) && count($resultadosQ39) > 0)
                                                @foreach ($resultadosQ39 as $resultado)
                                                    @if (isset($resultado->fec_evento) && isset($resultado->cantidad))
                                                        labels_cortes.push('{{ $resultado->fec_evento }}');
                                                        values_cortes.push({{ $resultado->cantidad }});
                                                    @endif
                                                @endforeach
                                            @endif




                                            document.addEventListener("DOMContentLoaded", function() {
                                                var labels = labels_cortes;
                                                var data = [{
                                                    label: 'cortes',
                                                    backgroundColor: function(context) {
                                                        var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                        gradient.addColorStop(0, 'rgba(222, 54, 63, 0.9)');
                                                        gradient.addColorStop(0.6, 'rgba(27,32,38, 0.5)');
                                                        gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                        return gradient;
                                                    },
                                                    borderColor: 'rgba(222, 54, 63, 0.9)',
                                                    borderWidth: 1,
                                                    data: values_cortes
                                                }];




                                                var maxValue = Math.max(...values_cortes) * 1.1; // Incrementa el valor máximo en un 10%




                                                var ctx = document.getElementById('graficoBarrascortes').getContext('2d');
                                                var myChart = new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: labels_cortes,
                                                        datasets: data
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
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
                                                                    }
                                                                }
                                                            },
                                                            y: {
                                                                grid: {
                                                                    color: 'rgba(0, 0, 0, 0)'
                                                                },
                                                                ticks: {
                                                                    stepSize: 100,
                                                                    color: 'white',
                                                                    callback: function(value, index, values) {
                                                                        return value.toFixed(0);
                                                                    },
                                                                    font: {
                                                                        family: 'Didact Gothic',
                                                                        weight: 'normal'
                                                                    }
                                                                },
                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje "y"
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
















                            {{-- MICROCORTES --}}
                            <div id="microcortes-container" class="col-span-1 md:col-span-1">
                                <div class="card text-white mb-3 h-full"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    <!-- Contenido de MICROCORTES -->
                                    <div class="p-0 #205E86 text-white rounded-lg shadow-xl ">
                                        <h1 id="microcortes-title" class="text-center text-2xl w-full "
                                            style="color: white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#e8eaed"
                                                class="cursor-pointer absolute top-0 right-0 mt-1 sombra-icon">
                                                <path fill="#FFFFF"
                                                    d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                            </svg>
                                            MICROCORTES
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div class="table-responsive w-full"
                                            style="display: flex; justify-content: center;">
                                            @if (isset($resultadosQ40) && count($resultadosQ40) > 0 && isset($resultadosQ40[0]->fec_evento))
                                                {{-- GRÁFICO DE MICROCORTES --}}
                                                <div id="grafico-container-microcortes" class="grafico-wrapper"
                                                    style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                    <canvas id="graficoBarrasmicrocortes" class="w-full"></canvas>
                                                </div>
                                            @else
                                                <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                    <p class="mt-2 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap justify-center">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Nº Microcortes</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(255, 155, 0);">
                                                    {{ count($resultadosQ44) > 0 && !empty($resultadosQ44[0]->total_eventos) ? $resultadosQ44[0]->total_eventos : 'No hay datos' }}
                                                </p>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Ratio</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(255, 155, 0);">
                                                    {{ count($resultadosQ44) > 0 && !empty($resultadosQ44[0]->ratio) ? $resultadosQ44[0]->ratio : 'No hay datos' }}
                                                </p>
                                            </div>
                                        </div>
























                                        <script>
                                            document.getElementById('microcortes-title').addEventListener('click', function() {
                                                var microcortesContainer = document.getElementById('microcortes-container');
                                                var graficoContainer = document.getElementById('grafico-container-microcortes');




                                                if (microcortesContainer.classList.contains('lg:col-span-4')) {
                                                    microcortesContainer.classList.remove('lg:col-span-4');
                                                    graficoContainer.style.width = '80vw';
                                                    graficoContainer.style.height = '30vh'; // Ajusta la altura a la original
                                                } else {
                                                    microcortesContainer.classList.add('lg:col-span-4');
                                                    graficoContainer.style.width = '100vw';
                                                    graficoContainer.style.height = '60vh'; // Ajusta la altura cuando la clase es añadida
                                                    graficoContainer.scrollIntoView({
                                                        behavior: 'smooth',
                                                        block: 'center'
                                                    });
                                                }
                                            });
                                        </script>




































                                        {{-- SCRIPT PARA EL GRÁFICO DE MICROCORTES --}}
                                        <script>
                                            var labels_microcortes = [];
                                            var values_microcortes = [];




                                            @if (isset($resultadosQ40) && count($resultadosQ40) > 0)
                                                @foreach ($resultadosQ40 as $resultado)
                                                    @if (isset($resultado->fec_evento) && isset($resultado->cantidad))
                                                        labels_microcortes.push('{{ $resultado->fec_evento }}');
                                                        values_microcortes.push({{ $resultado->cantidad }});
                                                    @endif
                                                @endforeach
                                            @endif




                                            document.addEventListener("DOMContentLoaded", function() {
                                                var labels = labels_microcortes;
                                                var data = [{
                                                    label: 'microcortes',
                                                    backgroundColor: function(context) {
                                                        var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                        gradient.addColorStop(0, 'rgba(255, 155, 0, 0.9)');
                                                        gradient.addColorStop(0.6, 'rgba(27,32,38, 0.5)');
                                                        gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                        return gradient;
                                                    },
                                                    borderColor: 'rgba(255, 155, 0, 0.9)',
                                                    borderWidth: 1,
                                                    data: values_microcortes
                                                }];




                                                var maxValue = Math.max(...values_microcortes) * 1.1; // Incrementa el valor máximo en un 10%




                                                var ctx = document.getElementById('graficoBarrasmicrocortes').getContext('2d');
                                                var myChart = new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: labels_microcortes,
                                                        datasets: data
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
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
                                                                    }
                                                                }
                                                            },
                                                            y: {
                                                                grid: {
                                                                    color: 'rgba(0, 0, 0, 0)'
                                                                },
                                                                ticks: {
                                                                    stepSize: 100,
                                                                    color: 'white',
                                                                    callback: function(value, index, values) {
                                                                        return value.toFixed(0);
                                                                    },
                                                                    font: {
                                                                        family: 'Didact Gothic',
                                                                        weight: 'normal'
                                                                    }
                                                                },
                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje "y"
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
















                            {{-- SUBTENSIONES --}}
                            <div id="subtensiones-container" class="col-span-1 md:col-span-1">
                                <div class="card text-white mb-3 h-full"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    <!-- Contenido de SUBTENSIONES -->
                                    <div class="p-0 #205E86 text-white rounded-lg shadow-xl ">
                                        <h1 id="subtensiones-title" class="text-center text-2xl w-full "
                                            style="color: white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#e8eaed"
                                                class="cursor-pointer absolute top-0 right-0 mt-1 sombra-icon">
                                                <path fill="#FFFFF"
                                                    d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                            </svg>
                                            SUBTENSIONES
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div class="table-responsive w-full"
                                            style="display: flex; justify-content: center;">
                                            @if (isset($resultadosQ41) && count($resultadosQ41) > 0 && isset($resultadosQ41[0]->fec_evento))
                                                {{-- GRÁFICO DE SUBTENSIONES --}}
                                                <div id="grafico-container-subtensiones" class="grafico-wrapper"
                                                    style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                    <canvas id="graficoBarrassubtensiones" class="w-full"></canvas>
                                                </div>
                                            @else
                                                <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                    <p class="mt-2 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap justify-center">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Nº Subtensiones</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(76, 218, 19);">
                                                    {{ count($resultadosQ45) > 0 && !empty($resultadosQ45[0]->total_eventos) ? $resultadosQ45[0]->total_eventos : 'No hay datos' }}
                                                </p>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Ratio</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(76, 218, 19);">
                                                    {{ count($resultadosQ45) > 0 && !empty($resultadosQ45[0]->ratio) ? $resultadosQ45[0]->ratio : 'No hay datos' }}
                                                </p>
                                            </div>
                                        </div>
































                                        <script>
                                            document.getElementById('subtensiones-title').addEventListener('click', function() {
                                                var subtensionesContainer = document.getElementById('subtensiones-container');
                                                var graficoContainer = document.getElementById('grafico-container-subtensiones');




                                                if (subtensionesContainer.classList.contains('lg:col-span-4')) {
                                                    subtensionesContainer.classList.remove('lg:col-span-4');
                                                    graficoContainer.style.width = '80vw';
                                                    graficoContainer.style.height = '30vh'; // Ajusta la altura a la original
                                                } else {
                                                    subtensionesContainer.classList.add('lg:col-span-4');
                                                    graficoContainer.style.width = '100vw';
                                                    graficoContainer.style.height = '60vh'; // Ajusta la altura cuando la clase es añadida
                                                    graficoContainer.scrollIntoView({
                                                        behavior: 'smooth',
                                                        block: 'center'
                                                    });
                                                }
                                            });
                                        </script>
































                                        {{-- SCRIPT PARA EL GRÁFICO DE SUBTENSIONES --}}
                                        <script>
                                            var labels_subtensiones = [];
                                            var values_subtensiones = [];




                                            @if (isset($resultadosQ41) && count($resultadosQ41) > 0)
                                                @foreach ($resultadosQ41 as $resultado)
                                                    @if (isset($resultado->fec_evento) && isset($resultado->cantidad))
                                                        labels_subtensiones.push('{{ $resultado->fec_evento }}');
                                                        values_subtensiones.push({{ $resultado->cantidad }});
                                                    @endif
                                                @endforeach
                                            @endif




                                            document.addEventListener("DOMContentLoaded", function() {
                                                var labels = labels_subtensiones;
                                                var data = [{
                                                    label: 'subtensiones',
                                                    backgroundColor: function(context) {
                                                        var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                        gradient.addColorStop(0, 'rgba(76, 218, 19, 0.9)');
                                                        gradient.addColorStop(0.6, 'rgba(27,32,38, 0.5)');
                                                        gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                        return gradient;
                                                    },
                                                    borderColor: 'rgba(76, 218, 19, 0.9)',
                                                    borderWidth: 1,
                                                    data: values_subtensiones
                                                }];




                                                var maxValue = Math.max(...values_subtensiones) * 1.1; // Incrementa el valor máximo en un 10%




                                                var ctx = document.getElementById('graficoBarrassubtensiones').getContext('2d');
                                                var myChart = new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: labels_subtensiones,
                                                        datasets: data
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
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
                                                                    }
                                                                }
                                                            },
                                                            y: {
                                                                grid: {
                                                                    color: 'rgba(0, 0, 0, 0)'
                                                                },
                                                                ticks: {
                                                                    stepSize: 100,
                                                                    color: 'white',
                                                                    callback: function(value, index, values) {
                                                                        return value.toFixed(0);
                                                                    },
                                                                    font: {
                                                                        family: 'Didact Gothic',
                                                                        weight: 'normal'
                                                                    }
                                                                },
                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje "y"
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
































                            {{-- SOBRETENSIONES --}}
                            <div id="sobretensiones-container" class="col-span-1 md:col-span-1">
                                <div class="card text-white mb-3 h-full"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    <h1 id="sobretensiones-title" class="text-center text-2xl w-full relative"
                                        style="color: white;">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24"
                                            width="24px" fill="#e8eaed"
                                            class="cursor-pointer absolute top-0 right-0 mt-1 sombra-icon">
                                            <path fill="#FFFFF"
                                                d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                        </svg>
                                        SOBRETENSIONES
                                    </h1>
































                                    <div
                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                    </div>
                                    <div class="col-span-1 md:col-span-1">
                                        <div class="table-responsive w-full"
                                            style="display: flex; justify-content: center;">
                                            @if (isset($resultadosQ42) && count($resultadosQ42) > 0 && isset($resultadosQ42[0]->fec_evento))
                                                {{-- GRÁFICO DE SOBRETENSIONES --}}
                                                <div id="grafico-container-sobretensiones" class="grafico-wrapper"
                                                    style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                    <canvas id="graficoBarrassobretensiones" class="w-full"></canvas>
                                                </div>
                                            @else
                                                <div class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                    <p class="mt-2 text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap justify-center">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Nº Sobretensiones</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(190, 83, 223);">
                                                    {{ count($resultadosQ46) > 0 && !empty($resultadosQ46[0]->total_eventos) ? $resultadosQ46[0]->total_eventos : 'No hay datos' }}
                                                </p>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl mx-2 mb-4">
                                                <h2 class="text-xl text-center font-normal">Ratio</h2>
                                                <p class="mt-2 text-xl text-center" style="color:rgb(190, 83, 223);">
                                                    {{ count($resultadosQ46) > 0 && !empty($resultadosQ46[0]->ratio) ? $resultadosQ46[0]->ratio : 'No hay datos' }}
                                                </p>
                                            </div>
                                        </div>
                                        <script>
                                            document.getElementById('sobretensiones-title').addEventListener('click', function() {
                                                var sobretensionesContainer = document.getElementById('sobretensiones-container');
                                                var graficoContainer = document.getElementById('grafico-container-sobretensiones');




                                                if (sobretensionesContainer.classList.contains('lg:col-span-4')) {
                                                    sobretensionesContainer.classList.remove('lg:col-span-4');
                                                    graficoContainer.style.width = '80vw';
                                                    graficoContainer.style.height = '30vh'; // Ajusta la altura a la original
                                                } else {
                                                    sobretensionesContainer.classList.add('lg:col-span-4');
                                                    graficoContainer.style.width = '100vw';
                                                    graficoContainer.style.height = '60vh'; // Ajusta la altura cuando la clase es añadida
                                                    graficoContainer.scrollIntoView({
                                                        behavior: 'smooth',
                                                        block: 'center'
                                                    });
                                                }
                                            });
                                        </script>
                                        {{-- SCRIPT PARA EL GRÁFICO DE SOBRETENSIONES --}}
                                        <script>
                                            var labels_sobretensiones = [];
                                            var values_sobretensiones = [];




                                            @if (isset($resultadosQ42) && count($resultadosQ42) > 0)
                                                @foreach ($resultadosQ42 as $resultado)
                                                    @if (isset($resultado->fec_evento) && isset($resultado->cantidad))
                                                        labels_sobretensiones.push('{{ $resultado->fec_evento }}');
                                                        values_sobretensiones.push({{ $resultado->cantidad }});
                                                    @endif
                                                @endforeach
                                            @endif




                                            document.addEventListener("DOMContentLoaded", function() {
                                                var labels = labels_sobretensiones;
                                                var data = [{
                                                    label: 'sobretensiones',
                                                    backgroundColor: function(context) {
                                                        var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                        gradient.addColorStop(0, 'rgba(190, 83, 223, 0.9)');
                                                        gradient.addColorStop(0.6, 'rgba(27,32,38, 0.5)');
                                                        gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                                        return gradient;
                                                    },
                                                    borderColor: 'rgba(190, 83, 223, 0.9)',
                                                    borderWidth: 1,
                                                    data: values_sobretensiones
                                                }];




                                                var maxValue = Math.max(...values_sobretensiones) * 1.1; // Incrementa el valor máximo en un 10%




                                                var ctx = document.getElementById('graficoBarrassobretensiones').getContext('2d');
                                                var myChart = new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: labels_sobretensiones,
                                                        datasets: data
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
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
                                                                    }
                                                                }
                                                            },
                                                            y: {
                                                                grid: {
                                                                    color: 'rgba(0, 0, 0, 0)'
                                                                },
                                                                ticks: {
                                                                    stepSize: 100,
                                                                    color: 'white',
                                                                    callback: function(value, index, values) {
                                                                        return value.toFixed(0);
                                                                    },
                                                                    font: {
                                                                        family: 'Didact Gothic',
                                                                        weight: 'normal'
                                                                    }
                                                                },
                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje "y"
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








                        {{-- CUARTA FILA --}}
                        <div class="col-span-3 md:col-span-1">
                            <div class="card text-white mb-3 h-full"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                    <div class="card text-white  mb-3 h-full"
                                        style="
                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl w-full" style="color: white;">
                                            RESUMEN DE CALIDAD DE TENSIÓN E INTENSIDAD</h1>
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
                                                (Últimas 48 horas)
                                            @endif
                                        </h2>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                 border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div> <!-- Cuadrado para Reportes Calidad por CUPS-->
                                        @if (is_array($resultadosQ48) && count($resultadosQ48) > 0 && is_array($resultadosQ49) && count($resultadosQ49) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">


                                                <table id="testTableResumenCalidadEnergia"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr id="titulogrande">
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">#</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">CT</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;"
                                                                colspan="3">Desequilibrio Voltaje</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;"
                                                                colspan="3">Desequilibrio Corriente</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;"
                                                                colspan="3">Voltaje Fase R</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;"
                                                                colspan="3">Voltaje Fase S</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-right"
                                                                style="color:rgb(88,226,194); padding: 0 8px;"
                                                                colspan="3">Voltaje Fase T</th>
                                                        </tr>
                                                        <tr id="titulopeque">
                                                            <th class="border-right"></th>
                                                            <th class="border-right"></th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Max</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Min</th>
                                                            <th class="text-sm font-medium border-right"
                                                                style="color:rgb(88,226,194);">Promedio</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Max</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Min</th>
                                                            <th class="text-sm font-medium border-right"
                                                                style="color:rgb(88,226,194);">Promedio</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Max</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Min</th>
                                                            <th class="text-sm font-medium border-right"
                                                                style="color:rgb(88,226,194);">Promedio</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Max</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Min</th>
                                                            <th class="text-sm font-medium border-right"
                                                                style="color:rgb(88,226,194);">Promedio</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Max</th>
                                                            <th class="text-sm font-medium"
                                                                style="color:rgb(88,226,194);">Min</th>
                                                            <th class="text-sm font-medium border-right"
                                                                style="color:rgb(88,226,194);">Promedio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $combinedResults = [];
                                                            foreach ($resultadosQ48 as $resultado) {
                                                                $combinedResults[$resultado->id_ct][
                                                                    'desequilibrio_voltaje'
                                                                ] = $resultado;
                                                            }
                                                            foreach ($resultadosQ49 as $resultado) {
                                                                $combinedResults[$resultado->id_ct][
                                                                    'voltajes'
                                                                ] = $resultado;
                                                            }
                                                        @endphp


                                                        @foreach ($combinedResults as $id_ct => $resultados)
                                                            <tr class="highlight-row">
                                                                <td class="p-2 border-right">{{ $loop->iteration }}
                                                                </td>
                                                                <td class="p-2 border-right">
                                                                    {{ $resultados['desequilibrio_voltaje']->nom_ct !== null ? $resultados['desequilibrio_voltaje']->nom_ct : 'No hay datos' }}
                                                                </td>
                                                                <!-- Desequilibrio Voltaje -->
                                                                <td class="p-2">
                                                                    {{ $resultados['desequilibrio_voltaje']->max_pct_deseq_voltaje !== null ? $resultados['desequilibrio_voltaje']->max_pct_deseq_voltaje : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2">
                                                                    {{ $resultados['desequilibrio_voltaje']->min_pct_deseq_voltaje !== null ? $resultados['desequilibrio_voltaje']->min_pct_deseq_voltaje : 'No hay datos' }}
                                                                </td>
                                                                @php
                                                                    $backgroundStyle = '';
                                                                    if (
                                                                        $resultados['desequilibrio_voltaje']
                                                                            ->avg_pct_deseq_voltaje !== null
                                                                    ) {
                                                                        if (
                                                                            $resultados['desequilibrio_voltaje']
                                                                                ->avg_pct_deseq_voltaje <= 3
                                                                        ) {
                                                                            $backgroundStyle =
                                                                                'linear-gradient(to bottom, rgba(76, 218, 19, 0.4), rgba(55, 157, 14, 0.9))';
                                                                        } else {
                                                                            $backgroundStyle =
                                                                                'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))';
                                                                        }
                                                                    }
                                                                @endphp


                                                                <td class="p-2 border-right"
                                                                    style="background: {{ $backgroundStyle }}">
                                                                    {{ $resultados['desequilibrio_voltaje']->avg_pct_deseq_voltaje !== null
                                                                        ? $resultados['desequilibrio_voltaje']->avg_pct_deseq_voltaje
                                                                        : 'No hay datos' }}
                                                                </td>














                                                                <!-- Desequilibrio Corriente -->
                                                                <td class="p-2">
                                                                    {{ $resultados['desequilibrio_voltaje']->max_pct_deseq_corriente !== null ? $resultados['desequilibrio_voltaje']->max_pct_deseq_corriente : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2">
                                                                    {{ $resultados['desequilibrio_voltaje']->min_pct_deseq_corriente !== null ? $resultados['desequilibrio_voltaje']->min_pct_deseq_corriente : 'No hay datos' }}
                                                                </td>
                                                                @php
                                                                    $backgroundStyleCorriente = ''; // Default color if no data
                                                                    if (
                                                                        $resultados['desequilibrio_voltaje']
                                                                            ->avg_pct_deseq_corriente !== null
                                                                    ) {
                                                                        if (
                                                                            $resultados['desequilibrio_voltaje']
                                                                                ->avg_pct_deseq_corriente <= 30
                                                                        ) {
                                                                            $backgroundStyleCorriente =
                                                                                'linear-gradient(to bottom, rgba(76, 218, 19, 0.4), rgba(55, 157, 14, 0.9))';
                                                                        } else {
                                                                            $backgroundStyleCorriente =
                                                                                'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))';
                                                                        }
                                                                    }
                                                                @endphp


                                                                <td class="p-2 border-right"
                                                                    style="background: {{ $backgroundStyleCorriente }}">
                                                                    {{ $resultados['desequilibrio_voltaje']->avg_pct_deseq_corriente !== null
                                                                        ? $resultados['desequilibrio_voltaje']->avg_pct_deseq_corriente
                                                                        : 'No hay datos' }}
                                                                </td>






                                                                <!-- Voltaje Fase R -->
                                                                <td class="p-2">
                                                                    {{ $resultados['voltajes']->max_volt1 !== null ? $resultados['voltajes']->max_volt1 : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2">
                                                                    {{ $resultados['voltajes']->min_volt1 !== null ? $resultados['voltajes']->min_volt1 : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2 border-right">
                                                                    {{ $resultados['voltajes']->prom_volt1 !== null ? $resultados['voltajes']->prom_volt1 : 'No hay datos' }}
                                                                </td>


                                                                <!-- Voltaje Fase S -->
                                                                <td class="p-2">
                                                                    {{ $resultados['voltajes']->max_volt2 !== null ? $resultados['voltajes']->max_volt2 : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2">
                                                                    {{ $resultados['voltajes']->min_volt2 !== null ? $resultados['voltajes']->min_volt2 : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2 border-right">
                                                                    {{ $resultados['voltajes']->prom_volt2 !== null ? $resultados['voltajes']->prom_volt2 : 'No hay datos' }}
                                                                </td>


                                                                <!-- Voltaje Fase T -->
                                                                <td class="p-2">
                                                                    {{ $resultados['voltajes']->max_volt3 !== null ? $resultados['voltajes']->max_volt3 : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2">
                                                                    {{ $resultados['voltajes']->min_volt3 !== null ? $resultados['voltajes']->min_volt3 : 'No hay datos' }}
                                                                </td>
                                                                <td class="p-2 border-right">
                                                                    {{ $resultados['voltajes']->prom_volt3 !== null ? $resultados['voltajes']->prom_volt3 : 'No hay datos' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">No
                                                    hay
                                                    datos</p>
                                            </div>
                                        @endif
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4">
                                            <input type="button"
                                                onclick="tableToExcel2('testTableResumenCalidadEnergia', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- QUINTA FILA  --}}
                        <div class="col-span-3 md:col-span-1">
                            <div class="card text-white mb-3 h-full"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <div class="col-span-3 md:col-span-1 lg:col-span-3">
                                    <div class="card text-white  mb-3 h-full"
                                        style="
                                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl w-full" style="color: white;">
                                            RESUMEN DE NIVEL DE TENSIÓN POR CUPS
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
                                                (Últimos 7 días)
                                            @endif
                                        </h2>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                                         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>




                                        <!-- Cuadrado para TENSIÓN POR CUPS -->
                                        @if (is_array($resultadosQ51) && count($resultadosQ51) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableTensionCUPS"
                                                    class="w-full text-white text-center">
                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">#</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">ID CUPS
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Nombre
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">Nombre CT
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Dirección
                                                            </th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Contador</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Última fecha de lectura</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Promedio</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Máximo</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Mínimo</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194); padding: 0 8px;">
                                                                Número de lecturas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($resultadosQ51 as $index => $resultado)
        @php
            // Verifica si $resultado es un objeto antes de acceder a sus propiedades
            if (is_object($resultado)) {
                // Condición para el campo "round"
                if ($resultado->round > 243) {
                    $fondoRound = 'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))'; // Si "round" es mayor que 243 ROJO
                } elseif ($resultado->round < 218) {
                    $fondoRound = 'linear-gradient(to bottom, rgba(255, 165, 0, 0.6), rgba(255, 140, 0, 0.9));'; // Si "round" es menor que 218
                } else {
                    $fondoRound = 'transparent'; // Si no cumple ninguna condición
                }


                // Condición para el campo "max"
                if ($resultado->max > 243) {
                    $fondoMax = 'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))'; // Si "max" es mayor que 243 ROJO
                } elseif ($resultado->max < 218) {
                    $fondoMax = 'linear-gradient(to bottom, rgba(255, 165, 0, 0.6), rgba(255, 140, 0, 0.9));'; // Si "max" es menor que 218
                } else {
                    $fondoMax = 'transparent'; // Si no cumple ninguna condición
                }


                // Condición para el campo "min"
                if ($resultado->min > 243) {
                    $fondoMin = 'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))'; // Si "min" es mayor que 243 ROJO
                } elseif ($resultado->min < 218) {
                    $fondoMin = 'linear-gradient(to bottom, rgba(255, 165, 0, 0.6), rgba(255, 140, 0, 0.9));'; // Si "min" es menor que 218
                } else {
                    $fondoMin = 'transparent'; // Si no cumple ninguna condición
                }
            } else {
                // Si $resultado no es un objeto, establecemos valores predeterminados
                $fondoRound = $fondoMax = $fondoMin = 'transparent';
            }
        @endphp




                                                            <tr class="highlight-row">
                                                                <td class="py-2">{{ $loop->iteration }}</td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->nom_cups) ? $resultado->nom_cups : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->fec_lectura) ? $resultado->fec_lectura : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2"
                                                                    style="background: {{ $fondoRound }}">
                                                                    {{ !empty($resultado->round) ? $resultado->round : '0' }}
                                                                </td>
                                                                <td class="py-2"
                                                                    style="background: {{ $fondoMax }}">
                                                                    {{ !empty($resultado->max) ? $resultado->max : '0' }}
                                                                </td>
                                                                <td class="py-2"
                                                                    style="background: {{ $fondoMin }}">
                                                                    {{ !empty($resultado->min) ? $resultado->min : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->count) ? $resultado->count : '0' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>




                                                </table>
                                            </div>
                                        @else
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <p class="mt-0 text-xl text-center" style="color:rgb(88,226,194)">No
                                                    hay
                                                    datos</p>
                                            </div>
                                        @endif
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4">
                                            <input type="button"
                                                onclick="tableToExcel('testTableTensionCUPS', 'W3C Example Table')"
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
    </div>
</body>




