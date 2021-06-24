<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpledgeAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipledge_agreement', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('case_id');
            $table->string('md_case_id');
            $table->string('patient_name')->nullable();
            $table->longtext('answer')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('patients_signature')->nullable();
            $table->date('patients_signature_date');
            $table->string('guardians_signature')->nullable();
            $table->date('guardians_signature_date');
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
        Schema::dropIfExists('ipledge_agreement');
    }
}
