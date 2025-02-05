<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    {{-- MAPA --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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




   








    <title>Contacto</title>
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
        @include('includes/header') <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full"> <!-- Añadir margen superior -->
                <!-- Content -->


                <h1 class="text-center text-3xl w-full mt-24" style="color: white;">CONTACTO</h1>
                <div
                    style="border-bottom: 3px solid transparent;
                        border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                </div>


                {{-- Primera fila --}}
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4 mt-16 ml-14">








                    <div class="container">
                        <div class="card text-white mb-2 w-full h-full"
                            style="background: linear-gradient(to bottom, RGB(27, 32, 38), RGB(27, 32, 38));">
                            <h1 class="text-center text-2xl mt-2 mb-2"
                                style="display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 256 256" style="margin-right: 10px;">
                                    <path fill="#ffffff"
                                        d="M128 60a44 44 0 1 0 44 44a44.05 44.05 0 0 0-44-44m0 64a20 20 0 1 1 20-20a20 20 0 0 1-20 20m0-112a92.1 92.1 0 0 0-92 92c0 77.36 81.64 135.4 85.12 137.83a12 12 0 0 0 13.76 0a259 259 0 0 0 42.18-39C205.15 170.57 220 136.37 220 104a92.1 92.1 0 0 0-92-92m31.3 174.71a249.4 249.4 0 0 1-31.3 30.18a249.4 249.4 0 0 1-31.3-30.18C80 167.37 60 137.31 60 104a68 68 0 0 1 136 0c0 33.31-20 63.37-36.7 82.71" />
                                </svg>
                                DIRECCIÓN
                            </h1>
                            <div
                                style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                            </div>
                            <p class="text-center text-1xl m-4">


                                CELNET COMUNICACIONES<br><br>

                                Calle Vendimiadoras 5, Polígono NOVAPARQ, Carriòn de los Céspedes, Sevilla, 41820.
                            </p>
                            <h1 class="text-center text-2xl mt-8 mb-2"
                                style="display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 32 32" style="margin-right: 10px;">
                                    <g fill="#ffffff">
                                        <path
                                            d="m29.631 12.63l.33 1.47c.05.223.05.444.008.652A1 1 0 0 1 29 16h-2.255l-1.483-1.977v-.002A2.544 2.544 0 0 0 23.22 13H23v-1.69c0-.722-.588-1.31-1.31-1.31h-1.38c-.722 0-1.31.588-1.31 1.31v1.68h-6v-1.68c0-.722-.588-1.31-1.31-1.31h-1.38C9.588 10 9 10.588 9 11.31V13h-.22c-.808 0-1.563.381-2.05 1.03L5.254 16H3a1 1 0 0 1-.969-1.248a1.544 1.544 0 0 1 .008-.652l.32-1.47A7.199 7.199 0 0 1 9.379 7h13.242a7.18 7.18 0 0 1 7.01 5.63" />
                                        <path
                                            d="m24.46 14.62l3.66 4.88A9.366 9.366 0 0 1 30 25.13v3.31c0 .86-.7 1.56-1.56 1.56H3.56C2.7 30 2 29.3 2 28.44v-3.31c0-2.03.66-4.01 1.88-5.63l3.65-4.87c.3-.4.76-.63 1.25-.63h.91c.17 0 .31-.14.31-.31v-2.38c0-.17.14-.31.31-.31h1.38c.17 0 .31.14.31.31v2.38c0 .17.14.31.31.31h7.38c.17 0 .31-.14.31-.31v-2.38c0-.17.14-.31.31-.31h1.38c.17 0 .31.14.31.31v2.38c0 .17.14.31.31.31h.91c.49 0 .95.23 1.24.62m-11.62 4.38c.17 0 .31-.14.31-.312v-1.376a.313.313 0 0 0-.311-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312zm3 0a.3.3 0 0 0 .302-.312v-1.376a.314.314 0 0 0-.312-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312zm1.624 0h1.376a.3.3 0 0 0 .302-.312v-1.376a.314.314 0 0 0-.312-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312m-4.624 3c.17 0 .311-.14.301-.312v-1.376a.313.313 0 0 0-.311-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312zm1.624 0h1.376a.3.3 0 0 0 .302-.312v-1.376a.314.314 0 0 0-.312-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312m4.376 0a.3.3 0 0 0 .302-.312v-1.376a.314.314 0 0 0-.312-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312zm-7.376 3h1.376c.17 0 .311-.14.301-.312v-1.376a.313.313 0 0 0-.311-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312m4.376 0a.3.3 0 0 0 .302-.312v-1.376a.314.314 0 0 0-.312-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312zm1.624 0h1.376a.3.3 0 0 0 .302-.312v-1.376a.314.314 0 0 0-.312-.312h-1.376a.313.313 0 0 0-.312.312v1.376c0 .171.14.312.322.312" />
                                    </g>
                                </svg>
                                TELÉFONOS
                            </h1>
                            <div
                                style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                            </div>
                            <p class="text-center text-1xl m-4">
                                Comercial: 641 427 208 <br><br>
                                Administración: 627 472 203
                            </p>


                            <h1 class="text-center text-2xl mt-8 mb-2"
                                style="display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"  style="margin-right: 10px;"
                                    viewBox="0 0 24 24">
                                    <path fill="#ffffff"
                                        d="m20 8l-8 5l-8-5V6l8 5l8-5m0-2H4c-1.11 0-2 .89-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2" />
                                </svg>
                                CONECTA CON NOSOTROS
                            </h1>
                            <div
                                style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                            </div>
                            <p class="text-center text-1xl m-4">
                                comercial@celnet.es


                            </p>
                            <div class="text-center"  style="display: flex; align-items: center; justify-content: center;">

                                <a href="https://www.facebook.com/celnetcomunicaciones?locale=es_ES">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    style="margin-right: 20px; margin-bottom: 20px" viewBox="0 0 256 256">
                                    <path fill="#1877F2"
                                        d="M256 128C256 57.308 198.692 0 128 0C57.308 0 0 57.308 0 128c0 63.888 46.808 116.843 108 126.445V165H75.5v-37H108V99.8c0-32.08 19.11-49.8 48.348-49.8C170.352 50 185 52.5 185 52.5V84h-16.14C152.959 84 148 93.867 148 103.99V128h35.5l-5.675 37H148v89.445c61.192-9.602 108-62.556 108-126.445" />
                                    <path fill="#FFF"
                                        d="m177.825 165l5.675-37H148v-24.01C148 93.866 152.959 84 168.86 84H185V52.5S170.352 50 156.347 50C127.11 50 108 67.72 108 99.8V128H75.5v37H108v89.445A128.959 128.959 0 0 0 128 256a128.9 128.9 0 0 0 20-1.555V165z" />
                                </svg>
                                </a>



                                <a href="https://es.linkedin.com/company/celnet-comunicaciones-sl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" style="margin-right: 20px; margin-bottom: 20px"
                                    viewBox="0 0 128 128">
                                    <path fill="#0076b2"
                                        d="M116 3H12a8.91 8.91 0 0 0-9 8.8v104.42a8.91 8.91 0 0 0 9 8.78h104a8.93 8.93 0 0 0 9-8.81V11.77A8.93 8.93 0 0 0 116 3" />
                                    <path fill="#fff"
                                        d="M21.06 48.73h18.11V107H21.06zm9.06-29a10.5 10.5 0 1 1-10.5 10.49a10.5 10.5 0 0 1 10.5-10.49m20.41 29h17.36v8h.24c2.42-4.58 8.32-9.41 17.13-9.41C103.6 47.28 107 59.35 107 75v32H88.89V78.65c0-6.75-.12-15.44-9.41-15.44s-10.87 7.36-10.87 15V107H50.53z" />
                                </svg>
                                </a>
                            </div>
                        </div>
                    </div>





                    <div class="container">
                        <div class="card text-white mb-2 w-full h-full"
                            style="background: linear-gradient(to bottom, RGB(27, 32, 38), RGB(27, 32, 38));">
                            <h1 class="text-center text-2xl mt-2 mb-2"
                                style="display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 256 256" style="margin-right: 10px;">
                                    <path fill="#ffffff"
                                        d="M231.38 46.54a12 12 0 0 0-10.29-2.18L161.4 59.28l-60-30a12 12 0 0 0-8.28-.91l-64 16A12 12 0 0 0 20 56v144a12 12 0 0 0 14.91 11.64l59.69-14.92l60 30a12 12 0 0 0 8.28.91l64-16A12 12 0 0 0 236 200V56a12 12 0 0 0-4.62-9.46M108 59.42l40 20v117.16l-40-20Zm-64 6l40-10v119.21l-40 10Zm168 125.21l-40 10V81.37l40-10Z" />
                                </svg>
                                MAPA
                            </h1>
                            <div
                                style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                            </div>
                            
                            <div style="position: relative; padding-bottom: 56.25%;  overflow: hidden;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3171.22557131728!2d-6.331444623570577!3d37.3608391358955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd11cd7e752c9b67%3A0x8565b63d92011905!2sCelnet%20Comunicaciones%20SL!5e0!3m2!1ses!2ses!4v1717488734658!5m2!1ses!2ses"
                                    width="100%" height="100%" style="position: absolute; top: 0; left: 0; border:0;"
                                    allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




</body>
