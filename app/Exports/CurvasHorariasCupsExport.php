<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CurvasHorariasCupsExport implements FromCollection, WithHeadings
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
                'id_cnt' => $item->id_cnt ?? '',
                'fec_inicio' => $item->fec_inicio ?? '',
                'hor_inicio' => $item->hor_inicio ?? 0,
                'fec_fin' => $item->fec_fin ?? 0,
                'hor_fin' => $item->hor_fin ?? 0,
                'val_ai_h' => strval($item->val_ai_h ?? '0'),
                'val_ae_h' => strval($item->val_ae_h ?? '0'),
                'val_r1_h' => strval($item->val_r1_h ?? '0'),
                'val_r2_h' => strval($item->val_r2_h ?? '0'),
                'val_r3_h' => strval($item->val_r3_h ?? '0'),
                'val_r4_h' => strval($item->val_r4_h ?? '0'),
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'ID Cups',
            'Contador',
            'Fecha Inicio',
            'Hora Inicio',
            'Fecha Fin',
            'Hora Fin',
            'Val AI H',
            'Val AE H',
            'Val R1 H',
            'Val R2 H',
            'Val R3 H',
            'Val R4 H',
        ];
    }
}
