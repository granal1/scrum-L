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
    DROP PROCEDURE IF EXISTS nightly_service;
    CREATE DEFINER=`root`@`localhost` PROCEDURE `nightly_service`()
        MODIFIES SQL DATA
        COMMENT 'Ежесуточное обслуживание'
    BEGIN

        call archive_files();
        call archive_outgoing_files();

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
        $sql = "DROP PROCEDURE IF EXISTS nightly_service";
        DB::connection()->getPdo()->exec($sql);
    }
};
