<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBirthcontrolAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birthcontrol_answer', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('case_id')->nullable();
            $table->string('md_case_id')->nullable();
            $table->string('answer')->nullable();
            $table->string('left_face')->nullable();
            $table->string('left_face_file_id')->nullable();
            $table->string('right_face')->nullable();
            $table->string('right_face_file_id')->nullable();
            $table->string('center_face')->nullable();
            $table->string('center_face_file_id')->nullable();
            $table->string('back_photo')->nullable();
            $table->string('back_photo_file_id')->nullable();
            $table->string('chest_photo')->nullable();
            $table->string('chest_photo_file_id')->nullable();
            $table->string('last_step')->nullable();
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
        Schema::dropIfExists('birthcontrol_answer');
    }
}
