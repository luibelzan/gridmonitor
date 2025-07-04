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
    {{-- TAILWIND --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.31.1.min.js'></script> <!-- Load plotly.js into the DOM -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    {{-- JAVASCRIPT --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <!--icono cargando -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ENLACE A JS GENERAL --}}
    <script src="{{ asset('js/app.js') }}"></script>

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
            var base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };
            var format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
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
    <script>
        function tableToExcel2Cols(tableID, filename = '') {
            var tab_text = "<table border='2px'>";
            var textRange;
            var j = 0;
            var table = document.getElementById(tableID);
            for (j = 0; j < table.rows.length; j++) {
                tab_text = tab_text + table.rows[j].innerHTML + "</tr>";
                //tab_text=tab_text+"</tr>";
            }
            tab_text = tab_text + "</table>";
            var ua = window.navigator.userAgent;
            var msieEdge = ua.indexOf("Edge");
            if (msieEdge > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                txtArea1.document.open("txt/html", "replace");
                txtArea1.document.write(tab_text);
                txtArea1.document.close();
                txtArea1.focus();
                sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
            } else
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            return (sa);
        }
    </script>

    <title>Indicadores SABT</title>

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
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14"> <audio id="alarma"
                        src="../../sounds/alarma.mp3" preload="auto"></audio>
                    {{-- Botones de arriba --}}
                    <x-nav-sabt />

                    {{-- Desplegable para seleccionar el CT --}}
                    <div class="container">
                        <div class="dropdown" style="margin-left: 6px">
                            <form style="color: white; background-color: transparent;"
                                action="{{ route('indicadoressabt', ['id_ct' => $id_ct]) }}" method="GET">
                                <select name="id_ct" class="form-control mt-2" onchange="this.form.submit()"
                                    style="color: white; background-color: rgb(27, 32, 38); width: min-content; font-size: 14px; text-align: left;">
                                    {{-- Si hay un id_ct seleccionado en la sesión, mostrarlo seleccionado --}}
                                    @if ($id_ct)
                                        <option class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value=""
                                            disabled selected style="color: rgb(27, 32, 38);">Seleccione un
                                            CT</option>
                                        @foreach ($ct_info as $ct_item)
                                            <option class="btn btn-link"
                                                style="color: white; background-color: rgb(27, 32, 38);"
                                                value="{{ $ct_item->id_ct }}" {{ $id_ct == $ct_item->id_ct ? 'selected' : '' }}>
                                                {{ $ct_item->nom_ct }}
                                            </option>
                                        @endforeach
                                        {{-- Si no hay un id_ct seleccionado en la sesión, mostrar la opción "Seleccione un
                                        CT" --}}
                                    @else
                                        <option class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value=""
                                            disabled selected style="color: rgb(27, 32, 38);">Seleccione un
                                            CT</option>

                                        @foreach ($ct_info as $ct_item)
                                            @if ($ct_item->ind_sabt)
                                                <option class="btn btn-link"
                                                    style="color: white; background-color: rgb(27, 32, 38);"
                                                    value="{{ $ct_item->id_ct }}" {{ $id_ct == $ct_item->id_ct ? 'selected' : '' }}>
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


                            <!-- Content -->
                            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-16 ml-14 ">
                                {{-- CUERPO AQUI --}}
                                <h1 class="text-center text-3xl w-full" style="color: white;">INDICADORES SABT</h1>
                                <div style="border-bottom: 3px solid transparent;
                            border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
                                </div>
                                <div class="container">
                                    {{-- PRIMERA FILA --}}
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                        {{-- 1º cuadro --}}
                                        <div class="card text-white mb-2" style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <h1 class="text-center text-2xl" style="color: white;">
                                                Distorsiones armonicas (promedio 3 dias)
                                            </h1>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div
                                                            class="p-2 #205E86 text-white rounded-lg shadow-xl flex flex-row flex-wrap justify-center">
                                                            <div class="flex flex-col items-center pr-4">
                                                                <p class="text-2xl font-bold max-w-full">Fase R</p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/harmonics-no-bg.png') }}" width="60" height="80">
                                                                    {{ !empty($distorsionesArmonicas[0]->avg_hr_thd) ? number_format($distorsionesArmonicas[0]->avg_hr_thd, 2) : '0.00' }}
                                                                </p>
                                                            </div>

                                                            <div class="flex flex-col items-center pr-4 pl-4">
                                                                <p class="text-2xl font-bold max-w-full">Fase S</p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/harmonics-no-bg.png') }}" width="60" height="80">
                                                                    {{ !empty($distorsionesArmonicas[0]->avg_hs_thd) ? number_format($distorsionesArmonicas[0]->avg_hs_thd, 2) : '0.00' }}

                                                                </p>
                                                            </div>

                                                            <div class="flex flex-col items-center pl-4">
                                                                <p class="text-2xl font-bold max-w-full">Fase T</p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/harmonics-no-bg.png') }}" width="60" height="80">
                                                                    {{ !empty($distorsionesArmonicas[0]->avg_ht_thd) ? number_format($distorsionesArmonicas[0]->avg_ht_thd, 2) : '0.00' }}

                                                                </p>
                                                            </div>

                                                        </div>
                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                        </div>
                                                        <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                            <h2 class="text-sm text-center font-normal">Total Distorsiones
                                                                Armonicas</h2>
                                                            <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                                {{ !empty($numDistorsionesArmonicas[0]->total_distorsiones) ? $numDistorsionesArmonicas[0]->total_distorsiones : 0}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- 2º cuadro --}}
                                        <div class="card text-white mb-2" style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <h1 class="text-center text-2xl" style="color: white;">
                                                Flickers (Promedio 3 dias)
                                            </h1>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div
                                                            class="p-2 #205E86 text-white rounded-lg shadow-xl flex flex-row flex-wrap justify-center">
                                                            <div class="flex flex-col items-center pr-4">
                                                                <p class="text-2xl font-bold max-w-full">Fase R</p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/flickers-no-bg.png') }}" width="60" height="80">
                                                                    {{ !empty($promedioFase[0]->avg_hr_thd) ? number_format($promedioFase[0]->avg_fr, 2) : '0.00' }}

                                                                </p>
                                                            </div>

                                                            <div class="flex flex-col items-center pr-4 pl-4">
                                                                <p class="text-2xl font-bold max-w-full">Fase S</p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/flickers-no-bg.png') }}" width="60" height="80">
                                                                    {{ !empty($promedioFase[0]->avg_fs) ? number_format($promedioFase[0]->avg_fs, 2) : '0.00' }}

                                                                </p>
                                                            </div>

                                                            <div class="flex flex-col items-center pl-4">
                                                                <p class="text-2xl font-bold max-w-full">Fase T</p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/flickers-no-bg.png') }}" width="60" height="80">
                                                                    {{ !empty($promedioFase[0]->avg_ft) ? number_format($promedioFase[0]->avg_ft, 2) : '0.00' }}

                                                                </p>
                                                            </div>

                                                        </div>
                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                        </div>
                                                        <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                            <h2 class="text-sm text-center font-normal">Numero de Flickers por
                                                                encima de 1</h2>
                                                            <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                                {{ !empty($numFlickers[0]->total_flickers) ? $numFlickers[0]->total_flickers : 0}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        {{-- 3º cuadro --}}
                                        <div class="card text-white mb-2" style="
                                                background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <h1 class="text-center text-2xl" style="color: white;">
                                                Desbalances de Tension (Ultimos 3 dias)
                                            </h1>
                                            <div
                                                style="border-bottom: 3px solid transparent;
                                                                            border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div
                                                            class="p-2 #205E86 text-white rounded-lg shadow-xl flex flex-row flex-wrap justify-center">
                                                            <div class="flex flex-col items-center pr-4">
                                                                <p class="text-2xl font-bold max-w-full">Promedio por General
                                                                </p>
                                                                <p class="mt-0 text-3xl text-center max-w-full"
                                                                    style="color:rgb(88,226,194); display: flex; justify-content: center; align-items: center;">
                                                                    <img src="{{ asset('images/unbalance-no-bg.png') }}" width="80" height="80" class="mt-5">
                                                                    {{ !empty($desbalancesTension[0]->avg_desbalance_tension) ? number_format($desbalancesTension[0]->avg_desbalance_tension, 2) : '0.00' }}

                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            style="border-bottom: 3px solid transparent;
                                                                                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                                        </div>
                                                        <div class="p-2 #205E86 text-white rounded-lg shadow-xl">
                                                            <h2 class="text-sm text-center font-normal">Numero de desbalances
                                                                por encima de 2</h2>
                                                            <p class="mt-4 text-3xl  text-center" style="color:rgb(88,226,194)">
                                                                {{ !empty($numDesbalancesTension[0]->total_desbalances) ? $numDesbalancesTension[0]->total_desbalances : 0}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        {{-- TABLA DISTORSIONES ARMONICAS --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white mb-2" style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="container">
                                                    @if (isset($infoDistorsionesArmonicas))
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableEventosCups" class="w-full text-white text-center ">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="mt-0 text-xl  text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            RTU</th>
                                                                        <th class="mt-0 text-xl  text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Fecha</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($infoDistorsionesArmonicas as $resultado)
                                                                        <tr class="highlight-row ">
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->rtu_id) ? $resultado->rtu_id : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No
                                                                hay datos
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <!-- Contenedor del botón de descarga -->
                                                    <div class="text-right mt-4">
                                                        <!-- Botón Excel -->
                                                        <button id="exportarExcel"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;"
                                                            title="Exportar a Excel">
                                                        </button>

                                                        <!-- Botón CSV -->
                                                        <button id="exportarCsv"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/csv-icon.png'); background-size: cover; width: 30px; height: 30px;"
                                                            title="Exportar a CSV">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- TABLA FLCIKERS --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white mb-2" style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="container">
                                                    @if (isset($infoFlickers))
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableEventosCups" class="w-full text-white text-center ">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="mt-0 text-xl  text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Fecha</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            FR</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            FS</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            FT</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($infoFlickers as $resultado)
                                                                        <tr class="highlight-row ">
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->fr) ? $resultado->fr : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->fs) ? $resultado->fs : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->ft) ? $resultado->ft : 'No hay datos' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No
                                                                hay datos
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <!-- Contenedor del botón de descarga -->
                                                    <div class="text-right mt-4">
                                                        <!-- Botón Excel -->
                                                        <button id="exportarExcel"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;"
                                                            title="Exportar a Excel">
                                                        </button>

                                                        <!-- Botón CSV -->
                                                        <button id="exportarCsv"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/csv-icon.png'); background-size: cover; width: 30px; height: 30px;"
                                                            title="Exportar a CSV">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- TABLA DESBALANCES --}}
                                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                                            <div class="card text-white mb-2" style="
                                            background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                                <div class="container">
                                                    @if (isset($infoDesbalancesTension))
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                                            <table id="testTableEventosCups" class="w-full text-white text-center ">
                                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                                    <tr>
                                                                        <th class="mt-0 text-xl  text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Fecha</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Vu</th>
                                                                        <th class="mt-0 text-xl font-bold text-center"
                                                                            style="color:rgb(88,226,194)">
                                                                            Pi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($infoDesbalancesTension as $resultado)
                                                                        <tr class="highlight-row ">
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->vu) ? $resultado->vu : 'No hay datos' }}
                                                                            </td>
                                                                            <td class="py-2">
                                                                                {{ !empty($resultado->pi) ? $resultado->pi : 'No hay datos' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    @else
                                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                                            <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No
                                                                hay datos
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <!-- Contenedor del botón de descarga -->
                                                    <div class="text-right mt-4">
                                                        <!-- Botón Excel -->
                                                        <button id="exportarExcel"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;"
                                                            title="Exportar a Excel">
                                                        </button>

                                                        <!-- Botón CSV -->
                                                        <button id="exportarCsv"
                                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/csv-icon.png'); background-size: cover; width: 30px; height: 30px;"
                                                            title="Exportar a CSV">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</html>