<?php

namespace App\Observers;

use App\Jobs\ProcessDocumentParsing;
use App\Models\Documents\Document;
use Symfony\Component\Process\Process;


class DocumentObserver
{
    /**
     * Handle the document "created" event.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return void
     */
    public function created(Document $document)
    {

    }

    public function saved(){
        $process = new Process(['php', 'artisan', 'queue:work', '--once']);
        $process->setWorkingDirectory(base_path());
        $process->setOptions(['create_new_console' => true]);
        $process->start();
    }

    /**
     * Handle the document "updated" event.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return void
     */
    public function updated(Document $document)
    {
        //
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return void
     */
    public function deleted(Document $document)
    {
        //
    }

    /**
     * Handle the document "restored" event.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the document "force deleted" event.
     *
     * @param  \App\Models\Documents\Document  $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }
}
