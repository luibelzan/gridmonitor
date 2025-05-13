<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventosCTExport implements FromCollection, WithHeadings
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
                'id_ct' => $item->id_ct ?? '',
                'id_cnc' => $item->id_cnc ?? '',
                'fecha' => $item->fecha ?? '',
                'hor_evento' => $item->hor_evento ?? '',
                'txt_adicionales_1' => $item->txt_adicionales_1 ?? '',
                'txt_adicionales_2' => $item->txt_adicionales_2 ?? '',
                'des_evento_dc' => $item->des_evento_dc ?? '',
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'ID CT',
            'Concentrador',
            'Fecha',
            'Hora',
            'Info adicional 1',
            'Info adicional 2',
            'Descripcion',
        ];
    }
}
