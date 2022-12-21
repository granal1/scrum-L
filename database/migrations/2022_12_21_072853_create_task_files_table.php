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
            $table->uuid()->primary();
            $table->foreignId('task_uuid')
                ->constrained('tasks', 'uuid')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('file_uuid')
                ->constrained('files', 'uuid')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign(['file_uuid']);
            $table->dropForeign(['task_uuid']);
        });

        Schema::dropIfExists('task_files');
    }
};
