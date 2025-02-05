<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisores extends Model
{
    use HasFactory;

    protected $table = 't_supervisores';

    protected $fillable = [
        'id_svr',
        'des_svrfab',
        'des_svrmod',
        'des_svrdlms',
        'des_svrvprime',
        'des_svrmac',
        'val_svr_tp',
        'val_svr_ts',
        'val_svr_ip',
        'val_svr_is',
        'id_trafo'
    ];

    /**
     * Relación uno a uno inversa entre Supervisores y Trafos
     * Un supervisor pertenece a un trafo y se relacionan por la clave id_trafo
     */
    public function trafo()
    {
        return $this->belongsTo(Trafos::class, 'id_trafo', 'id_trafo');
    }

    /**
     * Relación uno a uno entre Supervisores y SupervisoresVoltaje
     * Un Supervisor tiene un registro de supervisores de voltaje y se relacionan por la clave id_svr
     */
    public function supervisoresVoltaje()
    {
        return $this->hasOne(SupervisoresVoltaje::class, 'id_svr', 'id_svr');
    }
}
