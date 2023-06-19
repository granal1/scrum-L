<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Polyfill\Uuid\Uuid;


class UserRoleStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            [
                'id' => Str::uuid(),
                'user_uuid' => 'cabb4d3b-38d7-4ed0-904d-cd2797aab70a',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'admin')->value('id'),
            ],
        ]);
    }
}
