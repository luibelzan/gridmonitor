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
                'cups' => $item->cups ?? '',
                'id_cnt' => $item->id_cnt ?? '',
                'contrato' => $item->contrato ?? '',
                'periodo_tarifario' => strval($item->periodo_tarifario ?? '0'),
                'fecha_inicio' => $item->fecha_inicio ?? '',
                'fecha_fin' => $item->fecha_fin ?? '',
                'energia_activa_absoluta' => strval($item->energia_activa_absoluta ?? '0'),
                'energia_activa_incremental' => strval($item->energia_activa_incremental ?? '0'),
                'bit_calidad_activa' => strval($item->bit_calidad_activa ?? '0'),
                'energia_reactiva_inductiva_absoluta' => strval($item->energia_reactiva_inductiva_absoluta ?? '0'),
                'energia_reactiva_inductiva_incremental' => strval($item->energia_reactiva_inductiva_incremental ?? '0'),
                'bit_calidad_reactiva_inductiva' => strval($item->bit_calidad_reactiva_inductiva ?? '0'),
                'energia_reactiva_capacitiva_absoluta' => strval($item->energia_reactiva_capacitiva_absoluta ?? '0'),
                'energia_reactiva_capacitiva_incremental' => strval($item->energia_reactiva_capacitiva_incremental ?? '0'),
                'bit_calidad_reactiva_capacitiva' => strval($item->bit_calidad_reactiva_capacitiva ?? '0'),
                'excesos_de_potencias' => strval($item->excesos_de_potencias ?? '0'),
                'bit_calidad_excesos' => strval($item->bit_calidad_excesos ?? '0'),
                'maximetros' => strval($item->maximetros ?? '0'),
                'fecha_maximetros' => $item->fecha_maximetros ?? '',
                'bit_calidad_maximetros' => strval($item->bit_calidad_maximetros ?? '0'),
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
