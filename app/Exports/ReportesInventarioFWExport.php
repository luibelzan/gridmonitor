<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesInventarioFWExport implements FromCollection, WithHeadings
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
                'fec_evento' => $item->fec_evento ?? '',
                'hor_evento' => $item->hor_evento ?? '',
                'txt_adicionales_1' => $item->txt_adicionales_1 ?? '',
                'txt_adicionales_2' => $item->txt_adicionales_2 ?? '',
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'CUPS',
            'Contador',
            'Fecha',
            'Hora',
            'Texto adicional 1',
            'Texto adicional 2',
        ];
    }
}
