<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsInBirthcontrol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('birthcontrol', function (Blueprint $table) {
            $table->text('answer1')->change();
            $table->text('answer2')->change();
            $table->text('answer3')->change();
            $table->text('answer4')->change();
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
