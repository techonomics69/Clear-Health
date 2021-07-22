<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_treatments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('case_id');
            $table->string('md_case_id')->nullable();
            $table->longtext('answer')->nullable();
            $table->string('order_id')->nullable();
            $table->string('product_type')->nullable();
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
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('change_treatments');
    }
}
