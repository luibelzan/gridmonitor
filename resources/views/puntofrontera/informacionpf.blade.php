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
    {{-- JAVASCRIPT --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!--icono cargando -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


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




    <title>Información de PF</title>
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
                        <a href="{{ route('dashboardpf') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacionpf', ['id_cnt' => $id_cnt]) }}" class="nav-item is-active "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('curvashorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Curvas horarias</a>
                        @if ($id_cnt && !empty($mostrarcurvascuartihorarias) && $mostrarcurvascuartihorarias[0]->curva_1 == 1)
                            <a href="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                                active-color="rgb(88, 226, 194">Curvas Cuartihorarias</a>
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
                                action="{{ route('informacionpf', ['id_cnt' => $id_cnt]) }}" method="GET">
                                <select name="id_cnt" class="form-control mt-2" onchange="this.form.submit()"
                                    style="color: white; background-color: rgb(27, 32, 38); width: 200px; font-size: 14px; text-align: left;">
                                    {{-- Si hay un id_cnt seleccionado en la sesión, mostrarlo seleccionado --}}
                                    @if ($id_cnt)
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un Punto</option>
                                        @foreach ($parametros as $cnt)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $cnt->id_cnt }}"
                                                {{ $selected_cnt == $cnt->id_cnt ? 'selected' : '' }}>
                                                {{ $cnt->cups }}
                                            </option>
                                        @endforeach
                                        {{-- Si no hay un id_cnt seleccionado en la sesión, mostrar la opción "Seleccione un CT" --}}
                                    @else
                                        <option class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" value="" disabled selected
                                            style="color: rgb(27, 32, 38);">Seleccione un Punto</option>
                                        @foreach ($parametros as $cnt)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $cnt->id_cnt }}">
                                                {{ $cnt->cups }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- INICIO BODY DE LA VISTA --}}
                    @if ($id_cnt)
                        @if (count($resultadosQ1pf) === 0)
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">INFORMACIÓN DEL P.F</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>




                            {{-- CONTENEDOR CUERPO --}}
                            <div class="container ">
                                @foreach ($parametros as $cnt)
                                    @if ($cnt->id_cnt == $id_cnt)
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                                            {{-- 1º cuadro --}}
                                            {{-- PL1_1 --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">
                                                    DATOS CONTADOR
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Nro. De Serie -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Nº De
                                                                    Serie
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->id_cnt) ? $resultadosQ1pf[0]->id_cnt : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para fabricante -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Fabricante
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ7pf) > 0 && !empty($resultadosQ7pf[0]->fabricante) ? $resultadosQ7pf[0]->fabricante : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Relación Transformadores Tensión -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Trafos
                                                                    Tensión
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->rel_trafos_tension) ? $resultadosQ1pf[0]->rel_trafos_tension : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Relación Transformadores Intensidad -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Trafos
                                                                    Intensidad</h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->rel_trafos_intensidad) ? $resultadosQ1pf[0]->rel_trafos_intensidad : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- 2º cuadro --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">
                                                    DATOS DE COMUNICACIONES
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Direccion de Enlace -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Dir. Enlace
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->direnlace) ? $resultadosQ1pf[0]->direnlace : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para PM -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Dir. Pm
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->pm) ? $resultadosQ1pf[0]->pm : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Contraseña -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Password
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->password) ? $resultadosQ1pf[0]->password : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Tipo de Conexión -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Tipo de
                                                                    Conexión</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->conx_name) ? $resultadosQ1pf[0]->conx_name : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <!-- Cuadrado para Número / IP -->
                                                        <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                            <h2 class="text-sm text-center font-normal">Número / IP
                                                            </h2>
                                                            <p class="mt-4 text-sm  text-center"
                                                                style="color:rgb(88,226,194);">
                                                                {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->conx_info) ? $resultadosQ1pf[0]->conx_info : 'No hay datos' }}
                                                            </p>
                                                            <div
                                                                style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- 3º cuadro --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">
                                                    DATOS DEL PUNTO DE MEDIDA </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para del Tipo del Punto de Medida -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Tipo de
                                                                    Punto
                                                                    de Medida</h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->tip_punto_medida) ? $resultadosQ1pf[0]->tip_punto_medida : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para del ID del Punto de Medida -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">
                                                                    Identificador
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->id_punto_medida) ? $resultadosQ1pf[0]->id_punto_medida : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para cups -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Cups</h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->cups) ? $resultadosQ1pf[0]->cups : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Descripcion -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Descripción
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->description) ? $resultadosQ1pf[0]->description : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para Direccion Física -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Dirección
                                                                    Física</h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 && !empty($resultadosQ1pf[0]->dir_punto_medida) ? $resultadosQ1pf[0]->dir_punto_medida : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <!-- Cuadrado para del Longitud y Latitud del Punto de Medida -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Latitud /
                                                                    Longitud</h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ1pf) > 0 &&
                                                                    !empty($resultadosQ1pf[0]->lon_punto_medida) &&
                                                                    !empty($resultadosQ1pf[0]->lat_punto_medida)
                                                                        ? $resultadosQ1pf[0]->lon_punto_medida . '/' . $resultadosQ1pf[0]->lat_punto_medida
                                                                        : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- 4º cuadro Fechas --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">
                                                    FECHAS </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <!-- Columna 1 -->
                                                        <div class="col-md">
                                                            <!-- Cuadrado para Fecha Última Cierre -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Fecha
                                                                    Último
                                                                    Cierre</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ2pf) > 0 && !empty($resultadosQ2pf[0]->fecha_ultima_cierre)
                                                                        ? $resultadosQ2pf[0]->fecha_ultima_cierre
                                                                        : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Columna 2 -->
                                                        <div class="col-md">
                                                            <!-- Cuadrado para Fecha Última Curva -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Fecha
                                                                    Última
                                                                    Curva</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ3pf) > 0 && !empty($resultadosQ3pf[0]->fecha_ultima_curva)
                                                                        ? $resultadosQ3pf[0]->fecha_ultima_curva
                                                                        : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Columna 3 -->
                                                        <div class="col-md">
                                                            <!-- Cuadrado para Fecha Último Evento -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Fecha
                                                                    Último
                                                                    Evento</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ4pf) > 0 && !empty($resultadosQ4pf[0]->fecha_ultimo_evento)
                                                                        ? $resultadosQ4pf[0]->fecha_ultimo_evento
                                                                        : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>


                                        {{-- SEGUNDA FILA --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-2 mb-6">
                                            {{-- GRÁFICO CONSUMOS MENSUALES - GRAFICO DE BARRAS --}}
                                            <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">ENERGÍA MENSUAL</h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <h2 class="text-center text-1xl mt-2" style="color: white;">
                                                        Últimos 12
                                                        meses</h2>
                                                    <div class="table-responsive w-full"
                                                        style="display: flex; justify-content: center;">

                                                        {{-- GRÁFICO DE CONSUMOS MENSUALES --}}
                                                        <div class="grafico-wrapper"
                                                            style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                            <canvas id="graficoBarrasConsumoCups"
                                                                class="w-full"></canvas>
                                                        </div>
                                                    </div>
                                                    {{-- SCRIPT PARA EL GRÁFICO DE CONSUMOS MENSUALES --}}
                                                    <script>
    var labels_fecha = [];
    var values_contratos = {}; // Objeto para agrupar datos por fecha y contrato

    @foreach ($resultadosQ26pf as $resultado)
        var fecha = '{{ $resultado->Fecha_Inicio }}';

        // Si la fecha no está en labels_fecha, agregarla
        if (!labels_fecha.includes(fecha)) {
            labels_fecha.push(fecha);
            // Inicializar para cada contrato
            values_contratos[fecha] = { 1: null, 2: null, 3: null };
        }

        // Asignar el valor de energía al contrato correspondiente
        values_contratos[fecha][{{ $resultado->Contrato }}] = {{ $resultado->Energia_Activa_Incremental }};
    @endforeach

    document.addEventListener("DOMContentLoaded", function() {
        var data = [{
            label: 'Contrato 1',
            backgroundColor: 'rgba(88, 226, 194, 0.5)',
            borderColor: 'rgba(88, 226, 194, 0.9)',
            borderWidth: 1,
            // Mapeamos las fechas para obtener los valores del contrato 1
            data: labels_fecha.map(fecha => values_contratos[fecha][1])
        }, {
            label: 'Contrato 2',
            backgroundColor: 'rgba(171, 38, 194, 0.5)',
            borderColor: 'rgba(171, 38, 194, 0.9)',
            borderWidth: 1,
            // Mapeamos las fechas para obtener los valores del contrato 2
            data: labels_fecha.map(fecha => values_contratos[fecha][2])
        }, {
            label: 'Contrato 3',
            backgroundColor: 'rgba(255, 159, 64, 0.5)',
            borderColor: 'rgba(255, 159, 64, 0.8)',
            borderWidth: 1,
            // Mapeamos las fechas para obtener los valores del contrato 3
            data: labels_fecha.map(fecha => values_contratos[fecha][3])
        }];

        var ctx = document.getElementById('graficoBarrasConsumoCups').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels_fecha, // Fechas agrupadas sin repetición
                datasets: data
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0)' // Quitar rejilla en eje x
                        },
                        ticks: {
                            color: 'white',
                            font: {
                                family: 'Didact Gothic',
                                weight: 'normal'
                            }
                        },
                        barPercentage: 1.0,
                        categoryPercentage: 1.0
                    },
                    y: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0)' // Quitar rejilla en eje y
                        },
                        ticks: {
                            color: 'white',
                            callback: function(value) {
                                return value.toFixed(0) + " kWh";
                            },
                            font: {
                                family: 'Didact Gothic',
                                weight: 'normal'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'white',
                            font: {
                                family: 'Didact Gothic',
                                weight: 'normal'
                            }
                        },
                        onClick: function(e, legendItem) {
                            var index = legendItem.datasetIndex;
                            var chart = this.chart;
                            var dataset = chart.data.datasets[index];
                            dataset.hidden = !dataset.hidden;
                            chart.update();
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
                        color: '',
                        font: {
                            family: 'Didact Gothic',
                            weight: 'normal'
                        },
                        anchor: 'center',
                        align: 'end',
                        formatter: function(value) {
                            return value + " \nkWh";
                        }
                    }
                }
            },
        });
    });
