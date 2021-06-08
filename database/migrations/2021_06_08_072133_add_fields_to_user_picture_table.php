<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUserPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_picture', function (Blueprint $table) {
            $table->MEDIUMTEXT('left_pic')->change();
            $table->MEDIUMTEXT('right_pic')->change();
            $table->MEDIUMTEXT('straight_pic')->change();
            $table->MEDIUMTEXT('other_pic')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_picture', function (Blueprint $table) {
            //
        });
    }
}
