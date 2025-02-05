<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoContadores extends Model
{
    use HasFactory;

    //MODELO DE PRUEBA
    protected $table = 'consumo_contadores';
    protected $fillable = [
        'id_contador',
        'consumo_dia',
        'consumo_mes',
        'potencia_max_diaria',
    ];
}
