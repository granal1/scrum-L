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
                    `id`,
                    `task_uuid`,
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
                VALUES(
                    UUID(),
                    NEW.id,
                    NEW.parent_uuid,
                    NEW.priority_uuid,
                    NEW.author_uuid,
                    NEW.responsible_uuid,
                    NEW.description,
                    NEW.deadline_at,
                    NEW.done_progress,
                    NEW.report,
                    NEW.sort_order,
                    NEW.comment,
                    NEW.created_at,
                    NEW.updated_at,
                    NEW.deleted_at
                );
                END'
        );

        DB::unprepared('
        CREATE TRIGGER tr_Update_Task AFTER UPDATE ON `tasks` FOR EACH ROW
            BEGIN
                INSERT INTO `log_task` (
                    `id`,
                    `task_uuid`,
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
                VALUES(
                    UUID(),
                    NEW.id,
                    NEW.parent_uuid,
                    NEW.priority_uuid,
                    NEW.author_uuid,
                    NEW.responsible_uuid,
                    NEW.description,
                    NEW.deadline_at,
                    NEW.done_progress,
                    NEW.report,
                    NEW.sort_order,
                    NEW.comment,
                    NEW.created_at,
                    NEW.updated_at,
                    NEW.deleted_at
                );
            END');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_Insert_Task`');
        DB::unprepared('DROP TRIGGER `tr_Update_Task`');
    }
};
