<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaskTrigger extends Migration
{
    public function up()
    {
//        DB::unprepared('
//        CREATE TRIGGER tr_Create_Task AFTER INSERT ON `tasks` FOR EACH ROW
//                BEGIN
//                   INSERT INTO `roles` (`id`, `name`, `alias`) VALUES (UUID(), "vasya", "vasya");
//                END');
    }

    public function down()
    {
//        DB::unprepared('DROP TRIGGER `tr_Create_Task`');
    }
};
