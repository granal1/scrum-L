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
                'id' => UUID::uuid_create(),
                'name' => 'низкий',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'ниже среднего',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'средний',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'выше среднего',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'высокий',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
