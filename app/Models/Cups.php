<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cups extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */

    protected $table = 't_cups';

    protected $fillable = [
        'id_cups',
        'nom_cups',
        'cif_cups',
        'dir_cups',
        'cp_cups',
        'id_comunidad',
        'id_provincia',
        'id_localidad',
        'cod_catastro',
        'cod_acometida',
        'cod_nodo',
        'cod_zona',
        'cod_sector',
        'cod_subsector',
        'lat_cups',
        'lon_cups',
        'des_utmy',
        'cups_estado',
        'tip_cups',
        'id_ct',
        'tip_tarifa',
        'fec_fecha_alta',
        'tip_tipo_frontera',
        'cod_codigo_mytc',
        'cod_clave_autonomica',
        'id_distribuidora',
        'val_potencia_adscrita',
        'val_potencia_contratada',
        'des_nivel_tension',
        'cod_poliza',
        'id_cnt',
        'des_propiedad',
        'des_fabricante',
        'tip_equipo',
        'cod_fase',
        'id_linea',
        'id_trafo',
        'nom_calle',
        'cod_portal',
        'nom_comercializadora',
        'tip_punto_medida',
        'tip_lectura',
        'ind_habitual',
        'ind_maximetro',
        'ind_reactiva',
        'fec_registro',
        'ind_repetidor',
        'ind_autoconsumo',
    ];

    // Relacion entre la tabla t_g02_estadisticas_contadores con la tabla t_cups
    //un cup tiene muchas estadisticas y se relacionan por la clave id_cnt
    public function estadisticasContadores()
    {
        return $this->hasMany(Estadisticas::class, 'id_cnt', 'id_cnt');
    }

    // Relacion entre la tabla t_consumos_diarios con la tabla t_cups
    //un cup tiene muchos consumos diarios y se relacionan por la clave id_cnt
    public function consumosDiarios()
    {
        return $this->hasMany(ConsumoDiario::class, 'id_cnt', 'id_cnt');
    }

    // Relación uno a uno entre Cups y Ct
    public function ct()
    {
        return $this->belongsTo(Ct::class, 'id_ct', 'id_ct');
    }

    /**
     * Relación uno a muchos entre Cups y ConsumoHora
     * Un Cups tiene muchos registros de ConsumoHora y se relacionan por la clave id_cups
     */
    public function consumosHorarios()
    {
        return $this->hasMany(ConsumoHora::class, 'id_cups', 'id_cups');
    }

    /**
     * Relación uno a uno entre Cups y EventosContador
     * Un Cups tiene muchos eventos de contador y se relacionan por la clave id_cups
     */
    public function eventosContador()
    {
        return $this->hasMany(EventosContador::class, 'id_cups', 'id_cups');
    }

    /**
     * Relación uno a uno con Lineas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function linea()
    {
        return $this->belongsTo(Lineas::class, 'id_linea', 'id_linea');
    }

    /**
     * Relación uno a uno con Trafos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trafo()
    {
        return $this->belongsTo(Trafos::class, 'id_trafo', 'id_trafo');
    }
}
