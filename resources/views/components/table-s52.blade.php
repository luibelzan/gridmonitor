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
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">LVS MAGN</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">FECHA</th>
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
                        {{ !empty($resultado->rtu_id) ? $resultado->rtu_id : 'No hay datos' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->lvs_id) ? $resultado->lvs_id : 'No hay datos' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->lvs_pos) ? $resultado->lvs_pos : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->lvs_magn) ? $resultado->lvs_magn : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->fec_inicio) ? $resultado->fec_inicio : 'No hay datos' }}
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
