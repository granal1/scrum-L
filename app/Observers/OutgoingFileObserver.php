<?php

namespace App\Observers;


use App\Models\OutgoingFiles\OutgoingFile;
use Symfony\Component\Process\Process;


class OutgoingFileObserver
{
    /**
     * Handle the document "created" event.
     *
     * @param \App\Models\OutgoingFiles\OutgoingFile $outgoing_file
     * @return void
     */
    public function created(OutgoingFile $outgoing_file)
    {

    }

    public function saved()
    {

        $command = ['php', 'artisan', 'queue:work', '--once', '--queue=outgoing_files'];
        $process = new Process($command);
        $process->setWorkingDirectory(base_path());
        $process->setOptions(['create_new_console' => true]);
        $process->disableOutput();
        $process->start();
    }

    /**
     * Handle the document "updated" event.
     *
     * @param \App\Models\OutgoingFiles\OutgoingFile $outgoing_file
     * @return void
     */
    public function updated(OutgoingFile $outgoing_file)
    {
        //
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param \App\Models\OutgoingFiles\OutgoingFile $outgoing_file
     * @return void
     */
    public function deleted(OutgoingFile $outgoing_file)
    {
        //
    }

    /**
     * Handle the document "restored" event.
     *
     * @param \App\Models\OutgoingFiles\OutgoingFile $outgoing_file
     * @return void
     */
    public function restored(OutgoingFile $outgoing_file)
    {
        //
    }

    /**
     * Handle the document "force deleted" event.
     *
     * @param \App\Models\OutgoingFiles\OutgoingFile $outgoing_file
     * @return void
     */
    public function forceDeleted(OutgoingFile $outgoing_file)
    {
        //
    }
}
