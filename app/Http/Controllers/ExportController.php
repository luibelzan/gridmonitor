<?php

namespace App\Http\Controllers;

use App\Models\ExportProgress;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function getExportProgress($exportId)
    {
        $progress = ExportProgress::where('export_id', $exportId)->first();

        if (!$progress) {
            return response()->json(['status' => 'not_found'], 404);
        }

        return response()->json([
            'status' => $progress->status,
            'progress' => $progress->progress,
            'download_url' => $progress->status === 'completed' ? Storage::disk('public')->url($progress->file_path) : null
        ]);
    }
}
