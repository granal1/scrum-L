<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StartParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsing:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start queue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Очередь запустилась');
        //exec('php artisan queue:work &');
        return Command::SUCCESS;
    }
}
