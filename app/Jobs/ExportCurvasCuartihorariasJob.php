<?php

namespace App\Jobs;

use App\Exports\ReportesPFCurvasCuartihorariasExport;
use App\Models\ExportProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportCurvasCuartihorariasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;

    protected $id_cnts;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $fileName;
    protected $dbConnectionName;
    protected $exportId;

    public function __construct($id_cnts, $fecha_inicio, $fecha_fin, $fileName, $dbConnectionName, $exportId)
    {
        $this->id_cnts = $id_cnts;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->fileName = $fileName;
        $this->dbConnectionName = $dbConnectionName;
        $this->exportId = $exportId;
    }

    public function handle()
    {
        try {
            // Actualiza a "processing" y progreso 10%
            ExportProgress::where('export_id', $this->exportId)
                ->update([
                    'status' => 'processing',
                    'progress' => 10
                ]);

            sleep(3); // Simula trabajo pesado

            // Asegurar carpeta "exports"
            if (!Storage::disk('public')->exists('exports')) {
                Storage::disk('public')->makeDirectory('exports');
                Log::info("Carpeta 'exports' creada.");
            }

            // Paso 2: Inicializando exportador (20%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 20]);
            sleep(3);

            // Crear exportador
            $export = new ReportesPFCurvasCuartihorariasExport(
                $this->id_cnts,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->fileName,
                $this->dbConnectionName
            );

            // Guardar archivo
            Excel::store(
                $export,
                $this->fileName,
                'public',
                \Maatwebsite\Excel\Excel::XLSX
            );

            // Paso 3: Preparando datos (30%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 30]);
            sleep(3);

            // Paso 4: Preparando datos (40%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 40]);
            sleep(3);

            // Simulación: progreso al 50%
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 50]);

            sleep(3); // Simula trabajo pesado

            // Paso 6: Preparando datos (60%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 60]);
            sleep(3);

            // Paso 3: Preparando datos (70%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 70]);
            sleep(3);

            // Paso 3: Preparando datos (80%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 80]);
            sleep(3);

            // Paso 3: Preparando datos (90%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 90]);
                sleep(3);

            // Paso 3: Preparando datos (100%)
            ExportProgress::where('export_id', $this->exportId)
                ->update(['progress' => 100]);

            // Finalizar progreso
            ExportProgress::where('export_id', $this->exportId)
                ->update([
                    'status' => 'completed',
                    'progress' => 100,
                    'file_path' => $this->fileName
                ]);

            $fullPath = Storage::disk('public')->path($this->fileName);
            Log::info("Archivo exportado: " . $fullPath);

        } catch (\Exception $e) {
            Log::error("Error al exportar: " . $e->getMessage());

            ExportProgress::where('export_id', $this->exportId)
                ->update([
                    'status' => 'failed',
                    'progress' => 0
                ]);

            throw $e;
        }
    }
}
