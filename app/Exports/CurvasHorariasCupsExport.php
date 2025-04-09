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
        return collect($this->data); // Convierte los datos en una colección
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
