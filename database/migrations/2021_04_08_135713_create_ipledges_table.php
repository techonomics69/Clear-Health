<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpledgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipledges', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id');
            $table->date('addon_date');
            $table->string('addon_by');
            $table->string('patient_name');
            $table->enum('patients_type', ['0','1'])->comment = "'0'='Can Not Pregnant','1'='Can Pregnant'";
            $table->string('gender')->comment = "'M'='Male','F'='Female'";
            $table->date('assigned_date');
            $table->string('assigned_by');
            $table->string('notes');
            $table->string('user_case_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipledges');
    }
}
