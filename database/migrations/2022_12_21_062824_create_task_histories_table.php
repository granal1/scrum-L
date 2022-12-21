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
            $table->foreignId('priority_uuid')
                ->constrained('task_priorities', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('parent_uuid')
                ->constrained('tasks', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_uuid')
                ->constrained('users', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('responsible_uuid')
                ->constrained('users', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('done_progress')->nullable()->default(0);
            $table->timestamp('deadline_at');
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
        Schema::table('task_histories', function (Blueprint $table) {
            $table->dropForeign(['priority_uuid']);
            $table->dropForeign(['parent_uuid']);
            $table->dropForeign(['user_uuid']);
            $table->dropForeign(['responsible_uuid']);
        });

        Schema::dropIfExists('task_histories');
    }
};
