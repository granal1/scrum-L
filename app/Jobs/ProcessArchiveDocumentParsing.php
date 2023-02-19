<?php

namespace App\Jobs;

use App\Models\ArchiveDocuments\ArchiveDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessArchiveDocumentParsing implements ShouldQueue
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
    //public $backoff = 1;  // next try after 1 sec
    public $backoff = [1, 2, 3];

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    //public $failOnTimeout = true;

    public ArchiveDocument $document;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ArchiveDocument $document)
    {
        $this->document = $document->withoutRelations();
        $this->queue = 'documents';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            //set_time_limit(599);

            $file_path = Storage::disk('public')->path($this->document->path);

            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file_path) ?? null;
            $content = $pdf->getText() ?? null;

            $this->document->content = $content;
            $this->document->save();

        } catch (\Throwable $e) {

            $this->document->content = 'Не удалось распарсить PDF файл ...';
            $this->document->save();

            Log::error($e);
        }

    }
}
