<?php

namespace App\Jobs;

use App\Http\Requests\Documents\StoreDocumentFormRequest;
use App\Models\Documents\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Exception\DceSecurityException;

class ProcessDocumentParsing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    //public $timeout = 600;
    public $tries = 1;
    //public $maxExceptions = 3;
    //public $backoff = 1;  // next try after 1 sec
    //public $backoff = [1, 2, 3, 4, 5];

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    //public $failOnTimeout = true;

    public Document $document;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document->withoutRelations();
        //$this->queue = 'documents';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try{
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
