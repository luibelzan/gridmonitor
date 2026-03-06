<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventosCupsExport implements FromCollection, WithHeadings
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
                'fecha' => $item->fecha ?? '',
                'hora' => $item->hor_evento ?? '',
                'cod_fase' => $item->cod_fase ?? '',
                'id_linea' => $item->id_linea ?? '',
                'txt_adicionales_1' => $item->txt_adicionales_1 ?? '',
                'txt_adicionales_2' => $item->txt_adicionales_2 ?? '',
                'des_evento_contador' => $item->des_evento_contador ?? '',
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'CUP',
            'Contador',
            'Fecha',
            'Hora',
            'Fase',
            'Linea',
            'Info adicional 1',
            'Info adicional 2',
            'Descripcion',
        ];
    }
}
