<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesEventosExport implements FromCollection, WithHeadings
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
            'Fecha',
            'Hora',
            'Adicional Inf. 1',
            'Adicional Inf. 2',
            'Descripcion',
        ];
    }
}
