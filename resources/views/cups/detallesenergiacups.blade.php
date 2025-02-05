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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- ENLACE A JS GENERAL --}}
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

        /* CSS PARA LOS GRAFICOS DE LA ULTIMA FILA */
        /* #segundaFila {
            margin-left: 10%;
        } */


        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */

        }


        @media (min-width: 1024px) {
            #graficoPromedio {
                width: 100%;
                height: 100%;
            }

            #segundaFila {
                margin-left: 0%;
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
    <title>Calidad Energía CUPS</title>
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
                        <a href="{{ route('detallesinformacioncups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('detallescurvashorariascups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Curvas Horarias</a>
                        <a href="{{ route('detallesenergiacups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Calidad Energía</a>
                        <a href="{{ route('detalleseventoscups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Eventos</a> <span class="nav-indicator"></span>
                    </nav> {{-- Obtener el id_cups almacenado en la sesión --}}
                    @php
                        $id_cups = session()->get('id_cups');
                        $id_cnt = session()->get('id_cnt');
                    @endphp
                    {{-- BUSCADOR --}}
                    <div class="container ">
                        <div class="form-group ">
                            <form action="{{ route('energiacups') }}" method="GET">
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
                    @if (isset($id_cups) || isset($id_cnt))
                        @if (count($resultadosQ1cups) === 0)
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">CALIDAD ENERGÍA CUPS</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>

                            {{-- <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-2 mb-6"> --}}
                            {{-- PRIMERA FILA --}}
                            <div class="container">
                                <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-2 ">

                                    <!-- Cuadrado para Cortes de Tensión  CAJA 1-->
                                    <div class="col-span-1 card text-white mb-3 h-full"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">Nº DE CORTES
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md mt-4">
                                                        <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                            <p class="mt-0 text-{{ count($resultadosQ14cups) > 0 && !empty($resultadosQ14cups[0]->cortes) ? '3xl' : '3xl' }} text-center"
                                                                style="color:rgb(222,54,63)">
                                                                {{ count($resultadosQ14cups) > 0 && !empty($resultadosQ14cups[0]->cortes) ? number_format($resultadosQ14cups[0]->cortes, 0, '.', '.') : '0' }}
                                                            </p>
                                                        </div>
                                                        @if (count($resultadosQ19cups) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableCortes"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                HORA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ19cups as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fec_evento) ? $resultado->fec_evento : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->hor_evento) ? $resultado->hor_evento : 'No hay datos' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
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
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4"
                                            style="position: absolute; bottom: 10px; right: 10px;">
                                            <input type="button"
                                                onclick="tableToExcel('testTableCortes', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>


                                    <!-- Cuadrado para Micro Cortes CAJA 2-->
                                    <div class="col-span-1 card text-white mb-3  h-full"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">MICRO CORTES
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md mt-4">
                                                        <!-- Cuadrado para Micro Cortes -->
                                                        <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                            <p class="mt-0 text-{{ count($resultadosQ15cups) > 0 && !empty($resultadosQ15cups[0]->micro_cortes) ? '3xl' : '3xl' }} text-center"
                                                                style="color:rgb(252,158,36)">
                                                                {{ count($resultadosQ15cups) > 0 && !empty($resultadosQ15cups[0]->micro_cortes) ? number_format($resultadosQ15cups[0]->micro_cortes, 0, '.', '.') : '0' }}
                                                            </p>
                                                        </div>
                                                        @if (count($resultadosQ20cups) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableMicroCortes"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                HORA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ20cups as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fec_evento) ? $resultado->fec_evento : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->hor_evento) ? $resultado->hor_evento : 'No hay datos' }}
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
                                                                    hay
                                                                    datos
                                                                </p>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4"
                                            style="position: absolute; bottom: 10px; right: 10px;">
                                            <input type="button"
                                                onclick="tableToExcel('testTableMicroCortes', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>

                                    <!-- Cuadrado para Sobretensiones CAJA 3-->
                                    <div class="col-span-1 card text-white mb-3  h-full"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">SOBRETENSIONES
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md mt-4">
                                                        <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                            <p class="mt-0 text-{{ count($resultadosQ16cups) > 0 && !empty($resultadosQ16cups[0]->sobre_tensiones) ? '3xl' : '3xl' }} text-center"
                                                                style="color:rgb(190, 83, 223)">
                                                                {{ count($resultadosQ16cups) > 0 && !empty($resultadosQ16cups[0]->sobre_tensiones) ? number_format($resultadosQ16cups[0]->sobre_tensiones, 0, '.', '.') : '0' }}
                                                            </p>
                                                        </div>
                                                        @if (count($resultadosQ21cups) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableSobreTensiones"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                HORA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ21cups as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fec_evento) ? $resultado->fec_evento : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->hor_evento) ? $resultado->hor_evento : 'No hay datos' }}
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
                                                                    hay
                                                                    datos
                                                                </p>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4"
                                            style="position: absolute; bottom: 10px; right: 10px;">
                                            <input type="button"
                                                onclick="tableToExcel('testTableSobreTensiones', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>


                                    <!--Subtensiones CAJA 4-->
                                    <div class="col-span-1 card text-white mb-3  h-full"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">SUBTENSIONES
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md mt-4">
                                                        <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                            <p class="mt-0 text-{{ count($resultadosQ17cups) > 0 && !empty($resultadosQ17cups[0]->sub_tensiones) ? '3xl' : '3xl' }} text-center"
                                                                style="color:rgb(76,218,19)">
                                                                {{ count($resultadosQ17cups) > 0 && !empty($resultadosQ17cups[0]->sub_tensiones) ? number_format($resultadosQ17cups[0]->sub_tensiones, 0, '.', '.') : '0' }}
                                                            </p>
                                                        </div>
                                                        @if (count($resultadosQ22cups) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableSubTensiones"
                                                                    class="w-full text-white text-center">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194); padding: 10px">
                                                                                HORA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ22cups as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fec_evento) ? $resultado->fec_evento : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->hor_evento) ? $resultado->hor_evento : 'No hay datos' }}
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
                                                                    hay
                                                                    datos
                                                                </p>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Contenedor del botón de descarga -->
                                        <div class="text-right mt-4"
                                            style="position: absolute; bottom: 10px; right: 10px;">
                                            <input type="button"
                                                onclick="tableToExcel('testTableSubTensiones', 'W3C Example Table')"
                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                        </div>
                                    </div>


                                    <div class="col-span-1 card text-white mb-3 col h-full"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">FACTOR
                                            POTENCIA PROMEDIO
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div style="display: flex; justify-content: center;">
                                            <div class="container">
                                                <div class="row ">
                                                    <div class="col-md mt-4 mb-4">
                                                        <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                            <?php
                                                            $color = 'rgb(254,230,153)'; // default color
                                                            if (count($resultadosQ18cups) > 0 && !empty($resultadosQ18cups[0]->factor_potencia)) {
                                                                $factor_potencia = $resultadosQ18cups[0]->factor_potencia;
                                                                if ($factor_potencia >= 0.95 && $factor_potencia <= 1) {
                                                                    $color = 'rgb(76,218,19)'; //verde
                                                                } elseif ($factor_potencia >= 0.8 && $factor_potencia < 0.95) {
                                                                    $color = 'rgb(252,158,36)'; //naranja
                                                                } elseif ($factor_potencia >= 0 && $factor_potencia < 0.8) {
                                                                    $color = 'rgb(222,54,63)'; //rojo
                                                                }
                                                            } else {
                                                                $factor_potencia = 'No hay datos';
                                                                $color = 'rgb(254,230,153)'; // color for "No hay datos"
                                                            }
                                                            ?> <p
                                                                class="mt-0 text-{{ is_numeric($factor_potencia) ? '3xl' : '1xl' }} text-center"
                                                                style="color:<?= $color ?>;">
                                                                <?= $factor_potencia ?> θ
                                                            </p>
                                                        </div>
                                                        <!-- Elemento derecho -->
                                                        @if (count($resultadosQ26cups) > 0)
                                                            <div class="container mt-20 w-32 align-center">
                                                                <div>
                                                                    <div class="#205E86 text-white rounded-lg shadow-xl"
                                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); ">
                                                                        <h2
                                                                            class="text-sm text-center font-normal mb-0">
                                                                            Máx</h2>
                                                                        <p
                                                                            class="mt-0 text-xl font-bold text-center text-white mb-2">
                                                                            {{ !empty($resultadosQ26cups[0]->factor_potencia_max) ? $resultadosQ26cups[0]->factor_potencia_max : '0' }}
                                                                            θ
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="#205E86 text-white rounded-lg shadow-xl"
                                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); ">
                                                                        <h2 class="text-sm text-center font-normal">
                                                                            Mín
                                                                        </h2>
                                                                        <p
                                                                            class="mt-0 text-xl font-bold text-center text-white">
                                                                            {{ !empty($resultadosQ26cups[0]->factor_potencia_min) ? $resultadosQ26cups[0]->factor_potencia_min : '0' }}
                                                                            θ
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Manejo de no hay datos -->
                                                            <div class="col-md-12 text-center mt-10">
                                                                <div
                                                                    class="#205E86 text-white rounded-lg shadow-xl p-4">
                                                                    <p class="mt-2 text-xl font-bold"
                                                                        style="color: rgb(88, 226, 194)">
                                                                        No hay
                                                                        datos</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}

                            {{-- SEGUNDA FILA DE GRÁFICOS --}}
                            <!--FACTOR DE POTENCIA CAJA 5-->
                            <h1 class="text-center text-2xl" style="color: white;">VOLTAJE</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                            <div
                                class="container grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0">
                                <div class="card text-white mb-3 col-span-1"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    {{-- GRAFICO --}}
                                    @if (count($resultadosQ24cups) > 0)
                                        <!-- Elemento izquierdo GAUGE-->
                                        <div class="p-4 h-full flex flex-col justify-center items-center">
                                            <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                Promedio
                                            </h2>
                                            <!-- Ajuste de margen superior -->
                                            <div id="graficoPromedio" class="h-40"></div>
                                        </div>
                                    @else
                                        <!-- Manejo de no hay datos -->
                                        <div class="col-md-12 text-center mt-10">
                                            <div class="#205E86 text-white rounded-lg shadow-xl p-4">
                                                <p class="mt-2 text-xl font-bold" style="color: rgb(88, 226, 194)">
                                                    No hay
                                                    datos</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- Elemento central (gráfico de lineas) -->
                                <div class="card text-white  mb-3 col-span-4"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    @if (!empty($resultadosQ23cups) && count($resultadosQ23cups) > 0)
                                        <div class="table-responsive w-full"
                                            style="display: flex; justify-content: center;">
                                            <div
                                                style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                <canvas id="graficoTensionHora" class="w-full"></canvas>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Manejo de no hay datos -->
                                        <div class="col-md-12 text-center mt-10">
                                            <div class="#205E86 text-white rounded-lg shadow-xl p-4">
                                                <p class="mt-2 text-xl font-bold" style="color: rgb(88, 226, 194)">
                                                    No hay
                                                    datos</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- Elemento derecho MAX y MIN -->
                                <div class="card text-white mb-3 col-span-1 w-full"
                                    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                    @if (count($resultadosQ24cups) > 0)
                                        <div class="p-4 h-full flex flex-col justify-center items-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="max-min-item text-white rounded-lg shadow-xl mb-2 p-4"
                                                    style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                    <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                    <p class="text-xl font-bold text-center">
                                                        {{ !empty($resultadosQ24cups[0]->maximo) ? $resultadosQ24cups[0]->maximo : '0' }}
                                                        V
                                                    </p>
                                                </div>
                                                <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                    style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                    <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                    <p class="text-xl font-bold text-center">
                                                        {{ !empty($resultadosQ24cups[0]->minimo) ? $resultadosQ24cups[0]->minimo : '0' }}
                                                        V
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Manejo de no hay datos -->
                                        <div class="col-md-12 text-center mt-10">
                                            <div class="#205E86 text-white rounded-lg shadow-xl p-4">
                                                <p class="mt-2 text-xl font-bold" style="color: rgb(88, 226, 194)">
                                                    No hay
                                                    datos</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- GRAFICO GAUGE --}}
                            <script>
                                var myChart; // Variable para almacenar el objeto Chart
                                var prom_volt1_data = {
                                    @if (count($resultadosQ24cups) > 0 && !empty($resultadosQ24cups[0]->promedio))
                                        data: {{ $resultadosQ24cups[0]->promedio }},
                                    @else
                                        data: '0',
                                    @endif
                                };
                                // Función para actualizar el gráfico de pastel con nuevos datos
                                function updateChartPromedio(data) {
                                    // Función para determinar el color basado en los datos
                                    function getColor(value) {
                                        return value < 80 ? "rgba(232,80,107, 0.9)" : "rgba(39,47,58, 0.9)";
                                    }
                                    // Variables para el color y color de texto
                                    var color = getColor(data.data);
                                    var textColor = getColor(data.data) === "rgba(232,80,107, 0.9)" ? "rgba(232,80,107, 0.9)" :
                                        "linear-gradient(to bottom, rgba(88,226,194, 0.9), rgba(0, 0, 0, 0.9))";
                                    // Valores máximo y mínimo del gráfico
                                    @if (count($resultadosQ24cups) > 0 && !empty($resultadosQ24cups[0]->maximo))
                                        var maxVolt1 = {{ $resultadosQ24cups[0]->maximo }};
                                    @else
                                        var maxVolt1 = 100; // Valor predeterminado si no hay datos
                                    @endif
                                    @if (count($resultadosQ24cups) > 0 && !empty($resultadosQ24cups[0]->minimo))
                                        var minVolt1 = {{ $resultadosQ24cups[0]->minimo }};
                                    @else
                                        var minVolt1 = 0; // Valor predeterminado si no hay datos
                                    @endif
                                    // Configuración de nuevos datos y diseño del gráfico
                                    var newData = [{
                                        type: "indicator",
                                        mode: "gauge",
                                        value: data.data,
                                        title: {
                                            font: {
                                                size: 20,
                                                color: 'white' // Letras blancas
                                            }
                                        },
                                        gauge: {
                                            axis: {
                                                range: [minVolt1, maxVolt1],
                                                tickwidth: 1,
                                                tickcolor: "rgb(88,226,194)",
                                                linecolor: "rgb(88,226,194)" // Línea central verde
                                            },
                                            bar: {
                                                color: "rgba(88,226,194, 0.9)",
                                                thickness: 0.8
                                            },
                                            bgcolor: "transparent",
                                            borderwidth: 2,
                                            bordercolor: "transparent",
                                            steps: [{
                                                    range: [0, minVolt1],
                                                    color: color
                                                },
                                                {
                                                    range: [minVolt1, maxVolt1],
                                                    color: "rgba(27,32,38, 0.5)" // Nuevo color en la mitad del gradiente
                                                }
                                            ],
                                            startangle: 270,
                                        },
                                        hoverinfo: data.data,
                                    }];
                                    var layout = {
                                        responsive: true,
                                        margin: {
                                            t: 25,
                                            r: 25,
                                            l: 25,
                                            b: 25
                                        },
                                        paper_bgcolor: "transparent",
                                        font: {
                                            color: "white",
                                            family: "Didact Gothic",
                                            weight: 'normal'
                                        },
                                        annotations: [{
                                            text: data.data + ' V',
                                            x: 0.5,
                                            y: 0.45,
                                            showarrow: false,
                                            font: {
                                                size: 20,
                                                color: textColor
                                            }
                                        }],
                                    };
                                    // Actualizar el gráfico
                                    Plotly.react('graficoPromedio', newData, layout, {
                                        displaylogo: false,
                                        displayModeBar: false
                                    });
                                }
                                //inicialización del gráfico
                                window.onload = function() {
                                    updateChartPromedio(prom_volt1_data);
                                };
                            </script>
                            {{-- GRAFICO DE LINEAS --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    @if (!empty($resultadosQ23cups) && count($resultadosQ23cups) > 0)
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt1 = [];
                                        var values_volt1 = [];
                                        @foreach ($resultadosQ23cups as $key => $resultado)
                                            // Agregar la fecha y hora como etiquetas del eje x
                                            var dateTime = '{{ $resultado->fec_lectura }} {{ $resultado->hor_lectura }}';
                                            labels_volt1.push(dateTime);
                                            // Agregar el valor de 'tension' como valor del eje y
                                            values_volt1.push({{ $resultado->tension }});
                                        @endforeach // Logging para verificación
                                        console.log('Datos de resultadosQ23cups:', @json($resultadosQ23cups));
                                        console.log('Labels:', labels_volt1);
                                        console.log('Values:',
                                            values_volt1); // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                        var filteredLabels = [labels_volt1[0]];
                                        for (var i = 1; i < labels_volt1.length; i++) {
                                            if (labels_volt1[i] !== labels_volt1[i - 1]) {
                                                filteredLabels.push(labels_volt1[i]);
                                            }
                                        }
                                        var canvas = document.getElementById('graficoTensionHora');
                                        console.log('Canvas element:', canvas);
                                        if (canvas) {
                                            var ctx = canvas.getContext('2d');
                                            var myChartLineVoltaje1 = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: filteredLabels,
                                                    datasets: [{
                                                        label: 'Tensión',
                                                        data: values_volt1,
                                                        borderColor: 'rgb(88, 226, 194)',
                                                        backgroundColor: function(context) {
                                                            var gradient = context.chart.ctx.createLinearGradient(0, 0,
                                                                0, 400);
                                                            gradient.addColorStop(0,
                                                                'rgba(88,226,194, 0.9)'
                                                            ); // Color inicial con opacidad 0.9
                                                            gradient.addColorStop(0.3,
                                                                'rgba(88,226,194, 0.5)'
                                                            ); // Nuevo color en la mitad del gradiente
                                                            gradient.addColorStop(1,
                                                                'rgba(88,226,194, 0)'
                                                            ); // Color final con opacidad 0 (transparente)
                                                            return gradient;
                                                        },
                                                        borderWidth: 2,
                                                        pointBackgroundColor: 'rgba(88,226,194, 0.8)',
                                                        pointBorderColor: 'rgb(88,226,194)',
                                                        pointBorderWidth: 2,
                                                        fill: true,
                                                        tension: 0.4,
                                                        pointRadius: 3,
                                                    }]
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
                                                                        label += context.parsed.y + ' V';
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
                                                            labels: filteredLabels.map(label => {
                                                                const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                return timeWithoutSeconds;
                                                            }),
                                                            grid: {
                                                                color: 'rgb(50, 50, 50)'
                                                            },
                                                            ticks: {
                                                                color: '#FFFFFF',
                                                                stepSize: 2
                                                            }
                                                        },
                                                        y: {
                                                            display: true,
                                                            beginAtZero: true,
                                                            grid: {
                                                                color: 'rgb(50, 50, 50)'
                                                            },
                                                            ticks: {
                                                                color: '#FFFFFF',
                                                                min: 0,
                                                                max: 300,
                                                                stepSize: 100,
                                                                callback: function(value, index, values) {
                                                                    return [0, 100, 200, 300].includes(value) ? value + ' V' :
                                                                        '';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        } else {
                                            console.error('El elemento canvas con id "graficoTensionHora" no se encontró.');
                                        }
                                    @endif
                                });
                            </script>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
