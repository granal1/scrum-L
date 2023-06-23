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
use DateTime;

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
        //__________________________________________________________________________________
        // Рассылка заданий, которые должны быть закончены на этой неделе или уже просрочены
        //__________________________________________________________________________________
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
                $utcTime = new DateTime($task['deadline_at']);
                $task['deadline_at'] = $utcTime->setTimezone(timezone_open('Europe/Moscow'))->format('Y-m-d H:i'); // перевод МСК часовой пояс
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
            } 
            catch (\Exception $e) {
                Log::error($e);
            }
        })
        ->weeklyOn(1, '06:00');
        //->dailyAt('06:00'); //Для тестирования


        //____________________________
        // Создание архива документов
        //____________________________
        $schedule->call(function(){
            $check_date = date('Y') - 1 . "-01-01";

            // Архивирование ВХОДЯЩИХ документов
            $oldest_date = DB::table('files')->min('incoming_at');
            $archive_table = 'archive_files_' . date('Y', strtotime($oldest_date));
            if ($oldest_date < $check_date) {
                while ($oldest_date < $check_date) {
                    Log::info('Перенос в архив ВХОДЯЩИХ за '. $oldest_date);
                    DB::statement('CREATE TABLE if not exists ' . $archive_table . ' LIKE files');
                    try {
                        DB::beginTransaction();
                        DB::statement('INSERT INTO `' .$archive_table. '` (SELECT * FROM `files` WHERE `incoming_at`= "' .$oldest_date. '")');
                        DB::statement('DELETE FROM `files` WHERE `incoming_at`= "' .$oldest_date. '"');
                        DB::commit();
                    }
                    catch (\Exception $e) {
                        Log::error($e);
                        DB::rollBack();
                        echo 'Tables document copy error' . PHP_EOL;
                    }
                    $oldest_date = DB::table('files')->min('incoming_at');
                    $archive_table = 'archive_files_' . date('Y', strtotime($oldest_date));
                }
            }

            // Архивирование ИСХОДЯЩИХ документов
            $oldest_date = DB::table('outgoing_files')->min('outgoing_at');
            $archive_table = 'archive_outgoing_files_' . date('Y', strtotime($oldest_date));
            if ($oldest_date < $check_date) {
                while ($oldest_date < $check_date) {
                    Log::info('Перенос в архив ИСХОДЯЩИХ за '. $oldest_date);
                    DB::statement('CREATE TABLE if not exists ' . $archive_table . ' LIKE outgoing_files');
                    try {
                        DB::beginTransaction();
                        DB::statement('INSERT INTO `' .$archive_table. '` (SELECT * FROM `outgoing_files` WHERE `outgoing_at`= "' .$oldest_date. '")');
                        DB::statement('DELETE FROM `outgoing_files` WHERE `outgoing_at`= "' .$oldest_date. '"');
                        DB::commit();
                    }
                    catch (\Exception $e) {
                        Log::error($e);
                        DB::rollBack();
                        echo 'Tables document copy error' . PHP_EOL;
                    }
                    $oldest_date = DB::table('outgoing_files')->min('outgoing_at');
                    $archive_table = 'archive_outgoing_files_' . date('Y', strtotime($oldest_date));
                }
            }
        })        
        ->daily(); //->dailyAt('21:24'); //Для тестирования


        //__________________________
        //Запуск обработчика очереди
        //__________________________

        if (!$this->osProcessIsRunning('queue:work')) {
            $schedule->command('queue:work --stop-when-empty')
            ->everyMinute();
        }


        //________________________
        //Обнуление Базы данных
        //________________________

        $schedule->exec('composer start && composer seed')
        //TODO Надо добавить команду на стирание файлов
        ->dailyAt('20:34');
    




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

    /**
     * Checks whether the process is running.
     *
     * @return bool
     */
    protected function osProcessIsRunning($needle)
    {
        exec('ps aux -ww', $process_status);

        $result = array_filter($process_status, function($var) use ($needle) {
            return strpos($var, $needle);
        });

        $process_exist = !empty($result) ? true : false;
        return $process_exist;
    }
}
