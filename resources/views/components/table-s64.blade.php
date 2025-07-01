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
                    <td colspan="14" class="py-4 text-center text-gray-400">
                        No hay datos disponibles
                    </td>
                </tr>
            @else
                @foreach($resultados as $resultado)
                    <tr>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->id_linea) ? $resultado->id_linea : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->v1) ? $resultado->v1 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->v2) ? $resultado->v2 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->v3) ? $resultado->v3 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->i1) ? $resultado->i1 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->i2) ? $resultado->i2 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->i3) ? $resultado->i3 : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->in) ? $resultado->in : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->simp) ? $resultado->simp : '0' }}
                        </td>
                        <td class="py-2" style="padding: 10px;">
                            {{ !empty($resultado->sexp) ? $resultado->sexp : '0' }}
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

<div>
    <h1 class="text-center text-3xl mt-4" style="color: white;">TENSIONES POR LINEA Y FASE </h1>
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

    {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA --}}
    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                <div id="graficoV1" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoLineaV1" class="w-full"></canvas>
                </div>
            </div>
        @endif
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
    @endphp



    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 1 --}}
    <script>
        var datosPorLinea = {};
        var tooltipsPorLinea = {}; // NUEVO objeto para guardar fecha con hora

        @foreach ($resultados2 as $resultado)
            @if (isset($resultado->fh) && isset($resultado->v1) && isset($resultado->id_linea))
                var linea = '{{ $resultado->id_linea }}';
                var fecha = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i') }}';
                var fechaCompleta = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i:s') }}';
                var valor = {{ $resultado->v1 }};

                if (!datosPorLinea[linea]) {
                    datosPorLinea[linea] = {
                        labels: [],
                        values: []
                    };
                    tooltipsPorLinea[linea] = {};
                }

                datosPorLinea[linea].labels.push(fecha);
                datosPorLinea[linea].values.push(valor);
                tooltipsPorLinea[linea][fecha] = fechaCompleta;
            @endif
        @endforeach

        var etiquetasGlobalesSet = new Set();
        Object.values(datosPorLinea).forEach(linea => {
            linea.labels.forEach(label => etiquetasGlobalesSet.add(label));
        });
        var etiquetasGlobales = Array.from(etiquetasGlobalesSet).sort();
        var fechas = Array.from(etiquetasGlobalesSet).sort();

        var datasets = [];

        Object.keys(datosPorLinea).forEach(lineaId => {
            const linea = datosPorLinea[lineaId];
            const datosPorFecha = {};
            for (let i = 0; i < linea.labels.length; i++) {
                datosPorFecha[linea.labels[i]] = linea.values[i];
            }
            // Mapear el valor según fechas completas
            const valoresAlineados = fechas.map(fecha => {
                return datosPorFecha[fecha] !== undefined ? datosPorFecha[fecha] : null;
            });

            datasets.push({
                label: 'Línea ' + lineaId,
                data: valoresAlineados,
                borderColor: getColor(lineaId),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointRadius: 3,
                tooltips: fechas.map(f => tooltipsPorLinea[lineaId][f] ?? f)
            });
        });


        function hashCode(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            return hash;
        }

        function getColor(lineaId) {
            const colores = [
                '#EE9104', '#4BC0C0', '#FF6384', '#36A2EB',
                '#9966FF', '#FF9F40', '#00cc99', '#ffcc00'
            ];
            const hash = hashCode(lineaId);
            const index = Math.abs(hash) % colores.length;
            return colores[index];
        }


        var ctx = document.getElementById('graficoLineaV1').getContext('2d');
        var myChartLineVoltaje1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas, // eje X
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tension Fase R',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Didact Gothic'
                        },

                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: { family: 'Didact Gothic', weight: 'normal' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                // Obtener el índice del punto
                                const index = context[0].dataIndex;
                                const dataset = context[0].dataset;
                                return dataset.tooltips ? dataset.tooltips[index] : context[0].label;
                            },
                            label: function (context) {
                                return 'Valor: ' + context.formattedValue + ' V';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            stepSize: 2
                        }
                    },
                    y: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            callback: value => value + ' V'
                        }
                    }
                }
            }
        });

    </script>

    {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS V2 --}}
    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                <div id="graficoV2" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoLineaVoltaje2" class="w-full"></canvas>
                </div>
            </div>
        @endif
    </div>

    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 1 --}}
    <script>
        var datosPorLinea = {};
        var tooltipsPorLinea = {}; // NUEVO objeto para guardar fecha con hora

        @foreach ($resultados2 as $resultado)
            @if (isset($resultado->fh) && isset($resultado->v2) && isset($resultado->id_linea))
                var linea = '{{ $resultado->id_linea }}';
                var fecha = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i') }}';
                var fechaCompleta = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i:s') }}';
                var valor = {{ $resultado->v2 }};

                if (!datosPorLinea[linea]) {
                    datosPorLinea[linea] = {
                        labels: [],
                        values: []
                    };
                    tooltipsPorLinea[linea] = {};
                }

                datosPorLinea[linea].labels.push(fecha);
                datosPorLinea[linea].values.push(valor);
                tooltipsPorLinea[linea][fecha] = fechaCompleta;
            @endif
        @endforeach

        var etiquetasGlobalesSet = new Set();
        Object.values(datosPorLinea).forEach(linea => {
            linea.labels.forEach(label => etiquetasGlobalesSet.add(label));
        });
        var etiquetasGlobales = Array.from(etiquetasGlobalesSet).sort();
        var fechas = Array.from(etiquetasGlobalesSet).sort();

        var datasets = [];

        Object.keys(datosPorLinea).forEach(lineaId => {
            const linea = datosPorLinea[lineaId];
            const datosPorFecha = {};
            for (let i = 0; i < linea.labels.length; i++) {
                datosPorFecha[linea.labels[i]] = linea.values[i];
            }
            // Mapear el valor según fechas completas
            const valoresAlineados = fechas.map(fecha => {
                return datosPorFecha[fecha] !== undefined ? datosPorFecha[fecha] : null;
            });

            datasets.push({
                label: 'Línea ' + lineaId,
                data: valoresAlineados,
                borderColor: getColor(lineaId),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointRadius: 3,
                tooltips: fechas.map(f => tooltipsPorLinea[lineaId][f] ?? f)
            });
        });


        function hashCode(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            return hash;
        }

        function getColor(lineaId) {
            const colores = [
                '#EE9104', '#4BC0C0', '#FF6384', '#36A2EB',
                '#9966FF', '#FF9F40', '#00cc99', '#ffcc00'
            ];
            const hash = hashCode(lineaId);
            const index = Math.abs(hash) % colores.length;
            return colores[index];
        }


        var ctx = document.getElementById('graficoLineaVoltaje2').getContext('2d');
        var myChartLineVoltaje1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas, // eje X
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tension Fase S',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Didact Gothic'
                        },

                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: { family: 'Didact Gothic', weight: 'normal' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                // Obtener el índice del punto
                                const index = context[0].dataIndex;
                                const dataset = context[0].dataset;
                                return dataset.tooltips ? dataset.tooltips[index] : context[0].label;
                            },
                            label: function (context) {
                                return 'Valor: ' + context.formattedValue + ' V';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            stepSize: 2
                        }
                    },
                    y: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            callback: value => value + ' V'
                        }
                    }
                }
            }
        });

    </script>



    {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS V2 --}}
    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                <div id="graficoV3" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoLineaVoltaje3" class="w-full"></canvas>
                </div>
            </div>
        @endif
    </div>

    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 3 --}}
    <script>
        var datosPorLinea = {};
        var tooltipsPorLinea = {}; // NUEVO objeto para guardar fecha con hora

        @foreach ($resultados2 as $resultado)
            @if (isset($resultado->fh) && isset($resultado->v3) && isset($resultado->id_linea))
                var linea = '{{ $resultado->id_linea }}';
                var fecha = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i') }}';
                var fechaCompleta = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i:s') }}';
                var valor = {{ $resultado->v3 }};

                if (!datosPorLinea[linea]) {
                    datosPorLinea[linea] = {
                        labels: [],
                        values: []
                    };
                    tooltipsPorLinea[linea] = {};
                }

                datosPorLinea[linea].labels.push(fecha);
                datosPorLinea[linea].values.push(valor);
                tooltipsPorLinea[linea][fecha] = fechaCompleta;
            @endif
        @endforeach

        var etiquetasGlobalesSet = new Set();
        Object.values(datosPorLinea).forEach(linea => {
            linea.labels.forEach(label => etiquetasGlobalesSet.add(label));
        });
        var etiquetasGlobales = Array.from(etiquetasGlobalesSet).sort();
        var fechas = Array.from(etiquetasGlobalesSet).sort();

        var datasets = [];

        Object.keys(datosPorLinea).forEach(lineaId => {
            const linea = datosPorLinea[lineaId];
            const datosPorFecha = {};
            for (let i = 0; i < linea.labels.length; i++) {
                datosPorFecha[linea.labels[i]] = linea.values[i];
            }
            // Mapear el valor según fechas completas
            const valoresAlineados = fechas.map(fecha => {
                return datosPorFecha[fecha] !== undefined ? datosPorFecha[fecha] : null;
            });

            datasets.push({
                label: 'Línea ' + lineaId,
                data: valoresAlineados,
                borderColor: getColor(lineaId),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointRadius: 3,
                tooltips: fechas.map(f => tooltipsPorLinea[lineaId][f] ?? f)
            });
        });


        function hashCode(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            return hash;
        }

        function getColor(lineaId) {
            const colores = [
                '#EE9104', '#4BC0C0', '#FF6384', '#36A2EB',
                '#9966FF', '#FF9F40', '#00cc99', '#ffcc00'
            ];
            const hash = hashCode(lineaId);
            const index = Math.abs(hash) % colores.length;
            return colores[index];
        }


        var ctx = document.getElementById('graficoLineaVoltaje3').getContext('2d');
        var myChartLineVoltaje1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas, // eje X
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tension Fase T',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Didact Gothic'
                        },

                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: { family: 'Didact Gothic', weight: 'normal' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                // Obtener el índice del punto
                                const index = context[0].dataIndex;
                                const dataset = context[0].dataset;
                                return dataset.tooltips ? dataset.tooltips[index] : context[0].label;
                            },
                            label: function (context) {
                                return 'Valor: ' + context.formattedValue + ' V';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            stepSize: 2
                        }
                    },
                    y: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            callback: value => value + ' V'
                        }
                    }
                }
            }
        });

    </script>

