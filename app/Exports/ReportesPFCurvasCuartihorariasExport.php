<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithEvents; 
use Maatwebsite\Excel\Events\BeforeWriting; // Importa los eventos que usarás
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Para logging dentro del exportador
use App\Models\ExportProgress; // Para actualizar el modelo de progreso
use Maatwebsite\Excel\Events\AfterBatch;


class ReportesPFCurvasCuartihorariasExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue, WithCustomChunkSize, WithEvents // ¡Añadimos WithEvents!
{
    protected $id_cnts;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $fileName;
    protected $dbConnectionName;
    protected $exportId; // ¡Nuevo! Necesitamos el ID de la exportación
    protected $processedChunks = 0; // Contador de chunks procesados
    protected $maxEstimatedChunks = 20; // ¡Ajusta este valor!

    public function __construct($id_cnts, $fecha_inicio, $fecha_fin, $fileName, $dbConnectionName, $exportId) // ¡Añadimos $exportId al constructor!
    {
        $this->id_cnts = $id_cnts;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->fileName = $fileName;
        $this->dbConnectionName = $dbConnectionName;
        $this->exportId = $exportId; // Asignamos el ID
    }

    public function query()
{
    return DB::connection($this->dbConnectionName)
        ->table('t_dat_iec870_load_profile_2')
        ->join('t_meter_params_iec870', 't_dat_iec870_load_profile_2.id_cnt', '=', 't_meter_params_iec870.id_cnt')
        ->whereIn('t_dat_iec870_load_profile_2.id_cnt', $this->id_cnts)
        ->when($this->fecha_inicio && $this->fecha_fin, function ($q) {
            $q->whereBetween('t_dat_iec870_load_profile_2.fh', [$this->fecha_inicio, $this->fecha_fin]);
        })
        ->selectRaw("
            t_meter_params_iec870.id_cups AS cups,
            t_dat_iec870_load_profile_2.id_cnt,
            TO_CHAR(t_dat_iec870_load_profile_2.fh, 'DD/MM/YYYY') AS fecha,
            TO_CHAR(t_dat_iec870_load_profile_2.fh, 'HH24:MI:SS') AS hora,
            t_dat_iec870_load_profile_2.ai AS energia_activa_importada_a,
            t_dat_iec870_load_profile_2.ai_bc AS bit_calidad_activa_a,
            t_dat_iec870_load_profile_2.ae AS energia_activa_exportada_a,
            t_dat_iec870_load_profile_2.ae_bc AS bit_calidad_activa_a2,
            t_dat_iec870_load_profile_2.r1 AS energia_reactiva_inductiva_importada_ri,
            t_dat_iec870_load_profile_2.r1_bc AS bit_calidad_reactiva_imp_ri,
            t_dat_iec870_load_profile_2.r2 AS energia_reactiva_inductiva_exportada_ri,
            t_dat_iec870_load_profile_2.r2_bc AS bit_calidad_reactiva_imp_ri2,
            t_dat_iec870_load_profile_2.r3 AS energia_reactiva_capacitiva_importada_rc,
            t_dat_iec870_load_profile_2.r3_bc AS bit_calidad_reactiva_imp_rc,
            t_dat_iec870_load_profile_2.r4 AS energia_reactiva_capacitiva_exportada_rc,
            t_dat_iec870_load_profile_2.r4_bc AS bit_calidad_reactiva_exp_rc
        ");
}


    public function map($row): array
    {
        return [
            $row->cups ?? '',
            $row->id_cnt ?? '',
            $row->fecha ?? '',
            $row->hora ?? '',
            strval($row->energia_activa_importada_a ?? '0'),
            strval($row->bit_calidad_activa_a ?? '0'),
            strval($row->energia_activa_exportada_a ?? '0'),
            strval($row->bit_calidad_activa_a2 ?? '0'),
            strval($row->energia_reactiva_inductiva_importada_ri ?? '0'),
            strval($row->bit_calidad_reactiva_imp_ri ?? '0'),
            strval($row->energia_reactiva_inductiva_exportada_ri ?? '0'),
            strval($row->bit_calidad_reactiva_imp_ri2 ?? '0'),
            strval($row->energia_reactiva_capacitiva_importada_rc ?? '0'),
            strval($row->bit_calidad_reactiva_imp_rc ?? '0'),
            strval($row->energia_reactiva_capacitiva_exportada_rc ?? '0'),
            strval($row->bit_calidad_reactiva_exp_rc ?? '0'),
        ];
    }

    public function headings(): array
    {
        return [
            'CUPS',
            'ID CNT',
            'Fecha',
            'Hora',
            'Energía Activa Importada A',
            'Bit Calidad Activa A',
            'Energía Activa Exportada A',
            'Bit Calidad Activa A2',
            'Energía Reactiva Inductiva Importada Ri',
            'Bit Calidad Reactiva Imp Ri',
            'Energía Reactiva Inductiva Exportada Ri',
            'Bit Calidad Reactiva Imp Ri2',
            'Energía Reactiva Capacitiva Importada Rc',
            'Bit Calidad Reactiva Imp Rc',
            'Energía Reactiva Capacitiva Exportada Rc',
            'Bit Calidad Reactiva Exp Rc',
        ];
    }

    public function chunkSize(): int
    {
        return 5000;
    }

 
    public function registerEvents(): array
    {
        return [
            AfterBatch::class => function(AfterBatch $event) {
                $this->processedChunks++; // Incrementa el contador de chunks

                // Calculamos el progreso basándonos en los chunks procesados.
                // Asignamos el rango 20% - 89% a la lectura y procesamiento de los chunks.
                $baseProgress = 20; // Inicio del rango de progreso para chunks
                $rangeSize = 69;   // 89 - 20 = 69% del total para los chunks

                $progress = $baseProgress;
                if ($this->maxEstimatedChunks > 0) {
                    $progress = $baseProgress + (int)(($this->processedChunks / $this->maxEstimatedChunks) * $rangeSize);
                }

                // Aseguramos que el progreso no exceda el 89% en esta fase
                $progress = min(89, $progress);

                ExportProgress::on('pgsql-exports')->where('export_id', $this->exportId)->update([
                    'progress' => $progress,
                ]);
                Log::info("Exportador: AfterBatch event para export_id: {$this->exportId}. Chunks procesados: {$this->processedChunks}. Progreso: {$progress}%");
            },

            BeforeWriting::class => function(BeforeWriting $event) {
                Log::info("Exportador: Evento BeforeWriting para export_id: " . $this->exportId);
                ExportProgress::on('pgsql-exports')->where('export_id', $this->exportId)->update([
                    'progress' => 90, // El 90% indica que la escritura final del archivo está a punto de comenzar
                ]);
            },
        ];
    }
}