<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportesPFCurvasCuartihorariasExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
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
}
