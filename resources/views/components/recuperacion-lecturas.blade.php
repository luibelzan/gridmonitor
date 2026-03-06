{{-- TERCERA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            {{-- 1º cuadro --}}
                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    RECUPERACIÓN DE LECTURAS
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                        style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                        @php
                                            // Combinar todas las fechas de ambas consultas
                                            $fechas = array_unique(
                                                array_merge(
                                                    array_column($resultadosQ12dashboard, 'fec_lectura'),
                                                    array_column($resultadosQ10dashboard, 'fec_lectura'),
                                                ),
                                            );
                                            // Ordenar las fechas
                                            sort($fechas);
                                        @endphp @if (!empty($fechas))
                                            <table id="testTableRecuperacionLecturas"
                                                class="w-full text-white text-center">
                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                    <!-- Fila de fechas -->
                                                    <tr>
                                                        <th></th>
                                                        @foreach ($fechas as $fecha)
                                                            <th colspan="2"
                                                                class="mt-0 text-xl font-bold text-center border-r border-l"
                                                                style="color:rgb(88,226,194); padding: 10px; text-align: center;">
                                                                <div
                                                                    style="display: inline-flex; align-items: center; justify-content: center;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="20" height="20"
                                                                        viewBox="0 0 24 24"
                                                                        style="margin-right: 5px; vertical-align: middle;">
                                                                        <g fill="none">
                                                                            <rect width="18" height="15" x="3"
                                                                                y="6" stroke="#ffffff"
                                                                                stroke-width="2" rx="2" />
                                                                            <path fill="#ffffff"
                                                                                d="M3 10c0-1.886 0-2.828.586-3.414C4.172 6 5.114 6 7 6h10c1.886 0 2.828 0 3.414.586C21 7.172 21 8.114 21 10z" />
                                                                            <path stroke="#ffffff"
                                                                                stroke-linecap="round"
                                                                                stroke-width="2" d="M7 3v3m10-3v3" />
                                                                            <rect width="4" height="2" x="7"
                                                                                y="12" fill="#ffffff"
                                                                                rx=".5" />
                                                                            <rect width="4" height="2" x="7"
                                                                                y="16" fill="#ffffff"
                                                                                rx=".5" />
                                                                            <rect width="4" height="2" x="13"
                                                                                y="12" fill="#ffffff"
                                                                                rx=".5" />
                                                                            <rect width="4" height="2" x="13"
                                                                                y="16" fill="#ffffff"
                                                                                rx=".5" />
                                                                        </g>
                                                                    </svg>
                                                                    <span>{{ !empty($fecha) ? date('d/m/Y', strtotime($fecha)) : 'No hay datos' }}</span>
                                                                </div>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                    <!-- Fila de subcolumnas S02 y S05 -->
                                                    <tr>
                                                        <th></th>
                                                        @foreach ($fechas as $fecha)
                                                            <th class="mt-0 text-xl font-bold text-center border-l"
                                                                style="color:rgb(88,226,194); padding: 10px">S02</th>
                                                            <th class="mt-0 text-xl font-bold text-center border-r"
                                                                style="color:rgb(88,226,194); padding: 10px">S05</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        // Inicializar arrays para almacenar los datos
                                                        $tp_counts_s02 = [];
                                                        $tp_counts_s05 = [];
                                                        $stg_counts_s02 = [];
                                                        $stg_counts_s05 = [];
                                                        $totales_s02 = [];
                                                        $totales_s05 = [];
                                                        // Procesar datos de resultadosQ12dashboard (para S02)
                                                        foreach ($resultadosQ12dashboard as $resultado) {
                                                            if (is_object($resultado)) {
                                                                $fecha = $resultado->fec_lectura;
                                                                $tp_counts_s02[$fecha] = $resultado->tp_count;
                                                                $stg_counts_s02[$fecha] = $resultado->stg_count;
                                                                $totales_s02[$fecha] =
                                                                    ($resultado->tp_count ?? 0) +
                                                                    ($resultado->stg_count ?? 0);
                                                            }
                                                        }
                                                        // Procesar datos de resultadosQ10dashboard (para S05)
                                                        foreach ($resultadosQ10dashboard as $resultado) {
                                                            if (is_object($resultado)) {
                                                                $fecha = $resultado->fec_lectura;
                                                                $tp_counts_s05[$fecha] = $resultado->tp_count;
                                                                $stg_counts_s05[$fecha] = $resultado->stg_count;
                                                                $totales_s05[$fecha] =
                                                                    ($resultado->tp_count ?? 0) +
                                                                    ($resultado->stg_count ?? 0);
                                                            }
                                                        }
                                                    @endphp
                                                    <!-- Primera fila: valores de TP -->
                                                    <tr class="highlight-row ">
                                                        <td class="border-r">Tareas Prog.</td>
                                                        @foreach ($fechas as $fecha)
                                                            <td class="py-2">
                                                                {{ !empty($tp_counts_s02[$fecha]) ? $tp_counts_s02[$fecha] : '0' }}
                                                            </td>
                                                            <td class="py-2 border-r">
                                                                {{ !empty($tp_counts_s05[$fecha]) ? $tp_counts_s05[$fecha] : '0' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <!-- Segunda fila: sumas totales -->
                                                    <tr class="highlight-row ">
                                                        <td class="border-r">Total</td>
                                                        @foreach ($fechas as $fecha)
                                                            <td class="py-2">
                                                                {{ !empty($totales_s02[$fecha]) ? $totales_s02[$fecha] : '0' }}
                                                            </td>
                                                            <td class="py-2 border-r">
                                                                {{ !empty($totales_s05[$fecha]) ? $totales_s05[$fecha] : '0' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <!-- Tercera fila: valores de STG -->
                                                    <tr class="highlight-row ">
                                                        <td class="border-r">Recuperadas</td>
                                                        @foreach ($fechas as $fecha)
                                                            <td class="py-2">
                                                                {{ !empty($stg_counts_s02[$fecha]) ? $stg_counts_s02[$fecha] : '0' }}
                                                            </td>
                                                            <td class="py-2 border-r">
                                                                {{ !empty($stg_counts_s05[$fecha]) ? $stg_counts_s05[$fecha] : '0' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="mt-0 text-xl font-bold text-center"
                                                style="color:rgb(88,226,194); padding: 10px">No hay datos disponibles
                                                para mostrar.</p>
                                        @endif
                                    </div>
                                    <!-- Contenedor del botón de descarga -->
                                    <div class="text-right mt-4">
                                        <input type="button"
                                            onclick="tableToExcel2Cols('testTableRecuperacionLecturas', 'W3C Example Table')"
                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                    </div>
                                </div>
                            </div>
                        </div>