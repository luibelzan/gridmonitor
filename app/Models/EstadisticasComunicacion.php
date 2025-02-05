<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadisticasComunicacion extends Model
{
    use HasFactory;

    protected $table = 't_g01_estadisticas_comunicaciones';

    protected $fillable = [
        'id_cnc',
        'id_ct',
        'fec_estadistica',
        'hor_estadistica',
        'num_conta_media',
        'num_conta_max',
        'num_conta_total',
        'por_conta',
        'des_origen',
        'tip_origen',
        'tip_calculo'

    ];

    /**
     * Relación uno a uno entre EstadisticasComunicacion y Concentradores
     * Una estadística de comunicación pertenece a un Concentradores y se relacionan por la clave id_cnc
     */
    public function concentrador()
    {
        return $this->belongsTo(Concentradores::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a uno entre EstadisticasComunicacion y Ct
     * Una estadística de comunicación pertenece a un Ct y se relacionan por la clave id_ct
     */
    public function ct()
    {
        return $this->belongsTo(Ct::class, 'id_ct', 'id_ct');
    }
}
