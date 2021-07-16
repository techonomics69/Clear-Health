<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielsAndChangeFieldsInMdManagmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('md_managment', function (Blueprint $table) {
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('title')->after('last_name')->nullable(); 
            $table->string('credentials')->after('title')->nullable();
            $table->string('education')->after('credentials')->nullable();
            $table->string('expertise')->comment('specialty')->change();
            $table->string('license_number')->after('education');
            $table->string('states_licensed_to_practice')->comment('license_number');
            $table->string('language_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /* Schema::table('md_managment', function (Blueprint $table) {
            //
        });*/
    }
}
