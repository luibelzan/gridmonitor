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
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">FH</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">NR</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">NS</th>
                <th class="text-xl font-bold text-center" style="color:rgb(88,226,194); padding: 10px;">NT</th>
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
                    <td colspan="6" class="py-4 text-center text-gray-400">
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
                        {{ !empty($resultado->fh) ? $resultado->fh : 'No hay datos' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->nr) ? $resultado->nr : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->ns) ? $resultado->ns : '0' }}
                    </td>
                    <td class="py-2" style="padding: 10px;">
                        {{ !empty($resultado->nt) ? $resultado->nt : '0' }}
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
