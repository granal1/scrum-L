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
    DROP PROCEDURE IF EXISTS archive_outgoing_files;
    
    CREATE DEFINER=`root`@`localhost` PROCEDURE `archive_outgoing_files`()
        MODIFIES SQL DATA
        COMMENT 'процедура архивирования'
    BEGIN

    search: LOOP

        SET @keydate := DATE(CONCAT(YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)), "-01-01"));
        SET @min := (SELECT MIN(`outgoing_at`) FROM outgoing_files);
        SET @archive_table := CONCAT('archive_outgoing_files_', YEAR(@min));

        IF @min < @keydate THEN
        call create_archive_table(@archive_table, 'outgoing_files');

        SET @sql = CONCAT("INSERT LOW_PRIORITY INTO " , @archive_table , " (SELECT * FROM `outgoing_files` WHERE `outgoing_at`= '", @min, "')");
        PREPARE stmt FROM @sql;

        START TRANSACTION;
            EXECUTE stmt;
            DELETE FROM `outgoing_files` WHERE `outgoing_at`= @min;
        COMMIT;

        DEALLOCATE PREPARE stmt;

        ELSE
        /* Выход из цикла поиска старых записей */
        LEAVE search;
        END IF;

    END LOOP search;
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
        $sql = "DROP PROCEDURE IF EXISTS archive_outgoing_files";
        DB::connection()->getPdo()->exec($sql);
    }
};
