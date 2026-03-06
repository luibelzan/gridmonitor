<div class="col">
    <div class="card text-white  mb-0 h-full"
        style="
                                                    background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
        <h1 class="text-center text-2xl" style="color: white;">
            % USO
        </h1>
        <div
            style="border-bottom: 3px solid transparent;
                                                        border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38))1 ;">
        </div>
        <h2 class="text-center text-1xl mt-2 mb-2" style="color: white;">
            Capacidad último año
        </h2>
        <div class="table-responsive" style="display: flex; justify-content: center;" class="h-full">
            <!-- Cuadrado para Porcentaje de Uso de
                                                                 Capacidad del Trafo Último Año -->
            @if (count($capacidadUltimoAnio) > 0 && !empty($capacidadUltimoAnio[0]->cap_instalada))
                <div class="grafico-wrapper" style="position: relative; height: 40vh; width: 80vw; overflow: hidden;">
                    {{-- GRAFICO DE BARRAS CAPACIDAD Último Año --}}
                    <canvas id="graficoBarrasCapacidadAnio" class="w-full"></canvas>
                    <script>
                        setTimeout(() => {

                            var labels_capacidad_anio = [];
                            var values_capacidad_anio = [];

                            @foreach ($capacidadUltimoAnio as $resultado)
                                var date = new Date('{{ $resultado->date_trunc_anio }}');
                                var month = date.toLocaleString('default', { month: 'short' });
                                var year = date.getFullYear();
                                labels_capacidad_anio.push(month + '-' + year);
                                values_capacidad_anio.push({{ round($resultado->cap_instalada) }});
                            @endforeach

                            values_capacidad_anio.push(100);

                            var maxValue = Math.max(...values_capacidad_anio) * 1.1;

                            var ctx = document.getElementById('graficoBarrasCapacidadAnio').getContext('2d');

                            // Destruir gráfico anterior si existe
                            if (window.graficoCapacidadUltimoAnio) {
                                window.graficoCapacidadUltimoAnio.destroy();
                            }

                            window.graficoCapacidadUltimoAnio = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels_capacidad_anio,
                                    datasets: [{
                                        label: ' ',
                                        backgroundColor: function (context) {
                                            var chartHeight = context.chart.height;
                                            var gradientStartY = chartHeight * 0.25;
                                            var gradient = context.chart.ctx.createLinearGradient(0, gradientStartY, 0, chartHeight);
                                            gradient.addColorStop(0, 'rgba(88, 226, 194, 0.9)');
                                            gradient.addColorStop(0.7, 'rgba(27,32,38, 0.7)');
                                            gradient.addColorStop(1, 'rgba(27,32,38, 0)');
                                            return gradient;
                                        },
                                        borderColor: 'rgba(88, 226, 194, 0.9)',
                                        borderWidth: 1,
                                        data: values_capacidad_anio
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    // TUS OPCIONES...
                                },
                                plugins: [ChartDataLabels]
                            });

                        }, 10);
                    </script>


                </div>
            @else
                <div class="p-0 #205E86 text-white rounded-lg shadow-xl">
                    <p class="mt-0 text-xl font-bold text-center" style="color:rgb(232,80,107)">
                        No hay datos
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>