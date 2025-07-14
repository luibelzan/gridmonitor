<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Illuminate\Support\Facades\DB;

class ReportesPFCurvasCuartihorariasExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue, WithCustomChunkSize
{
    protected $id_cnts;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $fileName;
    protected $format;
    protected $dbConnectionName;

    public function __construct($id_cnts, $fecha_inicio, $fecha_fin, $fileName, $format, $dbConnectionName)
    {
        $this->id_cnts = $id_cnts;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->fileName = $fileName;
        $this->format = $format;
        $this->dbConnectionName = $dbConnectionName;
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
                t_dat_iec870_load_profile_1.e_react_cap_exp_cualif as Bit_Calidad_Reactiva_Exp_Rc
            ");
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
        return 2000; // Define tamaño del chunk para evitar cargar mucho en memoria
    }
}