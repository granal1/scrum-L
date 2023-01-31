<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
use Brokenice\LaravelMysqlPartition\Schema\Schema;
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
            $table->uuid('id');
            $table->date('incoming_at');
            $table->primary(['id','incoming_at']);
        });

        Schema::partitionByList('partitioned', 'YEAR(incoming_at)', [
            new Partition('y2019', Partition::LIST_TYPE, [2019]),
            new Partition('y2020', Partition::LIST_TYPE, [2020]),
            new Partition('y2021', Partition::LIST_TYPE, [2021]),
            new Partition('y2022', Partition::LIST_TYPE, [2022]),
            new Partition('y2023', Partition::LIST_TYPE, [2023]),
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
