<?php

namespace Database\Seeders\Tasks;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;
use App\Models\Tasks\TaskPriority;


class TaskSeeder extends Seeder
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
            DB::table('tasks')->insert($this->getData());
        }

    }

    public function getData()
    {
        return [
            'id' => fake()->uuid(),
            'priority_uuid' => TaskPriority::inRandomOrder()->first()->id,
            'author_uuid' => User::inRandomOrder()->first()->id,
            'responsible_uuid' => User::inRandomOrder()->first()->id,
            'description' => 'Это резолюция к документу.',
            'deadline_at' => now()->addMinutes(5),
            'done_progress' => '100',
            'report' => 'Исполнено',
            'created_at' => now(),
            'executed_at' => now()->addMinutes(1),
        ];
    }
}
