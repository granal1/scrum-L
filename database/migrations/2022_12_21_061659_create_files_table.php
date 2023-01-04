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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('incoming_at')->nullable()->default(null);
            $table->string('incoming_number', 255)->nullable()->default(null);
            $table->string('incoming_author', 255)->nullable()->default(null);
            $table->string('number', 255)->nullable()->default(null);
            $table->date('date')->nullable()->default(null);
            $table->text('short_description')->nullable()->default(null);
            $table->string('document_and_application_sheets', 6)->nullable()->default(null);
            $table->text('task_description')->nullable()->default(null);
            $table->string('executor', 255)->nullable()->default(null);
            $table->date('deadline_at')->nullable()->default(null);
            $table->text('executed_result')->nullable()->default(null);
            $table->date('executed_at')->nullable()->default(null);
            $table->string('file_mark')->nullable()->default(null);
            $table->string('name', 255);
            $table->string('path', 255);
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->default(1);
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
        Schema::dropIfExists('files');
    }
};
