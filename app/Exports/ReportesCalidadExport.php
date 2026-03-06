<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesCalidadExport implements FromCollection, WithHeadings
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
                'nom_ct' => $item->nom_ct ?? '',
                'id_cups' => $item->id_cups ?? '',
                'nom_cups' => $item->nom_cups ?? '',
                'dir_cups' => $item->dir_cups ?? '',
                'apagones' => strval($item->apagones ?? '0'),
                'sobrevoltajes' =>  strval($item->sobrevoltajes ?? '0'),
                'sub_voltajes' => strval($item->sub_voltajes ?? '0'),
                'micro_cortes' => strval($item->micro_cortes ?? '0'),
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'CT',
            'CUPS',
            'Nombre Cups',
            'Direccion CUPS',
            'Cortes',
            'Sobretensiones',
            'Subtensiones',
            'Micro cortes',
        ];
    }
}
