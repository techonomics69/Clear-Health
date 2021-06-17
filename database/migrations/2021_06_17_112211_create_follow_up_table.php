<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_up', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('case_id');
            $table->string('md_case_id');
            $table->string('answer');
            $table->string('left_face');
            $table->string('right_face');
            $table->string('center_face');
            $table->string('back_photo');
            $table->string('chest_photo');
            $table->string('follow_up_status');
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
        Schema::dropIfExists('follow_up');
    }
}
