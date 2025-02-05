<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisoresVoltaje extends Model
{
    use HasFactory;

    protected $table = 't_supervisores_voltajes';

    protected $fillable = [
        'id_cnc',
        'id_svr',
        'fec_registro',
        'hor_registro',
        'bc',
        'val_voltaje_1',
        'val_voltaje_2',
        'val_voltaje_3',
        'val_corriente_1',
        'val_corriente_2',
        'val_corriente_3',
        'val_corriente_n',
        'val_media_import',
        'val_media_export',
        'pct_deseq_corriente',
        'val_kva_1',
        'val_kva_2',
        'val_kva_3',
        'val_kva_t',
    ];
    
    /**
     * Relación muchos a uno entre SupervisoresVoltaje y Concentradores
     * Muchos registros de supervisores de voltaje pertenecen a un concentrador y se relacionan por la clave id_cnc
     */
    public function concentrador()
    {
        return $this->belongsTo(Concentradores::class, 'id_cnc', 'id_cnc');
    }

    /**
     * Relación uno a uno inversa entre SupervisoresVoltaje y Supervisores
     * Un registro de supervisores de voltaje pertenece a un supervisor y se relacionan por la clave id_svr
     */
    public function supervisor()
    {
        return $this->belongsTo(Supervisores::class, 'id_svr', 'id_svr');
    }
}
