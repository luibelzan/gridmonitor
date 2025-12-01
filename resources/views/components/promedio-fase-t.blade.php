<div id="terceraFila"
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-6 gap-0 mb-0 ">
                                        <div class="card text-white mb-3 col-span-1"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <h2 class="text-white text-center text-sm font-normal mb-2 mt-4">
                                                    Promedio Fase T
                                                </h2>
                                                @if (is_array($promedioFase) && count($promedioFase) > 0)
                                                    <div id="graficoVoltajeProm3" class="h-40"
                                                        data-avg="{{ $promedioFase[0]->prom_volt3 ?? 0 }}"
                                                        data-min="{{ $promedioFase[0]->min_volt3 ?? 0 }}"
                                                        data-max="{{ $promedioFase[0]->max_volt_3 ?? 0 }}">
                                                    </div>
                                                @else
                                                    <div class="p-4 h-full flex flex-col justify-center items-center">
                                                        <p class="text-center" style="color: rgba(44, 131, 174, 0.9)">
                                                            No hay datos</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- ELEMENTO CENTRAL GRAFICO DE PUNTOS AZUL --}}
                                        <div class="card text-white mb-3 col-span-4"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">

                                            @if (isset($tensiones[0]) == null)
                                                <div class="p-4 h-full flex flex-col justify-center items-center">
                                                    <p class="text-center" style="color: rgba(44, 131, 174, 0.9)">No
                                                        hay datos</p>
                                                </div>
                                            @else
                                                <div class="table-responsive w-full"
                                                    style="display: flex; justify-content: center;">
                                                    <div id="graficoPuntosNaranja"
                                                        style="position: relative; height: 30vh; width: 80vw; overflow: hidden;">
                                                        <canvas id="graficoLineaVoltaje3" class="w-full"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div> 

                                        {{-- ELEMENTO DERECHO MAX MIN AZUL --}}
                                        <div class="card text-white mb-3 col-span-1 w-full"
                                            style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                            <div class="p-4 h-full flex flex-col justify-center items-center">
                                                <div id="cuadrosNaranjas"
                                                    class="flex flex-col items-center justify-center">
                                                    <div class="max-min-item text-white rounded-lg shadow-xl mb-2 p-4"
                                                        style="background: linear-gradient(135deg, rgba(44, 131, 174, 0.9), #133B5C); text-align: center; width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($promedioFase[0]->max_volt_3) ? $promedioFase[0]->max_volt_3 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                    <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                                                        style="background: linear-gradient(135deg, rgba(44, 131, 174, 0.9), #133B5C); text-align: center; width: 100%; box-sizing: border-box;">
                                                        <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                                                        <p class="text-xl font-bold text-center">
                                                            {{ !empty($promedioFase[0]->min_volt3) ? $promedioFase[0]->min_volt3 : '0' }}
                                                            V
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SCRIPTS PARA EL GRÁFICO GAUGE 3 --}}
                                    <script>
                                        var myChart3; // Variable para almacenar el objeto Chart
                                        var prom_volt3_data = {
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->prom_volt3))
                                                data: {{ $promedioFase[0]->prom_volt3 }},
                                            @else
                                                data: '0',
                                            @endif
                                        };
                                        // Función para actualizar el gráfico de pastel con nuevos datos
                                        function updateChartVoltajeProm3(data) {
                                            var color; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                color = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                color = "rgba(44, 131, 174, 0.9)"; // Si es mayor o igual a 80, color original
                                            }
                                            var colorTexto; // Variable para almacenar el color
                                            // Verificar el valor de data.data y asignar el color correspondiente
                                            if (data.data < 80) {
                                                colorTexto = "rgba(232,80,107, 0.9)"; // Si es menor a 80, color rojo
                                            } else {
                                                colorTexto = "linear-gradient(to bottom, rgba(44, 131, 174, 0.9), rgba(0, 0, 0, 0.9))";
                                            }
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->max_volt_3)) // Valor máximo del gráfico
                                                var maxVolt3 = {{ $promedioFase[0]->max_volt_3 }};
                                            @else
                                                var maxVolt3 = 100; // Valor predeterminado si no hay datos
                                            @endif
                                            @if (is_array($promedioFase) && count($promedioFase) > 0 && !empty($promedioFase[0]->min_volt3)) // Valor mínimo del gráfico
                                                var minVolt3 = {{ $promedioFase[0]->min_volt3 }};
                                            @else
                                                var minVolt3 = 0; // Valor predeterminado si no hay datos
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
                                                        range: [minVolt3, maxVolt3], // Utiliza el valor mínimo y máximo
                                                        tickwidth: 1,
                                                        tickcolor: "RGB(44, 131, 174)",
                                                        linecolor: "RGB(44, 131, 174)" // Línea central verde
                                                    },
                                                    bar: {
                                                        color: "rgba(44, 131, 174, 0.9)",
                                                        thickness: 0.8 // Ajusta este valor para cambiar el arco
                                                    },
                                                    bgcolor: "transparent", // Cambio del fondo a transparente
                                                    borderwidth: 2,
                                                    bordercolor: "transparent",
                                                    steps: [{
                                                            range: [0, minVolt3], // Cambio de los rangos y colores
                                                            color: color // Color dinámico
                                                        },
                                                        {
                                                            range: [minVolt3, maxVolt3],
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
                                            Plotly.react('graficoVoltajeProm3', newData, layout, {
                                                displaylogo: false,
                                                displayModeBar: false
                                            });
                                        }
                                    </script>
                                    {{-- SCRIPTS PARA EL GRÁFICO VOLTAJE 3 --}}
                                    <script>
                                        // Transformar los datos para el gráfico de línea
                                        var labels_volt3 = [];
                                        var values_volt3 = [];
                                        @if ($tensiones && count($tensiones) > 0)
                                            @foreach ($tensiones as $key => $resultado)
                                                @if (isset($resultado->fec_registro) && isset($resultado->hor_registro) && isset($resultado->val_voltaje_3))
                                                    // Agregar la fecha y hora como etiquetas del eje x
                                                    var dateTime = '{{ $resultado->fec_registro }} {{ $resultado->hor_registro }}';
                                                    labels_volt3.push(dateTime);
                                                    // Agregar el valor de 'val_voltaje_3' como valor del eje y
                                                    values_volt3.push({{ $resultado->val_voltaje_3 }});
                                                @endif
                                            @endforeach
                                        @endif
                                        if (labels_volt3.length > 0 && values_volt3.length > 0) {
                                            // Ordenar los datos por fecha y hora
                                            var sortedDataVolt3 = labels_volt3.slice().sort();
                                            // Filtrar las etiquetas para evitar repeticiones consecutivas de fechas y horas
                                            var filteredLabelsVolt3 = [sortedDataVolt3[0]];
                                            for (var i = 1; i < sortedDataVolt3.length; i++) {
                                                if (sortedDataVolt3[i] !== sortedDataVolt3[i - 1]) {
                                                    filteredLabelsVolt3.push(sortedDataVolt3[i]);
                                                }
                                            }
                                            var myChartLineVoltaje3;
                                            // Actualizar el gráfico con las etiquetas filtradas
                                            function updateChartLineVoltaje3(data) {
                                                if (myChartLineVoltaje3) {
                                                    myChartLineVoltaje3.data.labels = data.labels_volt3;
                                                    myChartLineVoltaje3.data.datasets[0].data = data.values_volt3;
                                                    myChartLineVoltaje3.update();
                                                } else {
                                                    var ctx = document.getElementById('graficoLineaVoltaje3').getContext('2d');
                                                    myChartLineVoltaje3 = new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: data.labels_volt3,
                                                            datasets: [{
                                                                label: 'Voltaje Fase T.',
                                                                data: data.values_volt3,
                                                                borderColor: 'rgb(44, 131, 174)',
                                                                backgroundColor: function(context) {
                                                                    var gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                                                                    gradient.addColorStop(0,
                                                                        'rgba(44, 131, 174, 0.9)'); // Color inicial con opacidad 0.9
                                                                    gradient.addColorStop(0.3,
                                                                        'rgba(44, 131, 174, 0.5)'
                                                                    ); // Nuevo color en la mitad del gradiente
                                                                    gradient.addColorStop(1,
                                                                        'rgba(44, 131, 174, 0)'
                                                                    ); // Color final con opacidad 0 (transparente)
                                                                    return gradient;
                                                                },
                                                                borderWidth: 2,
                                                                pointBackgroundColor: 'rgba(44, 131, 174, 0.8)',
                                                                pointBorderColor: 'rgba(44, 131, 174, 0.5)',
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
                                                                    labels: data.labels_volt3.map(label => {
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
                                                                        min: 100, // Valor mínimo en el eje y
                                                                        max: 300, // Valor máximo en el eje y
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
                                            updateChartLineVoltaje3({
                                                labels_volt3: filteredLabelsVolt3,
                                                values_volt3: values_volt3
                                            });
                                        } else {
                                            console.log("No hay datos disponibles para mostrar en el gráfico.");
                                        }
                                    </script>