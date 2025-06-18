<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiferenciaConsumosExport implements FromCollection, WithHeadings
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
                'id_cups'              => $item->id_cups ?? '',
                'id_cnt'               => $item->id_cnt ?? '',
                'suma_diarios'         => $item->suma_diarios ?? 0,
                'num_cons_dia'         => $item->num_cons_dia ?? 0,
                'suma_mensual'         => $item->suma_mensual ?? 0,
                'num_cons_mes'         => $item->num_cons_mes ?? 0,
                'suma_horas'           => $item->suma_horas ?? 0,
                'num_cons_horas'       => $item->num_cons_horas ?? 0,
                'dif_diario_mensual'   => $item->dif_diario_mensual ?? 0,
                'dif_diario_horario'   => $item->dif_diario_horario ?? 0,
                'dif_mensual_horario'  => $item->dif_mensual_horario ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID CUPS',
            'ID CNT',
            'Suma Diarios',
            'N° Consumos Diario',
            'Suma Mensual',
            'N° Consumos Mensual',
            'Suma Horaria',
            'N° Consumos Horarios',
            'Diferencia Diario vs Mensual',
            'Diferencia Diario vs Horario',
            'Diferencia Mensual vs Horario',
        ];
    }
}
