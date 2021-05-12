<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdMessageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_message_files', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('case_id');
            $table->string('md_case_id');
            $table->string('system_file');
            $table->string('name');
            $table->string('url');
            $table->string('url_thumbnail')->nullable();
            $table->string('file_id');
            $table->string('mime_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('md_message_files');
    }
}
