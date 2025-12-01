<div id="segundaFila"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0">
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                    Promedio Fase S
                                                </h2>
                                                @if (is_array($promedioFase) && count($promedioFase) > 0)
                                                    <div id="graficoVoltajeProm2" class="h-40"
                                                        data-avg="{{ $promedioFase[0]->prom_volt2 ?? 0 }}"
                                                        data-min="{{ $promedioFase[0]->min_volt2 ?? 0 }}"
                                                        data-max="{{ $promedioFase[0]->max_volt_2 ?? 0 }}">
                                                    </div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center" style="color:rgba(88,226,194, 0.9)">No
                                                            hay
                                                            datos</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS CELESTE --}}
                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (isset($tensiones[0]) == null)
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center" style="color:rgba(88,226,194, 0.9)">No hay
                                                        datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntosNaranja"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoLineaVoltaje2" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- ELEMENTO DERECHO MAX MIN CELESTE --}}
                                        <div class="card text-white mb-3 col-span-1 w-full"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-col items-center justify-center">
                                                    <div class="max-min-item text-white rounded-lg shadow-xl mb-2 p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($promedioFase[0]->max_volt_2) ? $promedioFase[0]->max_volt_2 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($promedioFase[0]->min_volt2) ? $promedioFase[0]->min_volt2 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SCRIPTS PARA EL GRÁFICO GAUGE 2 --}}
                                    <script>
                                        var myChart2; // Variable para almacenar el objeto Chart
                                        var prom_volt2_data = {
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->prom_volt2))
                                                data: {{ $promedioFase[0]->prom_volt2 }},
                                            @else
                                                data: '0',
                                            @endif
                                        };
                                        // Función para actualizar el gráfico de pastel con nuevos datos
                                        function updateChartVoltajeProm2(data) {
                                            var color; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                color = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                color = "rgba(39,47,58, 0.9)"; // Si es mayor o igual a 80, color original
                                            }
                                            var colorTexto; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                colorTexto = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                colorTexto = "linear-gradient(to bottom, rgba(88,226,194, 0.9), rgba(0, 0, 0, 0.9))";
                                            }
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->max_volt_2)) // Valor máximo del gráfico
                                                var maxVolt2 = {{ $promedioFase[0]->max_volt_2 }};
                                            @else
                                                var maxVolt2 = 100; // Valor predeterminado si no hay datos
                                            @endif
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->min_volt2)) // Valor mínimo del gráfico
                                                var minVolt2 = {{ $promedioFase[0]->min_volt2 }};
                                            @else
                                                var minVolt2 = 0; // Valor predeterminado si no hay datos
                                            @endif
                                            var newData = [{
                                                type: "indicator",
                                                mode: "gauge",
                                                value: data.data,
                                                title: {
                                                    // text: "",
                                                    font: {
                                                        size: 20,
                                                        color: 'white' // Letras blancas
                                                    }
                                                },
                                                gauge: {
                                                    axis: {
                                                        range: [minVolt2, maxVolt2], // Utiliza el valor mínimo y máximo
                                                        tickwidth: 1,
                                                        tickcolor: "rgb(88,226,194)",
                                                        linecolor: "rgb(88,226,194)" // Línea central verde
                                                    },
                                                    bar: {
                                                        color: "rgba(88,226,194, 0.9)",
                                                        thickness: 0.8 // Ajusta este valor para cambiar el arco
                                                    },
                                                    bgcolor: "transparent", // Cambio del fondo a transparente
                                                    borderwidth: 2,
                                                    bordercolor: "transparent",
                                                    steps: [{
                                                            range: [0, minVolt2], // Cambio de los rangos y colores
                                                            color: color // Color dinámico
                                                        },
                                                        {
                                                            range: [minVolt2, maxVolt2],
                                                            color: "rgba(27,32,38, 0.5)" // Nuevo color en la mitad del gradiente
                                                        }
                                                    ],
                                                    startangle: 270, // Ajusta este valor para cambiar el ángulo de inicio
                                                },
                                                hoverinfo: data.data,
                                            }];
                                            var layout = {
                                                responsive: true,
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
                                                        color: colorTexto
                                                    }
                                                }],
                                            };
                                            Plotly.react('graficoVoltajeProm2', newData, layout, {
                                                displaylogo: false,
                                                displayModeBar: false
                                            });
                                        }
                                    </script>
                                    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 2 --}}
                                    <script>
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt2 = [];
                                        var values_volt2 = [];
                                        @if ($tensiones && count($tensiones) > 0)
                                            @foreach ($tensiones as $key => $resultado)
                                                @if (isset($resultado->fec_registro) && isset($resultado->hor_registro) && isset($resultado->val_voltaje_2))
                                                    // Agregar la fecha y hora como etiquetas del eje x
                                                    var dateTime = '{{ $resultado->fec_registro }} {{ $resultado->hor_registro }}';
                                                    labels_volt2.push(dateTime);
                                                    // Agregar el valor de 'val_voltaje_2' como valor del eje y
                                                    values_volt2.push({{ $resultado->val_voltaje_2 }});
                                                @endif
                                            @endforeach
                                        @endif
                                        if (labels_volt2.length > 0 && values_volt2.length > 0) {
                                            // Ordenar los datos por fecha y hora
                                            var sortedDataVolt2 = labels_volt2.slice().sort();
                                            // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                            var filteredLabelsVolt2 = [sortedDataVolt2[0]];
                                            for (var i = 1; i < sortedDataVolt2.length; i++) {
                                                if (sortedDataVolt2[i] !== sortedDataVolt2[i - 1]) {
                                                    filteredLabelsVolt2.push(sortedDataVolt2[i]);
                                                }
                                            }
                                            var myChartLineVoltaje2;
                                            // Actualizar el gráfico con las etiquetas filtradas
                                            function updateChartLineVoltaje2(data) {
                                                if (myChartLineVoltaje2) {
                                                    myChartLineVoltaje2.data.labels = data.labels_volt2;
                                                    myChartLineVoltaje2.data.datasets[0].data = data.values_volt2;
                                                    myChartLineVoltaje2.update();
                                                } else {
                                                    var ctx = document.getElementById('graficoLineaVoltaje2').getContext('2d');
                                                    myChartLineVoltaje2 = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: data.labels_volt2,
                                                            datasets: [{
                                                                label: 'Voltaje Fase S.',
                                                                data: data.values_volt2,
                                                                borderColor: 'rgb(88, 226, 194)',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(88,226,194, 0.9)'); // Color inicial con opacidad 0.9
                                                                    gradient.addColorStop(0.3,
                                                                        'rgba(88,226,194, 0.5)'
                                                                    ); // Nuevo color en la mitad del gradiente
                                                                    gradient.addColorStop(1,
                                                                        'rgba(88,226,194, 0)'
                                                                    ); // Color final con opacidad 0 (transparente)
                                                                    return gradient;
                                                                },
                                                                borderWidth: 2,
                                                                pointBackgroundColor: 'rgba(88,226,194, 0.8)',
                                                                pointBorderColor: 'rgb(88,226,194)',
                                                                pointBorderWidth: 1,
                                                                fill: true,
                                                                tension: 0.4,
                                                                pointRadius: 3, // Establecer el radio del punto a 0 para que no se muestren los puntos
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
                                                                    labels: data.labels_volt2.map(label => {
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
                                            updateChartLineVoltaje2({
                                                labels_volt2: filteredLabelsVolt2,
                                                values_volt2: values_volt2
                                            });
                                        } else {
                                            console.log("No hay datos disponibles para mostrar en el gráfico.");
                                        }
                                    </script>