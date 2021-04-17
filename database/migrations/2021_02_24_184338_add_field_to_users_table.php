<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {           
            $table->string('mobile')->after('password');            
            $table->string('address')->after('mobile');
            $table->string('state')->after('address');
            $table->string('city')->after('state');
            $table->string('zip')->after('city');
            $table->string('gender')->after('zip');
            $table->integer('role')->after('gender');
            $table->string('temp_password')->after('role');
            $table->integer('status')->after('temp_password'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           //
        });
    }
}
