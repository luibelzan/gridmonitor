<?php

namespace App\Jobs;

use App\Exports\ReportesPFCurvasCuartihorariasExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ExportCurvasCuartihorariasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * El número de segundos que el job puede ejecutar antes de que se agote el tiempo.
     *
     * @var int
     */
    public $timeout = 1200; // 10 minutos (600 segundos)

    protected $id_cnts;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $fileName;
    protected $format;
    protected $dbConnectionName;

    public function __construct($id_cnts, $fecha_inicio, $fecha_fin, $fileName, $dbConnectionName)
    {
        $this->id_cnts = $id_cnts;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->fileName = $fileName;
        $this->dbConnectionName = $dbConnectionName;
    }

    public function handle()
    {
        try {
            // Asegurarse de que la carpeta 'exports' exista dentro del disco 'public'
            if (!Storage::disk('public')->exists('exports')) {
                Storage::disk('public')->makeDirectory('exports');
                Log::info("Carpeta 'exports' creada en el disco 'public'.");
            }

            $export = new ReportesPFCurvasCuartihorariasExport(
                $this->id_cnts,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->fileName,
                $this->dbConnectionName,
            );

            Excel::store(
                $export,
                $this->fileName,
                'public',
                $this->format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX
            );

            // Log the absolute path where the file should be saved
            $fullPath = Storage::disk('public')->path($this->fileName);
            Log::info("Archivo exportado exitosamente a la ruta: " . $fullPath);

        } catch (\Exception $e) {
            Log::error("Error al exportar: " . $e->getMessage());
            throw $e; // <- Importante: relanza la excepción
        }
    }
}