</div>


{{-- INTENSIDADES DEL CT --}}

<div>
    <h1 class="text-center text-3xl mt-4" style="color: white;">INTENSIDADES POR LINEA Y FASE</h1>
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

    {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA I1 --}}
    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                <div id="graficoI1" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoLineaI1" class="w-full"></canvas>
                </div>
            </div>
        @endif
    </div>


    {{-- SCRIPTS PARA EL GRÁFICO INTENSIDAD 1 --}}
    <script>
        var datosPorLinea = {};
        var tooltipsPorLinea = {}; // NUEVO objeto para guardar fecha con hora

        @foreach ($resultados2 as $resultado)
            @if (isset($resultado->fh) && isset($resultado->i1) && isset($resultado->id_linea))
                var linea = '{{ $resultado->id_linea }}';
                var fecha = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i') }}';
                var fechaCompleta = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i:s') }}';
                var valor = {{ $resultado->i1 }};

                if (!datosPorLinea[linea]) {
                    datosPorLinea[linea] = {
                        labels: [],
                        values: []
                    };
                    tooltipsPorLinea[linea] = {};
                }

                datosPorLinea[linea].labels.push(fecha);
                datosPorLinea[linea].values.push(valor);
                tooltipsPorLinea[linea][fecha] = fechaCompleta;
            @endif
        @endforeach

        var etiquetasGlobalesSet = new Set();
        Object.values(datosPorLinea).forEach(linea => {
            linea.labels.forEach(label => etiquetasGlobalesSet.add(label));
        });
        var etiquetasGlobales = Array.from(etiquetasGlobalesSet).sort();
        var fechas = Array.from(etiquetasGlobalesSet).sort();

        var datasets = [];

        Object.keys(datosPorLinea).forEach(lineaId => {
            const linea = datosPorLinea[lineaId];
            const datosPorFecha = {};
            for (let i = 0; i < linea.labels.length; i++) {
                datosPorFecha[linea.labels[i]] = linea.values[i];
            }
            // Mapear el valor según fechas completas
            const valoresAlineados = fechas.map(fecha => {
                return datosPorFecha[fecha] !== undefined ? datosPorFecha[fecha] : null;
            });

            datasets.push({
                label: 'Línea ' + lineaId,
                data: valoresAlineados,
                borderColor: getColor(lineaId),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointRadius: 3,
                tooltips: fechas.map(f => tooltipsPorLinea[lineaId][f] ?? f)
            });
        });


        function hashCode(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            return hash;
        }

        function getColor(lineaId) {
            const colores = [
                '#1E88E5', // Azul intenso (muy baja intensidad)
                '#43A047', // Verde oscuro (baja intensidad)
                '#FDD835', // Amarillo (media intensidad)
                '#FB8C00', // Naranja (alta intensidad)
                '#E53935', // Rojo intenso (muy alta intensidad)
                '#8E24AA', // Púrpura (pico o alerta)
                '#00ACC1', // Cian (uso especial o neutro)
                '#FFB300'  // Naranja brillante (intermedio cálido)
            ];
            const hash = hashCode(lineaId);
            const index = Math.abs(hash) % colores.length;
            return colores[index];
        }



        var ctx = document.getElementById('graficoLineaI1').getContext('2d');
        var myChartLineVoltaje1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas, // eje X
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Intensidad Fase R',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Didact Gothic'
                        },

                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: { family: 'Didact Gothic', weight: 'normal' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                // Obtener el índice del punto
                                const index = context[0].dataIndex;
                                const dataset = context[0].dataset;
                                return dataset.tooltips ? dataset.tooltips[index] : context[0].label;
                            },
                            label: function (context) {
                                return 'Valor: ' + context.formattedValue + ' I';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            stepSize: 2
                        }
                    },
                    y: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            callback: value => value + ' I'
                        }
                    }
                }
            }
        });

    </script>

    {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA I1 --}}
    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                <div id="graficoI2" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoLineaI2" class="w-full"></canvas>
                </div>
            </div>
        @endif
    </div>


    {{-- SCRIPTS PARA EL GRÁFICO INTENSIDAD 2 --}}
    <script>
        var datosPorLinea = {};
        var tooltipsPorLinea = {}; // NUEVO objeto para guardar fecha con hora

        @foreach ($resultados2 as $resultado)
            @if (isset($resultado->fh) && isset($resultado->i2) && isset($resultado->id_linea))
                var linea = '{{ $resultado->id_linea }}';
                var fecha = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i') }}';
                var fechaCompleta = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i:s') }}';
                var valor = {{ $resultado->i2 }};

                if (!datosPorLinea[linea]) {
                    datosPorLinea[linea] = {
                        labels: [],
                        values: []
                    };
                    tooltipsPorLinea[linea] = {};
                }

                datosPorLinea[linea].labels.push(fecha);
                datosPorLinea[linea].values.push(valor);
                tooltipsPorLinea[linea][fecha] = fechaCompleta;
            @endif
        @endforeach

        var etiquetasGlobalesSet = new Set();
        Object.values(datosPorLinea).forEach(linea => {
            linea.labels.forEach(label => etiquetasGlobalesSet.add(label));
        });
        var etiquetasGlobales = Array.from(etiquetasGlobalesSet).sort();
        var fechas = Array.from(etiquetasGlobalesSet).sort();

        var datasets = [];

        Object.keys(datosPorLinea).forEach(lineaId => {
            const linea = datosPorLinea[lineaId];
            const datosPorFecha = {};
            for (let i = 0; i < linea.labels.length; i++) {
                datosPorFecha[linea.labels[i]] = linea.values[i];
            }
            // Mapear el valor según fechas completas
            const valoresAlineados = fechas.map(fecha => {
                return datosPorFecha[fecha] !== undefined ? datosPorFecha[fecha] : null;
            });

            datasets.push({
                label: 'Línea ' + lineaId,
                data: valoresAlineados,
                borderColor: getColor(lineaId),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointRadius: 3,
                tooltips: fechas.map(f => tooltipsPorLinea[lineaId][f] ?? f)
            });
        });


        function hashCode(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            return hash;
        }

        function getColor(lineaId) {
            const colores = [
                '#1E88E5', // Azul intenso (muy baja intensidad)
                '#43A047', // Verde oscuro (baja intensidad)
                '#FDD835', // Amarillo (media intensidad)
                '#FB8C00', // Naranja (alta intensidad)
                '#E53935', // Rojo intenso (muy alta intensidad)
                '#8E24AA', // Púrpura (pico o alerta)
                '#00ACC1', // Cian (uso especial o neutro)
                '#FFB300'  // Naranja brillante (intermedio cálido)
            ];
            const hash = hashCode(lineaId);
            const index = Math.abs(hash) % colores.length;
            return colores[index];
        }



        var ctx = document.getElementById('graficoLineaI2').getContext('2d');
        var myChartLineVoltaje1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas, // eje X
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Intensidad Fase S',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Didact Gothic'
                        },

                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: { family: 'Didact Gothic', weight: 'normal' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                // Obtener el índice del punto
                                const index = context[0].dataIndex;
                                const dataset = context[0].dataset;
                                return dataset.tooltips ? dataset.tooltips[index] : context[0].label;
                            },
                            label: function (context) {
                                return 'Valor: ' + context.formattedValue + ' I';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            stepSize: 2
                        }
                    },
                    y: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            callback: value => value + ' I'
                        }
                    }
                }
            }
        });

    </script>

    {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA I1 --}}
    <div class="card text-white mb-3 col-span-4"
        style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

        @if (isset($resultados2[0]) == null)
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @else
            <div class="table-responsive w-full" style="display: flex; justify-content: center;">
                <div id="graficoI3" style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                    <canvas id="graficoLineaI3" class="w-full"></canvas>
                </div>
            </div>
        @endif
    </div>


    {{-- SCRIPTS PARA EL GRÁFICO INTENSIDAD 1 --}}
    <script>
        var datosPorLinea = {};
        var tooltipsPorLinea = {}; // NUEVO objeto para guardar fecha con hora

        @foreach ($resultados2 as $resultado)
            @if (isset($resultado->fh) && isset($resultado->i3) && isset($resultado->id_linea))
                var linea = '{{ $resultado->id_linea }}';
                var fecha = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i') }}';
                var fechaCompleta = '{{ \Carbon\Carbon::parse($resultado->fh)->format('Y-m-d H:i:s') }}';
                var valor = {{ $resultado->i3 }};

                if (!datosPorLinea[linea]) {
                    datosPorLinea[linea] = {
                        labels: [],
                        values: []
                    };
                    tooltipsPorLinea[linea] = {};
                }

                datosPorLinea[linea].labels.push(fecha);
                datosPorLinea[linea].values.push(valor);
                tooltipsPorLinea[linea][fecha] = fechaCompleta;
            @endif
        @endforeach

        var etiquetasGlobalesSet = new Set();
        Object.values(datosPorLinea).forEach(linea => {
            linea.labels.forEach(label => etiquetasGlobalesSet.add(label));
        });
        var etiquetasGlobales = Array.from(etiquetasGlobalesSet).sort();
        var fechas = Array.from(etiquetasGlobalesSet).sort();

        var datasets = [];

        Object.keys(datosPorLinea).forEach(lineaId => {
            const linea = datosPorLinea[lineaId];
            const datosPorFecha = {};
            for (let i = 0; i < linea.labels.length; i++) {
                datosPorFecha[linea.labels[i]] = linea.values[i];
            }
            // Mapear el valor según fechas completas
            const valoresAlineados = fechas.map(fecha => {
                return datosPorFecha[fecha] !== undefined ? datosPorFecha[fecha] : null;
            });

            datasets.push({
                label: 'Línea ' + lineaId,
                data: valoresAlineados,
                borderColor: getColor(lineaId),
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointRadius: 3,
                tooltips: fechas.map(f => tooltipsPorLinea[lineaId][f] ?? f)
            });
        });


        function hashCode(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            return hash;
        }

        function getColor(lineaId) {
            const colores = [
                '#1E88E5', // Azul intenso (muy baja intensidad)
                '#43A047', // Verde oscuro (baja intensidad)
                '#FDD835', // Amarillo (media intensidad)
                '#FB8C00', // Naranja (alta intensidad)
                '#E53935', // Rojo intenso (muy alta intensidad)
                '#8E24AA', // Púrpura (pico o alerta)
                '#00ACC1', // Cian (uso especial o neutro)
                '#FFB300'  // Naranja brillante (intermedio cálido)
            ];
            const hash = hashCode(lineaId);
            const index = Math.abs(hash) % colores.length;
            return colores[index];
        }



        var ctx = document.getElementById('graficoLineaI3').getContext('2d');
        var myChartLineVoltaje1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas, // eje X
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Intensidad Fase T',
                        color: 'white',
                        font: {
                            size: 18,
                            weight: 'bold',
                            family: 'Didact Gothic'
                        },

                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white',
                            font: { family: 'Didact Gothic', weight: 'normal' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                // Obtener el índice del punto
                                const index = context[0].dataIndex;
                                const dataset = context[0].dataset;
                                return dataset.tooltips ? dataset.tooltips[index] : context[0].label;
                            },
                            label: function (context) {
                                return 'Valor: ' + context.formattedValue + ' I';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            stepSize: 2
                        }
                    },
                    y: {
                        grid: { color: 'rgb(50, 50, 50)' },
                        ticks: {
                            color: '#FFFFFF',
                            callback: value => value + ' I'
                        }
                    }
                }
            }
        });

    </script>

</div>