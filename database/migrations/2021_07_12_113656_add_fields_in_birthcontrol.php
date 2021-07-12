<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInBirthcontrol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('birthcontrol', function (Blueprint $table) {
            $table->string('answer1')->nullable()->after('user_id');
            $table->string('answer2')->nullable()->after('answer1');
            $table->string('answer3')->nullable()->after('answer2');
            $table->string('answer4')->nullable()->after('answer3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('birthcontrol', function (Blueprint $table) {
            //
        });
    }
}
