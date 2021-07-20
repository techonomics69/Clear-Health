<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportMessagesFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_messages_files', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('case_id');
            $table->string('md_case_id');
            $table->string('system_file')->nullable();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('url_thumbnail')->nullable();
            $table->string('file_id')->nullable();
            $table->string('mime_type')->nullable();            
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
        Schema::dropIfExists('support_messages_files');
    }
}
