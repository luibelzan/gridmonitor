<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trafos extends Model
{
    use HasFactory;

    protected $table = 't_trafos';

    protected $fillable = [
        'id_trafo',
        'nom_trafo',
        'id_cnc',
        'id_svr',
        'val_kva',
        'fec_alta',
        'fec_baja'
    ];

    /**
     * Relación muchos a uno entre Trafos y Concentradores
     * Muchos trafos pertenecen a un Concentrador y se relacionan por la clave id_cnc
     */
    public function concentrador()
    {
        return $this->belongsTo(Concentradores::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a muchos entre Trafos y Lineas
     * Un Trafo tiene muchas líneas y se relacionan por la clave id_trafo
     */
    public function lineas()
    {
        return $this->hasMany(Lineas::class, 'id_trafo', 'id_trafo');
    }

    /**
     * Relación uno a uno entre Trafos y Supervisores
     * Un Trafo tiene un supervisor y se relacionan por la clave id_trafo
     */
    public function supervisor()
    {
        return $this->hasOne(Supervisores::class, 'id_trafo', 'id_trafo');
    }

    /**
     * Relación uno a muchos con Cups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cups()
    {
        return $this->hasMany(Cups::class, 'id_trafo', 'id_trafo');
    }
}
