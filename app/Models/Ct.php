<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ct extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */

    protected $table = 't_ct';

    protected $fillable = [
        'id_ct',
        'nom_ct',
        'id_comunidad',
        'id_provincia',
        'id_localidad',
        'cp_ct',
        'cod_zona',
        'id_distribuidora',
        'lat_ct',
        'lon_ct',
        'cod_estacion',
        'dir_ct',
        'id_se',
        'id_circuito',
        'ind_balance',
    ];

    /**
     * Relación uno a muchos entre Ct y Cups
     * Una Ct tiene muchas Cups y se relacionan por la clave id_ct
     */
    public function cups()
    {
        return $this->hasMany(Cups::class, 'id_ct', 'id_ct');
    }

    /**
     * Relación uno a uno entre Ct y Concentradores
     * Una Ct tiene un único Concentrador y se relacionan por la clave id_ct
     */
    public function concentrador()
    {
        return $this->hasOne(Concentradores::class, 'id_ct', 'id_ct');
    }

    /**
     * Relación uno a uno entre Ct y EstadisticasComunicacion
     * Un Ct tiene una estadística de comunicación y se relacionan por la clave id_ct
     */
    public function estadisticasComunicacion()
    {
        return $this->hasOne(EstadisticasComunicacion::class, 'id_ct', 'id_ct');
    }

    /**
     * Relación uno a uno entre Ct y EventosConcentrador
     * Un Ct tiene muchos eventos y se relacionan por la clave id_ct
     */
    public function eventosConcentrador()
    {
        return $this->hasMany(EventosConcentrador::class, 'id_ct', 'id_ct');
    }
}
