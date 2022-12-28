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
                'id' => 'b713f92c-7794-4894-a2cb-4bd2ae52e1f7',
                'name' => 'admin',
                'alias' => 'Администратор',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '52e0d6ca-3b62-4e06-8134-64378049ca9b',
                'name' => 'guest',
                'alias' => 'Гость',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '6c5fee4a-87ec-4f35-863a-93dcfdcc16da',
                'name' => 'kadr',
                'alias' => 'Кадровик',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '75242942-9614-4591-b36f-f421803df822',
                'name' => 'delo',
                'alias' => 'Делопроизводитель',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 'eb62b24c-fb64-4982-a6fa-32da92ebd2cd',
                'name' => 'user',
                'alias' => 'Пользователь',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
