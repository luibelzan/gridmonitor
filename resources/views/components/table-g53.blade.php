<div class="rgb(27,32,38) p-4 rounded-lg shadow-xl"
    style="max-height: 400px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 rgb(27,32,38);">
    <div class="mb-4"
        style="border-bottom: 3px solid transparent;
                border-image: linear-gradient(to right, rgb(27,32,38), rgb(42,50,62),rgb(27,32,38)) 1;">
    </div>
    <table id="tabla-eventos" class="w-full text-white text-center"
        style="border-spacing: 0 5px;">
        <thead style="border-bottom: 1px solid #ffffff;">
            <tr>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">RTU ID</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">LVS ID</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">LVS POS</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">FECHA</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMCPH1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMVPH1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPIMPH1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPEXPH1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMQIMPH1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMQEXPH1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPF1</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMCPH2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMVPH2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPIMPH2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPEXPH2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMQIMPH2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMQEXPH2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPF2</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMCPH3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMVPH3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPIMPH3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPEXPH3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMQIMPH3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMQEXPH3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMPF3</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">MOMCN</th>

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
                    <td colspan="26" class="py-4 text-center text-gray-400">
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
                        {{ !empty($resultado->lvs_id) ? $resultado->lvs_id : 'No hay datos' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->lvs_pos) ? $resultado->lvs_pos : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momCph1) ? $resultado->momCph1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momVph1) ? $resultado->momVph1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPimph1) ? $resultado->momPimph1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->MomPexph1) ? $resultado->MomPexph1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momQimph1) ? $resultado->momQimph1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momQexph1) ? $resultado->momQexph1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPF1) ? $resultado->momPF1 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momCph2) ? $resultado->momCph2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momVph2) ? $resultado->momVph2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPimph2) ? $resultado->momPimph2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPexph2) ? $resultado->momPexph2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momQimph2) ? $resultado->momQimph2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momQexph2) ? $resultado->momQexph2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPF2) ? $resultado->momPF2 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momCph3) ? $resultado->momCph3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momVph3) ? $resultado->momVph3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPimph3) ? $resultado->momPimph3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPexph3) ? $resultado->momPexph3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momQimph3) ? $resultado->momQimph3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momQexph3) ? $resultado->momQexph3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momPF3) ? $resultado->momPF3 : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->momCn) ? $resultado->momCn : '0' }}
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
