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




        .bg-custom-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(52 176 148 / var(--tw-bg-opacity));
        }


          /* Color al pasar el raton por encima de la fila de datos */
          .highlight-row:hover {
            background-color: rgba(88, 226, 194, 0.1);
            /* Cambia el color de fondo al pasar el ratón */
            transition: background-color 0.3s ease;
            /* Agrega una transición suave */
           
        }


    </style>






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
                    <div class="border-emerald-900 p-2 shadow-md sm:p-6 md:p-8 w-full"
                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-4 ml-14">
                            <h1 class="text-center text-3xl" style="color: white;">
                                LISTADO DE USUARIOS </h1>
                            <div
                                style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                            </div>
                            <form action="{{ route('admin') }}" method="GET"
                                class="flex flex-wrap items-center gap-4">
                                <div class="relative">
                                    <input type="text" name="name" placeholder="Nombre usuario"
                                        class="border p-2 rounded-md w-48 text-white"style="background-color: transparent; border-color: rgb(255, 255, 255);" />
                                </div>
                                <div class="relative">
                                    <input type="text" name="email" placeholder="Email"
                                        class="border p-2 rounded-md w-48 text-white"
                                        style="background-color: transparent; border-color: rgb(255, 255, 255);" />
                                </div>
                                <div class="relative">
                                    <input type="text" name="nom_distribuidora" placeholder="Nombre de distrubuidora"
                                        class="border p-2 rounded-md w-48 text-white"style="background-color: transparent; border-color: rgb(255, 255, 255);" />
                                </div>
                                <button type="submit" class="btn btn-outline-info px-4 py-2 text-white"
                                    style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                    onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                    onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Buscar</button>
                                <button type="submit" class="btn btn-outline-info px-4 py-2 text-white"
                                    style="background-color: transparent; border-color: rgb(255, 255, 255);"
                                    onmouseover="this.style.borderColor='rgb(88,226,194)'"
                                    onmouseout="this.style.borderColor='rgb(255, 255, 255)'">Mostrar todos</button>
                            </form>
                            <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl" style="max-height: 80%; ">
                                <div class="overflow-x-auto w-full">
                                    <table class="w-full text-white text-center ">
                                        <thead style="border-bottom: 1px solid #6461615a;">
                                            <tr>
                                                <th class="mt-0 text-1xl text-center px-4"
                                                    style="color:rgb(88,226,194)">ID
                                                </th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Nombre</th>
                                                <th class="mt-0 text-1xl  text-center" style="color:rgb(88,226,194) ">
                                                    Email</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Nombre Distribuidora</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Fecha de Creación</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Indicador PF</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194) ">Indicador CT</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Indicador CUPS</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Indicador SABT</th>
                                                <th class="mt-0 text-1xl  text-center px-4 "
                                                    style="color:rgb(88,226,194)">Código de Grupo</th>
                                                    <th class="mt-0 text-1xl  text-center px-4 "
                                                    style="color:rgb(88,226,194)">Indicador WS</th>
                                                <th class="mt-0 text-1xl  text-center px-4"
                                                    style="color:rgb(88,226,194)">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($users->isEmpty())
                                            <tr>
                                                <td colspan="11" class="py-2 text-center">No hay usuarios disponibles.</td>
                                            </tr>
                                        @else
                                            @foreach ($users as $user)
                                                <tr style="border-bottom: 1px solid #6461615a;" class="highlight-row">
                                                    <td class="py-2">{{ $user->id }}</td>
                                                    <td class="py-2">{{ $user->name }}</td>
                                                    <td class="py-2 px-4">{{ $user->email }}</td>
                                                    <td class="py-2">{{ $user->nom_distribuidora }}</td>
                                                    <td class="py-2">
                                                        {{ \Carbon\Carbon::parse($user->fec_acceso)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="py-2">{{ $user->ind_pf ? 'Sí' : 'No' }}</td>
                                                    <td class="py-2">{{ $user->ind_ct ? 'Sí' : 'No' }}</td>
                                                    <td class="py-2">{{ $user->ind_cups ? 'Sí' : 'No' }}</td>
                                                    <td class="py-2">{{ $user->ind_sabt ? 'Sí' : 'No' }}</td>
                                                   
                                                    <td class="py-2">
                                                        @if(isset($user->cod_id_group) && trim($user->cod_id_group) !== '')
                                                            {{ $user->cod_id_group }}
                                                        @else
                                                            No tiene
                                                        @endif
                                                    </td>
                                                    <td class="py-2">{{ $user->ind_ws ? 'Sí' : 'No' }}</td>
                                                    <td class="py-2">
                                                        <!-- Botón para editar usuario -->
                                                        <button
                                                            class="bg-custom-300 hover:bg-emerald-700 text-white py-2 px-4 rounded inline-block mb-2"
                                                            style="margin-right: 10px; width: 100px;">
                                                            <!-- Estableciendo ancho fijo -->
                                                            <a href="{{ route('editarusuario', ['id' => $user->id]) }}"
                                                                style="text-decoration: none; color: white;">Editar</a>
                                                        </button>
                                                        <!-- Botón para eliminar usuario -->
                                                        <form
                                                            action="{{ route('eliminarusuario', ['id' => $user->id]) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="return confirm('¿Estás seguro?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded-md inline-block"
                                                                style="margin-right: 10px; width: 100px;">
                                                                <!-- Estableciendo ancho fijo -->
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                       
                                        </tbody>
                                    </table>
                                    @if ($users->hasPages())
                                        <div class="flex items-center justify-center space-x-3 mt-6">
                                            @if ($users->onFirstPage())
                                                <span
                                                    class="px-3 py-2 text-gray-500 bg-custom-300 rounded-md cursor-not-allowed">
                                                    Anterior
                                                </span>
                                            @else
                                                <a href="{{ $users->previousPageUrl() }}"
                                                    class="px-3 py-2 text-sm font-medium text-white bg-custom-300 border-custom-300 rounded-md hover:bg-emerald-600 focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-emerald-700 active:text-white transition ease-in-out duration-150">
                                                    Anterior
                                                </a>
                                            @endif
                                            <span
                                                class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-md">
                                                {{ $users->currentPage() }}
                                            </span>
                                            @if ($users->hasMorePages())
                                                <a href="{{ $users->nextPageUrl() }}"
                                                    class="px-3 py-2 text-sm font-medium text-white bg-custom-300 rounded-md hover:bg-emerald-600 focus:outline-none focus:ring ring-custom-300 focus:border-custom-300 active:bg-emerald-700 active:text-white transition ease-in-out duration-150">
                                                    Siguiente
                                                </a>
                                            @else
                                                <span
                                                    class="px-3 py-2 text-gray-500 bg-custom-300 rounded-md cursor-not-allowed">
                                                    Siguiente
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>




