<?php

namespace App\Jobs;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExportEmployeesPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(600);
        
        try {
        Log::info('ExportEmployeesPdfJob started.');

        $chunkSize = 50;
        $html = '';

        Employee::with('department')->chunk($chunkSize, function ($employees) use (&$html) {
            Log::info('Processing chunk with ' . count($employees) . ' employees.');
            $html .= view('backend.admin.pdf.employees', ['employees' => $employees])->render();
        });

        Log::info('Finished building HTML.');

        $pdf = PDF::loadHTML($html);
        $output = $pdf->output();

        Storage::put("public/exports/pdf/{$this->fileName}", $output);

        Log::info("PDF exported and saved as {$this->fileName}");
    } catch (\Throwable $e) {
        Log::error('ExportEmployeesPdfJob failed: ' . $e->getMessage());
    }
  }
}
