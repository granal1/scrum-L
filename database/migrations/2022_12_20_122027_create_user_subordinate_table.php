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
        Schema::create('user_subordinate', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('superior_uuid')
                ->constrained('users', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_uuid')
                ->constrained('users', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::table('user_subordinate', function (Blueprint $table) {
            $table->dropForeign(['superior_uuid']);
            $table->dropForeign(['user_uuid']);
        });

        Schema::dropIfExists('user_subordinate');
    }
};
