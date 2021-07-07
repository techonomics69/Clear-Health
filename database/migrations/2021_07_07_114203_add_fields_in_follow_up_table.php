<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInFollowUpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('follow_up', function (Blueprint $table) {
            $table->string('left_face_file_id')->nullable()->after('left_face');
            $table->string('right_face_file_id')->nullable()->after('right_face');
            $table->string('center_face_file_id')->nullable()->after('center_face');
            $table->string('back_photo_file_id')->nullable()->after('back_photo');
            $table->string('chest_photo_file_id')->nullable()->after('chest_photo');
            $table->string('pregnancy_test_file_id')->nullable()->after('pregnancy_test');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('follow_up', function (Blueprint $table) {
            //
        });*/
    }
}
