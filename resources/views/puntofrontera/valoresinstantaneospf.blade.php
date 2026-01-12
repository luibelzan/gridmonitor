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


        /* Archivo styles.css */
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
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datos iniciales
        var avg_pct_deseq_voltaje = {
            @if (count($tensionFase) > 0 && !empty($tensionFase[0]->volt_fase_1_promedio))
                data: {{ number_format($tensionFase[0]->volt_fase_1_promedio, 2, '.', '') }},
            @else
                data: 0,
            @endif
        };

        // Función para actualizar el gráfico de desequilibrio de voltaje
        function updateChartDesequilibrioVoltaje1(data) {

            // Selecciona color según valor
            function getColor(value) {
                return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_voltaje = @json($tensionFase[0]->volt_fase_1_maximo ?? 100);
            var min_pct_deseq_voltaje = @json($tensionFase[0]->volt_fase_1_minimo ?? 0);

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
                    steps: [
                        { range: [0, min_pct_deseq_voltaje], color: "transparent" },
                        { range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje], color: "transparent" }
                    ],
                    startangle: 270
                },
                hoverinfo: 'none'
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: { t: 35, r: 35, l: 35, b: 35 },
                paper_bgcolor: "transparent",
                font: { color: "white", family: "Didact Gothic", weight: 'normal' },
                annotations: [{
                    text: data.data + ' V',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: { size: 20, color: textColor }
                }]
            };

            // Renderiza el gráfico con Plotly
            Plotly.react('graficoTensionFase1', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Inicializa el gráfico al cargar la página
        updateChartDesequilibrioVoltaje1(avg_pct_deseq_voltaje);
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datos iniciales
        var avg_pct_deseq_voltaje = {
            @if (count($tensionFase) > 0 && !empty($tensionFase[0]->volt_fase_2_promedio))
                data: {{ number_format($tensionFase[0]->volt_fase_2_promedio, 2, '.', '') }},
            @else
                data: 0,
            @endif
        };

        // Función para actualizar el gráfico de desequilibrio de voltaje
        function updateChartDesequilibrioVoltaje2(data) {

            // Selecciona color según valor
            function getColor(value) {
                return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_voltaje = @json($tensionFase[0]->volt_fase_2_maximo ?? 100);
            var min_pct_deseq_voltaje = @json($tensionFase[0]->volt_fase_2_minimo ?? 0);

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
                    steps: [
                        { range: [0, min_pct_deseq_voltaje], color: "transparent" },
                        { range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje], color: "transparent" }
                    ],
                    startangle: 270
                },
                hoverinfo: 'none'
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: { t: 35, r: 35, l: 35, b: 35 },
                paper_bgcolor: "transparent",
                font: { color: "white", family: "Didact Gothic", weight: 'normal' },
                annotations: [{
                    text: data.data + ' V',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: { size: 20, color: textColor }
                }]
            };

            // Renderiza el gráfico con Plotly
            Plotly.react('graficoTensionFase2', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Inicializa el gráfico al cargar la página
        updateChartDesequilibrioVoltaje2(avg_pct_deseq_voltaje);
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datos iniciales
        var avg_pct_deseq_voltaje = {
            @if (count($tensionFase) > 0 && !empty($tensionFase[0]->volt_fase_3_promedio))
                data: {{ number_format($tensionFase[0]->volt_fase_3_promedio, 2, '.', '') }},
            @else
                data: 0,
            @endif
        };

        // Función para actualizar el gráfico de desequilibrio de voltaje
        function updateChartDesequilibrioVoltaje3(data) {

            // Selecciona color según valor
            function getColor(value) {
                return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_voltaje = @json($tensionFase[0]->volt_fase_3_maximo ?? 100);
            var min_pct_deseq_voltaje = @json($tensionFase[0]->volt_fase_3_minimo ?? 0);

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
                    steps: [
                        { range: [0, min_pct_deseq_voltaje], color: "transparent" },
                        { range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje], color: "transparent" }
                    ],
                    startangle: 270
                },
                hoverinfo: 'none'
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: { t: 35, r: 35, l: 35, b: 35 },
                paper_bgcolor: "transparent",
                font: { color: "white", family: "Didact Gothic", weight: 'normal' },
                annotations: [{
                    text: data.data + ' V',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: { size: 20, color: textColor }
                }]
            };

            // Renderiza el gráfico con Plotly
            Plotly.react('graficoTensionFase3', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Inicializa el gráfico al cargar la página
        updateChartDesequilibrioVoltaje3(avg_pct_deseq_voltaje);
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datos iniciales
        var avg_pct_deseq_voltaje = {
            @if (count($intensidadFase) > 0 && !empty($intensidadFase[0]->current_fase_1_promedio))
                data: {{ number_format($intensidadFase[0]->current_fase_1_promedio, 2, '.', '') }},
            @else
                data: 0,
            @endif
        };

        // Función para actualizar el gráfico de desequilibrio de voltaje
        function updateChartDesequilibrioIntensidad1(data) {

            // Selecciona color según valor
            function getColor(value) {
                return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_voltaje = @json($intensidadFase[0]->current_fase_1_maximo ?? 100);
            var min_pct_deseq_voltaje = @json($intensidadFase[0]->current_fase_1_minimo ?? 0);

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
                    steps: [
                        { range: [0, min_pct_deseq_voltaje], color: "transparent" },
                        { range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje], color: "transparent" }
                    ],
                    startangle: 270
                },
                hoverinfo: 'none'
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: { t: 35, r: 35, l: 35, b: 35 },
                paper_bgcolor: "transparent",
                font: { color: "white", family: "Didact Gothic", weight: 'normal' },
                annotations: [{
                    text: data.data + ' A',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: { size: 20, color: textColor }
                }]
            };

            // Renderiza el gráfico con Plotly
            Plotly.react('graficoIntensidadFase1', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Inicializa el gráfico al cargar la página
        updateChartDesequilibrioIntensidad1(avg_pct_deseq_voltaje);
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datos iniciales
        var avg_pct_deseq_voltaje = {
            @if (count($intensidadFase) > 0 && !empty($intensidadFase[0]->current_fase_2_promedio))
                data: {{ number_format($intensidadFase[0]->current_fase_2_promedio, 2, '.', '') }},
            @else
                data: 0,
            @endif
        };

        // Función para actualizar el gráfico de desequilibrio de voltaje
        function updateChartDesequilibrioIntensidad2(data) {

            // Selecciona color según valor
            function getColor(value) {
                return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_voltaje = @json($intensidadFase[0]->current_fase_2_maximo ?? 100);
            var min_pct_deseq_voltaje = @json($intensidadFase[0]->current_fase_2_minimo ?? 0);

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
                    steps: [
                        { range: [0, min_pct_deseq_voltaje], color: "transparent" },
                        { range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje], color: "transparent" }
                    ],
                    startangle: 270
                },
                hoverinfo: 'none'
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: { t: 35, r: 35, l: 35, b: 35 },
                paper_bgcolor: "transparent",
                font: { color: "white", family: "Didact Gothic", weight: 'normal' },
                annotations: [{
                    text: data.data + ' A',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: { size: 20, color: textColor }
                }]
            };

            // Renderiza el gráfico con Plotly
            Plotly.react('graficoIntensidadFase2', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Inicializa el gráfico al cargar la página
        updateChartDesequilibrioIntensidad2(avg_pct_deseq_voltaje);
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datos iniciales
        var avg_pct_deseq_voltaje = {
            @if (count($intensidadFase) > 0 && !empty($intensidadFase[0]->current_fase_3_promedio))
                data: {{ number_format($intensidadFase[0]->current_fase_3_promedio, 2, '.', '') }},
            @else
                data: 0,
            @endif
        };

        // Función para actualizar el gráfico de desequilibrio de voltaje
        function updateChartDesequilibrioIntensidad3(data) {

            // Selecciona color según valor
            function getColor(value) {
                return value <= 3 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_voltaje = @json($intensidadFase[0]->current_fase_3_maximo ?? 100);
            var min_pct_deseq_voltaje = @json($intensidadFase[0]->current_fase_3_minimo ?? 0);

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
                    steps: [
                        { range: [0, min_pct_deseq_voltaje], color: "transparent" },
                        { range: [min_pct_deseq_voltaje, max_pct_deseq_voltaje], color: "transparent" }
                    ],
                    startangle: 270
                },
                hoverinfo: 'none'
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: { t: 35, r: 35, l: 35, b: 35 },
                paper_bgcolor: "transparent",
                font: { color: "white", family: "Didact Gothic", weight: 'normal' },
                annotations: [{
                    text: data.data + ' A',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: { size: 20, color: textColor }
                }]
            };

            // Renderiza el gráfico con Plotly
            Plotly.react('graficoIntensidadFase3', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Inicializa el gráfico al cargar la página
        updateChartDesequilibrioIntensidad3(avg_pct_deseq_voltaje);
    });
    </script>



    <title>Eventos PF</title>
