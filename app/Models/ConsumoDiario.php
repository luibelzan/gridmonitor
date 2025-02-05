<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoDiario extends Model
{
    use HasFactory;

    protected $table = 't_consumos_diarios';

    protected $fillable = [
        'id_cups',
        'id_cnt',
        'fec_inicio',
        'hor_inicio',
        'fec_fin',
        'hor_fin',
        'val_ai_d',
        'val_ae_d',
        'val_r1_d',
        'val_r2_d',
        'val_r3_d',
        'val_r4_d',
        'des_origen',
        'tip_origen',
        'tip_calculo',
        'val_fp_d',
    ];

    // Relacion entre la tabla t_consumos_diarios con la tabla t_cups
    //un cup tiene muchos consumos diarios y se relacionan por la clave id_cnt
    public function cups()
    {
        return $this->belongsTo(Cups::class, 'id_cnt', 'id_cnt');
    }
}
