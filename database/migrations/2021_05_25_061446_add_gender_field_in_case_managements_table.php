<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderFieldInCaseManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_managements', function (Blueprint $table) {
            $table->string('gender')->default('0')->after('user_id')->comment='0 = Not known,1 = Male,2 = Female,9 = Not applicable';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('case_managements', function (Blueprint $table) {
            //
        });*/
    }
}
