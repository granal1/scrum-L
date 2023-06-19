<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Polyfill\Uuid\Uuid;


class UserRoleSeeder extends Seeder
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
                'user_uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'main_supervisor')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '0c91a116-6127-43d9-95bb-c09fa39fb455',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'kadr')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'b9e7a020-492e-47b3-8055-6a59a2bfbe36',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'delo')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'e75fb917-4d70-44d2-8560-c785aff50780',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'supervisor')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'supervisor')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'supervisor')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '37eb9897-568a-4af1-a0a8-244d3f697487',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'supervisor')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '997b70af-8ffd-45e1-9937-02378284d93c',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '871ccdbe-067e-45ad-9926-c723b08eaec4',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'e7474977-f7d3-4e0b-ae11-49c14f6c2c26',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'a9dbf6a6-0ecf-4445-b612-f720eebfaf4e',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '7dc4aa86-c5e2-42f5-9d09-9ac2929295f3',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '38373b78-9023-4332-9462-a191bf341666',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'b775b419-cfd2-4ae6-ad2b-a3a4e5d39343',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'a8c316e9-9d48-4547-9d4c-c91fb05540a2',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '06b66523-17a5-4d7a-b387-f0671d71b7f6',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '3d5145fe-f840-45cb-8f3f-eb9b5c5d8758',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '3eab0e12-7a14-495e-9e5a-dcfa3d37ea6c',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'dfe0c326-61c8-4c30-b50b-1ddb4c711ab8',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '6ad75659-9ee2-4bbf-920d-74815f5d46b4',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '32df05dd-f66b-4994-b127-aa77872fadea',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => '1f374bd2-2113-4945-8651-bb7268023a2b',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
            [
                'id' => Str::uuid(),
                'user_uuid' => 'a48c76ac-e787-4979-b075-7f1cdd46c16f',
                'role_uuid' => DB::table('roles')->where('name', 'like', 'employee')->value('id'),
            ],
        ]);
    }
}
