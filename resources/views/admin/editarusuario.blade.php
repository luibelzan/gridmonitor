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


        .hover\:bg-custom:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(52 176 148 / var(--tw-bg-opacity));
        }


        .bg-custom {
            --tw-bg-opacity: 1;
            background-color: rgb(52 176 148 / var(--tw-bg-opacity));
        }




        /* Estilo personalizado para los checkboxes */
        .custom-checkbox input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #374151;
            /* Fondo del checkbox */
            border: 2px solid #4A5568;
            /* Borde del checkbox */
            border-radius: 0.375rem;
            /* Radio de borde */
            width: 1rem;
            /* Ancho del checkbox */
            height: 1rem;
            /* Alto del checkbox */
            outline: none;
            /* Quita el contorno al enfocar */
            cursor: pointer;
            /* Cursor al pasar */
            position: relative;
        }


        /* Estilo para el tick dentro del checkbox */
        .custom-checkbox input[type="checkbox"]:checked::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0.35rem;
            height: 0.6rem;
            border: solid rgb(88, 226, 194);
            /* Color del tick */
            border-width: 0 0.2rem 0.2rem 0;
            /* Define el tamaño y grosor del tick */
            transform: translate(-50%, -50%) rotate(45deg);
            /* Centra y rota el tick */
        }


        /* Ajustes para el borde y fondo cuando está marcado */
        .custom-checkbox input[type="checkbox"]:checked {
            background-color: #374151;
            /* Fondo del checkbox sigue igual */
            border-color: rgb(88, 226, 194);
            /* Cambia solo el borde cuando está marcado */
        }
    </style>
    <script>
        // Cargando
        var Loading = (loadingDelayHidden = 0) => {
            let loading = null;
            const myLoadingDelayHidden = loadingDelayHidden;
            let imgs = [];
            let lenImgs = 0;
            let counterImgsLoading = 0;


            function incrementCounterImgs() {
                counterImgsLoading += 1;
                if (counterImgsLoading === lenImgs) {
                    hideLoading()
                }
            }


            function hideLoading() {
                if (loading !== null) {
                    loading.classList.remove('show');
                    setTimeout(function() {
                        loading.remove()
                    }, myLoadingDelayHidden)
                }
            }


            function init() {
                document.addEventListener('DOMContentLoaded', function() {
                    loading = document.querySelector('.loading');
                    imgs = Array.from(document.images);
                    lenImgs = imgs.length;
                    if (imgs.length === 0) {
                        hideLoading()
                    } else {
                        imgs.forEach(function(img) {
                            img.addEventListener('load', incrementCounterImgs, false)
                        })
                    }
                })
            }
            return {
                'init': init
            }
        }
        Loading(1000).init();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtén todos los elementos con la clase deseada
            var elements = document.querySelectorAll('.fade-in');
            // Agrega la clase de animación a cada elemento después de un pequeño retraso
            elements.forEach(function(element, index) {
                setTimeout(function() {
                        element.classList.add('fade-in');
                    }, index *
                    100); // Ajusta el retraso para controlar el momento en que aparecen los elementos
            });
        });
    </script>
    <script>
        // BOTON SUBIR
        $(document).ready(function() {
            $(window).scroll(function() {
                var position = $(this).scrollTop();
                if (position > 20) {
                    $(".boton-subir").fadeIn('slow');
                } else {
                    $(".boton-subir").fadeOut('slow');
                }
            });
        });
    </script>
    <title>Admin</title>
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
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14">
                    <div class="flex justify-center items-center h-screen">
                        <div class="border-blue-900 p-6 shadow-md sm:p-8 md:p-10 w-full  max-w-md"
                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38)); margin: 0 auto;">
                            <div class="text-center">
                                <h1 class="text-3xl text-white">EDITAR USUARIO</h1>
                                <div
                                    style="border-bottom: 3px solid transparent; border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                            </div>
                            <form action="{{ route('actualizarusuario', ['id' => $usuario->id]) }}" method="POST"
                                class="mt-4">
                                @csrf
                                @method('PUT')
                                <label for="nombre" class="text-white">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" value="{{ $usuario->name }}"
                                    required class="bg-gray-800 text-white px-4 py-2 rounded-md block w-full"><br>
                                <label for="email" class="text-white">Email:</label>
                                <input type="email" id="email" name="email" value="{{ $usuario->email }}"
                                    required class="bg-gray-800 text-white px-4 py-2 rounded-md block w-full"><br>
                                <label for="nom_distribuidora" class="text-white">Nombre Distribuidora:</label>
                                <input type="text" id="nom_distribuidora" name="nom_distribuidora"
                                    value="{{ $usuario->nom_distribuidora }}" required
                                    class="bg-gray-800 text-white px-4 py-2 rounded-md block w-full"><br>
                                <label for="fec_acceso" class="text-white">Fecha de Acceso:</label>
                                <input type="date" id="fec_acceso" name="fec_acceso"
                                    value="{{ $usuario->fec_acceso }}"
                                    class="bg-gray-800 text-white px-4 py-2 rounded-md block w-full"><br>
                                <div class="mt-4">
                                    <label for="ind_pf" class="text-white custom-checkbox">
                                        <input type="checkbox" id="ind_pf" name="ind_pf"
                                            {{ $usuario->ind_pf ? 'checked' : '' }}
                                            class="bg-gray-800 text-white px-4 py-2 rounded-md mr-2">
                                        Indicador PF
                                    </label><br>
                                    <label for="ind_ct" class="text-white custom-checkbox">
                                        <input type="checkbox" id="ind_ct" name="ind_ct"
                                            {{ $usuario->ind_ct ? 'checked' : '' }}
                                            class="bg-gray-800 text-white px-4 py-2 rounded-md mr-2">
                                        Indicador CT
                                    </label><br>
                                    <label for="ind_cups" class="text-white custom-checkbox">
                                        <input type="checkbox" id="ind_cups" name="ind_cups"
                                            {{ $usuario->ind_cups ? 'checked' : '' }}
                                            class="bg-gray-800 text-white px-4 py-2 rounded-md mr-2">
                                        Indicador CUPS
                                    </label><br>
                                    <label for="ind_sabt" class="text-white custom-checkbox">
                                        <label for="ind_sabt" class="text-white ">
                                            <input type="checkbox" id="ind_sabt" name="ind_sabt"
                                                {{ $usuario->ind_sabt ? 'checked' : '' }}
                                                class="bg-gray-800 text-white px-4 py-2 rounded-md mr-2">
                                            Indicador SABT
                                        </label><br>
                                        <label for="ind_ws" class="text-white custom-checkbox">
                                            <label for="ind_ws" class="text-white ">
                                                <input type="checkbox" id="ind_ws" name="ind_ws"
                                                    {{ $usuario->ind_ws ? 'checked' : '' }}
                                                    class="bg-gray-800 text-white px-4 py-2 rounded-md mr-2">
                                                Indicador WS
                                            </label><br>
                                            <label for="ind_cups" class="text-white custom-checkbox">
                                                <label for="cod_id_group" class="text-whit ">Código de Grupo:</label>
                                                <input type="text" id="cod_id_group" name="cod_id_group"
                                                    value="{{ $usuario->cod_id_group }}"
                                                    class="bg-gray-800 text-white px-4 py-2 rounded-md block w-full"><br>
                                </div>
                                <button type="submit"
                                    class="bg-custom hover:bg-custom text-white  py-2 px-4 rounded-md">Guardar
                                    Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>




