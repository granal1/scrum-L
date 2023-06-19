<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class UserStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 'cabb4d3b-38d7-4ed0-904d-cd2797aab70a',
                'superior_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'name' => 'Админ',
                'email' => 'admin@admin.ru',
                'phone' => '999-854-99-74',
                'position' => 'Администратор',
                'birthday_at' => '1980-01-10',
                'email_verified_at' => now(),
                'password' => '$2y$10$wCv1t74ruEq.ijydsd4zYuJZSg3LnWoNmShVfdy0JicSYnDLUK5Ae', // password
            ]
       ]);

    }
}
