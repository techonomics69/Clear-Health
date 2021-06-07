<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('user_picture', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('case_id');
            $table->string('left_pic')->nullable();
            $table->string('right_pic')->nullable();;
            $table->string('straight_pic')->nullable();;
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
        //
    }
}
