<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VoltajesCUPSExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Fecha lectura',
            'Hora lectura',
            'Tensión (V)'
        ];
    }

    public function array(): array
    {
        return array_map(function ($item) {
            return [
                $item->fec_lectura,
                $item->hor_lectura,
                $item->tension,
            ];
        }, $this->data);
    }
}