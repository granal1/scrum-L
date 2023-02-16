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
    DROP PROCEDURE IF EXISTS create_archive_table;
    CREATE DEFINER=`root`@`localhost` PROCEDURE `create_archive_table`(IN `arc_table` VARCHAR(30), IN `work_table` VARCHAR(30))
        COMMENT 'создание архивной таблицы'
    BEGIN

        SET @sql = CONCAT('CREATE TABLE IF NOT EXISTS ', arc_table , ' LIKE ', work_table);
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

    END
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
        $sql = "DROP PROCEDURE IF EXISTS create_archive_table";
        DB::connection()->getPdo()->exec($sql);
    }
};
