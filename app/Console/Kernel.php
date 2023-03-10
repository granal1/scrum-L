<?php

namespace App\Console;

use App\Mail\DeadlineOnThisWeek;
use App\Models\Documents\Document;
use App\Models\OutgoingFiles\OutgoingFile;
use App\Models\Tasks\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    /*
        // Создание архивной таблицы входящих документов и перенос данных из основной таблицы документов старше двух лет, раз в год
        $schedule->call(function () {

            $files = DB::table('files')
                ->where('incoming_at', '<=', Carbon::now()
                    ->subYears(2)
                    ->toDateTimeString())
                ->orderBy('incoming_at')
                ->get();

            $table_year = date('Y') - 2;

            DB::statement('CREATE TABLE if not exists archive_documents_' . $table_year . ' LIKE files');

            foreach ($files as $file) {

                try {

                    DB::beginTransaction();

                    DB::table('archive_documents_' . $table_year)->insert([
                        'id' => (string)Str::uuid(),
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

                } catch (\Exception $e) {
                    Log::error($e);
                    DB::rollBack();
                    echo 'Tables document copy error' . PHP_EOL;
                }

            }

        })->yearlyOn(2, 8, '16:26');
    */

    /*
        // Создание архивной таблицы исходящих документов и перенос данных из основной таблицы документов старше двух лет, раз в год
        $schedule->call(function () {

            $files = DB::table('outgoing_files')
                ->where('outgoing_at', '<=', Carbon::now()
                    ->subYears(2)
                    ->toDateTimeString())
                ->orderBy('outgoing_at')
                ->get();

            $table_year = date('Y') - 2;

            DB::statement('CREATE TABLE if not exists archive_outgoing_documents_' . $table_year . ' LIKE outgoing_files');

            foreach ($files as $file) {

                try {

                    DB::beginTransaction();

                    DB::table('archive_outgoing_documents_' . $table_year)->insert([
                        'id' => (string)Str::uuid(),
                        'outgoing_at' => $file->outgoing_at,
                        'outgoing_number' => $file->outgoing_number,
                        'destination' => $file->destination,
                        'number_of_source_document' => $file->number_of_source_document,
                        'date_of_source_document' => $file->date_of_source_document,
                        'short_description' => $file->short_description,
                        'document_and_application_sheets' => $file->document_and_application_sheets,
                        'file_mark' => $file->file_mark,
                        'path' => $file->path,
                        'comment' => $file->comment,
                        'sort_order' => $file->sort_order,
                        'content' => $file->content,
                        'archive_path' => $file->archive_path,
                        'created_at' => $file->created_at,
                        'updated_at' => $file->updated_at,
                        'deleted_at' => $file->deleted_at,
                        'author_uuid' => $file->author_uuid,
                        'executor_uuid' => $file->executor_uuid,
                    ]);

                    OutgoingFile::find($file->id)->forceDelete();

                    DB::commit();

                } catch (\Exception $e) {
                    Log::error($e);
                    DB::rollBack();
                    echo 'Tables outgoing copy error' . PHP_EOL;
                }

            }

        })->yearlyOn(2, 8, '16:26');
    */

        // Рассылка заданий, которые должны быть закончены на этой неделе или уже просрочены
        $schedule->call(function () {

            $tasks = Task::where('deadline_at',
                '<',
                Carbon::now()->addDays(7)->toDateTimeString()
            )
                ->where('done_progress', '<', 100)
                ->orderBy('deadline_at')
                ->get();


            $emails = $tasks->map(function($item){
                return $item->responsible->email;
            })->toArray();

            $emails = array_unique(array_values($emails));

            $tasks_for_users = [];

            foreach($tasks as $task)
            {
                foreach($emails as $email)
                {
                    if($email === $task->responsible->email)
                    {
                        if($task->deadline_at < Carbon::now()->addDays(7)->toDateTimeString()
                            &&
                            $task->deadline_at > Carbon::now()->toDateTimeString())
                        {
                            $tasks_for_users[$email]['current'][] = $task;
                        } else {
                            $tasks_for_users[$email]['overdue'][] = $task; // просроченные
                        }
                    }
                }
            }

            try {

                foreach($tasks_for_users as $key => $value)
                {
                    $hostname = explode('@', $key, 2)[1];

                    if (checkdnsrr($hostname, 'ANY')) {

                        Mail::to($key)->send(new DeadlineOnThisWeek($value));

                    } else {
                        echo "NO DNS Record found for " . $hostname . PHP_EOL;
                    }

                }

            } catch (\Exception $e) {
                Log::error($e);
            }

            })->weeklyOn(4, '12:12');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
