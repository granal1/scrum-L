<?php

namespace App\Observers;

use App\Models\Tasks\Task;
use Symfony\Component\Process\Process;


class TaskObserver
{
    /**
     * Handle the document "created" event.
     *
     * @param  \App\Models\Tasks\Task $task
     * @return void
     */
    public function created(Task $task)
    {

    }

    public function saved(){

        $command = ['php', 'artisan', 'queue:work', '--once', '--queue=tasks'];
        $process = new Process($command);
        $process->setWorkingDirectory(base_path());
        $process->setOptions(['create_new_console' => true]);
        $process->disableOutput();
        $process->start();
    }

    /**
     * Handle the document "updated" event.
     *
     * @param  \App\Models\Tasks\Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param  \App\Models\Tasks\Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the document "restored" event.
     *
     * @param  \App\Models\Tasks\Task $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the document "force deleted" event.
     *
     * @param  \App\Models\Tasks\Task $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
