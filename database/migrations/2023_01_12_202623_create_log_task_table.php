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
            $table->id();
            $table->string('parent_uuid', 36);
            $table->string('priority_uuid', 36);
            $table->string('author_uuid', 36);
            $table->string('responsible_uuid', 36);
            $table->text('description');
            $table->timestamp('deadline_at');
            $table->integer('done_progress');
            $table->text('report');
            $table->integer('sort_order');
            $table->string('comment');
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
