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
            $exportProgressModel = ExportProgress::on('mysql_exports');

            // 1. Marcar como "processing" y 10%
            $exportProgressModel->where('export_id', $this->exportId)->update([
                'status' => 'processing',
                'progress' => 10
            ]);
            Log::info("Job: Estado inicial de exportación establecido para " . $this->exportId);

            // Asegurar carpeta "exports" - esto puede ir aquí o en el controlador si lo prefieres
            if (!Storage::disk('public')->exists('exports')) {
                Storage::disk('public')->makeDirectory('exports');
                Log::info("Job: Carpeta 'exports' creada si no existía.");
            }
            $exportProgressModel->where('export_id', $this->exportId)->update(['progress' => 20]);


            // 2. Despachar la exportación de Maatwebsite/Excel.
            // Maatwebsite gestionará sus propios jobs internos.
            Log::info("Job: Despachando exportador de Maatwebsite para " . $this->exportId);
            Excel::queue(
                new ReportesPFCurvasCuartihorariasExport(
                    $this->id_cnts,
                    $this->fecha_inicio,
                    $this->fecha_fin,
                    $this->fileName,
                    $this->dbConnectionName,
                    $this->exportId // Pasa el exportId al exportador
                ),
                $this->fileName,
                'public',
                \Maatwebsite\Excel\Excel::XLSX
            )->chain([
                // Esto es CRUCIAL. El job que actualiza el estado a "completed"
                // solo se ejecutará DESPUÉS de que todos los jobs internos de Maatwebsite
                // (QueueExport, AppendQueryToSheet, StoreQueuedExport) hayan terminado.
                new FinalizeExportJob($this->exportId, $this->fileName)
            ]);

            // El Job actual (ExportCurvasCuartihorariasJob) termina aquí.
            // El resto del progreso y la finalización los manejarán los jobs encadenados y los eventos.
            Log::info("Job: ExportCurvasCuartihorariasJob completado. Los jobs de Maatwebsite están en cola.");

        } catch (\Exception $e) {
            Log::error("Error al iniciar la exportación para export_id {$this->exportId}: " . $e->getMessage());

            ExportProgress::on('mysql_exports')->where('export_id', $this->exportId)->update([
                'status' => 'failed',
                'progress' => 0
            ]);
            throw $e;
        }
    }
}