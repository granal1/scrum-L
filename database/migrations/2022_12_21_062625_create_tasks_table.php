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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('parent_uuid', 36)->nullable()->default(null);

            $table->foreignUuid('priority_uuid');
            $table->foreignUuid('author_uuid');
            $table->foreignUuid('responsible_uuid');

            $table->text('description');
            $table->timestamp('deadline_at');
            $table->integer('done_progress')->nullable()->default(0);
            $table->text('report')->nullable()->default(null);
            $table->integer('sort_order')->default(1);
            $table->string('comment')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tasks', function($table)
        {
            $table->foreign('priority_uuid')->references('id')->on('task_priorities')->onupdate('cascade')->ondelete('no action');
            $table->foreign('author_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('no action');
            $table->foreign('responsible_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['priority_uuid']);
            $table->dropForeign(['author_uuid']);
            $table->dropForeign(['responsible_uuid']);
        });

        Schema::dropIfExists('tasks');
    }
};
