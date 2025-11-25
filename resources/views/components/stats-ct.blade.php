{{-- SEGUNDA FILA --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            {{-- 1º cuadro --}}



                            <div class="card text-white  mb-2"
                                style="
                                        background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
                                <h1 class="text-center text-2xl" style="color: white;">
                                    ESTADÍSTICAS POR C.T
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
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            NOMBRE CT</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            FECHA LECTURA</th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            LECTURAS S02 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            % S02 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            LECTURAS S05 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            % S05 </th>
                                                        <th class="mt-0 text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            LECTURAS S04 </th>
                                                        <th class="mt-0  text-xl font-bold text-center"
                                                            style="color:rgb(88,226,194); padding: 10px">
                                                            % S04</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($resultadosQ9dashboard as $resultado)
                                                        <tr class="highlight-row ">
                                                            <td class="py-2">
                                                                {{ !empty($resultado->nom_ct) ? $resultado->nom_ct : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->fec_lectura) ? $resultado->fec_lectura : 'No hay datos' }}
                                                            </td>
                                                            <td class="py-2">                                                                
                                                                {{ !empty($resultado->lec_s02_hoy) ? $resultado->lec_s02_hoy : '0' }}
                                                                /
                                                                {{ !empty($resultado->total_cups_ct) ? $resultado->total_cups_ct : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->porcentaje_s02) ? $resultado->porcentaje_s02 : '0' }}
                                                                %
                                                            </td>
                                                            <td class="py-2">                                                                
                                                                {{ !empty($resultado->lec_s05_hoy) ? $resultado->lec_s05_hoy : '0' }}
                                                                /
                                                                {{ !empty($resultado->total_cups_ct) ? $resultado->total_cups_ct : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->porcentaje_s05) ? $resultado->porcentaje_s05 : '0' }}
                                                                %
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->lec_s04_hoy) ? $resultado->lec_s04_hoy : '0' }}
                                                                /
                                                                {{ !empty($resultado->total_cups_ct) ? $resultado->total_cups_ct : '0' }}
                                                            </td>
                                                            <td class="py-2">
                                                                {{ !empty($resultado->porcentaje_s04) ? $resultado->porcentaje_s04 : '0' }}
                                                                %
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