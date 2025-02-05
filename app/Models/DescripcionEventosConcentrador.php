<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescripcionEventosConcentrador extends Model
{
    use HasFactory;

    protected $table = 't_descripcion_eventos_concentrador';

    protected $fillable = [
        'grp_evento_dc',
        'cod_evento_dc',
        'des_evento_dc'
    ];

    /**
     * Relación uno a muchos entre DescripcionEventosConcentrador y EventosConcentrador
     * Una descripción de evento de concentrador puede tener muchos eventos de concentrador asociados
     */
    public function eventosConcentrador()
    {
        return $this->hasMany(EventosConcentrador::class, 'grp_evento_dc', 'grp_evento_dc')->where('cod_evento_dc', $this->cod_evento_dc);
    }
}
