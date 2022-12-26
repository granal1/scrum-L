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
        Schema::create('user_role', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_uuid');
            $table->foreignUuid('role_uuid');

            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('user_role', function($table)
        {
            $table->foreign('user_uuid')->references('id')->on('users')->onupdate('cascade')->ondelete('cascade');
            $table->foreign('role_uuid')->references('id')->on('roles')->onupdate('cascade')->ondelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_role', function (Blueprint $table) {
            $table->dropForeign(['user_uuid']);
            $table->dropForeign(['role_uuid']);
        });

        Schema::dropIfExists('user_role');
    }
};
