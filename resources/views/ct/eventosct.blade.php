<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}"> {{-- BOOTSTRAP --}}
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
   
    <title>Eventos CT</title>
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
                        <a href="{{ route('señalplc', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Lecturas/Señal PLC</a>
                        @foreach ($ct_info as $ct)
                            @if ($ct->id_ct == $id_ct && $ct->ind_balance == true)
                                <a href="{{ route('balances', ['id_ct' => $id_ct]) }}" class="nav-item"
                                    active-color="rgb(88, 226, 194">Balances</a>
                            @endif
                        @endforeach
                        <a href="{{ route('eventosct', ['id_ct' => $id_ct]) }}" class="nav-item is-active"
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
                                action="{{ route('eventosct', ['id_ct' => $id_ct]) }}" method="GET">
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
                        @endphp @if ($selected_ct_info->isEmpty())
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
                            @foreach ($ct_info as $ct)
                                @if ($ct->id_ct == $id_ct)
                                    {{-- CONTENEDOR CUERPO --}}
                                    <div class="container">
                                        {{-- PRIMERA FILA --}}
                                        <form action="{{ route('eventosct', ['id_ct' => $id_ct]) }}"
                                            method="GET"
                                            class="flex flex-col sm:flex-row items-center justify-start space-y-4 sm:space-y-0 space-x-0 sm:space-x-4 mb-4 mt-4 mr-2">
                                            <input type="hidden" name="id_ct"
                                                value="{{ $id_ct }}">
                                            <div class="form-group">
                                                <label for="fecha_inicio" class="text-white">Fecha de
                                                    inicio:</label>
                                                <input type="date" id="fecha_inicio"
                                                    name="fecha_inicio"
                                                    class="border border-gray-400 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                    max="{{ date('Y-m-d') }}"
                                                    style="background-color: transparent;">
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_fin" class="text-white">Fecha de
                                                    fin:</label>
                                                <input type="date" id="fecha_fin" name="fecha_fin"
                                                    class="border border-slate-900 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                    max="{{ date('Y-m-d') }}"
                                                    style="background-color: transparent;">
                                            </div>
                                            <button type="submit"
                                                class="btn btn-outline-info ml-2 mb-0 text-white"
                                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                        </form>
                                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white  mb-2"
                                                style="
                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <!-- Contenido de S1 -->
                                                <div class="overflow-x-auto">
                                                    {{-- CONTENIDO AQUI --}}
                                                    <h1 class="text-center text-2xl" style="color: white;">
                                                        EVENTOS CT </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    
                                                    <div class="container">
                                                        @if (count($resultadosQ23) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableAlertasCt"
                                                                    class="w-full text-white text-center ">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                CONCENTRADOR</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                HORA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                DESCRIPCIÓN EVENTO</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                INFORMACIÓN ADICIONAL 1</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                INFORMACIÓN ADICIONAL 2</th>




                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ23 as $resultado)
                                                                            <tr class="highlight-row ">
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->id_cnc) ? $resultado->id_cnc : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->fecha) ? $resultado->fecha : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->hor_evento) ? $resultado->hor_evento : 'No hay datos' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->des_evento_dc) ? $resultado->des_evento_dc : 'No hay datos' }}
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
                                                        @else
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                <p class="mt-0 text-xl  text-center"
                                                                    style="color:rgb(88,226,194)">No hay
                                                                    datos
                                                                </p>
                                                            </div>
                                                        @endif
                                                        <!-- Contenedor del botón de descarga -->
                                                        <div class="text-right mt-4">
                                                            <input type="button"
                                                                onclick="tableToExcel('testTableAlertasCt', 'W3C Example Table')"
                                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- SEGUNDA FILA --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            {{-- Gráfico de 48 horas --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl m-2"
                                                    style="color: white; display: flex; align-items: center; justify-content: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                        height="30" viewBox="0 0 128 128">
                                                        <path fill="#F2A600"
                                                            d="m57.16 8.42l-52 104c-1.94 4.02-.26 8.85 3.75 10.79c1.08.52 2.25.8 3.45.81h104c4.46-.04 8.05-3.69 8.01-8.15a8.123 8.123 0 0 0-.81-3.45l-52-104a8.067 8.067 0 0 0-14.4 0" />
                                                        <path fill="#FFCC32"
                                                            d="m53.56 15.72l-48.8 97.4c-1.83 3.77-.25 8.31 3.52 10.14c.99.48 2.08.74 3.18.76h97.5a7.55 7.55 0 0 0 7.48-7.62a7.605 7.605 0 0 0-.78-3.28l-48.7-97.4a7.443 7.443 0 0 0-9.93-3.47a7.484 7.484 0 0 0-3.47 3.47" />
                                                        <path fill="#424242"
                                                            d="M64.36 34.02c4.6 0 8.3 3.7 8 8l-3.4 48c-.38 2.54-2.74 4.3-5.28 3.92a4.646 4.646 0 0 1-3.92-3.92l-3.4-48c-.3-4.3 3.4-8 8-8m0 64c3.31 0 6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6s2.69-6 6-6"
                                                            opacity=".2" />
                                                        <linearGradient id="IconifyId18fa00b9c17e9a3a40"
                                                            x1="68" x2="68" y1="-1808.36"
                                                            y2="-1887.05"
                                                            gradientTransform="matrix(1 0 0 -1 -3.64 -1776.09)"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop offset="0" stop-color="#424242" />
                                                            <stop offset="1" stop-color="#212121" />
                                                        </linearGradient>
                                                        <path fill="url(#IconifyId18fa00b9c17e9a3a40)"
                                                            d="M64.36 34.02c4.6 0 8.3 3.7 8 8l-3.4 48c-.38 2.54-2.74 4.3-5.28 3.92a4.646 4.646 0 0 1-3.92-3.92l-3.4-48c-.3-4.3 3.4-8 8-8" />
                                                        <linearGradient id="IconifyId18fa00b9c17e9a3a41"
                                                            x1="64.36" x2="64.36" y1="-1808.36"
                                                            y2="-1887.05"
                                                            gradientTransform="matrix(1 0 0 -1 0 -1772.11)"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop offset="0" stop-color="#424242" />
                                                            <stop offset="1" stop-color="#212121" />
                                                        </linearGradient>
                                                        <circle cx="64.36" cy="104.02" r="6"
                                                            fill="url(#IconifyId18fa00b9c17e9a3a41)" />
                                                        <path fill="#FFF170"
                                                            d="M53.56 23.02c-1.2 1.5-21.4 41-21.4 41s-1.8 3 .7 4.7c2.3 1.6 4.4-.3 5.3-1.8s19.2-36.9 19.9-38.6c.6-1.87.18-3.91-1.1-5.4c-1.3-1.2-2.6-1-3.4.1" />
                                                        <circle cx="31.36" cy="75.33" r="3.3"
                                                            fill="#FFF170" />
                                                    </svg>








                                                    <style>
                                                        .popover-trigger {
                                                            position: relative;
                                                            display: inline-block;
                                                            cursor: pointer;
                                                        }
                                                       
                                                        .popover-content {
                                                            display: none;
                                                            position: absolute;
                                                            background-color: #2f3237;
                                                            border: 1px solid #000000;
                                                            border-radius: 20px;
                                                            padding: 10px; /* Ajusta el padding según sea necesario */
                                                            z-index: 1;
                                                            white-space: nowrap;
                                                            bottom: 100%; /* Position above the trigger */
                                                            left: 50%;
                                                            transform: translateX(-50%);
                                                            font-size: 16px; /* Ajusta el tamaño de la fuente si es necesario */
                                                        }
                                                       
                                                        .popover-trigger:hover .popover-content {
                                                            display: block;
                                                        }
                                                       
                                                        .popover-content > svg {
                                                            vertical-align: middle; /* Alinea verticalmente los íconos con el texto */
                                                            margin-right: 5px; /* Espacio entre el ícono y el texto */
                                                            display: inline-block; /* Asegura que el ícono se comporte como un elemento en línea */
                                                            line-height: 1; /* Ajusta la altura de la línea para evitar desalineación */
                                                        }
                                                       
                                                        .popover-content span {
                                                            display: flex; /* Utiliza flexbox para alinear los íconos y el texto verticalmente */
                                                            align-items: center; /* Alinea verticalmente los íconos y el texto */
                                                            margin-bottom: 5px; /* Espacio entre las líneas del texto */
                                                        }
                                                       
                                                       
                                                       
                                                            </style>
                                                         <p class="ml-2">
                                                            <span id="info" class="popover-trigger">
                                                                ALERTAS CT
                                                                <span class="popover-content">
                                                         
                                                                    <svg class="circle-icon" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                                        <circle r="8" cx="8" cy="8" fill="yellow" />
                                                                    </svg>
                                                                   
                                                                        Gravedad 1 <br><br>
                                                                   
                                                                   
                                                                        <svg class="circle-icon" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                                            <circle r="8" cx="8" cy="8" fill="orange" />
                                                                        </svg>
                                                                        Gravedad 2<br><br>
                                                                   
                                                                   
                                                                        <svg class="circle-icon" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                                            <circle r="8" cx="8" cy="8" fill="red" />
                                                                        </svg>
                                                                       Gravedad 3
                                                                </span>
                                                            </span>
                                                        </p>
                                                            <script src="scripts.js"></script>
                                                       
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                {{-- CONTENIDO AQUI --}}
                                                <div class="container">
                                                    @if (count($resultadosQ24) > 0)
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableAlertasCt"
                                                                class="w-full text-white text-center  ">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            CONCENTRADOR</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            FECHA</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            HORA</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            DESCRIPCIÓN ALERTA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($resultadosQ24 as $resultado)
                                                                        @php
                                                                            $row_color = '';
                                                                            $darken_color = '';
                                                                            if (!empty($resultado->cod_gravedad_dc)) {
                                                                                switch ($resultado->cod_gravedad_dc) {
                                                                                    case 1:
                                                                                        $row_color =
                                                                                            'linear-gradient(to bottom, rgba(247, 229, 59, 0.7), rgba(227, 207, 0, 0.9))'; // AMARILLO
                                                                                        $darken_color =
                                                                                            'rgba(227, 207, 0, 0.9)'; // AMARILLO oscurecido
                                                                                        break;
                                                                                    case 2:
                                                                                        $row_color =
                                                                                            'linear-gradient(to bottom, rgba(255, 140, 0, 0.7), rgba(204, 112, 0, 1))'; // NARANJA
                                                                                        $darken_color =
                                                                                            'rgba(204, 112, 0, 1)'; // NARANJA oscurecido
                                                                                        break;
                                                                                    case 3:
                                                                                        $row_color =
                                                                                            'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))'; // ROJO
                                                                                        $darken_color =
                                                                                            'rgba(206, 60, 73, 0.9)'; // ROJO oscurecido
                                                                                        break;
                                                                                    default:
                                                                                        $row_color = ''; // Si no coincide con ningún caso, no aplicar color
                                                                                        $darken_color = '';
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <tr class="highlight-row ">
                                                                            <td class="py-2 text-white">
                                                                                {{ !empty($resultado->id_cnc) ? $resultado->id_cnc : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2 text-white">
                                                                                {{ !empty($resultado->fecha) ? $resultado->fecha : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2 text-white">
                                                                                {{ !empty($resultado->hor_alerta_dc) ? $resultado->hor_alerta_dc : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2 text-white"
                                                                                style="background: {{ $row_color }};
                                                                               "
                                                                                onmouseover="this.style.background='{{ $darken_color }}';"
                                                                                onmouseout="this.style.background='{{ $row_color }}';">
                                                                                {{ !empty($resultado->des_evento) ? $resultado->des_evento : 'No hay datos' }}
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
                                                    <!-- Contenedor del botón de descarga -->
                                                    <div class="text-right mt-4">
                                                        <input type="button"
                                                            onclick="tableToExcel('testTableAlertasCt', 'W3C Example Table')"
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
            {{-- FIN CUERPO --}}
        </div>
    </div>
</body>












