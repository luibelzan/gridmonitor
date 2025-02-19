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
    <script>
        var res = @json($resultadosS64);
        console.log(res);
        </script>
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased text-black dark:text-white">
        @include('includes/header')
        <div class="lg:flex lg:ml-40 md:ml-56 sm:ml-14 ">
            <div class="lg:ml-14 p-2 mt-0 w-full">
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14"> <audio id="alarma"
                        src="../../sounds/alarma.mp3" preload="auto"></audio>

                    {{-- SEGUNDA FILA --}}
                    <div class="grid grid-cols-1 sm:grid-cols-1  md:grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
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
                                <form action="{{ route('supervisionavanzada') }}" method="GET"
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

                                        <!-- Campo oculto para el tipo de evento -->
                                        <input type="hidden" id="tipo_evento" name="tipo_evento" value="{{ request('tipo_evento', 'S64') }}">

                                        <!-- Botones de selección -->
                                        <div class="flex gap-2 justify-center mb-4">
                                            @foreach(['S64', 'S65', 'S66', 'S67'] as $key)
                                                <button 
                                                    type="button"
                                                    class="px-4 py-2 border rounded button {{ request('tipo_evento', 'S64') == $key ? 'bg-blue-500 text-white' : 'bg-gray-200' }}" 
                                                    id="btn-{{ $key }}" 
                                                    onclick="selectData(event, '{{ $key }}')">
                                                    {{ $key }}
                                                </button>
                                            @endforeach
                                        </div>

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
                                </form>

                                    <script>
                                        function selectData(event, key) {
                                            event.preventDefault();

                                            // Cambiar el valor del input oculto
                                            document.getElementById('tipo_evento').value = key;

                                            // Quitar selección de todos los botones
                                            document.querySelectorAll('.button').forEach(btn => {
                                                btn.classList.remove('bg-blue-500', 'text-white');
                                                btn.classList.add('bg-gray-200');
                                            });

                                            console.log(key);

                                            // Marcar el botón seleccionado
                                            document.getElementById('btn-' + key).classList.add('bg-blue-500', 'text-white');

                                            // Enviar el formulario automáticamente
                                            //document.querySelector('form').submit();
                                        }
                                    </script>

                            </div>
                        </div>

                        @if(count($resultadosS64) > 0)
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
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">RTU ID</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">LVS ID</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">LVS POS</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">FECHA</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">V1</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">V2</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">V3</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">I1</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">I2</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">I3</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">IN</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">SIMP</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">SEXP</th>
                                                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">BC</th>
                                            </tr>
                                         </thead>

                                         <tbody>
                                            @foreach($resultadosS64 as $resultado)
                                            <tr>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->rtu_id) ? $resultado->rtu_id : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->lvs_id) ? $resultado->lvs_id : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->lvs_pos) ? $resultado->lvs_pos : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->v1) ? $resultado->v1 : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->v2) ? $resultado->v2 : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->v3) ? $resultado->v3 : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->i1) ? $resultado->i1 : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->i2) ? $resultado->i2 : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->i3) ? $resultado->i3 : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->in) ? $resultado->in : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->simp) ? $resultado->simp : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->sexp) ? $resultado->sexp : 'No hay datos' }}
                                                </td>
                                                <td class="py-2" style="padding: 10px;">
                                                    {{ !empty($resultado->bc) ? $resultado->bc : 'No hay datos' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>