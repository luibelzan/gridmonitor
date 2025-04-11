<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesInventarioExport implements FromCollection, WithHeadings
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
                'mod_cnt' => $item->mod_cnt ?? '',
                'fw_dlms_cnt' => $item->fw_dlms_cnt ?? '',
                'fw_prime_cnt' => $item->fw_prime_cnt ?? '',
                'fab_cnt' => $item->fab_cnt ?? '',
                'des_cnt_af' => $item->des_cnt_af ?? '',
                'des_te' => $item->des_te ?? '',
                'des_companion' => $item->des_companion ?? '',
                'nom_fabricante' => $item->nom_fabricante ?? '',
                'num_fases' => $item->num_fases ?? '',
                'tipo_cnt' => strval($item->tipo_cnt ?? '0'),
            ];
        });
    }

    // Cabeceras de las columnas
    public function headings(): array
    {
        return [
            'Contador',
            'Modelo',
            'DLMS',
            'Prime',
            'Fabricante',
            'Anio',
            'Tipo',
            'Companion',
            'Nombre Fabricante',
            'Fases',
            'Tipo',
        ];
    }
}
