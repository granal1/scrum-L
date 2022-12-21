<?php

namespace Database\Seeders\Tasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_priorities')->insert([
            [
                'uuid' => UUID::uuid_create(),
                'name' => 'самый низкий',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => UUID::uuid_create(),
                'name' => 'низкий',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => UUID::uuid_create(),
                'name' => 'средний',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => UUID::uuid_create(),
                'name' => 'высокий',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => UUID::uuid_create(),
                'name' => 'самый высокий',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
