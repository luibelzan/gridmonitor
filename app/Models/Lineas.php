<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lineas extends Model
{
    use HasFactory;

    protected $table = 't_lineas';

    protected $fillable = [
        'id_linea',
        'nom_linea',
        'id_comunidad',
        'id_provincia',
        'id_localidad',
        'tip_linea',
        'linea_lineasup',
        'linea_origen',
        'val_linea',
        'linea_tension_nominal',
        'id_trafo'
    ];

    /**
     * Relación muchos a uno entre Lineas y Trafos
     * Muchas líneas pertenecen a un Trafo y se relacionan por la clave id_trafo
     */
    public function trafo()
    {
        return $this->belongsTo(Trafos::class, 'id_trafo', 'id_trafo');
    }

    /**
     * Relación uno a muchos con Cups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cups()
    {
        return $this->hasMany(Cups::class, 'id_linea', 'id_linea');
    }
}
