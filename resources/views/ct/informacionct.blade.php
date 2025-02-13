<!DOCTYPE html>
<html lang="en">








<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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








    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-option');
            const fechaLecturasContainer = document.getElementById('fecha_lecturas_container');
            const fechaInicioContainer = document.getElementById('fecha_inicio_container');
            const fechaFinContainer = document.getElementById('fecha_fin_container');
            // Eliminar cualquier opción guardada en localStorage
            localStorage.removeItem('selectedOption');
            // Restaurar la opción seleccionada desde sessionStorage
            const selectedOption = sessionStorage.getItem('selectedOption') || 'option1';
            if (selectedOption) {
                const selectedButton = document.querySelector(`.btn-option[data-option="${selectedOption}"]`);
                if (selectedButton) {
                    selectedButton.click();
                    setFechaContainersVisibility(selectedOption);
                }
            }
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedOption = this.getAttribute('data-option');
                    sessionStorage.setItem('selectedOption', selectedOption);
                    setFechaContainersVisibility(selectedOption);
                });
            });


            function setFechaContainersVisibility(option) {
                if (option === 'option6') {
                    fechaLecturasContainer.style.display = 'block';
                    fechaInicioContainer.style.display = 'none';
                    fechaFinContainer.style.display = 'none';
                } else {
                    fechaLecturasContainer.style.display = 'none';
                    fechaInicioContainer.style.display = 'block';
                    fechaFinContainer.style.display = 'block';
                }
            }
        });


        function setActive(button) {
            var buttons = document.querySelectorAll('.btn-option');
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            button.classList.add('active');
        }
    </script>
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




    <title>Información CT</title>
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
            <div class="lg:ml-14 p-2 mt-0 w-full">
                <!-- Content -->
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    {{-- Botones de arriba --}}


                    <nav class="nav custom-nav mb-12">
                        <a href="{{ route('dashboardct') }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Dashboard</a>
                        <a href="{{ route('informacionct', ['id_ct' => $id_ct]) }}" class="nav-item is-active"
                            active-color="rgb(88, 226, 194)">Información</a>
                        <a href="{{ route('energia', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Energía</a>
                        <a href="{{ route('señalplc', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Lecturas/Señal PLC</a>
                        @foreach ($ct_info as $ct)
                            @if ($ct->id_ct == $id_ct && $ct->ind_balance == true)
                                <a href="{{ route('balances', ['id_ct' => $id_ct]) }}" class="nav-item"
                                    active-color="rgb(88, 226, 194)">Balances</a>
                            @endif
                        @endforeach
                        <a href="{{ route('eventosct', ['id_ct' => $id_ct]) }}" class="nav-item"
                            active-color="rgb(88, 226, 194)">Eventos</a>
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
                                action="{{ route('informacionct', ['id_ct' => $id_ct]) }}" method="GET">
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">INFORMACIÓN DEL C.T</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                                border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                            </div>
                            {{-- CONTENEDOR CUERPO --}}
                            @foreach ($ct_info as $ct)
                                @if ($ct->id_ct == $id_ct)
                                    <div class="container ">
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                                            {{-- PRIMERA FILA --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                                    IDENTIFICACIÓN
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col">
                                                                <!-- Cuadrado para ID -->
                                                                <div
                                                                    class="p-2 #205E86 text-white rounded-lg shadow-xl ">
                                                                    <h2 class="text-sm text-center font-normal">ID</h2>
                                                                    <p class="mt-2 text-sm  text-center"
                                                                        style="color:rgb(88,226,194);  ">
                                                                        {{ $ct->id_ct }}</p>
                                                                    <div
                                                                        style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <!-- Cuadrado para Nombre -->
                                                                <div
                                                                    class="p-2 #205E86 text-white rounded-lg shadow-xl   ">
                                                                    <h2 class="text-sm text-center font-normal">Nombre
                                                                    </h2>
                                                                    <p class="mt-2 text-sm  text-center"
                                                                        style="color:rgb(88,226,194); ">
                                                                        {{ !empty($ct->nom_ct) ? $ct->nom_ct : 'No hay datos' }}
                                                                    </p>
                                                                    <div
                                                                        style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <!-- Cuadrado para Número de Trafos -->
                                                                <div
                                                                    class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                    <h2 class="text-sm text-center font-normal">Nº de
                                                                        Trafos
                                                                    </h2>
                                                                    <p class="mt-2 text-sm  text-center"
                                                                        style="color:rgb(88,226,194);">
                                                                        {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->nro_trafos) ? $resultadosQ1[0]->nro_trafos : 'No hay datos' }}
                                                                    </p>
                                                                    <div
                                                                        style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <!-- Cuadrado para Capacidad (KVA) -->
                                                                <div
                                                                    class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                    <h2 class="text-sm text-center font-normal">
                                                                        Capacidad
                                                                    </h2>
                                                                    <p class="mt-2 text-sm  text-center"
                                                                        style="color:rgb(88,226,194);">
                                                                        {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->kva_ct) ? $resultadosQ1[0]->kva_ct . ' kVA' : 'No hay datos' }}
                                                                    </p>
                                                                    <div
                                                                        style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <!-- Cuadrado para Número de Cups -->
                                                                <div
                                                                    class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                    <h2 class="text-sm text-center font-normal">Nº de
                                                                        cups
                                                                    </h2>
                                                                    <p class="mt-0 text-sm  text-center"
                                                                        style="color:rgb(88,226,194);">
                                                                        {{ count($resultadosQ2) > 0 && !empty($resultadosQ2[0]->nro_cups) ? number_format($resultadosQ2[0]->nro_cups, 0, '.', '.') : 'No hay datos' }}
                                                                    </p>
                                                                    <div
                                                                        style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <!-- Cuadrado para Número de Autoconsumos -->
                                                                <div
                                                                    class="p-0 #205E86 text-white rounded-lg shadow-xl">
                                                                    <h2 class="text-sm text-center font-normal">Nº
                                                                        Autoconsumos
                                                                    </h2>
                                                                    <p class="mt-0 text-sm  text-center"
                                                                        style="color:rgb(88,226,194)">
                                                                        {{ count($resultadosQ4) > 0 && !empty($resultadosQ4[0]->nro_autoconsumos) ? $resultadosQ4[0]->nro_autoconsumos : 'No hay datos' }}
                                                                    </p>
                                                                    <div
                                                                        style="border-bottom: 3px solid transparent;
                                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <!-- Cuadrado para Número de Líneas -->
                                                                <div
                                                                    class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                    <h2 class="text-sm text-center font-normal">Nº de
                                                                        lineas
                                                                    </h2>
                                                                    <p class="mt-2 text-sm  text-center"
                                                                        style="color:rgb(88,226,194)">
                                                                        {{ count($resultadosQ5) > 0 && !empty($resultadosQ5[0]->nro_lineas) ? $resultadosQ5[0]->nro_lineas : 'No hay datos' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- 2º cuadro --}}
                                            {{-- IMAGEN --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                                    REFERENCIA
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="m-4 mb-4 flex justify-around items-center"
                                                    style="display: flex; justify-content: center; align-items: center;">
                                                    @if (file_exists(public_path('images/imagesct/' . $ct->id_ct . '_' . $ct->nom_ct . '.jpeg')))
                                                        <img src="../../images/imagesct/{{ $ct->id_ct }}_{{ $ct->nom_ct }}.jpeg"
                                                            alt="Imagen del {{ $ct->nom_ct }}"
                                                            style="width: auto; height: 100%;">
                                                    @else
                                                        <img src="../../images/imagesct/default.png"
                                                            alt="Imagen predeterminada"
                                                            style="width: auto; height: 100%;">
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- 3º cuadro --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                                    DATOS DC
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para Concentrador -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">
                                                                    Concentrador
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->id_cnc) ? $resultadosQ1[0]->id_cnc : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Supervisor -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Supervisor
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->id_svr) ? $resultadosQ1[0]->id_svr : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para Año de Fabricación -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">
                                                                    Fabricación
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->des_cnc_af) ? 'Año ' . $resultadosQ1[0]->des_cnc_af : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Modelo -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Modelo</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->cod_mod) ? $resultadosQ1[0]->cod_mod : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para Fw DLMS -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Fw DLMS
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->des_vdlms) ? $resultadosQ1[0]->des_vdlms : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para URL -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">URL</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->dc_url) ? $resultadosQ1[0]->dc_url : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- 4º cuadro --}}
                                            <div class="card text-white  mb-2"
                                                style="
                                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                                    COMUNICACIONES
                                                </h1>
                                                <div
                                                    style="border-bottom: 3px solid transparent;
                                                    border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para id_hw -->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">ID</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ17) > 0 && !empty($resultadosQ17[0]->id_hw) ? $resultadosQ17[0]->id_hw : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Número hw -->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Nº Serie
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ17) > 0 && !empty($resultadosQ17[0]->nro_hw) ? $resultadosQ17[0]->nro_hw : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para MOD_HW -->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Modelo</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ17) > 0 && !empty($resultadosQ17[0]->mod_hw) ? $resultadosQ17[0]->mod_hw : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para Tipo hw-->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Tipo Equipo
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ17) > 0 && !empty($resultadosQ17[0]->tip_hw) ? $resultadosQ17[0]->tip_hw : 'No hay datos' }}
                                                                </p>
                                                                <div
                                                                    style="border-bottom: 3px solid transparent;
                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Cuadrado para fw hw -->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Firmware
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ17) > 0 && !empty($resultadosQ17[0]->fw_hw) ? $resultadosQ17[0]->fw_hw : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para url hw -->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">URL</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($resultadosQ17) > 0 && !empty($resultadosQ17[0]->url_hw) ? $resultadosQ17[0]->url_hw : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SEGUNDA FILA --}}
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                                        <div class="container">
                                            <div class="card text-white  mb-3"
                                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                                    GEOLOCALIZACIÓN
                                                    DE
                                                    PUNTOS DE MEDIDA</h1>
                                                <div class="mb-4"
                                                    style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>
                                                @if (!empty($cups_info) && count($cups_info) > 0)
                                                    {{-- Contiene el filtro fechas y el menu del mapa --}}
                                                    <div class="d-flex justify-content-center mb-0">
                                                        <div class="grid grid-cols-1 lg:grid-cols-1 gap-2 mb-0">
                                                            <!-- Filtro de búsqueda -->
                                                            <div
                                                                class="col-span-1 d-flex flex-wra justify-content-center ">
                                                                <!-- Agregamos flex-wrap para que los elementos se envuelvan en pantallas pequeñas -->
                                                                <form
                                                                    action="{{ route('informacionct', ['id_ct' => $id_ct]) }}"
                                                                    method="GET"
                                                                    class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 space-x-0 sm:space-x-4 mb-4 mt-4 mr-2">
                                                                    <input type="hidden" name="id_ct"
                                                                        value="{{ $id_ct }}">
                                                                    <div class="form-group"
                                                                        id="fecha_lecturas_container"
                                                                        style="display: none;">
                                                                        <label for="fecha_lecturas"
                                                                            class="text-white">Fecha:</label>
                                                                        <input type="date" id="fecha_lecturas"
                                                                            name="fecha_lecturas"
                                                                            class="border border-gray-400 p-2 rounded-lg text-white"
                                                                            @if (isset($_GET['fecha_lecturas'])) value="{{ $_GET['fecha_lecturas'] }}" @endif
                                                                            max="{{ date('Y-m-d') }}"
                                                                            style="background-color: transparent;">
                                                                    </div>
                                                                    <div class="form-group"
                                                                        id="fecha_inicio_container">
                                                                        <label for="fecha_inicio"
                                                                            class="text-white">Fecha de inicio:</label>
                                                                        <input type="date" id="fecha_inicio"
                                                                            name="fecha_inicio"
                                                                            class="border border-gray-400 p-2 rounded-lg text-white"
                                                                            @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                                            max="{{ date('Y-m-d') }}"
                                                                            style="background-color: transparent;">
                                                                    </div>
                                                                    <div class="form-group" id="fecha_fin_container">
                                                                        <label for="fecha_fin"
                                                                            class="text-white">Fecha de fin:</label>
                                                                        <input type="date" id="fecha_fin"
                                                                            name="fecha_fin"
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
                                                            </div>
                                                            <!-- Menú del mapa -->
                                                            <div
                                                                class="d-flex flex-wrap justify-content-center btn-group-option">
                                                                <button class="btn btn-option mr-3 mb-3"
                                                                    data-option="option1" id="btnOption1"
                                                                    onclick="setActive(this)">
                                                                    Conectividad
                                                                </button>
                                                                <button class="btn btn-option mr-3 mb-3"
                                                                    data-option="option6" id="btnOption6"
                                                                    onclick="setActive(this)">
                                                                    Lecturas
                                                                </button>
                                                                <button class="btn btn-option mr-3 mb-3"
                                                                    data-option="option2" id="btnOption2"
                                                                    onclick="setActive(this)">
                                                                    Sobretensiones
                                                                </button>
                                                                <button class="btn btn-option mr-3 mb-3"
                                                                    data-option="option3" id="btnOption3"
                                                                    onclick="setActive(this)">
                                                                    Subtensiones
                                                                </button>
                                                                <button class="btn btn-option mr-3 mb-3"
                                                                    data-option="option4" id="btnOption4"
                                                                    onclick="setActive(this)">
                                                                    Cortes
                                                                </button>
                                                                <button class="btn btn-option mr-3 mb-3"
                                                                    data-option="option5" id="btnOption5"
                                                                    onclick="setActive(this)">
                                                                    Microcortes
                                                                </button>


                                                                <button class="btn btn-option mb-3"
                                                                    data-option="option7" id="btnOption7"
                                                                    onclick="setActive(this)">
                                                                    Niveles de Tensión
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    {{-- Mapa --}}
                                                    <button id="mapButton" onclick="zoomMap()"
                                                        style="display: flex; align-items: center; justify-content: center; padding: 5px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                            viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                                            <path
                                                                d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Zm-40-60v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Z" />
                                                        </svg>
                                                        Ampliar mapa
                                                    </button>




                                                    <div id="map" style="height: 350px; width: 100%;"></div>




                                                    <script> //funcion para ampliar y reducir mapa
                                                        function zoomMap() {
                                                            var mapDiv = document.getElementById('map');
                                                            var button = document.getElementById('mapButton');




                                                            if (mapDiv.style.height === '350px') {
                                                                mapDiv.style.height = '750px'; // Cambia el tamaño del mapa al pulsar el botón si está en tamaño original
                                                                button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400ZM280-540v-80h200v80H280Z"/></svg>
                                                                            Disminuir mapa`;
                                                            } else {
                                                                mapDiv.style.height = '350px'; // Restaura el tamaño original si ya está ampliado
                                                                button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Zm-40-60v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Z"/></svg>
                                                                            Ampliar mapa`;
                                                            }




                                                            map.invalidateSize(); // Ajusta el tamaño del mapa




                                                            // Scroll para centrar el mapa en la pantalla
                                                            mapDiv.scrollIntoView({
                                                                behavior: 'smooth',
                                                                block: 'center'
                                                            });
                                                        }
                                                    </script>


                                                    {{-- Script del Mapa --}}
                                                    <script>
                                                        var map = L.map('map').setView([0, 0], 2);
                                                        map.setMaxZoom(20);
                                                        //Distintos tipos de mapas                                                        
                                                        //GOOGLE MAPS
                                                        var googleMaps = L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                                                            maxZoom: 20,
                                                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                                                        });

                                                        //SATELITE
                                                        var satelite = L.tileLayer('https://mt{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                                                            maxZoom: 20,
                                                            subdomains: ['0', '1', '2', '3'],
                                                        });

                                                        //OPENSTREETMAP
                                                        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                            maxZoom: 20,
                                                        });

                                                        googleMaps.addTo(map);

                                                        map.removeControl(map.attributionControl);

                                                        @if (!empty($resultadosQ1[0]->lat_ct) && !empty($resultadosQ1[0]->lon_ct))
                                                            var ctLat = {{ $resultadosQ1[0]->lat_ct }};
                                                            var ctLon = {{ $resultadosQ1[0]->lon_ct }};
                                                            var ctIcon = L.divIcon({
                                                                html: `<img src="../../images/ct.png" alt="ctIcon" style="width: 40px; height: 40px; margin-right: 10px;">`,
                                                                className: 'ct-icon'
                                                            });

                                                            // PopUp del centro de transformacion
                                                            var ctMarker = L.marker([ctLat, ctLon], {
                                                                icon: ctIcon
                                                            }).bindPopup(`
                                                                <div class="custom-popup">
                                                                    <h3><strong>CENTRO DE TRANSFORMACIÓN</strong></h3>
                                                                    <ul>
                                                                        <li><strong>ID:</strong> {{ !empty($ct->id_ct) ? $ct->id_ct : 'No hay datos' }}</li>
                                                                        <li><strong>Nombre:</strong> {{ !empty($ct->nom_ct) ? $ct->nom_ct : 'No hay datos' }}</li>
                                                                        <li><strong>Nº de Trafos:</strong> {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->nro_trafos) ? $resultadosQ1[0]->nro_trafos : 'No hay datos' }}</li>
                                                                        <li><strong>Capacidad (KVA):</strong> {{ count($resultadosQ1) > 0 && !empty($resultadosQ1[0]->kva_ct) ? $resultadosQ1[0]->kva_ct . ' kVA' : 'No hay datos' }}</li>
                                                                        <li><strong>Nº de cups:</strong> {{ count($resultadosQ2) > 0 && !empty($resultadosQ2[0]->nro_cups) ? number_format($resultadosQ2[0]->nro_cups, 0, '.', '.') : 'No hay datos' }}</li>
                                                                        <li><strong>Nº Autoconsumos:</strong> {{ count($resultadosQ4) > 0 && !empty($resultadosQ4[0]->nro_autoconsumos) ? $resultadosQ4[0]->nro_autoconsumos : 'No hay datos' }}</li>
                                                                        <li><strong>Nº de líneas:</strong> {{ count($resultadosQ5) > 0 && !empty($resultadosQ5[0]->nro_lineas) ? $resultadosQ5[0]->nro_lineas : 'No hay datos' }}</li>
                                                                    </ul>
                                                                </div>
                                                            `, {
                                                                className: 'custom-popup'
                                                            });
                                                            // Agregar el marcador ctMarker al mapa
                                                            map.addLayer(ctMarker);
                                                        @endif

                                                        //CONECTIVIDAD
                                                        var markers = [];
                                                        var ubicaciones = [];
                                                        @foreach ($cups_info as $cups)
                                                            @if ($cups->lat_cups !== null && $cups->lon_cups !== null)
                                                                ubicaciones.push([{{ $cups->lat_cups }}, {{ $cups->lon_cups }}]);
                                                                @php
                                                                    $ultima_estadistica = $cups->estadisticasContadores->sortByDesc('fec_fin')->first();
                                                                    if ($ultima_estadistica == null) {
                                                                        if ($cups->ind_autoconsumo === 'S') {
                                                                            $iconUrl = $cups->num_fases === '1F' ? '../../images/casaverdepanelsolar1f.png' : '../../images/casaverdepanelsolar3f.png';
                                                                        } else {
                                                                            $iconUrl = $cups->num_fases === '1F' ? '../../images/casaverde1f.png' : '../../images/casaverde3f.png';
                                                                        }
                                                                    }
                                                                    if ($ultima_estadistica && $ultima_estadistica->por_minutos_contador !== null) {
                                                                        if ($ultima_estadistica->por_minutos_contador > 80) {
                                                                            if ($cups->ind_autoconsumo === 'S') {
                                                                                $iconUrl = $cups->num_fases === '1F' ? '../../images/casaverdepanelsolar1f.png' : '../../images/casaverdepanelsolar3f.png';
                                                                            } else {
                                                                                $iconUrl = $cups->num_fases === '1F' ? '../../images/casaverde1f.png' : '../../images/casaverde3f.png';
                                                                            }
                                                                        } elseif ($ultima_estadistica->por_minutos_contador >= 50 && $ultima_estadistica->por_minutos_contador <= 80) {
                                                                            if ($cups->ind_autoconsumo === 'S') {
                                                                                $iconUrl = $cups->num_fases === '1F' ? '../../images/casanaranjapanelsolar1f.png' : '../../images/casanaranjapanelsolar3f.png';
                                                                            } else {
                                                                                $iconUrl = $cups->num_fases === '1F' ? '../../images/casanaranja1f.png' : '../../images/casanaranja3f.png';
                                                                            }
                                                                        } else {
                                                                            if ($cups->ind_autoconsumo === 'S') {
                                                                                $iconUrl = $cups->num_fases === '1F' ? '../../images/casarojapanelsolar1f.png' : '../../images/casarojapanelsolar3f.png';
                                                                            } else {
                                                                                $iconUrl = $cups->num_fases === '1F' ? '../../images/casaroja1f.png' : '../../images/casaroja3f.png';
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                var icon = L.icon({
                                                                    iconUrl: '{{ $iconUrl }}',
                                                                    iconSize: [30, 40],
                                                                    iconAnchor: [15, 40],
                                                                    popupAnchor: [0, -30]
                                                                });
                                                                //PopUp de los contadores y su conectividad
                                                                var popupContent = "<div id='popup-map' class='popup-content'>";
                                                                popupContent +=
                                                                    "<h3><strong>{{ !empty($cups->nom_cups) ? $cups->nom_cups : 'No hay datos' }}</strong></h3>";
                                                                popupContent += "<ul class='nav nav-tabs'>";
                                                                popupContent +=
                                                                    "<li class='nav-item'><a class='nav-link active' href='#general' data-toggle='tab'>General</a></li>";
                                                                popupContent +=
                                                                    "<li class='nav-item'><a class='nav-link' href='#localizacion' data-toggle='tab'>Localización</a></li>";
                                                                popupContent += "</ul>";
                                                                popupContent += "<div class='tab-content'>";
                                                                popupContent += "<div class='tab-pane fade show active' id='general'>";
                                                                popupContent += "<ul>";
                                                                popupContent +=
                                                                    `<li><b>Id cups:</b> <a href="detallesinformacioncups?id_cups={{ $cups->id_cups }}" target="_blank">{{ $cups->id_cups }}</a></li>`;
                                                                popupContent += "<ul>";
                                                                popupContent += "<li><b>Contador:</b> {{ !empty($cups->id_cnt) ? $cups->id_cnt : 'No hay datos' }}</li>";
                                                                @if ($ultima_estadistica)
                                                                    popupContent +=
                                                                        "<li><b>Porcentaje conectividad:</b> {{ $ultima_estadistica->por_minutos_contador }}%</li>";
                                                                    popupContent += "<li><b>Fecha:</b> {{ date('d/m/y', strtotime($ultima_estadistica->fec_fin)) }}</li>";
                                                                    popupContent += "</ul>";
                                                                @else
                                                                    popupContent += "<li>Sin datos de estadísticas disponibles</li>";
                                                                @endif
                                                                popupContent += "</ul>";
                                                                popupContent += "</div>";
                                                                popupContent += "<div class='tab-pane fade' id='localizacion'>";
                                                                popupContent += "<ul>";
                                                                popupContent +=
                                                                    "<li><b>Latitud:</b> {{ !empty($cups->lat_cups) ? $cups->lat_cups : 'No hay datos' }}</li>";
                                                                popupContent +=
                                                                    "<li><b>Longitud:</b> {{ !empty($cups->lon_cups) ? $cups->lon_cups : 'No hay datos' }}</li>";
                                                                popupContent +=
                                                                    "<li><b>Dirección:</b> {{ !empty($cups->dir_cups) ? $cups->dir_cups : 'No hay datos' }}</li>";
                                                                popupContent += 
																	"<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>";
                                                                popupContent += "</ul>";
                                                                popupContent += "</div>";
                                                                popupContent += "</div>";
                                                                popupContent += "</div>";
                                                                var marker = L.marker([{{ $cups->lat_cups }}, {{ $cups->lon_cups }}], {
                                                                    icon: icon
                                                                }).bindPopup(popupContent, {
                                                                    className: 'custom-popup'
                                                                });
                                                                //markers.push(marker);
                                                                markers.push(marker);
                                                            @endif
                                                        @endforeach
                                                        var bounds = new L.LatLngBounds(ubicaciones);
                                                        map.fitBounds(bounds);
                                                        var capasConectividad = L.layerGroup(markers);



                                                        //SOBRETENSIONES
                                                        var capasSobretensiones = L.layerGroup([]);

                                                        @foreach ($resultadosQ28 as $sobretension)
                                                            // Obtener latitud y longitud del objeto $sobretension si existen
                                                            @if (isset($sobretension->lat_cups) && isset($sobretension->lon_cups))
                                                                var latCupsSobretension = '{{ $sobretension->lat_cups }}';
                                                                var lonCupsSobretension = '{{ $sobretension->lon_cups }}';
                                                                //console.log(latCupsSobretension, lonCupsSobretension);

                                                                // Verificar si latCups y lonCups no son cadena vacía
                                                                if (latCupsSobretension !== '' && lonCupsSobretension !== '') {
                                                                    @if (isset($sobretension->ind_autoconsumo))
                                                                        // Determinar la imagen basada en el valor de ind_autoconsumo
                                                                        var iconImage = "{{ $sobretension->ind_autoconsumo }}" === 'S' ?
                                                                            '../../images/casaverdepanelsolar.png' :
                                                                            '../../images/casaverde.png';
                                                                    @else
                                                                        var iconImage = '../../images/casaverde.png'; // imagen por defecto si no tiene ind_autoconsumo
                                                                    @endif


                                                                    var divIcon = L.divIcon({
                                                                        html: `<div style="position: relative; text-align: center; font-family: 'Didact Gothic', sans-serif;">
                                                            <img src="${iconImage}" style="width: 30px; height: 40px;">
                                                            <div style="position: absolute; bottom: 5px; left: 0; width: 100%; color: white; font-weight: bold; font-size: 12px; text-shadow: 0 0 4px black;">{{ $sobretension->nro_sobre_voltajes ?? ' ' }}</div>
                                                        </div>`,
                                                                        className: 'custom-div-icon',
                                                                        iconSize: [30, 40],
                                                                        iconAnchor: [15, 40],
                                                                        popupAnchor: [0, -40],
                                                                        shadowSize: [30, 30]
                                                                    });


                                                                    var marker = L.marker([latCupsSobretension, lonCupsSobretension], {
                                                                        icon: divIcon
                                                                    }).bindPopup(
                                                                        '<div id="popup-map" class="popup-content">' +
                                                                        // Nombre del cliente o CUPS
                                                                        '<h3><strong>{{ !empty($sobretension->nom_cups) ? $sobretension->nom_cups : 'No hay datos' }}</strong></h3>' +


                                                                        // Pestañas (General y Localización)
                                                                        '<ul class="nav nav-tabs">' +
                                                                        '<li class="nav-item"><a class="nav-link active" href="#general-sobretension" data-toggle="tab">General</a></li>' +
                                                                        '<li class="nav-item"><a class="nav-link" href="#localizacion-sobretension" data-toggle="tab">Localización</a></li>' +
                                                                        '</ul>' +


                                                                        // Contenido de las pestañas
                                                                        '<div class="tab-content">' +


                                                                        // Pestaña de General
                                                                        '<div class="tab-pane fade show active" id="general-sobretension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Id cups:</b> <a href="detallesenergiacups?id_cups={{ $sobretension->id_cups ?? ' ' }}" target="_blank">{{ $sobretension->id_cups ?? ' ' }}</a></li>' +
                                                                        '<li><b>Sobretensiones:</b> {{ $sobretension->nro_sobre_voltajes ?? ' ' }}</li>' +
                                                                        '<li><b>Última fecha:</b> {{ $sobretension->fecha ?? ' ' }}</li>' +
                                                                        '<li><b>Hora:</b> {{ $sobretension->hora ?? ' ' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion-sobretension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($sobretension->lat_cups) ? $sobretension->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($sobretension->lon_cups) ? $sobretension->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($sobretension->dir_cups) ? $sobretension->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        }
                                                                    );
                                                                    capasSobretensiones.addLayer(marker);
                                                                    
                                                                }
                                                            @endif
                                                        @endforeach        


                                                        //LECTURAS
                                                        var capasLecturas = L.layerGroup([]); // Mapa de lecturas

                                                        @php
                                                            $filtroFechaLectura = !empty($_GET['fecha_lecturas']) ? \Carbon\Carbon::createFromFormat('Y-m-d', $_GET['fecha_lecturas'])->format('Y-m-d') : \Carbon\Carbon::today()->format('Y-m-d');
                                                        @endphp

                                                        @foreach ($resultadosQ32 as $lectura)
                                                            @if (isset($lectura->lat_cups) && isset($lectura->lon_cups))
                                                                @php
                                                                    $fechaLectura = \Carbon\Carbon::createFromFormat('d/m/Y', $lectura->fecha)->format('Y-m-d');
                                                                @endphp


                                                                var iconUrlLectura;
                                                                var indAutoconsumo = '{{ $lectura->ind_autoconsumo }}';
                                                                var indS05 = '{{ $lectura->ind_s05 }}';
                                                                var latCupsLectura = '{{ $lectura->lat_cups }}';
                                                                var lonCupsLectura = '{{ $lectura->lon_cups }}';
                                                                var fechaLectura = '{{ $fechaLectura }}';
                                                                var filtroFechaLectura = '{{ $filtroFechaLectura }}';


                                                                if (latCupsLectura !== null && lonCupsLectura !== null) {
                                                                    if (indAutoconsumo !== '' && indS05 !== '') {
                                                                        if (fechaLectura === filtroFechaLectura) {
                                                                            if (indS05 === 'S' && indAutoconsumo === 'N') {
                                                                                iconUrlLectura = '../../images/casaverde.png';
                                                                            } else if (indS05 === 'S' && indAutoconsumo === 'S') {
                                                                                iconUrlLectura = '../../images/casaverdepanelsolar.png';
                                                                            } else if ((indS05 === 'N' || indS05 == null) && indAutoconsumo === 'N') {
                                                                                iconUrlLectura = '../../images/casaroja.png';
                                                                            } else if ((indS05 === 'N' || indS05 == null) && indAutoconsumo === 'S') {
                                                                                iconUrlLectura = '../../images/casarojapanelsolar.png';
                                                                            }
                                                                        } else if (indAutoconsumo === 'S') {
                                                                            iconUrlLectura = '../../images/casarojapanelsolar.png';
                                                                        } else {
                                                                            iconUrlLectura = '../../images/casaroja.png';
                                                                        }
                                                                    }


                                                                    var customIcon = L.icon({
                                                                        iconUrl: iconUrlLectura,
                                                                        iconSize: [30, 40],
                                                                        iconAnchor: [15, 40],
                                                                        popupAnchor: [0, -40],
                                                                        shadowSize: [30, 30]
                                                                    });


                                                                    var message = indS05 === 'S' ? 'Leído' : 'No leído';


                                                                    var lecturaMarker = L.marker([latCupsLectura, lonCupsLectura], {
                                                                        icon: customIcon
                                                                    }).bindPopup(
                                                                        '<div id="popup-map" class="popup-content">' +
                                                                        // Nombre del cliente
                                                                        '<h3><strong>{{ !empty($lectura->nom_cups) ? $lectura->nom_cups : 'No hay datos' }}</strong></h3>' +


                                                                        // Pestañas (General y Localización)
                                                                        '<ul class="nav nav-tabs">' +
                                                                        '<li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>' +
                                                                        '<li class="nav-item"><a class="nav-link" href="#localizacion" data-toggle="tab">Localización</a></li>' +
                                                                        '</ul>' +


                                                                        // Contenido de las pestañas
                                                                        '<div class="tab-content">' +


                                                                        // Pestaña de General
                                                                        '<div class="tab-pane fade show active" id="general">' +
                                                                        '<ul>' +
                                                                        '<li><b>Id cups:</b> <a href="detallesinformacioncups?id_cups={{ $lectura->id_cups ?? ' ' }}" target="_blank">{{ $lectura->id_cups ?? ' ' }}</a></li>' +
                                                                        '<li><b>Estado de Lectura:</b> ' + message + '</li>' +
                                                                        '<li><b>Fecha de Lectura:</b> {{ $lectura->fecha }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($lectura->lat_cups) ? $lectura->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($lectura->lon_cups) ? $lectura->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($lectura->dir_cups) ? $lectura->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        });


                                                                        capasLecturas.addLayer(lecturaMarker);
                                                                }
                                                            @endif
                                                        @endforeach


                                                        //SUBTENSIONES
                                                        var capasSubtensiones = L.layerGroup([]); // mapa de subtensiones
                                                        
                                                        @foreach ($resultadosQ29 as $subtension)
                                                            // Obtener latitud y longitud del objeto $subtension si existen
                                                            @if (isset($subtension->lat_cups) && isset($subtension->lon_cups))
                                                                var latCupsSubtension = '{{ $subtension->lat_cups }}';
                                                                var lonCupsSubtension = '{{ $subtension->lon_cups }}';


                                                                // Verificar si latCups y lonCups no son cadena vacía
                                                                if (latCupsSubtension !== '' && lonCupsSubtension !== '') {
                                                                    @if (isset($subtension->ind_autoconsumo))
                                                                        // Determinar la imagen basada en el valor de ind_autoconsumo
                                                                        var iconImage = "{{ $subtension->ind_autoconsumo }}" === 'S' ?
                                                                            '../../images/casaverdepanelsolar.png' :
                                                                            '../../images/casaverde.png';
                                                                    @else
                                                                        var iconImage = '../../images/casaverde.png'; // imagen por defecto si no tiene ind_autoconsumo
                                                                    @endif


                                                                    var divIcon = L.divIcon({
                                                                        html: `<div style="position: relative; text-align: center; font-family: 'Didact Gothic', sans-serif;">
                                                                            <img src="${iconImage}" style="width: 30px; height: 40px;">
                                                                            <div style="position: absolute; bottom: 5px; left: 0; width: 100%; color: white; font-weight: bold; font-size: 12px; text-shadow: 0 0 4px black;">{{ $subtension->nro_sub_voltajes ?? ' ' }}</div>
                                                                        </div>`,
                                                                        className: 'custom-div-icon',
                                                                        iconSize: [30, 40],
                                                                        iconAnchor: [15, 40],
                                                                        popupAnchor: [0, -40],
                                                                        shadowSize: [30, 30]
                                                                    });


                                                                    var marker = L.marker([latCupsSubtension, lonCupsSubtension], {
                                                                        icon: divIcon
                                                                    }).bindPopup(
                                                                        '<div id="popup-map" class="popup-content">' +
                                                                        // Nombre del cliente o CUPS
                                                                        '<h3><strong>{{ !empty($subtension->nom_cups) ? $subtension->nom_cups : 'No hay datos' }}</strong></h3>' +


                                                                        // Pestañas (General y Localización)
                                                                        '<ul class="nav nav-tabs">' +
                                                                        '<li class="nav-item"><a class="nav-link active" href="#general-subtension" data-toggle="tab">General</a></li>' +
                                                                        '<li class="nav-item"><a class="nav-link" href="#localizacion-subtension" data-toggle="tab">Localización</a></li>' +
                                                                        '</ul>' +


                                                                        // Contenido de las pestañas
                                                                        '<div class="tab-content">' +


                                                                        // Pestaña de General
                                                                        '<div class="tab-pane fade show active" id="general-subtension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Id cups:</b> <a href="detallesenergiacups?id_cups={{ $subtension->id_cups ?? ' ' }}" target="_blank">{{ $subtension->id_cups ?? ' ' }}</a></li>' +
                                                                        '<li><b>Subtensiones:</b> {{ $subtension->nro_sub_voltajes ?? ' ' }}</li>' +
                                                                        '<li><b>Última fecha:</b> {{ $subtension->fecha ?? ' ' }}</li>' +
                                                                        '<li><b>Hora:</b> {{ $subtension->hora ?? ' ' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion-subtension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($subtension->lat_cups) ? $subtension->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($subtension->lon_cups) ? $subtension->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($subtension->dir_cups) ? $subtension->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        }
                                                                    );




                                                                    capasSubtensiones.addLayer(marker);
                                                                }
                                                            @endif
                                                        @endforeach

                                                        
                                                        //CORTES
                                                        var capasApagones = L.layerGroup([]);

                                                        @foreach ($resultadosQ30 as $apagone)
                                                            // Obtener latitud y longitud del objeto $apagone si existen
                                                            @if (isset($apagone->lat_cups) && isset($apagone->lon_cups))
                                                                var latCupsApagone = '{{ $apagone->lat_cups }}';
                                                                var lonCupsApagone = '{{ $apagone->lon_cups }}';


                                                                // Verificar si latCups y lonCups no son cadena vacía
                                                                if (latCupsApagone !== '' && lonCupsApagone !== '') {
                                                                    @if (isset($apagone->ind_autoconsumo))
                                                                        // Determinar la imagen basada en el valor de ind_autoconsumo
                                                                        var iconImage = "{{ $apagone->ind_autoconsumo }}" === 'S' ?
                                                                            '../../images/casaverdepanelsolar.png' :
                                                                            '../../images/casaverde.png';
                                                                    @else
                                                                        var iconImage = '../../images/casaverde.png'; // imagen por defecto si no tiene ind_autoconsumo
                                                                    @endif


                                                                    var divIcon = L.divIcon({
                                                                        html: `<div style="position: relative; text-align: center; font-family: 'Didact Gothic', sans-serif;">
                                                                        <img src="${iconImage}" style="width: 30px; height: 40px;">
                                                                        <div style="position: absolute; bottom: 5px; left: 0; width: 100%; color: white; font-weight: bold; font-size: 12px; text-shadow: 0 0 4px black;">{{ $apagone->apagones ?? ' ' }}</div>
                                                                    </div>`,
                                                                        className: 'custom-div-icon',
                                                                        iconSize: [30, 40],
                                                                        iconAnchor: [15, 40],
                                                                        popupAnchor: [0, -40],
                                                                        shadowSize: [30, 30]
                                                                    });


                                                                    var marker = L.marker([latCupsApagone, lonCupsApagone], {
                                                                        icon: divIcon
                                                                    }).bindPopup(
                                                                        '<div id="popup-map" class="popup-content">' +
                                                                        // Nombre del cliente o CUPS
                                                                        '<h3><strong>{{ !empty($apagone->nom_cups) ? $apagone->nom_cups : 'No hay datos' }}</strong></h3>' +


                                                                        // Pestañas (General y Localización)
                                                                        '<ul class="nav nav-tabs">' +
                                                                        '<li class="nav-item"><a class="nav-link active" href="#general-apagone" data-toggle="tab">General</a></li>' +
                                                                        '<li class="nav-item"><a class="nav-link" href="#localizacion-apagone" data-toggle="tab">Localización</a></li>' +
                                                                        '</ul>' +


                                                                        // Contenido de las pestañas
                                                                        '<div class="tab-content">' +


                                                                        // Pestaña de General
                                                                        '<div class="tab-pane fade show active" id="general-apagone">' +
                                                                        '<ul>' +
                                                                        '<li><b>Id cups:</b> <a href="detallesenergiacups?id_cups={{ $apagone->id_cups ?? ' ' }}" target="_blank">{{ $apagone->id_cups ?? ' ' }}</a></li>' +
                                                                        '<li><b>Cortes:</b> {{ $apagone->apagones ?? ' ' }}</li>' +
                                                                        '<li><b>Última fecha:</b> {{ $apagone->fecha ?? ' ' }}</li>' +
                                                                        '<li><b>Hora:</b> {{ $apagone->hora ?? ' ' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion-apagone">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($apagone->lat_cups) ? $apagone->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($apagone->lon_cups) ? $apagone->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($apagone->dir_cups) ? $apagone->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        }
                                                                    );




                                                                    capasApagones.addLayer(marker);
                                                                }
                                                            @endif
                                                        @endforeach


                                                        //MICROCORTES
                                                        var capasMicrocortes = L.layerGroup([]); // mapa de microcortes

                                                        @foreach ($resultadosQ31 as $microcorte)
                                                            // Obtener latitud y longitud del objeto $microcorte si existen
                                                            @if (isset($microcorte->lat_cups) && isset($microcorte->lon_cups))
                                                                var latCupsMicrocorte = '{{ $microcorte->lat_cups }}';
                                                                var lonCupsMicrocorte = '{{ $microcorte->lon_cups }}';


                                                                // Verificar si latCups y lonCups no son cadena vacía
                                                                if (latCupsMicrocorte !== '' && lonCupsMicrocorte !== '') {
                                                                    @if (isset($microcorte->ind_autoconsumo))
                                                                        // Determinar la imagen basada en el valor de ind_autoconsumo
                                                                        var iconImage = "{{ $microcorte->ind_autoconsumo }}" === 'S' ?
                                                                            '../../images/casaverdepanelsolar.png' :
                                                                            '../../images/casaverde.png';
                                                                    @else
                                                                        var iconImage = '../../images/casaverde.png'; // imagen por defecto si no tiene ind_autoconsumo
                                                                    @endif


                                                                    var divIcon = L.divIcon({
                                                                        html: `<div style="position: relative; text-align: center; font-family: 'Didact Gothic', sans-serif;">
                                                                            <img src="${iconImage}" style="width: 30px; height: 40px;">
                                                                            <div style="position: absolute; bottom: 5px; left: 0; width: 100%; color: white; font-weight: bold; font-size: 12px; text-shadow: 0 0 4px black;">{{ $microcorte->microcortes ?? ' ' }}</div>
                                                                        </div>`,
                                                                        className: 'custom-div-icon',
                                                                        iconSize: [30, 40],
                                                                        iconAnchor: [15, 40],
                                                                        popupAnchor: [0, -40],
                                                                        shadowSize: [30, 30]
                                                                    });


                                                                    var marker = L.marker([latCupsMicrocorte, lonCupsMicrocorte], {
                                                                        icon: divIcon
                                                                    }).bindPopup(
                                                                        '<div id="popup-map" class="popup-content">' +
                                                                        // Nombre del cliente o CUPS
                                                                        '<h3><strong>{{ !empty($microcorte->nom_cups) ? $microcorte->nom_cups : 'No hay datos' }}</strong></h3>' +


                                                                        // Pestañas (General y Localización)
                                                                        '<ul class="nav nav-tabs">' +
                                                                        '<li class="nav-item"><a class="nav-link active" href="#general-microcorte" data-toggle="tab">General</a></li>' +
                                                                        '<li class="nav-item"><a class="nav-link" href="#localizacion-microcorte" data-toggle="tab">Localización</a></li>' +
                                                                        '</ul>' +


                                                                        // Contenido de las pestañas
                                                                        '<div class="tab-content">' +


                                                                        // Pestaña de General
                                                                        '<div class="tab-pane fade show active" id="general-microcorte">' +
                                                                        '<ul>' +
                                                                        '<li><b>Id cups:</b> <a href="detallesenergiacups?id_cups={{ $microcorte->id_cups ?? ' ' }}" target="_blank">{{ $microcorte->id_cups ?? ' ' }}</a></li>' +
                                                                        '<li><b>Microcortes:</b> {{ $microcorte->microcortes ?? ' ' }}</li>' +
                                                                        '<li><b>Última fecha:</b> {{ $microcorte->fecha ?? ' ' }}</li>' +
                                                                        '<li><b>Hora:</b> {{ $microcorte->hora ?? ' ' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion-microcorte">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($microcorte->lat_cups) ? $microcorte->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($microcorte->lon_cups) ? $microcorte->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($microcorte->dir_cups) ? $microcorte->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        }
                                                                    );

                                                                    capasMicrocortes.addLayer(marker);
                                                                }
                                                            @endif
                                                        @endforeach


                                                        //NIVELES DE TENSION
                                                        var capasNivelesTension = L.layerGroup([]); // Mapa de niveles de tensión


                                                        @foreach ($resultadosQ50 as $nivelestension)
                                                            // Verificar si existen latitud y longitud en el objeto $nivelestension
                                                            @if (isset($nivelestension->lat_cups) && isset($nivelestension->lon_cups))
                                                                var latCupsNivelesTension = '{{ $nivelestension->lat_cups }}';
                                                                var lonCupsNivelesTension = '{{ $nivelestension->lon_cups }}';


                                                                // Verificar si latCupsNivelesTension y lonCupsNivelesTension no son cadenas vacías
                                                                if (latCupsNivelesTension !== '' && lonCupsNivelesTension !== '') {
                                                                    var avgL1v = "{{ $nivelestension->avg_l1v }}";
                                                                    var indAutoconsumo = "{{ $nivelestension->ind_autoconsumo }}";


                                                                    // Definir el color y el ícono según el valor de avgL1v y el ind_autoconsumo
                                                                    var iconImage;


                                                                    if (avgL1v >= 214 && avgL1v <= 246) {
                                                                        // Verde
                                                                        iconImage = (indAutoconsumo === 'S') ? '../../images/casaverdepanelsolar.png' :
                                                                            '../../images/casaverde.png';
                                                                    } else if (avgL1v < 214) {
                                                                        // Naranja
                                                                        iconImage = (indAutoconsumo === 'S') ? '../../images/casanaranjapanelsolar.png' :
                                                                            '../../images/casanaranja.png';
                                                                    } else if (avgL1v > 246) {
                                                                        // Rojo
                                                                        iconImage = (indAutoconsumo === 'S') ? '../../images/casarojapanelsolar.png' :
                                                                            '../../images/casaroja.png';
                                                                    }


                                                                    // Crear el ícono personalizado
                                                                    var divIcon = L.divIcon({
                                                                        html: `<div style="position: relative; text-align: center; font-family: 'Didact Gothic', sans-serif;">
                                                                            <img src="${iconImage}" style="width: 30px; height: 40px;">
                                                                            <div style="position: absolute; bottom: 5px; left: 0; width: 100%; color: white; font-weight: bold; font-size: 12px; text-shadow: 0 0 4px black;">
                                                                                {{ $nivelestension->avg_l1v ?? ' ' }}
                                                                            </div>
                                                                        </div>`,
                                                                        className: 'custom-div-icon',
                                                                        iconSize: [30, 40],
                                                                        iconAnchor: [15, 40],
                                                                        popupAnchor: [0, -40],
                                                                        shadowSize: [30, 30]
                                                                    });


                                                                    // Crear el marcador con las coordenadas
                                                                    var marker = L.marker([latCupsNivelesTension, lonCupsNivelesTension], {
                                                                        icon: divIcon
                                                                    }).bindPopup(
                                                                        '<div id="popup-map" class="popup-content">' +
                                                                        // Nombre del cliente o CUPS
                                                                        '<h3><strong>{{ !empty($nivelestension->nom_cups) ? $nivelestension->nom_cups : 'No hay datos' }}</strong></h3>' +


                                                                        // Pestañas (General y Localización)
                                                                        '<ul class="nav nav-tabs">' +
                                                                        '<li class="nav-item"><a class="nav-link active" href="#general-niveles-tension" data-toggle="tab">General</a></li>' +
                                                                        '<li class="nav-item"><a class="nav-link" href="#localizacion-niveles-tension" data-toggle="tab">Localización</a></li>' +
                                                                        '</ul>' +


                                                                        // Contenido de las pestañas
                                                                        '<div class="tab-content">' +


                                                                        // Pestaña de General
                                                                        '<div class="tab-pane fade show active" id="general-niveles-tension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Id cups:</b> <a href="detallesenergiacups?id_cups={{ $nivelestension->id_cups ?? ' ' }}" target="_blank">{{ $nivelestension->id_cups ?? ' ' }}</a></li>' +
                                                                        '<li><b>Promedio:</b> {{ $nivelestension->avg_l1v ?? ' ' }}</li>' +
                                                                        '<li><b>Máximo:</b> {{ $nivelestension->max_l1v ?? ' ' }}</li>' +
                                                                        '<li><b>Mínimo:</b> {{ $nivelestension->min_l1v ?? ' ' }}</li>' +
                                                                        '<li><b>Total lecturas:</b> {{ $nivelestension->total_lecturas ?? ' ' }}</li>' +
                                                                        '<li><b>Última fecha:</b> {{ $nivelestension->ultima_fecha ?? ' ' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion-niveles-tension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($nivelestension->lat_cups) ? $nivelestension->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($nivelestension->lon_cups) ? $nivelestension->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($nivelestension->dir_cups) ? $nivelestension->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($cups->id_linea) ? $cups->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        }
                                                                    );
                                                                    // Añadir el marcador a la capa
                                                                    capasNivelesTension.addLayer(marker);
                                                                }
                                                            @endif
                                                        @endforeach


                                                        var baseLayers = {
                                                            "Google Maps": googleMaps,
                                                            "Satélite": satelite,
                                                            "OpenStreetMap": osm,
                                                        };


                                                        // Definir overlayLayers condicionalmente
                                                        var overlayLayers = {};
                                                        @if (!empty($resultadosQ1[0]->lat_ct) && !empty($resultadosQ1[0]->lon_ct))
                                                            overlayLayers["Centro de Transformación"] = ctMarker;
                                                        @endif


                                                        L.control.layers(baseLayers, overlayLayers).addTo(map);


                                                        document.querySelectorAll('.btn-option').forEach(function(button) {
                                                            button.addEventListener('click', function() {
                                                                // Remover todas las capas antes de agregar una nueva
                                                                if (map.hasLayer(capasConectividad)) map.removeLayer(capasConectividad);
                                                                if (map.hasLayer(capasSobretensiones)) map.removeLayer(capasSobretensiones);
                                                                if (map.hasLayer(capasLecturas)) map.removeLayer(capasLecturas);
                                                                if (map.hasLayer(capasSubtensiones)) map.removeLayer(capasSubtensiones);
                                                                if (map.hasLayer(capasApagones)) map.removeLayer(capasApagones);
                                                                if (map.hasLayer(capasMicrocortes)) map.removeLayer(capasMicrocortes);
                                                                if (map.hasLayer(capasNivelesTension)) map.removeLayer(capasNivelesTension);


                                                                // Agregar el marcador ctMarker si está definido
                                                                @if (!empty($resultadosQ1[0]->lat_ct) && !empty($resultadosQ1[0]->lon_ct))
                                                                    map.addLayer(ctMarker);
                                                                @endif


                                                                // Agregar la capa correspondiente según la opción seleccionada
                                                                switch (this.getAttribute('data-option')) {
                                                                    case 'option1':
                                                                        map.addLayer(capasConectividad);
                                                                        break;
                                                                    case 'option2':
                                                                        map.addLayer(capasSobretensiones);
                                                                        break;
                                                                    case 'option3':
                                                                        map.addLayer(capasSubtensiones);
                                                                        break;
                                                                    case 'option4':
                                                                        map.addLayer(capasApagones);
                                                                        break;
                                                                    case 'option5':
                                                                        map.addLayer(capasMicrocortes);
                                                                        break;
                                                                    case 'option6':
                                                                        map.addLayer(capasLecturas);
                                                                        break;
                                                                    case 'option7':
                                                                        map.addLayer(capasNivelesTension);
                                                                        break;
                                                                    default:
                                                                        // Opción por defecto
                                                                        break;
                                                                }
                                                            });
                                                        });


                                                        // Inicializar las capas del mapa
                                                        map.addLayer(capasConectividad);
                                                        // Agregar el marcador ctMarker al inicializar el mapa si está definido
                                                        @if (!empty($resultadosQ1[0]->lat_ct) && !empty($resultadosQ1[0]->lon_ct))
                                                            map.addLayer(ctMarker);
                                                        @endif
                                                    </script>
                                                @else
                                                    {{-- Mensaje de que no hay datos --}}
                                                    <div class="flex justify-center">
                                                        <div class="alert alert-warning text-center max-w-max flex items-center space-x-2"
                                                            role="alert">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                                                            </svg>
                                                            <span>No hay datos de geolocalización.</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>




