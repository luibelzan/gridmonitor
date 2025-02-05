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








        a {
            text-decoration: none !important;
        }








        /* PARA EL NAV */
        * {
            box-sizing: border-box;
        }








        /* body {
            text-align: center;
            display: flex;
            height: 100vh;
            width: 100%;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            /* background-image: url("https://www.toptal.com/designers/subtlepatterns/patterns/debut_light.png"); */
        /* } */
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








        /* CSS PARA LOS GRAFICOS */
        #primeraFila,
        #segundaFila,
        #terceraFila {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 0;
        }


        @media (min-width: 1600px) {


            #primeraFila,
            #segundaFila,
            #terceraFila {
                grid-template-columns: repeat(6, 1fr);
            }
        }
    </style>
    <script>
        window.onload = function() {
            updateChartVoltajeProm1(prom_volt1_data);
            updateChartVoltajeProm2(prom_volt2_data);
            updateChartVoltajeProm3(prom_volt3_data);
            updateChartDesequilibrioVoltaje(avg_pct_deseq_voltaje)
        };
    </script>
    <title>Energía</title>
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
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white">
        @include('includes/header')
        <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full" style="height: 100%; ">
                <!-- Añadir margen superior -->
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14 ">
                    {{-- Botones de arriba --}}
                    <nav class="nav mb-12 ">
                        <a href="{{ route('dashboardct') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacionct', ['id_ct' => $id_ct]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('energia', ['id_ct' => $id_ct]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Energía</a>
                        <a href="{{ route('señalplc', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194">Lecturas/Señal PLC</a>
                        @foreach ($ct_info as $ct)
                            @if ($ct->id_ct == $id_ct && $ct->ind_balance == true)
                                <a href="{{ route('balances', ['id_ct' => $id_ct]) }}" class="nav-item"
                                    active-color="rgb(88, 226, 194">Balances</a>
                            @endif
                        @endforeach
                        <a href="{{ route('eventosct', ['id_ct' => $id_ct]) }}" class="nav-item"
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
                                action="{{ route('energia', ['id_ct' => $id_ct]) }}" method="GET">
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
                    @if ($id_ct)
                        @php
                            // Filtrar para encontrar el CT seleccionado
                            $selected_ct_info = $ct_info->filter(function ($ct) use ($id_ct) {
                                return $ct->id_ct == $id_ct;
                            });
                        @endphp








                        @if ($selected_ct_info->isEmpty())
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">CALIDAD DE ENERGÍA</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                            @foreach ($ct_info as $ct)
                                @if ($ct->id_ct == $id_ct)
                                    {{-- CONTENEDOR CUERPO --}}
                                    <div class="container">


                                        {{-- PRIMERA FILA --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-2">
                                            <div class="col-span-1 md:col-span-1">
                                                <div class="card text-white  mb-3"
                                                    style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                    <h1 class="text-center text-2xl" style="color: white;">RESUMEN DE
                                                        EVENTOS
                                                    </h1>
                                                    <h1 class="text-center text-1xl mb-2" style="color: white;"> (Mes
                                                        actual)
                                                    </h1>
                                                    <div
                                                        style="border-bottom: 3px solid transparent;
                                             border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                    </div>
                                                    <div class="m-4"
                                                        style="display: flex; justify-content: center;">
                                                        <div class="container">
                                                            <div class="row ">
                                                                <div class="col-md">
                                                                    <!-- Cuadrado para Sobretensiones -->
                                                                    <div
                                                                        class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                        <h2 class="text-sm text-center font-normal">
                                                                            Sobretensiones</h2>
                                                                        <p class="mt-0 text-{{ count($resultadosQ11) > 0 && !empty($resultadosQ11[0]->sobre_tensiones) ? '3xl' : '1xl' }} text-center"
                                                                            style="color:rgb(190, 83, 223)">
                                                                            {{ count($resultadosQ11) > 0 && !empty($resultadosQ11[0]->sobre_tensiones) ? number_format($resultadosQ11[0]->sobre_tensiones, 0, '.', '.') : 'No hay datos' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md">
                                                                    <div
                                                                        class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                        <h2 class="text-sm text-center font-normal">
                                                                            Subtensiones</h2>
                                                                        <p class="mt-0 text-{{ count($resultadosQ9) > 0 && !empty($resultadosQ9[0]->sub_tensiones) ? '3xl' : '1xl' }} text-center"
                                                                            style="color:rgb(76,218,19)">
                                                                            {{ count($resultadosQ9) > 0 && !empty($resultadosQ9[0]->sub_tensiones) ? number_format($resultadosQ9[0]->sub_tensiones, 0, '.', '.') : 'No hay datos' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md">
                                                                    <!-- Cuadrado para Cortes de Tensión -->
                                                                    <div
                                                                        class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                        <h2 class="text-sm text-center font-normal">
                                                                            Cortes
                                                                            de tensión</h2>
                                                                        <p class="mt-0 text-{{ count($resultadosQ10) > 0 && !empty($resultadosQ10[0]->cortes_tension) ? '3xl' : '1xl' }} text-center"
                                                                            style="color:{{ count($resultadosQ10) > 0 && !empty($resultadosQ10[0]->cortes_tension) ? 'rgb(222,54,63)' : 'rgb(222,54,63)' }}">
                                                                            {{ count($resultadosQ10) > 0 && !empty($resultadosQ10[0]->cortes_tension) ? number_format($resultadosQ10[0]->cortes_tension, 0, '.', '.') : 'No hay datos' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md">
                                                                    <!-- Cuadrado para Micro Cortes -->
                                                                    <div
                                                                        class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                        <h2 class="text-sm text-center font-normal">
                                                                            Micro
                                                                            cortes</h2>
                                                                        <p class="mt-0 text-{{ count($resultadosQ8) > 0 && !empty($resultadosQ8[0]->micro_cortes_tension) ? '3xl' : '1xl' }} text-center"
                                                                            style="color:rgb(255,155,0)">
                                                                            {{ count($resultadosQ8) > 0 && !empty($resultadosQ8[0]->micro_cortes_tension) ? number_format($resultadosQ8[0]->micro_cortes_tension, 0, '.', '.') : 'No hay datos' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>








                                        {{-- SEGUNDA FILA --}}
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-6 mb-2">
                                            {{-- 1º cuadro --}}
                                            <div class="row col-span-1">




                                                {{-- c3-1 --}}
                                                <div class="col">
                                                    <div class="card text-white mb-3 h-full w-full"
                                                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                        <h1 class="text-center text-2xl" style="color: white;">
                                                            CAPACIDAD DEL TRAFO
                                                        </h1>
                                                        <h2 class="text-center text-1xl" style="color: white;">
                                                            Último mes
                                                        </h2>
                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                        </div>




                                                        <!-- Cuadrado para Porcentaje de Uso de Capacidad del Trafo Mes Actual -->
                                                        <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                            @if (count($resultadosQ18) > 0)
                                                                {!! !empty($resultadosQ18[0]->val_kva)
                                                                    ? '<p class="mt-10 text-5xl text-center" style="color:rgb(88,226,194)">' . $resultadosQ18[0]->val_kva . ' kVA</p>'
                                                                    : '<p class="mt-20 text-1xl text-center" style="color:rgb(255,155,0)">No hay datos de kVA</p>' !!}




                                                                {!! !empty($resultadosQ18[0]->cap_instalada)
                                                                    ? '<p class="mt-10 text-5xl text-center" style="color:rgb(88,226,194)">' .
                                                                        number_format($resultadosQ18[0]->cap_instalada, 2) .
                                                                        '%</p>'
                                                                    : '<p class="mt-20 text-1xl text-center" style="color:rgb(255,155,0)">No hay datos de %</p>' !!}




                                                                {!! !empty($resultadosQ18[0]->mes)
                                                                    ? '<p class="mt-10 text-2xl text-center" style="color:rgb(88,226,194)">' .
                                                                        date('d/m/y', strtotime(substr($resultadosQ18[0]->mes, 0, 10))) .
                                                                        '</p>'
                                                                    : '<p class="mt-8 text-1xl text-center" style="color:rgb(255,155,0)">No hay datos de fecha</p>' !!}
                                                            @else
                                                                <p class="mt-0 text-1xl text-center"
                                                                    style="color:rgb(255,155,0)">No hay datos</p>
                                                            @endif
                                                        </div>




                                                    </div>
                                                </div>




                                            </div>
                                            <div class="row col-span-2">
                                                {{-- c3-2 --}}
                                                <div class="col">
                                                    <div class="card text-white  mb-0 h-full"
                                                        style="
                                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                        <h1 class="text-center text-2xl" style="color: white;">
                                                            % USO
                                                        </h1>
                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
                                                        </div>
                                                        <h2 class="text-center text-1xl mt-2 mb-2"
                                                            style="color: white;">
                                                            Capacidad último año
                                                        </h2>
                                                        <div class="table-responsive"
                                                            style="display: flex; justify-content: center;"
                                                            class="h-full">
                                                            <!-- Cuadrado para Porcentaje de Uso de
                                                                 Capacidad del Trafo Último Año -->
                                                            @if (count($resultadosQ19) > 0 && !empty($resultadosQ19[0]->cap_instalada))
                                                                <div class="grafico-wrapper"
                                                                    style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                                    {{-- GRAFICO DE BARRAS CAPACIDAD Último Año --}}
                                                                    <canvas id="graficoBarrasCapacidadAnio"
                                                                        class="w-full"></canvas>
                                                                    <script>
                                                                        document.addEventListener("DOMContentLoaded", function() {
                                                                            var labels_capacidad_anio = [];
                                                                            var values_capacidad_anio = [];

                                                                            @foreach ($resultadosQ19 as $resultado)
                                                                                var date = new Date('{{ $resultado->date_trunc_anio }}');
                                                                                var month = date.toLocaleString('default', {
                                                                                    month: 'short'
                                                                                });
                                                                                var year = date.getFullYear();
                                                                                var formattedDate = month + '-' + year;
                                                                                labels_capacidad_anio.push(formattedDate);
                                                                                values_capacidad_anio.push({{ round($resultado->cap_instalada) }});
                                                                            @endforeach

                                                                            // Agrega un valor de datos al 100%
                                                                            values_capacidad_anio.push(100);

                                                                            // Calcula el valor máximo de los datos y ajusta para agregar un margen
                                                                            var maxValue = Math.max(...values_capacidad_anio) * 1.1; // Incrementa el valor máximo en un 10%

                                                                            var ctx = document.getElementById('graficoBarrasCapacidadAnio').getContext('2d');
                                                                            var myChart = new Chart(ctx, {
                                                                                type: 'bar',
                                                                                data: {
                                                                                    labels: labels_capacidad_anio,
                                                                                    datasets: [{
                                                                                        label: ' ',
                                                                                        backgroundColor: function(context) {
                                                                                            var chartHeight = context.chart.height; // Altura del gráfico
                                                                                            var gradientStartY = chartHeight *
                                                                                                0.25; // Ajusta este valor para cambiar el punto de inicio del gradiente

                                                                                            var gradient = context.chart.ctx.createLinearGradient(0,
                                                                                                gradientStartY, 0, chartHeight);
                                                                                            gradient.addColorStop(0,
                                                                                                'rgba(88, 226, 194, 0.9)'); // Color inicial con opacidad 0.9
                                                                                            gradient.addColorStop(0.7,
                                                                                                'rgba(27,32,38, 0.7)'); // Nuevo color en la mitad del gradiente
                                                                                            gradient.addColorStop(1,
                                                                                                'rgba(27,32,38, 0)'
                                                                                            ); // Color final con opacidad 0 (transparente)

                                                                                            return gradient;
                                                                                        },
                                                                                        borderColor: 'rgba(88, 226, 194, 0.9)',
                                                                                        borderWidth: 1,
                                                                                        data: values_capacidad_anio
                                                                                    }]
                                                                                },
                                                                                options: {
                                                                                    responsive: true,
                                                                                    maintainAspectRatio: false,
                                                                                    scales: {
                                                                                        x: {
                                                                                            grid: {
                                                                                                display: false
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
                                                                                                color: function(context) {
                                                                                                    if (context.tick.value === 80) {
                                                                                                        return 'rgba(248,73,90, 0.5)';
                                                                                                    } else {
                                                                                                        return 'rgba(0, 0, 0, 0)';
                                                                                                    }
                                                                                                }
                                                                                            },
                                                                                            ticks: {
                                                                                                color: 'white',
                                                                                                beginAtZero: true,
                                                                                                callback: function(value) {
                                                                                                    return value + '%';
                                                                                                },
                                                                                                font: {
                                                                                                    family: 'Didact Gothic',
                                                                                                    weight: 'normal'
                                                                                                }
                                                                                            },
                                                                                            suggestedMax: maxValue // Establece el valor máximo sugerido en el eje y
                                                                                        }
                                                                                    },
                                                                                    plugins: {
                                                                                        legend: {
                                                                                            display: false
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
                                                                                                if (value !== 100) {
                                                                                                    return value + " %";
                                                                                                } else {
                                                                                                    return '';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    },
                                                                                    annotation: {
                                                                                        annotations: [{
                                                                                            type: 'line',
                                                                                            mode: 'horizontal',
                                                                                            scaleID: 'y',
                                                                                            borderColor: 'rgb(248,73,90)',
                                                                                            borderWidth: 2,
                                                                                            borderDash: [8, 4],
                                                                                            value: 80,
                                                                                        }]
                                                                                    }
                                                                                },
                                                                                plugins: [ChartDataLabels]
                                                                            });
                                                                        });
                                                                    </script>

                                                                </div>
                                                            @else
                                                                <div
                                                                    class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                    <p class="mt-0 text-xl font-bold text-center"
                                                                        style="color:rgb(232,80,107)">
                                                                        No hay datos
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-span-2">
                                                {{-- c4 --}}
                                                <div class="col">
                                                    <div class="card text-white  mb-0 h-full "
                                                        style="
                                                     background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                        <h1 class="text-center text-2xl" style="color: white;">ENERGÍA
                                                            DESPACHADA</h1>
                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                         border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                        </div>
                                                        <h2 class="text-center text-1xl mt-2" style="color: white;">
                                                            Últimos 7 días</h2>
                                                        @if (count($resultadosQ12) > 0 && !empty($resultadosQ12[0]->energia_importada_total))
                                                            <div class="table-responsive w-full"
                                                                style="display: flex; justify-content: center;">
                                                                <div class="grafico-wrapper"
                                                                    style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                                                                    {{-- GRÁFICO DE ENERGÍA DESPACHADA --}}
                                                                    <canvas id="graficoBarrasConsumo"
                                                                        class="w-full"></canvas>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="p-4 #205E86 text-white rounded-lg shadow-xl">
                                                                    <p class="mt-2 text-xl font-bold text-center"
                                                                        style="color:rgb(88,226,194)">No hay datos</p>
                                                                </div>
                                                        @endif
                                                    </div>
                                                    {{-- SCRIPT PARA EL GRÁFICO DE ENERGÍA DESPACHADA --}}
                                                    <script>
                                                        var labels_fecha_energia = [];
                                                        var values_energia_importada_total = [];

                                                        @if ($resultadosQ12 && count($resultadosQ12) > 0)
                                                            @foreach ($resultadosQ12 as $resultado)
                                                                @if (isset($resultado->fecha_energia) && isset($resultado->energia_importada_total))
                                                                    // Agregar la fecha en formato dd-mm-yy
                                                                    labels_fecha_energia.push('{{ date('d-m-y', strtotime($resultado->fecha_energia)) }}');
                                                                    // Agregar el valor de energía formateado en kWh
                                                                    values_energia_importada_total.push({{ $resultado->energia_importada_total }});
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            if (labels_fecha_energia.length > 0 && values_energia_importada_total.length > 0) {
                                                                var labels = labels_fecha_energia;
                                                                var maxValue = Math.max(...values_energia_importada_total) *
                                                                    1.1; // Incrementa el valor máximo en un 10%

                                                                var data = [{
                                                                    label: 'Consumo últimos 7 días',
                                                                    backgroundColor: function(context) {
                                                                        var chartHeight = context.chart.height; // Altura del gráfico
                                                                        var gradientStartY = chartHeight *
                                                                            0.25; // Ajusta este valor para cambiar el punto de inicio del gradiente

                                                                        var gradient = context.chart.ctx.createLinearGradient(0, gradientStartY, 0,
                                                                            chartHeight);
                                                                        gradient.addColorStop(0,
                                                                            'rgba(88, 226, 194, 0.9)'); // Color inicial con opacidad 0.9
                                                                        gradient.addColorStop(0.7,
                                                                            'rgba(27,32,38, 0.7)'); // Nuevo color en la mitad del gradiente
                                                                        gradient.addColorStop(1,
                                                                            'rgba(27,32,38, 0)'); // Color final con opacidad 0 (transparente)

                                                                        return gradient;
                                                                    },
                                                                    borderColor: 'rgba(88, 226, 194, 0.9)',
                                                                    borderWidth: 1,
                                                                    data: values_energia_importada_total
                                                                }];

                                                                var ctx = document.getElementById('graficoBarrasConsumo').getContext('2d');
                                                                var myChart = new Chart(ctx, {
                                                                    type: 'bar',
                                                                    data: {
                                                                        labels: labels_fecha_energia,
                                                                        datasets: data
                                                                    },
                                                                    options: {
                                                                        responsive: true,
                                                                        maintainAspectRatio: false,
                                                                        scales: {
                                                                            x: {
                                                                                grid: {
                                                                                    color: 'rgba(0, 0, 0, 0)' // Color transparente para desaparecer la rejilla en el eje x
                                                                                },
                                                                                ticks: {
                                                                                    color: 'white', // Color blanco para las etiquetas del eje x
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
                                                                                },
                                                                                suggestedMax: maxValue // Establece el valor máximo sugerido en el eje y
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
                                                                                anchor: 'end',
                                                                                align: 'top',
                                                                                formatter: function(value, context) {
                                                                                    return value + " kWh";
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    plugins: [ChartDataLabels]
                                                                });
                                                            } else {
                                                                console.log("No hay datos disponibles para mostrar en el gráfico.");
                                                            }
                                                        });
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- FILTRO AQUI --}}
                                    <form action="{{ route('energia', ['id_ct' => $id_ct]) }}" method="GET"
                                        class="flex flex-col sm:flex-row items-center justify-start space-y-4 sm:space-y-0 space-x-0 sm:space-x-4 mb-4 mt-4 mr-2">
                                        <input type="hidden" name="id_ct" value="{{ $id_ct }}">
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
                                        </div>
                                        <button type="submit" class="btn btn-outline-info ml-2 mb-0 text-white"
                                            style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                            onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                            onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                    </form>
                                    {{-- DESEQUILIBRIOS --}}
                                    <h1 class="text-center text-3xl mt-4" style="color: white;">DESEQUILIBRIOS
                                        DEL
                                        CT </h1>
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
                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
                                    </div>
                                    <div id="desequilibrios"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6 mb-0">
                                        {{-- DESEQUILIBRIOS VOLTAJE --}}
                                        <div class="card text-white mb-3 col-span-1 "
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
                                                    Desequilibrio Voltaje
                                                </h1>
                                                @if (is_array($resultadosQ47) && count($resultadosQ47) > 0)
                                                    <div id="graficoDesequilibrioVoltaje" class="h-40 "></div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center text-yellow-500">No hay datos</p>
                                                    </div>
                                                @endif
                                            </div>
                                            {{-- GRAFICO DESEQUILIBRIO VOLTAJE --}}
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var avg_pct_deseq_voltaje = {
                                                        @if (is_array($resultadosQ47) && count($resultadosQ47) > 0 && !empty($resultadosQ47[0]->avg_pct_deseq_voltaje))
                                                            data: {{ $resultadosQ47[0]->avg_pct_deseq_voltaje }},
                                                        @else
                                                            data: 0,
                                                        @endif
                                                    };

                                                    function updateChartDesequilibrioVoltaje(data) {
                                                        function getColor(value) {
                                                            return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
                                                        }

                                                        var color = getColor(data.data);
                                                        var textColor = color;

                                                        var max_pct_deseq_voltaje = @json($resultadosQ47[0]->max_pct_deseq_voltaje ?? 100);
                                                        var min_pct_deseq_voltaje = @json($resultadosQ47[0]->min_pct_deseq_voltaje ?? 0);

                                                        var newData = [{
                                                            type: "indicator",
                                                            mode: "gauge",
                                                            value: data.data,
                                                            title: {
                                                                font: {
                                                                    size: 20,
                                                                    color: 'white'
                                                                }
                                                            },
                                                            gauge: {
                                                                axis: {
                                                                    range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje],
                                                                    tickwidth: 1,
                                                                    tickcolor: color,
                                                                    linecolor: color
                                                                },
                                                                bar: {
                                                                    color: color,
                                                                    thickness: 0.8
                                                                },
                                                                bgcolor: "transparent",
                                                                borderwidth: 2,
                                                                bordercolor: "transparent",
                                                                steps: [{
                                                                    range: [0, min_pct_deseq_voltaje],
                                                                    color: "transparent"
                                                                }, {
                                                                    range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje],
                                                                    color: "transparent"
                                                                }],
                                                                startangle: 270,
                                                            },
                                                            hoverinfo: 'none',
                                                        }];

                                                        var layout = {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            margin: {
                                                                t: 35,
                                                                r: 35,
                                                                l: 35,
                                                                b: 35
                                                            },
                                                            paper_bgcolor: "transparent",
                                                            font: {
                                                                color: "white",
                                                                family: "Didact Gothic",
                                                                weight: 'normal'
                                                            },
                                                            annotations: [{
                                                                text: data.data + ' %',
                                                                x: 0.5,
                                                                y: 0.4,
                                                                showarrow: false,
                                                                font: {
                                                                    size: 20,
                                                                    color: textColor
                                                                }
                                                            }],
                                                        };

                                                        Plotly.react('graficoDesequilibrioVoltaje', newData, layout, {
                                                            displaylogo: false,
                                                            displayModeBar: false
                                                        });
                                                    }

                                                    // Llamar a la función para inicializar el gráfico con los datos
                                                    updateChartDesequilibrioVoltaje(avg_pct_deseq_voltaje);
                                                });
                                            </script>




                                            <div class="p-4 h-full flex flex-row justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-row items-center justify-center space-x-4">

                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ47[0]->min_pct_deseq_voltaje) ? $resultadosQ47[0]->min_pct_deseq_voltaje : '0' }}%
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ47[0]->max_pct_deseq_voltaje) ? $resultadosQ47[0]->max_pct_deseq_voltaje : '0' }}%
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        {{-- DESEQUILIBRIOS CORRIENTE --}}
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
                                                    Desequilibrio Corriente
                                                </h1>
                                                @if (is_array($resultadosQ47) && count($resultadosQ47) > 0)
                                                    <div id="graficoDesequilibrioCorriente" class="h-40 "></div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center text-yellow-500">No hay datos</p>
                                                    </div>
                                                @endif
                                            </div>
                                            {{-- GRAFICO DESEQUILIBRIO CORRIENTE --}}
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var avg_pct_deseq_corriente = {
                                                        @if (is_array($resultadosQ47) && count($resultadosQ47) > 0 && !empty($resultadosQ47[0]->avg_pct_deseq_corriente))
                                                            data: {{ $resultadosQ47[0]->avg_pct_deseq_corriente }},
                                                        @else
                                                            data: 0,
                                                        @endif
                                                    };

                                                    function updateChartDesequilibrioCorriente(data) {
                                                        function getColor(value) {
                                                            return value <= 30 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
                                                        }

                                                        var color = getColor(data.data);
                                                        var textColor = color;

                                                        var max_pct_deseq_corriente = @json($resultadosQ47[0]->max_pct_deseq_corriente ?? 100);
                                                        var min_pct_deseq_corriente = @json($resultadosQ47[0]->min_pct_deseq_corriente ?? 0);

                                                        var newData = [{
                                                            type: "indicator",
                                                            mode: "gauge",
                                                            value: data.data,
                                                            title: {
                                                                font: {
                                                                    size: 20,
                                                                    color: 'white'
                                                                }
                                                            },
                                                            gauge: {
                                                                axis: {
                                                                    range: [min_pct_deseq_corriente, max_pct_deseq_corriente],
                                                                    tickwidth: 1,
                                                                    tickcolor: color,
                                                                    linecolor: color
                                                                },
                                                                bar: {
                                                                    color: color,
                                                                    thickness: 0.8
                                                                },
                                                                bgcolor: "transparent",
                                                                borderwidth: 2,
                                                                bordercolor: "transparent",
                                                                steps: [{
                                                                    range: [0, min_pct_deseq_corriente],
                                                                    color: "transparent"
                                                                }, {
                                                                    range: [min_pct_deseq_corriente, max_pct_deseq_corriente],
                                                                    color: "transparent"
                                                                }],
                                                                startangle: 270,
                                                            },
                                                            hoverinfo: 'none',
                                                        }];

                                                        var layout = {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            margin: {
                                                                t: 35,
                                                                r: 35,
                                                                l: 35,
                                                                b: 35
                                                            },
                                                            paper_bgcolor: "transparent",
                                                            font: {
                                                                color: "white",
                                                                family: "Didact Gothic",
                                                                weight: 'normal'
                                                            },
                                                            annotations: [{
                                                                text: data.data + ' %',
                                                                x: 0.5,
                                                                y: 0.4,
                                                                showarrow: false,
                                                                font: {
                                                                    size: 20,
                                                                    color: textColor
                                                                }
                                                            }],
                                                        };

                                                        Plotly.react('graficoDesequilibrioCorriente', newData, layout, {
                                                            displaylogo: false,
                                                            displayModeBar: false
                                                        });
                                                    }

                                                    // Llamar a la función para inicializar el gráfico con los datos
                                                    updateChartDesequilibrioCorriente(avg_pct_deseq_corriente);
                                                });
                                            </script>


                                            <div class="p-4 h-full flex flex-row justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-row items-center justify-center space-x-4">

                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ47[0]->min_pct_deseq_corriente) ? $resultadosQ47[0]->min_pct_deseq_corriente : '0' }}%
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ47[0]->max_pct_deseq_corriente) ? $resultadosQ47[0]->max_pct_deseq_corriente : '0' }}%
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>





                                    {{-- TERCERA FILA --}}
                                    <h1 class="text-center text-3xl mt-4" style="color: white;">TENSIONES
                                        DEL
                                        CT </h1>
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
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                                    </div>
                                    {{-- VOLTAJE R --}}
                                    {{-- PRIMERA FILA NARANJA --}}

                                    <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
                                        Voltaje Fase R
                                    </h1>
                                    <div
                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
                                    </div>
                                    <div id="primeraFila"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0">
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">












                                                <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                    Promedio Fase R
                                                </h2>
                                                @if (is_array($resultadosQ15) && count($resultadosQ15) > 0)
                                                    <div id="graficoVoltajeProm1" class="h-40 "></div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center text-yellow-500">No hay datos</p>
                                                    </div>
                                                @endif
                                            </div>












                                        </div>








                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA --}}
                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (isset($resultadosQ16[0]) == null)
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center text-yellow-500">No hay datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntosNaranja"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoLineaVoltaje1" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>








                                        {{-- ELEMENTO DERECHO MAX MIN NARANJA --}}








                                        <div class="card text-white mb-3 col-span-1 w-full"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-col items-center justify-center">
                                                    <div class="max-min-item bg-gradient-to-br from-yellow-500 to-yellow-700 text-white rounded-lg shadow-xl mb-2 p-4"
                                                        style="width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ15[0]->max_volt_1) ? $resultadosQ15[0]->max_volt_1 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item bg-gradient-to-br from-yellow-500 to-yellow-700 text-white rounded-lg shadow-xl p-4"
                                                        style="width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ15[0]->min_volt1) ? $resultadosQ15[0]->min_volt1 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>








                                    {{-- SCRIPTS PARA EL GRÁFICO GAUGE 1 --}}
                                    <script>
                                        var myChart; // Variable para almacenar el objeto Chart
                                        var prom_volt1_data = {
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->prom_volt1))
                                                data: {{ $resultadosQ15[0]->prom_volt1 }},
                                            @else
                                                data: '0',
                                            @endif
                                        };
                                        // Función para actualizar el gráfico de pastel con nuevos datos
                                        function updateChartVoltajeProm1(data) {
                                            // Función para determinar el color basado en los datos
                                            function getColor(value) {
                                                return value < 80 ? "rgba(232,80,107, 0.9)" : "rgba(39,47,58, 0.9)";
                                            }
                                            // Variables para el color y color de texto
                                            var color = getColor(data.data);
                                            var textColor = getColor(data.data) === "rgba(232,80,107, 0.9)" ? "rgba(232,80,107, 0.9)" :
                                                "rgb(238,145,4)";
                                            // Valores máximo y mínimo del gráfico
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->max_volt_1))
                                                var maxVolt1 = {{ $resultadosQ15[0]->max_volt_1 }};
                                            @else
                                                var maxVolt1 = 100; // Valor predeterminado si no hay datos
                                            @endif
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->min_volt1))
                                                var minVolt1 = {{ $resultadosQ15[0]->min_volt1 }};
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
                                                        tickcolor: "rgb(238,145,4)",
                                                        linecolor: "rgb(238,145,4) "
                                                    },
                                                    bar: {
                                                        color: "rgb(238,145,4)",
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
                                                            color: "rgba(27,32,38, 0.5)"
                                                        }
                                                    ],
                                                    startangle: 270,
                                                },
                                                hoverinfo: data.data,
                                            }];
                                            var layout = {
                                                responsive: true,
                                                maintainAspectRatio: false,








                                                margin: {
                                                    t: 35,
                                                    r: 35,
                                                    l: 35,
                                                    b: 35
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
                                                    y: 0.4,
                                                    showarrow: false,
                                                    font: {
                                                        size: 20,
                                                        color: textColor
                                                    }
                                                }],
                                            };
                                            // Actualizar el gráfico
                                            Plotly.react('graficoVoltajeProm1', newData, layout, {
                                                displaylogo: false,
                                                displayModeBar: false
                                            });
                                        }
                                    </script>
                                    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 1 --}}
                                    <script>
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt1 = [];
                                        var values_volt1 = [];
                                        @if ($resultadosQ16 && count($resultadosQ16) > 0)
                                            @foreach ($resultadosQ16 as $key => $resultado)
                                                @if (isset($resultado->fec_registro) && isset($resultado->hor_registro) && isset($resultado->val_voltaje_1))
                                                    // Verificar que fec_registro, hor_registro y val_voltaje_1 estén definidos y no sean nulos o cadenas vacías
                                                    var dateTime = '{{ $resultado->fec_registro }} {{ $resultado->hor_registro }}';
                                                    labels_volt1.push(dateTime);
                                                    values_volt1.push({{ $resultado->val_voltaje_1 }});
                                                @endif
                                            @endforeach
                                        @endif
                                        if (labels_volt1.length > 0 && values_volt1.length > 0) {
                                            // Ordenar los datos por fecha y hora
                                            var sortedData = labels_volt1.slice().sort();
                                            // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                            var filteredLabels = [sortedData[0]];
                                            for (var i = 1; i < sortedData.length; i++) {
                                                if (sortedData[i] !== sortedData[i - 1]) {
                                                    filteredLabels.push(sortedData[i]);
                                                }
                                            }
                                            var myChartLineVoltaje1;
                                            // Actualiza el gráfico con las etiquetas filtradas
                                            function updateChartLineVoltaje1(data) {
                                                if (myChartLineVoltaje1) {
                                                    myChartLineVoltaje1.data.labels = data.labels_volt1;
                                                    myChartLineVoltaje1.data.datasets[0].data = data.values_volt1;
                                                    myChartLineVoltaje1.update();
                                                } else {
                                                    var ctx = document.getElementById('graficoLineaVoltaje1').getContext('2d');
                                                    myChartLineVoltaje1 = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: data.labels_volt1,
                                                            datasets: [{
                                                                label: 'Voltaje Fase R.',
                                                                data: data.values_volt1,
                                                                borderColor: 'rgb(238,145,4)',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(238,145,4, 0.9)'); // Color inicial con opacidad 0.9
                                                                    gradient.addColorStop(0.3,
                                                                        'rgba(238,145,4, 0.5)'
                                                                    ); // Nuevo color en la mitad del gradiente
                                                                    gradient.addColorStop(1,
                                                                        'rgba(238,145,4, 0)'
                                                                    ); // Color final con opacidad 0 (transparente)
                                                                    return gradient;
                                                                },
                                                                borderWidth: 2,
                                                                pointBackgroundColor: 'rgb(238,145,4)',
                                                                pointBorderColor: 'rgba(238,145,4, 0.5)',
                                                                pointBorderWidth: 1,
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
                                                                    position: 'bottom', // Mueve la leyenda a la parte inferior
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
                                                                    labels: data.labels_volt1.map(label => {
                                                                        // Eliminar los segundos de cada etiqueta
                                                                        const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                        return timeWithoutSeconds;
                                                                    }).sort(), // Utilizar las cadenas de fecha sin formato
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 2 // Establecer el tamaño del paso entre los valores en el eje y    
                                                                    }
                                                                },
                                                                y: {
                                                                    display: true, // Mostrar el eje y
                                                                    beginAtZero: true,
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        // min: 0, // Valor mínimo en el eje y
                                                                        // max: 300, // Valor máximo en el eje y
                                                                        stepSize: 100, // Espaciado entre cada valor
                                                                        callback: function(value, index, values) {
                                                                            // Devolver solo los valores que deseas mostrar
                                                                            return [0, 100, 200, 300].includes(value) ? value + ' V' : '';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                            updateChartLineVoltaje1({
                                                labels_volt1: filteredLabels,
                                                values_volt1: values_volt1
                                            });
                                        } else {
                                            console.log("No hay datos disponibles para mostrar en el gráfico.");
                                        }
                                    </script>




                                    {{-- VOLTAJE S --}}
                                    {{-- SEGUNDA FILA CELESTE --}}
                                    <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
                                        Voltaje Fase S
                                    </h1>
                                    <div
                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
                                    </div>
                                    <div id="segundaFila"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0">
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                    Promedio Fase S
                                                </h2>
                                                @if (is_array($resultadosQ15) && count($resultadosQ15) > 0)
                                                    <div id="graficoVoltajeProm2" class="h-40"></div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center" style="color:rgba(88,226,194, 0.9)">No
                                                            hay
                                                            datos</p>
                                                    </div>
                                                @endif
                                            </div>












                                        </div>








                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS CELESTE --}}








                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (isset($resultadosQ16[0]) == null)
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center" style="color:rgba(88,226,194, 0.9)">No hay
                                                        datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntosNaranja"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoLineaVoltaje2" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>








                                        {{-- ELEMENTO DERECHO MAX MIN CELESTE --}}
                                        <div class="card text-white mb-3 col-span-1 w-full"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-col items-center justify-center">
                                                    <div class="max-min-item text-white rounded-lg shadow-xl mb-2 p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ15[0]->max_volt_2) ? $resultadosQ15[0]->max_volt_2 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ15[0]->min_volt2) ? $resultadosQ15[0]->min_volt2 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SCRIPTS PARA EL GRÁFICO GAUGE 2 --}}
                                    <script>
                                        var myChart2; // Variable para almacenar el objeto Chart
                                        var prom_volt2_data = {
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->prom_volt2))
                                                data: {{ $resultadosQ15[0]->prom_volt2 }},
                                            @else
                                                data: '0',
                                            @endif
                                        };
                                        // Función para actualizar el gráfico de pastel con nuevos datos
                                        function updateChartVoltajeProm2(data) {
                                            var color; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                color = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                color = "rgba(39,47,58, 0.9)"; // Si es mayor o igual a 80, color original
                                            }
                                            var colorTexto; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                colorTexto = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                colorTexto = "linear-gradient(to bottom, rgba(88,226,194, 0.9), rgba(0, 0, 0, 0.9))";
                                            }
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->max_volt_2)) // Valor máximo del gráfico
                                                var maxVolt2 = {{ $resultadosQ15[0]->max_volt_2 }};
                                            @else
                                                var maxVolt2 = 100; // Valor predeterminado si no hay datos
                                            @endif
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->min_volt2)) // Valor mínimo del gráfico
                                                var minVolt2 = {{ $resultadosQ15[0]->min_volt2 }};
                                            @else
                                                var minVolt2 = 0; // Valor predeterminado si no hay datos
                                            @endif
                                            var newData = [{
                                                type: "indicator",
                                                mode: "gauge",
                                                value: data.data,
                                                title: {
                                                    // text: "",
                                                    font: {
                                                        size: 20,
                                                        color: 'white' // Letras blancas
                                                    }
                                                },
                                                gauge: {
                                                    axis: {
                                                        range: [minVolt2, maxVolt2], // Utiliza el valor mínimo y máximo
                                                        tickwidth: 1,
                                                        tickcolor: "rgb(88,226,194)",
                                                        linecolor: "rgb(88,226,194)" // Línea central verde
                                                    },
                                                    bar: {
                                                        color: "rgba(88,226,194, 0.9)",
                                                        thickness: 0.8 // Ajusta este valor para cambiar el arco
                                                    },
                                                    bgcolor: "transparent", // Cambio del fondo a transparente
                                                    borderwidth: 2,
                                                    bordercolor: "transparent",
                                                    steps: [{
                                                            range: [0, minVolt2], // Cambio de los rangos y colores
                                                            color: color // Color dinámico
                                                        },
                                                        {
                                                            range: [minVolt2, maxVolt2],
                                                            color: "rgba(27,32,38, 0.5)" // Nuevo color en la mitad del gradiente
                                                        }
                                                    ],
                                                    startangle: 270, // Ajusta este valor para cambiar el ángulo de inicio
                                                },
                                                hoverinfo: data.data,
                                            }];
                                            var layout = {
                                                responsive: true,
                                                margin: {
                                                    t: 35,
                                                    r: 35,
                                                    l: 35,
                                                    b: 35
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
                                                    y: 0.4,
                                                    showarrow: false,
                                                    font: {
                                                        size: 20,
                                                        color: colorTexto
                                                    }
                                                }],
                                            };
                                            Plotly.react('graficoVoltajeProm2', newData, layout, {
                                                displaylogo: false,
                                                displayModeBar: false
                                            });
                                        }
                                    </script>
                                    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 2 --}}
                                    <script>
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt2 = [];
                                        var values_volt2 = [];
                                        @if ($resultadosQ16 && count($resultadosQ16) > 0)
                                            @foreach ($resultadosQ16 as $key => $resultado)
                                                @if (isset($resultado->fec_registro) && isset($resultado->hor_registro) && isset($resultado->val_voltaje_2))
                                                    // Agregar la fecha y hora como etiquetas del eje x
                                                    var dateTime = '{{ $resultado->fec_registro }} {{ $resultado->hor_registro }}';
                                                    labels_volt2.push(dateTime);
                                                    // Agregar el valor de 'val_voltaje_2' como valor del eje y
                                                    values_volt2.push({{ $resultado->val_voltaje_2 }});
                                                @endif
                                            @endforeach
                                        @endif
                                        if (labels_volt2.length > 0 && values_volt2.length > 0) {
                                            // Ordenar los datos por fecha y hora
                                            var sortedDataVolt2 = labels_volt2.slice().sort();
                                            // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                            var filteredLabelsVolt2 = [sortedDataVolt2[0]];
                                            for (var i = 1; i < sortedDataVolt2.length; i++) {
                                                if (sortedDataVolt2[i] !== sortedDataVolt2[i - 1]) {
                                                    filteredLabelsVolt2.push(sortedDataVolt2[i]);
                                                }
                                            }
                                            var myChartLineVoltaje2;
                                            // Actualizar el gráfico con las etiquetas filtradas
                                            function updateChartLineVoltaje2(data) {
                                                if (myChartLineVoltaje2) {
                                                    myChartLineVoltaje2.data.labels = data.labels_volt2;
                                                    myChartLineVoltaje2.data.datasets[0].data = data.values_volt2;
                                                    myChartLineVoltaje2.update();
                                                } else {
                                                    var ctx = document.getElementById('graficoLineaVoltaje2').getContext('2d');
                                                    myChartLineVoltaje2 = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: data.labels_volt2,
                                                            datasets: [{
                                                                label: 'Voltaje Fase S.',
                                                                data: data.values_volt2,
                                                                borderColor: 'rgb(88, 226, 194)',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(88,226,194, 0.9)'); // Color inicial con opacidad 0.9
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
                                                                pointBorderWidth: 1,
                                                                fill: true,
                                                                tension: 0.4,
                                                                pointRadius: 3, // Establecer el radio del punto a 0 para que no se muestren los puntos
                                                            }]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            plugins: {
                                                                legend: {
                                                                    position: 'bottom', // Mueve la leyenda a la parte inferior
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
                                                                    labels: data.labels_volt2.map(label => {
                                                                        // Eliminar los segundos de cada etiqueta
                                                                        const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                        return timeWithoutSeconds;
                                                                    }).sort(), // Utilizar las cadenas de fecha sin formato
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 2 // Establecer el tamaño del paso entre los valores en el eje y    
                                                                    }
                                                                },
                                                                y: {
                                                                    display: true, // Mostrar el eje y
                                                                    beginAtZero: true,
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 100, // Espaciado entre cada valor
                                                                        callback: function(value, index, values) {
                                                                            // Devolver solo los valores que deseas mostrar
                                                                            return [0, 100, 200, 300].includes(value) ? value + ' V' : '';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                            updateChartLineVoltaje2({
                                                labels_volt2: filteredLabelsVolt2,
                                                values_volt2: values_volt2
                                            });
                                        } else {
                                            console.log("No hay datos disponibles para mostrar en el gráfico.");
                                        }
                                    </script>




                                    {{-- TERCERA FILA AZUL --}}
                                    {{-- VOLTAJE T --}}
                                    <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
                                        Voltaje Fase T
                                    </h1>
                                    <div
                                        style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
                                    </div>
                                    <div id="terceraFila"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0 ">
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                    Promedio Fase T
                                                </h2>
                                                @if (is_array($resultadosQ15) && count($resultadosQ15) > 0)
                                                    <div id="graficoVoltajeProm3" class="h-40"></div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center" style="color: rgba(44, 131, 174, 0.9)">
                                                            No hay datos</p>
                                                    </div>
                                                @endif
                                            </div>












                                        </div>








                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS AZUL --}}








                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (isset($resultadosQ16[0]) == null)
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center" style="color: rgba(44, 131, 174, 0.9)">No
                                                        hay datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntosNaranja"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoLineaVoltaje3" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div> {{-- ELEMENTO DERECHO MAX MIN AZUL --}}








                                        <div class="card text-white mb-3 col-span-1 w-full"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-col items-center justify-center">
                                                    <div class="max-min-item text-white rounded-lg shadow-xl mb-2 p-4"
                                                        style="background: linear-gradient(135deg, rgba(44, 131, 174, 0.9), #133B5C); text-align: center; width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ15[0]->max_volt_3) ? $resultadosQ15[0]->max_volt_3 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(44, 131, 174, 0.9), #133B5C); text-align: center; width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($resultadosQ15[0]->min_volt3) ? $resultadosQ15[0]->min_volt3 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SCRIPTS PARA EL GRÁFICO GAUGE 3 --}}
                                    <script>
                                        var myChart3; // Variable para almacenar el objeto Chart
                                        var prom_volt3_data = {
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->prom_volt3))
                                                data: {{ $resultadosQ15[0]->prom_volt3 }},
                                            @else
                                                data: '0',
                                            @endif
                                        };
                                        // Función para actualizar el gráfico de pastel con nuevos datos
                                        function updateChartVoltajeProm3(data) {
                                            var color; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                color = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                color = "rgba(44, 131, 174, 0.9)"; // Si es mayor o igual a 80, color original
                                            }
                                            var colorTexto; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                colorTexto = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                colorTexto = "linear-gradient(to bottom, rgba(44, 131, 174, 0.9), rgba(0, 0, 0, 0.9))";
                                            }
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->max_volt_3)) // Valor máximo del gráfico
                                                var maxVolt3 = {{ $resultadosQ15[0]->max_volt_3 }};
                                            @else
                                                var maxVolt3 = 100; // Valor predeterminado si no hay datos
                                            @endif
                                            @if (is_array($resultadosQ15) && count($resultadosQ15) > 0 && !empty($resultadosQ15[0]->min_volt3)) // Valor mínimo del gráfico
                                                var minVolt3 = {{ $resultadosQ15[0]->min_volt3 }};
                                            @else
                                                var minVolt3 = 0; // Valor predeterminado si no hay datos
                                            @endif
                                            var newData = [{
                                                type: "indicator",
                                                mode: "gauge",
                                                value: data.data,
                                                title: {
                                                    // text: "",
                                                    font: {
                                                        size: 20,
                                                        color: 'white' // Letras blancas
                                                    }
                                                },
                                                gauge: {
                                                    axis: {
                                                        range: [minVolt3, maxVolt3], // Utiliza el valor mínimo y máximo
                                                        tickwidth: 1,
                                                        tickcolor: "RGB(44, 131, 174)",
                                                        linecolor: "RGB(44, 131, 174)" // Línea central verde
                                                    },
                                                    bar: {
                                                        color: "rgba(44, 131, 174, 0.9)",
                                                        thickness: 0.8 // Ajusta este valor para cambiar el arco
                                                    },
                                                    bgcolor: "transparent", // Cambio del fondo a transparente
                                                    borderwidth: 2,
                                                    bordercolor: "transparent",
                                                    steps: [{
                                                            range: [0, minVolt3], // Cambio de los rangos y colores
                                                            color: color // Color dinámico
                                                        },
                                                        {
                                                            range: [minVolt3, maxVolt3],
                                                            color: "rgba(27,32,38, 0.5)" // Nuevo color en la mitad del gradiente
                                                        }
                                                    ],
                                                    startangle: 270, // Ajusta este valor para cambiar el ángulo de inicio
                                                },
                                                hoverinfo: data.data,
                                            }];
                                            var layout = {
                                                responsive: true,
                                                margin: {
                                                    t: 35,
                                                    r: 35,
                                                    l: 35,
                                                    b: 35
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
                                                    y: 0.4,
                                                    showarrow: false,
                                                    font: {
                                                        size: 20,
                                                        color: colorTexto
                                                    }
                                                }],
                                            };
                                            Plotly.react('graficoVoltajeProm3', newData, layout, {
                                                displaylogo: false,
                                                displayModeBar: false
                                            });
                                        }
                                    </script>
                                    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 3 --}}
                                    <script>
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt3 = [];
                                        var values_volt3 = [];
                                        @if ($resultadosQ16 && count($resultadosQ16) > 0)
                                            @foreach ($resultadosQ16 as $key => $resultado)
                                                @if (isset($resultado->fec_registro) && isset($resultado->hor_registro) && isset($resultado->val_voltaje_3))
                                                    // Agregar la fecha y hora como etiquetas del eje x
                                                    var dateTime = '{{ $resultado->fec_registro }} {{ $resultado->hor_registro }}';
                                                    labels_volt3.push(dateTime);
                                                    // Agregar el valor de 'val_voltaje_3' como valor del eje y
                                                    values_volt3.push({{ $resultado->val_voltaje_3 }});
                                                @endif
                                            @endforeach
                                        @endif
                                        if (labels_volt3.length > 0 && values_volt3.length > 0) {
                                            // Ordenar los datos por fecha y hora
                                            var sortedDataVolt3 = labels_volt3.slice().sort();
                                            // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                            var filteredLabelsVolt3 = [sortedDataVolt3[0]];
                                            for (var i = 1; i < sortedDataVolt3.length; i++) {
                                                if (sortedDataVolt3[i] !== sortedDataVolt3[i - 1]) {
                                                    filteredLabelsVolt3.push(sortedDataVolt3[i]);
                                                }
                                            }
                                            var myChartLineVoltaje3;
                                            // Actualizar el gráfico con las etiquetas filtradas
                                            function updateChartLineVoltaje3(data) {
                                                if (myChartLineVoltaje3) {
                                                    myChartLineVoltaje3.data.labels = data.labels_volt3;
                                                    myChartLineVoltaje3.data.datasets[0].data = data.values_volt3;
                                                    myChartLineVoltaje3.update();
                                                } else {
                                                    var ctx = document.getElementById('graficoLineaVoltaje3').getContext('2d');
                                                    myChartLineVoltaje3 = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: data.labels_volt3,
                                                            datasets: [{
                                                                label: 'Voltaje Fase T.',
                                                                data: data.values_volt3,
                                                                borderColor: 'rgb(44, 131, 174)',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(44, 131, 174, 0.9)'); // Color inicial con opacidad 0.9
                                                                    gradient.addColorStop(0.3,
                                                                        'rgba(44, 131, 174, 0.5)'
                                                                    ); // Nuevo color en la mitad del gradiente
                                                                    gradient.addColorStop(1,
                                                                        'rgba(44, 131, 174, 0)'
                                                                    ); // Color final con opacidad 0 (transparente)
                                                                    return gradient;
                                                                },
                                                                borderWidth: 2,
                                                                pointBackgroundColor: 'rgba(44, 131, 174, 0.8)',
                                                                pointBorderColor: 'rgba(44, 131, 174, 0.5)',
                                                                pointBorderWidth: 1,








                                                                fill: true,
                                                                tension: 0.4,
                                                                pointRadius: 3, // Establecer el radio del punto a 0 para que no se muestren los puntos
                                                            }]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            plugins: {
                                                                legend: {
                                                                    position: 'bottom', // Mueve la leyenda a la parte inferior
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
                                                                    labels: data.labels_volt3.map(label => {
                                                                        // Eliminar los segundos de cada etiqueta
                                                                        const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                        return timeWithoutSeconds;
                                                                    }).sort(), // Utilizar las cadenas de fecha sin formato
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 2 // Establecer el tamaño del paso entre los valores en el eje y    
                                                                    }
                                                                },
                                                                y: {
                                                                    display: true, // Mostrar el eje y
                                                                    beginAtZero: true,
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        min: 100, // Valor mínimo en el eje y
                                                                        max: 300, // Valor máximo en el eje y
                                                                        stepSize: 100, // Espaciado entre cada valor
                                                                        callback: function(value, index, values) {
                                                                            // Devolver solo los valores que deseas mostrar
                                                                            return [0, 100, 200, 300].includes(value) ? value + ' V' : '';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                            updateChartLineVoltaje3({
                                                labels_volt3: filteredLabelsVolt3,
                                                values_volt3: values_volt3
                                            });
                                        } else {
                                            console.log("No hay datos disponibles para mostrar en el gráfico.");
                                        }
                                    </script>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>


