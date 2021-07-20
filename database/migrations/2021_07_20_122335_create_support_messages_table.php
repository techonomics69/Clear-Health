<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('case_id');
            $table->string('md_case_id');
            $table->text('text')->nullable();
            $table->string('from')->nullable();
            $table->string('channel')->nullable();
            $table->string('prioritized_at')->nullable();
            $table->string('prioritized_reason')->nullable();
            $table->string('read_at')->nullable();
            $table->string('message_created_at')->nullable();
            $table->string('case_message_id')->nullable();
            $table->string('message_files_ids')->nullable();
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
        Schema::dropIfExists('support_messages');
    }
}
