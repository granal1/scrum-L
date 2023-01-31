<?php

use Brokenice\LaravelMysqlPartition\Models\Partition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
use Brokenice\LaravelMysqlPartition\Schema\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {

            $table->uuid('id');
            $table->date('incoming_at');
            $table->primary(['id', 'incoming_at']);


            $table->string('incoming_number', 255)->nullable()->default(null);
            $table->string('incoming_author', 255)->nullable()->default(null);
            $table->string('number', 255)->nullable()->default(null);
            $table->date('date')->nullable()->default(null);
            $table->text('short_description')->nullable()->default(null);
            $table->string('document_and_application_sheets', 6)->nullable()->default(null);
            $table->text('executed_result')->nullable()->default(null);
            $table->date('executed_at')->nullable()->default(null);
            $table->string('file_mark')->nullable()->default(null);
            $table->string('path', 255);
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->default(1);
            $table->longText('content')->fullText()->nullable()->default(null);
            $table->string('archive_path', 255)->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            //$table->foreignUuid('author_uuid');
        });

//        Schema::table('files', function($table)
//        {
//            $table->foreign('author_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('no action');
//        });

        Schema::partitionByList('files', 'YEAR(incoming_at)', [
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
        Schema::table('files', function (Blueprint $table) {
            //$table->dropForeign(['author_uuid']);
            $table->dropFullText('content');
        });

        Schema::dropIfExists('files');
    }
};
