{{-- DESEQUILIBRIOS CORRIENTE --}}
<div class="card text-white mb-3 col-span-1"
    style="background: linear-gradient(to bottom, RGB(27 32 38), RGB(27 32 38));">
    <div class="p-4 h-full flex flex-col justify-center items-center">
        <h1 class="text-white text-center text-md font-normal mb-2 mt-4">
            Desequilibrio Corriente
        </h1>
        @if (is_array($desequilibrios) && count($desequilibrios) > 0)
            <div id="graficoDesequilibrioCorriente" class="h-40"
                data-avg="{{ $desequilibrios[0]->avg_pct_deseq_corriente ?? 0 }}"
                data-min="{{ $desequilibrios[0]->min_pct_deseq_correinte ?? 0 }}"
                data-max="{{ $desequilibrios[0]->max_pct_deseq_corriente ?? 0 }}">
            </div>
        @else
            <div class="p-4 h-full flex flex-col justify-center items-center">
                <p class="text-center text-yellow-500">No hay datos</p>
            </div>
        @endif
    </div>


    <div class="p-4 h-full flex flex-row justify-center items-center">
        <div id="cuadrosNaranjas" class="flex flex-row items-center justify-center space-x-4">

            <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                <h2 class="text-sm font-normal mb-1 text-center">Mín</h2>
                <p class="text-xl font-bold text-center">
                    {{ !empty($desequilibrios[0]->min_pct_deseq_corriente) ? $desequilibrios[0]->min_pct_deseq_corriente : '0' }}%
                </p>
            </div>
            <div class="max-min-item text-white rounded-lg shadow-xl p-4"
                style="background: linear-gradient(135deg, rgba(88,226,194, 0.9), rgb(56, 125, 109)); width: 100%; box-sizing: border-box;">
                <h2 class="text-sm font-normal mb-1 text-center">Máx</h2>
                <p class="text-xl font-bold text-center">
                    {{ !empty($desequilibrios[0]->max_pct_deseq_corriente) ? $desequilibrios[0]->max_pct_deseq_corriente : '0' }}%
                </p>
            </div>
        </div>
    </div>


</div>