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

    {{-- ENLACE A JS GENERAL --}}
    <style>
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
        * {
            box-sizing: border-box;
        }

        .container {
            max-width: 100%;
        }

        #barraNavegacion {
            display: inline-flex;
            position: relative;
            overflow: hidden;
            max-width: 100%;
            background-color: rgb(27, 32, 38);
            padding: 0 20px;
            border-radius: 40px;
            margin: auto;
        }

        #barraNavegacion .nav-item {
            color: #ffffff;
            padding: 12px;
            text-decoration: none;
            transition: .3s;
            margin: 0 6px;
            z-index: 1;
            font-weight: 500;
            position: relative;
        }

        #barraNavegacion .nav-item:before {
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

        #barraNavegacion .nav-item:not(.is-active):hover:before {
            opacity: 1;
            bottom: 0;
        }

        #barraNavegacion .nav-item.is-active:before {
            background-color: rgb(88, 226, 194);
            opacity: 1;
            bottom: 0;
        }

        #barraNavegacion .nav-item:not(.is-active):hover {
            color: rgb(88, 226, 194);
        }

        #barraNavegacion .nav-indicator {
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

        .pagination-container > nav > div:last-child > div:last-child > span > a {
            background-color: rgb(52 176 148 / var(--tw-bg-opacity)) !important;
            border-color: rgb(52 176 148 / var(--tw-bg-opacity)) !important;
            font-weight: bolder;
            color: white !important;

        }

        .pagination-container > nav > div:last-child > div:last-child > span > span > span {
            background-color: rgb(52 176 148 / var(--tw-bg-opacity)) !important;
            border-color: rgb(52 176 148 / var(--tw-bg-opacity)) !important;
            color: white !important;
        }

        span[aria-current="page"] > span {
        text-decoration: underline;
        }


        @media (max-width: 600px) {
            #barraNavegacion .nav {
                flex-wrap: wrap;
                padding: 0;
                border-radius: 2;
                box-shadow: none;
            }

            #barraNavegacion .nav-item {
                flex: 1 0 40%;
                padding: 10px 0;
                text-align: center;
            }

            #barraNavegacion .nav-indicator {
                display: none;
            }
        }

        input[type="checkbox"] {
            accent-color: rgb(88, 226, 194);
            /* Cambia el color del tick */
        }
    </style>
    {{-- Estilo css para el parpadeo --}}
    <style>
        @keyframes blink {
            50% {
                opacity: 0;
            }
        }


        .new-notification {
            animation: blink 1s steps(5, start) infinite;
        }
    </style>

    {{-- AJAX PARA EVENTOS  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let lastEventIdTabla1 = localStorage.getItem('lastEventIdTabla1') || null;
            let lastEventIdTabla2 = localStorage.getItem('lastEventIdTabla2') || null;

            function reproducirSonido() {
                const alarma = document.getElementById('alarma');
                alarma.play();
            }

            function actualizarEventos() {
                $.ajax({
                    url: '/eventosespontaneos',
                    method: 'GET',
                    success: function(data) {
                        if (data.resultadosQ1Eventos) {
                            actualizarTabla(data.resultadosQ1EventosPaginate);
                            actualizarMapa(data
                                .resultadosQ1Eventos); // Actualiza el mapa con los nuevos eventos
                        }
                        if (data.resultadosQ3Eventos) {
                            actualizarTablaConcentrador(data.resultadosQ3Eventos);
                        }
                    },
                    error: function(error) {
                        console.error("Error al obtener los eventos", error);
                    }
                });
            }

            function actualizarTabla(eventos) {
                let tabla = $('#tabla-eventos tbody');
                tabla.empty();

                eventos.forEach(function(evento, index) {
                    // let codGravedad = generarCodigoGravedad();
                    let colorFondo, colorTexto;
                    switch (evento.cod_gravedad) {
                        case 1:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(247, 229, 59, 0.7), rgba(227, 207, 0, 0.9))'; // AMARILLO
                            colorTexto = 'black';
                            break;
                        case 2:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(255, 140, 0, 0.7), rgba(204, 112, 0, 1))'; // NARANJA
                            colorTexto = 'black';
                            break;
                        case 3:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))'; // ROJO
                            colorTexto = 'white';
                            break;
                        case 4:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(52, 152, 219, 0.7), rgba(41, 128, 185, 0.9))'; // AZUL
                            colorTexto = 'white';
                            break;
                        default:
                            colorFondo = ''; // GRIS (valor por defecto)
                            colorTexto = 'white';
                            break;
                    }


                    let fila = `
                    <tr style="background: ${colorFondo}; color: ${colorTexto};">
                          <td class="py-2" style="padding: 10px;">${evento.id_ct || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.nom_ct || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.cnc || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.cnt || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.fecha_hora_legible || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.et || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.c || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.des_evento_contador || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.id_cups || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.dir_cups || 'No hay datos'}</td>
                     
                    </tr>`;

                    tabla.append(fila);
                });

                const firstRow = eventos[0];
                if (firstRow && firstRow.id !== lastEventIdTabla1) {
                    lastEventIdTabla1 = firstRow.id;
                    localStorage.setItem('lastEventIdTabla1', lastEventIdTabla1);

                    const firstRowElement = $('#tabla-eventos tbody tr:first-child');
                    firstRowElement.addClass('new-notification');
                    reproducirSonido(); // Reproduce el sonido de alarma
                    setTimeout(() => {
                        firstRowElement.removeClass('new-notification');
                    }, 10000);
                }
            }

            function actualizarTablaConcentrador(eventos) {
                let tablaConcentrador = $('#tabla-eventos-concentrador tbody');
                tablaConcentrador.empty();

                eventos.forEach(function(evento, index) {
                    // let codGravedad1 = generarCodigoGravedad();
                    let colorFondo, colorTexto;
                    switch (evento.cod_gravedad) {
                        case 1:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(247, 229, 59, 0.7), rgba(227, 207, 0, 0.9))'; // AMARILLO
                            colorTexto = 'black';
                            break;
                        case 2:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(255, 140, 0, 0.7), rgba(204, 112, 0, 1))'; // NARANJA
                            colorTexto = 'black';
                            break;
                        case 3:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9))'; // ROJO
                            colorTexto = 'white';
                            break;
                        case 4:
                            colorFondo =
                                'linear-gradient(to bottom, rgba(52, 152, 219, 0.7), rgba(41, 128, 185, 0.9))'; // AZUL
                            colorTexto = 'white';
                            break;
                        default:
                            colorFondo = ''; // GRIS (valor por defecto)
                            colorTexto = 'white';
                            break;
                    }


                    let fila = `
                    <tr style="background: ${colorFondo}; color: ${colorTexto};">
                        <td class="py-2" style="padding: 10px;">${evento.nom_ct || 'No hay datos'}</td>
                     
                        <td class="py-2" style="padding: 10px;">${evento.cnc || 'No hay datos'}</td>
                         <td class="py-2" style="padding: 10px;">${evento.fecha_hora_legible || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.et || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.c || 'No hay datos'}</td>
                       
                        <td class="py-2" style="padding: 10px;">${evento.des_evento_dc || 'No hay datos'}</td>
                        <td class="py-2" style="padding: 10px;">${evento.d1 || 'No hay datos'}</td>

                   
                    </tr>`;

                    tablaConcentrador.append(fila);
                });

                const firstRow = eventos[0];
                if (firstRow && firstRow.id !== lastEventIdTabla2) {
                    lastEventIdTabla2 = firstRow.id;
                    localStorage.setItem('lastEventIdTabla2', lastEventIdTabla2);

                    const firstRowElement = $('#tabla-eventos-concentrador tbody tr:first-child');
                    firstRowElement.addClass('new-notification');
                    reproducirSonido(); // Reproduce el sonido de alarma
                    setTimeout(() => {
                        firstRowElement.removeClass('new-notification');
                    }, 10000);
                }
            }

            function generarCodigoGravedad() {
                return Math.floor(Math.random() * 4) + 1;
            }

            // Llamar a actualizarEventos periódicamente
            setInterval(actualizarEventos, 5000);
        });
    </script>





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
    {{-- Script para el parpadeo --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Variables para almacenar los últimos IDs de ambas tablas
            let lastEventIdTabla1 = localStorage.getItem('lastEventIdTabla1');
            let lastEventIdTabla2 = localStorage.getItem('lastEventIdTabla2');

            // Tabla 1: Verificar si hay nuevas filas en la tabla de 'resultadosQ1Eventos'
            const lastRowTabla1 = document.querySelector('#tabla-eventos tbody tr:first-child');
            if (lastRowTabla1) {
                const currentEventIdTabla1 = lastRowTabla1.querySelector('td:first-child').textContent.trim();

                if (currentEventIdTabla1 !== lastEventIdTabla1) {
                    lastRowTabla1.classList.add('new-notification');
                    localStorage.setItem('lastEventIdTabla1', currentEventIdTabla1);
                    setTimeout(() => {
                        lastRowTabla1.classList.remove('new-notification');
                    }, 10000); // Deja de parpadear después de 10 segundos
                }
            }

            // Tabla 2: Verificar si hay nuevas filas en la tabla de 'resultadosQ3Eventos'
            const lastRowTabla2 = document.querySelector('#tabla-eventos-concentrador tbody tr:first-child');
            if (lastRowTabla2) {
                const currentEventIdTabla2 = lastRowTabla2.querySelector('td:first-child').textContent.trim();

                if (currentEventIdTabla2 !== lastEventIdTabla2) {
                    lastRowTabla2.classList.add('new-notification');
                    localStorage.setItem('lastEventIdTabla2', currentEventIdTabla2);
                    setTimeout(() => {
                        lastRowTabla2.classList.remove('new-notification');
                    }, 10000); // Deja de parpadear después de 10 segundos
                }
            }
        });
    </script> --}}
    <title>Eventos Espontáneos</title>
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
                        src="../../sounds/alarma.mp3" preload="auto"></audio> {{-- PRIMERA FILA --}}
                    <div class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-1 lg:grid-cols-1 gap-6 mb-0">
                        <div class="container">
                            <div class="card text-white  mb-3"
                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                    MAPA</h1>
                                <div class="mb-4"
                                    style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                @if (!empty($resultadosQ1Eventos) && count($resultadosQ1Eventos) > 0)
                                    {{-- Mapa --}}
                                    <button id="mapButton" onclick="zoomMap()"
                                        style="display: flex; align-items: center; justify-content: center; padding: 5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#e8eaed">
                                            <path
                                                d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Zm-40-60v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Z" />
                                        </svg>
                                        Ampliar mapa
                                    </button>

                                    <div id="map" style="height: 350px; width: 100%;"></div>
                                    <script>
                                        //funcion para ampliar y reducir mapa
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




                                        var googleMaps = L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                                            maxZoom: 20,
                                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                                        });




                                        var satelite = L.tileLayer('https://mt{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                                            maxZoom: 20,
                                            subdomains: ['0', '1', '2', '3'],
                                        });




                                        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 20,
                                        });




                                        googleMaps.addTo(map);
                                        map.removeControl(map.attributionControl);




                                        var bounds = [];
                                        var representedCTs = new Set();
                                        var markers = []; // Array para almacenar los marcadores

                                        // Función para limpiar el mapa de marcadores antiguos
                                        function limpiarMarcadores() {
                                            markers.forEach(function(marker) {
                                                map.removeLayer(marker);
                                            });
                                            markers = [];
                                            representedCTs.clear();
                                            bounds = [];
                                        }




                                        // Función para actualizar el mapa con nuevos eventos
                                        function actualizarMapa(eventos) {
                                            limpiarMarcadores(); // Limpiar los marcadores antiguos antes de añadir los nuevos




                                            eventos.forEach(function(evento) {
                                                if (evento.lat_ct && evento.lon_ct) {
                                                    var idCt = evento.id_ct;
                                                    var eventosCount = evento.total_eventos || 0; // Usar 'total_eventos' del evento

                                                    console.log("Evento procesado:", evento);
console.log("Total eventos calculado:", evento.total_eventos);



                                                    if (!representedCTs.has(idCt)) {
                                                        var lat = evento.lat_ct;
                                                        var lon = evento.lon_ct;




                                                        // Crear un icono con el número de eventos
                                                        var ctIcon = L.divIcon({
                                                            className: 'ct-icon',
                                                            html: `<div style="position: relative; text-align: center;">
                                                                            <img src="../../images/icono_ct_sin_relleno.png" alt="ctIcon" style="width: 50px; height: 50px;">
                                                            <div style="position: absolute; bottom: 0; left: 55%; transform: translateX(-45%) translateY(9px); width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; color: black; opacity: 0.7; padding: 2px; border-radius: 3px; font-weight: bold;">
                                                                <strong>${eventosCount}</strong>
                                                            </div>
                                                        </div>`,
                                                            iconSize: [40, 40],
                                                            iconAnchor: [20, 40]
                                                        });




                                                        var ctMarker = L.marker([lat, lon], {
                                                            icon: ctIcon
                                                        }).bindPopup(`
                                                            <div class="custom-popup">
                                                                <h3><strong>CENTRO DE TRANSFORMACIÓN</strong></h3>
                                                                <ul>
                                                                    <li><strong>ID:</strong> ${evento.id_ct}</li>
                                                                    <li><strong>Nombre:</strong> ${evento.nom_ct}</li>
                                                                    <li><strong>Dirección:</strong> ${evento.dir_ct || 'No hay datos'}</li>
                                                                    <li><strong>Total Eventos Contador:</strong> ${evento.total_eventos_contador || 0}</li>
                                                                    <li><strong>Total Eventos Concentrador:</strong> ${evento.total_eventos_concentrador || 0}</li>
                                                                    <li><strong>Total Eventos:</strong> ${eventosCount}</li>
                                                                </ul>
                                                            </div>
                                                        `);




                                                        ctMarker.addTo(map);
                                                        markers.push(ctMarker); // Añadir el marcador al array
                                                        bounds.push([lat, lon]);
                                                        representedCTs.add(idCt);
                                                    }
                                                }
                                            });




                                            // Ajustar los límites del mapa
                                            if (bounds.length > 0) {
                                                map.fitBounds(bounds);
                                            }
                                        }




                                        var baseLayers = {
                                            "Google Maps": googleMaps,
                                            "Satélite": satelite,
                                            "OpenStreetMap": osm,
                                        };




                                        L.control.layers(baseLayers).addTo(map);




                                        // Llama a la función actualizarMapa inmediatamente con los datos iniciales
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var eventosIniciales = @json($resultadosQ1Eventos);
                                            actualizarMapa(eventosIniciales); // Mostrar los eventos en el mapa de inmediato
                                        });
                                    </script>
                                @else
                                    {{-- Mensaje de que no hay datos --}}
                                    <div class="flex justify-center">
                                        <div class="alert alert-warning text-center max-w-max flex items-center space-x-2"
                                            role="alert">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
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


                    {{-- SEGUNDA FILA --}}
                    <div class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                        <div class="container">
                            <div class="card text-white  mb-3"
                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                    EVENTOS CONTADOR</h1>
                                <div class="mb-4"
                                    style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                @php
    // Inicializar un array con los títulos de los cuadros y eventos en 0 por defecto
    $eventos = [
        1 => ['nombre' => 'Estandar', 'cantidad_24h' => 0, 'cantidad_historico' => 0],
        2 => ['nombre' => 'ICP', 'cantidad_24h' => 0, 'cantidad_historico' => 0],
        3 => ['nombre' => 'Calidad', 'cantidad_24h' => 0, 'cantidad_historico' => 0],
        4 => ['nombre' => 'Fraude', 'cantidad_24h' => 0, 'cantidad_historico' => 0],
        5 => ['nombre' => 'Demanda', 'cantidad_24h' => 0, 'cantidad_historico' => 0],
        6 => ['nombre' => 'Comunicaciones', 'cantidad_24h' => 0, 'cantidad_historico' => 0],
    ];

    // Solo procesar si resultadosQ5Eventos no está vacío
    if (!empty($resultadosQ5Eventos)) {
        foreach ($resultadosQ5Eventos as $resultadoQ5) {
            // Validar que $resultadoQ5 es un objeto y tiene la propiedad 'et'
            if (is_object($resultadoQ5) && isset($resultadoQ5->et) && isset($eventos[$resultadoQ5->et])) {
                $eventos[$resultadoQ5->et]['cantidad_24h'] = $resultadoQ5->cantidad_eventos_24h;
            }
        }
    }

    // Sobrescribir los valores con los resultados de la consulta resultadosQ6Eventos
    if (!empty($resultadosQ6Eventos)) {
        foreach ($resultadosQ6Eventos as $resultadoQ6) {
            // Validar que $resultadoQ6 es un objeto y tiene la propiedad 'et'
            if (is_object($resultadoQ6) && isset($resultadoQ6->et) && isset($eventos[$resultadoQ6->et])) {
                $eventos[$resultadoQ6->et]['cantidad_historico'] = $resultadoQ6->cantidad_eventos_historico;
            }
        }
    }
