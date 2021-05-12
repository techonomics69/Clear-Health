<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('case_id');
            $table->string('md_case_id');
            $table->text('text');
            $table->string('from');
            $table->string('channel');
            $table->string('prioritized_at');
            $table->string('prioritized_reason');
            $table->string('message_created_at');
            $table->string('case_message_id');
            $table->string('message_files_ids');
            $table->string('clinician')->nullable();
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
        Schema::dropIfExists('md_messages');
    }
}
