<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\Tasks\TaskFactory;
use Database\Seeders\Roles\RoleSeeder;
use Database\Seeders\Tasks\TaskPrioritySeeder;
use Database\Seeders\Users\UserRoleSeeder;
use Database\Seeders\Users\UserSeeder;
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

        //\App\Models\Tasks\Task::factory(50)->create();

        $this->call([

            RoleSeeder::class,
            TaskPrioritySeeder::class,
            UserSeeder::class,
        ]);
    }
}