@endphp


                                <!-- Formulario para filtros -->
                                <form action="{{ route('eventosespontaneos') }}" method="GET"
                                    class="flex flex-col items-center space-y-4 mb-4 mt-4">
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

                                        <!-- Botón de filtrar alineado con los inputs de fecha -->
                                        <div class="flex items-end">
                                            <button type="submit" class="btn btn-outline-info text-white"
                                                style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                                onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                                onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Filtrar</button>
                                        </div>
                                    </div>

                                    <!-- Mostrar eventos con checkboxes -->
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-6 mb-6">
                                        @foreach ($eventos as $key => $evento)
                                            <div class="card text-white mb-3"
                                                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <!-- Colocar el checkbox y el nombre del evento en la misma línea y centrados -->
                                                <div class="flex justify-center items-center gap-2 px-4"
                                                    style="width: 100%;">
                                                    <input type="checkbox" name="et[]" value="{{ $key }}"
                                                        {{ in_array($key, request('et', [])) ? 'checked' : '' }}>
                                                    <label
                                                        style="color: rgb(88,226,194); font-size: 1.25rem;">{{ $evento['nombre'] }}</label>
                                                </div>
                                                
                                                <div
                                                    style="display: flex; justify-content: center; align-items: baseline; gap: 1rem;">
                                                    <!-- Añadir resultado 24h -->
                                                    <h2 style="font-size: 2rem;">{{ $evento['cantidad_24h'] }}</h2>
                                                    <!-- Añadir el resultado histórico, más pequeño y alineado arriba -->
                                                    <h5 style="font-size: 1rem; align-self: flex-start;">
                                                        {{ $evento['cantidad_historico'] }}</h5>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </form>



                                @if (count($resultadosQ1Eventos) > 0)
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 400px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                        <div class="mb-4"
                                            style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                        </div>
                                        <table id="tabla-eventos" class="w-full text-white text-center"
                                            style="border-spacing: 0 5px;">
                                            <thead style="border-bottom: 1px solid #ffffff;">
                                                <tr>



                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">CT</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Nombre CT</th>


                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Concentrador</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Contador</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Fecha y hora</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Grupo</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Evento</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Descripción
                                                        Evento</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">CUPS</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Dirección CUPS
                                                    </th>


                                                </tr>
                                            </thead>




                                            <tbody>
                                                @foreach ($resultadosQ1EventosPaginate as $resultado)
                                                    <tr class="highlight-row @if ($loop->first) new-notification @endif"
                                                        @if (isset($resultado->cod_gravedad)) @switch($resultado->cod_gravedad)
                    @case(1)
                        style="color: black; background-image: linear-gradient(to bottom, rgba(247, 229, 59, 0.7), rgba(227, 207, 0, 0.9));"
                        {{-- AMARILLO --}}
                        @break

                    @case(2)
                        style="background-image: linear-gradient(to bottom, rgba(255, 140, 0, 0.7), rgba(204, 112, 0, 1));"
                        {{-- NARANJA --}}
                        @break

                    @case(3)
                        style="background-image: linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9));"
                        {{-- ROJO --}}
                        @break

                    @case(4)
                        style="color: white; background-image: linear-gradient(to bottom, rgba(52, 152, 219, 0.7), rgba(41, 128, 185, 0.9)); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); border-radius: 5px;"
                        {{-- AZUL --}}
                        @break
                @endswitch @endif>

                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->id_ct) ? $resultado->id_ct : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                        </td>


                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->cnc) ? $resultado->cnc : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->cnt) ? $resultado->cnt : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->fecha_hora_legible) ? $resultado->fecha_hora_legible : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->et) ? $resultado->et : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->c) ? $resultado->c : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->des_evento_contador) ? $resultado->des_evento_contador : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            @if (!empty($resultado->id_cups))
                                                                <a
                                                                    href="detalleseventoscups?id_cups={{ $resultado->id_cups }}">
                                                                    {{ $resultado->id_cups }}
                                                                </a>
                                                            @else
                                                                No hay datos
                                                            @endif
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->dir_cups) ? $resultado->dir_cups : 'No hay datos' }}
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                        <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No hay
                                            datos</p>
                                    </div>
                                @endif
                                <!-- Contenedor del botón de descarga -->
                                <div class="text-right m-4 flex justify-between">
                                    <!-- Paginación -->
                                    <div class="pagination-container">
                                    {{ $resultadosQ1EventosPaginate->appends(['cnt_page' => request()->get('cnt_page')])->links() }}
                                    </div>
                                    <input type="button" onclick="tableToExcel('tabla-eventos', 'W3C Example Table')"
                                        style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- TERCERA FILA --}}
                    <div class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                        <div class="container">
                            <div class="card text-white  mb-3"
                                style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl mt-2 mb-2" style="color: white;">
                                    EVENTOS CONCENTRADOR</h1>
                                <div class="mb-4"
                                    style="border-bottom: 3px solid transparent;
                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                @if (count($resultadosQ3Eventos) > 0)
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                        <table id="tabla-eventos-concentrador" class="w-full text-white text-center"
                                            style="border-spacing: 0 5px;">
                                            <thead style="border-bottom: 1px solid #ffffff;">
                                                <tr>


                                                    
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Nombre CT</th>


                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Concentrador</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Fecha y hora</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Grupo</th>
                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Categoría</th>

                                                    <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">Descripción
                                                        Evento</th>
                                                        <th class="text-xl font-bold text-center"
                                                        style="color:rgb(88,226,194); padding: 10px;">D1</th>


                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($resultadosQ3Eventos as $resultado)
                                                    <tr class="highlight-row @if ($loop->first) new-notification @endif"
                                                        @if (isset($resultado->cod_gravedad)) @switch($resultado->cod_gravedad)
                    @case(1)
                        style="color: black; background-image: linear-gradient(to bottom, rgba(247, 229, 59, 0.7), rgba(227, 207, 0, 0.9));"
                        {{-- AMARILLO --}}
                        @break

                    @case(2)
                        style="background-image: linear-gradient(to bottom, rgba(255, 140, 0, 0.7), rgba(204, 112, 0, 1));"
                        {{-- NARANJA --}}
                        @break

                    @case(3)
                        style="background-image: linear-gradient(to bottom, rgba(248, 73, 90, 0.6), rgba(206, 60, 73, 0.9));"
                        {{-- ROJO --}}
                        @break

                    @case(4)
                        style="color: white; background-image: linear-gradient(to bottom, rgba(52, 152, 219, 0.7), rgba(41, 128, 185, 0.9)); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); border-radius: 5px;"
                        {{-- AZUL --}}
                        @break
                @endswitch @endif>


                                                      
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                        </td>


                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->cnc) ? $resultado->cnc : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->fecha_hora_legible) ? $resultado->fecha_hora_legible : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->et) ? $resultado->et : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->c) ? $resultado->c : 'No hay datos' }}
                                                        </td>

                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->des_evento_dc) ? $resultado->des_evento_dc : 'No hay datos' }}
                                                        </td>
                                                        <td class="py-2" style="padding: 10px;">
                                                            {{ !empty($resultado->d1) ? $resultado->d1 : 'No hay datos' }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                        <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No hay
                                            datos</p>
                                    </div>
                                @endif
                                <!-- Contenedor del botón de descarga -->
                                <div class="text-right mt-4 flex justify-between">
                                    <!-- Paginación -->
                                    <div class="pagination-container">
                                    {{ $resultadosQ3Eventos->appends(['cnc_page' => request()->get('cnc_page')])->links() }}
                                    </div>
                                    <input type="button"
                                        onclick="tableToExcel('tabla-eventos-concentrador', 'W3C Example Table')"
                                        style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
