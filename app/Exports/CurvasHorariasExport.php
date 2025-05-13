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
        return collect($this->data)->map(function ($item) {
            return [
                'id_cups' => $item->id_cups ?? '',
                'nom_cups' => $item->nom_cups ?? '',
                'dir_cups' => $item->dir_cups ?? '',
                'id_ct' => $item->id_ct ?? '',
                'id_cnt' => $item->id_cnt ?? '',
                'ind_autoconsumo' => $item->ind_autoconsumo ?? '',
                'nom_ct' => $item->nom_ct ?? '',
                'fec_inicio' => $item->fec_inicio ?? '',
                'fec_fin' => $item->fec_fin ?? '',
                'total_curva_imp' => strval($item->total_curva_imp ?? '0'),
                'total_surva_exp' => strval($item->total_curva_exp ?? '0'),
                'curvas_leidas' => strval($item->curvas_leidas ?? '0'),
                'curvas_sin_consumo' => strval($item->curvas_sin_consumo ?? '0'),
            ];
        });
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
