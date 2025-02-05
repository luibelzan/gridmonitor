<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concentradores extends Model
{
    use HasFactory;

    protected $table = 't_concentradores';

    protected $fillable = [
        'id_cnc',
        'cod_mod',
        'des_cnc_af',
        'tip_concentrador',
        'des_vdlms',
        'des_vprime',
        'ip_ipcom',
        'des_portws',
        'des_ipmask',
        'ip_ipgtw',
        'des_ipdhcp',
        'ip_iploc',
        'des_ipmaskloc',
        'des_priority',
        'des_macplc',
        'des_stgserver',
        'des_ntpserver',
        'des_ftpserver',
        'id_ct',
        'des_version_stg',
        'des_fab_dc',
        'id_wanlan',
        'ws_url',
        'ind_synccontador',
        'num_contadores',
        'seg_sendreq',
        'seg_desconcontador',
        'num_reintdesconcontador',
        'seg_reintintervalo'
    ];

    /**
     * Relación uno a uno entre Concentradores y Ct
     * Un concentrador pertenece a una única Ct y se relacionan por la clave id_ct
     */
    public function ct()
    {
        return $this->belongsTo(Ct::class, 'id_ct', 'id_ct');
    }

    /**
     * Relación uno a muchos entre Concentradores y Estadisticas
     * Un concentrador tiene muchas estadísticas y se relacionan por la clave id_cnc
     */
    public function estadisticas()
    {
        return $this->hasMany(Estadisticas::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a muchos entre Concentradores y Cups
     * Un concentrador tiene muchas Cups y se relacionan por la clave id_cnc
     */
    public function cups()
    {
        return $this->hasMany(Cups::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a uno entre Concentradores y EstadisticasComunicacion
     * Un Concentradores tiene una estadística de comunicación y se relacionan por la clave id_cnc
     */
    public function estadisticasComunicacion()
    {
        return $this->hasOne(EstadisticasComunicacion::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a uno entre Concentradores y EventosConcentrador
     * Un Concentrador tiene muchos eventos y se relacionan por la clave id_cnc
     */
    public function eventosConcentrador()
    {
        return $this->hasMany(EventosConcentrador::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a uno entre Concentradores y Trafos
     * Un Concentrador tiene muchos trafos y se relacionan por la clave id_cnc
     */
    public function trafos()
    {
        return $this->hasMany(Trafos::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a muchos inversa entre Concentradores y SupervisoresVoltaje
     * Un concentrador tiene muchos registros de supervisores de voltaje y se relacionan por la clave id_cnc
     */
    public function supervisoresVoltaje()
    {
        return $this->hasMany(SupervisoresVoltaje::class, 'id_cnc', 'id_cnc');
    }
}
