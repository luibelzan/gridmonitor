<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloContador extends Model
{
    use HasFactory;
    protected $table = 't_modelos_contadores';

    protected $fillable = [
        'mod_cnt',
        'fab_cnt',
        'nom_fabricante',
        'tipo_cnt',
        'num_fases'
    ];
}
