<div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
    style="max-height: 400px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
    <div class="mb-4" style="border-bottom: 3px solid transparent;
                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
    </div>
    <table id="tabla-eventos" class="w-full text-white text-center" style="border-spacing: 0 5px;">
        <thead style="border-bottom: 1px solid #ffffff;">
            <tr>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">RTU ID</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">FH</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">NR</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">NS</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">NT</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">BC</th>
            </tr>
        </thead>

        @php
            $hayDatos = false;
            foreach ($resultados as $r) {
                if (!empty($r->rtu_id) || !empty($r->lvs_id) || !empty($r->fh)) {
                    $hayDatos = true;
                    break;
                }
            }
        @endphp

        <tbody>
            @if(!$hayDatos)
                <tr>
                    <td colspan="6" class="py-4 text-center text-gray-400">
                        No hay datos disponibles
                    </td>
                </tr>
            @else
                @foreach($resultados as $resultado)
                    <tr>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->rtu_id) ? $resultado->rtu_id : 'No hay datos' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->nr) ? $resultado->nr : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->ns) ? $resultado->ns : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->nt) ? $resultado->nt : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->bc) ? $resultado->bc : '0' }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<div class="pagination-container mt-4 flex justify-center items-center">
    <div class="pagination">
        {{ $resultados->links() }}
    </div>
</div>

@php
    use Carbon\Carbon;

    $fecha_inicio = request()->query('fecha_inicio')
        ? Carbon::parse(request()->query('fecha_inicio'))
        : Carbon::now()->subHours(48);

    $fecha_fin = request()->query('fecha_fin')
        ? Carbon::parse(request()->query('fecha_fin'))
        : Carbon::now();

    $fechas_completas = [];
    $fecha_actual = $fecha_inicio->copy();

    while ($fecha_actual->lte($fecha_fin)) {
        $fechas_completas[] = $fecha_actual->format('Y-m-d');
        $fecha_actual->addDay();
    }

    $valoresAgrupados = [];

    foreach ($resultados2 as $r) {
        $fecha = \Carbon\Carbon::parse($r->fh)->format('Y-m-d');

        if (!isset($valoresAgrupados[$fecha])) {
            $valoresAgrupados[$fecha] = ['nr' => [], 'ns' => [], 'nt' => []];
        }

        $valoresAgrupados[$fecha]['nr'][] = $r->nr;
        $valoresAgrupados[$fecha]['ns'][] = $r->ns;
        $valoresAgrupados[$fecha]['nt'][] = $r->nt;
    }

    $valoresNrPorFecha = [];
    $valoresNsPorFecha = [];
    $valoresNtPorFecha = [];

    foreach ($fechas_completas as $fecha) {
        $nr = $valoresAgrupados[$fecha]['nr'] ?? [];
        $ns = $valoresAgrupados[$fecha]['ns'] ?? [];
        $nt = $valoresAgrupados[$fecha]['nt'] ?? [];

        $valoresNrPorFecha[$fecha] = count($nr) ? array_sum($nr) : 0;
        $valoresNsPorFecha[$fecha] = count($ns) ? array_sum($ns) : 0;
        $valoresNtPorFecha[$fecha] = count($nt) ? array_sum($nt) : 0;
    }

    $sumaTotalNr = array_sum($valoresNrPorFecha);
    $sumaTotalNs = array_sum($valoresNsPorFecha);
    $sumaTotalNt = array_sum($valoresNtPorFecha);

@endphp


<div>
    <h1 class="text-center text-3xl mt-4" style="color: white;">VARIACIONES DE TENSION POR FASE</h1>
    <h2 class="text-center text-1xl w-full mb-2" style="color: white;">
        @if (request()->query('fecha_inicio') && request()->query('fecha_fin'))
            Del
            {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
            al
            {{ \Carbon\Carbon::parse(request()->query('fecha_fin'))->format('d/m/Y') }}
        @elseif (request()->query('fecha_inicio'))
            Del
            {{ \Carbon\Carbon::parse(request()->query('fecha_inicio'))->format('d/m/Y') }}
            al
            {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        @else
            (Últimas 48 horas)
        @endif
    </h2>
    <div style="border-bottom: 3px solid transparent;
        border-image: linear-gradient(to right, transparent, rgb(27,32,38), transparent) 1;">
    </div>

    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; flex-direction: column; align-items: center;">
                <div id="graficoV1" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoNumeroVariacionesTensionR" class="w-full"></canvas>
                </div>
                <div style="text-align: center; margin-top: 1em;">
                    <strong>Numero variaciones Fase R:  {{ $sumaTotalNr }} </strong>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fechas = [
                @foreach ($fechas_completas as $f)
                    "{{ $f }}",
                @endforeach
        ];

            const nr = [
                @foreach ($fechas_completas as $f)
                    {{ $valoresNrPorFecha[$f] }},
                @endforeach
        ];

            const ctx = document.getElementById('graficoNumeroVariacionesTensionR').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [{
                        label: 'NR',
                        data: nr,
                        backgroundColor: 'rgba(88, 226, 194, 0.6)',
                        borderColor: 'rgba(88, 226, 194, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: '#ffffff',
                                stepSize: 2,
                                autoSkip: false,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#ffffff' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        });
    </script>

    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; flex-direction: column; align-items: center;">
                <div id="graficoV1" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoNumeroVariacionesTensionS" class="w-full"></canvas>
                </div>
                <div style="text-align: center; margin-top: 1em;">
                    <strong>Numero variaciones Fase S:  {{ $sumaTotalNs }} </strong>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fechas = [
                @foreach ($fechas_completas as $f)
                    "{{ $f }}",
                @endforeach
        ];

            const ns = [
                @foreach ($fechas_completas as $f)
                    {{ $valoresNsPorFecha[$f] }},
                @endforeach
        ];

            const ctx = document.getElementById('graficoNumeroVariacionesTensionS').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [{
                        label: 'NR',
                        data: ns,
                        backgroundColor: 'rgba(88, 226, 194, 0.6)',
                        borderColor: 'rgba(88, 226, 194, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: '#ffffff',
                                stepSize: 2,
                                autoSkip: false,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#ffffff' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        });
    </script>

    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; flex-direction: column; align-items: center;">
                <div id="graficoV1" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoNumeroVariacionesTensionT" class="w-full"></canvas>
                </div>
                <div style="text-align: center; margin-top: 1em;">
                    <strong>Numero variaciones Fase T:  {{ $sumaTotalNt }} </strong>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fechas = [
                @foreach ($fechas_completas as $f)
                    "{{ $f }}",
                @endforeach
        ];

            const nt = [
                @foreach ($fechas_completas as $f)
                    {{ $valoresNtPorFecha[$f] }},
                @endforeach
        ];

            const ctx = document.getElementById('graficoNumeroVariacionesTensionT').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [{
                        label: 'NT',
                        data: nt,
                        backgroundColor: 'rgba(88, 226, 194, 0.6)',
                        borderColor: 'rgba(88, 226, 194, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: '#ffffff',
                                stepSize: 2,
                                autoSkip: false,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#ffffff' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        });
    </script>

</div>