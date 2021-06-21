<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowUpNoPragnanctTestFieldInFollowupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('follow_up', function (Blueprint $table) {
             $table->string('follow_up_no')->nullable()->after('chest_photo');
             $table->text('pregnancy_test')->nullable()->after('follow_up_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('follow_up', function (Blueprint $table) {
            //
        });
    }
}
