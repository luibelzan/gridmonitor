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
            padding: 20px;
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




        /* Color al pasar el raton por encima de la fila de datos */
        .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */


        }


        /* Asegura que el encabezado de la tabla esté siempre visible y por encima del contenido */
        thead th {
            position: sticky;
            top: -24px;
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
        function tableToExcel2Cols(tableID, filename = '') {
            var tab_text = "<table border='2px'>";
            var textRange;
            var j = 0;
            var table = document.getElementById(tableID);
            for (j = 0; j < table.rows.length; j++) {
                tab_text = tab_text + table.rows[j].innerHTML + "</tr>";
                //tab_text=tab_text+"</tr>";
            }
            tab_text = tab_text + "</table>";
            var ua = window.navigator.userAgent;
            var msieEdge = ua.indexOf("Edge");
            if (msieEdge > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                txtArea1.document.open("txt/html", "replace");
                txtArea1.document.write(tab_text);
                txtArea1.document.close();
                txtArea1.focus();
                sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
            } else
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            return (sa);
        }
    </script>
    <title>Inicio CT</title>
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
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14 ">
                    {{-- Botones de arriba --}}
                    {{-- CUERPO AQUI --}}
                    <h1 class="text-center text-3xl w-full" style="color: white;">DASHBOARD</h1>
                    <div
                        style="border-bottom: 3px solid transparent;
                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                    </div>
                    <div class="container ">
                        {{-- PRIMERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                            {{-- 1º cuadro --}}
                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    TRAFOS
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Número de trafos</h2>
                                                <p class="mt-4 text-3xl text-center"
                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                        height="40" viewBox="0 0 24 24" style="margin-right: 10px;">
                                                        <path fill="rgb(88,226,194)"
                                                            d="M6 3a2 2 0 0 0-2 2v11h2v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h6v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h2V5a2 2 0 0 0-2-2zm6 4V5h6v2zm0 2h6v2h-6zM8 5v4h2l-3 6v-4H5zm14 15v2H2v-2z" />
                                                    </svg>
                                                    {{ count($resultadosQ1dashboard) > 0 && !empty($resultadosQ1dashboard[0]->nro_trafos) ? $resultadosQ1dashboard[0]->nro_trafos : '0' }}
                                                    {{-- <img src="../../images/transformador.png" style="height: 50px; width: 50px; vertical-align: middle; margin-left: 10px;"> --}}


                                                </p>








                                            </div>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Capacidad instalada</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ1dashboard) > 0 && !empty($resultadosQ1dashboard[0]->cap_kva) ? $resultadosQ1dashboard[0]->cap_kva : '0' }}
                                                    KVA
                                                </p>
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
                                    CUPS / CONTADORES
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col ">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Número de Cups</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ2dashboard) > 0 && !empty($resultadosQ2dashboard[0]->nro_cups) ? $resultadosQ2dashboard[0]->nro_cups : '0' }}
                                                </p>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Número de Autoconsumos</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ22dashboard) > 0 && !empty($resultadosQ22dashboard[0]->nro_cups) ? $resultadosQ22dashboard[0]->nro_cups : '0' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Contadores PRIME</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ3dashboard) > 0 && !empty($resultadosQ3dashboard[0]->contadores_prime) ? $resultadosQ3dashboard[0]->contadores_prime : '0' }}
                                                </p>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                            </div>
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">Otros</h2>
                                                <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                    {{ count($resultadosQ4dashboard) > 0 && !empty($resultadosQ4dashboard[0]->contadores_otros) ? $resultadosQ4dashboard[0]->contadores_otros : '0' }}
                                                </p>
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
                                    LECTURAS / PLC</h1> {{-- rgb(76,218,19 --}}
                                <h2 class="text-center text-1xl" style="color: white;"> AL
                                    {{ count($resultadosQ6dashboard) > 0 && !empty($resultadosQ6dashboard[0]->fecha) ? $resultadosQ6dashboard[0]->fecha : '' }}
                                </h2>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                <h2 class="text-sm text-center font-normal">% Contadores Activos</h2>
                                                @php
                                                    $color = 'rgb(222,54,63)'; // Rojo por defecto
                                                    $por_contadores_activos =
                                                        count($resultadosQ5dashboard) > 0 &&
                                                        !empty($resultadosQ5dashboard[0]->por_contadores_activos)
                                                            ? $resultadosQ5dashboard[0]->por_contadores_activos
                                                            : 0;
                                                    if ($por_contadores_activos >= 80 && $por_contadores_activos < 95) {
                                                        $color = 'rgb(255,155,0)'; // Naranja
                                                    } elseif ($por_contadores_activos >= 95) {
                                                        $color = 'rgb(76,218,19)'; // Verde
                                                    }
                                                @endphp <p class="mt-4 text-3xl text-center"
                                                    style="color:{{ $color }}; display: flex; justify-content: center; align-items: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                        height="40" viewBox="0 0 20 20" style="margin-right: 10px;">
                                                        <path fill="{{ $color }}"
                                                            d="M5 2a2 2 0 0 0-2 2v5.6a5.5 5.5 0 0 1 1-.393V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2.6a5.5 5.5 0 0 1-.657 1H13a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 3.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM6 6v1h6V6zm10 0h.5a.5.5 0 0 1 .5.5V8a.5.5 0 0 1-.5.5H16zm0 3.5h.5a.5.5 0 0 1 .5.5v1.5a.5.5 0 0 1-.5.5H16zm0 3.5h.5a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H16zm-6 1.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0m-5.631.84c.16 0 .28.15.243.307l-.238 1.006c-.063.269.243.46.435.27l2.565-2.53c.262-.259.089-.723-.27-.723h-.236a.25.25 0 0 1-.239-.325l.309-.979c.057-.18-.07-.366-.25-.366H4.86a.26.26 0 0 0-.243.171l-1.096 2.783c-.073.184.055.386.242.386z" />
                                                    </svg> {{ $por_contadores_activos }} %










                                                </p>
                                            </div>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="flex justify-around items-center mx-0 m-2 text-white">
                                                {{-- primer cuadrado --}}
                                                <div class="flex flex-col items-center ">
                                                    <h3 class="text-sm text-center font-normal mb-0">
                                                        S05</h3>
                                                    <h5 class="text-sm text-center font-normal mb-0">
                                                        <br>
                                                    </h5>
                                                    <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194), rgb(55, 139, 119));">
                                                        <p class="text-2xl font-bold text-white">
                                                            {{ count($resultadosQ6dashboard) > 0 && !empty($resultadosQ6dashboard[0]->lect_s05_hoy) ? $resultadosQ6dashboard[0]->lect_s05_hoy : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- segundo cuadrado --}}
                                                <div class="flex flex-col items-center  ">
                                                    <h3 class="text-sm text-center font-normal mb-0">
                                                        S04</h3>
                                                    <h5 class="text-sm text-center font-normal mb-0">
                                                        {{ count($resultadosQ7dashboard) > 0 && !empty($resultadosQ7dashboard[0]->fec_lectura) ? $resultadosQ7dashboard[0]->fec_lectura : '0' }}
                                                    </h5>
                                                    <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                        style="background: linear-gradient(135deg,rgba(88,226,194), rgb(55, 139, 119));">
                                                        <p class="text-2xl font-bold text-white">
                                                            {{ count($resultadosQ7dashboard) > 0 && !empty($resultadosQ7dashboard[0]->lect_s04_mes) ? $resultadosQ7dashboard[0]->lect_s04_mes : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- tercer cuadrado --}}
                                                <div class="flex flex-col items-center ">
                                                    <h3 class="text-sm text-center font-normal mb-0">
                                                        S02</h3>
                                                    <h5 class="text-sm text-center font-normal mb-0">
                                                        <br>
                                                    </h5>
                                                    <div class="w-14 h-14 rounded-md flex justify-center items-center"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194), rgb(55, 139, 119));">
                                                        <p class="text-2xl font-bold text-white">
                                                            {{ count($resultadosQ8dashboard) > 0 && !empty($resultadosQ8dashboard[0]->lect_s02_hoy) ? $resultadosQ8dashboard[0]->lect_s02_hoy : '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- SEGUNDA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            {{-- 1º cuadro --}}



                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    ESTADÍSTICAS POR C.T
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    @if (count($resultadosQ9dashboard) > 0)
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                            <table id="testTableEstadisticasCt" class="w-full text-white text-center">
                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                    <tr>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            NOMBRE CT</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            FECHA LECTURA</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            LECTURAS S02 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            % S02 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            LECTURAS S05 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            % S05 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            LECTURAS S04 </th>
                                                        <th class="mt-0  text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            % S04</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($resultadosQ9dashboard as $resultado)
                                                        <tr class="highlight-row ">
                                                            <td class="py-2">
                                                                {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->fec_lectura) ? $resultado->fec_lectura : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->total_ct) ? $resultado->total_ct : '0' }}
                                                                /
                                                                {{ !empty($resultado->lec_s02_hoy) ? $resultado->lec_s02_hoy : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->porcentaje_s02) ? $resultado->porcentaje_s02 : '0' }}
                                                                %
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->total_ct) ? $resultado->total_ct : '0' }}
                                                                /
                                                                {{ !empty($resultado->lec_s05_hoy) ? $resultado->lec_s05_hoy : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->porcentaje_s05) ? $resultado->porcentaje_s05 : '0' }}
                                                                %
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->total_ct) ? $resultado->total_ct : '0' }}
                                                                /
                                                                {{ !empty($resultado->lec_s04_hoy) ? $resultado->lec_s04_hoy : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->porcentaje_s04) ? $resultado->porcentaje_s04 : '0' }}
                                                                %
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                            <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No
                                                hay
                                                datos
                                            </p>
                                        </div>
                                    @endif
                                    <!-- Contenedor del botón de descarga -->
                                    <div class="text-right mt-4">
                                        <input type="button"
                                            onclick="tableToExcel('testTableEstadisticasCt', 'W3C Example Table')"
                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TERCERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            {{-- 1º cuadro --}}
                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    RECUPERACIÓN DE LECTURAS
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                        @php
                                            // Combinar todas las fechas de ambas consultas
                                            $fechas = array_unique(
                                                array_merge(
                                                    array_column($resultadosQ12dashboard, 'fec_lectura'),
                                                    array_column($resultadosQ10dashboard, 'fec_lectura'),
                                                ),
                                            );
                                            // Ordenar las fechas
                                            sort($fechas);
                                        @endphp @if (!empty($fechas))
                                            <table id="testTableRecuperacionLecturas"
                                                class="w-full text-white text-center">
                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                    <!-- Fila de fechas -->
                                                    <tr>
                                                        <th></th>
                                                        @foreach ($fechas as $fecha)
                                                            <th colspan="2"
                                                                class="mt-0 text-xl font-bold text-center border-r border-l"
                                                                style="color:rgb(88,226,194); padding: 10px; text-align: center;">
                                                                <div
                                                                    style="display: inline-flex; align-items: center; justify-content: center;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="20" height="20"
                                                                        viewBox="0 0 24 24"
                                                                        style="margin-right: 5px; vertical-align: middle;">
                                                                        <g fill="none">
                                                                            <rect width="18" height="15" x="3"
                                                                                y="6" stroke="#ffffff"
                                                                                stroke-width="2" rx="2" />
                                                                            <path fill="#ffffff"
                                                                                d="M3 10c0-1.886 0-2.828.586-3.414C4.172 6 5.114 6 7 6h10c1.886 0 2.828 0 3.414.586C21 7.172 21 8.114 21 10z" />
                                                                            <path stroke="#ffffff"
                                                                                stroke-linecap="round"
                                                                                stroke-width="2" d="M7 3v3m10-3v3" />
                                                                            <rect width="4" height="2" x="7"
                                                                                y="12" fill="#ffffff"
                                                                                rx=".5" />
                                                                            <rect width="4" height="2" x="7"
                                                                                y="16" fill="#ffffff"
                                                                                rx=".5" />
                                                                            <rect width="4" height="2" x="13"
                                                                                y="12" fill="#ffffff"
                                                                                rx=".5" />
                                                                            <rect width="4" height="2" x="13"
                                                                                y="16" fill="#ffffff"
                                                                                rx=".5" />
                                                                        </g>
                                                                    </svg>
                                                                    <span>{{ !empty($fecha) ? date('d/m/Y', strtotime($fecha)) : 'No hay datos' }}</span>
                                                                </div>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                    <!-- Fila de subcolumnas S02 y S05 -->
                                                    <tr>
                                                        <th></th>
                                                        @foreach ($fechas as $fecha)
                                                            <th class="mt-0 text-xl font-bold text-center border-l"
                                                                style="color:rgb(88,226,194); padding: 10px">S02</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-r"
                                                                style="color:rgb(88,226,194); padding: 10px">S05</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        // Inicializar arrays para almacenar los datos
                                                        $tp_counts_s02 = [];
                                                        $tp_counts_s05 = [];
                                                        $stg_counts_s02 = [];
                                                        $stg_counts_s05 = [];
                                                        $totales_s02 = [];
                                                        $totales_s05 = [];
                                                        // Procesar datos de resultadosQ12dashboard (para S02)
                                                        foreach ($resultadosQ12dashboard as $resultado) {
                                                            if (is_object($resultado)) {
                                                                $fecha = $resultado->fec_lectura;
                                                                $tp_counts_s02[$fecha] = $resultado->tp_count;
                                                                $stg_counts_s02[$fecha] = $resultado->stg_count;
                                                                $totales_s02[$fecha] =
                                                                    ($resultado->tp_count ?? 0) +
                                                                    ($resultado->stg_count ?? 0);
                                                            }
                                                        }
                                                        // Procesar datos de resultadosQ10dashboard (para S05)
                                                        foreach ($resultadosQ10dashboard as $resultado) {
                                                            if (is_object($resultado)) {
                                                                $fecha = $resultado->fec_lectura;
                                                                $tp_counts_s05[$fecha] = $resultado->tp_count;
                                                                $stg_counts_s05[$fecha] = $resultado->stg_count;
                                                                $totales_s05[$fecha] =
                                                                    ($resultado->tp_count ?? 0) +
                                                                    ($resultado->stg_count ?? 0);
                                                            }
                                                        }
                                                    @endphp
                                                    <!-- Primera fila: valores de TP -->
                                                    <tr class="highlight-row ">
                                                        <td class="border-r">Tareas Prog.</td>
                                                        @foreach ($fechas as $fecha)
                                                            <td class="py-2">
                                                                {{ !empty($tp_counts_s02[$fecha]) ? $tp_counts_s02[$fecha] : '0' }}
                                                            </td>
                                                            <td class="py-2 border-r">
                                                                {{ !empty($tp_counts_s05[$fecha]) ? $tp_counts_s05[$fecha] : '0' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <!-- Segunda fila: sumas totales -->
                                                    <tr class="highlight-row ">
                                                        <td class="border-r">Total</td>
                                                        @foreach ($fechas as $fecha)
                                                            <td class="py-2">
                                                                {{ !empty($totales_s02[$fecha]) ? $totales_s02[$fecha] : '0' }}
                                                            </td>
                                                            <td class="py-2 border-r">
                                                                {{ !empty($totales_s05[$fecha]) ? $totales_s05[$fecha] : '0' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <!-- Tercera fila: valores de STG -->
                                                    <tr class="highlight-row ">
                                                        <td class="border-r">Recuperadas</td>
                                                        @foreach ($fechas as $fecha)
                                                            <td class="py-2">
                                                                {{ !empty($stg_counts_s02[$fecha]) ? $stg_counts_s02[$fecha] : '0' }}
                                                            </td>
                                                            <td class="py-2 border-r">
                                                                {{ !empty($stg_counts_s05[$fecha]) ? $stg_counts_s05[$fecha] : '0' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="mt-0 text-xl font-bold text-center"
                                                style="color:rgb(88,226,194); padding: 10px">No hay datos disponibles
                                                para mostrar.</p>
                                        @endif
                                    </div>
                                    <!-- Contenedor del botón de descarga -->
                                    <div class="text-right mt-4">
                                        <input type="button"
                                            onclick="tableToExcel2Cols('testTableRecuperacionLecturas', 'W3C Example Table')"
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
