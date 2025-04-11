<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventosEspontaneosExport implements FromCollection, WithHeadings
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
                'et' => $item->et ?? '',
                'c' => $item->c ?? '',
                'cnt' => $item->cnt ?? '',
                'fecha_hora_legible' => $item->fecha_hora_legible ?? '',
                'des_evento_contador' => $item->des_evento_contador ?? '',
                'id_cups' => $item->id_cups ?? '',
                'dir_cups' => $item->dir_cups ?? '',
                'id_ct' => $item->id_ct ?? '',
                'nom_ct' => $item->nom_ct ?? '',
                'cod_gravedad' => $item->cod_gravedad ?? '',
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'Grupo',
            'Evento',
            'Contador',
            'Fecha y Hora',
            'Descripcion',
            'Id CUPS',
            'Direccion CUPS',
            'CT',
            'Nombre CT',
            'Codigo gravedad',
        ];
    }
}
