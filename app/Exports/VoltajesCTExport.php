<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VoltajesCTExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Hora',
            'Voltaje Fase R (V)',
            'Voltaje Fase S (V)',
            'Voltaje Fase T (V)',
        ];
    }

    public function array(): array
    {
        return array_map(function ($item) {
            return [
                $item->fecha,
                $item->hor_registro,
                $item->val_voltaje_1,
                $item->val_voltaje_2,
                $item->val_voltaje_3,
            ];
        }, $this->data);
    }
}