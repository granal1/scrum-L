<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

$sql = <<<SQL
    DROP EVENT IF EXISTS everynight_event;
    CREATE EVENT `everynight_event`
    ON SCHEDULE EVERY 1 DAY STARTS DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL 1 DAY), "%Y-%m-%d %H:%i:%S")
    ON COMPLETION PRESERVE
    ENABLE
    COMMENT 'ежесуточное Событие в полночь'  DO
    call nightly_service();
SQL;

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = "DROP PROCEDURE IF EXISTS everynight_event";
        DB::connection()->getPdo()->exec($sql);
    }
};
