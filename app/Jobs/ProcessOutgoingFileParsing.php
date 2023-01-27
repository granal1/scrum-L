<?php

namespace App\Jobs;

use App\Models\OutgoingFiles\OutgoingFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessOutgoingFileParsing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;
    public $tries = 3;
    //public $maxExceptions = 3;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    //public $failOnTimeout = true;

    public OutgoingFile $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OutgoingFile $file)
    {
        $this->file = $file->withoutRelations();
        $this->queue = 'outgoing_files';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            //set_time_limit(602);

            $file_path = Storage::disk('public')->path($this->file->path);

            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file_path) ?? null;
            $content = $pdf->getText() ?? null;

            $this->file->content = $content;
            $this->file->save();

        } catch (\Throwable $e) {

            $this->file->content = 'Не удалось распарсить PDF файл ...';
            $this->file->save();

            Log::error($e);
        }

    }
}
