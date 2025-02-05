<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosConcentrador extends Model
{
    use HasFactory;
    protected $table = 't_eventos_concentrador';

    protected $fillable = [
        'id_ct',
        'id_cnc',
        'fec_evento',
        'hor_evento',
        'grp_evento_dc',
        'cod_evento_dc',
        'des_origen',
        'tip_origen',
        'tip_calculo',
        'txt_adicionales_1',
        'txt_adicionales_2'
    ];

    /**
     * Relación muchos a uno entre EventosConcentrador y Concentradores
     * Muchos eventos de concentrador pertenecen a un Concentrador y se relacionan por la clave id_cnc
     */
    public function concentrador()
    {
        return $this->belongsTo(Concentradores::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación muchos a uno entre EventosConcentrador y Ct
     * Muchos eventos de concentrador pertenecen a un Ct y se relacionan por la clave id_ct
     */
    public function ct()
    {
        return $this->belongsTo(Ct::class, 'id_ct', 'id_ct');
    }

    /**
     * Relación muchos a uno entre EventosConcentrador y DescripcionEventosConcentrador
     * Muchos eventos de concentrador pertenecen a una descripción de evento de concentrador y se relacionan por las claves grp_evento_dc y cod_evento_dc
     */
    public function descripcionEventoConcentrador()
    {
        return $this->belongsTo(DescripcionEventosConcentrador::class, 'grp_evento_dc', 'grp_evento_dc')->where('cod_evento_dc', $this->cod_evento_dc);
    }
}
