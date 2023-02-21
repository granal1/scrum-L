<?php

namespace Database\Seeders\Tasks;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;
use App\Models\Tasks\TaskPriority;
use App\Models\Documents\Document;
use App\Models\Tasks\TaskFile;
use App\Models\Tasks\Task;


class TaskFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x < 1000; $x++)
        {
            DB::table('task_files')->insert($this->getData());
        }

    }

    public function getData()
    {
        return [
            'id' => fake()->uuid(),
            'file_uuid' => Document::select('id')->whereNotIn('id', TaskFile::select('file_uuid'))->first()->id,
            'task_uuid' => Task::select('id')->whereNotIn('id', TaskFile::select('task_uuid'))->first()->id,
            'created_at' => now(),
        ];
    }
}
