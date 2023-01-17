<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_status')->insert([
            [
                'id' => '34ac2092-2a1e-4920-9639-4e0d774aef6b',
                'name' => 'Работает',
                'alias' => 'working',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '6edb4753-9fbe-45d9-9217-ea8c946f4879',
                'name' => 'Уволен',
                'alias' => 'fired',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '29f8b5fa-4035-48d6-8682-ef82c4062493',
                'name' => 'На больничном',
                'alias' => 'on_sick_leave',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 'e4bd0e30-f978-4af7-a38e-7cfddd491e8e',
                'name' => 'Заблокирован',
                'alias' => 'blocked',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '7dddc9a4-7393-49dc-a600-89543a9fd4d8',
                'name' => 'В отпуске',
                'alias' => 'on_holiday',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

    }
}
