<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BalancesFasesSABTExport implements FromCollection, WithHeadings {
    
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function collection() {
        return collect($this->data)->map(function ($item) {
            return [
                'id_ct' => $item->id_ct ?? '',
                'id_linea' => $item->id_linea ?? '',
                'total_ai_lvs_r' => strval(round($item->total_ai_lvs_r/1000 ?? 0)) ?? '0',
                'total_ae_lvs_r' => strval(round($item->total_ae_lvs_r/1000 ?? 0)) ?? '0',
                'total_lvs_r' => strval(round($item->total_lvs_r/1000 ?? 0)) ?? '0',
                'total_ai_cnt_r' => strval(round($item->total_ai_cnt_r/1000 ?? 0)) ?? '0',
                'total_ae_cnt_r' => strval(round($item->total_ae_cnt_r/1000 ?? 0)) ?? '0',
                'perdida_energia_r' => strval(round($item->perdida_energia_r/1000 ?? 0)) ?? '0',
                'porcentaje_perdida_r' => strval(round($item->porcentaje_perdida_r ?? 0)) ?? '0',

                'total_ai_lvs_s' => strval(round($item->total_ai_lvs_s/1000 ?? 0)) ?? '0',
                'total_ae_lvs_s' => strval(round($item->total_ae_lvs_s/1000 ?? 0)) ?? '0',
                'total_lvs_s' => strval(round($item->total_lvs_s/1000 ?? 0)) ?? '0',
                'total_ai_cnt_s' => strval(round($item->total_ai_cnt_s/1000 ?? 0)) ?? '0',
                'total_ae_cnt_s' => strval(round($item->total_ae_cnt_s/1000 ?? 0)) ?? '0',
                'perdida_energia_s' => strval(round($item->perdida_energia_s/1000 ?? 0)) ?? '0',
                'porcentaje_perdida_s' => strval(round($item->porcentaje_perdida_s ?? 0)) ?? '0',

                'total_ai_lvs_t' => strval(round($item->total_ai_lvs_t/1000 ?? 0)) ?? '0',
                'total_ae_lvs_t' => strval(round($item->total_ae_lvs_t/1000 ?? 0)) ?? '0',
                'total_lvs_t' => strval(round($item->total_lvs_t/1000 ?? 0)) ?? '0',
                'total_ai_cnt_t' => strval(round($item->total_ai_cnt_t/1000 ?? 0)) ?? '0',
                'total_ae_cnt_t' => strval(round($item->total_ae_cnt_t/1000 ?? 0)) ?? '0',
                'perdida_energia_t' => strval(round($item->perdida_energia_t/1000 ?? 0)) ?? '0',
                'porcentaje_perdida_t' => strval(round($item->porcentaje_perdida_t ?? 0)) ?? '0',
            ];
        });
    }

    public function headings(): array {
        return [
            'CT ID',
            'Línea',
            
            // Fase R
            'Energía Generada (R)',
            'Energía (Exceso R)',
            'Total Generación (R)',
            'Energía Consumida (R)',
            'Autoconsumos (R)',
            'Pérdida Energía (R)',
            'Pérdida Porcentual (R)',

            // Fase S
            'Energía Generada (S)',
            'Energía (Exceso S)',
            'Total Generación (S)',
            'Energía Consumida (S)',
            'Autoconsumos (S)',
            'Pérdida Energía (S)',
            'Pérdida Porcentual (S)',

            // Fase T
            'Energía Generada (T)',
            'Energía (Exceso T)',
            'Total Generación (T)',
            'Energía Consumida (T)',
            'Autoconsumos (T)',
            'Pérdida Energía (T)',
            'Pérdida Porcentual (T)',
        ];
    }
}