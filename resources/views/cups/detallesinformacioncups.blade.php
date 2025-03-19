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
    <title>Información CUPS</title>
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
                            class="nav-item is-active" active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('detallescurvashorariascups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Curvas Horarias</a>
                        <a href="{{ route('consumodiariocups', ['id_cups' => $id_cups, 'id_cnt' => $id_cnt]) }}" class="nav-item"
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">INFORMACIÓN CUPS</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>


                            {{-- PRIMERA FILA --}}
                            <div class="container">
                                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2 mb-6">
                                    {{-- CONTENEDOR CUERPO --}}
                                    {{-- <div class="container"> --}}
                                    {{-- CAJA 1 --}}
                                    @foreach ($resultadosQ1cups as $resultado)
                                        <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <h1 class="text-center text-2xl" style="color: white;">DATOS CUPS</h1>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            {{-- <div class="container"> --}}
                                            <div class="row">
                                                <div class="col">
                                                    <!-- Cuadrado para ID CUPS -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">CUPS</h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->id_cups) ? $resultado->id_cups : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Código Póliza -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Póliza</h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->cod_poliza) ? $resultado->cod_poliza : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Nombre CUPS -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Nombre</h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->nom_cups) ? $resultado->nom_cups : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Dirección CUPS -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Dirección
                                                            suministro
                                                        </h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Nombre CT -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Nombre CT
                                                        </h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- LINEA CENTRAL --}}
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <!-- Cuadrado para CP CUPS -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Código Postal</h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->cp_cups) ? $resultado->cp_cups : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Estado CUPS -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Estado </h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->cups_estado) ? $resultado->cups_estado : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Tipo Tarifa -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Tarifa</h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->tip_tarifa) ? $resultado->tip_tarifa : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Potencia Contratada -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Potencia Contratada
                                                        </h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->val_potencia_contratada) ? $resultado->val_potencia_contratada : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Indicador Autoconsumo -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Autoconsumo
                                                        </h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->ind_autoconsumo) ? $resultado->ind_autoconsumo : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <!-- Cuadrado para Indicador Maximetro -->
                                                    <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                        <h2 class="text-sm text-center font-normal">Maxímetro
                                                        </h2>
                                                        <p class="mt-2 text-sm  text-center"
                                                            style="color:rgb(88,226,194);">
                                                            {{ !empty($resultado->ind_maximetro) ? $resultado->ind_maximetro : 'No hay datos' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                        </div>
                                    @endforeach
                                    {{-- </div> --}}
                                    {{-- <div class="container"> --}}
                                    {{-- CAJA 2 --}}
                                    <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">DATOS CONTADOR</h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        @if (!empty($resultadosQ2cups))
                                            @foreach ($resultadosQ2cups as $resultado)
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para ID CNT -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Contador
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->id_cnt) ? $resultado->id_cnt : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col"> <!-- Cuadrado para Modelo -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Modelo</h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->mod_cnt) ? $resultado->mod_cnt : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Descripción TE-->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Tipo de
                                                                    Equipo
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->des_te) ? $resultado->des_te : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Nombre del Fabricante -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Fabricante
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->nom_fabricante) ? $resultado->nom_fabricante : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Descripción del Contador AF-->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Año de
                                                                    Fabricación
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->des_cnt_af) ? $resultado->des_cnt_af : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- LINEA CENTRAL --}}
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                     border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para Versión del Firmware DLMS -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Firmware
                                                                    DLMS
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->fw_dlms_cnt) ? $resultado->fw_dlms_cnt : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Versión del Firmware Prime -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Firmware
                                                                    Prime
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->fw_prime_cnt) ? $resultado->fw_prime_cnt : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Número de Fases -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Número de
                                                                    Fases
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->num_fases) ? $resultado->num_fases : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Tipo de Contador -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Tipo de P.M
                                                                </h2>
                                                                <p class="mt-2 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ !empty($resultado->tipo_cnt) ? $resultado->tipo_cnt : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="mt-4 text-xl  text-center" style="color:rgb(88,226,194);">
                                                No hay datos
                                            </p>
                                        @endif
                                    </div>
                                    {{-- </div> --}}
                                </div>

                                {{-- SEGUNDA FILA --}}
                                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-2 mb-6">
                                    {{-- GRÁFICO CONSUMOS MENSUALES - GRAFICO DE BARRAS --}}
                                    <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">CONSUMOS</h1>
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
                                                    <canvas id="graficoBarrasConsumoCups" class="w-full"></canvas>
                                                </div>
                                            </div>
                                            {{-- SCRIPT PARA EL GRÁFICO DE CONSUMOS MENSUALES --}}
                                            <script>
                                                var labels_fecha = [];
                                                var values_ai_m = [];
                                                @foreach ($resultadosQ3cups as $resultado)
                                                    // Agregar la fecha en formato dd-mm-yy
                                                    labels_fecha.push('{{ $resultado->fec_inicio }}');
                                                    // Agregar el valor de energía formateado en kWh
                                                    values_ai_m.push({{ $resultado->val_ai_m }});
                                                @endforeach
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    var labels = labels_fecha;
                                                    var data = [{
                                                        label: 'Consumo últimos 12 meses',
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
                                                        data: values_ai_m
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
                                    {{-- GRÁFICO MAXIMETROS --}}
                                    <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">MAXÍMETROS</h1>
                                        <div
                                            style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div class="container">
                                            <h2 class="text-center text-1xl mt-2" style="color: white;">Últimos 12
                                                meses</h2>
                                            <div class="table-responsive w-full"
                                                style="display: flex; justify-content: center;">

                                                {{-- GRÁFICO DE VALORES MAXÍMETROS --}}
                                                <div class="grafico-wrapper"
                                                    style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                    <canvas id="graficoBarrasMaximetros" class="w-full"></canvas>
                                                </div>
                                            </div>
                                            {{-- SCRIPT PARA EL GRÁFICO DE MAXIMETROS --}}

                                            <script>
                                                var labels_fecha_max = [];
                                                var values_val_maximetro = [];
                                                @foreach ($resultadosQ27cups as $resultado)
                                                    // Agregar la fecha en formato dd-mm-yy
                                                    labels_fecha_max.push('{{ $resultado->fecha }} {{ $resultado->hora }}');
                                                    // Agregar el valor de energía formateado en kWh
                                                    values_val_maximetro.push({{ $resultado->val_maximetro }});
                                                @endforeach

                                                // Obtener el valor de potencia contratada desde las consultas Blade
                                                var val_potencia_contratada = null;
                                                @foreach ($resultadosQ1cups as $resultado)
                                                    val_potencia_contratada = {{ $resultado->val_potencia_contratada }};
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
                                                                            xMin: val_potencia_contratada,
                                                                            xMax: val_potencia_contratada,
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
                                    <div class="card text-white mb-2 col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-1"
                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                        <h1 class="text-center text-2xl" style="color: white;">CONSUMOS POR PERIODOS
                                            TARIFARIOS</h1>
                                        <div
                                            style="border-bottom: 3px solid transparent;
                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <div class="container">
                                            <h2 class="text-center text-1xl mt-2" style="color: white;">Últimos 12
                                                meses
                                            </h2>
                                            <div class="p-4 #205E86 text-white rounded-lg shadow-xl mt-10">
                                                {{-- GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                                <canvas id="graficoCircularPeriodoTarifario"></canvas>
                                            </div>
                                            {{-- SCRIPT PARA EL GRÁFICO DE POR PERIODOS TARIFARIOS --}}
                                            <script>
                                                var data = [];
                                                var total = 0;
                                                @foreach ($resultadosQ4cups as $resultado)
                                                    total += {{ $resultado->val_ai_m }};
                                                @endforeach
                                                @foreach ($resultadosQ4cups as $resultado)
                                                    @if ($resultado->val_ai_m != 0)
                                                        var porcentaje = ({{ $resultado->val_ai_m }} / total) * 100;
                                                        data.push({
                                                            label: 'Periodo {{ $resultado->cod_periodotarifa }}: {{ $resultado->val_ai_m }} kWh',
                                                            value: {{ $resultado->val_ai_m }},
                                                            percentage: porcentaje.toFixed(2)
                                                        });
                                                    @endif
                                                @endforeach
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    var ctx = document.getElementById('graficoCircularPeriodoTarifario').getContext('2d');
                                                    var myChart = new Chart(ctx, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: data.map(item => item.label),
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
                                    {{-- </div> --}}
                                    {{-- </div> --}}

                                    {{-- TERCERA FILA --}}
                                    {{-- <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-2 mb-6"> --}}

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
                                                        REGISTROS MENSUALES </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                                        {{-- FILTRO FECHAS --}}
                                                        <form
                                                            action="{{ route('detallesinformacioncups', ['id_cups' => $id_cups]) }}"
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
                                                        @if (count($resultadosQ5cups) > 0)
                                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                <table id="testTableEventos"
                                                                    class="w-full text-white text-center  ">
                                                                    <thead style="border-bottom: 1px solid #ffffff;">
                                                                        <tr>
                                                                            <th class="mt-0 text-xl  text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                CONTADOR</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                FECHA</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                PERIODO</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL AI M</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL AE M</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R1 M</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R2 M</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R3 M</th>
                                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                                style="color:rgb(88,226,194)">
                                                                                VAL R4 M</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($resultadosQ5cups as $resultado)
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
                                                                                    {{ !empty($resultado->val_ai_m) ? $resultado->val_ai_m : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_ae_m) ? $resultado->val_ae_m : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r1_m) ? $resultado->val_r1_m : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r2_m) ? $resultado->val_r2_m : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r3_m) ? $resultado->val_r3_m : '0' }}
                                                                                </td>
                                                                                <td class="py-2">
                                                                                    {{ !empty($resultado->val_r4_m) ? $resultado->val_r4_m : '0' }}
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
                                                                    hay datos
                                                                </p>
                                                            </div>
                                                        @endif
                                                        <!-- Contenedor del botón de descarga -->
                                                        <div class="text-right mt-4">
                                                            <input type="button"
                                                                onclick="tableToExcel('testTableEventos', 'W3C Example Table')"
                                                                style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
