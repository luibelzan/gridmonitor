<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    {{-- MAPA --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
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
    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.31.1.min.js'></script> <!-- Load plotly.js into the DOM -->
    {{-- JAVASCRIPT --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!--icono cargando -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">    
    <style>
        /* botones menu mapa */
        .btn-group-option .btn-option {
            background-color: transparent;
            border-color: rgb(255, 255, 255);
            color: white;
        }


        .btn-group-option .btn-option:hover {
            border-color: rgb(88, 226, 194);
            color: rgb(88, 226, 194);
        }


        .btn-group-option .btn-option.active {
            background-color: rgb(88, 226, 194) !important;
            border-color: rgb(0, 0, 0) !important;
            color: rgb(0, 0, 0) !important;
        }


        .nav-link.active {
            background-color: white !important;
            color: black !important;
        }



        .tab-content {
            background-color: white !important;
            /* Agrega un poco de relleno para que el contenido no esté pegado a los bordes */
        }



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
        /* Estilos para .custom-nav */
        .custom-nav {
            display: inline-flex;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            background-color: rgb(27, 32, 38);
            padding: 0 20px;
            border-radius: 40px;
            margin: auto;
            /* Centra horizontalmente */
        }


        .custom-nav .nav-item {
            color: #ffffff;
            padding: 12px;
            text-decoration: none;
            transition: .3s;
            margin: 0 6px;
            z-index: 1;
            font-weight: 500;
            position: relative;
        }


        .custom-nav .nav-item:before {
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


        .custom-nav .nav-item:not(.is-active):hover:before {
            opacity: 1;
            bottom: 0;
        }


        .custom-nav .nav-item.is-active:before {
            background-color: rgb(88, 226, 194);
            opacity: 1;
            bottom: 0;
        }


        .custom-nav .nav-item:not(.is-active):hover {
            color: rgb(88, 226, 194);
        }


        .custom-nav .nav-indicator {
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
    </style>
    <title>Caidas de tension</title>
</head>

<script>
$(document).ready(function() {
    // Cuando cambia el CT
    $('#id_ct').on('change', function() {
        var id_ct = $(this).val();
        var $lineaSelect = $('#id_linea');
        //$lineaSelect.hide().empty().append('<option disabled selected>Cargando...</option>');

        if (id_ct) {
            $.ajax({
                url: "{{ url('/lineas') }}/" + id_ct,
                type: "GET",
                success: function(data) {
                    $lineaSelect.empty().append('<option disabled selected>Seleccione una línea</option>');
                    $.each(data, function(key, linea) {
                        $lineaSelect.append('<option value="' + linea.id_linea + '">' + linea.nom_linea + '</option>');
                    });
                    $lineaSelect.show();
                },
                error: function() {
                    $lineaSelect.empty().append('<option disabled selected>Error al cargar</option>');
                }
            });
        }
    });

    // Si cambia la línea, enviar el formulario automáticamente
    /*$('#id_linea').on('change', function() {
        $('#form-caidas').submit();
    });
    */
});
</script>


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
            <div class="lg:ml-14 p-2 mt-0 w-full">
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}
                    <x-nav-sabt/> 

                    {{-- Obtener el id_ct almacenado en la sesión --}}
                    @php
                        $id_ct = session()->get('id_ct');
                    @endphp

                    {{-- Selector de CT --}}
                    <div class="container">
                        <form id="form-caidas" style="color: white; background-color: transparent;" class="flex items-center space-x-4"
                            action="{{ route('caidastensionsabt') }}" method="GET">

                            {{-- Selector de CT --}}
                            <select id="id_ct" name="id_ct" class="form-control mt-2"
                                style="color: white; background-color: rgb(27, 32, 38); width: min-content; font-size: 14px; text-align: left;">
                                <option disabled selected>Seleccione un CT</option>
                                @foreach ($ct_info as $ct_item)
                                    @if ($ct_item->ind_sabt)
                                        <option value="{{ $ct_item->id_ct }}" {{ $id_ct == $ct_item->id_ct ? 'selected' : '' }}>
                                            {{ $ct_item->nom_ct }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            {{-- Selector de Línea (se llena dinámicamente) --}}
                            <select id="id_linea" name="id_linea" class="form-control mt-2"
                                style="color: white; background-color: rgb(27, 32, 38); width: min-content; font-size: 14px; text-align: left;">
                                <option disabled selected>Seleccione una línea</option>
                            </select>

                            <div class="flex items-center mt-2 gap-2">
                                <label for="fecha_inicio">Fecha inicio:</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="border border-gray-500 rounded-md p-1 text-white"
                                    style="background-color: transparent;"
                                    @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                    max="{{ date('Y-m-d') }}">
                            </div>

                            <div class="flex items-center mt-2 gap-2">
                                <label for="fecha_fin">Fecha fin:</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="border border-gray-500 rounded-md p-1 text-white"
                                    style="background-color: transparent;"
                                    @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                    max="{{ date('Y-m-d') }}">
                            </div>

                            <button type="submit"
                                class="btn btn-outline-info mt-2 mb-0 text-white"
                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                        </form>
                    </div>
                    
                    @if(count($caidasTension) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            <div class="card text-white  mb-2"
                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <!-- Contenido de S1 -->
                                <div class="overflow-x-auto">
                                    {{-- CONTENIDO AQUI --}}
                                    <h1 class="text-center text-2xl" style="color: white;">
                                        Caidas Tension </h1>
                                    <div
                                        style="border-bottom: 3px solid transparent;
                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                    </div>

                                    <div class="container">
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                            
                                            @php
                                            $distancias = [];
                                            $voltajes = [];

                                            if(isset($caidasTension) && count($caidasTension) > 0) {
                                                foreach($caidasTension as $cup) {
                                                    if(is_object($cup)) {
                                                        $distancias[] = round($cup->distancia_m); 
                                                        $voltajes[] = round($cup->avg_l1v_total, 2);
                                                    }
                                                }
                                            }
                                            @endphp

                                            @if(count($distancias) > 0)
                                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                <canvas id="voltajeDistanciaChart"></canvas>
                                            </div>

                                            <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const ctx = document.getElementById('voltajeDistanciaChart').getContext('2d');

                                                // Combinar distancias y voltajes en un array de objetos {x, y}
                                                const lineData = {!! json_encode(
                                                    array_map(function($d, $v) { return ['x' => $d, 'y' => $v]; }, $distancias, $voltajes)
                                                ) !!};

                                                const voltajeDistanciaChart = new Chart(ctx, {
                                                    type: 'line', // Cambiado de scatter a line
                                                    data: {
                                                        datasets: [{
                                                            label: 'Voltaje promedio (V)',
                                                            data: lineData,
                                                            backgroundColor: 'rgba(88, 226, 194, 0.7)',
                                                            borderColor: 'rgba(88, 226, 194, 1)',
                                                            borderWidth: 2,
                                                            pointRadius: 6,      // Tamaño de los puntos
                                                            pointBackgroundColor: 'rgba(88, 226, 194, 1)',
                                                            fill: false,
                                                            showLine: true       // Conecta los puntos con líneas
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        plugins: {
                                                            legend: {
                                                                labels: { color: 'white' }
                                                            },
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: function(context) {
                                                                        return `Distancia: ${context.parsed.x} m, Voltaje: ${context.parsed.y} V`;
                                                                    }
                                                                }
                                                            }
                                                        },
                                                        scales: {
                                                            x: {
                                                                type: 'linear',
                                                                title: {
                                                                    display: true,
                                                                    text: 'Distancia al CT (m)',
                                                                    color: 'white',
                                                                    font: { size: 14 }
                                                                },
                                                                ticks: { color: 'white' },
                                                                grid: { color: 'rgba(255,255,255,0.1)' }
                                                            },
                                                            y: {
                                                                title: {
                                                                    display: true,
                                                                    text: 'Voltaje promedio (V)',
                                                                    color: 'white',
                                                                    font: { size: 14 }
                                                                },
                                                                ticks: { color: 'white' },
                                                                grid: { color: 'rgba(255,255,255,0.1)' }
                                                            }
                                                        }
                                                    }
                                                });
                                            });
                                            </script>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    
                </div>
            </div>
        </div>
    </div>




</body>