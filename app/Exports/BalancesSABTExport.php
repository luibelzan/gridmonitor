<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BalancesSABTExport implements FromCollection, WithHeadings {
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function collection() {
        return collect($this->data)->map(function ($item) {
            return [
                'id_ct' => $item->id_ct ?? '',
                'id_linea' => $item->id_linea ?? '',
                'total_ai_lvs' => strval(round(($item->total_ai_lvs ?? 0) / 1000)) ?? '0',
                'total_ae_lvs' => strval(round(($item->total_ae_lvs ?? 0) / 1000)) ?? '0',
                'total_lvs' => strval(round(($item->total_lvs ?? 0) / 1000)) ?? '0',
                'total_ai_cnt' => strval(round(($item->total_ai_cnt ?? 0) / 1000)) ?? '0',
                'total_ae_cnt' => strval(round(($item->total_ae_cnt ?? 0) / 1000)) ?? '0',
                'total_cnt' => strval(round($item->total_cnt ?? 0)) ?? '0',
                'perdida_energia' => strval(round(($item->perdida_energia ?? 0) / 1000)) ?? '0',
                'porcentaje_perdida' => strval(($item->porcentaje_perdida ?? 0)) ?? '',
            ];
        });
    }

    public function headings(): array {
        return [
            'Id CT',
            'Id Linea',
            'Energia Generada',
            'Energia (Exceso)',
            'Total generacion',
            'Energia Consumida',
            'Autoconsumos',
            'Cups Leidos',
            'Perdida',
            'Perdida Porcentual',
        ];
    }
}