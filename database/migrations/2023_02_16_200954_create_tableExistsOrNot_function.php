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
    DROP FUNCTION IF EXISTS tableExistsOrNot;

    CREATE DEFINER=`root`@`localhost` FUNCTION `tableExistsOrNot`(`_tableName` VARCHAR(255)) RETURNS tinyint(1)
        READS SQL DATA
        COMMENT 'Проверка существования таблицы'
    IF
        (SELECT COUNT(*)FROM information_schema.tables WHERE table_schema =  DATABASE() AND table_name = _tableName)= 1
    THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF
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
        $sql = "DROP PROCEDURE IF EXISTS tableExistsOrNot";
        DB::connection()->getPdo()->exec($sql);
    }
};
