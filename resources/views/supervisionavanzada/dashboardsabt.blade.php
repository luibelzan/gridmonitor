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

    <title>Dashboard</title>
</head>

<body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center"
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

        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white">
            @include('includes/header')
            <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14">
                <div class="lg:ml-14 p-2 mt-0 w-full">
                    <!-- Content -->
                     <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                        {{-- Botones de arriba --}}
                        <x-nav-sabt/>
                        <h1 class="text-center text-3xl w-full" style="color: white;">Dashboard SABT</h1>
                        <div style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                        </div>

                        <div class="container">
                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                                <div class="container">
                                    <div class="table-responsive" style="display: flex; justify-content: center;">
                                        <div class="overflow-x-auto w-full">
                                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                                                {{-- FILTRO FECHAS --}}
                                                <div class="container ">
                                                    <form
                                                        action="{{ route('dashboardsabt') }}"
                                                        method="GET"
                                                        class="flex flex-wrap items-center justify-start gap-2 mt-6">
                                                        {{-- buscador por nombre --}}
                                                        <div class="form-group flex items-center">
                                                            <input type='text' name='nom_ct' placeholder='Buscar por nombre'
                                                                class='border p-2 rounded-md w-52 ml-1 text-white'
                                                                style='background-color: transparent; border-color: rgb(255, 255, 255);'
                                                                @if (isset($_GET['nom_ct'])) value="{{ $_GET['nom_ct'] }}" @endif>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-outline-info mb-3 text-white"
                                                            style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                            onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                            onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                                <div class="card text-white mb-2" 
                                                    style="
                                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <div class="container">
                                                        @if (isset($dashboardSABTInfo))
                                                                <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                                    style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                                    <table id="testTableEventosCups"
                                                                        class="w-full text-white text-center ">
                                                                        <thead
                                                                            style="border-bottom: 1px solid #ffffff;">
                                                                            <tr>
                                                                                <th class="mt-0 text-xl  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    ID CT</th>
                                                                                <th class="mt-0 text-xl  text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    NOMBRE CT</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    TRAFOS</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    LINEAS</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    CONTADORES</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    FASE R</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    FASE S</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    FASE T</th>
                                                                                <th class="mt-0 text-xl font-bold text-center"
                                                                                    style="color:rgb(88,226,194)">
                                                                                    RTU ID</th>
                                                                            </tr>
                                                                        </thead>


                                                                        <tbody>
                
                                                                                @foreach ($dashboardSABTInfo as $resultado)
                                                                                    <tr class="highlight-row ">
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->id_ct) ? $resultado->id_ct : 'No hay datos' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            @if(!empty($resultado->nom_ct) && !empty($resultado->id_ct))
                                                                                                <a href="{{ route('supervisionavanzada', ['id_ct' => $resultado->id_ct]) }}">
                                                                                                    {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                                                                </a>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_trafos) ? $resultado->nro_trafos : '0' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_lineas) ? $resultado->nro_lineas : '0' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_contadores) ? $resultado->nro_contadores : '0' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_contadores_r) ? $resultado->nro_contadores_r : '0' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_contadores_s) ? $resultado->nro_contadores_s : '0' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_contadores_t) ? $resultado->nro_contadores_t : '0' }}
                                                                                        </td>
                                                                                        <td class="py-2">
                                                                                            {{ !empty($resultado->nro_contadores_3) ? $resultado->nro_contadores_3 : '0' }}
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
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    
    
    
</body>




</html>