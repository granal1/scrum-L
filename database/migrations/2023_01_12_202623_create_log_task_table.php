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
        Schema::create('log_task', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('task_uuid', 36);
            $table->string('parent_uuid', 36)->nullable()->default(null);
            $table->string('priority_uuid', 36)->nullable()->default(null);
            $table->string('author_uuid', 36);
            $table->string('responsible_uuid', 36);
            $table->text('description');
            $table->timestamp('deadline_at');
            $table->integer('done_progress')->nullable()->default(null);
            $table->text('report')->nullable()->default(null);
            $table->integer('sort_order');
            $table->string('comment')->nullable()->default(null);
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
        Schema::dropIfExists('log_task');
    }
};
