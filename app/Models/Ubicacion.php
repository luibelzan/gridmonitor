<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */

    protected $table = 'ubicacion';

    protected $fillable = [
        'id_ubicacion',
        'poblacion',
        'latitud',
        'longitud',
    ];
}
