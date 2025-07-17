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
        return DB::connection($this->dbConnectionName)->table('t_dat_iec870_load_profile_1')
            ->join('t_meter_params_iec870', 't_dat_iec870_load_profile_1.id_cnt', '=', 't_meter_params_iec870.id_cnt')
            ->whereIn('t_dat_iec870_load_profile_1.id_cnt', $this->id_cnts)
            ->when($this->fecha_inicio && $this->fecha_fin, function ($q) {
                $q->whereBetween('t_dat_iec870_load_profile_1.fh', [$this->fecha_inicio, $this->fecha_fin]);
            })
            ->selectRaw("
                t_meter_params_iec870.cups as CUPS,
                t_dat_iec870_load_profile_1.id_cnt,
                DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%d/%m/%Y') as Fecha,
                DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%H:%i:%s') as Hora,
                t_dat_iec870_load_profile_1.e_act_imp as Energia_Activa_Importada_A,
                t_dat_iec870_load_profile_1.e_act_imp_cualif as Bit_Calidad_Activa_A,
                t_dat_iec870_load_profile_1.e_act_exp as Energia_Activa_Exportada_A,
                t_dat_iec870_load_profile_1.e_act_exp_cualif as Bit_Calidad_Activa_A2,
                t_dat_iec870_load_profile_1.e_react_ind_imp as Energia_Reactiva_Inductiva_Importada_Ri,
                t_dat_iec870_load_profile_1.e_react_ind_imp_cualif as Bit_Calidad_Reactiva_Imp_Ri,
                t_dat_iec870_load_profile_1.e_react_ind_exp as Energia_Reactiva_Inductiva_Exportada_Ri,
                t_dat_iec870_load_profile_1.e_react_ind_exp_cualif as Bit_Calidad_Reactiva_Imp_Ri2,
                t_dat_iec870_load_profile_1.e_react_cap_imp as Energia_Reactiva_Capacitiva_Importada_Rc,
                t_dat_iec870_load_profile_1.e_react_cap_imp_cualif as Bit_Calidad_Reactiva_Imp_Rc,
                t_dat_iec870_load_profile_1.e_react_cap_exp as Energia_Reactiva_Capacitiva_Exportada_Rc,
                t_dat_iec870_load_profile_1.e_react_cap_exp_cualif as Bit_Calidad_Reactiva_Exp_Rc"
            );
    }

    public function map($row): array
    {
        return [
            $row->CUPS ?? '',
            $row->id_cnt ?? '',
            $row->Fecha ?? '',
            $row->Hora ?? '',
            strval($row->Energia_Activa_Importada_A ?? '0'),
            strval($row->Bit_Calidad_Activa_A ?? '0'),
            strval($row->Energia_Activa_Exportada_A ?? '0'),
            strval($row->Bit_Calidad_Activa_A2 ?? '0'),
            strval($row->Energia_Reactiva_Inductiva_Importada_Ri ?? '0'),
            strval($row->Bit_Calidad_Reactiva_Imp_Ri ?? '0'),
            strval($row->Energia_Reactiva_Inductiva_Exportada_Ri ?? '0'),
            strval($row->Bit_Calidad_Reactiva_Imp_Ri2 ?? '0'),
            strval($row->Energia_Reactiva_Capacitiva_Importada_Rc ?? '0'),
            strval($row->Bit_Calidad_Reactiva_Imp_Rc ?? '0'),
            strval($row->Energia_Reactiva_Capacitiva_Exportada_Rc ?? '0'),
            strval($row->Bit_Calidad_Reactiva_Exp_Rc ?? '0'),
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

                ExportProgress::on('mysql_exports')->where('export_id', $this->exportId)->update([
                    'progress' => $progress,
                ]);
                Log::info("Exportador: AfterBatch event para export_id: {$this->exportId}. Chunks procesados: {$this->processedChunks}. Progreso: {$progress}%");
            },

            BeforeWriting::class => function(BeforeWriting $event) {
                Log::info("Exportador: Evento BeforeWriting para export_id: " . $this->exportId);
                ExportProgress::on('mysql_exports')->where('export_id', $this->exportId)->update([
                    'progress' => 90, // El 90% indica que la escritura final del archivo está a punto de comenzar
                ]);
            },
        ];
    }
}