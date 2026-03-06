<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportProgress extends Model
{
    protected $connection = 'pgsql-exports'; // 👈 Aquí indicamos la base de datos correcta

    protected $table = 'export_progress';

    protected $fillable = [
        'export_id',
        'status',
        'progress',
        'file_path',
    ];
}
