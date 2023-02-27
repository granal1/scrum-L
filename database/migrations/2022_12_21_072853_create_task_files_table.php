<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_files', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('task_uuid');
//            $table->foreignUuid('file_uuid');

            $table->string('file_uuid', 36)->nullable()->default(null);
            $table->string('outgoing_file_uuid', 36)->nullable()->default(null);
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('task_files', function($table)
        {
            $table->foreign('task_uuid')->references('id')->on('tasks')->onupdate('cascade')->ondelete('no action');
//            $table->foreign('file_uuid')->references('id')->on('files')->onupdate('cascade')->ondelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_files', function (Blueprint $table) {
//            $table->dropForeign(['file_uuid']);
            $table->dropForeign(['task_uuid']);
        });

        Schema::dropIfExists('task_files');
    }
};
