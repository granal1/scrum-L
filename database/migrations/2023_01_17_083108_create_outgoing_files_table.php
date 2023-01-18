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
        Schema::create('outgoing_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('outgoing_at')->nullable()->default(null);
            $table->string('outgoing_number', 255)->nullable()->default(null);
            $table->string('destination', 255)->nullable()->default(null);
            $table->string('number_of_source_document', 255)->nullable()->default(null);
            $table->date('date_of_source_document')->nullable()->default(null);
            $table->text('short_description')->nullable()->default(null);
            $table->string('document_and_application_sheets', 6)->nullable()->default(null);
            $table->string('file_mark')->nullable()->default(null);
            $table->string('path', 255);
            $table->string('comment')->nullable()->default(null);
            $table->integer('sort_order')->default(1);
            $table->longText('content')->fullText()->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignUuid('author_uuid');
        });

        Schema::table('outgoing_files', function($table)
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
        Schema::table('outgoing_files', function (Blueprint $table) {
            $table->dropForeign(['author_uuid']);
            $table->dropFullText('content');
        });

        Schema::dropIfExists('outgoing_files');
    }
};
