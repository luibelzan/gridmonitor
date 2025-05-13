<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrosMensualesExport  implements FromCollection, WithHeadings
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
                'val_ai_m' => strval($item->val_ai_m ?? '0'),
                'val_ae_m' => strval($item->val_ae_m ?? '0'),
                'val_r1_m' => strval($item->val_r1_m ?? '0'),
                'val_r2_m' => strval($item->val_r2_m ?? '0'),
                'val_r3_m' => strval($item->val_r3_m ?? '0'),
                'val_r4_m' => strval($item->val_r4_m ?? '0'),
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'ID Cups',
            'Fecha onsumo',
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
