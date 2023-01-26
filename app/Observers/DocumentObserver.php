<?php

namespace App\Observers;

use App\Models\Documents\Document;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\InputStream;
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
        //$process = new Process(['php', 'artisan', 'queue:work']);
        //$process->setWorkingDirectory(base_path());
        //$process->start();
        //$process->signal(9);
        //exec('php artisan queue:work --max-jobs=1');
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
