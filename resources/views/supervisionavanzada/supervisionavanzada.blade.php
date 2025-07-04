<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- MAPA --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Supervision Avanzada</title>

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
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14"> <audio id="alarma"
                        src="../../sounds/alarma.mp3" preload="auto"></audio>
                    
                    {{-- Botones de arriba --}}
                    <x-nav-sabt/> 

                    {{-- Desplegable para seleccionar el CT --}}
                    <div class="container">
                        <div class="dropdown" style="margin-left: 6px">
                            <form style="color: white; background-color: transparent;"
                                action="{{ route('supervisionavanzada', ['id_ct' => $id_ct]) }}" method="GET">
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
                                            @if ($ct_item->ind_sabt) 
                                                <option class="btn btn-link"
                                                    style="color: white; background-color: rgb(27, 32, 38);"
                                                    value="{{ $ct_item->id_ct }}"
                                                    {{ $id_ct == $ct_item->id_ct ? 'selected' : '' }}>
                                                    {{ $ct_item->nom_ct }}
                                                </option>
                                            @endif
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

                            {{-- SEGUNDA FILA --}}
                            @foreach ($ct_info as $ct)
                                @if ($ct->id_ct == $id_ct)
                                    <div class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                                        


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
                                                                        {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->nro_trafos) ? $numTrafosAndCapacity[0]->nro_trafos : 'No hay datos' }}
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
                                                                        {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->kva_ct) ? $numTrafosAndCapacity[0]->kva_ct . ' kVA' : 'No hay datos' }}
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
                                                                        {{ count($numCups) > 0 && !empty($numCups[0]->nro_cups) ? number_format($numCups[0]->nro_cups, 0, '.', '.') : 'No hay datos' }}
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
                                                                        {{ count($numAutoconsumos) > 0 && !empty($numAutoconsumos[0]->nro_autoconsumos) ? $numAutoconsumos[0]->nro_autoconsumos : 'No hay datos' }}
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
                                                                        {{ count($numLineas) > 0 && !empty($numLineas[0]->nro_lineas) ? $numLineas[0]->nro_lineas : 'No hay datos' }}
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
                                                                    {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->id_cnc) ? $numTrafosAndCapacity[0]->id_cnc : 'No hay datos' }}
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
                                                                    {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->id_svr) ? $numTrafosAndCapacity[0]->id_svr : 'No hay datos' }}
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
                                                                    {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->des_cnc_af) ? 'Año ' . $numTrafosAndCapacity[0]->des_cnc_af : 'No hay datos' }}
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
                                                                    {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity1[0]->cod_mod) ? $numTrafosAndCapacity[0]->cod_mod : 'No hay datos' }}
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
                                                                    {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->des_vdlms) ? $numTrafosAndCapacity[0]->des_vdlms : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para URL -->
                                                            <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">URL</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194)">
                                                                    {{ count($numTrafosAndCapacity) > 0 && !empty($numTrafosAndCapacity[0]->dc_url) ? $numTrafosAndCapacity[0]->dc_url : 'No hay datos' }}
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
                                                    DATOS SABT
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
                                                                <h2 class="text-sm text-center font-normal">RTU ID</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($datosSABT) > 0 && !empty($datosSABT[0]->id) ? $datosSABT[0]->id : 'No hay datos' }}
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
                                                                <h2 class="text-sm text-center font-normal">Modelo
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($datosSABT) > 0 && !empty($datosSABT[0]->modelo) ? $datosSABT[0]->modelo : 'No hay datos' }}
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
                                                                <h2 class="text-sm text-center font-normal">Año</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($datosSABT) > 0 && !empty($datosSABT[0]->anio) ? $datosSABT[0]->anio : 'No hay datos' }}
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
                                                                <h2 class="text-sm text-center font-normal">Tipo
                                                                </h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($datosSABT) > 0 && !empty($datosSABT[0]->tipo) ? $datosSABT[0]->tipo : 'No hay datos' }}
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
                                                                    {{ count($datosSABT) > 0 && !empty($datosSABT[0]->firmware) ? $datosSABT[0]->firmware : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Cuadrado para url hw -->
                                                            <div class="p-2  text-white rounded-lg shadow-xl">
                                                                <h2 class="text-sm text-center font-normal">Config</h2>
                                                                <p class="mt-4 text-sm  text-center"
                                                                    style="color:rgb(88,226,194);">
                                                                    {{ count($datosSABT) > 0 && !empty($datosSABT[0]->config) ? $datosSABT[0]->config : 'No hay datos' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        
                                    
                                    
                                        <div class="container">
                                            <div class="card text-white  mb-3"
                                                style="
                                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                                    SUPERVISION AVANZADA</h1>
                                                <div class="mb-4"
                                                    style="border-bottom: 3px solid transparent;
                                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                </div>

                                                <!-- Formulario para filtros -->
                                                <form id="sabtform" action="{{ route('supervisionavanzada') }}" method="GET"
                                                    class="flex flex-col items-center space-y-4 mb-4 mt-4">
                                                    <input type="hidden" name="id_ct" value="{{ $id_ct }}">
                                                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                                        <!-- Input de Fecha de Inicio -->
                                                        <div class="flex flex-col">
                                                            <label for="fecha_inicio" class="text-white">Fecha de inicio:</label>
                                                            <input type="date" id="fecha_inicio" name="fecha_inicio"
                                                                class="border border-gray-400 p-2 rounded-lg text-white"
                                                                @if (isset($_GET['fecha_inicio'])) value="{{ $_GET['fecha_inicio'] }}" @endif
                                                                max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                                        </div>

                                                        <!-- Input de Fecha de Fin -->
                                                        <div class="flex flex-col">
                                                            <label for="fecha_fin" class="text-white">Fecha de fin:</label>
                                                            <input type="date" id="fecha_fin" name="fecha_fin"
                                                                class="border border-gray-400 p-2 rounded-lg text-white"
                                                                @if (isset($_GET['fecha_fin'])) value="{{ $_GET['fecha_fin'] }}" @endif
                                                                max="{{ date('Y-m-d') }}" style="background-color: transparent;">
                                                        </div>

                                                        <!-- Campo oculto para el tipo de evento -->
                                                        @php
                                                            $tipoEventoSeleccionado = request('tipo_evento') ?? 'S64';
                                                        @endphp
                                                        <input type="hidden" id="tipo_evento" name="tipo_evento" value="{{ $tipoEventoSeleccionado }}">

                                                        <!-- Botón de filtrar -->
                                                        <div class="flex items-end">
                                                            <button type="submit" class="btn btn-outline-info text-white"
                                                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">
                                                                Filtrar
                                                            </button>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $botones = [
                                                            'S64' => 'Perfil Voltaje/Intensidad (S64)',
                                                            'G53' => 'Perfil V Neutro/Tierra (G53)',
                                                            'S52' => 'Perfil Energetico por Linea (S52)',
                                                            'S96' => 'Armonicos de Tension (S96)',
                                                            'S97' => 'Variaciones de Tension (S97)',
                                                        ];
                                                    @endphp
                                                    <!-- Contenedor que centra la rejilla -->
                                                    <div class="flex justify-center w-full">
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-1 mb-6">
                                                            @foreach($botones as $key => $label)
                                                                <div class="card text-white mb-3" style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                                    <div class="flex justify-center items-center p-2">
                                                                        <button 
                                                                            type="button"
                                                                            class="w-full h-16 px-4 py-2 border rounded button text-center"
                                                                            id="btn-{{ $key }}"
                                                                            onclick="selectData(event, '{{ $key }}')"
                                                                            style="@if($tipoEventoSeleccionado == $key) background-color: rgb(88,226,194); color: white; @endif">
                                                                            {{ $label }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </form>

                                                    <script>
                                                        function selectData(event, key) {
                                                            event.preventDefault();

                                                            // Cambiar el valor del input oculto
                                                            document.getElementById('tipo_evento').value = key;       
                                                            
                                        
                                                            // Recorrer todos los botones y cambiar su color solo si NO son el seleccionado
                                                            document.querySelectorAll('.button').forEach(btn => {
                                                                if (btn.id !== 'btn-' + key) {
                                                                    btn.style.backgroundColor = ''; // Resetear color
                                                                    btn.classList.remove('text-white');
                                                                }
                                                            });

                                                            // Marcar el botón seleccionado
                                                            let selectedButton = document.getElementById('btn-' + key);
                                                            

                                                            if (selectedButton) {
                                                                selectedButton.classList.add('text-white');
                                                                selectedButton.style.backgroundColor = 'rgb(88,226,194)';
                                                            }

                                                            // Hacer submit automático SOLO para cambiar tipo_evento
                                                            // Para no perder fecha_inicio y fecha_fin actuales
                                                            document.querySelector('#sabtform').submit();
                                                        }

                                                    </script>

                                            </div>
                                        </div>

                                        @if(isset($resultadosS64) && count($resultadosS64) > 0)
                                            <x-table-s64 :resultados="$resultadosS64" :resultados2="$resultadosS64Full"/>
                                        @endif

                                        @if(isset($resultadosG53) && count($resultadosG53) > 0)
                                            <x-table-g53 :resultados="$resultadosG53" :resultados2="$resultadosG53Full"/>
                                        @endif

                                        @if(isset($resultadosS52) && count($resultadosS52) > 0)
                                            <x-table-s52 :resultados="$resultadosS52" :resultados2="$resultadosS52Full" />
                                        @endif

                                        @if(isset($resultadosS96) && count($resultadosS96) > 0)
                                            <x-table-s96 :resultados="$resultadosS96" :resultados2="$resultadosS96Full"/>
                                        @endif

                                        @if(isset($resultadosS97) && count($resultadosS97) > 0)
                                            <x-table-s97 :resultados="$resultadosS97" :resultados2="$resultadosS97Full"/>
                                        @endif

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