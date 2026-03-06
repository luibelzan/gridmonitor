<style>
.sort-arrow2 {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-right: 2px solid white;
    border-bottom: 2px solid white;
    transform: rotate(45deg);
    transition: transform 0.2s ease;
}

/* Ascendente */
.sort-arrow2.asc {
    transform: rotate(-135deg);
}

/* Descendente */
.sort-arrow2.desc {
    transform: rotate(45deg);
}
</style>


{{-- SEGUNDA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            {{-- 1º cuadro --}}



                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    ESTADÍSTICAS DE LECTURA POR C.T
                                </h1>
                                <div
                                    style="border-bottom: 3px solid transparent;
                                                                      border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
                                </div>
                                <div class="container">
                                    @if (count($resultadosQ9dashboard) > 0)
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
                                            style="max-height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
                                            <table id="testTableEstadisticasCt" class="w-full text-white text-center">
                                                <thead style="border-bottom: 1px solid #ffffff;">
                                                    <tr>
                                                        <th onclick="sortTableEstadisticas(0, this)" class="mt-0 text-xl font-bold text-center" 
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                NOMBRE CT
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(1, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                FECHA LECTURA
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(2, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                LECTURAS S02
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(3, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                % S02
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(4, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                LECTURAS S05
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(5, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                % S05
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(6, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                LECTURAS S04
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>

                                                        <th onclick="sortTableEstadisticas(7, this)" class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px; cursor:pointer;">
                                                            <div class="flex items-center justify-center gap-1">
                                                                % S04
                                                                <span class="sort-arrow2"></span>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                @foreach ($resultadosQ9dashboard as $resultado)

                                                    @php
                                                        $p_s02 = $resultado->porcentaje_s02 ?? 0;
                                                        $p_s05 = $resultado->porcentaje_s05 ?? 0;
                                                        $p_s04 = $resultado->porcentaje_s04 ?? 0;

                                                        // función de color simplificada inline
                                                        $color_s02 = $p_s02 <= 50 ? 'red' : ($p_s02 <= 90 ? 'yellow' : 'rgb(76,218,19)');
                                                        $color_s05 = $p_s05 <= 50 ? 'red' : ($p_s05 <= 90 ? 'yellow' : 'rgb(76,218,19)');
                                                        $color_s04 = $p_s04 <= 50 ? 'red' : ($p_s04 <= 90 ? 'yellow' : 'rgb(76,218,19)');
                                                    @endphp

                                                    <tr class="highlight-row">
                                                        <td class="py-2">
                                                            {{ $resultado->nom_ct ?? 'No hay datos' }}
                                                        </td>

                                                        <td class="py-2">
                                                            {{ $resultado->fec_lectura ?? 'No hay datos' }}
                                                        </td>

                                                        <td class="py-2">
                                                            {{ $resultado->lec_s02_hoy ?? '0' }} /
                                                            {{ $resultado->total_cups_ct ?? '0' }}
                                                        </td>

                                                        <td class="py-2" style="color: {{ $color_s02 }};">
                                                            {{ $p_s02 }} %
                                                        </td>

                                                        <td class="py-2">
                                                            {{ $resultado->lec_s05_hoy ?? '0' }} /
                                                            {{ $resultado->total_cups_ct ?? '0' }}
                                                        </td>

                                                        <td class="py-2" style="color: {{ $color_s05 }};">
                                                            {{ $p_s05 }} %
                                                        </td>

                                                        <td class="py-2">
                                                            {{ $resultado->lec_s04_hoy ?? '0' }} /
                                                            {{ $resultado->total_cups_ct ?? '0' }}
                                                        </td>

                                                        <td class="py-2" style="color: {{ $color_s04 }};">
                                                            {{ $p_s04 }} %
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="rgb(27,32,38) p-4 rounded-lg shadow-xl">
                                            <p class="mt-0 text-xl  text-center" style="color:rgb(88,226,194)">No
                                                hay
                                                datos
                                            </p>
                                        </div>
                                    @endif
                                    <!-- Contenedor del botón de descarga -->
                                    <div class="text-right mt-4">
                                        <input type="button"
                                            onclick="tableToExcel('testTableEstadisticasCt', 'W3C Example Table')"
                                            style="padding: 5px; border: none; border-radius: 5px; cursor: pointer; background-image: url('../../images/excel-icon.png'); background-size: cover; width: 30px; height: 30px;">
                                    </div>
                                </div>
                            </div>
                        </div>