<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionMedicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_medication', function (Blueprint $table) {
            $table->id();
            $table->integer('case_prescription_id')->nullable();
            $table->string('dosespot_medication_id')->nullable();
            $table->string('dispense_unit_id')->nullable();
            $table->string('dose_form')->nullable();
            $table->string('route')->nullable();
            $table->string('strength')->nullable();
            $table->string('generic_product_name')->nullable();
            $table->string('lexi_gen_product_id')->nullable();
            $table->string('lexi_drug_syn_id')->nullable();
            $table->string('lexi_synonym_type_id')->nullable();
            $table->string('lexi_gen_drug_id')->nullable();
            $table->string('rx_cui')->nullable();
            $table->string('otc')->nullable();
            $table->string('ndc')->nullable();
            $table->string('schedule')->nullable();
            $table->string('display_name')->nullable();
            $table->string('monograph_path')->nullable();
            $table->string('drug_classification')->nullable();
            $table->string('state_schedules')->nullable();
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
        Schema::dropIfExists('prescription_medication');
    }
}
