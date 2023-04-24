<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\Tasks\TaskFactory;
use Database\Seeders\Roles\RoleSeeder;
use Database\Seeders\Tasks\TaskPeriodSeeder;
use Database\Seeders\Tasks\TaskPrioritySeeder;
use Database\Seeders\Users\UserStatusSeeder;
use Database\Seeders\Users\UserRoleSeeder;
use Database\Seeders\Users\UserSeeder;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Database\Seeders\Files\FileSeeder;
use Database\Seeders\Files\OutgoingFileSeeder;
use Database\Seeders\Tasks\TaskSeeder;
use Database\Seeders\Tasks\TaskFileSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
//            RoleSeeder::class,
//            TaskPrioritySeeder::class,
//            UserSeeder::class,
//            UserRoleSeeder::class,
//            UserStatusSeeder::class,

            FileSeeder::class,
            OutgoingFileSeeder::class,
            TaskSeeder::class,
            TaskFileSeeder::class,
        ]);

       // \App\Models\Documents\Document::factory(1000)->create();
    }
}
