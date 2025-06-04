<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SumBalancesExport implements FromCollection, WithHeadings
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
                'nom_cups' => $item->nom_cups ?? '',
                'id_cnt' => $item->id_cnt ?? '',
                'id_cups' => $item->id_cups ?? '',
                'total_val_ai_d' => strval($item->total_val_ai_d ?? '0'),
                'total_val_ae_d' => strval($item->total_val_ae_d ?? '0'),
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'Nombre Cups',
            'Contador',
            'Id Cups',
            'Total Val AI',
            'Total Val AE',
        ];
    }
}
