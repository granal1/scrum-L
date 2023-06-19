<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\Tasks\TaskFactory;
use Database\Seeders\Roles\RoleSeeder;
use Database\Seeders\Tasks\TaskPeriodSeeder;
use Database\Seeders\Tasks\TaskPrioritySeeder;
use Database\Seeders\Users\UserStatusSeeder;
use Database\Seeders\Users\UserRoleSeeder;
use Database\Seeders\Users\UserRoleStartSeeder;
use Database\Seeders\Users\UserSeeder;
use Database\Seeders\Users\UserStartSeeder;
//use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Database\Seeders\Files\FileSeeder;
use Database\Seeders\Files\OutgoingFileSeeder;
use Database\Seeders\Tasks\TaskSeeder;
use Database\Seeders\Tasks\TaskFileSeeder;

use App\Models\Documents\Document;
use App\Models\OutgoingFiles\OutgoingFile;
use App\Models\Tasks\Task;


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
            RoleSeeder::class,
            TaskPrioritySeeder::class,
            UserStartSeeder::class,
            UserRoleStartSeeder::class,
            UserStatusSeeder::class,

            //UserSeeder::class,
            //UserRoleSeeder::class,
            //FileSeeder::class,
            //OutgoingFileSeeder::class,
            //TaskSeeder::class,
            //TaskFileSeeder::class,
        ]);

       //Document::factory()->count(100)->create();
       //OutgoingFile::factory()->count(100)->create();
       //Task::factory()->count(100)->create();
    }
}
