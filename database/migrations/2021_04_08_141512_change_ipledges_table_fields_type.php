<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIpledgesTableFieldsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('ipledges', function (Blueprint $table) {
            $table->date('addon_date')->nullable()->change();
            $table->string('addon_by')->nullable()->change();
            $table->string('patient_name')->nullable()->change();
            $table->string('gender')->nullable()->change()->comment = "'M'='Male','F'='Female'";
            $table->date('assigned_date')->change()->nullable();
            $table->string('assigned_by')->change()->nullable();
            $table->string('notes')->change()->nullable();
            $table->string('user_case_id')->change()->nullable();
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
