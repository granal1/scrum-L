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
            $table->text('description');
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignUuid('author_uuid');
        });

        Schema::table('tasks', function($table)
        {
            $table->foreign('author_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('no action');
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
            $table->dropForeign(['author_uuid']);
        });

        Schema::dropIfExists('tasks');
    }
};