</script>





                                                </div>
                                                {{-- </div> --}}
                                            </div>
                                            {{-- GRÁFICO MAXIMETROS --}}
                                            <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">MAXÍMETROS</h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <h2 class="text-center text-1xl mt-2" style="color: white;">
                                                        Últimos 12
                                                        meses</h2>
                                                    <div class="table-responsive w-full"
                                                        style="display: flex; justify-content: center;">

                                                        {{-- GRÁFICO DE VALORES MAXÍMETROS --}}
                                                        <div class="grafico-wrapper"
                                                            style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                            <canvas id="graficoBarrasMaximetros"
                                                                class="w-full"></canvas>
                                                        </div>
                                                    </div>
                                                    {{-- SCRIPT PARA EL GRÁFICO DE MAXIMETROS --}}

                                                    <script>
                                                        var labels_fecha_max = [];
                                                        var values_val_maximetro = [];
                                                        @foreach ($resultadosQ27pf as $resultado)
                                                            // Agregar la fecha en formato dd-mm-yy
                                                            labels_fecha_max.push('{{ $resultado->Fecha }} ');
                                                            // Agregar el valor de energía formateado en kWh
                                                            values_val_maximetro.push({{ $resultado->Maximetros }});
                                                        @endforeach



                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            var ctx = document.getElementById('graficoBarrasMaximetros').getContext('2d');
                                                            var myChart = new Chart(ctx, {
                                                                type: 'bar',
                                                                data: {
                                                                    labels: labels_fecha_max,
                                                                    datasets: [{
                                                                        label: 'Maxímetros últimos 12 meses',
                                                                        backgroundColor: function(context) {
                                                                            var gradient = context.chart.ctx.createLinearGradient(0, 0, 400,
                                                                                0); // Gradiente horizontal
                                                                            gradient.addColorStop(0,
                                                                                'rgba(238, 145, 4, 0.9)'); // Color inicial con opacidad 0.9
                                                                            gradient.addColorStop(0.5,
                                                                                'rgba(238, 145, 4, 0.5)'); // Color en la mitad del gradiente
                                                                            gradient.addColorStop(1,
                                                                                'rgba(238, 145, 4, 0.1)'); // Color final con opacidad 0.1
                                                                            return gradient;
                                                                        },
                                                                        borderColor: 'rgba(238, 145, 4, 0.9)',
                                                                        borderWidth: 1,
                                                                        data: values_val_maximetro
                                                                    }]
                                                                },
                                                                options: {
                                                                    responsive: true,
                                                                    maintainAspectRatio: false,
                                                                    indexAxis: 'y', // Esta línea indica que las barras se mostrarán horizontalmente
                                                                    scales: {
                                                                        x: {
                                                                            grid: {
                                                                                color: 'rgba(0, 0, 0, 0)'
                                                                            },
                                                                            ticks: {
                                                                                color: 'white', // Color blanco para las etiquetas del eje x
                                                                                callback: function(value, index, values) {
                                                                                    return value.toFixed(2) + " kW";
                                                                                },
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
                                                                                return value + " kW";
                                                                            }
                                                                        },
                                                                        annotation: {
                                                                            annotations: {
                                                                                line1: {
                                                                                    type: 'line',

                                                                                    borderColor: 'rgb(248,73,90)',
                                                                                    borderWidth: 1,
                                                                                    label: {
                                                                                        content: 'Potencia Contratada',
                                                                                        enabled: true,
                                                                                        position: 'top'
                                                                                    }
                                                                                }
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
                                            {{-- GRÁFICO PERIODOS TARIFARIOS - CIRCULO --}}
                                            <div class="card text-white mb-2 col-span-2 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">CONSUMOS POR
                                                    PERIODOS TARIFARIOS</h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <h2 class="text-center text-1xl mt-2" style="color: white;">
                                                        Últimos 12 meses</h2>
                                                    <div class="p-4 #205E86 text-white rounded-lg shadow-xl mt-10">
                                                        {{-- GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                                        <canvas id="graficoContratos"></canvas>
                                                    </div>

                                                    <div id="toggleContrato1"
                                                        style="text-align: center; margin-bottom: 10px;">
                                                        <button id="btnContrato1" style="margin-right: 10px;">Contrato
                                                            1</button>
                                                        <button id="btnContrato2" style="margin-right: 10px;">Contrato
                                                            2</button>
                                                        <button id="btnContrato3">Contrato 3</button>
                                                    </div>

                                                    <script>
                                                        var dataContrato1 = [];
                                                        var dataContrato2 = [];
                                                        var dataContrato3 = [];
                                                        var labelsPeriodo = [];
                                                        var totalContrato1 = 0;
                                                        var totalContrato2 = 0;
                                                        var totalContrato3 = 0;

                                                        // Calcular totales por contrato
                                                        @foreach ($resultadosQ28pf as $resultado)
                                                            if ({{ $resultado->Contrato }} == 1) {
                                                                totalContrato1 += {{ $resultado->Energia_Activa_Incremental }};
                                                            } else if ({{ $resultado->Contrato }} == 2) {
                                                                totalContrato2 += {{ $resultado->Energia_Activa_Incremental }};
                                                            } else if ({{ $resultado->Contrato }} == 3) {
                                                                totalContrato3 += {{ $resultado->Energia_Activa_Incremental }};
                                                            }
                                                        @endforeach

                                                        // Llenar datos por contrato
                                                        @foreach ($resultadosQ28pf as $resultado)
                                                            var porcentaje = 0;
                                                            if ({{ $resultado->Contrato }} == 1 && {{ $resultado->Energia_Activa_Incremental }} != 0) {
                                                                porcentaje = ({{ $resultado->Energia_Activa_Incremental }} / totalContrato1) * 100;
                                                                dataContrato1.push({
                                                                    label: 'Periodo {{ $resultado->Periodo_Tarifario }}: {{ $resultado->Energia_Activa_Incremental }} kWh',
                                                                    value: {{ $resultado->Energia_Activa_Incremental }},
                                                                    percentage: porcentaje.toFixed(2)
                                                                });
                                                            } else if ({{ $resultado->Contrato }} == 2 && {{ $resultado->Energia_Activa_Incremental }} != 0) {
                                                                porcentaje = ({{ $resultado->Energia_Activa_Incremental }} / totalContrato2) * 100;
                                                                dataContrato2.push({
                                                                    label: 'Periodo {{ $resultado->Periodo_Tarifario }}: {{ $resultado->Energia_Activa_Incremental }} kWh',
                                                                    value: {{ $resultado->Energia_Activa_Incremental }},
                                                                    percentage: porcentaje.toFixed(2)
                                                                });
                                                            } else if ({{ $resultado->Contrato }} == 3 && {{ $resultado->Energia_Activa_Incremental }} != 0) {
                                                                porcentaje = ({{ $resultado->Energia_Activa_Incremental }} / totalContrato3) * 100;
                                                                dataContrato3.push({
                                                                    label: 'Periodo {{ $resultado->Periodo_Tarifario }}: {{ $resultado->Energia_Activa_Incremental }} kWh',
                                                                    value: {{ $resultado->Energia_Activa_Incremental }},
                                                                    percentage: porcentaje.toFixed(2)
                                                                });
                                                            }

                                                            // Evitar duplicar los periodos tarifarios en las etiquetas
                                                            if (!labelsPeriodo.includes('{{ $resultado->Periodo_Tarifario }}')) {
                                                                labelsPeriodo.push('{{ $resultado->Periodo_Tarifario }}');
                                                            }
                                                        @endforeach

                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            var ctx = document.getElementById('graficoContratos').getContext('2d');
                                                            var myChart = new Chart(ctx, {
                                                                type: 'doughnut',
                                                                data: {
                                                                    labels: dataContrato1.map(item => item.label), // Usando dataContrato1 para los labels
                                                                    datasets: [{
                                                                            label: 'Contrato 1',
                                                                            data: dataContrato1.map(item => item.value),
                                                                            backgroundColor: [
                                                                                'rgb(248,73,90)', // Rojo
                                                                                'rgb(88,226,194)', // Azul
                                                                                'RGB(247,229,59)', // Amarillo
                                                                                'rgb(147,195,96)', // Verde
                                                                                'rgb(171,38,194)', // Morado
                                                                                'rgba(255,159,64,0.9)', // Naranja
                                                                                'rgba(204,0,204,0.9)', // Violeta
                                                                                'rgba(255,193,7,0.9)', // Naranja amarillento
                                                                            ],
                                                                            borderWidth: 0 // Eliminar el borde blanco
                                                                        },
                                                                        {
                                                                            label: 'Contrato 2',
                                                                            data: dataContrato2.map(item => item.value),
                                                                            backgroundColor: [
                                                                                'rgb(200,0,0)', // Rojo oscuro
                                                                                'rgb(0,150,150)', // Azul oscuro
                                                                                'rgb(200,200,0)', // Amarillo oscuro
                                                                                'rgb(100,150,50)', // Verde oscuro
                                                                                'rgb(100,0,100)', // Morado oscuro
                                                                                'rgba(200,100,0,0.9)', // Naranja oscuro
                                                                                'rgba(150,0,150,0.9)', // Violeta oscuro
                                                                                'rgba(200,150,0,0.9)', // Naranja amarillento oscuro
                                                                            ],
                                                                            borderWidth: 0 // Eliminar el borde blanco
                                                                        },
                                                                        {
                                                                            label: 'Contrato 3',
                                                                            data: dataContrato3.map(item => item.value),
                                                                            backgroundColor: [
                                                                                'rgb(150,0,0)', // Rojo muy oscuro
                                                                                'rgb(0,100,100)', // Azul muy oscuro
                                                                                'rgb(150,150,0)', // Amarillo muy oscuro
                                                                                'rgb(50,100,30)', // Verde muy oscuro
                                                                                'rgb(50,0,50)', // Morado muy oscuro
                                                                                'rgba(150,70,0,0.9)', // Naranja muy oscuro
                                                                                'rgba(100,0,100,0.9)', // Violeta muy oscuro
                                                                                'rgba(150,100,0,0.9)', // Naranja amarillento muy oscuro
                                                                            ],
                                                                            borderWidth: 0 // Eliminar el borde blanco
                                                                        }
                                                                    ]
                                                                },
                                                                options: {
                                                                    maintainAspectRatio: false,
                                                                    responsive: true,
                                                                    cutout: '70%', // Disminuye este valor para que las porciones sean más anchas
                                                                    plugins: {
                                                                        legend: {
                                                                            display: false, // Esto desactiva la leyenda
                                                                        },
                                                                        tooltip: {
                                                                            callbacks: {
                                                                                label: function(context) {
                                                                                    var contrato = context.dataset.label;
                                                                                    var porcentaje = '';
                                                                                    if (context.datasetIndex === 0) {
                                                                                        porcentaje = dataContrato1[context.dataIndex].percentage + '%';
                                                                                    } else if (context.datasetIndex === 1) {
                                                                                        porcentaje = dataContrato2[context.dataIndex].percentage + '%';
                                                                                    } else {
                                                                                        porcentaje = dataContrato3[context.dataIndex].percentage + '%';
                                                                                    }
                                                                                    return contrato + ': ' + porcentaje;
                                                                                }
                                                                            }
                                                                        },
                                                                        datalabels: {
                                                                            anchor: "outside",
                                                                            color: "white",
                                                                            font: {
                                                                                family: 'Didact Gothic',
                                                                                size: 20,
                                                                                weight: "bold"
                                                                            },
                                                                            textStrokeColor: 'black',
                                                                            textStrokeWidth: 2,
                                                                            formatter: (value, ctx) => {
                                                                                if (ctx.datasetIndex === 0) {
                                                                                    return dataContrato1[ctx.dataIndex].percentage + '%';
                                                                                } else if (ctx.datasetIndex === 1) {
                                                                                    return dataContrato2[ctx.dataIndex].percentage + '%';
                                                                                } else {
                                                                                    return dataContrato3[ctx.dataIndex].percentage + '%';
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    rotation: -0.5 * Math.PI
                                                                },
                                                                plugins: [ChartDataLabels]
                                                            });

                                                            // Funciones para mostrar solo el contrato seleccionado
                                                            function showOnlyDataset(index) {
                                                                myChart.data.datasets.forEach((dataset, i) => {
                                                                    dataset.hidden = i !== index; // Mostrar solo el dataset seleccionado
                                                                });
                                                                myChart.update();
                                                            }

                                                            document.getElementById('btnContrato1').addEventListener('click', function() {
                                                                showOnlyDataset(0);
                                                            });

                                                            document.getElementById('btnContrato2').addEventListener('click', function() {
                                                                showOnlyDataset(1);
                                                            });

                                                            document.getElementById('btnContrato3').addEventListener('click', function() {
                                                                showOnlyDataset(2);
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>







                                        </div>










                                        {{-- TERCERA FILA --}} {{-- PL3 --}}
                                        {{-- SELECTOR DE FECHAS --}}
                                        <form action="{{ route('informacionpf', ['id_cnt' => $id_cnt]) }}"
                                            method="GET"
                                            class="flex items-center justify-start space-x-4 mb-4 mt-4 mr-2 ">
                                            <input type="hidden" name="id_cnt" value="{{ $id_cnt }}">
                                            <div class="form-group">
                                                <label for="fecha_inicio" class="text-white">Fecha de
                                                    inicio:</label>
                                                <input type="date" id="fecha_inicio" name="fecha_inicio"
                                                    class="border border-gray-400 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_fin" class="text-white">Fecha de
                                                    fin:</label>
                                                <input type="date" id="fecha_fin" name="fecha_fin"
                                                    class="border border-slate-900 p-2 rounded-lg text-white"
                                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                    max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                                <button type="submit"
                                                    class="btn btn-outline-info ml-2 mb-1 text-white"
                                                    style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                    onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                    onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                            </div>
                                        </form>
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">




                                            <div class="card text-white  mb-2"
                                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">
                                                    CIERRES MENSUALES </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>




                                                <!-- Contenido de PL3 -->




                                                <div class="table-responsive"
                                                    style="display: flex; justify-content: center;">
                                                    <div class="overflow-x-auto">
                                                        <div class="container">
                                                            @if (count($resultadosQ6pf) > 0)
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                    style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                    <table id="testTableCierresMensuales"
                                                                        class="w-full text-white text-center">
                                                                        <thead
                                                                            style="border-bottom: 1px solid #ffffff;">
                                                                            <tr>
                                                                                <th class="m-4 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Cups</th>
                                                                                <th class="m-4 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Contador</th>
                                                                                <th class="m-4 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Contrato</th>
                                                                                <th class="mt-0 small  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Periodo Tarifario</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Fecha Inicio</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Fecha<br> Fin</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía<br>Activa Absoluta
                                                                                </th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Activa<br>
                                                                                    Incremental
                                                                                </th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Activa</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Inductiva
                                                                                    Absoluta
                                                                                </th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Inductiva
                                                                                    Incremental</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Reactiva
                                                                                    Inductiva
                                                                                </th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Capacitiva
                                                                                    Absoluta
                                                                                </th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Energía Reactiva Capacitiva
                                                                                    Incremental</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Reactiva
                                                                                    Capacitiva
                                                                                </th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Excesos de Potencias</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Excesos</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Maxímetros</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Fecha Maxímetros</th>
                                                                                <th class="mt-0 small text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Bit Calidad Maxímetros</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($resultadosQ6pf as $resultado)
                                                                                <tr class="highlight-row ">
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->CUPS) ? $resultado->CUPS : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Contrato) ? $resultado->Contrato : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Periodo_Tarifario) ? $resultado->Periodo_Tarifario : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Fecha_Inicio) ? $resultado->Fecha_Inicio : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Fecha_Fin) ? $resultado->Fecha_Fin : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Energia_Activa_Absoluta) ? $resultado->Energia_Activa_Absoluta : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Energia_Activa_Incremental) ? $resultado->Energia_Activa_Incremental : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Bit_Calidad_Activa) ? $resultado->Bit_Calidad_Activa : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Inductiva_Absoluta) ? $resultado->Energia_Reactiva_Inductiva_Absoluta : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Inductiva_Incremental) ? $resultado->Energia_Reactiva_Inductiva_Incremental : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Bit_Calidad_Reactiva_Inductiva) ? $resultado->Bit_Calidad_Reactiva_Inductiva : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Capacitiva_Absoluta) ? $resultado->Energia_Reactiva_Capacitiva_Absoluta : '0' }}
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Energia_Reactiva_Capacitiva_Incremental) ? $resultado->Energia_Reactiva_Capacitiva_Incremental : '0' }}
                                                                                    </td>
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Bit_Calidad_Reactiva_Capacitiva) ? $resultado->Bit_Calidad_Reactiva_Capacitiva : '0' }}
                                                                                    </td>
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Excesos_de_Potencias) ? $resultado->Excesos_de_Potencias : '0' }}
                                                                                    </td>
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Bit_Calidad_Excesos) ? $resultado->Bit_Calidad_Excesos : '0' }}
                                                                                    </td>
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Maximetros) ? $resultado->Maximetros : '0' }}
                                                                                    </td>
                                                                                    </td>
                                                                                    <td class="py-6 small">
                                                                                        {{ !empty($resultado->Fecha_Maximetros) ? $resultado->Fecha_Maximetros : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-2">
                                                                                        {{ !empty($resultado->Bit_Calidad_Maximetros) ? $resultado->Bit_Calidad_Maximetros : '0' }}
                                                                                    </td>
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
                                                                    onclick="tableToExcel('testTableCierresMensuales', 'W3C Example Table')"
                                                                    style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        {{-- LOG DE COMUNICACIONES --}}
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white  mb-2"
                                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl" style="color: white;">
                                                    LOG DE COMUNICACIONES </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                                                         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>


                                                <!-- Contenido de PL2 -->
                                                <div class="table-responsive"
                                                    style="display: flex; justify-content: center;">
                                                    <div class="overflow-x-auto">
                                                        <div class="container">
                                                            @if (count($resultadosQ5pf) > 0)
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                    style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                    <table id="testTableBajaDisponibilidad"
                                                                        class="w-full text-white text-center">
                                                                        <thead
                                                                            style="border-bottom: 1px solid #ffffff;">
                                                                            <tr>
                                                                                <th class="mr-0  pl-4 text-xl text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Contador</th>
                                                                                <th class="mt-0   pl-4 text-xl text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Ts</th>
                                                                                <th class="mt-0  pl-4 text-xl text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    Logs</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($resultadosQ5pf as $resultado)
                                                                                <tr class="highlight-row ">
                                                                                    <td class="py-2 pl-4">
                                                                                        {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-2 pl-4">
                                                                                        {{ !empty($resultado->ts) ? $resultado->ts : 'No hay datos' }}
                                                                                    </td>
                                                                                    <td class="py-2 pl-6">
                                                                                        {{ !empty($resultado->log) ? $resultado->log : 'No hay datos' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                                    <p class="mt-0 text-xl  text-center"
                                                                        style="color:rgb(88,226,194)">No hay datos
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
