<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsumosTotalesDiariosExport implements FromCollection, WithHeadings
{
    protected $data;

    // Constructor para recibir los datos de la consulta
    public function __construct($data)
    {
        $this->data = $data;
    }

    // Función que retorna los datos a exportar
    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            return [
                'id_cups' => $item->id_cups ?? '',
                'fec_consumo' => $item->fec_consumo ?? '',
                'cod_periodotarifa' => $item->cod_periodotarifa ?? '',
                'val_ai_d' => strval($item->val_ai_d ?? '0'),
                'val_ae_d' => strval($item->val_ae_d ?? '0'),
                'val_r1_d' => strval($item->val_r1_d ?? '0'),
                'val_r2_d' => strval($item->val_r2_d ?? '0'),
                'val_r3_d' => strval($item->val_r3_d ?? '0'),
                'val_r4_d' => strval($item->val_r4_d ?? '0'),
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'ID Cups',
            'Fecha Consumo',
            'Periodo',
            'Val AI',
            'Val AE',
            'Val R1',
            'Val R2',
            'Val R3',
            'Val R4',
        ];
    }
}
