{{-- DESEQUILIBRIOS CORRIENTE --}}
<div class="card text-white mb-3 col-span-1"
    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
    <div class="p-4 h-full flex flex-col justify-center items-center">
        <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
            Desequilibrio Corriente
        </h1>
        @if (is_array($resultadosQ47) && count($resultadosQ47) > 0)
            <div id="graficoDesequilibrioCorriente" class="h-40 "></div>
        @else
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @endif
    </div>
    {{-- GRAFICO DESEQUILIBRIO CORRIENTE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var avg_pct_deseq_corriente = {
                @if (is_array($resultadosQ47) && count($resultadosQ47) > 0 && !empty($resultadosQ47[0]->avg_pct_deseq_corriente))
                    data: {{ $resultadosQ47[0]->avg_pct_deseq_corriente }},
                @else
                                                            data: 0,
                                                        @endif
                                                    };

        function updateChartDesequilibrioCorriente(data) {
            function getColor(value) {
                return value <= 30 ? "rgb(76,218,19)" : "rgba(232,80,107, 0.9)";
            }

            var color = getColor(data.data);
            var textColor = color;

            var max_pct_deseq_corriente = @json($resultadosQ47[0]->max_pct_deseq_corriente ?? 100);
            var min_pct_deseq_corriente = @json($resultadosQ47[0]->min_pct_deseq_corriente ?? 0);

            var newData = [{
                type: "indicator",
                mode: "gauge",
                value: data.data,
                title: {
                    font: {
                        size: 20,
                        color: 'white'
                    }
                },
                gauge: {
                    axis: {
                        range: [min_pct_deseq_corriente, max_pct_deseq_corriente],
                        tickwidth: 1,
                        tickcolor: color,
                        linecolor: color
                    },
                    bar: {
                        color: color,
                        thickness: 0.8
                    },
                    bgcolor: "transparent",
                    borderwidth: 2,
                    bordercolor: "transparent",
                    steps: [{
                        range: [0, min_pct_deseq_corriente],
                        color: "transparent"
                    }, {
                        range: [min_pct_deseq_corriente, max_pct_deseq_corriente],
                        color: "transparent"
                    }],
                    startangle: 270,
                },
                hoverinfo: 'none',
            }];

            var layout = {
                responsive: true,
                maintainAspectRatio: false,
                margin: {
                    t: 35,
                    r: 35,
                    l: 35,
                    b: 35
                },
                paper_bgcolor: "transparent",
                font: {
                    color: "white",
                    family: "Didact Gothic",
                    weight: 'normal'
                },
                annotations: [{
                    text: data.data + ' %',
                    x: 0.5,
                    y: 0.4,
                    showarrow: false,
                    font: {
                        size: 20,
                        color: textColor
                    }
                }],
            };

            Plotly.react('graficoDesequilibrioCorriente', newData, layout, {
                displaylogo: false,
                displayModeBar: false
            });
        }

        // Llamar a la función para inicializar el gráfico con los datos
        updateChartDesequilibrioCorriente(avg_pct_deseq_corriente);
                                                });
    </script>


    <div class="p-4 h-full flex flex-row justify-center items-center">
        <div id="cuadrosNaranjas" class="flex flex-row items-center justify-center space-x-4">

            <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                <p class="text-xl font-bold text-center">
                    {{ !empty($resultadosQ47[0]->min_pct_deseq_corriente) ? $resultadosQ47[0]->min_pct_deseq_corriente : '0' }}%
                </p>
            </div>
            <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                <p class="text-xl font-bold text-center">
                    {{ !empty($resultadosQ47[0]->max_pct_deseq_corriente) ? $resultadosQ47[0]->max_pct_deseq_corriente : '0' }}%
                </p>
            </div>
        </div>
    </div>


</div>