<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosContador extends Model
{
    use HasFactory;

    protected $table = 't_eventos_contador';

    protected $fillable = [
        'id_cups',
        'id_cnt',
        'fec_evento',
        'hor_evento',
        'grp_evento',
        'cod_evento',
        'des_origen',
        'tip_origen',
        'tip_calculo',
        'txt_adicionales_1',
        'txt_adicionales_2'
    ];

    /**
     * Relación muchos a uno entre EventosContador y Cups
     * Muchos eventos de contador pertenecen a un Cups y se relacionan por la clave id_cups
     */
    public function cups()
    {
        return $this->belongsTo(Cups::class, 'id_cups', 'id_cups');
    }

    /**
     * Relación muchos a uno entre EventosContador y Estadisticas
     * Muchos eventos de contador pertenecen a una estadística y se relacionan por la clave id_cnt
     */
    public function estadisticas()
    {
        return $this->belongsTo(Estadisticas::class, 'id_cnt', 'id_cnt');
    }

    /**
     * Relación muchos a uno entre EventosContador y DescripcionEventosContador
     * Muchos eventos de contador pertenecen a una descripción de evento de contador y se relacionan por las claves grp_evento y cod_evento
     */
    public function descripcionEventoContador()
    {
        return $this->belongsTo(DescripcionEventosContador::class, 'grp_evento', 'grp_evento')->where('cod_evento', $this->cod_evento);
    }
}
