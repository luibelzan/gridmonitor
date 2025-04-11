<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventosPFExport implements FromCollection, WithHeadings
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
                'id_cnt' => $item->id_cnt ?? '',
                'fh' => $item->fh ?? '',
                'DR' => strval($item->DR ?? '0'),
                'SPA' => strval($item->SPA ?? '0'),
                'SPQ' => strval($item->SPQ ?? '0'),
                'SPI' => strval($item->SPI ?? '0'),
                'description' => $item->description ?? '',
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'Contador',
            'Fecha',
            'DR',
            'SPA',
            'SPQ',
            'SPI',
            'Descripcion',
        ];
    }
}
