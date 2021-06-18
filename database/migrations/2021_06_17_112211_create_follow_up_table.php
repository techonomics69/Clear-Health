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
            $table->string('md_case_id')->nullable();
            $table->longText('answer')->nullable();
            $table->string('left_face')->nullable();
            $table->string('right_face')->nullable();
            $table->string('center_face')->nullable();
            $table->string('back_photo')->nullable();
            $table->string('chest_photo')->nullable();
            $table->string('chest_photo')->nullable();
            $table->string('follow_up_no')->nullable();
            $table->text('pregnancy_test')->nullable();
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
