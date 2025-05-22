<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesPFCierresMensualesExport implements FromCollection, WithHeadings
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
                'contrato' => $item->Contrato ?? '',
                'periodo_tarifario' => strval($item->Periodo_Tarifario ?? '0'),
                'fecha_inicio' => $item->Fecha_Inicio ?? '',
                'fecha_fin' => $item->Fecha_Fin ?? '',
                'energia_activa_absoluta' => strval($item->Energia_Activa_Absoluta ?? '0'),
                'energia_activa_incremental' => strval($item->Energia_Activa_Incremental ?? '0'),
                'bit_calidad_activa' => strval($item->Bit_Calidad_Activa ?? '0'),
                'energia_reactiva_inductiva_absoluta' => strval($item->Energia_Reactiva_Inductiva_Absoluta ?? '0'),
                'energia_reactiva_inductiva_incremental' => strval($item->Energia_Reactiva_Inductiva_Incremental ?? '0'),
                'bit_calidad_reactiva_inductiva' => strval($item->Bit_Calidad_Reactiva_Inductiva ?? '0'),
                'energia_reactiva_capacitiva_absoluta' => strval($item->Energia_Reactiva_Capacitiva_Absoluta ?? '0'),
                'energia_reactiva_capacitiva_incremental' => strval($item->Energia_Reactiva_Capacitiva_Incremental ?? '0'),
                'bit_calidad_reactiva_capacitiva' => strval($item->Bit_Calidad_Reactiva_Capacitiva ?? '0'),
                'excesos_de_potencias' => strval($item->Excesos_de_Potencias ?? '0'),
                'bit_calidad_excesos' => strval($item->Bit_Calidad_Excesos ?? '0'),
                'maximetros' => strval($item->Maximetros ?? '0'),
                'fecha_maximetros' => $item->Fecha_Maximetros ?? '',
                'bit_calidad_maximetros' => strval($item->Bit_Calidad_Maximetros ?? '0'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'CUPS',
            'ID CNT',
            'Contrato',
            'Periodo Tarifario',
            'Fecha Inicio',
            'Fecha Fin',
            'Energía Activa Absoluta',
            'Energía Activa Incremental',
            'Bit Calidad Activa',
            'Energía Reactiva Inductiva Absoluta',
            'Energía Reactiva Inductiva Incremental',
            'Bit Calidad Reactiva Inductiva',
            'Energía Reactiva Capacitiva Absoluta',
            'Energía Reactiva Capacitiva Incremental',
            'Bit Calidad Reactiva Capacitiva',
            'Excesos de Potencias',
            'Bit Calidad Excesos',
            'Maxímetros',
            'Fecha Maxímetros',
            'Bit Calidad Maxímetros',
        ];
    }
}
