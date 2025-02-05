<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadisticas extends Model
{
    use HasFactory;

    protected $table = 't_g02_estadisticas_contadores';
    protected $fillable = [
        'id_cups',
        'id_cnt',
        'id_cnc',
        'fec_fin',
        'hor_fin',
        'num_minutos_contador',
        'num_cambios',
        'num_minutos_concentrador',
        'por_minutos_contador',
        'des_origen',
        'tip_origen',
        'tip_calculo',
    ];

    // Relacion entre la tabla t_g02_estadisticas_contadores con la tabla t_cups
    //un cup tiene muchas estadisticas y se relacionan por la clave id_cnt
    public function cups()
    {
        return $this->belongsTo(Cups::class, 'id_cnt', 'id_cnt');
    }

    /**
     * Relación uno a muchos entre Estadisticas y ConsumoHora
     * Una estadistica tiene muchos registros de ConsumoHora y se relacionan por la clave id_cnt
     */
    public function consumosHorarios()
    {
        return $this->hasMany(ConsumoHora::class, 'id_cnt', 'id_cnt');
    }

    /**
     * Relación uno a uno entre Estadisticas y EventosContador
     * Una estadística tiene muchos eventos de contador y se relacionan por la clave id_cnt
     */
    public function eventosContador()
    {
        return $this->hasMany(EventosContador::class, 'id_cnt', 'id_cnt');
    }
}
