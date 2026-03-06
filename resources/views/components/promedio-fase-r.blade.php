{{-- comopnet.promedio-fase-r --}}
<div id="primeraFila"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0">
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                    Promedio Fase R
                                                </h2>
                                                @if (is_array($promedioFase) && count($promedioFase) > 0)
                                                    <div id="graficoVoltajeProm1"
                                                        class="h-40"
                                                        data-avg="{{ $promedioFase[0]->prom_volt1 ?? 0 }}"
                                                        data-min="{{ $promedioFase[0]->min_volt1 ?? 0 }}"
                                                        data-max="{{ $promedioFase[0]->max_volt_1 ?? 0 }}">
                                                    </div>

                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center text-yellow-500">No hay datos</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS NARANJA --}}
                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (isset($tensiones[0]) == null)
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center text-yellow-500">No hay datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntosNaranja"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoLineaVoltaje1" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- ELEMENTO DERECHO MAX MIN NARANJA --}}
                                        <div class="card text-white mb-3 col-span-1 w-full"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-col items-center justify-center">
                                                    <div class="max-min-item bg-gradient-to-br from-yellow-500 to-yellow-700 text-white rounded-lg shadow-xl mb-2 p-4"
                                                        style="width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($promedioFase[0]->max_volt_1) ? $promedioFase[0]->max_volt_1 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item bg-gradient-to-br from-yellow-500 to-yellow-700 text-white rounded-lg shadow-xl p-4"
                                                        style="width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($promedioFase[0]->min_volt1) ? $promedioFase[0]->min_volt1 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SCRIPTS PARA EL GRÁFICO GAUGE 1 --}}
                                    <script>
                                        var myChart; // Variable para almacenar el objeto Chart
                                        var prom_volt1_data = {
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->prom_volt1))
                                                data: {{ $promedioFase[0]->prom_volt1 }},
                                            @else
                                                data: '0',
                                            @endif
                                        };
                                        // Función para actualizar el gráfico de pastel con nuevos datos
                                        function updateChartVoltajeProm1(data) {
                                            // Función para determinar el color basado en los datos
                                            function getColor(value) {
                                                return value < 80 ? "rgba(232,80,107, 0.9)" : "rgba(39,47,58, 0.9)";
                                            }
                                            // Variables para el color y color de texto
                                            var color = getColor(data.data);
                                            var textColor = getColor(data.data) === "rgba(232,80,107, 0.9)" ? "rgba(232,80,107, 0.9)" :
                                                "rgb(238,145,4)";
                                            // Valores máximo y mínimo del gráfico
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->max_volt_1))
                                                var maxVolt1 = {{ $promedioFase[0]->max_volt_1 }};
                                            @else
                                                var maxVolt1 = 100; // Valor predeterminado si no hay datos
                                            @endif
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->min_volt1))
                                                var minVolt1 = {{ $promedioFase[0]->min_volt1 }};
                                            @else
                                                var minVolt1 = 0; // Valor predeterminado si no hay datos
                                            @endif
                                            // Configuración de nuevos datos y diseño del gráfico
                                            var newData = [{
                                                type: "indicator",
                                                mode: "gauge",
                                                value: data.data,
                                                title: {
                                                    font: {
                                                        size: 20,
                                                        color: 'white' // Letras blancas
                                                    }
                                                },
                                                gauge: {
                                                    axis: {
                                                        range: [minVolt1, maxVolt1],
                                                        tickwidth: 1,
                                                        tickcolor: "rgb(238,145,4)",
                                                        linecolor: "rgb(238,145,4) "
                                                    },
                                                    bar: {
                                                        color: "rgb(238,145,4)",
                                                        thickness: 0.8
                                                    },
                                                    bgcolor: "transparent",
                                                    borderwidth: 2,
                                                    bordercolor: "transparent",
                                                    steps: [{
                                                            range: [0, minVolt1],
                                                            color: color
                                                        },
                                                        {
                                                            range: [minVolt1, maxVolt1],
                                                            color: "rgba(27,32,38, 0.5)"
                                                        }
                                                    ],
                                                    startangle: 270,
                                                },
                                                hoverinfo: data.data,
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
                                                    text: data.data + ' V',
                                                    x: 0.5,
                                                    y: 0.4,
                                                    showarrow: false,
                                                    font: {
                                                        size: 20,
                                                        color: textColor
                                                    }
                                                }],
                                            };
                                            // Actualizar el gráfico
                                            Plotly.react('graficoVoltajeProm1', newData, layout, {
                                                displaylogo: false,
                                                displayModeBar: false
                                            });
                                        }
                                    </script>
                                    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 1 --}}
                                    <script>
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt1 = [];
                                        var values_volt1 = [];
                                        @if ($tensiones && count($tensiones) > 0)
                                            @foreach ($tensiones as $key => $resultado)
                                                @if (isset($resultado->fec_registro) && isset($resultado->hor_registro) && isset($resultado->val_voltaje_1))
                                                    // Verificar que fec_registro, hor_registro y val_voltaje_1 estén definidos y no sean nulos o cadenas vacías
                                                    var dateTime = '{{ $resultado->fec_registro }} {{ $resultado->hor_registro }}';
                                                    labels_volt1.push(dateTime);
                                                    values_volt1.push({{ $resultado->val_voltaje_1 }});
                                                @endif
                                            @endforeach
                                        @endif
                                        if (labels_volt1.length > 0 && values_volt1.length > 0) {
                                            // Ordenar los datos por fecha y hora
                                            var sortedData = labels_volt1.slice().sort();
                                            // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                            var filteredLabels = [sortedData[0]];
                                            for (var i = 1; i < sortedData.length; i++) {
                                                if (sortedData[i] !== sortedData[i - 1]) {
                                                    filteredLabels.push(sortedData[i]);
                                                }
                                            }
                                            var myChartLineVoltaje1;
                                            // Actualiza el gráfico con las etiquetas filtradas
                                            function updateChartLineVoltaje1(data) {
                                                if (myChartLineVoltaje1) {
                                                    myChartLineVoltaje1.data.labels = data.labels_volt1;
                                                    myChartLineVoltaje1.data.datasets[0].data = data.values_volt1;
                                                    myChartLineVoltaje1.update();
                                                } else {
                                                    var ctx = document.getElementById('graficoLineaVoltaje1').getContext('2d');
                                                    myChartLineVoltaje1 = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: data.labels_volt1,
                                                            datasets: [{
                                                                label: 'Voltaje Fase R.',
                                                                data: data.values_volt1,
                                                                borderColor: 'rgb(238,145,4)',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(238,145,4, 0.9)'); // Color inicial con opacidad 0.9
                                                                    gradient.addColorStop(0.3,
                                                                        'rgba(238,145,4, 0.5)'
                                                                    ); // Nuevo color en la mitad del gradiente
                                                                    gradient.addColorStop(1,
                                                                        'rgba(238,145,4, 0)'
                                                                    ); // Color final con opacidad 0 (transparente)
                                                                    return gradient;
                                                                },
                                                                borderWidth: 2,
                                                                pointBackgroundColor: 'rgb(238,145,4)',
                                                                pointBorderColor: 'rgba(238,145,4, 0.5)',
                                                                pointBorderWidth: 1,
                                                                fill: true,
                                                                tension: 0.4,
                                                                pointRadius: 3,
                                                            }]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            plugins: {
                                                                legend: {
                                                                    position: 'bottom', // Mueve la leyenda a la parte inferior
                                                                    labels: {
                                                                        color: 'white',
                                                                        font: {
                                                                            family: 'Didact Gothic',
                                                                            weight: 'normal'
                                                                        }
                                                                    }
                                                                },
                                                                tooltip: {
                                                                    callbacks: {
                                                                        title: function(tooltipItems, data) {
                                                                            var tooltipTitle = '';
                                                                            if (tooltipItems.length > 0) {
                                                                                var label = tooltipItems[0].label;
                                                                                tooltipTitle = label;
                                                                            }
                                                                            return tooltipTitle;
                                                                        },
                                                                        label: function(context) {
                                                                            var label = '';
                                                                            if (context.parsed.y !== null) {
                                                                                label += context.parsed.y + ' V';
                                                                            }
                                                                            return label;
                                                                        }
                                                                    },
                                                                    titleFont: {
                                                                        family: 'Didact Gothic',
                                                                        weight: 'normal'
                                                                    },
                                                                    bodyFont: {
                                                                        family: 'Didact Gothic',
                                                                        weight: 'normal'
                                                                    }
                                                                }
                                                            },
                                                            scales: {
                                                                x: {
                                                                    type: 'category',
                                                                    labels: data.labels_volt1.map(label => {
                                                                        // Eliminar los segundos de cada etiqueta
                                                                        const timeWithoutSeconds = label.replace(/\:\d\d$/, 'h');
                                                                        return timeWithoutSeconds;
                                                                    }).sort(), // Utilizar las cadenas de fecha sin formato
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        stepSize: 2 // Establecer el tamaño del paso entre los valores en el eje y    
                                                                    }
                                                                },
                                                                y: {
                                                                    display: true, // Mostrar el eje y
                                                                    beginAtZero: true,
                                                                    grid: {
                                                                        color: 'rgb(50, 50, 50)'
                                                                    },
                                                                    ticks: {
                                                                        color: '#FFFFFF',
                                                                        // min: 0, // Valor mínimo en el eje y
                                                                        // max: 300, // Valor máximo en el eje y
                                                                        stepSize: 100, // Espaciado entre cada valor
                                                                        callback: function(value, index, values) {
                                                                            // Devolver solo los valores que deseas mostrar
                                                                            return [0, 100, 200, 300].includes(value) ? value + ' V' : '';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                            updateChartLineVoltaje1({
                                                labels_volt1: filteredLabels,
                                                values_volt1: values_volt1
                                            });
                                        } else {
                                            console.log("No hay datos disponibles para mostrar en el gráfico.");
                                        }
                                    </script>