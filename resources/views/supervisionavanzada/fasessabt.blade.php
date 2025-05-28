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
    <title>Fases CUPS</title>
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
                    <x-nav-sabt/> 

                    {{-- Obtener el id_ct almacenado en la sesión --}}
                    @php
                        $id_ct = session()->get('id_ct');
                    @endphp

                    {{-- Desplegable para seleccionar el CT --}}
                    <div class="container">
                        <div class="dropdown" style="margin-left: 6px">
                            <form style="color: white; background-color: transparent;"
                                action="{{ route('fasessabt', ['id_ct' => $id_ct]) }}" method="GET">
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
                            <h1 class="text-center text-3xl w-full" style="color: white;">Fases CUPS SABT</h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                                border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
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
                                                @if (!empty($fasessabt))
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

                                                        //SOBRETENSIONES
                                                        //var capasSobretensiones = L.layerGroup([]);
                                                        var markersSobretensiones = L.markerClusterGroup({
                                                            spiderfyOnMaxZoom: true,  // Activa la separación de marcadores al hacer zoom
                                                            showCoverageOnHover: false,
                                                            zoomToBoundsOnClick: true,
                                                            maxClusterRadius: 0,  // Reduce el radio del clúster
                                                            });

                                                        @foreach ($fasessabt as $sobretension)
                                                            // Obtener latitud y longitud del objeto $sobretension si existen
                                                            @if (isset($sobretension->lat_cups) && isset($sobretension->lon_cups))
                                                                var latCupsSobretension = '{{ $sobretension->lat_cups }}';
                                                                var lonCupsSobretension = '{{ $sobretension->lon_cups }}';
                                                                //console.log(latCupsSobretension, lonCupsSobretension);

                                                                // Verificar si latCups y lonCups no son cadena vacía
                                                                console.log(@json($sobretension));
                                                                if (latCupsSobretension !== '' && lonCupsSobretension !== '') {
                                                                    @if ($sobretension->cod_fase == 'R')
                                                                        // Determinar la imagen basada en el valor de ind_autoconsumo
                                                                        var iconImage = '../../images/casaverder.png';
                                                                    @elseif($sobretension->cod_fase == 'S')
                                                                        var iconImage = '../../images/casaverdes.png'; // imagen por defecto si no tiene ind_autoconsumo
                                                                    @elseif($sobretension->cod_fase == 'T')
                                                                        var iconImage = '../../images/casaverdet.png';
                                                                    @else
                                                                        var iconImage = '../../images/casaverdenofase.png';
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
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        // Pestaña de Localización
                                                                        '<div class="tab-pane fade" id="localizacion-sobretension">' +
                                                                        '<ul>' +
                                                                        '<li><b>Latitud:</b> {{ !empty($sobretension->lat_cups) ? $sobretension->lat_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Longitud:</b> {{ !empty($sobretension->lon_cups) ? $sobretension->lon_cups : 'No hay datos' }}</li>' +
                                                                        '<li><b>Dirección:</b> {{ !empty($sobretension->dir_cups) ? $sobretension->dir_cups : 'No hay datos' }}</li>' +
																		'<li><b>Línea:</b> {{ !empty($sobretension->id_linea) ? $sobretension->id_linea : 'No hay datos' }}</li>' +
                                                                        '</ul>' +
                                                                        '</div>' +


                                                                        '</div>' + // Cierra tab-content
                                                                        '</div>', {
                                                                            className: 'custom-popup'
                                                                        }
                                                                    );
                                                                    markersSobretensiones.addLayer(marker);
                                                                    //capasSobretensiones.addLayer(marker);
                                                                    
                                                                }
                                                            @endif
                                                        @endforeach        

                                                        var capasSobretensiones = markersSobretensiones;
                                                        map.addLayer(capasSobretensiones);

                                                        //TRAMOS
                                                        // Añadir líneas desde tramos
                                                        var tramos = @json($tramos);
                                                        tramos.forEach(tramo => {
                                                            if (
                                                                tramo.lat_inicio && tramo.lon_inicio &&
                                                                tramo.lat_fin && tramo.lon_fin
                                                            ) {
                                                                const latlngs = [
                                                                    [parseFloat(tramo.lat_inicio), parseFloat(tramo.lon_inicio)],
                                                                    [parseFloat(tramo.lat_fin), parseFloat(tramo.lon_fin)]
                                                                ];

                                                                L.polyline(latlngs, {
                                                                    color: 'red',      // Cambia el color si lo deseas
                                                                    weight: 3,         // Grosor de la línea
                                                                    opacity: 0.8       // Opacidad
                                                                }).addTo(map);
                                                            }
                                                        });



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

                                                        // Inicializar las capas del mapa
                                                        map.addLayer(capasSobretensiones);
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
                            
                        @endif

                </div>
            </div>
        </div>
    </div>
</body>