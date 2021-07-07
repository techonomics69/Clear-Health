<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldeTypeInIpledgeAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipledge_agreement', function (Blueprint $table) {
            $table->date('patients_signature_date')->nullable()->change();
            $table->date('guardians_signature_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('ipledge_agreement', function (Blueprint $table) {
            //
        });*/
    }
}
