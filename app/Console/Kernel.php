<?php

namespace App\Console;

use App\Models\Documents\Document;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {

            // TODO сделать сразу выборку данных только старше двух лет
        $files = DB::table('files')->orderBy('incoming_at')->get();

        $need_to_copy = false;
        $current_year = date('Y');

        foreach($files as $file)
        {
            // Есть ли хоть один документ старше, чем два года
            if($current_year - date('Y', strtotime($file->incoming_at)) >= 2) {
                $need_to_copy = true;
                break;
            }
        }

        $table_year = date('Y') - 2;

        if($need_to_copy)
        {

            DB::statement('CREATE TABLE if not exists archive_documents_' . $table_year . ' LIKE files');

            foreach($files as $file)
            {

                if($current_year - date('Y', strtotime($file->incoming_at)) >= 2)
                {
                    try{

                        DB::beginTransaction();

                        DB::table('archive_documents_' . $table_year)->insert([
                            'id' =>  (string) Str::uuid(),
                            'incoming_at' => $file->incoming_at,
                            'incoming_number' => $file->incoming_number,
                            'incoming_author' => $file->incoming_author,
                            'number' => $file->number,
                            'date' => $file->date,
                            'short_description' => $file->short_description,
                            'document_and_application_sheets' => $file->document_and_application_sheets,
                            'executed_result' => $file->executed_result,
                            'executed_at' => $file->executed_at,
                            'file_mark' => $file->file_mark,
                            'path' => $file->path,
                            'comment' => $file->comment,
                            'sort_order' => $file->sort_order,
                            'content' => $file->content,
                            'archive_path' => $file->archive_path,
                            'created_at' => $file->created_at,
                            'updated_at' => $file->updated_at,
                            'deleted_at' => $file->deleted_at,
                            'author_uuid' => $file->author_uuid
                        ]);

                        Document::find($file->id)->forceDelete();

                        DB::commit();

                    } catch(\Exception $e) {
                        Log::error($e);
                        DB::rollBack();
                        echo 'Tables copy error' . PHP_EOL;
                    }

                } else {
                    echo 'Break from tables copy foreach' . PHP_EOL;
                    break;
                }
            }
        }

                })->yearlyOn(2,8,'14:31');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');


        require base_path('routes/console.php');
    }
}
