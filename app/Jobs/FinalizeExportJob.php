<?php

namespace App\Jobs;

use App\Models\ExportProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FinalizeExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exportId;
    protected $fileName;

    public function __construct($exportId, $fileName)
    {
        $this->exportId = $exportId;
        $this->fileName = $fileName;
    }

    public function handle()
    {
        $exportProgressModel = ExportProgress::on('pgsql-exports');
        $disk = Storage::disk('public');

        // Opcional: Re-verificación final del archivo (aunque Maatwebsite debería haberlo hecho)
        if (!$disk->exists($this->fileName) || $disk->size($this->fileName) === 0) {
            Log::error("FinalizeExportJob: Archivo '{$this->fileName}' no encontrado o vacío al finalizar.");
            $exportProgressModel->where('export_id', $this->exportId)->update([
                'status' => 'failed',
                'progress' => 0,
                'file_path' => null
            ]);
            // Opcional: Lanzar una excepción si esto es un error crítico
            // throw new \Exception("El archivo final no está disponible o está vacío: {$this->fileName}");
            return; // Detener la ejecución si el archivo no está
        }

        // Marcar como COMPLETADO y 100% solo después de que todo haya terminado
        $exportProgressModel->where('export_id', $this->exportId)->update([
            'status' => 'completed',
            'progress' => 100,
            'file_path' => $this->fileName
        ]);

        Log::info("FinalizeExportJob: Exportación realmente completada y verificada para export_id: {$this->exportId}");
    }
}