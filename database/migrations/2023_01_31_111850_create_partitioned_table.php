<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Brokenice\LaravelMysqlPartition\Models\Partition;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partitioned', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('incoming_at')->nullable()->default(null);
        });

        Schema::partitionByRange('partitioned', 'YEAR(incoming_at)', [
            new Partition('2019', Partition::RANGE_TYPE, 2019),
            new Partition('2020', Partition::RANGE_TYPE, 2020),
            new Partition('2021', Partition::RANGE_TYPE, 2021),
            new Partition('2022', Partition::RANGE_TYPE, 2022),
            new Partition('2023', Partition::RANGE_TYPE, 2023),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partitioned');
    }
};
