<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaskTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER tr_Insert_Task AFTER INSERT ON `tasks` FOR EACH ROW
                BEGIN
                   INSERT INTO `log_task` (
                        `parent_uuid`,
                        `priority_uuid`,
                        `author_uuid`,
                        `responsible_uuid`,
                        `description`,
                        `deadline_at`,
                        `done_progress`,
                        `report`,
                        `sort_order`,
                        `comment`,
                        `created_at`,
                        `updated_at`,
                        `deleted_at`
                   ) 
                   SELECT 
                        `parent_uuid`,
                        `priority_uuid`,
                        `author_uuid`,
                        `responsible_uuid`,
                        `description`,
                        `deadline_at`,
                        `done_progress`,
                        `report`,
                        `sort_order`,
                        `comment`,
                        `created_at`,
                        `updated_at`,
                        `deleted_at`
                   FROM `tasks` 
                   WHERE `updated_at` = (
                        SELECT MAX(updated_at) 
                        FROM `tasks`
                    );
                END');

        DB::unprepared('
        CREATE TRIGGER tr_Update_Task AFTER UPDATE ON `tasks` FOR EACH ROW
                BEGIN
                   INSERT INTO `log_task` (
                        `parent_uuid`,
                        `priority_uuid`,
                        `author_uuid`,
                        `responsible_uuid`,
                        `description`,
                        `deadline_at`,
                        `done_progress`,
                        `report`,
                        `sort_order`,
                        `comment`,
                        `created_at`,
                        `updated_at`,
                        `deleted_at`
                   ) 
                   SELECT 
                        `parent_uuid`,
                        `priority_uuid`,
                        `author_uuid`,
                        `responsible_uuid`,
                        `description`,
                        `deadline_at`,
                        `done_progress`,
                        `report`,
                        `sort_order`,
                        `comment`,
                        `created_at`,
                        `updated_at`,
                        `deleted_at`
                   FROM `tasks` 
                   WHERE `updated_at` = (
                        SELECT MAX(updated_at) 
                        FROM `tasks`
                    );
                END');
    }

//    INSERT INTO `log_task` (`id`, `name`, `alias`) VALUES (UUID(), "vasya", "vasya");
//    INSERT INTO frequencies_audit select * from frequencies where freqId = NEW.freqId;
//    SELECT * FROM `tasks` WHERE `updated_at` = (SELECT MAX(updated_at) FROM `tasks`);

    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_Insert_Task`');
        DB::unprepared('DROP TRIGGER `tr_Update_Task`');
    }
};
