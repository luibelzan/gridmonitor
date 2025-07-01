<div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
    style="max-height: 400px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
    <div class="mb-4" style="border-bottom: 3px solid transparent;
                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
    </div>
    <table id="tabla-eventos" class="w-full text-white text-center" style="border-spacing: 0 5px;">
        <thead style="border-bottom: 1px solid #ffffff;">
            <tr>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">Linea</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">FECHA</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">HORA</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">AI</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">AE</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">R1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">R2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">R3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">R4</th>
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
                    <td colspan="11" class="py-4 text-center text-gray-400">
                        No hay datos disponibles
                    </td>
                </tr>
            @else
                @foreach($resultados as $resultado)
                    <tr>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->id_linea) ? $resultado->id_linea : 'No hay datos' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->fec_inicio) ? $resultado->fec_inicio : 'No hay datos' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->hor_inicio) ? $resultado->hor_inicio : 'No hay datos' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->ai) ? $resultado->ai : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->ae) ? $resultado->ae : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->r1) ? $resultado->r1 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->r2) ? $resultado->r2 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->r3) ? $resultado->r3 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->r4) ? $resultado->r4 : '0' }}
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
    $fechaInicio = request()->query('fecha_inicio')
        ? Carbon::parse(request()->query('fecha_inicio'))
        : Carbon::now()->subHours(48);

    $fechaFin = request()->query('fecha_fin')
        ? Carbon::parse(request()->query('fecha_fin'))
        : Carbon::now();

    $fechas = [];
    $fechaActual = $fechaInicio->copy();
    while ($fechaActual <= $fechaFin) {
        $fechas[] = $fechaActual->format('d-m-Y');
        $fechaActual->addDay();
    }

    $agrupado = [];

    if (is_array($resultados2) && isset($resultados2[0]) && is_object($resultados2[0])) {
        foreach ($resultados2 as $r) {
            $linea = $r->id_linea;
            $fecha = \Carbon\Carbon::parse($r->fec_inicio)->format('d-m-Y');
            $agrupado[$linea][$fecha]['ai'] = ($agrupado[$linea][$fecha]['ai'] ?? 0) + ($r->ai ?? 0);
            $agrupado[$linea][$fecha]['ae'] = ($agrupado[$linea][$fecha]['ae'] ?? 0) + ($r->ae ?? 0);
        }
    } else {
        $agrupado = [];
    }


@endphp


<div>
    <h1 class="text-center text-3xl mt-4" style="color: white;">ENERGIA POR LINEA</h1>
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


    {{-- GRAFICO DE ENERGIA LINEA 1 --}}
    @foreach ($agrupado as $linea => $valores)
            @if (empty($resultados2[0]))
                    <div class="card text-white mb-3 col-span-4"
                        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));"></div>
                    <div class="p-4 h-full flex flex-col justify-center items-center">
                        <p class="text-center text-yellow-500">No hay datos</p>
                    </div>
                </div>
            @else
            <div class="card text-white mb-3 col-span-4"
                style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                    <div class="graficoV2" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                        <h3 class="text-white text-center text-xl mb-2">Línea {{ $linea }}</h3>
                        <canvas class="w-full mb-10" id="grafico_linea_{{ $linea }}"></canvas>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

</div>


{{-- Datos JS --}}
<script>
    const datos = @json($agrupado);
    const fechas = @json($fechas);
</script>

{{-- Script para gráficos --}}
<script>
    const colores = {
        ai: [
            '#1f77b4', // azul fuerte
            '#ff7f0e', // naranja
            '#2ca02c', // verde
            '#d62728', // rojo
            '#9467bd', // morado
            '#8c564b', // marrón
            '#e377c2', // rosa fuerte
            '#7f7f7f'  // gris oscuro
        ],
        ae: [
            '#ff4500', // naranja rojizo
            '#bcbd22', // verde lima
            '#ff9896', // rojo claro
            '#98df8a', // verde claro
            '#c5b0d5', // lila claro
            '#c49c94', // beige
            '#f7b6d2', // rosa claro
            '#c7c7c7'  // gris claro
        ]
    };



    document.addEventListener("DOMContentLoaded", function () {
        const allAi = [];
        const allAe = [];

        // Recolectar todos los valores de ai y ae en todas las líneas
        for (const linea in datos) {
            for (const f of fechas) {
                allAi.push(datos[linea]?.[f]?.ai ?? 0);
                allAe.push(datos[linea]?.[f]?.ae ?? 0);
            }
        }

        // Calcular el máximo global entre todos los datos
        const maxAi = Math.max(...allAi);
        const maxAe = Math.max(...allAe);
        const maxY = Math.max(maxAi, maxAe);

        let lineaIndex = 0;

        for (const linea in datos) {
            const ai = [];
            const ae = [];

            for (const f of fechas) {
                ai.push(datos[linea]?.[f]?.ai ?? 0);
                ae.push(datos[linea]?.[f]?.ae ?? 0);
            }

            const ctx = document.getElementById(`grafico_linea_${linea}`).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [
                        {
                            label: 'AI',
                            backgroundColor: colores.ai[lineaIndex % colores.ai.length],
                            data: ai
                        },
                        {
                            label: 'AE',
                            backgroundColor: colores.ae[lineaIndex % colores.ae.length],
                            data: ae
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: 'white',
                                stepSize: 2,
                                autoSkip: false,
                            }
                        },
                        y: {
                            min: 0,
                            max: maxY,
                            ticks: {
                                color: 'white',
                                callback: val => Math.round(val / 1000) + " kWh"
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.dataset.label + ": " + Math.round(ctx.raw / 1000) + " kWh"
                            }
                        }
                    }
                }
            });

            lineaIndex++;
        }
    });
</script>