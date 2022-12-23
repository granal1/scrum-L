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
        Schema::create('task_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('priority_uuid');
            $table->foreignUuid('user_uuid');
            $table->foreignUuid('responsible_uuid');
            $table->foreignUuid('task_uuid');

            $table->string('parent_uuid', 36)->nullable()->default(null);

            $table->integer('done_progress')->nullable()->default(0);
            $table->timestamp('deadline_at');
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();

            Schema::table('task_histories', function($table)
            {
                $table->foreign('priority_uuid')->references('id')->on('task_priorities')->onupdate('cascade')->ondelete('cascade');
                $table->foreign('user_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('cascade');
                $table->foreign('responsible_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('cascade');
                $table->foreign('task_uuid')->references('id')->on('tasks')->onupdate('cascade')->ondelete('cascade');

            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_histories', function (Blueprint $table) {
            $table->dropForeign(['priority_uuid']);
            $table->dropForeign(['user_uuid']);
            $table->dropForeign(['responsible_uuid']);
            $table->dropForeign(['task_uuid']);
        });

        Schema::dropIfExists('task_histories');
    }
};
