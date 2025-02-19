<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S64 extends Model {
    
    use HasFactory;

    protected $table = 't_s64';

    protected $fillable = [
        'id',
        'rtu_id',
        'lvs_id',
        'lvs_pos',
        'fh',
        'v1',
        'v2',
        'v3',
        'i1',
        'i2',
        'i3',
        'in',
        'simp',
        'sexp',
        'bc',
    ];

    

}