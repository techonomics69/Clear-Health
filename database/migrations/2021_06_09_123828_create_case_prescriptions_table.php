<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('dosespot_prescription_id')->nullable();
            $table->string('dosespot_prescription_sync_status')->nullable();
            $table->string('dosespot_confirmation_status')->nullable();
            $table->string('dosespot_confirmation_status_details')->nullable();
            $table->integer('refills')->nullable();
            $table->string('quantity')->nullable();
            $table->integer('days_supply')->nullable();
            $table->string('no_substitutions')->nullable();
            $table->string('pharmacy_notes')->nullable();
            $table->string('directions')->nullable();
            $table->string('dispense_unit_id')->nullable();
            $table->string('preferred_pharmacy_id')->nullable();
            $table->string('partner_medication')->nullable();
            $table->string('dispense_unit_id')->nullable();
            $table->string('preferred_pharmacy_id')->nullable();
            $table->string('prescription_medication_id')->nullable();
            $table->string('prescription_compound_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('case_id')->nullable();
            $table->string('system_case_id')->nullable();
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
        Schema::dropIfExists('case_prescriptions');
    }
}
