<?php

namespace Database\Seeders\Roles;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => UUID::uuid_create(),
                'name' => 'admin',
                'alias' => 'Администратор',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'guest',
                'alias' => 'Гость',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'kadr',
                'alias' => 'Кадровик',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'delo',
                'alias' => 'Делопроизводитель',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => UUID::uuid_create(),
                'name' => 'user',
                'alias' => 'Пользователь',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
