<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Roles\RoleSeeder;
use Database\Seeders\Tasks\TaskPrioritySeeder;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::factory()->create([
            'uuid' => 'cabb4d3b-38d7-4ed0-904d-cd2797aab70a',
            'login' => 'admin',
            'name' => 'Василий Николаевич',
            'email' => 'admin@admin.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '1a80b3d0-89b8-40d8-8e85-cb643f022fb9',
            'login' => 'boss',
            'name' => 'Иван Иванович',
            'email' => 'boss@boss.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '0c91a116-6127-43d9-95bb-c09fa39fb455',
            'login' => 'kadr',
            'name' => 'Валентина Валентиновна',
            'email' => 'kadr@kadr.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'b9e7a020-492e-47b3-8055-6a59a2bfbe36',
            'login' => 'delo',
            'name' => 'Ольга Олеговна',
            'email' => 'delo@delo.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'e75fb917-4d70-44d2-8560-c785aff50780',
            'login' => 'o1',
            'name' => 'Анатолий Иванович',
            'email' => 'o1@o1.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '7d9a3510-5118-4cd9-ac9d-0b9fda8c3ed9',
            'login' => 'o2',
            'name' => 'Борис Иванович',
            'email' => 'o2@o2.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '9d5b1b8a-03bb-40db-b795-c98b8f898352',
            'login' => 'o3',
            'name' => 'Владимир Иванович',
            'email' => 'o3@o3.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '37eb9897-568a-4af1-a0a8-244d3f697487',
            'login' => 'o4',
            'name' => 'Геннадий Иванович',
            'email' => 'o4@o4.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '997b70af-8ffd-45e1-9937-02378284d93c',
            'login' => 'o1s1',
            'name' => 'Артем Анатольевич',
            'email' => 'o1s1@o1s1.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '871ccdbe-067e-45ad-9926-c723b08eaec4',
            'login' => 'o1s2',
            'name' => 'Богдан Анатольевич',
            'email' => 'o1s2@o1s2.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'e7474977-f7d3-4e0b-ae11-49c14f6c2c26',
            'login' => 'o1s3',
            'name' => 'Валерий Анатольевич',
            'email' => 'o1s3@o1s3.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'a9dbf6a6-0ecf-4445-b612-f720eebfaf4e',
            'login' => 'o1s4',
            'name' => 'Георгий Анатольевич',
            'email' => 'o1s4@o1s4.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '7dc4aa86-c5e2-42f5-9d09-9ac2929295f3',
            'login' => 'o2s1',
            'name' => 'Артемий Борисович',
            'email' => 'o2s1@o2s1.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '38373b78-9023-4332-9462-a191bf341666',
            'login' => 'o2s2',
            'name' => 'Бронислав Борисович',
            'email' => 'o2s2@o2s2.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'b775b419-cfd2-4ae6-ad2b-a3a4e5d39343',
            'login' => 'o2s3',
            'name' => 'Вера Борисовна',
            'email' => 'o2s3@o2s3.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'a8c316e9-9d48-4547-9d4c-c91fb05540a2',
            'login' => 'o2s4',
            'name' => 'Глеб Борисович',
            'email' => 'o2s4@o2s4.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '06b66523-17a5-4d7a-b387-f0671d71b7f6',
            'login' => 'o3s1',
            'name' => 'Алиса Владимировна',
            'email' => 'o3s1@o3s1.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '3d5145fe-f840-45cb-8f3f-eb9b5c5d8758',
            'login' => 'o3s2',
            'name' => 'Берта Владимировна',
            'email' => 'o3s2@o3s2.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '3eab0e12-7a14-495e-9e5a-dcfa3d37ea6c',
            'login' => 'o3s3',
            'name' => 'Вениамин Владимирович',
            'email' => 'o3s3@o3s3.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'dfe0c326-61c8-4c30-b50b-1ddb4c711ab8',
            'login' => 'o3s4',
            'name' => 'Герман Владимирович',
            'email' => 'o3s4@o3s4.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '6ad75659-9ee2-4bbf-920d-74815f5d46b4',
            'login' => 'o4s1',
            'name' => 'Алла Геннадьевна',
            'email' => 'o4s1@o4s1.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '32df05dd-f66b-4994-b127-aa77872fadea',
            'login' => 'o4s2',
            'name' => 'Белла Геннадьевна',
            'email' => 'o4s2@o4s2.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => '1f374bd2-2113-4945-8651-bb7268023a2b',
            'login' => 'o4s3',
            'name' => 'Валентин Геннадьевич',
            'email' => 'o4s3@o4s3.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'a48c76ac-e787-4979-b075-7f1cdd46c16f',
            'login' => 'o4s4',
            'name' => 'Галина Геннадьевна',
            'email' => 'o4s4@o4s4.ru',
            'email_verified_at' => now(),
            'password' => '88afbf27a79133adacdb144934fd9d148542d0237b4b3ed5a49a9a4927d6bc26', // password
        ]);
        \App\Models\User::factory()->create([
            'uuid' => 'f5900f0c-ef8f-4862-925e-4957926ae7a2',
            'login' => 'guest',
            'name' => 'Гость',
            'email' => 'guest@guest.ru',
            'email_verified_at' => now(),
            'password' => 'b79465edbb2036fa2cb1f488c01747ab1b808939ac2973d275968c38b00254d2', // password
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([

            RoleSeeder::class,
            TaskPrioritySeeder::class,

        ]);
    }
}
