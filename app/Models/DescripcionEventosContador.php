<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescripcionEventosContador extends Model
{
    use HasFactory;

    protected $table = 't_descripcion_eventos_contador';

    protected $fillable = [
        'grp_evento',
        'cod_evento',
        'des_evento_contador'
    ];

    /**
     * Relación uno a muchos entre DescripcionEventosContador y EventosContador
     * Una descripción de evento de contador puede tener muchos eventos de contador asociados
     */
    public function eventosContador()
    {
        return $this->hasMany(EventosContador::class, 'grp_evento', 'grp_evento')->where('cod_evento', $this->cod_evento);
    }
}
