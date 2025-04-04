<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CurvasHorariasExport implements FromCollection, WithHeadings
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
        return collect($this->data); // Convierte los datos en una colección
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'ID Cups',
            'Nombre Cups',
            'Dirección Cups',
            'ID CT',
            'ID CNT',
            'Autoconsumo',
            'Nombre CT',
            'Fecha Inicio',
            'Fecha Fin',
            'Total Curva Imp',
            'Total Curva Exp',
            'Curvas Leídas',
            'Curvas Sin Consumo',
        ];
    }
}
