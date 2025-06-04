<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesPFCurvasCuartihorariasExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            return [
                'cups' => $item->CUPS ?? '',
                'id_cnt' => $item->id_cnt ?? '',
                'fecha' => $item->Fecha ?? '',
                'hora' => $item->Hora ?? '',
                'energia_activa_importada_a' => strval($item->Energia_Activa_Importada_A ?? '0'),
                'bit_calidad_activa_a' => strval($item->Bit_Calidad_Activa_A ?? '0'),
                'energia_activa_exportada_a' => strval($item->Energia_Activa_Exportada_A ?? '0'),
                'bit_calidad_activa_a2' => strval($item->Bit_Calidad_Activa_A2 ?? '0'),
                'energia_reactiva_inductiva_importada_ri' => strval($item->Energia_Reactiva_Inductiva_Importada_Ri ?? '0'),
                'bit_calidad_reactiva_imp_ri' => strval($item->Bit_Calidad_Reactiva_Imp_Ri ?? '0'),
                'energia_reactiva_inductiva_exportada_ri' => strval($item->Energia_Reactiva_Inductiva_Exportada_Ri ?? '0'),
                'bit_calidad_reactiva_imp_ri2' => strval($item->Bit_Calidad_Reactiva_Imp_Ri2 ?? '0'),
                'energia_reactiva_capacitiva_importada_rc' => strval($item->Energia_Reactiva_Capacitiva_Importada_Rc ?? '0'),
                'bit_calidad_reactiva_imp_rc' => strval($item->Bit_Calidad_Reactiva_Imp_Rc ?? '0'),
                'energia_reactiva_capacitiva_exportada_rc' => strval($item->Energia_Reactiva_Capacitiva_Exportada_Rc ?? '0'),
                'bit_calidad_reactiva_exp_rc' => strval($item->Bit_Calidad_Reactiva_Exp_Rc ?? '0'),
            ];
        });
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
