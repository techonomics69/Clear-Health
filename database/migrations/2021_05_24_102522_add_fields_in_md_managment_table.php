<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInMdManagmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('md_managment', function (Blueprint $table) {
            $table->string('reason')->nullable()->after('case_id');
            $table->string('created_at')->nullable()->after('reason');
            $table->string('case_assignment_id')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('md_managment', function (Blueprint $table) {
            //
        });*/
    }
}
