<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoHora extends Model
{
    use HasFactory;

    protected $table = 't_consumos_horarios';

    protected $fillable = [
        'id_cups',
        'id_cnt',
        'fec_inicio',
        'hor_inicio',
        'fec_fin',
        'hor_fin',
        'val_ai_h',
        'val_ae_h',
        'val_r1_h',
        'val_r2_h',
        'val_r3_h',
        'val_r4_h',
        'des_origen',
        'tip_origen',
        'tip_calculo',
        'val_fp_h',
    ];

    /**
     * Relación muchos a uno entre ConsumoHora y Cups
     * Muchos registros de ConsumoHora pertenecen a un Cups y se relacionan por la clave id_cups
     */
    public function cups()
    {
        return $this->belongsTo(Cups::class, 'id_cups', 'id_cups');
    }

    /**
     * Relación muchos a uno entre ConsumoHora y Estadisticas
     * Muchos registros de ConsumoHora pertenecen a una estadistica y se relacionan por la clave id_cnt
     */
    public function estadisticas()
    {
        return $this->belongsTo(Estadisticas::class, 'id_cnt', 'id_cnt');
    }
}