</head>


<body class="h-full sm:grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 justify-center"
    style="background: linear-gradient(to bottom, rgb(42,50,62), rgb(27, 32, 38));" id="top">
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
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}
                    <nav class="nav mb-12 ">
                        <a href="{{ route('dashboardpf') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Dashboard</a>
                        <a href="{{ route('informacionpf', ['id_cnt' => $id_cnt]) }}" class="nav-item  "
                            active-color="rgb(88, 226, 194">Información</a>
                        <a href="{{ route('curvascuartihorariaspf', ['id_cnt' => $id_cnt]) }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Curvas Cuartihorarias</a>
                        <a href="{{ route('eventospf', ['id_cnt' => $id_cnt]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194">Eventos</a>
                        <a href="{{ route('reportespf') }}" class="nav-item "
                            active-color="rgb(88, 226, 194">Reportes</a>
                        <span class="nav-indicator"></span>
                    </nav>
                    
                    {{-- Selector CNT + fechas + botón --}}
                    <form
                        action="{{ route('valoresinstantaneospf', ['id_cnt' => $id_cnt]) }}"
                        method="GET"
                        class="container flex items-end gap-6 flex-wrap"
                        style="color:white;">

                        {{-- Selector CNT --}}
                        <div class="dropdown" style="margin-left: 6px">
                            <input list="cntList" name="id_cnt"
                                class="form-control mt-2"
                                style="color: white;
                                    background-color: rgb(27, 32, 38);
                                    font-size: 14px;
                                    width: 250px;"
                                placeholder="Buscar o seleccionar un Punto..."
                                value="{{ $id_cnt ?? '' }}">

                            <datalist id="cntList">
                                @foreach ($parametros as $cnt)
                                    @if ($cnt->lp_2)
                                        <option value="{{ $cnt->id_cnt }}">{{ $cnt->id_cups }}</option>
                                    @endif
                                @endforeach
                            </datalist>
                        </div>

                        {{-- Fecha inicio --}}
                        <div>
                            <label for="fecha_inicio" class="text-white block mb-1">
                                Fecha inicio
                            </label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio"
                                class="border border-gray-400 p-2 rounded-lg text-white"
                                value="{{ request('fecha_inicio') }}"
                                max="{{ date('Y-m-d') }}"
                                style="background-color: transparent;">
                        </div>

                        {{-- Fecha fin --}}
                        <div>
                            <label for="fecha_fin" class="text-white block mb-1">
                                Fecha fin
                            </label>
                            <input type="date" id="fecha_fin" name="fecha_fin"
                                class="border border-gray-400 p-2 rounded-lg text-white"
                                value="{{ request('fecha_fin') }}"
                                max="{{ date('Y-m-d') }}"
                                style="background-color: transparent;">
                        </div>

                        {{-- Botón --}}
                        <div>
                            <button type="submit"
                                class="btn btn-outline-info mt-6 text-white"
                                style="background-color: transparent; border-color: rgb(255,255,255);"
                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                onmouseout="this.style.borderColor='rgb(255,255,255)'">
                                Filtrar
                            </button>
                        </div>

                    </form>



                    {{-- INICIO BODY DE LA VISTA --}}
                    @if($id_cnt)
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
                            @php
                                $fechaInicio = request('fecha_inicio');
                                $fechaFin    = request('fecha_fin');
                            @endphp

                            <h1 class="text-center text-3xl w-full text-white">
                                @if ($fechaInicio && $fechaFin)
                                    VALORES INSTANTÁNEOS ({{ $fechaInicio }} a {{ $fechaFin }})
                                @else
                                    VALORES INSTANTÁNEOS (Últimos 7 días)
                                @endif
                            </h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                                    border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                           
                                @if ($cnt->id_cnt == $id_cnt)
                                    {{-- CONTENEDOR CUERPO --}}
                                    <div class="container ">
                                        {{-- PRIMERA FILA --}}
                                        <div id="desequilibrios"
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-0">

                                            {{-- FACTOR POTENCIA --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">
                                                        Factor de Potencia Promedio
                                                    </h1>
                                                    @if (is_array($factorPotenciaPromedio) && count($factorPotenciaPromedio) > 0)
                                                        <h3>
                                                            {{ number_format($factorPotenciaPromedio[0]->fp_promedio, 2) }}
                                                        </h3>
                                                    @else
                                                        <p class="text-yellow-500">No hay datos</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- TENSION FASE 1 --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">Tensión Fase 1</h1>
                                                    <div id="graficoTensionFase1" class="h-40"></div>
                                                </div>

                                                <div class="p-4 flex justify-center">
                                                    <div class="flex space-x-4">
                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Mín</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $tensionFase[0]->volt_fase_1_minimo ?? 0 }}V
                                                            </p>
                                                        </div>

                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Máx</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $tensionFase[0]->volt_fase_1_maximo ?? 0 }}V
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- TENSION FASE 2 --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">Tensión Fase 2</h1>
                                                    <div id="graficoTensionFase2" class="h-40"></div>
                                                </div>

                                                <div class="p-4 flex justify-center">
                                                    <div class="flex space-x-4">
                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Mín</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $tensionFase[0]->volt_fase_2_minimo ?? 0 }}V
                                                            </p>
                                                        </div>

                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Máx</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $tensionFase[0]->volt_fase_2_maximo ?? 0 }}V
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            {{-- TENSION FASE 3 --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">Tensión Fase 3</h1>
                                                    <div id="graficoTensionFase3" class="h-40"></div>
                                                </div>

                                                <div class="p-4 flex justify-center">
                                                    <div class="flex space-x-4">
                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Mín</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $tensionFase[0]->volt_fase_3_minimo ?? 0 }}V
                                                            </p>
                                                        </div>

                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Máx</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $tensionFase[0]->volt_fase_3_maximo ?? 0 }}V
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        {{-- PRIMERA FILA NARANJA --}}

                                        <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
                                            Tensiones (Voltaje Por Fase)
                                        </h1>
                                        <div
                                            style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
                                        </div>                                    


                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA --}}
                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (!isset($tensionesPorFase))
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center text-yellow-500">No hay datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntos"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoTensionesPorFase" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 1 --}}
                                        <script>
                                            /************************************************
                                             * 1. Preparación y ordenación de datos
                                             ***********************************************/
                                            var dataVoltajes = [];

                                            @if ($tensionesPorFase && count($tensionesPorFase) > 0)
                                                @foreach ($tensionesPorFase as $resultado)
                                                    @if (isset($resultado->fh))
                                                        dataVoltajes.push({
                                                            label: '{{ $resultado->fh }}',
                                                            phase1: {{ $resultado->volt_phase_1 ?? 'null' }},
                                                            phase2: {{ $resultado->volt_phase_2 ?? 'null' }},
                                                            phase3: {{ $resultado->volt_phase_3 ?? 'null' }}
                                                        });
                                                    @endif
                                                @endforeach
                                            @endif

                                            // Ordenar por fecha real
                                            dataVoltajes.sort(function(a, b) {
                                                return new Date(a.label) - new Date(b.label);
                                            });

                                            // Separar etiquetas y valores
                                            var labels = dataVoltajes.map(item => {
                                                const date = new Date(item.label);
                                                return date.toLocaleString('es-ES', {
                                                    year: 'numeric',
                                                    month: '2-digit',
                                                    day: '2-digit',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                });
                                            });
                                            var valuesPhase1 = dataVoltajes.map(item => item.phase1);
                                            var valuesPhase2 = dataVoltajes.map(item => item.phase2);
                                            var valuesPhase3 = dataVoltajes.map(item => item.phase3);

                                            /************************************************
                                             * 2. Creación del gráfico con las 3 fases
                                             ***********************************************/
                                            if (labels.length > 0) {
                                                var canvas = document.getElementById('graficoTensionesPorFase');
                                                if (canvas) {
                                                    var ctx = canvas.getContext('2d');

                                                    new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: labels,
                                                            datasets: [
                                                                {
                                                                    label: 'Fase 1',
                                                                    data: valuesPhase1,
                                                                    borderColor: 'rgb(238,145,4)',
                                                                    backgroundColor: 'rgba(238,145,4,0.3)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                    pointRadius: 3
                                                                },
                                                                {
                                                                    label: 'Fase 2',
                                                                    data: valuesPhase2,
                                                                    borderColor: 'rgb(72, 200, 50)',
                                                                    backgroundColor: 'rgba(72, 200, 50,0.3)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                    pointRadius: 3
                                                                },
                                                                {
                                                                    label: 'Fase 3',
                                                                    data: valuesPhase3,
                                                                    borderColor: 'rgb(50,150,250)',
                                                                    backgroundColor: 'rgba(50,150,250,0.3)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                    pointRadius: 3
                                                                }
                                                            ]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            plugins: {
                                                                legend: {
                                                                    position: 'bottom',
                                                                    labels: {
                                                                        color: '#FFFFFF',
                                                                        font: { family: 'Didact Gothic' }
                                                                    }
                                                                },
                                                                tooltip: {
                                                                    callbacks: {
                                                                        label: function(context) {
                                                                            return context.dataset.label + ': ' + context.parsed.y + ' V';
                                                                        }
                                                                    }
                                                                }
                                                            },
                                                            scales: {
                                                                x: {
                                                                    type: 'category',
                                                                    grid: { color: 'rgb(50, 50, 50)' },
                                                                    ticks: { color: '#FFFFFF', maxRotation: 45, minRotation: 45 }
                                                                },
                                                                y: {
                                                                    beginAtZero: true,
                                                                    grid: { color: 'rgb(50, 50, 50)' },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 50,
                                                                        callback: v => v + ' V'
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            } else {
                                                console.log('No hay datos de tensión para mostrar el gráfico.');
                                            }
                                        </script>


                                        {{-- TERCERA FILA --}}
                                        <div id="desequilibrios"
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-0">

                                            {{-- INTENSIDAD FASE 1 --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">Intensidad Fase 1</h1>
                                                    <div id="graficoIntensidadFase1" class="h-40"></div>
                                                </div>

                                                <div class="p-4 flex justify-center">
                                                    <div class="flex space-x-4">
                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Mín</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $intensidadFase[0]->current_fase_1_minimo ?? 0 }}A
                                                            </p>
                                                        </div>

                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Máx</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $intensidadFase[0]->current_fase_1_maximo ?? 0 }}A
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- INTENSIDAD FASE 2 --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">Intensidad Fase 2</h1>
                                                    <div id="graficoIntensidadFase2" class="h-40"></div>
                                                </div>

                                                <div class="p-4 flex justify-center">
                                                    <div class="flex space-x-4">
                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Mín</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $intensidadFase[0]->current_fase_2_minimo ?? 0 }}A
                                                            </p>
                                                        </div>

                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Máx</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $intensidadFase[0]->current_fase_2_maximo ?? 0 }}A
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            {{-- INTENSIDAD FASE 3 --}}
                                            <div class="card text-white mb-3 col-span-1"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                                <div class="p-4 flex flex-col justify-center items-center">
                                                    <h1 class="text-center text-md font-normal mb-2 mt-4">Intensidad Fase 3</h1>
                                                    <div id="graficoIntensidadFase3" class="h-40"></div>
                                                </div>

                                                <div class="p-4 flex justify-center">
                                                    <div class="flex space-x-4">
                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Mín</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $intensidadFase[0]->current_fase_3_minimo ?? 0 }}A
                                                            </p>
                                                        </div>

                                                        <div class="rounded-lg p-4 text-center"
                                                            style="background: linear-gradient(135deg, rgba(88,226,194,.9), rgb(56,125,109));">
                                                            <h2 class="text-sm">Máx</h2>
                                                            <p class="text-xl font-bold">
                                                                {{ $intensidadFase[0]->current_fase_3_maximo ?? 0 }}A
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA --}}
                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (!isset($intensidadesPorFase))
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center text-yellow-500">No hay datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntos"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoIntensidadesPorFase" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 1 --}}
                                        <script>
                                            /************************************************
                                             * 1. Preparación y ordenación de datos
                                             ***********************************************/
                                            var dataVoltajes = [];

                                            @if ($intensidadesPorFase && count($intensidadesPorFase) > 0)
                                                @foreach ($intensidadesPorFase as $resultado)
                                                    @if (isset($resultado->fh))
                                                        dataVoltajes.push({
                                                            label: '{{ $resultado->fh }}',
                                                            phase1: {{ $resultado->current_phase_1 ?? 'null' }},
                                                            phase2: {{ $resultado->current_phase_2 ?? 'null' }},
                                                            phase3: {{ $resultado->current_phase_3 ?? 'null' }}
                                                        });
                                                    @endif
                                                @endforeach
                                            @endif

                                            // Ordenar por fecha real
                                            dataVoltajes.sort(function(a, b) {
                                                return new Date(a.label) - new Date(b.label);
                                            });

                                            // Separar etiquetas y valores
                                            var labels = dataVoltajes.map(item => {
                                                const date = new Date(item.label);
                                                return date.toLocaleString('es-ES', {
                                                    year: 'numeric',
                                                    month: '2-digit',
                                                    day: '2-digit',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                });
                                            });
                                            var valuesPhase1 = dataVoltajes.map(item => item.phase1);
                                            var valuesPhase2 = dataVoltajes.map(item => item.phase2);
                                            var valuesPhase3 = dataVoltajes.map(item => item.phase3);

                                            /************************************************
                                             * 2. Creación del gráfico con las 3 fases
                                             ***********************************************/
                                            if (labels.length > 0) {
                                                var canvas = document.getElementById('graficoIntensidadesPorFase');
                                                if (canvas) {
                                                    var ctx = canvas.getContext('2d');

                                                    new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: labels,
                                                            datasets: [
                                                                {
                                                                    label: 'Fase 1',
                                                                    data: valuesPhase1,
                                                                    borderColor: 'rgb(238,145,4)',
                                                                    backgroundColor: 'rgba(238,145,4,0.3)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                    pointRadius: 3
                                                                },
                                                                {
                                                                    label: 'Fase 2',
                                                                    data: valuesPhase2,
                                                                    borderColor: 'rgb(72, 200, 50)',
                                                                    backgroundColor: 'rgba(72, 200, 50,0.3)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                    pointRadius: 3
                                                                },
                                                                {
                                                                    label: 'Fase 3',
                                                                    data: valuesPhase3,
                                                                    borderColor: 'rgb(50,150,250)',
                                                                    backgroundColor: 'rgba(50,150,250,0.3)',
                                                                    fill: true,
                                                                    tension: 0.4,
                                                                    pointRadius: 3
                                                                }
                                                            ]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            plugins: {
                                                                legend: {
                                                                    position: 'bottom',
                                                                    labels: {
                                                                        color: '#FFFFFF',
                                                                        font: { family: 'Didact Gothic' }
                                                                    }
                                                                },
                                                                tooltip: {
                                                                    callbacks: {
                                                                        label: function(context) {
                                                                            return context.dataset.label + ': ' + context.parsed.y + ' V';
                                                                        }
                                                                    }
                                                                }
                                                            },
                                                            scales: {
                                                                x: {
                                                                    type: 'category',
                                                                    grid: { color: 'rgb(50, 50, 50)' },
                                                                    ticks: { color: '#FFFFFF', maxRotation: 45, minRotation: 45 }
                                                                },
                                                                y: {
                                                                    beginAtZero: true,
                                                                    grid: { color: 'rgb(50, 50, 50)' },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 50,
                                                                        callback: v => v + ' V'
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            } else {
                                                console.log('No hay datos de tensión para mostrar el gráfico.');
                                            }
                                        </script>

                                        @if (count($detallesValoresInstantaneos) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                <table id="testTableEventos"
                                                    class="w-full text-white text-center ">
                                                    <thead
                                                        style="border-bottom: 1px solid #ffffff;">
                                                        <tr>
                                                            <th class="mt-0 text-xl  text-center"
                                                                style="color:rgb(88,226,194)">
                                                                Fecha</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                FP Total</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                V F1 (V)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                V F2 (V)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                V F3 (V)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                I F1 (A)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                I F2 (A)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                I F3 (A)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                P Act (kW)</th>
                                                            <th class="mt-0 text-xl font-bold text-center"
                                                                style="color:rgb(88,226,194)">
                                                                P React (kVAr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($detallesValoresInstantaneos as $resultado)
                                                            <tr class="highlight-row ">
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->fecha) ? $resultado->fecha : 'No hay datos' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->factor_potencia_total) ? $resultado->factor_potencia_total : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->voltaje_fase_1) ? $resultado->voltaje_fase_1 : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->voltaje_fase_2) ? $resultado->voltaje_fase_2 : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->voltaje_fase_3) ? $resultado->voltaje_fase_3 : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->intensidad_fase_1) ? $resultado->intensidad_fase_1 : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->intensidad_fase_2) ? $resultado->intensidad_fase_2 : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->intensidad_fase_3) ? $resultado->intensidad_fase_3 : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->potencia_activa) ? $resultado->potencia_activa : '0' }}
                                                                </td>
                                                                <td class="py-2">
                                                                    {{ !empty($resultado->potencia_reactiva) ? $resultado->potencia_reactiva : '0' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="pagination-container mt-4 flex justify-center items-center">
                                                <div class="pagination">
                                                    {{ $detallesValoresInstantaneos->links() }}
                                                </div>
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
                                @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>